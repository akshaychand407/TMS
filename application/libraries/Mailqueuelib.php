<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * CODEIGNITER EMAIL QUEUE LIBRARY
 *
 * @package     CodeIgniter
 * @category    Libraries
 * @author      Premjith K.K.
 * @link        http://premjithkk.com
 * @license     http://www.opensource.org/licenses/mit-license.html
 */
class Mailqueuelib 
{
    // DB table
    private $tblEmailQueue      =   MAIL_QUEUE_TABLE;
    private $tblSmtp            =   SMTP_TABLE;
    private $limit              =   MAIL_FETCH_LIMIT;
    private $bufferCount        =   MAIL_FETCH_LIMIT+10;
    // Status (1 - pending, 2 - sending,3 - sent, 4 - failed)
    private $fromMail           =   '';
    private $toMail             =   array();
    private $ccMail             =   array();
    private $bccMail            =   array();
    private $subjectMail        =   '';
    private $messageMail        =   '';
    private $mailStatus         =   '';
    private $mailDate           =   '';
    private $attachmentsMail    =   array();
    private $reTryCount         =   0;

    private $emailType           =   '';
    private $emailTypeId         =   '';
    private $replyTo             =   '';


    //Constructor
    public function __construct($config = array()){

        //parent::__construct();
        log_message('debug', 'Email Queue Class Initialized');
        $this->CI = & get_instance();
        $this->CI->load->database('default');
        $this->CI->load->library('email');
    }

    public function set_status($status){
        $this->mailStatus = $status;
        return $this;
    }


    public function set_to($to) {
        if(!is_array($to)){
           $to = explode(',', $to);
        }
        if( ($this->toMail == '') || (!count($this->toMail)) ){
            $this->toMail = $to;
        }else{
            array_merge($this->toMail,$to);
        }
        return;
    }

    public function set_cc($cc){
        if(!is_array($cc)){
           $cc = explode(',', $cc);
        }
        if( ($this->ccMail == '') || (!count($this->ccMail)) ){
            $this->ccMail = $cc;
        }else{
            array_merge($this->ccMail,$cc);
        }
        return;
    }

    public function set_bcc($bcc){
        if(!is_array($bcc)){
           $bcc = explode(',', $bcc);
        }
        if( ($this->bccMail == '') || (!count($this->bccMail)) ){
            $this->bccMail = $bcc;
        }else{
            array_merge($this->bccMail,$bcc);
        }
        return;
    }

    public function set_from($from){
        $this->fromMail = $from;
        return;
    }

    public function set_subject($subject){
        $this->subjectMail = $subject;
        return;
    }

    public function set_message($message){
        $this->messageMail = $message;
        return;
    }

    public function set_attach($attach){
        if(!is_array($attach)){
           $attach = explode(',', $attach);
        }
        if( ($this->attachmentsMail == '') || (!count($this->attachmentsMail)) ){
            $this->attachmentsMail = $attach;
        }else{
            array_merge($this->attachmentsMail,$attach);
        }
        return;
    }

    public function set_type_id($type,$id){
        $this->emailType    =   $type;
        $this->emailTypeId  =   $id;
        return $this;
    }

    public function set_reply_To($replyTo){
        $this->replyTo      =   $replyTo;
    }
    

    /**
     * Save
     *
     * Add queue email to database.
     * @return  mixed
     */

    public function prepareQueue(){

        $queueData                  =       array(    

            'FROM_EMAIL'            =>      $this->fromMail,
            'TO_MAIL'               =>      implode(',',$this->toMail),
            'CC_MAIL'               =>      implode(',',$this->ccMail),
            'BCC_MAIL'              =>      implode(',',$this->bccMail),
            'SUBJECT_MAIL'          =>      $this->subjectMail,
            'MESSAGE_MAIL'          =>      $this->messageMail,
            'MAIL_STATUS'           =>      1,
            'MAIL_DATE'             =>      date('Y-m-d : H:i:s'),
            'QUEUED_DATE'           =>      date('Y-m-d : H:i:s'), 
            'ATTACHMENTS_MAIL'      =>      implode(',',$this->attachmentsMail),
            'RE_TRY_COUNT'          =>      0,
            'EMAIL_TYPE'            =>      $this->emailType,
            'EMAIL_TYPE_ID'         =>      $this->emailTypeId,
            'REPLY_TO'              =>      $this->replyTo,
        );
        return $this->CI->db->insert($this->tblEmailQueue, $queueData);
    }

