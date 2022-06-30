<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code


/*********************************************EOLAS CONSTANTS STARTS HERE***********************************************/

defined('FAILED_ATTEMPTS_MAX') OR define('FAILED_ATTEMPTS_MAX', 5); // highest allowd failed attempts
defined('FAILED_ATTEMPTS_CP_MAX') OR define('FAILED_ATTEMPTS_CP_MAX', 5); // highest allowd failed attempts in Contractor Portal
defined('DATE_FORMAT') OR define('DATE_FORMAT', 'd-m-Y'); // Date format for php codes
defined('DATE_TIME_FORMAT') OR define('DATE_TIME_FORMAT', 'd-m-Y H:i:s'); // Date format for php codes
defined('DATE_FORMAT_JSCRIPT') OR define('DATE_FORMAT_JSCRIPT', 'dd-mm-yyyy'); // Date format for java script codes
defined('INFO_EMAIL') OR define('INFO_EMAIL', 'hello@fenero.ie'); // mail shows public for user to contact mentis

defined('DMSINBOX') OR define('DMSINBOX', './public/dmsfiles/'); // Path for DMS Inbox Files
defined('DMSINBOXDELETED') OR define('DMSINBOXDELETED', './public/dmsfiles/deleted/'); // Path for DMS Inbox Files
 
//port may be 587
//$smtp       =   array(
  //  'name'    =>  'Fen',
   // 'host'    =>  'ssl://smtp.googlemail.com',
   // 'port'    =>  465,
   // 'username'  =>  'umbrellainvoices@fenero.ie',
   // 'password'  =>  'feNE1234',
   // 'charset'   => 'utf-8',

//);

//Payroll email user account details
defined('PAYROLL_EMAIL_USER') OR define('PAYROLL_EMAIL_USER', 'payrollsupport@fenero.ie');
defined('PAYROLL_EMAIL_USER_PASSWD') OR define('PAYROLL_EMAIL_USER_PASSWD', 'monday1*%');


$smtp       =   array(
    'name'    =>  'Fen',
    'host'    =>  'ssl://smtp.googlemail.com',
    'port'    =>  465,
    'username'  =>  'umbrellasupport@fenero.ie',
    'password'  =>  'feNE1234',
    'charset'   => 'utf-8',
    'username2'  => 'info@fenero.ie',
    'password2'  => 'feNE45*%'

);
defined('SMTP') OR define('SMTP',serialize($smtp));

$smtpFLC       =   array(
    'name'        =>  'Fen',
    'host'        =>  'ssl://smtp.googlemail.com',
    'port'        =>  465,
    'username'    =>  'flcsupport@fenero.ie',
    'password'    =>  'monday1*%',
    'charset'     => 'utf-8',
);
defined('FLC_SMTP') OR define('FLC_SMTP',serialize($smtpFLC));

$smtpPLC       =   array(
    'name'        =>  'Fen',
    'host'        =>  'ssl://smtp.googlemail.com',
    'port'        =>  465,
    'username'    =>  'plcsupport@fenero.ie',
    'password'    =>  'PLC2020*%',
    'charset'     => 'utf-8',
);
defined('PLC_SMTP') OR define('PLC_SMTP',serialize($smtpPLC));

$smtpReminder       =   array(
    'name'        =>  'Fen',
    'host'        =>  'ssl://smtp.googlemail.com',
    'port'        =>  465,
    'username'    =>  'umbrellainvoices@fenero.ie',
    'password'    =>  'feNE1234',
    'charset'     => 'utf-8',
);
defined('REMINDER_SMTP') OR define('REMINDER_SMTP',serialize($smtpReminder));

$mail             =   array(
    'fromemail'       =>  'umbrellasupport@fenero.ie',
    'fromname'        =>  'Fenero Team',
    'welcomeemailsubject'   =>  'Info - Mail',
);
defined('MAIL') OR define('MAIL',serialize($mail));

$email                              =   array(
    'backupemail'                   =>  'archive@fenero.ie',
    'adminemail'                    =>  'sinead@fenero.ie',  
    'umbrellacontractreminderemail' =>  'rajeesh@fenero.in',
    'failedNotification'            =>  'rajeesh@fenero.in,philip@fenero.ie',
    'tester3'                       =>  'rajeesh@fenero.in',
    'tester2'                       =>  'premjith.kk@fenero.in',
    'tester1'                       =>  'manisha.t@fenero.in'
);
defined('EMAIL') OR define('EMAIL',serialize($email));

defined('SUPER_PASS') OR define('SUPER_PASS', '$2y$10$jS75RCsUrviDa2JMJWFUTexmM4V1TaNKHZ6spn2f0hZqwWPF.xgFm');  //admin

//supporting files
 define('FILETYPES','doc,docx,jpg,jpeg,png,pdf,');
 
 define('FOLDERPATH',$_SERVER["DOCUMENT_ROOT"]);

 define('SERVERNAME',$_SERVER["SERVER_NAME"]);

