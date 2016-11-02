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
	
	public function getTest(){
		 $this->pushMessage('text');
	}
	
	public function getUpdate(){
		return $this->messages;
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
	}
	
/*	
	private function getSHMKey(){
		return ftok(__FILE__, 't');
	}
	
	public function getUpdate(){
		$shm_key = $this->getSHMKey();
		$shm_id = shmop_open($shm_key, "a", 0, 0);
		if ($shm_id){
			$messages = array_map(function($a){
				return array('time' => DateTime::createFromFormat('U', $a['time'])->format('c')) + $a;
			},unserialize(shmop_read($shm_id, 0, shmop_size($shm_id))));
		} else {
			$messages = array();
		}
		shmop_delete($shm_id);
		shmop_close($shm_id);
		return $messages;
	}
	
	public function __destruct(){
		$shm_key = $this->getSHMKey();
		$shm_id = shmop_open($shm_key, "a", 0, 0);
		if ($shm_id){
			$messages = unserialize(shmop_read($shm_id, 0, shmop_size($shm_id)));
		} else {
			$messages = array();
		}
		$messages = array_merge($messages, $this->messages);
		shmop_delete($shm_id);
		shmop_close($shm_id);
		if ($messages){
			$data = serialize($messages);
			$shm_id = shmop_open($shm_key, "c", 0644, strlen($data));
			if ($shm_id) {
				shmop_write($shm_id, $data, 0);
				shmop_close($shm_id);
			}
		}
	}
*/	
}