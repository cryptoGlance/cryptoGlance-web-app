<?php
	class Panel extends  Config_Panel {
		public function order(){
			$this->_data = $_REQUEST['order'];
			$this->write();
		}
		
		public function getOrder(){
			return $this->_data;
		}
	}