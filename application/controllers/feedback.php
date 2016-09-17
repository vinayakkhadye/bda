<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Feedback extends CI_Controller {
	private $data = array();
	public function __construct(){
		parent::__construct();
		$this->load->model(array('common_model'));
		$this->data = $this->common_model->getAllData();
		$this->data['class_name'] = $this->router->fetch_class(); 
	}

	function apponintment_update()
	{
		$doctorid				=	$_GET['d'];
		$message				=	'';
		$rating					=	$_GET['r'];
		$username				=	$_GET['n'];
		$email					=	$_GET['e'];
		$filename_path	=	NULL;
		$status					=	1;
		
		$this->load->model(array('admin/adminreview_model'));
		$insert_id	=	$this->adminreview_model->insert_review($doctorid, $message, $rating, $username, $email, $filename_path, $status);
		if($insert_id)
		{
			$this->data['message']	=	'Thank You for Your Feedback !!';
		}
		else
		{
			$this->data['message']	=	'Plase Try Again !!';
		}
		$this->load->view('feedback/apponintment_update',$this->data);
	}

}