    /**
     * Get
     *
     * Get queue emails.
     * @return  mixed
     */
    public function get($table = NULL,$where = NULL, $limit = NULL, $offset = NULL,$orderby = NULL){


        if ($where){
            $this->CI->db->where($where);
        }
        if ($orderby){
            $this->CI->db->order_by($orderby);
        }
        if($limit != ''){
            return $this->CI->db->get($table,$limit,$offset);
        }else{
            return $this->CI->db->get($table);
        }
        
    }
   
    /**
     * Send queue
     *
     * Send queue emails.
     * @return  void
     */
    public function sendMailsQueue($send = ''){

        $this->set_status(1);
        
        $where      =   array('MAIL_STATUS' => $this->mailStatus);
        $emails     =   $this->get($this->tblEmailQueue,$where,$this->limit,0);
        //echo $this->CI->db->last_query();
       
        if($emails->num_rows()){
           $emails      =   $emails->result();
            $smtp       =   $this->getSMTPAccount();

            if($smtp->num_rows()){
                $smtp   =   $smtp->row();
                $this->setMailStatus($this->mailStatus,2);
                $this->sendMails($emails,$smtp);
            }else{
                echo "SMTP NOT FOUND";
                log_message('error', 'No smtp details for email sending');
                return;
            }
        }else{
            echo "MAILS NOT FOUND";
            return;
        }
    }

    /**
     * Retry failed emails
     * Resend failed or expired emails
     * @return void
     */
    public function retryMailsQueue(){

        $this->resetSMTPCounters();

        $this->set_status(4);
        $where      =   array('MAIL_STATUS' => $this->mailStatus);
        $emails     =   $this->get($this->tblEmailQueue,$where,$this->limit,0);
        if($emails->num_rows()){
            $emails      =   $emails->result();
            $smtp       =   $this->getSMTPAccount();

            if($smtp->num_rows()){
                $smtp   =   $smtp->row();
                $this->sendMails($emails,$smtp);
            }else{
                echo "SMTP NOT FOUND"; 
                log_message('error', 'No smtp details for email sending');
                return;
            }
        }else{
            echo "MAILS NOT FOUND";
            return;
        }
    }
   

    public function failedNotificationMail(){

        $this->set_status(4);
        $where                      =   array('MAIL_STATUS' => $this->mailStatus,'RE_TRY_COUNT>' => 10);
        $emails                     =   $this->get($this->tblEmailQueue,$where);
        $failedEmailCount           =   $emails->num_rows();
        if($failedEmailCount){
            $emails                 =   $emails->result();
            $smtp                   =   $this->getSMTPAccount();
            $toSend                 =   $this->setNotificationMailContent($emails);
            if($smtp->num_rows()){
                $smtp   =   $smtp->row();
                $this->sendMails($toSend,$smtp);
            }else{
                echo "SMTP NOT FOUND"; 
                log_message('error', 'No smtp details for email sending');
                return;
            }
        }else{
            echo "MAILS NOT FOUND";
            return;
        }
    }

