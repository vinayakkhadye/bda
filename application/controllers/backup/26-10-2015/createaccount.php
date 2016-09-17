<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');

class createaccount extends CI_Controller
{
	function __construct()
	{
		
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->helper(array('form','url'));
		$this->load->model('user_model');
		
	}

	function index()
	{
		$submit = $this->input->post('submit_x');
		// Check if the form is submitted
		if( ! empty($submit))
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
				),
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
				array(
					'field'=> 'mob',
					'label'=> 'Mobile Number',
					'rules'=> 'required|trim|min_length[10]|max_length[10]|callback_checkmobexist'
					// SMS verification removal
					//'rules'=> 'required|trim|min_length[10]|max_length[10]|callback_checkmobverified'
				),
				array(
					'field'=> 'dob',
					'label'=> 'Date of Birth',
					'rules'=> 'required'
				),
				array(
					'field'=> 'gender',
					'label'=> 'Gender',
					'rules'=> 'required'
				),
				array(
					'field'=> 'usertype',
					'label'=> 'User Type',
					'rules'=> 'required'
				),
				array(
					'field'=> 'acceptterms',
					'label'=> 'Terms and Conditions',
					'rules'=> 'callback_accept_terms'
				)
			);
			$this->form_validation->set_rules($config);
			//echo $this->input->post('fbid');
			if($this->form_validation->run() === FALSE)
			{
				// Invalid details
			}
			else
			{
				// Details are valid
//				$flag = $this->session->userdata('code_verified');
//				if($flag == '1')
//				{
					$fbid        = $this->input->post('fbid');
					$googleid    = $this->input->post('googleid');
					$googleimage = $this->session->userdata('googleimage');

					// check if file is uploaded or not
					$newfilename = $this->input->post('profile_pic_base64_name');
					if(!empty($newfilename))
					{
						//echo getcwd();
						$md        = date('M').date('Y'); // getting the current month and year for folder name
						$structure = "./media/photos/".$md; // setting the folder path
						// Check if the directory with that particular name is present or not
						if(!is_dir("./media/photos/".$md))
						{
							// If directory not present, then create the directory
							mkdir($structure, 0777);
						}
						// setup the image new file name
						$filename      = md5($newfilename).rand(10000,99999);
						// Get extension of the file
						$ext           = pathinfo($newfilename, PATHINFO_EXTENSION);
						// get the full filename with full path as it needs to be entered in the db
						$filename_path = $structure."/".$filename.".".$ext;

						$decoded_pic   = base64_decode($this->input->post('profile_pic_base64'));

						file_put_contents($filename_path, $decoded_pic);
					}
					else if(!empty($fbid) && is_numeric($fbid))
					{
						//echo getcwd();
						$md        = date('M').date('Y'); // getting the current month and year for folder name
						$structure = "./media/photos/".$md; // setting the folder path
						// Check if the directory with that particular name is present or not
						if(!is_dir("./media/photos/".$md))
						{
							// If directory not present, then create the directory
							mkdir($structure, 0777);
						}
						// setup the image new file name
						$filename      = md5($newfilename).rand(10000,99999);
						// Get extension of the file
						$ext           = 'jpg';
						$filename_path = $structure."/".$filename.".".$ext;
						$url = "http://graph.facebook.com/{$fbid}/picture?type=large";
						file_put_contents($filename_path, file_get_contents($url));

					}else
					{
					
						$filename_path = NULL;
					}

					if(!empty($googleid))
					{
						$filename_path = $googleimage;
						$id            = $this->user_model->create_account($_POST,$filename_path);
						// unset code verified status from the session
						$this->session->unset_userdata('code_verified');
						$this->session->unset_userdata('googleimage');
						$this->session->unset_userdata('uname');
						$this->session->unset_userdata('uemail');
					}
					else
					{
						$id = $this->user_model->create_account($_POST,$filename_path);
						// unset code verified status from the session
						$this->session->unset_userdata('code_verified');
						$this->session->unset_userdata('googleimage');
						$this->session->unset_userdata('uname');
						$this->session->unset_userdata('uemail');
					}

					// Check if the user is using facebook for Sign up. If yes, then link the user id with the facebook id
					if(!empty($fbid) && is_numeric($fbid))
					{
						$this->user_model->link_fbid($id, $fbid);
						// unset facebook id from the session
						$this->session->unset_userdata('fbid');
					}

					// Check if the user is using google for Sign up. If yes, then link the user id with the google id
					if(!empty($googleid) && is_numeric($googleid))
					{
						$this->user_model->link_googleid($id, $googleid);
						// unset google id from the session
						$this->session->unset_userdata('googleid');
					}
					
					$this->session->unset_userdata('set_usertype_signup');
					
					$details->id = $id;
					$details->name = $_POST["name"];
					$details->type = $_POST["usertype"];
					$this->user_model->login_user($details);
					
					redirect('/login');
//				}
//				else
//				{
//					$this->form_validation->set_message('mob', 'Mobile Number is not verified');
//				}
			}
		}
		else
		{
			$this->session->unset_userdata('code_verified');
		}
		$this->load->view('createaccount', isset($data) ? $data : NULL);
	}

	function check_email_exists($email)
	{
		// check if the email is already
		$query = $this->user_model->check_email($email);
		if($query === TRUE)
		{
			$this->form_validation->set_message('check_email_exists', 'Email ID already in use');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}

	function accept_terms()
	{
		if(isset($_POST['acceptterms']) && $_POST['acceptterms'] == '1')
		{
			return TRUE;
		}
		else
		{
			$this->form_validation->set_message('accept_terms', 'Please accept the terms and conditions');
			return FALSE;
		}
	}

	function checkmobverified()
	{
		$flag = $this->session->userdata('code_verified');
		if(empty($flag))
		{
			$this->form_validation->set_message('checkmobverified', 'Mobile Number is not verified');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}

	function checkmobexist()
	{
		$mobile = $this->input->post('mob');
		$check = $this->user_model->check_mobno_exists($mobile);
		if($check === TRUE)
		{
			$this->form_validation->set_message('checkmobexist', 'Mobile Number already exist');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}

	function send_verification_sms() 
	{
		$this->load->model('sendsms_model',true);
		$mobile = $this->input->post('mob');
		// Check if the mobile number is a number and it is of length 10
		if(is_numeric($mobile) && strlen($mobile) == 10)
		{
			// Check if the mobile number is already present in the db
			$check = $this->user_model->check_mobno_exists($mobile);
			if($check === TRUE)
			{
				echo "Mobile number already exists";
			}
			else
			{			
				
				$code = rand(1000, 9999);
				$this->sendsms_model->send_verification_sms_code($mobile, $code);

				#$this->load->model('sendsms_model');	
				// Generate a random 4 digit number
				
				#$this->sendsms_model->send_sms($mobile, $code);
				$this->session->set_userdata('verification_code', $code);
				echo "success";
				//echo $message = urlencode("Your Account Verification code is ".$code."");	
			}
		}
		else
		{
			echo "Not a valid mobile number";
		}
	}

	function check_verification_code()
	{
		
		$code = $this->input->post('code');
		// Check if the verification code is a number and it has only 4 didgits
		
		if(is_numeric($code) && strlen($code) == 4)
		{
			$actual_code = $this->session->userdata('verification_code');
			// Comapare the code entered by the user with the code present in the session
			if($actual_code == $code)
			{
				$this->session->set_userdata('code_verified', '1');
				echo 'success';
			}
			else
			{
				echo "Invalid Verification code";
			}
		}
		else
		{
			echo "Invalid Verification code";
		}
	}

}