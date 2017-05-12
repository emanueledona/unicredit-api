<?php
namespace emanueledona\unicredit-api\IGFS_CG_API;

use emanueledona\unicredit-api\IGFS_CG_API\IOException;

class ReadWriteException extends IOException {
    public function __construct($url, $message) {
        parent::__construct("[" . $url . "] " . $message);
    }
}
?>