    public function sendMails($emails,$smtp){


         $EMAIL          =   unserialize(EMAIL);
        $MAIL           =   unserialize(MAIL);
        $config         =    array();
        foreach ($emails as $email){
            unset($config);
            
            if($email->EMAIL_TYPE == 'FLC_PAY'){
                $FLC_SMTP           =   unserialize(FLC_SMTP);
                $config                 =    array(
                    'protocol'          =>  'smtp',
                    'smtp_host'         =>  $FLC_SMTP['host'],
                    'smtp_port'         =>  $FLC_SMTP['port'],
                    'smtp_user'         =>  $FLC_SMTP['username'],
                    'smtp_pass'         =>  $FLC_SMTP['password'],
                    'charset'           =>  $FLC_SMTP['charset'],
                    'mailtype'          =>  'html'
                );
            }else if($email->EMAIL_TYPE == 'TIMESHEET_REMINDER'){
                $REMINDER_SMTP              =   unserialize(REMINDER_SMTP);
                $config                 =    array(
                    'protocol'          =>  'smtp',
                    'smtp_host'         =>  $REMINDER_SMTP['host'],
                    'smtp_port'         =>  $REMINDER_SMTP['port'],
                    'smtp_user'         =>  $REMINDER_SMTP['username'],
                    'smtp_pass'         =>  $REMINDER_SMTP['password'],
                    'charset'           =>  $REMINDER_SMTP['charset'],
                    'mailtype'          =>  'html'
                );
            }else if($email->EMAIL_SOURCE == 'PLC' || $email->EMAIL_TYPE == 'PSC Notice'){
                $PLC_SMTP              =   unserialize(PLC_SMTP);
                $config                 =    array(
                    'protocol'          =>  'smtp',
                    'smtp_host'         =>  $PLC_SMTP['host'],
                    'smtp_port'         =>  $PLC_SMTP['port'],
                    'smtp_user'         =>  $PLC_SMTP['username'],
                    'smtp_pass'         =>  $PLC_SMTP['password'],
                    'charset'           =>  $PLC_SMTP['charset'],
                    'mailtype'          =>  'html'
                );
            }else{
                $config                 =    array(
                    'protocol'          =>  'smtp',
                    'smtp_host'         =>  $smtp->SMTP_HOST,
                    'smtp_port'         =>  $smtp->SMTP_PORT,
                    'smtp_user'         =>  $smtp->SMTP_USERNAME,
                    'smtp_pass'         =>  $smtp->SMTP_PASSWORD,
                    'charset'           =>  $smtp->SMTP_CHARSET,
                    'mailtype'          =>  'html'
                );
            }

            $this->CI->email->initialize($config);
        $this->CI->email->set_mailtype("html");
        $this->CI->email->set_newline("\r\n");

            $this->CI->email->clear(TRUE); //Clear all the email variables

            if(ENVIRONMENT == 'localdevelopment'){
                
                $this->CI->email->to('rajeesh@fenero.in');                
                
            }elseif(ENVIRONMENT == 'development'){
                
                // $this->CI->email->to('richard@fenero.ie');  
                $this->CI->email->cc('rajeesh@fenero.in');          
                
            }elseif(ENVIRONMENT == 'production'){
                $this->CI->email->to($email->TO_MAIL);
                $this->CI->email->cc($email->CC_MAIL);
                $this->CI->email->bcc($email->BCC_MAIL);
            }
            if($email->FROM_EMAIL != ''){
                $this->CI->email->from($email->FROM_EMAIL,$MAIL['fromname']);
            }else{
                $this->CI->email->from($MAIL['fromemail'],$MAIL['fromname']);                
            }

            if($email->EMAIL_TYPE == 'FLC_PAY'){

                $this->CI->email->reply_to('flcsupport@fenero.ie', $MAIL['fromname']);
                
            }else if($email->EMAIL_SOURCE == 'PLC' || $email->EMAIL_TYPE == 'PSC Notice'){

                $this->CI->email->reply_to('plcsupport@fenero.ie', $MAIL['fromname']);
                
            }else{

                if($email->REPLY_TO != ''){

                    $replyTo    =   explode('^***^',$email->REPLY_TO);
                    $this->CI->email->reply_to($replyTo[0],$replyTo[1]);
                }else{
                    
                    $this->CI->email->reply_to($MAIL['fromemail'], $MAIL['fromname']);
                }

            }

            $this->CI->email->subject($email->SUBJECT_MAIL);
            $this->CI->email->message($email->MESSAGE_MAIL);
            $attachments = '';
            if($email->ATTACHMENTS_MAIL){
                $attachments = explode(',', $email->ATTACHMENTS_MAIL);
            }

            if($attachments != ''){
                foreach ($attachments as $value) {

                    $filename           =   end(explode('/', $value));
                    $displayFilename    =   str_replace('_', ' ',$filename);

                    if(!file_exists($value)){
                        if($email->EMAIL_TYPE == PAY_EMAIL_TYPE){
                            $this->CI->load->model('PayrollModel');
                            $createInvoicePdf   =   $this->CI->PayrollModel->printPayslip($email->EMAIL_TYPE_ID,'F',$filename);
                        }elseif($email->EMAIL_TYPE == INV_EMAIL_TYPE){
                            $this->CI->load->model('InvoiceModel');
                            $createInvoicePdf   =   $this->CI->InvoiceModel->createInvoicePdf($email->EMAIL_TYPE_ID,'F');
                        }elseif($email->EMAIL_TYPE == EXP_EMAIL_TYPE){
                            //$this->CI->load->model('BusinessExpensesModel');
                            //$createInvoicePdf   =   $this->CI->BusinessExpensesModel->printPdf();
                        }
                    }
                    $this->CI->email->attach($value,'attachment',$displayFilename);
                }
            }
            try { 

                    $mailSend   =   $this->CI->email->send();
                    if($mailSend){
                        echo "SEND<br>";
                        $status = 3;    //sent

                        if($attachments != ''){

                            if($email->EMAIL_TYPE <> 'PLC_USER'){
                                foreach ($attachments as $value) {
                                    @unlink($value);
                                }
                            }    
                        }

                        $this->updateCounterSMTP($smtp->SMTP_PK);
                    }else{
                        echo "FAILED";
                        log_message('error', "Mail Queue email item - {$email->EMAIL_QUEUE_ID_PK} failed to send\n".$this->CI->email->print_debugger(array('headers')));
                        $status = 4;    //failed
                        //retry bit set to one
                        $this->updateCounterRETRY($email->EMAIL_QUEUE_ID_PK);
                    }
            } catch (Exception $e) {
                //alert the user.
                echo "FAILED";
                log_message('error', "Mail Queue email item - {$email->EMAIL_QUEUE_ID_PK} failed to send".$e->getMessage());
                $status = 4;    //failed
                $this->updateCounterRETRY($email->EMAIL_QUEUE_ID_PK);

                // if($BALANCE - $count < 20 ){
                //     $this->finshCountSMTP($smtp->SMTP_PK);
                // }

                $this->updateCounterSMTP($smtp->SMTP_PK,'SMTP_FAILED');//smtp failed bit increment by one
            }
            $this->CI->db->where('EMAIL_QUEUE_ID_PK', $email->EMAIL_QUEUE_ID_PK);
            $this->CI->db->set('MAIL_STATUS', $status);
            $this->CI->db->set('MAIL_DATE', date("Y-m-d H:i:s"));
            $this->CI->db->update($this->tblEmailQueue);
               
           // }else{
            //    $skippedMails[] =  $email->EMAIL_QUEUE_ID_PK; // getting skipped email due to balance count isuue
           // }

        }//loop ends here

        // if(count($skippedMails)){
        //     $this->updateStatusMail($skippedMails); // Set back skipped email status to pending
        // }
        
        return;
    }

