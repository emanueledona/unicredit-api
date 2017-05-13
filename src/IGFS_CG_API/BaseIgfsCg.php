<?php
namespace emanueledona\unicreditApi\IGFS_CG_API;

use emanueledona\unicreditApi\IGFS_CG_API\IgfsUtils;
use emanueledona\unicreditApi\IGFS_CG_API\IgfsMissingParException;
use emanueledona\unicreditApi\IGFS_CG_API\IgfsException;
use emanueledona\unicreditApi\IGFS_CG_API\ReadWriteException;
use emanueledona\unicreditApi\IGFS_CG_API\ConnectionException;
use emanueledona\unicreditApi\IGFS_CG_API\IOException;

abstract class BaseIgfsCg {
	
	private static $version = "2.3.7";

	public $kSig; // chiave signature

	public $serverURL = NULL;
	public $serverURLs = NULL;
	public $cTimeout = 5000;
	public $timeout = 30000;
	
	public $proxy = NULL;

	public $httpAuthUser = NULL;
	public $httpAuthPass = NULL;

	public $tid = NULL;

	public $rc = NULL;
	public $error = NULL;
	public $errorDesc = NULL;

	protected $fields2Reset = false;
	protected $checkCert = true;

	public $installPath = NULL;
    
	function __construct() {
		$this->resetFields();
	}
   
	protected function resetFields() {
		$this->tid = NULL;
		$this->rc = NULL;
		$this->error = false;
		$this->errorDesc = NULL;
		$this->fields2Reset = false;
	}
	
	protected function checkFields() {
		if ($this->serverURL == NULL || "" == $this->serverURL)
			if ($this->serverURLs == NULL || sizeof($this->serverURLs) == 0)
				throw new IgfsMissingParException("Missing serverURL");
		if ($this->kSig == NULL || "" == $this->kSig)
			throw new IgfsMissingParException("Missing kSig");
		if ($this->tid == NULL || "" == $this->tid)
			throw new IgfsMissingParException("Missing tid");
		return true;
	}

	/**
	 * Disable Certification Check on SSL HandShake
	 */
	public function disableCheckSSLCert() {
		$this->checkCert = false;
	}

	protected function getServerUrl($surl) {
		if (!IgfsUtils::endsWith($surl, "/")) {
			$surl .= "/";
		}
		return $surl . $this->getServicePort();
	}
	
	abstract protected function getServicePort();
	
	public static function getVersion() {
		return BaseIgfsCg::$version;
	}

	protected function replaceRequest($request, $find, $value) {
		if ($value == NULL)
			$value = "";
		return str_replace($find, $value, $request);
	}
	
	protected function buildRequest() {
		$request = $this->readFromJARFile($this->getFileName());
		$request = $this->replaceRequest($request, "{apiVersion}", $this->getVersion());
		$request = $this->replaceRequest($request, "{tid}", $this->tid);
		return $request;
	}
	
	abstract protected function getFileName();
	
	protected function readFromJARFile($filename) {
		if ($this->installPath != NULL) {
			if (substr($this->installPath, -1) == "/") {
				return file_get_contents($this->installPath . $filename);
			} else {
				return file_get_contents($this->installPath . "/" . $filename);
			}
		} else {
			return file_get_contents($filename);
		}
	}
 
 	abstract protected function setRequestSignature($request);

	abstract protected function getResponseSignature($response);

	protected static $SOAP_ENVELOPE = "soap:Envelope";
	protected static $SOAP_BODY = "soap:Body";
	protected static $RESPONSE = "response";
	
	protected function parseResponse($response) {
			
			$response = str_replace("<soap:", "<", $response);
			$response = str_replace("</soap:", "</", $response);
			$dom = new \SimpleXMLElement($response, LIBXML_NOERROR, false);
			if (count($dom)==0) {
				return;
			}

			$tmp = str_replace("<Body>", "", $dom->Body->asXML());
			$tmp = str_replace("</Body>", "", $tmp);
			$dom = new \SimpleXMLElement($tmp, LIBXML_NOERROR, false);
			if (count($dom)==0) {
				return;
			}

			$root = BaseIgfsCg::$RESPONSE;
			if (count($dom->$root)==0) {
				return;
			}

			$fields = IgfsUtils::parseResponseFields($dom->$root);
			if (isset($fields)) {
				$fields[BaseIgfsCg::$RESPONSE] = $response;
			}
			
			return $fields;
			
	}

	protected function parseResponseMap($response) {
		$this->tid = IgfsUtils::getValue($response, "tid");
		$this->rc = IgfsUtils::getValue($response, "rc");
		if (IgfsUtils::getValue($response, "error") == NULL) {
			$this->error = true;
		} else {
			$this->error = ("true" == IgfsUtils::getValue($response, "error"));
		}
		$this->errorDesc = IgfsUtils::getValue($response, "errorDesc");
	}

	protected function checkResponseSignature($response) {
		if (IgfsUtils::getValue($response, "signature") == NULL)
			return false;
		$signature = IgfsUtils::getValue($response, "signature");
		if ($signature != $this->getResponseSignature($response))
			return false;
		return true;
	}

