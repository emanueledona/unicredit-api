<?php
namespace emanueledona\unicreditApi\IGFS_CG_API\tran;

use emanueledona\unicreditApi\IGFS_CG_API\Level3Info;
use emanueledona\unicreditApi\IGFS_CG_API\tran\BaseIgfsCgTran;

class IgfsCgAuth extends BaseIgfsCgTran {

	public $shopUserRef;
	public $shopUserName;
	public $shopUserAccount;
	public $shopUserMobilePhone;
	public $shopUserIMEI;
	public $shopUserIP;
	public $trType = "AUTH";
	public $amount;
	public $currencyCode;
	public $langID;
	public $callbackURL;
	public $pan;
	public $payInstrToken;
	public $regenPayInstrToken;
	public $keepOnRegenPayInstrToken;
	public $payInstrTokenExpire;
	public $payInstrTokenUsageLimit;
	public $payInstrTokenAlg;
	public $cvv2;
	public $expireMonth;
	public $expireYear;
	public $accountName;
	public $enrStatus;
	public $authStatus;
	public $cavv;
	public $xid;
	public $level3Info;
	public $description;
	public $recurrent;
	public $paymentReason;
	public $topUpID;
	public $firstTopUp;
	public $payInstrTokenAsTopUpID;
	public $promoCode;
	public $payPassData;
	public $userAgent;
	public $fingerPrint;
	public $validityExpire;

	public $paymentID;
	public $authCode;
	public $brand;
	public $acquirerID;
	public $maskedPan;
	public $additionalFee;
	public $status;
	public $nssResult;
	public $receiptPdf;

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
		$this->shopUserIP = NULL;
		$this->trType = "AUTH";
		$this->amount = NULL;
		$this->currencyCode = NULL;
		$this->langID = NULL;
		$this->callbackURL = NULL;
		$this->pan = NULL;
		$this->payInstrToken = NULL;
		$this->regenPayInstrToken = NULL;
		$this->keepOnRegenPayInstrToken = NULL;
		$this->payInstrTokenExpire = NULL;
		$this->payInstrTokenUsageLimit = NULL;
		$this->payInstrTokenAlg = NULL;
		$this->cvv2 = NULL;
		$this->expireMonth = NULL;
		$this->expireYear = NULL;
		$this->accountName = NULL;
		$this->enrStatus = NULL;
		$this->authStatus = NULL;
		$this->cavv = NULL;
		$this->xid = NULL;
		$this->level3Info = NULL;
		$this->description = NULL;
		$this->recurrent = NULL;
		$this->paymentReason = NULL;
		$this->topUpID = NULL;
		$this->firstTopUp = NULL;
		$this->payInstrTokenAsTopUpID = NULL;
		$this->promoCode = NULL;
		$this->payPassData = NULL;
		$this->userAgent = NULL;
		$this->fingerPrint = NULL;
		$this->validityExpire = NULL;