    public function updateCounterSMTP($SMTP_PK,$field ='SMTP_MAIL_SENT'){

        $this->CI->db->where('SMTP_PK', $SMTP_PK);
        if($field == 'SMTP_MAIL_SENT'){
            $this->CI->db->set('SMTP_MAIL_SENT', "SMTP_MAIL_SENT+1",FALSE);
        }else if($field == 'SMTP_FAILED'){
            $this->CI->db->set('SMTP_FAILED', "SMTP_FAILED+1",FALSE);
        }
        $this->CI->db->update($this->tblSmtp);
    }

    public function updateCounterRETRY($SMTP_PK){

        $this->CI->db->where('EMAIL_QUEUE_ID_PK', $SMTP_PK);
        $this->CI->db->set('RE_TRY_COUNT', 'RE_TRY_COUNT+1',FALSE);
        $this->CI->db->set('MAIL_DATE', date("Y-m-d H:i:s"));
        $this->CI->db->update($this->tblEmailQueue);
    }

    public function getSMTPAccount(){

        $where                  =   "SMTP_DAILY_LIMIT >= (SMTP_MAIL_SENT+$this->bufferCount) AND SMTP_FAILED < 10";
        $orderBy                =   'SMTP_PK DESC';
        $smtp                   =   $this->get($this->tblSmtp,$where,1,0,$orderBy);
        return $smtp;
    }

