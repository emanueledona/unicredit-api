<?php
namespace emanueledona\unicreditApi\IGFS_CG_API\init;

use emanueledona\unicreditApi\IGFS_CG_API\init\BaseIgfsCgInit;
use emanueledona\unicreditApi\IGFS_CG_API\init\InitTerminalInfo;
use emanueledona\unicreditApi\IGFS_CG_API\IgfsUtils;
use emanueledona\unicreditApi\IGFS_CG_API\Level3Info;
use emanueledona\unicreditApi\IGFS_CG_API\MandateInfo;

class IgfsCgInit extends BaseIgfsCgInit {

	public $shopUserRef;
	public $shopUserName;
	public $shopUserAccount;
	public $shopUserMobilePhone;
	public $shopUserIMEI;
	public $trType = "AUTH";
	public $amount;
	public $currencyCode;
	public $langID = "IT";
	public $notifyURL;
	public $errorURL;
	public $callbackURL;
	public $addInfo1;
	public $addInfo2;
	public $addInfo3;
	public $addInfo4;
	public $addInfo5;
	public $payInstrToken;
	public $regenPayInstrToken;
	public $keepOnRegenPayInstrToken;
	public $payInstrTokenExpire;
	public $payInstrTokenUsageLimit;
	public $payInstrTokenAlg;
	public $accountName;
	public $level3Info;
	public $mandateInfo;
	public $description;
	public $recurrent;
	public $paymentReason;
	public $topUpID;
	public $firstTopUp;
	public $payInstrTokenAsTopUpID;
	public $validityExpire;
	public $minExpireMonth;
	public $minExpireYear;
	public $termInfo;

	public $paymentID;
	public $redirectURL;

	function __construct() {
		parent::__construct();
	}

	protected function resetFields() {
		parent::resetFields();
		$this->shopUserRef = NULL;
		$this->shopUserName = NULL;
		$this->shopUserAccount = NULL;
		$this->shopUserMobilePhone = NULL;
		$this->shopUserIMEI = NULL;
		$this->trType = "AUTH";
		$this->amount = NULL;
		$this->currencyCode = NULL;
		$this->langID = "IT";
		$this->notifyURL = NULL;
		$this->errorURL = NULL;
		$this->callbackURL = NULL;
		$this->addInfo1 = NULL;
		$this->addInfo2 = NULL;
		$this->addInfo3 = NULL;
		$this->addInfo4 = NULL;
		$this->addInfo5 = NULL;
		$this->payInstrToken = NULL;
		$this->regenPayInstrToken = NULL;
		$this->keepOnRegenPayInstrToken = NULL;
		$this->payInstrTokenExpire = NULL;
		$this->payInstrTokenUsageLimit = NULL;
		$this->payInstrTokenAlg = NULL;
		$this->accountName = NULL;
		$this->level3Info = NULL;
		$this->mandateInfo = NULL;
		$this->description = NULL;
		$this->recurrent = NULL;
		$this->paymentReason = NULL;
		$this->topUpID = NULL;
		$this->firstTopUp = NULL;
		$this->payInstrTokenAsTopUpID = NULL;
		$this->validityExpire = NULL;
		$this->minExpireMonth = NULL;
		$this->minExpireYear = NULL;
		$this->termInfo = NULL;

		$this->paymentID = NULL;
		$this->redirectURL = NULL;
	}

	protected function checkFields() {
		parent::checkFields();
		if ($this->trType == NULL)
			throw new IgfsMissingParException("Missing trType");
		// if ($this->trType == "TOKENIZE") {}
		// elseif ($this->trType == "DELETE") {}
		// elseif ($this->trType == "VERIFY") {}
		// else {
		// if ($this->amount == NULL)
		// throw new IgfsMissingParException("Missing amount");
		// if ($this->currencyCode == NULL)
		// throw new IgfsMissingParException("Missing currencyCode");
		// }
		if ($this->langID == NULL)
			throw new IgfsMissingParException("Missing langID");
		if ($this->notifyURL == NULL)
			throw new IgfsMissingParException("Missing notifyURL");
		if ($this->errorURL == NULL)
			throw new IgfsMissingParException("Missing errorURL");
		if ($this->payInstrToken != NULL) {
			// Se è stato impostato il payInstrToken verifico...
			if ($this->payInstrToken == "")
				throw new IgfsMissingParException("Missing payInstrToken");
		}
		if ($this->level3Info != NULL) {
			$i = 0;
			if ($this->level3Info->product != NULL) {
				foreach ($this->level3Info->product as $product) {
					if ($product->productCode == NULL)
						throw new IgfsMissingParException("Missing productCode[" . i . "]");
					if ($product->productDescription == NULL)
						throw new IgfsMissingParException("Missing productDescription[" . i . "]");
				}
				$i++;
			}
		}
		if ($this->mandateInfo != NULL) {
			if ($this->mandateInfo->mandateID == NULL)
				throw new IgfsMissingParException("Missing mandateID");
		}
	}

