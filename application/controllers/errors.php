<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Errors extends CI_Controller {
	private $data = array();
	public function __construct(){
		parent::__construct();
		$this->load->model(array('common_model','user_model'));
		$this->data = $this->common_model->getAllData();
		$this->data['class_name'] = $this->router->fetch_class(); 
	}
	public function page_missing()
	{
		#print_r($this->data);exit;
		$this->data['method_name'] = $this->router->fetch_method();
		$this->load->view('errors/page_missing',$this->data);
		
		
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/errors.php */