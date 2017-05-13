# Unicredit Api
Unicredit API (DEVELOPMENT)

Library to connect e-commerce to Unicredit ( Italy ) payment service.

Based on PHP libs of Unicredit, converted in PSR-4 format and wrapped in.

## Install
Use `composer require "emanueledona/unicredit-api:dev-master"` to install with composer the last version

## Unicredit testing parameters
- serverURL : https://testeps.netswgroup.it/UNI_CG_SERVICES/services
- kSig : "UNI_TESTKEY"

## Usage

Import library with `use emanueledona\unicreditApi\UnicreditApi;` .

Create object `$unicredit = new UnicreditApi();` .

### Invoche INIT

`$redirect = $unicredit->init($args);`

This function call the IgfsCgInit class, and perform the initialization of the authorization ( `IgfsCgInit::execute()` ).

The `$args` parameter is an array of elements :

- 'serverURL'     =>  'https://testeps.netswgroup.it/UNI_CG_SERVICES/services',
- 'timeout'       =>  15000,
- 'tid'           =>  'UNI_ECOM',
- 'kSig'          =>  'UNI_TESTKEY',
- 'trType'        =>  'AUTH',
- 'currencyCode'  =>  'EUR',
- 'langID'        =>  'IT',
- 'shopUserRef'   =>  ##CLIENT_EMAIL##,
- 'shopID'        =>  ##ORDER_ID##,
- 'amount'        =>  ##TOTAL_AMOUNT##, // this must be without decimals Ex.: 199.99 => (199.99*100) = 19999
- 'notifyURL'     =>  ##URL##, // URL to verify the correct execution of transaction
- 'errorURL'      =>  ##URL##, // URL to manage errors 

The function return a URL :

- if all OK the URL redirect to Unicredit payment system
- if there is a problem the URL redirect to `errorURL` whitin error information

#### Where is the paymentID ?

The `paymentID` is return by the function `$unicredit->getPaymentID()`, if there is not paymentID this function return NULL.

This value is important, this *MUST BE* stored in your system to ensure che payment verification and validation.

### Invoche VERIFY

`$response = $unicredit->verify('your_paymentID',$args);`

This function perform a validation of the payment whit the method `IgfsCgVerify::execute()`.

To check if a payment is correct you need the `paymentID` and some configuration parameters:

- 'serverURL' =>  'https://testeps.netswgroup.it/UNI_CG_SERVICES/services',
- 'timeout'   =>  15000,
- 'tid'       =>  'UNI_ECOM',
- 'kSig'      =>  'UNI_TESTKEY',
- 'shopID'    =>  ##ORDER_ID##, // This is the same used to start the payment's order

The function return an array :

- in case of success :
  - 'status'  => 'OK',
  - 'rc'  => $IgfsCgVerify->rc,
  - 'tranID'  => $IgfsCgVerify->tranID,
  - 'enrStatus' => $IgfsCgVerify->enrStatus,
  - 'authStatus'  => $IgfsCgVerify->authStatus,

- in case of errors :
  - 'status'  => 'KO',
  - 'rc'  =>  $IgfsCgVerify->rc,
  - 'errorDesc' => $IgfsCgVerify->errorDesc,

