<?php
namespace emanueledona\unicreditApi\IGFS_CG_API\init;

use emanueledona\unicreditApi\IGFS_CG_API\init\BaseIgfsCgInit;
use emanueledona\unicreditApi\IGFS_CG_API\init\SelectorTerminalInfo;

class IgfsCgSelector extends BaseIgfsCgInit {

	public $shopUserRef;
	public $trType = "AUTH";
	public $amount;
	public $currencyCode;
	public $langID = "IT";
	public $addInfo1;
	public $addInfo2;
	public $addInfo3;
	public $addInfo4;
	public $addInfo5;
	public $payInstrToken;

	public $termInfo;

	function __construct() {
		parent::__construct();
	}

	protected function resetFields() {
		parent::resetFields();
		$this->shopUserRef = NULL;
		$this->trType = "AUTH";
		$this->amount = NULL;
		$this->currencyCode = NULL;
		$this->langID = "IT";
		$this->addInfo1 = NULL;
		$this->addInfo2 = NULL;
		$this->addInfo3 = NULL;
		$this->addInfo4 = NULL;
		$this->addInfo5 = NULL;
		$this->payInstrToken = NULL;

		$this->termInfo = NULL;
	}

	protected function checkFields() {
		parent::checkFields();
		if ($this->trType == NULL)
			throw new IgfsMissingParException("Missing trType");
		if ($this->trType != "TOKENIZE") {
			if ($this->amount == NULL)
				throw new IgfsMissingParException("Missing amount");
			if ($this->currencyCode == NULL)
				throw new IgfsMissingParException("Missing currencyCode");
		}
		if ($this->langID == NULL)
			throw new IgfsMissingParException("Missing langID");
		if ($this->payInstrToken != NULL) {
			// Se è stato impostato il payInstrToken verifico...
			if ($this->payInstrToken == "")
				throw new IgfsMissingParException("Missing payInstrToken");
		}
			
	}

	protected function buildRequest() {
		$request = parent::buildRequest();
		if ($this->shopUserRef != NULL)
			$request = $this->replaceRequest($request, "{shopUserRef}", "<shopUserRef><![CDATA[" . $this->shopUserRef . "]]></shopUserRef>");
		else
			$request = $this->replaceRequest($request, "{shopUserRef}", "");

		$request = $this->replaceRequest($request, "{trType}", $this->trType);
		if ($this->amount != NULL)
			$request = $this->replaceRequest($request, "{amount}", "<amount><![CDATA[" . $this->amount . "]]></amount>");
		else
			$request = $this->replaceRequest($request, "{amount}", "");
		if ($this->currencyCode != NULL)
			$request = $this->replaceRequest($request, "{currencyCode}", "<currencyCode><![CDATA[" . $this->currencyCode . "]]></currencyCode>");
		else
			$request = $this->replaceRequest($request, "{currencyCode}", "");
		$request = $this->replaceRequest($request, "{langID}", $this->langID);
		
		if ($this->addInfo1 != NULL)
			$request = $this->replaceRequest($request, "{addInfo1}", "<addInfo1><![CDATA[" . $this->addInfo1 . "]]></addInfo1>");
		else
			$request = $this->replaceRequest($request, "{addInfo1}", "");
		if ($this->addInfo2 != NULL)
			$request = $this->replaceRequest($request, "{addInfo2}", "<addInfo2><![CDATA[" . $this->addInfo2 . "]]></addInfo2>");
		else
			$request = $this->replaceRequest($request, "{addInfo2}", "");
		if ($this->addInfo3 != NULL)
			$request = $this->replaceRequest($request, "{addInfo3}", "<addInfo3><![CDATA[" . $this->addInfo3 . "]]></addInfo3>");
		else
			$request = $this->replaceRequest($request, "{addInfo3}", "");
		if ($this->addInfo4 != NULL)
			$request = $this->replaceRequest($request, "{addInfo4}", "<addInfo4><![CDATA[" . $this->addInfo4 . "]]></addInfo4>");
		else
			$request = $this->replaceRequest($request, "{addInfo4}", "");
		if ($this->addInfo5 != NULL)
			$request = $this->replaceRequest($request, "{addInfo5}", "<addInfo5><![CDATA[" . $this->addInfo5 . "]]></addInfo5>");
		else
			$request = $this->replaceRequest($request, "{addInfo5}", "");
		
		if ($this->payInstrToken != NULL)
			$request = $this->replaceRequest($request, "{payInstrToken}", "<payInstrToken><![CDATA[" . $this->payInstrToken . "]]></payInstrToken>");
		else
			$request = $this->replaceRequest($request, "{payInstrToken}", "");

		return $request;
	}

	protected function setRequestSignature($request) {
		// signature dove il buffer e' cosi composto APIVERSION|TID|SHOPID|SHOPUSERREF|TRTYPE|AMOUNT|CURRENCYCODE|LANGID|UDF1|UDF2|UDF3|UDF4|UDF5|PAYINSTRTOKEN
		$fields = array(
				$this->getVersion(), // APIVERSION
				$this->tid, // TID
				$this->shopID, // SHOPID
				$this->shopUserRef, // SHOPUSERREF
				$this->trType,// TRTYPE
				$this->amount, // AMOUNT
				$this->currencyCode, // CURRENCYCODE
				$this->langID, // LANGID
				$this->addInfo1, // UDF1
				$this->addInfo2, // UDF2
				$this->addInfo3, // UDF3
				$this->addInfo4, // UDF4
				$this->addInfo5, // UDF5
				$this->payInstrToken); // PAYINSTRTOKEN
		$signature = $this->getSignature($this->kSig, // KSIGN
				$fields); 
		$request = $this->replaceRequest($request, "{signature}", $signature);
		return $request;
	}

	protected function parseResponseMap($response) {
		parent::parseResponseMap($response);
		$xml = $response[BaseIgfsCg::$RESPONSE];	

		$xml = str_replace("<soap:", "<", $xml);
		$xml = str_replace("</soap:", "</", $xml);
		$dom = new SimpleXMLElement($xml, LIBXML_NOERROR, false);
		if (count($dom)==0) {
			return;
		}

		$tmp = str_replace("<Body>", "", $dom->Body->asXML());
		$tmp = str_replace("</Body>", "", $tmp);
		$dom = new SimpleXMLElement($tmp, LIBXML_NOERROR, false);
		if (count($dom)==0) {
			return;
		}
		
		$xml_response = IgfsUtils::parseResponseFields($dom->response);
		if (isset($xml_response["termInfo"])) {
			$termInfo = array();
			foreach ($dom->response->children() as $item) {
				if ($item->getName() == "termInfo") {
				    $termInfo[] = SelectorTerminalInfo::fromXml($item->asXML());
				}
			}
			$this->termInfo = $termInfo;
		}
		
	}

	protected function getResponseSignature($response) {
		$fields = array(
				IgfsUtils::getValue($response, "tid"), // TID
				IgfsUtils::getValue($response, "shopID"), // SHOPID
				IgfsUtils::getValue($response, "rc"), // RC
				IgfsUtils::getValue($response, "errorDesc"));// ERRORDESC
		// signature dove il buffer e' cosi composto TID|SHOPID|RC|ERRORDESC|PAYMENTID|REDIRECTURL
		return $this->getSignature($this->kSig, // KSIGN
				$fields); 
	}
	
	protected function getFileName() {
		return __DIR__."/IgfsCgSelector.request";
	}

}

?>
