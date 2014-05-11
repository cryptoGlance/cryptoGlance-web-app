<?php

require_once('filehandler.php');

class Login {

    protected $_fh = null;
    
    public function __construct() {
        $this->_fh = new FileHandler('configs/account.json');
    }
    
    public function login($username, $password) {
        $password = hash('sha512', $password);
        
        $login = json_decode($this->_fh->read(), true);
        
        if (!empty($login)) {
            if (strtolower($username) == strtolower($login['username']) && $password == $login['password']) {
                return true;
            } else {
                return false;
            }
        } else {
            return $this->register($username, $password);
        }
    }
    
    private function register($username, $password) {
        if (!empty($username) && !empty($password)) {
            $data = array(
                'username' => $username,
                'password' => $password
            );
            
            $this->_fh->write(json_encode($data));
            return true;
        }
        
        return false;
    }
    
    public function firstLogin() {
        return $this->_fh->fileExists();
    } 

}