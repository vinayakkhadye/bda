<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');

class register extends CI_Controller
{
	private $data = array();

	public
	function __construct()
	{
		parent::__construct();
		$this->load->model(array('common_model','user_model'));
		$this->load->library('form_validation');
		$this->load->library('facebook');
	}

	function index()
	{
		$this->data = $this->common_model->getAllData();
		$city_detail = $this->common_model->setCurrentCity();
		$this->data['cityId'] = $city_detail[1];
		$this->data['cityName'] = $city_detail[0];

		$this->data['class_name'] = $this->router->fetch_class();
		
		// Create login URL for facebook
		$this->data['login_url'] = $this->facebook->getLoginUrl(
			array(
				'redirect_uri'=> site_url('login/facebook'),
					'scope'=> array(
					'email',
					'user_friends',
					'public_profile'
				) // permissions here
			));
		
		// check if the user is already logged in
		$sessuserid = $this->session->userdata('id');
		if(!empty($sessuserid))
		{
			redirect('/', 'refresh');
			exit();
		}
		
		$this->load->helper(array('form','url'));
		//print_r($this->input->post());
		$signup = $this->input->post('signup');
		
		if( ! empty($signup))
		{
			$config = array(
				array(
					'field'=> 'name',
					'label'=> 'Name',
					'rules'=> 'required|trim|min_length[4]|max_length[30]|xss_clean'
				),
				array(
					'field'=> 'email',
					'label'=> 'Email',
					'rules'=> 'required|trim|valid_email|callback_check_email_exists'
				)/*,
				array(
					'field'=> 'terms',
					'label'=> 'Agreement to terms and conditions',
					'rules'=> 'callback_accept_terms'
				)*/
			);
			$this->form_validation->set_rules($config);

			if($this->form_validation->run() === FALSE)
			// Invalid details
			{
			}
			else
			{
				$this->session->set_userdata('uname', $this->input->post('name'));
				$this->session->set_userdata('uemail', $this->input->post('email'));
				redirect('/createaccount', 'location');
			}
		}
		$this->data['metadata']['title'] = "Book Dr Appointment - Doctor and Patient Registration";
		$this->data['metadata']['description'] = "Doctor and Patient can register on Book Dr Appointment and use our best Services";

		$this->data['method_name'] = $this->router->fetch_method();
		$this->load->view('register',$this->data);
	}

	function accept_terms($terms)
	{
		if($terms == 'on')
		{
			return TRUE;
		}
		else
		{
			$this->form_validation->set_message('accept_terms', 'Please accept the terms and conditions.');
			return FALSE;
		}
	}

	function check_email_exists($email)
	{
		$query = $this->db->get_where('user', array('email_id'=> $email), 1);

		if($query->num_rows() >= 1)
		{
			$this->form_validation->set_message('check_email_exists', 'Email ID already in use');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
}
