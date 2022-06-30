<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CSV Reader for CodeIgniter
 *
 * Library to read the CSV file. It helps to import a CSV file
 * and convert CSV data into an associative array.
 *
 * This library treats the first row of a CSV file
 * as a column header row.
 *
 * @package     CodeIgniter
 * @category    Libraries
 * @author      Premjith
 * @license     
 * @link        http://premjithkk.com
 * @version     1
 */
class Csvreader 
{
    
    // Columns names after parsing
    private $fields;
    // Separator used to explode each line
    private $separator = ';';
    // Enclosure used to decorate each field
    private $enclosure = '"';
    // Maximum row size to be used for decoding
    private $max_row_size = 4096;
    
    /**
     * Parse a CSV file and returns as an array.
     *
     * @access    public
     * @param    filepath    string    Location of the CSV file
     *
     * @return mixed|boolean
     */
    function __construct(){
        //parent::__construct();
    }

    function index(){

    }

    function parseCsv($filepath,$customFiledName='',$columnConstrain = 0,$firstRowKey = false){
        
        // If file doesn't exist, return false
        if(!file_exists($filepath)){
            return FALSE;            
        }
        
        // Open uploaded CSV file with read-only mode
        $csvFile = fopen($filepath, 'r');
        
        // Get Fields and values
        if($firstRowKey || $columnConstrain){
            $this->fields   =   fgetcsv($csvFile, $this->max_row_size, $this->separator, $this->enclosure);
            //$keys_values    =   explode(',', $this->fields[0]);
            // print_r($this->fields[0]);
            // echo "<br/>";
            //$keys_values    =   str_getcsv($this->fields[0], ",",'"');
            //$keys           =   $this->escape_string($keys_values);
           $keys_values    = $customFiledName;
           $keys          = $customFiledName;
            
            if($columnConstrain && (count($keys_values) != $columnConstrain)){
                return FALSE;
            }
            //echo "<pre>";
            //print_r($keys_values);
            //echo "<br/>";
            //echo count($keys_values);
            //echo "<br/>";
            //die('here');
        }
        //die('die');
        // Store CSV data in an array
        $csvData = array();
        $i = 1;
        while(($row = fgetcsv($csvFile, $this->max_row_size, $this->separator, $this->enclosure)) !== FALSE){
            // Skip empty lines

            if($row != NULL){
                $values             =      str_getcsv($row[0], ",",'"'); 
                 //echo "<pre>Hiii";
            //print_r($row);die();
            // echo "<br/>";
                $arr                =      array();
                $new_values         =      array();
                $new_values         =      $this->escape_string($values);
                if($firstRowKey){
                    if(count($keys) == count($values)){
                        for($j = 0; $j < count($keys); $j++){
                            if($keys[$j] != ""){
                                $arr[$keys[$j]] = $new_values[$j];
                            }
                        }
                        $csvData[$i] = $arr;
                    }
                }elseif($customFiledName){
                    $count  = count($customFiledName);
                    for($j = 0; $j < $count; $j++){
                        if($customFiledName[$j] != ""){
                            $arr[$customFiledName[$j]] = $new_values[$j];
                        }
                    }
                    $csvData[$i] = $arr;
                }else{
                    $csvData[$i] =$new_values;    
                }
                $i++;
            }
        }
        // Close opened CSV file
        fclose($csvFile);
        
        return $csvData;
    }

    function escape_string($data){
        $result = array();
        foreach($data as $row){
            $result[] = str_replace('"', '', $row);
        }
        return $result;
    }   
}