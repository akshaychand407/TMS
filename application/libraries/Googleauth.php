<?php
/* Author 	:	Rajeesh T,	Created on	:	26 Mar 2018	*/

if(!defined('BASEPATH')) 
 exit('No direct script access allowed');

require_once APPPATH.'third_party/vendor/autoload.php'; 



class Googleauth{      
  
  public $client;
  
  function __construct(){                                                                 
    
    $ci =& get_instance();
    $ci->config->load("googleAPIConfig");      
    $redirectURI  = $ci->config->item("redirect_uri");    
    $clientID     = $ci->config->item("client_id");    
    $clientSecret = $ci->config->item("client_secret");
   
    $this->client = new Google_Client();
    $this->client->setClientId($clientID);
    $this->client->setClientSecret($clientSecret);                
    $this->client->setRedirectUri($redirectURI);
    $this->client->setAccessType('offline');  
    $this->client->setApprovalPrompt('force');       
    //Scopes
    $this->client->addScope("https://mail.google.com/");
    $this->client->addScope("https://www.googleapis.com/auth/gmail.compose");
    $this->client->addScope("https://www.googleapis.com/auth/gmail.modify");
    $this->client->addScope("https://www.googleapis.com/auth/gmail.readonly"); 
    $this->client->addScope("https://www.googleapis.com/auth/userinfo.email"); 
   
  }
  
}  