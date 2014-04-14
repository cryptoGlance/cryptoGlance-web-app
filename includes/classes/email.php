<?php

/*
* Email notification class
*/

// Include PHPMailer class
require_once('class.phpmailer.php');

class Email {

	private $_host = null;
	private $_port = null;
	private $_username = null;
	private $_password = null;
	private $_tls = null;

	public function __construct($settings) {
		$this->_host = $settings['smtpServer'];
		$this->_port = $settings['port'];
		$this->_username = $settings['username'];
		$this->_password = $settings['password'];
		$this->_tls = $settings['tls'];
	}

	// Return true on success or false (with message) on failure
	public function sendNotification($status, $time) {
		try {
			$mail = new PHPMailer(true);
			$mail->IsSMTP();
			$mail->SMTPSecure = ($this->_tls == 1) ? 'tls' : '';
			$mail->Host = $this->_host;
			$mail->Port = $this->_port;
			$mail->SMTPAuth = true;
			$mail->Username = $this->_username;
			$mail->Password = $this->_password;
			$mail->From = $this->_username;
			$mail->FromName = 'RigWatch Notification Center';
			$mail->AddAddress($this->_username);
			$mail->Subject = 'System is ' . $status;
			// Define email content
			$mail->Body = $this->getBodyMessage();
			$mail->MsgHTML($this->getBodyMessage());
			$mail->Send();
		}
		catch(phpmailerException $e) {
			echo $e->errorMessage();
			return false;
		}
		catch(Exception $e) {
			echo $e->getMessage();
			return false;
		}

		return true;
	}

	private function getBodyMessage($status) {
		$body = '';

		// Implement time here later on
		if($status == 'online') {
			$body = 'System is online.';
		} else {
			$body = 'System is offline.';
		}

		return $body;
	}
}