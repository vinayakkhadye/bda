<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller
{
	private $data = array();

	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('common_model','user_model','mail_model'));
		$this->load->library('facebook');
	}

	function index()
	{
//		print_r($_SERVER);
		if(!empty($_SERVER['HTTP_REFERER']) && ($_SERVER['HTTP_REFERER'] == 'http://www.bookdrappointment.com/patient.html'))
		{
			$this->session->set_userdata('set_usertype_signup', '1');
		}
		elseif(!empty($_SERVER['HTTP_REFERER']) && ($_SERVER['HTTP_REFERER'] == 'http://www.bookdrappointment.com/marketing.html'))
		{
			$this->session->set_userdata('set_usertype_signup', '2');
		}
		$this->data = $this->common_model->getAllData();
		$city_detail = $this->common_model->setCurrentCity();
		$this->data['cityId'] = $city_detail[1];
		$this->data['cityName'] = $city_detail[0];
		$this->data['class_name'] = $this->router->fetch_class();

		// check if the user is already logged in
		$sessuserid = $this->session->userdata('id');
		if(!empty($sessuserid))
		{
			$usertype = $this->session->userdata('usertype');
			if($usertype == 1)
			{
				redirect('/patient/details');
				exit();
			}
			elseif($usertype == 2)
			{
				redirect('/doctor/scheduler');
				exit();
			}
			elseif($usertype == 3)
			{
				redirect('/hospital/scheduler');
				exit();
			}
			else
			{
				redirect('/', 'refresh');
				exit();
			}
		}
		else
		{
			$this->session->unset_userdata('code_verified');
		}
		//Create login URL for facebook
		$this->data['login_url'] = $this->facebook->getLoginUrl(
			array(
				'redirect_uri'=> site_url('login/facebook'),
					'scope'=> array(
					'email',
					'user_friends',
					'public_profile'
				)  //permissions here
			));

		$this->data['metadata']['title'] = "Book Dr Appointment - Doctor and Patient login";
		$this->data['metadata']['description'] = "Doctor and Patient can login on Book Dr Appointment and use our best Services";

		$this->data['method_name'] = $this->router->fetch_method();
		$this->load->view('login',$this->data);
	}

	function check()
	{
		$msg =array();
		$this->load->library('form_validation');
		$config = array(
			array(
				'field'=> 'email',
				'label'=> 'Email',
				'rules'=> 'required|trim|valid_email'
			),
			array(
				'field'=> 'pass',
				'label'=> 'Password',
				'rules'=> 'required'
			)
		);
		$this->form_validation->set_rules($config);

		if($this->form_validation->run() == FALSE)
		{
			// Invalid form details
			//$this->session->set_flashdata('invalid_login_error', 'Invalid login credentials');
			//redirect('/login');
			$msg	=	array("error"=>'Invalid login credentials');
			
		}
		else
		{
			// Check if email and password are correct
			$email    = $this->input->post('email');
			$password = $this->input->post('pass');

			$details  = $this->user_model->check_login($email, $password);
			if($details !== FALSE)
			{
				$msg	=	$this->login_user($details);
			}
			else
			{
				//$this->session->set_flashdata('invalid_login_error', 'Invalid login credentials');
				//redirect('/login');
				$msg	=	array("error"=>'Invalid login credentials');
			}
		}
		echo json_encode($msg);
	}

	function login_user($details)
	{
		// Set login session
		$this->session->set_userdata('id', $details->id);
		$this->session->set_userdata('name', $details->name);
		$this->session->set_userdata('usertype', $details->type);
		
		//Check if the user is linked to facebook
		$checkfbuser = $this->user_model->check_fb_linked($details->id);
		if($checkfbuser)
		{
			$this->session->set_userdata('facebook_id', $checkfbuser->facebook_id);
		}

		//print_r($this->session->all_userdata());
		$userid    = $this->session->userdata('id');
		$usersname = $this->session->userdata('name');
		
		// Redirect code for review panel
		$redirect_url = $this->session->userdata('redirect_url');
		if(isset($redirect_url) && !empty($redirect_url))
		{
			$this->session->unset_userdata('redirect_url');
			redirect($redirect_url.'#review_panel');
			exit();
		}

		if($details->type == '2')
		{
			$msg	=	array("redirect"=>'/doctor/scheduler');
			#echo '/doctor/dashboard';
			//redirect('/doctor/dashboard');
		}
		elseif($details->type == '1')
		{
			$msg	=	array("redirect"=>'/patient/dashboard');
			#echo '/patient/dashboard';
			#redirect('/patient/dashboard');
		}
		else
		{
			$msg	=	array("redirect"=>'/logout');
			#echo '/logout';
			#redirect('/logout');
		}
		return $msg;
	}

	function facebook()
	{
		$user = $this->facebook->getUser();
		// Check if the permissions are granted to the app by the user
		if($user)
		{
			try
			{
				$details = $this->facebook->api('/me');
			}
			catch(FacebookApiException $e)
			{
				$user = null;
			}
		}
		else
		{
			$this->facebook->destroySession();
			redirect('/login', 'refresh');
		}

		$check = $this->user_model->check_fbuser_exists($details['id']);
		// Check if the facebook user is new to our web application or not
		if($check === FALSE)
		{
			// User is new
			$this->session->set_userdata('uname', $details['name']);
			$this->session->set_userdata('fbid', $details['id']);
			$this->session->set_userdata('uemail', $details['email']);
			redirect('/createaccount');
		}
		else
		{
			// user already signed up via facebook
			$userdetails = $this->user_model->get_all_userdetails($check->user_id);
			$redirect	=	$this->login_user($userdetails);
			redirect($redirect['redirect']);
		}
	}

	function google()
	{
		$provider   = 'google';
		$this->load->library('OAuth2');
		$this->load->helper('url_helper');

		$app_id     = $this->config->item('googleplus_appid');
		$app_secret = $this->config->item('googleplus_appsecret');
		$provider   = $this->oauth2->provider($provider, array(
				'id'    => $app_id,
				'secret'=> $app_secret,
			));

		if(!$this->input->get('code'))
		{
			// By sending no options it'll come back here
			$provider->authorize();
		}
		else
		{
			$token = $provider->access($_GET['code']);
			// Get user details
			$user  = $provider->get_user_info($token);

			// Check if the google user already exists
			$check = $this->user_model->check_googleuser_exists($user['uid']);
			if($check === FALSE)
			{
				// User is new
				$this->session->set_userdata('uname', $user['name']);
				$this->session->set_userdata('uemail', $user['email']);
				$this->session->set_userdata('googleid', $user['uid']);
				$this->session->set_userdata('googleimage', $user['image']);
				redirect('/createaccount');
			}
			else
			{
				// user already signed up via Google
				$userdetails = $this->user_model->get_all_userdetails($check->user_id);
				// Perform login
				$redirect	=	$this->login_user($userdetails);
				redirect($redirect['redirect']);
			}
		}
	}
	
	function google_bookapt()
	{
		$provider   = 'google';
		$this->load->library('OAuth2');
		$this->load->helper('url_helper');

		$app_id     = $this->config->item('googleplus_appid');
		$app_secret = $this->config->item('googleplus_appsecret');
		$provider   = $this->oauth2->provider($provider, array(
				'id'    => $app_id,
				'secret'=> $app_secret,
			));

		if(!$this->input->get('code'))
		{
			// By sending no options it'll come back here
			$provider->authorize();
		}
		else
		{
			$token = $provider->access($_GET['code']);
			// Get user details
			$user  = $provider->get_user_info($token);

			//print_r($user);exit;
			// Check if the google user already exists
			$check = $this->user_model->check_googleuser_exists($user['uid']);
			if($check === FALSE)
			{
				// User is new
				$this->session->set_userdata('uname', $user['name']);
				$this->session->set_userdata('uemail', $user['email']);
				$this->session->set_userdata('googleid', $user['uid']);
				$this->session->set_userdata('googleimage', $user['image']);
				redirect('/createaccount');
			}
			else
			{
				// user already signed up via Google
				$userdetails = $this->user_model->get_all_userdetails($check->user_id);
				// Perform login
				$this->login_user($userdetails);
			}
		}
	}

	function forgotpassword()
	{
		$email = $_POST['email'];
		// check if email is present in the database
		$check = $this->user_model->check_email($email);
		if($check === TRUE)
		{
			$resetcode = md5($email).rand(1000,9999).rand(1000,9999);
			$this->user_model->insert_forgotpass($email, $resetcode);
			$userdetails = $this->user_model->get_all_userdetails_byemail($email);
			$this->mail_model->sendresetpasswordmail($email, $userdetails->name, $resetcode);
			echo 'success';
		}
		else
		{
			//echo 'error';
		}
	}

}