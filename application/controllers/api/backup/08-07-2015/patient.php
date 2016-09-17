<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
* Example
*
* This is an example of a few basic user interaction methods you could use
* all done with a hardcoded array.
*
* @package        CodeIgniter
* @subpackage    Rest Server
* @category    Controller
* @author        Phil Sturgeon
* @link        http://philsturgeon.co.uk/code/
*/

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH.'/libraries/REST_Controller.php';

class Patient extends REST_Controller
{
	private $log_file = ""; 

	function __construct()
	{
		parent::__construct();
		$this->load->model(array('user_model','patient_model','common_model','appointment_model','sms_package_model'));
	}
	public function log_message($myfile,$query)
	{
		fwrite($myfile, $query);
		#file_put_contents(DOCUMENT_ROOT."logs/" .$log_file,$query,FILE_APPEND);
		#$this->load->view('errors/page_missing.tpl.php',$this->data);
		return false;
	}
	
	function profile_post()
	{
		$user_id   	= intval($this->post('user_id'));
		$patient_id = intval($this->post('patient_id'));
		$t   = intval($this->post('t'));
		
		if(empty($user_id) && empty($patient_id))
		{
			$rs        = array("message"=>"Please Provide user_id or patient_id","status" =>0);
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		}
		
		if($user_id)
		{
			$data = $this->patient_model->get_patient_details($user_id);
		}
		else if($patient_id)
		{
			$data = $this->patient_model->get_patient_details_byid($patient_id);
		}

		if($t)
		{
			echo $this->patient_model;
			var_dump($data);
		}
		if($data)
		{
			if(empty($data->image))
			{
				if(strtolower($data->gender) == "m")
				{
					$data->image = "./static/images/default_404.jpg";
				}else if(strtolower($data->gender) == "f")
				{
					$data->image = "./static/images/default_404.jpg";
				}else
				{
					$data->image = "./static/images/default_404.jpg";
				}
			}
			$from = new DateTime($data->dob);
			$to   = new DateTime('today');
			$age = $from->diff($to)->y;
			$data->age = $age;
			$rs = array("patient_data"=>$data,"message"=>"successful","status"=>1);
		}
		else
		{
			$rs = array("message"=>"no such user","status" =>0);
		}
		$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
	}
	function communication_post()
	{
		$user_id   = intval($this->post('user_id'));
		$t   = intval($this->post('t'));
		
		if(empty($user_id))
		{
			$rs        = array("message"=>"Please Provide user_id","status" =>0);
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		}
		$data = $this->sms_package_model->get_communication_for_user($user_id);
		if($t)
		{
			echo $this->patient_model;
			var_dump($data);
		}
		if($data)
		{

			$rs = array("communication_data"=>$data,"message"=>"successful","status"=>1);
		}
		else
		{
			$rs = array("message"=>"no communications available","status" =>0);
		}
		$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
	}

	function updatebasicprofile_post()
	{
		$user_id    = intval($this->post('user_id'));
		#$patient_id	= intval($this->post('patient_id'));
		$name = ($this->post('name'))?$this->post('name'):'';
		$gender = ($this->post('gender'))?strtoupper($this->post('gender')):'';
		$dob = ($this->post('dob'))?date("Y-m-d H:i:s",strtotime($this->post('dob'))):'';
		$is_dob	=	strtotime($this->post('dob'));
		$image_path	=	$this->post('image_path');
		$mobile_number = ($this->post('mob'))?$this->post('mob'):'';
		
		if(empty($user_id))
		{
			$rs        = array("message"=>"Please provide user_id","status" =>0);
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		}
		
		if (!empty($mobile_number) && !is_numeric($mobile_number) && strlen($mobile_number) <= 9)
		{
				$rs = array("message"=>"Please provide valid mobile number","status" =>0);
				$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		}
		
		if(!empty($gender) && !in_array($gender,array('M','F','O')))
		{
				$rs = array("message"=>"Please provide gender (M,F,O)","status" =>0);
				$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		
		}
		if(!empty($dob) && $is_dob==false)
		{
				$rs = array("message"=>"Please provide valid dob","status" =>0);
				$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		}
		if(!empty($dob) && $is_dob>time())
		{
				$rs = array("message"=>"Future date cannot be on valid dob","status" =>0);
				$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		}
		#var_dump($user_id);var_dump($patient_id);exit;
		if(!empty($name))$data['name']	=	$name;
		if(!empty($gender))$data['gender']	=	$gender;
		if(!empty($dob))$data['dob']	=	$dob;
		if(!empty($image_path))$data['image']	=	$image_path;
		if(!empty($mobile_number))$data['mobile_number']	=	$mobile_number;
		if(!isset($data))
		{
			$rs = array("message"=>"please provide details to update","status"=>0);
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		}
		$this->patient_model->update_patient($data,0,$user_id);
		$rs = array("profile_data"=>"basic profile updated","message"=>"updated basic profile successful","status"=>1);
		/*if($this->db->affected_rows())
		{
			$rs = array("profile_data"=>"basic profile updated","message"=>"successfully updated basic profile","status"=>1);
		}
		else
		{
			if($mobile_number){
				$mobile_exists = $this->user_model->get_all_userdetails_by_contact_number($mobile_number);
				if($mobile_exists){
					$rs = array("message"=>"user mobile number already used by another user","status" =>0);
					$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
				}
			}
			#$rs = array("message"=>"basic profile not updated","status" =>0,"erorr"  =>$this->db->_error_message());
		}*/
		
		$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
	}