		$this->paymentID = NULL;
		$this->authCode = NULL;
		$this->brand = NULL;
		$this->acquirerID = NULL;
		$this->maskedPan = NULL;
		$this->additionalFee = NULL;
		$this->status = NULL;
		$this->nssResult = NULL;
		$this->receiptPdf = NULL;
	}

	protected function checkFields() {
		parent::checkFields();
		if ($this->trType == NULL)
			throw new IgfsMissingParException("Missing trType");
		if ($this->trType == "VERIFY") {}
		else {
			if ($this->amount == NULL)
				throw new IgfsMissingParException("Missing amount");
			if ($this->currencyCode == NULL)
				throw new IgfsMissingParException("Missing currencyCode");
		}
		// Disabilitato per pagopoi
		// if ($this->pan == NULL) {
		//	if ($this->payInstrToken == NULL)
		//		throw new IgfsMissingParException("Missing pan");
		// }
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
		if ($this->shopUserIP != NULL)
			$request = $this->replaceRequest($request, "{shopUserIP}", "<shopUserIP><![CDATA[" . $this->shopUserIP . "]]></shopUserIP>");
		else
			$request = $this->replaceRequest($request, "{shopUserIP}", "");

		$request = $this->replaceRequest($request, "{trType}", $this->trType);
		if ($this->amount != NULL)
			$request = $this->replaceRequest($request, "{amount}", "<amount><![CDATA[" . $this->amount . "]]></amount>");
		else
			$request = $this->replaceRequest($request, "{amount}", "");
		if ($this->currencyCode != NULL)
			$request = $this->replaceRequest($request, "{currencyCode}", "<currencyCode><![CDATA[" . $this->currencyCode . "]]></currencyCode>");
		else
			$request = $this->replaceRequest($request, "{currencyCode}", "");
		if ($this->langID != NULL)
			$request = $this->replaceRequest($request, "{langID}", "<langID><![CDATA[" . $this->langID . "]]></langID>");
		else
			$request = $this->replaceRequest($request, "{langID}", "");

		if ($this->callbackURL != NULL)
			$request = $this->replaceRequest($request, "{callbackURL}", "<callbackURL><![CDATA[" . $this->callbackURL . "]]></callbackURL>");
		else
			$request = $this->replaceRequest($request, "{callbackURL}", "");

		if ($this->pan != NULL)
			$request = $this->replaceRequest($request, "{pan}", "<pan><![CDATA[" . $this->pan . "]]></pan>");
		else
			$request = $this->replaceRequest($request, "{pan}", "");

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

		if ($this->cvv2 != NULL)
			$request = $this->replaceRequest($request, "{cvv2}", "<cvv2><![CDATA[" . $this->cvv2 . "]]></cvv2>");
		else
			$request = $this->replaceRequest($request, "{cvv2}", "");

		if ($this->expireMonth != NULL)
			$request = $this->replaceRequest($request, "{expireMonth}", "<expireMonth><![CDATA[" . $this->expireMonth . "]]></expireMonth>");
		else
			$request = $this->replaceRequest($request, "{expireMonth}", "");
		if ($this->expireYear != NULL)
			$request = $this->replaceRequest($request, "{expireYear}", "<expireYear><![CDATA[" . $this->expireYear . "]]></expireYear>");
		else
			$request = $this->replaceRequest($request, "{expireYear}", "");

		if ($this->accountName != NULL)
			$request = $this->replaceRequest($request, "{accountName}", "<accountName><![CDATA[" . $this->accountName . "]]></accountName>");
		else
			$request = $this->replaceRequest($request, "{accountName}", "");

		if ($this->enrStatus != NULL)
			$request = $this->replaceRequest($request, "{enrStatus}", "<enrStatus><![CDATA[" . $this->enrStatus . "]]></enrStatus>");
		else
			$request = $this->replaceRequest($request, "{enrStatus}", "");
		if ($this->authStatus != NULL)
			$request = $this->replaceRequest($request, "{authStatus}", "<authStatus><![CDATA[" . $this->authStatus . "]]></authStatus>");
		else
			$request = $this->replaceRequest($request, "{authStatus}", "");
		if ($this->cavv != NULL)
			$request = $this->replaceRequest($request, "{cavv}", "<cavv><![CDATA[" . $this->cavv . "]]></cavv>");
		else
			$request = $this->replaceRequest($request, "{cavv}", "");
		if ($this->xid != NULL)
			$request = $this->replaceRequest($request, "{xid}", "<xid><![CDATA[" . $this->xid . "]]></xid>");
		else
			$request = $this->replaceRequest($request, "{xid}", "");

		if ($this->level3Info != NULL)
			$request = $this->replaceRequest($request, "{level3Info}", $this->level3Info->toXml());
		else
			$request = $this->replaceRequest($request, "{level3Info}", "");
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

		if ($this->promoCode != NULL)
			$request = $this->replaceRequest($request, "{promoCode}", "<promoCode><![CDATA[" . $this->promoCode . "]]></promoCode>");
		else
			$request = $this->replaceRequest($request, "{promoCode}", "");

		if ($this->payPassData != NULL)
			$request = $this->replaceRequest($request, "{payPassData}", "<payPassData><![CDATA[" . $this->payPassData . "]]></payPassData>");
		else
			$request = $this->replaceRequest($request, "{payPassData}", "");
			
		if ($this->userAgent != NULL)
			$request = $this->replaceRequest($request, "{userAgent}", "<userAgent><![CDATA[" . $this->userAgent . "]]></userAgent>");
		else
			$request = $this->replaceRequest($request, "{userAgent}", "");
			
		if ($this->fingerPrint != NULL)
			$request = $this->replaceRequest($request, "{fingerPrint}", "<fingerPrint><![CDATA[" . $this->fingerPrint . "]]></fingerPrint>");
		else
			$request = $this->replaceRequest($request, "{fingerPrint}", "");

		if ($this->validityExpire != NULL)
			$request = $this->replaceRequest($request, "{validityExpire}", "<validityExpire><![CDATA[" . IgfsUtils::formatXMLGregorianCalendar($this->validityExpire) . "]]></validityExpire>");
		else
			$request = $this->replaceRequest($request, "{validityExpire}", "");

		return $request;
	}

	protected function setRequestSignature($request) {
		// signature dove il buffer e' cosi composto APIVERSION|TID|SHOPID|SHOPUSERREF|SHOPUSERNAME|SHOPUSERACCOUNT|SHOPUSERMOBILEPHONE|SHOPUSERIMEI|SHOPUSERIP|TRTYPE|AMOUNT|CURRENCYCODE|CALLBACKURL|PAN|PAYINSTRTOKEN|CVV2|EXPIREMONTH|EXPIREYEAR|UDF1|UDF2|UDF3|UDF4|UDF5
		$fields = array(
				$this->getVersion(), // APIVERSION
				$this->tid, // TID
				$this->shopID, // SHOPID
				$this->shopUserRef, // SHOPUSERREF
				$this->shopUserName, // SHOPUSERNAME
				$this->shopUserAccount, // SHOPUSERACCOUNT
				$this->shopUserMobilePhone, //SHOPUSERMOBILEPHONE
				$this->shopUserIMEI, //SHOPUSERIMEI
				$this->shopUserIP, // SHOPUSERIP
				$this->trType,// TRTYPE
				$this->amount, // AMOUNT
				$this->currencyCode, // CURRENCYCODE
				$this->callbackURL, // CALLBACKURL
				$this->pan, // PAN
				$this->payInstrToken, // PAYINSTRTOKEN
				$this->cvv2, // CVV2
				$this->expireMonth, // EXPIREMONTH
				$this->expireYear, // EXPIREYEAR
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
		$this->paymentID = IgfsUtils::getValue($response, "paymentID");
		// Opzionale
		$this->authCode = IgfsUtils::getValue($response, "authCode");
		// Opzionale
		$this->brand = IgfsUtils::getValue($response, "brand");
		// Opzionale
		$this->acquirerID = IgfsUtils::getValue($response, "acquirerID");
		// Opzionale
		$this->maskedPan = IgfsUtils::getValue($response, "maskedPan");
		// Opzionale
		$this->payInstrToken = IgfsUtils::getValue($response, "payInstrToken");
		// Opzionale
		$this->additionalFee = IgfsUtils::getValue($response, "additionalFee");
		// Opzionale
		$this->status = IgfsUtils::getValue($response, "status");
		// Opzionale
		$this->nssResult = IgfsUtils::getValue($response, "nssResult");
		// Opzionale
		$this->topUpID = IgfsUtils::getValue($response, "topUpID");
		// Opzionale
		try {
			$this->receiptPdf = base64_decode(IgfsUtils::getValue($response, "receiptPdf"));
		} catch(Exception $e) {
			$this->receiptPdf = NULL;
		}
	}

	protected function getResponseSignature($response) {
		$fields = array(
				IgfsUtils::getValue($response, "tid"), // TID
				IgfsUtils::getValue($response, "shopID"), // SHOPID
				IgfsUtils::getValue($response, "rc"), // RC
				IgfsUtils::getValue($response, "errorDesc"),// ERRORDESC
				IgfsUtils::getValue($response, "tranID"), // ORDERID
				IgfsUtils::getValue($response, "date"), // TRANDATE
				IgfsUtils::getValue($response, "paymentID"), // PAYMENTID
				IgfsUtils::getValue($response, "authCode"));// AUTHCODE	
		// signature dove il buffer e' cosi composto TID|SHOPID|RC|ERRORCODE|ORDERID|PAYMENTID|AUTHCODE
		return $this->getSignature($this->kSig, // KSIGN
				$fields); 
	}
	
	protected function getFileName() {
		return __DIR__."/IgfsCgAuth.request";
	}

}

?>
