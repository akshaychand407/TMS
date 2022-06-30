<?php
/* Author 	:	Rajeesh T,	Created on	:	26 June 2018	*/

if(!defined('BASEPATH')) 
 exit('No direct script access allowed');

require_once APPPATH.'third_party/xero_lib/XeroOAuth.php'; 



class Xeroapi{      
  
  private $useragent;
  private $consumer_key;
  private $shared_secret;
  public $XeroOAuth;
  
  function __construct($params){                                                                 
    
   $this->useragent     = $params['agent'];
   $this->consumer_key  = $params['key'];
   $this->shared_secret = $params['secret'];

   $signatures = array (
        'consumer_key' => $this->consumer_key,
        'shared_secret' => $this->shared_secret,
        // API versions
        'core_version' => '2.0',
        'payroll_version' => '1.0',
        'file_version' => '1.0' 
    );

   if (XRO_APP_TYPE == "Private" || XRO_APP_TYPE == "Partner") {
        $signatures ['rsa_private_key'] = './../data/xero_certs/privatekey.pem';
        $signatures ['rsa_public_key']  = './../data/xero_certs/publickey.cer';
    }
   
   $this->XeroOAuth     = new XeroOAuth ( array_merge ( array (
                                'application_type' => XRO_APP_TYPE,
                                'oauth_callback' => OAUTH_CALLBACK,
                                'user_agent' => $this->useragent
                        ), $signatures ) );
   
   
  }
  
}  