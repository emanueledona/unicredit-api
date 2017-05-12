<?php
namespace emanueledona\unicreditApi\IGFS_CG_API\tran;

use emanueledona\unicreditApi\IGFS_CG_API\tran\BaseIgfsCg;

abstract class BaseIgfsCgTran extends BaseIgfsCg {

	public $shopID; // chiave messaggio
	public $addInfo1;
	public $addInfo2;
	public $addInfo3;
	public $addInfo4;
	public $addInfo5;

	public $tranID;

	function __construct() {
		parent::__construct();
	}

	protected function resetFields() {
		parent::resetFields();
		$this->shopID = NULL;
		$this->addInfo1 = NULL;
		$this->addInfo2 = NULL;
		$this->addInfo3 = NULL;
		$this->addInfo4 = NULL;
		$this->addInfo5 = NULL;

		$this->tranID = NULL;
	}

	protected function checkFields() {
		parent::checkFields();
		if ($this->shopID == NULL || "" == $this->shopID)
			throw new IgfsMissingParException("Missing shopID");
	}

	protected function buildRequest() {
		$request = parent::buildRequest();
		$request = $this->replaceRequest($request, "{shopID}", $this->shopID);
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

	protected function getServicePort() {
		return "PaymentTranGatewayPort";
	}

	protected function parseResponseMap($response) {
		parent::parseResponseMap($response);
		// Opzionale
		$this->tranID = IgfsUtils::getValue($response, "tranID");
		// Opzionale
		$this->addInfo1 = IgfsUtils::getValue($response, "addInfo1");
		// Opzionale
		$this->addInfo2 = IgfsUtils::getValue($response, "addInfo2");
		// Opzionale
		$this->addInfo3 = IgfsUtils::getValue($response, "addInfo3");
		// Opzionale
		$this->addInfo4 = IgfsUtils::getValue($response, "addInfo4");
		// Opzionale
		$this->addInfo5 = IgfsUtils::getValue($response, "addInfo5");
	}

}

?>
