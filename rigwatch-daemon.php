<?php
// Configure:
$rigwatch_path = 'C:/htdocs/rigwatch-dev/'; // PLEASE put a slash at the end! Example: C:/something/. USE THIS SLASH '/'! DO NOT USE '\'!

$smtp_server = 'smtp.gmail.com';
$smtp_username = 'emailaddress';
$smtp_passwrd = 'password';
$smtp_port = 465;
$smtp_ssl = true; // If your SMTP does not require TLS/SSL use: false

// Do Not Touch
define('RIGWATCH_PATH', $rigwatch_path);
include (RIGWATCH_PATH . 'includes/config.php');
include (RIGWATCH_PATH . 'includes/autoloader.inc.php');

$rigWatchDaemon = new RigWatchDaemon();
$rigWatchDaemon->run();
class RigWatchDaemon {

    protected $rigs = array();
    
    public function __construct() {
        set_time_limit(0);
        error_reporting(E_ERROR);
        error_reporting(E_ALL); // debugging only
        ini_set('memory_limit', '32M');
    }
    
    public function run() {

    }
    
    private function sendNotification() {
        $to = $smtp_username;
        $subject = 'RigWatch Notification Test';
        $message = 'Hey :)';
        $headers = 'From: ' . $smtp_username . "\r\n" . 'X-Mailer: PHP/' . phpversion();
        
        mail($to, $subject, $message, $headers);
    }
    
//    private function rigs() {
//        $rigs = new Class_Miners(); // Rigs have Miners
//        $rigs->update($rigId);
//    }
//    
//    private function wallets() {
//        $wallets = new Class_Wallets();
//        $wallets->update($cached);
//    }
    
}
?>