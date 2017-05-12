<?php
namespace emanueledona\unicreditApi\IGFS_CG_API\tran;

use emanueledona\unicreditApi\IGFS_CG_API\tran\BaseIgfsCgTran;

class IgfsCgConfirm extends BaseIgfsCgTran {

	public $amount;
	public $refTranID;
	public $paymentReason;
	public $topUpID;
	public $splitTran;
	public $carrierTrackID;
	public $carrierID;

	public $pendingAmount;

	function __construct() {
		parent::__construct();
	}

	protected function resetFields() {
		parent::resetFields();
		$this->amount = NULL;
		$this->refTranID = NULL;
		$this->paymentReason = NULL;
		$this->topUpID = NULL;
		$this->splitTran = NULL;		
		$this->carrierTrackID = NULL;
		$this->carrierID = NULL;

		$this->pendingAmount = NULL;
	}

	protected function checkFields() {
		parent::checkFields();
		if ($this->amount == NULL)
			throw new IgfsMissingParException("Missing amount");

		if ($this->refTranID == NULL)
		if ($this->topUpID == NULL)
			throw new IgfsMissingParException("Missing refTranID");
	}

	protected function buildRequest() {
		$request = parent::buildRequest();
		$request = $this->replaceRequest($request, "{amount}", $this->amount);

		if ($this->refTranID != NULL)
			$request = $this->replaceRequest($request, "{refTranID}", "<refTranID><![CDATA[" . $this->refTranID . "]]></refTranID>");
		else
			$request = $this->replaceRequest($request, "{refTranID}", "");

		if ($this->paymentReason != NULL)
			$request = $this->replaceRequest($request, "{paymentReason}", "<paymentReason><![CDATA[" . $this->paymentReason . "]]></paymentReason>");
		else
			$request = $this->replaceRequest($request, "{paymentReason}", "");

		if ($this->topUpID != NULL)
			$request = $this->replaceRequest($request, "{topUpID}", "<topUpID><![CDATA[" . $this->topUpID . "]]></topUpID>");
		else
			$request = $this->replaceRequest($request, "{topUpID}", "");

		if ($this->splitTran != NULL)
			$request = $this->replaceRequest($request, "{splitTran}", "<splitTran><![CDATA[" . $this->splitTran . "]]></splitTran>");
		else
			$request = $this->replaceRequest($request, "{splitTran}", "");
			
		if ($this->carrierTrackID != NULL)
			$request = $this->replaceRequest($request, "{carrierTrackID}", "<carrierTrackID><![CDATA[" . $this->carrierTrackID . "]]></carrierTrackID>");
		else
			$request = $this->replaceRequest($request, "{carrierTrackID}", "");
		
		if ($this->carrierID != NULL)
			$request = $this->replaceRequest($request, "{carrierID}", "<carrierID><![CDATA[" . $this->carrierID . "]]></carrierID>");
		else
			$request = $this->replaceRequest($request, "{carrierID}", "");

		return $request;
	}

	protected function setRequestSignature($request) {
		// signature dove il buffer e' cosi composto APIVERSION|TID|SHOPID|AMOUNT|REFORDERID
		$fields = array(
				$this->getVersion(), // APIVERSION
				$this->tid, // TID
				$this->shopID, // SHOPID
				$this->amount, // AMOUNT
				$this->refTranID, // REFORDERID
				$this->addInfo1, // UDF1
				$this->addInfo2, // UDF2
				$this->addInfo3, // UDF3
				$this->addInfo4, // UDF4
				$this->addInfo5, // UDF5
				$this->topUpID);
		$signature = $this->getSignature($this->kSig, // KSIGN
				$fields); 
		$request = $this->replaceRequest($request, "{signature}", $signature);
		return $request;
	}

	protected function parseResponseMap($response) {
		parent::parseResponseMap($response);
		// Opzionale
		$this->pendingAmount = IgfsUtils::getValue($response, "pendingAmount");
	}

	protected function getResponseSignature($response) {
		$fields = array(
				IgfsUtils::getValue($response, "tid"), // TID
				IgfsUtils::getValue($response, "shopID"), // SHOPID
				IgfsUtils::getValue($response, "rc"), // RC
				IgfsUtils::getValue($response, "errorDesc"),// ERRORDESC
				IgfsUtils::getValue($response, "tranID"), // ORDERID
				IgfsUtils::getValue($response, "date"), // TRANDATE
				IgfsUtils::getValue($response, "addInfo1"), // UDF1
				IgfsUtils::getValue($response, "addInfo2"), // UDF2
				IgfsUtils::getValue($response, "addInfo3"), // UDF3
				IgfsUtils::getValue($response, "addInfo4"), // UDF4
				IgfsUtils::getValue($response, "addInfo5"));// UDF5
		// signature dove il buffer e' cosi composto TID|SHOPID|RC|ERRORDESC|ORDERID|DATE|UDF1|UDF2|UDF3|UDF4|UDF5
		return $this->getSignature($this->kSig, // KSIGN
				$fields); 
	}
	
	protected function getFileName() {
		return __DIR__."/IgfsCgConfirm.request";
	}

}

?>
