<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bookappointment extends CI_Controller
{
	private $data = array();

	public function __construct()
	{
		parent::__construct();
	}
	public function index()
	{
		$url	=	base64_decode($this->get['data']);
		$url_params	=	parse_url($url);
		parse_str($url_params['path']);

		if(empty($clinic_id) || empty($doctor_id))
		{
			redirect('/');
		}
		if((strlen($time)!=7 && strlen($time)!=8)|| strlen($date)!=10)
		{
			redirect('/');
		}

		$this->load->model(array('common_model'));
		$this->data = $this->common_model->getAllData();

		$city_detail = $this->common_model->setCurrentCity();
		$this->data['cityId'] = $city_detail[1];
		$this->data['cityName'] = $city_detail[0];
		
		
		$this->load->config('facebook');
		$this->data['method_name'] = 'bookappointment';
		$this->load->model(array('patient_model','doctor_model','common_model','user_model'));
		$this->data['date'] = date("Y-m-d",strtotime($date));
		$this->data['time'] = date("H:i:s",strtotime($time));

		$this->data['apt']['date'] = date("D, jS M, Y",strtotime($date));
		$this->data['apt']['time'] = date('h:i a',strtotime($time));
		$this->data['apt']['clinic_id'] = $clinic_id;
		$this->data['apt']['doctor_id'] = $doctor_id;
		$this->data['user_id'] = $this->session->userdata('id');
		$this->data['user_type'] = $this->session->userdata('usertype');
		#$this->data['flag'] = $this->session->userdata('code_verified');
		if($this->data['user_id']){
			$user = $this->user_model->get_all_userdetails($this->data['user_id']);
			$this->data['patient_name'] = $user->name;
			$this->data['email_id'] = $user->email_id;
			$this->data['mobile_number'] = $user->contact_number;
			$this->data['gender'] = $user->gender;

			#print_r($user);
		}
		$doctor = $this->doctor_model->getDoctorByClinicId(array('clinic_id'=>$clinic_id,'column'   =>array('doc.id as doctor_id','doc.name','doc.speciality','doc.qualification','doc.image as doctor_image','doc.gender as doctor_gender','cli.name as clinic_name','cli.address as clinic_address','cli.city_id as clinic_city_id','cli.latitude','cli.longitude','doc.contact_number as doctor_contact_number','cli.contact_number as clinic_contact_number')));
		if(is_array($doctor) && sizeof($doctor)){
			$doctor = current($doctor);
			$doctor['specialityStr'] = '';
			if(!empty($doctor['speciality'])){
				$doctor['speciality'] = $this->common_model->getSpeciality(array('ids'=>$doctor['speciality'],'status'=>ACTIVE,'limit' =>100,'column'=>array('name','id')));
				$doctor['specialityStr'] = '';
				if(is_array($doctor['speciality'])){
					foreach($doctor['speciality'] as $spKey=>$spVal){
						$doctor['specialityStr'] .= ucfirst($spVal['name']).", ";

					}
				}
				$doctor['specialityStr'] = trim($doctor['specialityStr'],", ");
			}

			$doctor['qualificationStr'] = '';
			if(!empty($doctor['qualification'])){
				$doctor['qualification'] = $this->common_model->getQualification(array('ids'   =>$doctor['qualification'],'status'=>ACTIVE,'limit' =>100,'column'=>array('name','id')));
				$doctor['qualificationStr'] = '';
				if(is_array($doctor['qualification'])){
					foreach($doctor['qualification'] as $spKey=>$spVal){
						$doctor['qualificationStr'] .= strtoupper($spVal['name']).", ";
					}
				}
				$doctor['qualificationStr'] = trim($doctor['qualificationStr'],", ");

			}
			if($doctor['doctor_image']){
				if(strpos($doctor['doctor_image'],"http") !== false){
					$doctor['doctor_image'] = $doctor['doctor_image'];
				}
				else
				{
					$doctor['doctor_image'] = BASE_URL.$doctor['doctor_image'];
				}
			}
			else
			{
				if(strtolower($doctor['doctor_gender']) == "m"){
					$doctor['doctor_image'] = IMAGE_URL."default_doctor.png";
				}
				else
				if(strtolower($doctor['doctor_gender']) == "f"){
					$doctor['doctor_image'] = IMAGE_URL."female_doctor.jpg";
				}
				elseif(strtolower($doctor['doctor_gender']) == "o")
				{
					$doctor['doctor_image'] = IMAGE_URL."default_404.jpg";
				}
				else
				{
					$doctor['doctor_image'] = IMAGE_URL."default_404.jpg";
				}

			}

			$this->data['apt']['doctor'] = $doctor;

			$meta_data['title'] =  "Request an appointment| Book Doctor Appointment";
			$meta_data['description'] =  "Request an appointment| Book Doctor Appointment";
			$meta_data['keywords'] =  "Request an appointment| Book Doctor Appointment";
			$this->data['metadata'] = $meta_data;			
			//print_r($this->data);
			$this->load->view('bookappointment.php',$this->data);

		}
		else
		{
			redirect('/');
		}
	}
	public function saveappointment()
	{
		$this->load->model(array('doctor_model','sendsms_model','user_model','mail_model','patient_model','appointment_model'));

		$this->data['method_name'] = 'saveappointment';

		if($this->post['user_id'])
		{
			$user_id   = $this->post['user_id'];
			$user_type = $this->post['user_type'];
			$user      = $this->user_model->get_all_userdetails($user_id);
		}
		else if($this->post['email_id'])
		{
			$user = $this->user_model->get_all_userdetails_byemail($this->post['email_id']);
			if($user)
			{
				$user_id   = $user->id;
				$user_type = $user->type;
			}
		}

		if(isset($user_id))
		{
			$this->post['user_id'] = $user_id;
			$this->post['user_type'] = $user_type;
			$patient_id = $this->patient_model->get_patientid_byuserid($user_id);

			if($patient_id == FALSE)
			{
				$patient_id = $this->patient_model->insert_patient
				(
					array('name'         =>$this->post["patient_name"],
						'user_id'      =>$this->post['user_id'],
						'gender'       =>$this->post["gender"],
						'image'        =>(isset($this->post["image"])?$this->post["image"]:''),
						'email'        =>(isset($user->email_id))?$user->email_id:$this->post['email_id'],
						'mobile_number'=>(isset($user->contact_number))?$user->contact_number:$this->post["mobile_number"],
						'status'       =>1)
				);
			}
		}
		else
		{
			#print_r($this->post);exit;
			$this->post['user_id'] = NULL;
			$this->post['user_type'] = 1;
			$patient_id = $this->patient_model->get_patientid_byemail($this->post['email_id']);
			if($patient_id == FALSE)
			{
				$patient_id = $this->patient_model->insert_patient(
					array('name'         =>$this->post["patient_name"],
						'user_id'      =>$this->post['user_id'],
						'gender'       =>$this->post["gender"],
						'image'        =>(isset($this->post["image"])?$this->post["image"]:''),
						'email'        =>$this->post["email_id"],
						'mobile_number'=>$this->post["mobile_number"],'status'       =>1)
				);
			}
		}

		if(isset($patient_id) && !empty($patient_id))
		{
			$this->post['patient_id'] = $patient_id;
			if($patient_id && $this->post["doctor_id"])
			{
				$patient_doctor_data	=	array(
																	'doctor_id'=>$this->post["doctor_id"],
																	'patient_id'=>$patient_id
																);
				$patient_doctor_id = $this->patient_model->insert_patient_doctor_map($patient_doctor_data); 
			}
			
		}
		else
		{
			$this->post['patient_id'] = NULL;
		}

		$appointment_id	=	$this->appointment_model->get_appointments_by_status(date("Y-m-d H:i:s",strtotime($this->post['date']." ".$this->post['time'])),$this->post["doctor_id"],$this->post["clinic_id"]);
		if($appointment_id)
		{
			echo '0';
			return false;
		}
		$insert_id = $this->doctor_model->saveAppointment($this->post);
		if($insert_id)
		{
			#$notification_msg	=	urlencode("you have a new appointment for doctor ".$this->post["doctor_name"]." @".date("dS M Y \a\t h:i a",strtotime($this->post['date']." ".$this->post['time']))." for ".$this->post['patient_name']." - ".$this->post['mobile_number'].", Doctor Numbers ".$this->post['doctor_contact_number'].", ".$this->post['clinic_contact_number']);
			$notification_msg	=	urlencode("Dr. ".$this->post["doctor_name"]." - ".$this->post['doctor_contact_number'].", ".$this->post['clinic_name']." - ".$this->post['clinic_contact_number']." Patient - ".$this->post['patient_name']." - ".$this->post['mobile_number']." @".date("dS M Y \a\t h:i a",strtotime($this->post['date']." ".$this->post['time'])));
			
			$this->sendsms_model->send_sms("7715856018",$notification_msg); #preethika
			$this->sendsms_model->send_sms("8879652002",$notification_msg); #roshni
			$this->sendsms_model->send_sms("9619725197",$notification_msg); #sachin

			$caller_number = '+91'.$this->post['mobile_number'];
			$rs            = $this->db->query("INSERT INTO `caller_verify`(`number`)VALUES ('".$caller_number."')");
						
			echo $insert_id;
		}
		else
		{
			echo '0';
		}

		return false;
	}
	public function appointment_success()
	{
		$id	=	$this->post['appointment_id'];
		if($id)
		{
		$this->load->model(array('common_model','doctor_model','sendsms_model','mail_model'));
		
		$this->data['aptData'] = $this->doctor_model->showAppointmentDetail(array('app_id'=>$id,'column'=>array("d.name AS doctor_name","d.image AS doctor_image","d.gender AS doctor_gender","apt.date AS appointment_date","apt.doctor_id",
		"apt.time AS appointment_time","apt.patient_name AS patient_name","apt.patient_email AS patient_email",
		"d.speciality","d.qualification","c.name AS 'clinic_name'",
		"c.address AS 'clinic_address'","c.contact_number AS 'clinic_number'","c.knowlarity_number","c.knowlarity_extension","apt.reason_for_visit",
		"apt.id AS 'appointment_id'","apt.mobile_number","l.name as 'location_name'")));

		if(is_array($this->data['aptData']) && sizeof($this->data['aptData']) > 0)
		{
			$aptData	=	$this->data['aptData'] = current($this->data['aptData']);
			$msgArray= array('dr_name'        =>$aptData['doctor_name'],
			'clinic_name'    =>$aptData['clinic_name'],
			'clinic_location'=>$aptData['location_name'],
			'clinic_address'=>$aptData['clinic_address'],
			'time'           =>date('dS M Y \a\t h:i a',strtotime($aptData['appointment_date']." ".$aptData['appointment_time']))
			);
			$this->sendsms_model->send_appointment_request_sms($aptData['mobile_number'],$msgArray);
			if(!empty($aptData["patient_email"]))
			{
				$mail_arr = array(
					'name'				=>$aptData['patient_name'],
					'dr_name'			=>$aptData['doctor_name'],
					'clinic_name'		=>$aptData['clinic_name'],
					'clinic_address'	=>$aptData['clinic_address'],
					'reason_for_visit'	=>$aptData['reason_for_visit'],
					'doctor_image'			=> ($aptData['doctor_image'])? BASE_URL.$aptData['doctor_image']: IMAGE_URL."default_doctor.png" ,
					'appointment_time'           =>date('dS M Y \a\t h:i a',strtotime($aptData['appointment_date']." ".$aptData['appointment_time'])),
					'clinic_number'	=>	$aptData['clinic_number'],
					'knowlarity_number'	=>	$aptData['knowlarity_number'],
					'knowlarity_extension'	=>	$aptData['knowlarity_extension'],
				);
				$mail_res = $this->mail_model->appointmentrequest($aptData["patient_email"],$aptData["patient_name"],$mail_arr);
			}
			$this->load->view('appointment_success',$this->data);
		}
		}
	}
	function check()
	{
		$this->load->model('user_model');
		$resp = array();
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

		if($this->form_validation->run() == FALSE){
			// Invalid form details
			$resp = array("error"=>"Invalid login credentials");
		}
		else
		{
			// Check if email and password are correct
			$email    = $this->input->post('email');
			$password = $this->input->post('pass');

			$details  = $this->user_model->check_login($email, $password);
			#print_r($details);
			if($details !== FALSE){
				$resp = $this->login_user($details);
			}
			else
			{
				$resp = array("error"=>"User does not exists");
			}
		}

		echo json_encode($resp);
	}
	function login_user($details)
	{
		// Set login session
		$this->session->set_userdata('id', $details->id);
		$this->session->set_userdata('name', $details->name);
		$this->session->set_userdata('usertype', $details->type);
		$resp = array('id'            =>$details->id,'name'          =>$details->name,'email_id'      =>$details->email_id,'contact_number'=>$details->contact_number,'usertype'      =>$details->type,'gender'        =>$details->gender);
		//Check if the user is linked to facebook
		$checkfbuser = $this->user_model->check_fb_linked($details->id);
		if($checkfbuser){
			$resp['facebook_id'] = $checkfbuser->facebook_id;
			$this->session->set_userdata('facebook_id', $checkfbuser->facebook_id);
		}
		return $resp;

	}
}
