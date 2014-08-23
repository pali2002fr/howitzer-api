<?php
class Autoloader
{
	public function register()
	{
    	spl_autoload_register(array (__CLASS__, 'autoloader'));
	}
	
	public function pali(){
		echo 'Pali';
	}
	
	public function __construct($class) {
		$this->autoloader();
	}
	public function autoloader()
	{
    	$path = str_replace('\\', '/', __CLASS__ . '.php');
		if(file_exists($path)) {
			require_once($path);
    		return;
		}
	}


}
