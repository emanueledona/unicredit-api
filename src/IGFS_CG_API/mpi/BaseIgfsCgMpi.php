<?php
namespace emanueledona\unicreditApi\IGFS_CG_API\mpi;

use emanueledona\unicreditApi\IGFS_CG_API\BaseIgfsCg;

abstract class BaseIgfsCgMpi extends BaseIgfsCg {

	public $shopID; // chiave messaggio

	public $xid;

	function __construct() {
		parent::__construct();
	}

	protected function resetFields() {
		parent::resetFields();
		$this->shopID = NULL;

		$this->xid = NULL;
	}

	protected function checkFields() {
		parent::checkFields();
		if ($this->shopID == NULL || "" == $this->shopID)
			throw new IgfsMissingParException("Missing shopID");
	}

	protected function buildRequest() {
		$request = parent::buildRequest();
		$request = $this->replaceRequest($request, "{shopID}", $this->shopID);
		return $request;
	}

	protected function getServicePort() {
		return "MPIGatewayPort";
	}

	protected function parseResponseMap($response) {
		parent::parseResponseMap($response);
		// Opzionale
		$this->xid = IgfsUtils::getValue($response, "xid");
	}

}

?>