	function save_appointment_post()
	{

		$appointment_date = date("Y-m-d",strtotime($this->post('appt_date')));
		$appointment_time = $this->post('appt_time');
		$clinic_id = $this->post('clinic_id');
		$doctor_id = $this->post('doctor_id');
		$mobile_number = $this->post('patient_contact_no');
		$patient_email = $this->post('patient_email');
		$patient_name = $this->post('patient_name');
		$reason_for_visit = $this->post('reason_for_visit');
		
		$appointment_id = $this->post('appt_id');
		$city_id = $this->post('city_id');
		
		$old_patient_contact_no = $this->post('old_patient_contact_no');
		$old_patient_id = $this->post('old_patient_id');
		$appointment_date_time	=	strtotime($appointment_date." ".$appointment_time);
		$current_time	=	strtotime("now");
		#$appointment_date $appointment_time  $clinic_id $doctor_id $patient_id
		
		$patient_id = $this->post('patient_id');
		$user_id = $this->post('user_id');
		

		if(empty($appointment_date) || empty($appointment_time) || empty($clinic_id) ||  empty($doctor_id) ||  empty($city_id))
		{
			$rs = array("message"=>"please provide appt_date,appt_time,clinic_id,doctor_id,city_id","status" =>0);
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code 
		}
		
		if($current_time>$appointment_date_time)
		{
			$rs = array("message"=>"appointment cannot be booked for past dates","status" =>0);
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code 
		}

		$file_log = DOCUMENT_ROOT."logs/appointment_log_".date("Y-m-d").".log";
		$this->log_file = fopen($file_log, "a+"); 
		$this->log_message($this->log_file,json_encode($this->post).NEW_LINE);
		
		$time = substr($appointment_time,0,5);
		$scheduled_time = date("Y-m-d H:i:s",strtotime($appointment_date." ".$time));
		$this->load->model(array('appointment_model','doctor_model','clinic_model'));
		
		$data = array
		(
			'patient_name'=>$patient_name,
			'patient_email'=>$patient_email,
			'doctor_id'=>$doctor_id,
			'clinic_id'=>$clinic_id,
			'mobile_number'=>$mobile_number,
			'reason_for_visit'=>$reason_for_visit,
			'scheduled_time'=>$scheduled_time,
			'city_id'=>$city_id,
			'DATE'=>$appointment_date,
			'TIME'=>$time,
			'status' => 1,
			'confirmation' => 0,
			'from_app' => 1
		);
		
		if($user_id)
		{
			$patient_id = $this->patient_model->get_patientid_byuserid($user_id);
			if($patient_id==false)
			{
				$rs = array("message"=>"Invalid User please login by patient account to book an appointmnet","status" =>0);
				$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code 
			}
		}
		else
		{
			$user_id = NULL;
			$patient_id = $this->patient_model->get_patientid_byemail($patient_email);
			if($patient_id==false)
			{
				$patient_id = $this->patient_model->insert_patient(array('email'=>$patient_email,'name'=>$patient_name,'mobile_number'=>$mobile_number));
				$patient_doctor_data	=	array('doctor_id'=>$doctor_id,'patient_id'=>$patient_id);
				$patient_doctor_id = $this->patient_model->insert_patient_doctor_map($patient_doctor_data); 
			}
		}


		$data['patient_id'] = $patient_id;
		
		if($appointment_id == "")
		{
			//print_r($data);
			$appointment_id	=	$this->appointment_model->add_appointment_details($data);
			if($appointment_id)
			{
				//send sms to patient_model
				$doctor_data = $this->doctor_model->get_doctor_name($doctor_id);
				
				$clinic_data = $this->clinic_model->get_clinic_data($clinic_id);
				
				$sms_array = array
				(
					'dr_name' => $doctor_data->name,
					'clinic_name' => $clinic_data->name,
					'clinic_address' => $clinic_data->address." ". $clinic_data->location,
					'clinic_contact' => $clinic_data->contact_number,
					'time' => $appointment_date." ".$appointment_time
				);
	
				#$this->sendsms_model->send_appointment_confirmation_sms($mobile_number,$sms_array);
				$this->sendsms_model->send_appointment_request_sms($mobile_number,$sms_array);
				
				if($patient_email){
					// send email to patient
					$mail_array = array
					(
						'name' => $patient_name,
						'dr_name' => $doctor_data->name,
						'doctor_image'			=> ($doctor_data->image)? BASE_URL.$doctor_data->image: IMAGE_URL."default_doctor.png" ,
						'clinic_name' => $clinic_data->name,
						'clinic_address' => $clinic_data->address." ". $clinic_data->location,
						'clinic_contact' => $clinic_data->contact_number,
						'time' => $appointment_time,
						'reason_for_visit'	=>$reason_for_visit,
						'appointment_time'  =>date('dS M Y \a\t h:i a',strtotime($scheduled_time)),
						'clinic_number'	=>	$clinic_data->contact_number,
						'knowlarity_number'	=>	$clinic_data->knowlarity_number,
						'knowlarity_extension'	=>	$clinic_data->knowlarity_extension,
					);
					
					#$this->mail_model->appointmentconfirmation($patient_email, $patient_name,$mail_array);
					$mail_res = $this->mail_model->appointmentrequest($patient_email,$patient_name,$mail_array);
				}
				$rs = array("message"=>"successfully added appointment","status"=>1,"data"=>$appointment_id,"call_to_verify"=>"02249425883");

			}
			else
			{
				$rs = array("message"=>"The time slot you have selected for your appointment is already booked. Kindly choose another time",
				"status" =>0,"error"=>$this->db->_error_message());
			}
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code 
		}
		else
		{
			$this->appointment_model->edit_appointment_details($appointment_id, $data);
			$affected_rows	=	$this->db->affected_rows();
			//if patient is changed. send sms to prev user for appointment cancellation
			if($old_patient_id !== $patient_id)
			{
				//send sms to patient_model
				$doctor_data = $this->doctor_model->get_doctor_name($doctor_id);
				$clinic_data = $this->clinic_model->get_clinic_data($clinic_id);
	            
				$sms_array = array
				(
					'dr_name' => $doctor_data->name,
					'clinic_name' => $clinic_data->name,
					'clinic_location' => $clinic_data->address." ". $clinic_data->location,
					'clinic_contact' => $clinic_data->contact_number,
					'time' => $appointment_date." ".$appointment_time
				);
				//echo "<pre>".print_r($sms_array,true);
				$this->sendsms_model->send_appointment_cancellation_sms($old_patient_contact_no,$sms_array);
			}
			if ($affected_rows) 
			{
				$rs = array("message"=>"successfully edited appointment","status"=>1,"call_to_verify"=>"02249425883");
			}
			else 
			{
				$rs = array("message"=>"The time slot you have selected for your appointment is already booked. Kindly choose another time","status" =>0,
				"erorr"=>$this->db->_error_message());
			}
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code 
		}
	}
	
