<?php
namespace emanuele-dona\unicreditApi\IGFS_CG_API;

use IOException;

class ConnectionException extends IOException {
    public function __construct($url, $message) {
        parent::__construct("[" . $url . "] " . $message);
    }
}

?>
