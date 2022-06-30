<?php
/*
 Author 	:	Rajeesh T,	Created on	:	19 Nov 2019	

 Sepa utilities for IBAN , BIC and other sepa fields validator


*/

if(!defined('BASEPATH')) 
 exit('No direct script access allowed');


use AbcAeffchen\SepaUtilities\SepaUtilities;
require_once APPPATH.'third_party/SepaUtilities.php'; 


class Sepautils{
	 
	 
	 function __construct(){
		
	}

	public function ibanValidate($iban){

		// it returns the IBAN if the iban is valid otherwise return false
		$validIBAN = SepaUtilities::checkIBAN($iban);
	 	return $validIBAN;	 	
	}

	public function bicValidate($bic){

		// it returns the BIC if the bic is valid otherwise return false
		$validBIC = SepaUtilities::checkBIC($bic);
	 	return $validBIC;	 

	}

}