<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');

class resetpassword extends CI_Controller
{
	private $data = array();
	
	function __construct()
	{
		parent::__construct();
		$this->load->model(array('common_model','user_model'));
	}
	
	function index()
	{
		if(isset($_GET['email']) && isset($_GET['code']))
		{
			$data = $this->common_model->getAllData();
			$city_detail = $this->common_model->setCurrentCity();
			$data['cityId'] = $city_detail[1];
			$data['cityName'] = $city_detail[0];
			$data['class_name'] = $this->router->fetch_class();
			$data['method_name'] = $this->router->fetch_method();
			
			$email = $_GET['email'];
			$code = $_GET['code'];
			$check = $this->user_model->check_resetpassword_code($email, $code);
			
			if($check === TRUE)
			{
				$this->load->library('form_validation');
				if(isset($_POST['submit']))
				{
					$config = array(
						array(
							'field'=> 'pass',
							'label'=> 'Password',
							'rules'=> 'required|min_length[6]|max_length[24]'
						),
						array(
							'field'=> 'cnfmpass',
							'label'=> 'Confirm Password',
							'rules'=> 'required|matches[pass]'
						),
					);
					$this->form_validation->set_rules($config);
					//echo $this->input->post('fbid');
					if($this->form_validation->run() === FALSE)
					{
						// Invalid details
					}
					else
					{
						$newpass = $_POST['pass'];
						
						$this->user_model->change_password_with_code($email, $newpass);
						$this->user_model->change_resetcode_status($email, $code);
						//send mailer
						$user_details = $this->user_model->get_all_userdetails_byemail($email);
						$this->load->model('mail_model');
						$result 	=	$this->mail_model->changepasswordmail($email, $user_details->name);
						redirect('/login');
					}
				}
				$this->load->view('resetpassword', isset($data) ? $data : NULL);
			}
			else
			{
				redirect('/');
			}
		}
		else
		{
			redirect('/');
		}
	}
}