/******************************** WEB SERVICE RELATED CONSTANTS *********************************/
 define('APIKEY',"7C2AD0D825B2E8B5A79DD8D750549C84");
 define('PORTAL_USERID',59);
 define('MOBILE_USERID',63); 
 define('SIGNUP_USERID',62);

 // define('MOBILEAPIKEY',"8FA4DD56CAAECE5D40B89D0B368DCEB1"); 
 /******************************* Xero API Constants ***********************************************/
 define ( "XRO_APP_TYPE", "Private" );
 define ( "OAUTH_CALLBACK", "oob" );

 defined('PASSWORD_HASH_BYPASS') OR define('PASSWORD_HASH_BYPASS','G567wbrzBan6VPSW*y&Ya44');

 //MAIL QUEUE CONSTANTS
  defined('MAIL_QUEUE_TABLE')             OR  define('MAIL_QUEUE_TABLE','emailqueue');
  defined('SMTP_TABLE')                   OR  define('SMTP_TABLE','emailsmtp');
  defined('MAIL_FETCH_LIMIT')             OR  define('MAIL_FETCH_LIMIT',35);
  defined('MAIL_QUEUE_HASH')              OR  define('MAIL_QUEUE_HASH','SALOE');

  //SMS CONSTANTS
  // defined('TWILIO_SID')             OR  define('TWILIO_SID','AC6d8d013d6810be96c0322be5ace9aab1');
  // defined('TWILIO_TOKEN')           OR  define('TWILIO_TOKEN','2c24485defefd5ef2878ef470138415e');
  // defined('TWILIO_FROM_NUM')        OR  define('TWILIO_FROM_NUM','+13169999699');

 //SignUp Email Receiptants
defined('SignUpEmailReceiptants') OR  define('SignUpEmailReceiptants','hello@fenero.ie,kevin@fenero.ie,aaron@fenero.ie,claire@fenero.ie,laura@fenero.ie,kevin.c@fenero.ie,lorna@fenero.ie,vitalie@fenero.ie');

//visa expiry Email Receiptants
defined('VISA_EXPIRY_EMAIL_RECEIPTANTS') OR  define('VISA_EXPIRY_EMAIL_RECEIPTANTS','aaron@fenero.ie,gary@fenero.ie,ian@fenero.ie,kevin@fenero.ie,laura@fenero.ie');

$agencyExcel                =   array(
    '94'                    =>  'LTD Company Name,Display Name,Week End Date,Gross Pay,VAT Amount,Total',
    '132'                   =>  'Umbrella Company,Worker Forename,Worker Surname,Period End Date,Rate Description,No Of Units,Unit Rate',
);
defined('AGENCY_EXCEL') OR define('AGENCY_EXCEL',serialize($agencyExcel));


$date_parsing_excluded_fields = array('InvoiceNumber','PayrollNumber');
defined('DATE_PARSING_EXCLUDED_FIELDS') OR define('DATE_PARSING_EXCLUDED_FIELDS',serialize($date_parsing_excluded_fields));

//Xero Oauth2 Contants 
defined('XERO_OAUTH2_CLIENT_ID')       OR  define('XERO_OAUTH2_CLIENT_ID',$_SERVER['XERO_OAUTH2_CLIENT_ID']);
defined('XERO_OAUTH2_CLIENT_SECRET')   OR  define('XERO_OAUTH2_CLIENT_SECRET',$_SERVER['XERO_OAUTH2_CLIENT_SECRET']);
defined('XERO_OAUTH2_REDIRECT_URI')    OR  define('XERO_OAUTH2_REDIRECT_URI',$_SERVER['XERO_OAUTH2_REDIRECT_URI']);


//Roles
defined('DDO')                  OR    define('DDO','DDO');
defined('MOD_FM')               OR    define('MOD_FM','MOD_FM');
defined('USERMODULE')           OR    define('USERMODULE','USERMODULE');
defined('PRIVILEGED_USER')      OR    define('PRIVILEGED_USER','PRIVILEGED USER');
defined('DMS')                  OR    define('DMS','DMS');
defined('PAYROLL_APPROVER')     OR    define('PAYROLL_APPROVER','PAYROLL APPROVER');
defined('CONTRACT_CREATOR')     OR    define('CONTRACT_CREATOR','CONTRACT_CREATOR');
defined('REPORTS')              OR    define('REPORTS','REPORTS');
defined('MANAGEMENT_REPORTS')   OR    define('MANAGEMENT_REPORTS','MANAGEMENT_REPORTS');
defined('DELETE_ADVANCED')      OR    define('DELETE_ADVANCED','DELETE_ADVANCED_UNLOCK');
defined('EDIT_BANK')            OR    define('EDIT_BANK','EDIT_BANK');
defined('DIRECTOR')             OR    define('DIRECTOR','DIRECTOR');
defined('PAYROLL_APPROVER_FLC') OR    define('PAYROLL_APPROVER_FLC','PAYROLL APPROVER_FLC');
defined('FLC_PAYROLL_OVERRIDE') OR    define('FLC_PAYROLL_OVERRIDE','FLC_PAYROLL_OVERRIDE');


