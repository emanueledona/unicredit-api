<?php
namespace emanueledona\unicreditApi\IGFS_CG_API;

class MandateInfo {

	public $mandateID;
	public $contractID;
	public $sequenceType;
	public $frequency;
	public $durationStartDate;
	public $durationEndDate;
	public $firstCollectionDate;
	public $finalCollectionDate;
	public $maxAmount;
	
    function __construct() {
	}

	public function toXml() {
		$sb = "";
		$sb .= "<mandateInfo>";
		if ($this->mandateID != NULL) {
			$sb .= "<mandateID><![CDATA[";
			$sb .= $this->mandateID;
			$sb .= "]]></mandateID>";
		}
		if ($this->contractID != NULL) {
			$sb .= "<contractID><![CDATA[";
			$sb .= $this->contractID;
			$sb .= "]]></contractID>";
		}
		if ($this->sequenceType != NULL) {
			$sb .= "<sequenceType><![CDATA[";
			$sb .= $this->sequenceType;
			$sb .= "]]></sequenceType>";
		}
		if ($this->frequency != NULL) {
			$sb .= "<frequency><![CDATA[";
			$sb .= $this->frequency;
			$sb .= "]]></frequency>";
		}
		if ($this->durationStartDate != NULL) {
			$sb .= "<durationStartDate><![CDATA[";
			$sb .= IgfsUtils::formatXMLGregorianCalendar($this->durationStartDate);
			$sb .= "]]></durationStartDate>";
		}
		if ($this->durationEndDate != NULL) {
			$sb .= "<durationEndDate><![CDATA[";
			$sb .= IgfsUtils::formatXMLGregorianCalendar($this->durationEndDate);
			$sb .= "]]></durationEndDate>";
		}
		if ($this->firstCollectionDate != NULL) {
			$sb .= "<firstCollectionDate><![CDATA[";
			$sb .= IgfsUtils::formatXMLGregorianCalendar($this->firstCollectionDate);
			$sb .= "]]></firstCollectionDate>";
		}
		if ($this->finalCollectionDate != NULL) {
			$sb .= "<finalCollectionDate><![CDATA[";
			$sb .= IgfsUtils::formatXMLGregorianCalendar($this->finalCollectionDate);
			$sb .= "]]></finalCollectionDate>";
		}
		if ($this->maxAmount != NULL) {
			$sb .= "<maxAmount><![CDATA[";
			$sb .= $this->maxAmount;
			$sb .= "]]></maxAmount>";
		}
		$sb .= "</mandateInfo>";
		return $sb;
	}

}
?>
