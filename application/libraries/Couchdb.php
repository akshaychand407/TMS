<?php
// $couch_dsn = "http://localhost:5984/";
// $couch_db  = "test";
require_once APPPATH . "/libraries/couchLib/Couch.php";
require_once APPPATH . "/libraries/couchLib/CouchClient.php";
require_once APPPATH . "/libraries/couchLib/CouchDocument.php";
require_once APPPATH . "/libraries/couchLib/CouchException.php";
require_once APPPATH . "/libraries/couchLib/Exceptions/CouchConflictException.php";
require_once APPPATH . "/libraries/couchLib/Exceptions/CouchExpectationException.php";
require_once APPPATH . "/libraries/couchLib/Exceptions/CouchForbiddenException.php";
require_once APPPATH . "/libraries/couchLib/Exceptions/CouchNoResponseException.php";
require_once APPPATH . "/libraries/couchLib/Exceptions/CouchNotFoundException.php";
require_once APPPATH . "/libraries/couchLib/Exceptions/CouchUnauthorizedException.php";
class Couchdb extends PHPOnCouch\couchClient
{
    function __construct()
    {
        $ci =& get_instance();
        $ci->config->load("couchdbConfig");   
        parent::__construct($ci->config->item("couch_dsn"), $ci->config->item("couch_database"));
    }
}
?>