	protected function buildRequest() {
		$request = parent::buildRequest();
		if ($this->shopUserRef != NULL)
			$request = $this->replaceRequest($request, "{shopUserRef}", "<shopUserRef><![CDATA[" . $this->shopUserRef . "]]></shopUserRef>");
		else
			$request = $this->replaceRequest($request, "{shopUserRef}", "");
		if ($this->shopUserName != NULL)
			$request = $this->replaceRequest($request, "{shopUserName}", "<shopUserName><![CDATA[" . $this->shopUserName . "]]></shopUserName>");
		else
			$request = $this->replaceRequest($request, "{shopUserName}", "");
		if ($this->shopUserAccount != NULL)
			$request = $this->replaceRequest($request, "{shopUserAccount}", "<shopUserAccount><![CDATA[" . $this->shopUserAccount . "]]></shopUserAccount>");
		else
			$request = $this->replaceRequest($request, "{shopUserAccount}", "");
		if ($this->shopUserMobilePhone != NULL)
			$request = $this->replaceRequest($request, "{shopUserMobilePhone}", "<shopUserMobilePhone><![CDATA[" . $this->shopUserMobilePhone . "]]></shopUserMobilePhone>");
		else
			$request = $this->replaceRequest($request, "{shopUserMobilePhone}", "");
		if ($this->shopUserIMEI != NULL)
			$request = $this->replaceRequest($request, "{shopUserIMEI}", "<shopUserIMEI><![CDATA[" . $this->shopUserIMEI . "]]></shopUserIMEI>");
		else
			$request = $this->replaceRequest($request, "{shopUserIMEI}", "");

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
		$request = $this->replaceRequest($request, "{notifyURL}", $this->notifyURL);
		$request = $this->replaceRequest($request, "{errorURL}", $this->errorURL);
		if ($this->callbackURL != NULL)
			$request = $this->replaceRequest($request, "{callbackURL}", "<callbackURL><![CDATA[" . $this->callbackURL . "]]></callbackURL>");
		else
			$request = $this->replaceRequest($request, "{callbackURL}", "");
		
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
		if ($this->regenPayInstrToken != NULL)
			$request = $this->replaceRequest($request, "{regenPayInstrToken}", "<regenPayInstrToken><![CDATA[" . $this->regenPayInstrToken . "]]></regenPayInstrToken>");
		else
			$request = $this->replaceRequest($request, "{regenPayInstrToken}", "");
		if ($this->keepOnRegenPayInstrToken != NULL)
			$request = $this->replaceRequest($request, "{keepOnRegenPayInstrToken}", "<keepOnRegenPayInstrToken><![CDATA[" . $this->keepOnRegenPayInstrToken . "]]></keepOnRegenPayInstrToken>");
		else
			$request = $this->replaceRequest($request, "{keepOnRegenPayInstrToken}", "");
		if ($this->payInstrTokenExpire != NULL)
			$request = $this->replaceRequest($request, "{payInstrTokenExpire}", "<payInstrTokenExpire><![CDATA[" . IgfsUtils::formatXMLGregorianCalendar($this->payInstrTokenExpire) . "]]></payInstrTokenExpire>");
		else
			$request = $this->replaceRequest($request, "{payInstrTokenExpire}", "");
		if ($this->payInstrTokenUsageLimit != NULL)
			$request = $this->replaceRequest($request, "{payInstrTokenUsageLimit}", "<payInstrTokenUsageLimit><![CDATA[" . $this->payInstrTokenUsageLimit . "]]></payInstrTokenUsageLimit>");
		else
			$request = $this->replaceRequest($request, "{payInstrTokenUsageLimit}", "");
		if ($this->payInstrTokenAlg != NULL)
			$request = $this->replaceRequest($request, "{payInstrTokenAlg}", "<payInstrTokenAlg><![CDATA[" . $this->payInstrTokenAlg . "]]></payInstrTokenAlg>");
		else
			$request = $this->replaceRequest($request, "{payInstrTokenAlg}", "");

		if ($this->accountName != NULL)
			$request = $this->replaceRequest($request, "{accountName}", "<accountName><![CDATA[" . $this->accountName . "]]></accountName>");
		else
			$request = $this->replaceRequest($request, "{accountName}", "");

		if ($this->level3Info != NULL)
			$request = $this->replaceRequest($request, "{level3Info}", $this->level3Info->toXml());
		else
			$request = $this->replaceRequest($request, "{level3Info}", "");
		if ($this->mandateInfo != NULL)
			$request = $this->replaceRequest($request, "{mandateInfo}", $this->mandateInfo->toXml());
		else
			$request = $this->replaceRequest($request, "{mandateInfo}", "");
		if ($this->description != NULL)
			$request = $this->replaceRequest($request, "{description}", "<description><![CDATA[" . $this->description . "]]></description>");
		else
			$request = $this->replaceRequest($request, "{description}", "");
		if ($this->recurrent != NULL)
			$request = $this->replaceRequest($request, "{recurrent}", "<recurrent><![CDATA[" . $this->recurrent . "]]></recurrent>");
		else
			$request = $this->replaceRequest($request, "{recurrent}", "");
		if ($this->paymentReason != NULL)
			$request = $this->replaceRequest($request, "{paymentReason}", "<paymentReason><![CDATA[" . $this->paymentReason . "]]></paymentReason>");
		else
			$request = $this->replaceRequest($request, "{paymentReason}", "");

		if ($this->topUpID != NULL)
			$request = $this->replaceRequest($request, "{topUpID}", "<topUpID><![CDATA[" . $this->topUpID . "]]></topUpID>");
		else
			$request = $this->replaceRequest($request, "{topUpID}", "");
		if ($this->firstTopUp != NULL)
			$request = $this->replaceRequest($request, "{firstTopUp}", "<firstTopUp><![CDATA[" . $this->firstTopUp . "]]></firstTopUp>");
		else
			$request = $this->replaceRequest($request, "{firstTopUp}", "");
		if ($this->payInstrTokenAsTopUpID != NULL)
			$request = $this->replaceRequest($request, "{payInstrTokenAsTopUpID}", "<payInstrTokenAsTopUpID><![CDATA[" . $this->payInstrTokenAsTopUpID . "]]></payInstrTokenAsTopUpID>");
		else
			$request = $this->replaceRequest($request, "{payInstrTokenAsTopUpID}", "");

		if ($this->validityExpire != NULL)
			$request = $this->replaceRequest($request, "{validityExpire}", "<validityExpire><![CDATA[" . IgfsUtils::formatXMLGregorianCalendar($this->validityExpire) . "]]></validityExpire>");
		else
			$request = $this->replaceRequest($request, "{validityExpire}", "");

		if ($this->minExpireMonth != NULL)
			$request = $this->replaceRequest($request, "{minExpireMonth}", "<minExpireMonth><![CDATA[" . $this->minExpireMonth . "]]></minExpireMonth>");
		else
			$request = $this->replaceRequest($request, "{minExpireMonth}", "");
		if ($this->minExpireYear != NULL)
			$request = $this->replaceRequest($request, "{minExpireYear}", "<minExpireYear><![CDATA[" . $this->minExpireYear . "]]></minExpireYear>");
		else
			$request = $this->replaceRequest($request, "{minExpireYear}", "");

		if ($this->termInfo != NULL) {
			$sb = "";
			foreach ($this->termInfo as $item) {
				$sb .= $item->toXml();
			}
			$request = $this->replaceRequest($request, "{termInfo}", $sb);
		} else
			$request = $this->replaceRequest($request, "{termInfo}", "");

		return $request;
	}

