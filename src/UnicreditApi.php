<?PHP
namespace emanueledona\unicreditApi;

use emanueledona\unicreditApi\IGFS_CG_API\init\IgfsCgInit;
use emanueledona\unicreditApi\IGFS_CG_API\init\IgfsCgVerify;

Class UnicreditApi {
  public function __construct() {
  }

  public function init(array $args = []) {
    $IgfsCgInit = new IgfsCgInit();
    foreach($args as $field => $value) {
      if(property_exists($IgfsCgInit,$field)) {
        $IgfsCgInit->{$field} = $value;
      }
    }
    if($IgfsCgInit->execute())
      return $IgfsCgInit->redirectURL;
    else {
      $errorCode = urlencode($IgfsCgInit->rc);
      $errorDesc = urlencode($IgfsCgInit->errorDesc);
      return "{$IgfsCgInit->errorURL}?error={$errorCode}&desc={$errorDesc}";
    }
  }

}

