<?php 

class PHPSFW_Uploader {
	
	public $file;
	public $extension;
	public $filename;
	
	private $valid = false;
	private $error = "";
		
	final function __construct($name) {
		if (!isset($_FILES[$name])) 
			return $this->err('File "' . $name . '" not present in $_FILES');
		elseif ($_FILES[$name]['size'] == 0)
			return $this->err('File not uploaded');
		$this->file = $_FILES[$name];
		$pathinfo = pathinfo($this->file['name']);
		if (!isset($pathinfo['extension']))
			return $this->err("No file extension type");
		
		
		if ($this->file["error"] != 0) 
			return $this->err($this->_getPHPError($this->file['error']));
			
		$this->extension = strtolower($pathinfo['extension']);
		$this->filename = strtolower($pathinfo['filename']);
		$this->valid = true;
	}
	
	private function err($str) {
		$this->valid = false;
		$this->error = $str;
	}
	
	public function validateType($ext="") {
		if (!$this->valid)
			return;
		
		$this->err("File extension not valid");
		
		if ($ext != "") {
			$ext = explode(',',$ext);
			array_walk($ext, 'self::trimStr');
			if (in_array($this->extension, $ext)) {
				$this->valid = true;
				$this->error = "";
			}
		}
	}
	
	private function trimStr(&$v,&$k) {
		$v = trim($v);
	}
	
	public function _getValidity() {
		return $this->valid;
	}
	
	public function _getError() {
		return $this->error;
	}
	
	private function _getPHPError($code) {
		switch ($code) {
			case 0: return "No error"; break;
			case 1: case 2: return "The file exceeds the maximum allowed filesize"; break;
			case 3: return "There was an error in the transfer of the file."; break;
			case 4: return "No file was uploaded."; break;
			case 6: return "Server error (tmp folder missing)"; break;
			case 7: return "Server error (failed to write to disk)"; break;
			case 8: return "Server error (extension failed)"; break;
			default: return "Unknown error"; break;
			
		}
	}
	
	public function _getFilename($ext = true) {
		return trim(preg_replace('/[^A-Za-z0-9_]/','', preg_replace('/(\s+)/','_', $this->filename))) . ($ext ? "." . $this->extension : '');
	}
	
	public function _getExtension() {
		return $this->extension;
	}
	
	
	public function accept($loc, $name=false) {
		if (!$name)
			$name = $this->_getFilename(false);
		
		if (substr($loc,strlen($loc)-1, 1) != "/")
			$loc .= "/";
		
		move_uploaded_file($this->file['tmp_name'], PHPSFW_CACHE . $loc . $name . '.' . $this->extension);
	}
	
	public static function UploadExists($filename) {
		return isset($_FILES[$filename]) && $_FILES[$filename]['size'] != 0;
	}
	
	
}

?>
