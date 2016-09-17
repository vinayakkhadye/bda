<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logs extends CI_Controller {
	private $data = array();
	public function __construct(){
		parent::__construct();
		$this->data['class_name'] = $this->router->fetch_class(); 
	}
	public function message(){
		$this->data['method_name'] = $this->router->fetch_method();
	    file_put_contents($log_file,$query,FILE_APPEND);
	
		#$this->load->view('errors/page_missing.tpl.php',$this->data);
		return false;
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/errors.php */