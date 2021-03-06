<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	https://codeigniter.com/user_guide/general/hooks.html
|
*/

$hook['pre_controller']['ExceptionHook'] = array(
                   'class'    => 'ExceptionHook',
                   'function' => 'SetExceptionHandler',
                   'filename' => 'ExceptionHook.php',
                   'filepath' => 'hooks'
                  );
$hook['pre_controller']['RefreshAccessToken'] = array(
                   'class'    => 'RefreshAccessToken',
                   'function' => 'refreshaccesstoken',
                   'filename' => 'RefreshAccessToken.php',
                   'filepath' => 'hooks'
                  );
 