	function get_appointment_post()
	{
		$type				=	$this->post('type');
		$patient_id	=	$this->post('patient_id');
		$doctor_id	=	$this->post('doctor_id');
		$page				=	intval($this->post('page'));
		$t					=	$this->post('t');
		$limit			=	1000;
		if(empty($doctor_id))
		{
			if(empty($type) || empty($patient_id))
			{
				$rs = array("message"=>"please provide type, patient_id","status" =>0);
				$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code 
			}

			if(!in_array($type,array('past','upcoming')))
			{
				$rs = array("message"=>"allowed types are past or upcoming","status" =>0);
				$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code 
			}
		}
		
		if($doctor_id && !is_numeric($doctor_id))
		{
			$rs = array("message"=>"please provide valid doctor_id","status" =>0);
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code 
		}
		if(!is_numeric($patient_id))
		{
			$rs = array("message"=>"please provide valid patient_id","status" =>0);
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code 
		}
		
		if($doctor_id)
		{
			#$limit	=	LIMIT;
		}
		if($type	==	"past")
		{
			$limit	=	LIMIT;
		}
		
		$offset	=	0;
		if($page)
		{
			$offset	=	($page-1)*$limit;
		}

		$this->load->model(array('appointment_model'));
		
		$data = $this->appointment_model->get_all_appointments($limit,$offset,$type,$patient_id,$doctor_id);
		if($t)
		{
			echo $this->appointment_model;exit;
			print_r($data);exit;
		}

		if(is_array($data) && sizeof($data)>0)
		{
			foreach($data as $key=>$val)
			{
				$speciality	=	 array();
				#print_r($val);exit;
				if(!empty($val->speciality))
				{
					$speciality	=	$this->common_model->getSpeciality(array('ids'=>$val->speciality,'column'=>array('name')));
				}
				$cur_time = strtotime($val->scheduled_time);
				$bookedStartTime = $key;#date("Y-m-d H:i:s",$cur_time);
				
				$rs[$bookedStartTime]['id'] = intval($val->id);
				$rs[$bookedStartTime]['user_id'] = intval($val->user_id);
				$rs[$bookedStartTime]['date'] = date("d/m/Y",$cur_time);
				$rs[$bookedStartTime]['start'] = date("h:i a",$cur_time);
				#$rs[$bookedStartTime]['end'] = date("Y-m-d H:i:s",strtotime("+".$val->duration." minutes", $cur_time));
				$rs[$bookedStartTime]['doctor_name'] = $val->doctor_name;
				$rs[$bookedStartTime]['reason_for_visit'] = $val->reason_for_visit;
				
				$rs[$bookedStartTime]['doctor_image'] = $val->doctor_image;
				
				if(empty($val->doctor_image))
				{
					if(strtolower($val->doctor_gender) == "m")
					{
						$rs[$bookedStartTime]['doctor_image'] = BASE_URL."static/images/default_doctor.png";
					}
					else if(strtolower($val->doctor_gender) == "f")
					{
						$rs[$bookedStartTime]['doctor_image'] = BASE_URL."static/images/female_doctor.jpg";
					}
					else if(strtolower($val->doctor_gender) == "o")
					{
						$rs[$bookedStartTime]['doctor_image'] = BASE_URL."static/images/default_404.jpg";
					}
					else
					{
						$rs[$bookedStartTime]['doctor_image'] = BASE_URL."static/images/default_404.jpg";
					}
				}
				else
				{
					if(strpos($val->doctor_image,"http") !== false)
					{
						$rs[$bookedStartTime]['doctor_image'] = $val->doctor_image;
					}
					else
					{
						$rs[$bookedStartTime]['doctor_image'] = BASE_URL.$val->doctor_image."?wm";
					}
				}
				
				$rs[$bookedStartTime]['speciality'] = $speciality;
				$rs[$bookedStartTime]['other_speciality'] = ($val->other_speciality)?$val->other_speciality:'';
				$rs[$bookedStartTime]['doctor_id'] = $val->doctor_id;
				$rs[$bookedStartTime]['clinic_name'] = $val->clinic_name;
				$rs[$bookedStartTime]['clinic_id'] = $val->clinic_id;
				$rs[$bookedStartTime]['locality_name'] = ucwords($val->locality_name);
				$rs[$bookedStartTime]['city_name'] = ucwords($val->city_name);
				$rs[$bookedStartTime]['status'] = ($val->status==1)?'scheduled':'Cancelled';
				$rs[$bookedStartTime]['confirmation'] = ($val->confirmation==1)?'Confirmed':'Pending';

				$rs[$bookedStartTime]['mobile_number'] = $val->mobile_number;
				$rs[$bookedStartTime]['patient_name'] = $val->patient_name;
				$rs[$bookedStartTime]['patient_email'] = $val->patient_email;
			}
			$rs = array("message"=>"successful","status"=>1,"appointments"=>$rs);
			if($page)
			{
				$rs['next_page']	=	$page+1;
			}
		}
		else
		{
			$rs = array("message"=>"no appointments","status"=>0);
		}	
		$this->response($rs, 200); // 200 being the HTTP response code
	}


}

