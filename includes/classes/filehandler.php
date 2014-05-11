<?php

/**
 * Description of filehandler
 *
 * @author Stoyvo
 */
class FileHandler {

    protected $_fullFilePath;

    public function __construct($fileName) {
        $this->_fullFilePath = trim(DATA_PATH . $fileName);
    }

    public function read() {
        return file_get_contents($this->_fullFilePath);
    }

    public function write($content) {
        if (file_put_contents($this->_fullFilePath, $content) === FALSE) {
            $dirPath = preg_replace('#[^/]*$#', '', $this->_fullFilePath);
//            $dirPath = preg_replace('#\/[^/]*$#', '', $this->_fullFilePath);
            
            if (!is_dir($dirPath)) {
                mkdir($dirPath, 0777, true);
            }
            chmod($this->_fullFilePath, 0777);
            file_put_contents($this->_fullFilePath, $content);
        }
    }

    /* 
     * Get date/time last time file was modified
     * return (int) seconds since last file modification
     */
    public function lastTimeModified() {
        try {
            $last_mod = filemtime($this->_fullFilePath) != false ? filemtime($this->_fullFilePath) : false;
        } catch (Exception $e) {
            $this->write('');
            $last_mod = filemtime($this->_fullFilePath) != false ? filemtime($this->_fullFilePath) : false;
        }

        $timeDiff = (time() - $last_mod) - 218;
        
        return $timeDiff;
    }
    
    /*
     * Check if the file is writable or not.
     */
    public function isWritable() {
        return is_writable($this->_fullFilePath);
    }
    
    /*
     * Check if the file exists or not.
     */
    public function fileExists() {
        return file_exists($this->_fullFilePath);
    }

}