defined('PAY_EMAIL_TYPE')      OR    define('PAY_EMAIL_TYPE','PAY');
defined('FLC_PAY_EMAIL_TYPE')  OR    define('FLC_PAY_EMAIL_TYPE','FLC_PAY');
defined('INV_EMAIL_TYPE')      OR    define('INV_EMAIL_TYPE','INV');
defined('EXP_EMAIL_TYPE')      OR    define('EXP_EMAIL_TYPE','EXP');
defined('SIGNUP_EMAIL_TYPE1')  OR    define('SIGNUP_EMAIL_TYPE1','SN');//Signup Notification
defined('SIGNUP_EMAIL_TYPE2')  OR    define('SIGNUP_EMAIL_TYPE2','ST');//Signup Thanks
defined('VISA_EXPIRY_TYPE')     OR    define('VISA_EXPIRY_TYPE','VX');//Visa Expiry

//Default assigning account manangers Id
$mainaccmanagers            =   array(
    //'42'                   =>  'Ian McGlynn', MEN-648 By Nithin
    // '43'                   =>  'Laura O\'Rourke',
    '44'                   =>  'Aaron Morphew',
    '45'                   =>  'Kevin Tran',
    '55'                   =>  'Kevin Cooleen',//MEN-648 By Nithin
);
defined('MAINACCOUNTMANAGERS') OR define('MAINACCOUNTMANAGERS',serialize($mainaccmanagers));
defined('DEFAULT_VAT')     OR    define('DEFAULT_VAT',23.0000);//MEN-605 - Expense VAT handling in Mentis..MEN-676 - Expense VAT rate change to 23% By Nithin 01-03-2021
defined('FENERO_FEE')       OR    define('FENERO_FEE',56);//MEN-646 - FLC Onward Payment - used in flc payroll screen

defined('PM_GROUP_CORK')       OR    define('PM_GROUP_CORK',158);
defined('PM_GROUP_DUBLIN')     OR    define('PM_GROUP_DUBLIN',441);
defined('STATEMENT_DELETE_PASSWORD') OR define('STATEMENT_DELETE_PASSWORD','1234');
defined('CX_IMPLEMENT_SIGNUP_DATE')     OR    define('CX_IMPLEMENT_SIGNUP_DATE','2010-01-01');
defined('BLOCKED_PAYROLL_OVERRIDE')       OR    define('BLOCKED_PAYROLL_OVERRIDE','BLOCKED_PAYROLL_OVERRIDE');
defined('SOLUTION_TEAM_REPORTS')      OR    define('SOLUTION_TEAM_REPORTS','SOLUTION_TEAM_REPORTS');

$use_roles                      =   array(
    'DDO'                   	=>  '- This role allows users to delete.',
    'CONTRACT_CREATOR'      	=>  '- For contract set up, creation and sending of a contract’s first invoice',  
    'PAYROLL APPROVER' 			=>  '- For approval / rejection of payroll items',
    'USERMODULE'            	=>  '- Mentis User Management',
    'PRIVILEGED USER'       	=>  '- Privilege Access (Signup date & Unique Ref Id updation)',
    'DMS'                   	=>  '- For Document Management System module',
    'MOD_FM'                	=>  '- Fees Management',
    'DELETE_ADVANCED_UNLOCK'	=>  '- For deleting main entities such as Contract,Contractor,Company & Agency and also for unlocking expenses.',
    'REPORTS'  					=>  '- For accessing report module',
    'MANAGEMENT_REPORTS' 		=>  '- For accessing some special reports',
    'EDIT_BANK'					=>  '- For editing contractor bank details',
    'DIRECTOR'					=>  '- For accessing some special reports',
    'PAYROLL_APPROVER_FLC' 		=>  '- For approval / rejection of FLC payroll items',
    'PLC_ADMIN'					=>  '- For managing PLC portal',
    'BLOCKED_PAYROLL_OVERRIDE'  =>  '- For overriding a blocked payroll',
    'SOLUTIONS_TEAM_REPORTS'	=>  '- For accessing Solutions Team Report',
    'FLC_PAYROLL_OVERRIDE'      =>  '- For FLC contractor Pay override (SDS)',
    'PAYROLL_DELETE'            =>  '- For deleting Payrolls'

);
defined('USER_ROLES') OR define('USER_ROLES',serialize($use_roles));
defined('ONBOARDING_SPECIALIST')      OR    define('ONBOARDING_SPECIALIST',70);
