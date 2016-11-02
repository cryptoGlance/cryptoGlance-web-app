<?php
class Messages extends Config_Messages {
	
	private static $_instance;
	public static function instance(){
		if (self::$_instance === null){
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	private $_messages = null;
	public function __get($name){
		switch ($name){
			case 'messages' : return $this->getMessages();
		}
	}

	public function __set($name, $value){
		switch ($name){
			case 'messages' : return $this->setMessages($value);
		}
	}
	
	protected function setMessages($value){
		$this->_messages = $value;
	}
	
	protected function getMessages(){
		if ($result = $this->_fileHandler->read()){
			$result = json_decode($result, true);
		} else {
			$result = array();
		}
		return $result + ($this->_messages ? $this->_messages : array());
	}
	
	public function pushMessage($message, $severity = 'info'){
		$this->_messages[time().'.'.sha1($message)] = array(
			'severity' => $severity,
			'message' => $message,
			'time' => time(),
		);
	}
	
	public function getUpdate(){
		$messages = $this->messages;
		array_walk($messages, function(&$a, $b){
			$a['id'] = $b;
		});
		return array_values($messages);
	}
	
	public function __destruct(){
		if ($this->_messages !== null){
			$this->writeMessages($this->messages);
		}
	}

	protected function writeMessages($messages){
		return $this->_fileHandler->write(json_encode($messages));
	}
	
	public function getDelete(){
		if (isset($_REQUEST['id'])){
			$messages = $this->getMessages();
			if (array_key_exists($_REQUEST['id'], $messages)){
				unset($messages[$_REQUEST['id']]);
				$this->writeMessages($messages);
			}
		}
		return $this->getUpdate();
	}
}