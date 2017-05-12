<?php
namespace emanueledona\unicreditApi\IGFS_CG_API;

class emanueledona\unicreditApi\IGFS_CG_API\Level3InfoProduct {
	
	public $productCode;
	public $productDescription;
	public $items;
	public $amount;
	public $imgURL;

    function __construct() {
	}

	public function toXml() {
		$sb = "";
		$sb .= "<product>";
		if ($this->productCode != NULL) {
			$sb .= "<productCode><![CDATA[";
			$sb .= $this->productCode;
			$sb .= "]]></productCode>";
		}
		if ($this->productDescription != NULL) {
			$sb .= "<productDescription><![CDATA[";
			$sb .= $this->productDescription;
			$sb .= "]]></productDescription>";
		}
		if ($this->items != NULL) {
			$sb .= "<items><![CDATA[";
			$sb .= $this->items;
			$sb .= "]]></items>";
		}
		if ($this->amount != NULL) {
			$sb .= "<amount><![CDATA[";
			$sb .= $this->amount;
			$sb .= "]]></amount>";
		}
		if ($this->imgURL != NULL) {
			$sb .= "<imgURL><![CDATA[";
			$sb .= $this->imgURL;
			$sb .= "]]></imgURL>";
		}
		$sb .= "</product>";
		return $sb;
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
		$product = NULL;
		if (isset($response) && count($response)>0) {
			$product = new Level3InfoProduct();
			$product->productCode = (IgfsUtils::getValue($response, "productCode"));
			$product->productDescription = (IgfsUtils::getValue($response, "productDescription"));
			$product->items = (IgfsUtils::getValue($response, "items"));
			$product->amount = (IgfsUtils::getValue($response, "amount"));
			$product->imgURL = (IgfsUtils::getValue($response, "imgURL"));
		}
		return $product;
	}

}
?>
