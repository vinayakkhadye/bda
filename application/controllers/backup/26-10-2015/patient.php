<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');

class Patient extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model(array('common_model','user_model','patient_model','location_model','sendsms_model'));

		/* user login check code begins */
		$session_userid = $this->session->userdata('id');
		$session_usertype = $this->session->userdata('usertype');
		if(empty($session_userid))
		{
			redirect('/login', 'refresh');
			exit();
		}
		elseif($session_usertype != '1')
		{
			redirect('/login', 'refresh');
			exit();
		}
		/* user login check code ends */
	}
	
	function index()
	{
		if($this->session->userdata('usertype') == '1')
		redirect('patient/dashboard');
	}

	function dashboard()
	{
		$userid = $this->session->userdata('id');
		$data['name'] = $this->session->userdata('name');

		$this->load->view('patient_dashboard', isset($data) ? $data : NULL);
	}

	function profile()
	{
		// Get user id and name from the session
		$userid = $this->session->userdata('id');
		$data['name'] = $this->session->userdata('name');

		// get details if already present in patient table
		$patient_details = $this->patient_model->get_patient_details($userid);
		//print_r($patient_details);
		if($patient_details != FALSE)
		{
			$data['patient_details'] = $patient_details;
			$stateid = $this->location_model->get_state_id($patient_details->city_id);
			//			var_dump($stateid);
			if($stateid !== FALSE)
			{
				$data['patient_details_stateid'] = $stateid->state_id;
				$data['cities'] = $this->location_model->get_city($stateid->state_id);
				$data['locality'] = $this->location_model->get_locality($patient_details->city_id);
			}
			// get details if already present in bmi table
			$patient_bmi_details = $this->patient_model->get_patient_bmi_details($userid);
			if($patient_bmi_details != FALSE)
			{
				$data['patient_bmi_details'] = $patient_bmi_details;
			}

			// get details if already present in patient_family_details table
			$patient_family_details = $this->patient_model->get_patient_family_details($userid, $patient_details->id);
			if($patient_family_details != FALSE)
			{
				$data['patient_family_details'] = $patient_family_details;
			}

			// get details if already present in patient_history table
			$patient_history = $this->patient_model->get_patient_history($userid, $patient_details->id);
			if($patient_history != FALSE)
			{
				$data['patient_history'] = $patient_history;
				$data['disease_duration'] = $this->calc_disease_duration($patient_history->disease_from_date, $patient_history->disease_to_date);
			}
		}

		$submit = $this->input->post('submit');
		if($submit)
		{
			/*print_r($this->input->post());
			echo "<br/><br>";*/
			if($patient_details === FALSE)
			{
				$this->patient_model->insert_patient_details($this->input->post(), $userid);
			}
			else
			{
				$this->patient_model->update_patient_details($this->input->post(), $userid, $patient_details->id);
			}

			//redirect(' / patient / dashboard');
		}

		$data['states'] = $this->location_model->get_state();

		$this->load->view('patient_profile', isset($data) ? $data : NULL);
	}

	function test()
	{
		$incident_month = '2';
		$incident_year  = '2013';

		$duration_year  = '1';
		$duration_month = '11';

		/*
		// conversion of time from 12 hr format to 24 hr format
		$t = "09:00PM";
		date('H:i', strtotime($t));

		$e = '1-'.$incident_month.'-'.$incident_year;
		echo date('m-d-Y', strtotime($e));

		$f = '+'.$duration_year.'year '.$duration_month.' months';
		echo date('m-d-Y', strtotime($e.$f));
		*/

	}

	function calc_disease_duration($disease_from_date, $disease_to_date)
	{
		//echo $disease_from_date . '  till  ' . $disease_to_date . ' < br/>';
		$dates_calc = array();
		$dates_calc['incident_month'] = date('m' ,strtotime($disease_from_date));
		$dates_calc['incident_year'] = date('Y' ,strtotime($disease_from_date));

		$date_intervals = date_diff(date_create($disease_to_date), date_create($disease_from_date));
		$dates_calc['duration_month'] = $date_intervals->m;
		$dates_calc['duration_year'] = $date_intervals->y;
		//print_r($dates_calc);

		return $dates_calc;
	}
	function phi()
	{

		if(sizeof($_POST)>0){
			$this->post_phi();
			redirect('/patient/dashboard');
		}
		$this->load->library('form_validation');
		$userid = $this->session->userdata('id');
		$data['name'] = $this->session->userdata('name');
		$data['userdetails'] = $this->user_model->get_all_userdetails($userid);
		$data['user_image'] = $data['userdetails']->image;
		
		$data['patientdetails'] = $this->patient_model->get_patient_details($userid);
		$data['patient_id'] = $data['patientdetails']->id;
		if(empty($data['patientdetails'])){
			redirect('/patient/dashboard');
		}
		
		$data['family_details_count'] =  $data['past_disease_count'] = $data['past_surgery_count'] =  $data['medication_count'] =  $data['reports_count'] = 0;
		
			
			
			$localities = $this->location_model->get_locality($data['patientdetails']->city_id);
			
			$data['localities'] = $localities;
			
			$data['bmi'] = $this->patient_model->get_patient_bmi_details($data['patientdetails']->id);
			$data['family_details'] = $this->patient_model->get_patient_family_details($data['patientdetails']->id);
			$data['family_details_count'] = count($data['family_details'])-1;
			
			#print_r($data['bmi']);exit;
			if($data['patientdetails']->location_id == 0)
			{
				$data['other_locality'] = $data['patientdetails']->other_location;
			}
			
			$data['past_disease'] = $this->patient_model->get_patient_past_disease($data['patientdetails']->id);
			$data['past_disease_count'] = (count($data['past_disease']))?count($data['past_disease'])-1:0;

			$data['past_surgery'] = $this->patient_model->get_patient_past_surgery($data['patientdetails']->id);
			$data['past_surgery_count'] = (count($data['past_surgery']))?count($data['past_surgery'])-1:0;

			$data['medication'] = $this->patient_model->get_patient_medication($data['patientdetails']->id);
			$data['medication_count'] = (count($data['medication']))?count($data['medication'])-1:0;
			
			$data['allergic'] = $this->patient_model->get_patient_allergy($data['patientdetails']->id);
			$data['allergic_count'] = (count($data['allergic']))?count($data['allergic'])-1:0;

		
		$data['blood_group'] = $this->common_model->get_blood_group();
		$data['month'] = array(1=>'January',2=>'February',3=>'March',4=>'April',5=>'May',6=>'June',7=>'July',8=>'August',9=>'September',10=>'October',11=>'November',12=>'December');
		
		$data['year'] = range(date("Y",strtotime("now")),1970);
		$data['allergy_list'] = array(1=>"Food Allergy",2=>"Drug Allergy",3=>"Environmental Allergy",4=>"Animal Allergy");

		$this->load->view('patient_phi', isset($data) ? $data : NULL);
			
	}
	function phr()
	{
		if(sizeof($_POST)>0){
			$this->post_phr();
			redirect('/patient/dashboard');
		}
		$this->load->library('form_validation');
		$userid = $this->session->userdata('id');
		$data['name'] = $this->session->userdata('name');
		$data['userdetails'] = $this->user_model->get_all_userdetails($userid);
		$data['user_image'] = $data['userdetails']->image;
		
		$data['patientdetails'] = $this->patient_model->get_patient_details($userid);
		$data['patient_id'] = $data['patientdetails']->id;
		if(empty($data['patientdetails'])){
			redirect('/patient/dashboard');
		}
		$data['report_categories'] = array("Prescription","Lab Report","Allergy","Immunization","Surgery","Other");
		$data['reports'] = $this->patient_model->get_patient_reports($data['patientdetails']->id);
		$data['reports_count'] = (count($data['reports']))?count($data['reports'])-1:0;
		$this->load->view('patient_phr', isset($data) ? $data : NULL);
	}
	
	function post_phi(){
		
		
		$patient_id = (isset($_POST['patient_id']))?$_POST['patient_id']:'';
		if($patient_id)
		{
			$patient['blood_group'] = (isset($_POST['blood_group']) && !empty($_POST['blood_group']))?$_POST['blood_group']:'';
			$patient['food_habits'] = (isset($_POST['food_habits']))?$_POST['food_habits']:'';
			$patient['alcohol'] = (isset($_POST['alcohol']))?$_POST['alcohol']:'';
			$patient['smoking'] = (isset($_POST['smoking']))?$_POST['smoking']:'';
			$patient['ciggi_per_day'] = (isset($_POST['no_of_cig']))?intval($_POST['no_of_cig']):0;
			$patient['tobacco_consumption'] = (isset($_POST['tobacco']))?$_POST['tobacco']:'';
			
			$this->patient_model->update_patient($patient,$patient_id);
			
			$bmi['height_feet'] = (isset($_POST['height_feet']))?$_POST['height_feet']:'';
			$bmi['height_inches'] = (isset($_POST['height_inches']))?$_POST['height_inches']:'';
			$bmi['weight'] = (isset($_POST['weight']))?$_POST['weight']:'';
			$bmi['bmi_value'] = (isset($_POST['bmi_value']))?$_POST['bmi_value']:'';
			$bmi['patient_id'] = $patient_id;
			$bmi['user_id'] = (isset($_POST['user_id']))?$_POST['user_id']:NULL;
			if($bmi['bmi_value'] && $bmi['weight']){
				$patient_bmi = $this->patient_model->insert_patient_bmi($bmi);
			}
			$family_member_name = (isset($_POST['family_member_name']))?$_POST['family_member_name']:'';
			
			if(isset($family_member_name) && is_array($family_member_name) && sizeof($family_member_name)>0){
				foreach($family_member_name as $key=>$val){
					if(is_array($val) && sizeof($val)>0 && !empty($_POST['family_disease'][$key])){
						$memebers = array_keys($val);
						$family_details['family_member_name'] = $memebers; 
						$family_details['family_summary'] = (isset($_POST['family_summary'][$key]))?$_POST['family_summary'][$key]:'';
						$family_details['family_disease'] = (isset($_POST['family_disease'][$key]))?$_POST['family_disease'][$key]:'';
						$family_details['patient_id'] = $patient_id;

						if(!empty($_POST['family_detail_id'][$key])){
							$this->patient_model->update_patient_family_history($_POST['family_detail_id'][$key],$family_details);
						}else{
							$this->patient_model->insert_patient_family_history($family_details);
						}
					}
				}
				
			}
			
			$disease_from_year = (isset($_POST['disease_from_year']))?$_POST['disease_from_year']:NULL;
			if(isset($disease_from_year) && is_array($disease_from_year) && sizeof($disease_from_year)>0){
				foreach($disease_from_year as $key=>$val){
					if(!empty($val)){
						$patient_past_disease['disease_name'] =  (isset($_POST['disease_name'][$key]))?$_POST['disease_name'][$key]:NULL; 
						$patient_past_disease['disease_from_year'] =  (isset($_POST['disease_from_year'][$key]))?$_POST['disease_from_year'][$key]:NULL; 
						$patient_past_disease['disease_from_month'] =  (isset($_POST['disease_from_month'][$key]))?$_POST['disease_from_month'][$key]:NULL; 
						$patient_past_disease['disease_duration'] =  (isset($_POST['disease_duration'][$key]))?$_POST['disease_duration'][$key]:NULL; 
						$patient_past_disease['disease_details'] =  (isset($_POST['disease_details'][$key]))?$_POST['disease_details'][$key]:NULL; 
						$patient_past_disease['patient_id'] = $patient_id;
						
						if(!empty($_POST['past_disease_id'][$key])){
							$this->patient_model->update_patient_past_disease($_POST['past_disease_id'][$key],$patient_past_disease);
						}else{
							$this->patient_model->insert_patient_past_disease($patient_past_disease);
						}
					}

					#echo $this->patient_model;
				}
			}

			$surgery_name = (isset($_POST['surgery_name']))?$_POST['surgery_name']:NULL;
			if(isset($surgery_name) && is_array($surgery_name) && sizeof($surgery_name)>0){
				foreach($surgery_name as $key=>$val){
					if(!empty($val)){
						$patient_past_surgery['surgery_name'] =  $val;
						$patient_past_surgery['surgery_reason'] =  (isset($_POST['surgery_reason'][$key]))?$_POST['surgery_reason'][$key]:NULL; 
						$patient_past_surgery['surgery_date'] =  (isset($_POST['surgery_date'][$key]))?$_POST['surgery_date'][$key]:NULL; 
						$patient_past_surgery['patient_id'] = $patient_id;
	
						if(!empty($_POST['past_surgery_id'][$key])){
							$this->patient_model->update_patient_past_surgery($_POST['past_surgery_id'][$key],$patient_past_surgery);
						}else{
							$this->patient_model->insert_patient_past_surgery($patient_past_surgery);
						}
					}
					
				}
			}

			$ongoing_medications = (isset($_POST['ongoing_medications']))?$_POST['ongoing_medications']:NULL;	
			if(isset($ongoing_medications) && is_array($ongoing_medications) && sizeof($ongoing_medications)>0){
				foreach($ongoing_medications as $key=>$val){
					if(!empty($val)){
						$patient_medication['medication'] = $val;
						$patient_medication['patient_id'] = $patient_id;
						if(!empty($_POST['ongoing_medications_id'][$key])){
							$this->patient_model->update_patient_medication($_POST['ongoing_medications_id'][$key],$patient_medication);
							#echo $this->patient_model;
						}else{
							$this->patient_model->insert_patient_medication($patient_medication);
							#echo $this->patient_model;
						}
					}
				}
			}

			$allergic = (isset($_POST['allergic']))?$_POST['allergic']:NULL;	
			if(isset($allergic) && is_array($allergic) && sizeof($allergic)>0){
				foreach($allergic as $key=>$val){
					if(!empty($val)){
						$patient_allergic['allergic'] = $val;
						$patient_allergic['allery_type'] = (!empty($_POST['allergic_list'][$key]))?$_POST['allergic_list'][$key]:NULL;
						$patient_allergic['patient_id'] = $patient_id;
						if(!empty($_POST['allergic_id'][$key])){
							$this->patient_model->update_patient_allergic($_POST['allergic_id'][$key],$patient_allergic);
							#echo $this->patient_model;
						}else{
							#print_r($patient_allergic);
							$this->patient_model->insert_patient_allergic($patient_allergic);
							#echo $this->patient_model;
						}
					}
				}
			}
		}
		#echo $this->patient_model;
	
	}
	public function mkpath($path,$perm){
		if(@mkdir($path) or file_exists($path)) return true;
		return ($this->mkpath(dirname($path),$perm) and mkdir($path,$perm));
	}
	
	function post_phr(){
		#print_r($_POST);print_r($_FILES);exit;
		$patient_id = (isset($_POST['patient_id']))?$_POST['patient_id']:'';
		if($patient_id)
		{
			$report_date = (isset($_POST['report_date']))?$_POST['report_date']:NULL;	
			if(isset($report_date) && is_array($report_date) && sizeof($report_date)>0){
				foreach($report_date as $key=>$val){
					if(!empty($val)){
						#print_r($val);
						$patient_report['report_category'] = (!empty($_POST['report_category'][$key]))?$_POST['report_category'][$key]:NULL;
						$patient_report['report_date'] = date("Y-m-d H:i:s",strtotime($val));
						$patient_report['patient_id'] = $patient_id;
						$patient_report['report_reason'] = (!empty($_POST['report_reason'][$key]))?$_POST['report_reason'][$key]:NULL;
						$patient_report['report_attachment'] = (!empty($_FILES['report_attachment_'.$key]['name']))?
						$_FILES['report_attachment_'.$key]['name']:NULL;
						if($patient_report['report_attachment'])
						{
							
							$files['upload_path'] = './media/reports/'.date("Y").'/'.date("M");
							if(!is_dir($files['upload_path'])){
								$this->mkpath($files['upload_path'],0777);
							}
							$files['overwrite'] =TRUE;
							$patient_report['report_attachment'] = $files['file_name'] = $patient_id."_".date("YmdHis")."_".rand(111,999)."_".$patient_report['report_attachment'];
							$files['allowed_types'] = '*';
							$this->load->library('upload', $files);
							$this->upload->do_upload("report_attachment_{$key}");
							$uploaded_data = $this->upload->data();
							#print_r($uploaded_data);
							if(!isset($_POST['report_detail_id'][$key]) && !empty($patient_report['report_category'])){
								#print_r($patient_report);
								$this->patient_model->insert_patient_report($patient_report);
								#echo $this->patient_model;
							}
						}
						if(isset($_POST['report_detail_id']) && !empty($_POST['report_detail_id'][$key]))
						{
							#print_r($patient_report);
							$this->patient_model->update_patient_report($_POST['report_detail_id'][$key],$patient_report);
							#echo $this->patient_model;
						}
					}
					
				}
				
			}
		}
		#exit;
	}
	function details()
	{
		$this->load->library('form_validation');
		$userid = $this->session->userdata('id');
		$data['name'] = $this->session->userdata('name');
		$data['userdetails'] = $this->user_model->get_all_userdetails($userid);
		$data['user_image'] = $data['userdetails']->image;

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
					'field'=> 'mob',
					'label'=> 'Mobile Number',
					'rules'=> 'required|trim|min_length[10]|max_length[10]|callback_checkmobverified'
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
				)
			);
			$this->form_validation->set_rules($config);

			//echo $this->input->post('fbid');
			
			//echo date('Y-m-d', strtotime($this->input->post('dob')));

			if($this->form_validation->run() === FALSE)
			{
				// Invalid details
			}
			else
			{
				$mob = $this->input->post('mob');
				// Details are valid
				$flag = $this->session->userdata('code_verified');
				if(($data['userdetails']->contact_number == $mob) || ($flag == '1'))
				{
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
					else
					{
						$filename_path = NULL;
					}

					$id = $this->user_model->update_account($_POST, $filename_path, $userid);
					// unset code verified status from the session
					$this->session->unset_userdata('code_verified');
					
					redirect('/patient/details');
				}
				else
				{
					$this->form_validation->set_message('mob', 'Mobile Number is not verified');
				}
			}
		}
		$this->load->view('patient_details', isset($data) ? $data : NULL);
	}

	function send_verification_sms()
	{
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
				$this->session->set_userdata('verification_code', $code);
				$this->session->set_userdata('code_verified', '0');
				$this->load->model('sms_model');
				$this->sendsms_model->send_verification_sms_code($mobile, $code);
				echo "success";
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
	
	function changepassword()
	{
		$userid = $this->session->userdata('id');
		$data['name'] = $this->session->userdata('name');
		$data['userdetails'] = $this->user_model->get_all_userdetails($userid);
		$this->load->library('form_validation');
		
		if(isset($_POST['submit_x']))
		{
			//print_r($_POST);
			$config = array(
				array(
					'field'=> 'oldpass',
					'label'=> 'Current Password',
					'rules'=> 'required|callback_check_current_password'
				),
				array(
					'field'=> 'newpass',
					'label'=> 'New Password',
					'rules'=> 'required|min_length[6]|max_length[24]'
				),
				array(
					'field'=> 'cnfmnewpass',
					'label'=> 'New Password Confirm',
					'rules'=> 'required|matches[newpass]'
				)
			);
			$this->form_validation->set_rules($config);
			if($this->form_validation->run() == FALSE)
			{
				// Invalid form details
			}
			else
			{
				//Change password
				$check = $this->user_model->change_password($userid,$_POST['newpass']);
				//send mailer
				$this->load->model('mail_model');
				$this->mail_model->changepasswordmail($data['userdetails']->email_id, $data['userdetails']->name);
				redirect('/patient');
			}
		}
		
		$this->load->view('changepassword', isset($data) ? $data : NULL);
	}
	
	function check_current_password($pass)
	{
		$userid = $this->session->userdata('id');
		$check = $this->user_model->check_password($userid,$pass);
		var_dump($check);
		if($check === FALSE)
		{
			$this->form_validation->set_message('check_current_password', 'You have entered an incorrect password');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	function patient_delete_bytype(){
		$rs = false;
		$id = isset($_POST['id'])?intval($_POST['id']):''; 
		$type = isset($_POST['type'])?$_POST['type']:''; 
		if($id){
			if($type == "family_detail"){
				$rs = $this->db->update('patient_family_detail', array("status"=>-1,"updated_on"=>date("Y-m-d H:i:s")), array('id' => $id));
				echo $this->db->last_query();
			}else if($type == "past_disease"){
				$rs = $this->db->update('patient_past_disease', array("status"=>-1,"updated_on"=>date("Y-m-d H:i:s")), array('id' => $id));
				echo $this->db->last_query();
			}else if($type == "past_surgery"){
				$rs = $this->db->update('patient_past_surgery', array("status"=>-1,"updated_on"=>date("Y-m-d H:i:s")), array('id' => $id));
				echo $this->db->last_query();
			}else if($type == "ongoing_medications"){
				$rs = $this->db->update('patient_medication', array("status"=>-1,"updated_on"=>date("Y-m-d H:i:s")), array('id' => $id));
				echo $this->db->last_query();
			}else if($type == "allergic"){
				$rs = $this->db->update('patient_allergic', array("status"=>-1,"updated_on"=>date("Y-m-d H:i:s")), array('id' => $id));
				echo $this->db->last_query();
			}else if($type == "report_detail"){
				$rs = $this->db->update('patient_report', array("status"=>-1,"updated_on"=>date("Y-m-d H:i:s")), array('id' => $id));
				echo $this->db->last_query();
			}
			
			if($rs){
				echo "1";
			}else{
				echo "0";
			}
		}
	}
	
	function smstest()
	{
		$this->sendsms_model->send_welcome_sms_patient('8082771213', 'sgdf@fsdhgd.com');
	}
}