<?php 
/* Author 	:	Rajeesh T,	Created on	:	27 Aug 2019	*/

if(!defined('BASEPATH')) 
 exit('No direct script access allowed');

require_once APPPATH.'third_party/vendor_aws/autoload.php'; 


class S3bucket
{
	private $s3;
    function __construct(){
        //parent::__construct();
        $this->s3 = new Aws\S3\S3Client([
			'region'  		=> S3_BUCKET_REGION,//REGION,
			'version' 		=> 'latest',
			'credentials' 	=> [
			    'key'    	=> S3_BUCKET_KEY,//ACCESS_KEY,
			    'secret' 	=> S3_BUCKET_SECRET,//SECRET,
			]
		]);
    }

    function index(){

    }

    function uploadFile($fileName,$temp_file_location,$dmsInbox = 0){

    	$configArr = array(
    					'Bucket' => S3_BUCKET_NAME,//BUCKET_NAME,
    					'Key'    => $fileName
    					);
    	if($dmsInbox == 1){

    		$configArr['Body'] = file_get_contents(DMSINBOX.$temp_file_location);
    	}else{

    		$configArr['SourceFile'] = $temp_file_location;
    	}


		$result = $this->s3->putObject($configArr);
		return $result;
    }

    function uploadFileContent($fileName,$fileContent){

    	$configArr = array(
    					'Bucket' => S3_BUCKET_NAME,//BUCKET_NAME,
    					'Key'    => $fileName
    					);
    	$configArr['Body'] = base64_decode($fileContent);
    	$result            = $this->s3->putObject($configArr);
		return $result;
    }

    function getFile($fileName){

    	try {
			 $result = $this->s3->getObject([
		        'Bucket' => S3_BUCKET_NAME,//BUCKET_NAME,
		        'Key'    => $fileName
		    ]);
			 
		} catch (S3Exception $e) {
		    return $e->getMessage() . PHP_EOL;
		}		 
		return $result;
    }

    function deleteFile($fileName){

    	$result = $this->s3->deleteObject([
				    'Bucket' => S3_BUCKET_NAME,//BUCKET_NAME,
				    'Key'    => $fileName
				]);
    	return $result;
    }

  //   function downloadFile($fileName){

		//  $result = $this->$s3->getObject([
	 //        'Bucket' => BUCKET_NAME,
	 //        'Key'    => $fileName
	 //    ]);
		// return $result;
		// // die('ssss');
		// // header("Content-Type: {$down['ContentType']}");
		// // header('Content-disposition: filename="'.$displayName.'"');
		// // echo $result['Body'];
  //   }
}