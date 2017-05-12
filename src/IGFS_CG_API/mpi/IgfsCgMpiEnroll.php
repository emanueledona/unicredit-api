<?php
namespace emanueledona\unicreditApi\IGFS_CG_API\mpi;

use emanueledona\unicreditApi\IGFS_CG_API\mpi\BaseIgfsCgMpi;

class IgfsCgMpiEnroll extends BaseIgfsCgMpi {

	public $shopUserRef;
	public $amount;
	public $currencyCode;

	public $pan;
	public $payInstrToken;
	public $expireMonth;
	public $expireYear;
	public $termURL;
	public $description;

	public $addInfo1;
	public $addInfo2;
	public $addInfo3;
	public $addInfo4;
	public $addInfo5;

	public $enrStatus;
	public $paReq;
	public $md;
	public $acsURL;
	public $acsPage;

	function __construct() {
		parent::__construct();
	}

	protected function resetFields() {
		parent::resetFields();
		$this->shopUserRef = NULL;
		$this->amount = NULL;
		$this->currencyCode = NULL;

		$this->pan = NULL;
		$this->payInstrToken = NULL;
		$this->expireMonth = NULL;
		$this->expireYear = NULL;
		$this->termURL = NULL;
		$this->description = NULL;

		$this->addInfo1 = NULL;
		$this->addInfo2 = NULL;
		$this->addInfo3 = NULL;
		$this->addInfo4 = NULL;
		$this->addInfo5 = NULL;

		$this->enrStatus = NULL;
		$this->paReq = NULL;
		$this->md = NULL;
		$this->acsURL = NULL;
		$this->acsPage = NULL;
	}

	protected function checkFields() {
		parent::checkFields();
		if ($this->amount == NULL)
			throw new IgfsMissingParException("Missing amount");
		if ($this->currencyCode == NULL)
			throw new IgfsMissingParException("Missing currencyCode");

		if ($this->pan == NULL)
		if ($this->payInstrToken == NULL)
			throw new IgfsMissingParException("Missing pan");

		if ($this->pan != NULL) {
			// Se è stato impostato il pan verifico...
			if ($this->pan == "")
				throw new IgfsMissingParException("Missing pan");
		}

		if ($this->payInstrToken != NULL) {
			// Se è stato impostato il payInstrToken verifico...
			if ($this->payInstrToken == "")
				throw new IgfsMissingParException("Missing payInstrToken");
		}

		if ($this->termURL == NULL)
			throw new IgfsMissingParException("Missing termURL");

	}

	protected function buildRequest() {
		$request = parent::buildRequest();
		if ($this->shopUserRef != NULL)
			$request = $this->replaceRequest($request, "{shopUserRef}", "<shopUserRef><![CDATA[" . $this->shopUserRef . "]]></shopUserRef>");
		else
			$request = $this->replaceRequest($request, "{shopUserRef}", "");

		$request = $this->replaceRequest($request, "{amount}", $this->amount);
		$request = $this->replaceRequest($request, "{currencyCode}", $this->currencyCode);

		if ($this->pan != NULL)
			$request = $this->replaceRequest($request, "{pan}", "<pan><![CDATA[" . $this->pan . "]]></pan>");
		else
			$request = $this->replaceRequest($request, "{pan}", "");

		if ($this->payInstrToken != NULL)
			$request = $this->replaceRequest($request, "{payInstrToken}", "<payInstrToken><![CDATA[" . $this->payInstrToken . "]]></payInstrToken>");
		else
			$request = $this->replaceRequest($request, "{payInstrToken}", "");

		if ($this->expireMonth != NULL)
			$request = $this->replaceRequest($request, "{expireMonth}", "<expireMonth><![CDATA[" . $this->expireMonth . "]]></expireMonth>");
		else
			$request = $this->replaceRequest($request, "{expireMonth}", "");
		if ($this->expireYear != NULL)
			$request = $this->replaceRequest($request, "{expireYear}", "<expireYear><![CDATA[" . $this->expireYear . "]]></expireYear>");
		else
			$request = $this->replaceRequest($request, "{expireYear}", "");

		$request = $this->replaceRequest($request, "{termURL}", $this->termURL);

		if ($this->description != NULL)
			$request = $this->replaceRequest($request, "{description}", "<description><![CDATA[" . $this->description . "]]></description>");
		else
			$request = $this->replaceRequest($request, "{description}", "");
		
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

		return $request;
	}

	protected function setRequestSignature($request) {
		// signature dove il buffer e' cosi composto APIVERSION|TID|SHOPID|SHOPUSERREF|AMOUNT|CURRENCYCODE|PAN|PAYINSTRTOKEN|EXPIREMONTH|EXPIREYEAR|TERMURL|DESCRIPTION|UDF1|UDF2|UDF3|UDF4|UDF5
		$fields = array(
				$this->getVersion(), // APIVERSION
				$this->tid, // TID
				$this->shopID, // SHOPID
				$this->shopUserRef, // SHOPUSERREF
				$this->amount, // AMOUNT
				$this->currencyCode, // CURRENCYCODE
				$this->pan, // PAN
				$this->payInstrToken, // PAYINSTRTOKEN
				$this->expireMonth, // EXPIREMONTH
				$this->expireYear, // EXPIREYEAR
				$this->termURL, // TERMURL
				$this->description, // DESCRIPTION
				$this->addInfo1, // UDF1
				$this->addInfo2, // UDF2
				$this->addInfo3, // UDF3
				$this->addInfo4, // UDF4
				$this->addInfo5); // UDF5
		$signature = $this->getSignature($this->kSig, // KSIGN
				$fields); 
		$request = $this->replaceRequest($request, "{signature}", $signature);
		return $request;
	}

	protected function parseResponseMap($response) {
		parent::parseResponseMap($response);
		$this->enrStatus = IgfsUtils::getValue($response, "enrStatus");
		// Opzionale
		$this->paReq = IgfsUtils::getValue($response, "paReq");
		// Opzionale
		$this->md = IgfsUtils::getValue($response, "md");
		// Opzionale
		$this->acsURL = IgfsUtils::getValue($response, "acsURL");
		// Opzionale
		$this->acsPage = IgfsUtils::getValue($response, "acsPage");
	}

	protected function getResponseSignature($response) {
		$fields = array(
				IgfsUtils::getValue($response, "tid"), // TID
				IgfsUtils::getValue($response, "shopID"), // SHOPID
				IgfsUtils::getValue($response, "rc"), // RC
				IgfsUtils::getValue($response, "errorDesc"),// ERRORDESC
				IgfsUtils::getValue($response, "enrStatus"), // ENRSTATUS
				IgfsUtils::getValue($response, "paReq"), // PAREQ
				IgfsUtils::getValue($response, "md"), // MD
				IgfsUtils::getValue($response, "acsURL"), // ACSURL
				IgfsUtils::getValue($response, "acsPage")); // ACSPAGE
		// signature dove il buffer e' cosi composto TID|SHOPID|RC|ERRORCODE|ENRSTATUS|PAREQ|MD|ACSURL|ACSPAGE
		return $this->getSignature($this->kSig, // KSIGN
				$fields); 
	}
	
	protected function getFileName() {
		return __DIR__."/IgfsCgMpiEnroll.request";
	}

}

?>
