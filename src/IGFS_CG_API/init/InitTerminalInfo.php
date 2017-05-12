<?php
namespace emanueledona\unicreditApi\IGFS_CG_API\init;

class InitTerminalInfo {
	
	public $tid;
	public $payInstrToken;

    function __construct() {
	}

	public function toXml() {
		$sb = "";
		$sb .= "<termInfo>";
		if ($this->tid != NULL) {
			$sb .= "<tid><![CDATA[";
			$sb .= $this->tid;
			$sb .= "]]></tid>";
		}
		if ($this->payInstrToken != NULL) {
			$sb .= "<payInstrToken><![CDATA[";
			$sb .= $this->payInstrToken;
			$sb .= "]]></payInstrToken>";
		}
		$sb .= "</termInfo>";
		return $sb;
	}

}
?>