	protected function setRequestSignature($request) {
		// signature dove il buffer e' cosi composto APIVERSION|TID|SHOPID|SHOPUSERREF|SHOPUSERNAME|SHOPUSERACCOUNT|SHOPUSERMOBILEPHONE|SHOPUSERIMEI|TRTYPE|AMOUNT|CURRENCYCODE|LANGID|NOTIFYURL|ERRORURL|CALLBACKURL
		$fields = array(
				$this->getVersion(), // APIVERSION
				$this->tid, // TID
				$this->shopID, // SHOPID
				$this->shopUserRef, // SHOPUSERREF
				$this->shopUserName, // SHOPUSERNAME
				$this->shopUserAccount, // SHOPUSERACCOUNT
				$this->shopUserMobilePhone, //SHOPUSERMOBILEPHONE
				$this->shopUserIMEI, //SHOPUSERIMEI
				$this->trType,// TRTYPE
				$this->amount, // AMOUNT
				$this->currencyCode, // CURRENCYCODE
				$this->langID, // LANGID
				$this->notifyURL, // NOTIFYURL
				$this->errorURL, // ERRORURL
				$this->callbackURL, // CALLBACKURL
				$this->addInfo1, // UDF1
				$this->addInfo2, // UDF2
				$this->addInfo3, // UDF3
				$this->addInfo4, // UDF4
				$this->addInfo5, // UDF5
				$this->payInstrToken, // PAYINSTRTOKEN
				$this->topUpID);
		$signature = $this->getSignature($this->kSig, // KSIGN
				$fields); 
		$request = $this->replaceRequest($request, "{signature}", $signature);
		return $request;
	}

	protected function parseResponseMap($response) {
		parent::parseResponseMap($response);
		// Opzionale
		$this->paymentID = IgfsUtils::getValue($response, "paymentID");
		// Opzionale
		$this->redirectURL = IgfsUtils::getValue($response, "redirectURL");
	}

	protected function getResponseSignature($response) {
		$fields = array(
				IgfsUtils::getValue($response, "tid"), // TID
				IgfsUtils::getValue($response, "shopID"), // SHOPID
				IgfsUtils::getValue($response, "rc"), // RC
				IgfsUtils::getValue($response, "errorDesc"),// ERRORDESC
				IgfsUtils::getValue($response, "paymentID"), // PAYMENTID
				IgfsUtils::getValue($response, "redirectURL"));// REDIRECTURL	
		// signature dove il buffer e' cosi composto TID|SHOPID|RC|ERRORDESC|PAYMENTID|REDIRECTURL
		return $this->getSignature($this->kSig, // KSIGN
				$fields); 
	}
	
	protected function getFileName() {
		return __DIR__."/IgfsCgInit.request";
	}

}

?>
