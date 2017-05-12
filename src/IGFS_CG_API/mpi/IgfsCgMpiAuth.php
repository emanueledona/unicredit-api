<?php
namespace emanueledona\unicreditApi\IGFS_CG_API\mpi;

use emanueledona\unicreditApi\IGFS_CG_API\mpi\BaseIgfsCgMpi;

class IgfsCgMpiAuth extends BaseIgfsCgMpi {

	public $paRes;
	public $md;

	public $authStatus;
	public $cavv;
	public $eci;

	function __construct() {
		parent::__construct();
	}

	protected function resetFields() {
		parent::resetFields();
		$this->paRes = NULL;
		$this->md = NULL;

		$this->authStatus = NULL;
		$this->cavv = NULL;
		$this->eci = NULL;
	}

	protected function checkFields() {
		parent::checkFields();

		if ($this->paRes != NULL) {
		if ($this->paRes == "")
			throw new IgfsMissingParException("Missing paRes");
		}
		if ($this->md != NULL) {
		if ($this->md == "")
			throw new IgfsMissingParException("Missing md");
		}

	}

	protected function buildRequest() {
		$request = parent::buildRequest();

		$request = $this->replaceRequest($request, "{paRes}", $this->paRes);
		$request = $this->replaceRequest($request, "{md}", $this->md);

		return $request;
	}

	protected function setRequestSignature($request) {
		// signature dove il buffer e' cosi composto APIVERSION|TID|SHOPID|PARES|MD
		$fields = array(
				$this->getVersion(), // APIVERSION
				$this->tid, // TID
				$this->shopID, // SHOPID
				$this->paRes, // PARES
				$this->md); // MD
		$signature = $this->getSignature($this->kSig, // KSIGN
				$fields); 
		$request = $this->replaceRequest($request, "{signature}", $signature);
		return $request;
	}

	protected function parseResponseMap($response) {
		parent::parseResponseMap($response);
		$this->authStatus = IgfsUtils::getValue($response, "authStatus");
		// Opzionale
		$this->cavv = IgfsUtils::getValue($response, "cavv");
		// Opzionale
		$this->eci = IgfsUtils::getValue($response, "eci");
	}

	protected function getResponseSignature($response) {
		$fields = array(
				IgfsUtils::getValue($response, "tid"), // TID
				IgfsUtils::getValue($response, "shopID"), // SHOPID
				IgfsUtils::getValue($response, "rc"), // RC
				IgfsUtils::getValue($response, "errorDesc"),// ERRORDESC
				IgfsUtils::getValue($response, "authStatus"), // AUTHSTATUS
				IgfsUtils::getValue($response, "cavv"), // CAVV
				IgfsUtils::getValue($response, "eci")); // ECI
		// signature dove il buffer e' cosi composto TID|SHOPID|RC|ERRORCODE|AUTHSTATUS|CAVV|ECI
		return $this->getSignature($this->kSig, // KSIGN
				$fields); 
	}
	
	protected function getFileName() {
		return __DIR__."/IgfsCgMpiAuth.request";
	}

}

?>