	protected function process($url) {
		// Creiamo la richiesta
		$request = $this->buildRequest();
		if ($request == NULL) {
			throw new IgfsException("IGFS Request is null");
		}
		// Impostiamo la signature
		$request = $this->setRequestSignature($request);
		// Inviamo la richiesta e leggiamo la risposta
		try {
			// System.out.println(request);
			$response = $this->post($url, $request);
			// System.out.println(response);
		} catch (IOException $e) {
			throw $e;
		}		
		if ($response == NULL) {
			throw new IgfsException("IGFS Response is null");
		}
		// Parsifichiamo l'XML
		return $this->parseResponse($response);
	}
	
	private function post($url, $request) {

		//open connection 
		$ch = curl_init();

		$httpHeader = array("Content-Type: text/xml; charset=\"utf-8\"");

		//set the url, number of POST vars, POST data 
		curl_setopt($ch,CURLOPT_HTTPHEADER,$httpHeader); 		
		curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$this->cTimeout/1000);
		curl_setopt($ch,CURLOPT_TIMEOUT,$this->timeout/1000);
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_POST,1);
		curl_setopt($ch,CURLOPT_POSTFIELDS,$request);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
		if ($this->proxy != NULL) {
			curl_setopt($ch,CURLOPT_HTTPPROXYTUNNEL, true);
			curl_setopt($ch,CURLOPT_PROXY, $this->proxy);		
		}
		if (!$this->checkCert) {
			curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
		}
		if ($this->httpAuthUser != NULL && $this->httpAuthPass != NULL) {
			curl_setopt($ch,CURLOPT_USERPWD,$this->httpAuthUser . ":" . $this->httpAuthPass);
		}

		// PHP <5.5.0
		defined("CURLE_OPERATION_TIMEDOUT") || define("CURLE_OPERATION_TIMEDOUT", CURLE_OPERATION_TIMEOUTED);

		//execute post 
		$result = curl_exec($ch);
		if (curl_errno($ch)) { 
			if (curl_errno($ch) == CURLE_OPERATION_TIMEDOUT) {
				throw new ReadWriteException($url, curl_error($ch));
			} else {
				throw new ConnectionException($url, curl_error($ch));
			}
        } else { 
			//close connection 
			curl_close($ch);	
        } 
		
		return $result;
	}

	public function execute() {
		try {
			$this->checkFields();

			if ($this->serverURL != null) {
				$mapResponse = $this->executeHttp($this->serverURL);
			} else {
				$i = 0;
				$sURL = $this->serverURLs[$i];
				$finished = false;
				while ( ! $finished ) {
					try {
						$mapResponse = $this->executeHttp($sURL);
						$finished = true;
					} catch (ConnectionException $e) {
						$i++;
						if ($i < sizeof($this->serverURLs) && $this->serverURLs[$i] != null) {
							$sURL = $this->serverURLs[$i];
						} else {
							throw $e;
						}
					}
				}
			}

			// Leggiamo i campi
			$this->parseResponseMap($mapResponse);
			$this->fields2Reset = true;
			if (!$this->error) {
				// Verifico la signature
				if (!$this->checkResponseSignature($mapResponse)) {
					throw new IgfsException("Invalid IGFS Response signature");
				}
				return true;
			} else {
				return false;
			}
		} catch (Exception $e) {
			$this->resetFields();
			$this->fields2Reset = true;
			$this->error = true;
			$this->errorDesc = $e->getMessage();
			if ($e instanceof IgfsMissingParException) {
				$this->rc = "IGFS_20000"; // dati mancanti
				$this->errorDesc = $e->getMessage();
			}
			if ($e instanceof ConnectionException) {
				$this->rc = "IGFS_007"; // errore di comunicazione
				$this->errorDesc = $e->getMessage();
			}
			if ($e instanceof ReadWriteException) {
				$this->rc = "IGFS_007"; // errore di comunicazione
				$this->errorDesc = $e->getMessage();
			}
			if ($this->rc == null) {
				$this->rc = "IGFS_909"; // se nessuno ha settato l'errore...
			}
			return false;
		}
	}

	private function executeHttp($url) {
		$requestMethod = "POST";
		// cTimeout;
		// timeout;
		$url = $this->getServerUrl($url);
		$contentType = $this->getContentType();

		try {
			$mapResponse = $this->process($url);
		} catch (IOException $e) {
			throw $e;
		}
		if ($mapResponse == NULL) {
			throw new IgfsException("Invalid IGFS Response");
		}

		return $mapResponse;
	}

	protected function getContentType() {
		return "text/xml; charset=\"utf-8\"";
	}

	protected function getSignature($key, $fields) {
		try {
			return IgfsUtils::getSignature($key, $fields);
		} catch (Exception $e) {
			throw new IgfsException($e);
		}
	}

	protected function getUniqueBoundaryValue() {
		return IgfsUtils::getUniqueBoundaryValue();
	}

}
?>
