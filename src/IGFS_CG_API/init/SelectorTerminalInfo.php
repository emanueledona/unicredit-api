<?php
namespace emanueledona\unicreditApi\IGFS_CG_API\init;

class SelectorTerminalInfo {
	
	public $tid;
	public $description;
	public $payInstr;
	public $payInstrDescription;
	public $imgURL;

    function __construct() {
	}

	public static function fromXml($xml) {

		if ($xml=="" || $xml==NULL) {
			return;
		}

		$dom = new SimpleXMLElement($xml, LIBXML_NOERROR, false);
		if (count($dom)==0) {
			return;
		}

		$response = IgfsUtils::parseResponseFields($dom);
		$terminal = NULL;
		if (isset($response) && count($response)>0) {
			$terminal = new SelectorTerminalInfo();
			$terminal->tid = (IgfsUtils::getValue($response, "tid"));
			$terminal->description = (IgfsUtils::getValue($response, "description"));
			$terminal->payInstr = (IgfsUtils::getValue($response, "payInstr"));
			$terminal->payInstrDescription = (IgfsUtils::getValue($response, "payInstrDescription"));

			if (isset($response["imgURL"])) {
				$imgURL = array();
				foreach ($dom->children() as $item) {
					if ($item->getName() == "imgURL") {
					    $imgURL[] = $item->__toString();
					}
				}
				$terminal->imgURL = $imgURL;
			}

		}
		return $terminal;
	}

}
?>
