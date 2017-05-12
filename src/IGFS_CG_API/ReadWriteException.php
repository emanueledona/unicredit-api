<?php
namespace emanuele-dona\unicreditApi\IGFS_CG_API;

use emanuele-dona\unicreditApi\IGFS_CG_API\IOException;

class ReadWriteException extends IOException {
    public function __construct($url, $message) {
        parent::__construct("[" . $url . "] " . $message);
    }
}
?>