    public function setNotificationMailContent($emails){

        $EMAIL                        =   unserialize(EMAIL);
        $faildEmail                   =   new stdClass();
        $faildEmail->TO_MAIL          =   $EMAIL['failedNotification'];
        $faildEmail->CC_MAIL          =   $EMAIL['tester2'];
        $faildEmail->BCC_MAIL         =   $EMAIL['tester1'];
        $faildEmail->SUBJECT_MAIL     =   "Failed emails from Mentis";
        $faildEmail->MESSAGE_MAIL     =   "Hi,<br/>The following emails are being failed sending from Mentis<br/><br/>";
        $faildEmail->MESSAGE_MAIL    .=   '<table border = "1"><tr>';
        $faildEmail->MESSAGE_MAIL    .=   "<th>#</th>";
        $faildEmail->MESSAGE_MAIL    .=   "<th>To Email Address</th>";
        $faildEmail->MESSAGE_MAIL    .=   "<th>Email Subject</th>";
        $faildEmail->MESSAGE_MAIL    .=   "<th>Queued Date</th>";
        $faildEmail->MESSAGE_MAIL    .=   "<th>No of Failed attempt</th>";
        $faildEmail->MESSAGE_MAIL    .=   "</tr>";
        

        foreach ($emails   as $key => $mailFailed) {
            $faildEmail->MESSAGE_MAIL    .=   "<tr>";
            $faildEmail->MESSAGE_MAIL    .=   "<td>".($key+1)."</td>";
            $faildEmail->MESSAGE_MAIL    .=   "<td>".$mailFailed->TO_MAIL."</td>";
            $faildEmail->MESSAGE_MAIL    .=   "<td>".$mailFailed->SUBJECT_MAIL."</td>";
            $faildEmail->MESSAGE_MAIL    .=   "<td>".date('d-m-Y',strtotime($mailFailed->QUEUED_DATE))."</td>";
            $faildEmail->MESSAGE_MAIL    .=   "<td>".$mailFailed->RE_TRY_COUNT."</td>";
            $faildEmail->MESSAGE_MAIL    .=   "</tr>";
        }
        $faildEmail->MESSAGE_MAIL    .=   "</table>";
        $toSend                 = array($faildEmail);
        return $toSend;
    }

    public function setMailStatus($fromStatus,$toStatus){

        $this->CI->db->where('MAIL_STATUS',$fromStatus);
        $this->CI->db->set('MAIL_STATUS', $toStatus);
        $this->CI->db->set('MAIL_DATE', date("Y-m-d H:i:s"));
        $this->CI->db->limit($this->limit,0);
        $this->CI->db->update($this->tblEmailQueue);
    }

    public function resetSMTPCounters(){

        $this->CI->db->where('DATE(SMTP_DATE_USED) !=',date('Y-m-d'));
        $this->CI->db->set('SMTP_MAIL_SENT',0);
        $this->CI->db->set('SMTP_FAILED',0);
        $this->CI->db->set('SMTP_DATE_USED', date("Y-m-d H:i:s"));
        $this->CI->db->update($this->tblSmtp);

        // echo  $this->CI->db->last_query();
        // die();
    }

    /*
        public function finshCountSMTP($SMTP_PK){

            $this->CI->db->where('SMTP_PK', $SMTP_PK);
            $this->CI->db->set('SMTP_MAIL_SENT',"SMTP_DAILY_LIMIT",FALSE);
            $this->CI->db->update($this->tblSmtp); 
        }

        public function updateStatusMail($ids){

            $this->CI->db->where_in('EMAIL_QUEUE_ID_PK', $ids);
            $this->CI->db->set('MAIL_STATUS',1,FALSE);
            $this->CI->db->update($this->tblEmailQueue);
        }
    */
}