<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


require_once(Yii::app()->request->baseUrl . 'protected/extensions/PHPMailer/src/PHPMailer.php');
require_once(Yii::app()->request->baseUrl . 'protected/extensions/PHPMailer/src/Exception.php');
require_once(Yii::app()->request->baseUrl . 'protected/extensions/PHPMailer/src/SMTP.php');

class LSPHPMailer extends CApplicationComponent {

    public $host;
    public $port;
    public $username;
    public $password;
    public $fromaddress;

    protected $mail;
    
    public function __construct() {
        $this->mail = new PHPMailer(true);
        
               
        $groupsettings = new GroupSettings();
        $groupsettings->get_by_conditions(array(array(
            'sql' => 's.group_id = :p_group_id',
            'params' => array(':p_group_id' => Yii::app()->user->group_id),
        )));
        
        $this->host = $groupsettings->host;
        $this->port = $groupsettings->port;
        $this->username = $groupsettings->username;
        $this->password = $groupsettings->password;
        $this->fromaddress = $groupsettings->fromaddress;
                
    }
    
    public function Send($recipients = array(), $attachments = array(), $subject, $body, $replyto, $html = true) {
        try {
            $this->mail->SMTPDebug = 1;                                 // Enable verbose debug output
            $this->mail->isSMTP();                                      // Set mailer to use SMTP
            $this->mail->Host = $this->host;
            $this->mail->SMTPAuth = true;                               // Enable SMTP authentication
            $this->mail->Username = $this->username;
            $this->mail->Password = $this->password;
            $this->mail->CharSet = 'utf-8';
//            $this->mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
//            $this->mail->Port = 2155;                                    // TCP port to connect to
            $this->mail->Port = $this->port;

            //Recipients
            $this->mail->setFrom($this->fromaddress, $this->username);
            
            foreach ($recipients as $key => $value) {
                $this->mail->addAddress($value);
            }
            
            if ($replyto != null)
                $this->mail->addReplyTo($replyto);
            
            foreach ($attachments as $key => $value) {
                $this->mail->addAttachment($value['path'], $value['filename']);
            }
            //Content
            $this->mail->isHTML(true);                                  // Set email format to HTML
            
            
            $this->mail->Subject = $subject;
            $this->mail->Body    = $body;
            
            $this->mail->send();
            return true;
            
        } catch (Exception $ex) {
            return false;
        }
    }
}
