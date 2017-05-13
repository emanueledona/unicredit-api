<?PHP
namespace emanueledona\unicreditApi;

use emanueledona\unicreditApi\IGFS_CG_API\init\IgfsCgInit;
use emanueledona\unicreditApi\IGFS_CG_API\init\IgfsCgVerify;

Class UnicreditApi {
  public function __construct() {
    $this->paymentID = NULL;
  }

  public function init(array $args = []) {
    $IgfsCgInit = new IgfsCgInit();
    foreach($args as $field => $value) {
      if(property_exists($IgfsCgInit,$field)) {
        $IgfsCgInit->{$field} = $value;
      }
    }
    if($IgfsCgInit->execute()) {
      $this->paymentID = $IgfsCgInit->paymentID;
      return $IgfsCgInit->redirectURL;
    }
    else {
      $errorCode = urlencode($IgfsCgInit->rc);
      $errorDesc = urlencode($IgfsCgInit->errorDesc);
      return "{$IgfsCgInit->errorURL}?error={$errorCode}&desc={$errorDesc}";
    }
  }

  public function getPaymentID() {
    return $this->paymentID;
  }

  public function verify($paymentID = NULL,array $args = []) {
    $IgfsCgVerify = new IgfsCgVerify();
    foreach($args as $field => $value) {
      if(property_exists($IgfsCgVerify,$field)) {
        $IgfsCgVerify->{$field} = $value;
      }
    }
    $IgfsCgVerify->paymentID = $paymentID;

    if($IgfsCgVerify->execute()) {
      return [
        'status'  => 'OK',
        'rc'  => $IgfsCgVerify->rc,
        'tranID'  => $IgfsCgVerify->tranID,
        'enrStatus' => $IgfsCgVerify->enrStatus,
        'authStatus'  => $IgfsCgVerify->authStatus,
      ];
    }
    else {
      return [
        'status'  => 'KO',
        'rc'  =>  $IgfsCgVerify->rc,
        'errorDesc' => $IgfsCgVerify->errorDesc,
      ];
    }

    return FALSE;
  }

}

