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

class Scheduler_app extends REST_Controller
{
	private $log_file = ""; 

	function __construct()
	{
		parent::__construct();
		$this->load->model(array('doctor_model','sendsms_model','mail_model','patient_model','clinic_model','appointment_model'));
	}

	public function log_message($myfile,$query)
	{
		fwrite($myfile, $query);
		return false;
	}

	function GetAppointmentsByDate_post()
	{
		$doctor_id	=	$this->post('doctor_id');
		$clinic_id	=	$this->post('clinic_id');
		$date		=	date("Y-m-d",strtotime($this->post('date')));
		$is_date	=	strtotime($this->post('date'));		
		$start		= 	date("Y-m-d 00:00:00",strtotime($date));
		$end		=	date("Y-m-d 23:59:59",strtotime($date));
		$t	=	$this->post('t');
		if(!$doctor_id || !$clinic_id || $is_date==false)
		{
			$rs = array("message"=>"please provide valid doctor_id,clinic_id and date","status" =>0);
			$this->response(array("response"=>$rs), 200);
		}

		$clinic_data = $this->doctor_model->get_clinic_timings($clinic_id);
		#echo $this->doctor_model;exit;
				
		if(sizeof($clinic_data)>0)
		{
			$availCount = $bookedCount = 0; 
			$tmpData = array();
			// blocked slots 
			$blocked_slots = $this->appointment_model->get_blocked_slots($doctor_id);#,$clinic_id
			if(!empty($blocked_slots))
			{
				$block_time_array = array();
				foreach($blocked_slots as $key=>$val)
				{
					$cur_time = strtotime($val['from_date']);
					$blockStartTime = date("Y-m-d H:i:s",$cur_time);

					$blockData[$blockStartTime]['id'] = intval($val['id']);
					$blockData[$blockStartTime]['type'] = 'blockedTimeSlot';
					$blockData[$blockStartTime]['start'] = date("Y-m-d H:i:s",strtotime($val['from_date']));
					$blockData[$blockStartTime]['end'] = date("Y-m-d H:i:s", strtotime($val['to_date']));
				}
				#print_r($blockData);
			}
			
			if(isset($blockData) && is_array($blockData))
			{
				foreach($blockData as $blockKey=>$blockVal)
				{
					if(date("Y-m-d",strtotime($blockVal['start']))	==	$date || date("Y-m-d",strtotime($blockVal['end']))	== $date)
					{
						$tmpData[$blockKey]=$blockVal;
					}
					else if($is_date>strtotime($blockVal['start']) && $is_date<strtotime($blockVal['end']))
					{
						$tmpData[$blockKey]=$blockVal;
					}
				}
				if(isset($tmpData) && is_array($tmpData) && sizeof($tmpData)>0)
				{
					$blockData	=	$tmpData; 
				}
				
			}	
		if($this->post('t')==1)
		{
			print_r($blockData);
		}
			
			//BOOKED slots 
			$data = $this->appointment_model->get_scheduler_appointment($doctor_id,$clinic_id,$start,$end);
			#echo $this->appointment_model;
			if(is_array($data) && sizeof($data)>0)
			{
				foreach($data as $key=>$val)
				{
					$cur_time = strtotime($val['DATE']." ".$val['TIME']);
					$bookedStartTime = date("Y-m-d H:i:s",$cur_time);

					$bookedData[$bookedStartTime]['id'] = intval($val['id']);
					$bookedData[$bookedStartTime]['type'] = 'appointmentFixed';
					$bookedData[$bookedStartTime]['start'] = date("Y-m-d H:i:s",$cur_time);
					$bookedData[$bookedStartTime]['end'] = date("Y-m-d H:i:s",strtotime("+".$val['duration']." minutes", $cur_time));
					$bookedData[$bookedStartTime]['patient_id'] = intval($val['patient_id']);
					$bookedData[$bookedStartTime]['patient_name'] = $val['patient_name'];
					$bookedData[$bookedStartTime]['patient_contact'] = $val['patient_contact'];
					$bookedData[$bookedStartTime]['patient_dob'] = (empty($val['dob']))?'':date("Y-m-d",strtotime($val['dob']));
					$bookedData[$bookedStartTime]['patient_gender'] = $val['patient_gender'];
					$bookedData[$bookedStartTime]['patient_email'] = $val['patient_email'];
					$bookedData[$bookedStartTime]['patient_address'] = $val['patient_address'];
					$bookedData[$bookedStartTime]['patient_image'] = $val['patient_image'];
					$bookedData[$bookedStartTime]['reason_for_visit'] = $val['reason_for_visit'];
				}
			}	

			if(isset($bookedData) && is_array($bookedData))
			{
				
				$tmpData = array_merge($bookedData,$tmpData);
				
				$bookedCount = count($bookedData);
			}	
			
			$duration	=	$clinic_data->duration;
			$timings	=	$this->doctor_model->getTimeArrayFromTimings(array('timings'=>$clinic_data->timings,'duration'=>$clinic_data->duration));
			$day = date('w', strtotime($start));
			if($t)
			{
				
				print_r($timings);exit;
			}
			$selectedDayTimings = $timings[$day];
			
			$merge_timings = array();
			if(isset($selectedDayTimings[0]) && is_array($selectedDayTimings[0]))
			{
				$merge_timings =  array_merge($merge_timings,$selectedDayTimings[0]);
			}
			if(isset($selectedDayTimings[1]) && is_array($selectedDayTimings[1]))
			{
				$merge_timings =  array_merge($merge_timings,$selectedDayTimings[1]);
			}
			#print_r($merge_timings);#exit;
			
			foreach($merge_timings as $key=>$val)
			{
				
				$cur_time = strtotime($date." ".$val);
				$availStartTime = date("Y-m-d H:i:s",$cur_time);
				
				$isBlocked = FALSE;
				if(isset($blockData) && is_array($blockData))
				{
					foreach($blockData as $blockKey=>$blockVal)
					{
						
						if($cur_time>strtotime($blockVal['start']) && $cur_time < strtotime($blockVal['end']))
						{
							$isBlocked = TRUE;			
						}
					}
				}
				if($isBlocked === FALSE)
				{
					$availData[$availStartTime]['id'] = 0;
					$availData[$availStartTime]['type'] = 'availableTimeSlot';
					$availData[$availStartTime]['start'] = $availStartTime;
					$availData[$availStartTime]['end'] = date("Y-m-d H:i:s", strtotime('+'.$duration.' minutes',$cur_time));
				}
				
			}
			
			#print_r($availData);
			#exit;
			if(isset($availData) && is_array($availData))
			{
				#print_r($tmpData);#exit;
				$tmpData = array_merge($availData,$tmpData);
				$availCount = count($availData);
			}	

			if($this->post('test'))
			{
				print_r($bookedData);
				exit;
			}
			

			if(isset($tmpData))
			{
				ksort($tmpData);
				$tmpData = array_values($tmpData);
				$rs['appointment_count'] = $bookedCount;
				$rs['slots'] = $tmpData; 
				
			}
			else
			{
				$rs = array("message"=>"no slots data available","status"=>0);
			}
		}	
		else
		{
			$rs = array("message"=>"clinic not present","status"=>0);
		}
		$this->response($rs, 200); // 200 being the HTTP response code
	}
	
	function GetAppointmentCountByDateRange_post()
	{
		$doctor_id			=	$this->post('doctor_id');
		$clinic_id			=	$this->post('clinic_id');
		$start_date			=	date("Y-m-d",strtotime($this->post('start_date')));
		$end_date				=	date("Y-m-d",strtotime($this->post('end_date')));
		$is_start_date	=	strtotime($this->post('start_date'));
		$is_end_date		=	strtotime($this->post('end_date'));
	
		if(!$doctor_id || !$clinic_id || $is_start_date==false || $is_end_date == false)
		{
			$rs = array("message"=>"please provide valid doctor_id,clinic_id and start_date,end_date","status" =>0);
			$this->response(array("response"=>$rs), 200);
		}

		$begin = new DateTime($start_date);
		$end = new DateTime($end_date);
		$end = $end->modify( '+1 day' );
		
		$interval = new DateInterval('P1D');
		$daterange = new DatePeriod($begin, $interval ,$end);
		
		foreach($daterange as $date){
			$date_array[] = $date->format("Y-m-d");
		}

		$data	=	$this->appointment_model->get_scheduler_appointment_count($doctor_id,$clinic_id,$start_date,$end_date);
		if(is_array($data) && sizeof($data)>0)
		{
			foreach($data as $key=>$val)
			{
				$tmpData[$val['start']]['count'] = intval($val['title']);
				$tmpData[$val['start']]['date'] = $val['start'];
			}
		}
		foreach($date_array as $day_key => $day_val)
		{
			if(isset($tmpData[$day_val]))
			{
				$rsData[$day_key]['date'] = $tmpData[$day_val]['date'];
				$rsData[$day_key]['count'] = intval($tmpData[$day_val]['count']);
			}
			else
			{
				$rsData[$day_key]['date'] = $day_val;
				$rsData[$day_key]['count'] = 0;
			}
			
		}
		$rs = array("date_count"=>$rsData,"status"=>1);

        $this->response($rs, 200); // 200 being the HTTP response code
	}
	
	function GetAppointmentById_post()
	{

		$appointment_id = $this->post('appointment_id');
		if($appointment_id){
			$data = $this->appointment_model->get_scheduler_appointment_byId($appointment_id);
			if($data && sizeof($data)>0){
				$cur_time = strtotime($data->DATE." ".$data->TIME);
				$tmpData['id'] = intval($data->id);
				$tmpData['type'] = "appointmentFixed";
				$tmpData['start'] = date("Y-m-d H:i:s",$cur_time);
				$tmpData['end'] = date("Y-m-d H:i:s",strtotime("+".$data->duration." minutes", $cur_time));
				$tmpData['clinic_id'] = ($data->clinic_id)?intval($data->clinic_id):0;
				$tmpData['patient_id'] = ($data->patient_id)?intval($data->patient_id):0;
				$tmpData['patient_name'] = ($data->patient_name)?$data->patient_name:"";
				$tmpData['patient_contact'] = ($data->mobile_number)?$data->mobile_number:"";
				$tmpData['reason_for_visit'] = ($data->reason_for_visit)?$data->reason_for_visit:"";
				if($data->dob)
				{
					$tmpData['patient_dob'] = date("d-m-Y",strtotime($data->dob));
				}
				$tmpData['patient_gender'] = ($data->patient_gender)?$data->patient_gender:"";
				$tmpData['patient_email'] = ($data->patient_email)?$data->patient_email:"";
				$tmpData['patient_address'] = ($data->address)?$data->address:"";
				$tmpData['patient_image'] = ($data->patient_image)?IMAGE_URL.$data->patient_image:"";
				
				$rs = array("appointment_data"=>$tmpData,"message"=>"successfull","status"=>1);
				#$rs = $tmpData;
			}else{
				$rs = array("message"=>"no appointment found","status"=>0);
			}
		}else{
			$rs = array("message"=>"please provide appointment_id","status"=>0);
		}
        $this->response($rs, 200); // 200 being the HTTP response code
			
	} 
	
	function SaveAppointment_post()
	{

		$appointment_date = date("Y-m-d",strtotime($this->post('appt_date')));
		$appointment_time = $this->post('appt_time');
		$clinic_id = $this->post('clinic_id');
		$doctor_id = $this->post('doctor_id');
		$patient_address = $this->post('patient_address'); 
		$mobile_number = $this->post('patient_contact_no');
		$patient_dob = date("Y-m-d",strtotime($this->post('patient_dob')));
		$patient_email = $this->post('patient_email');
		$patient_gender = $this->post('patient_gender');
		$patient_name = $this->post('patient_name');
		$reason_for_visit = $this->post('reason_for_visit');
		
		$appointment_id = $this->post('appt_id');
		$old_patient_contact_no = $this->post('old_patient_contact_no');
		$old_patient_id = $this->post('old_patient_id');
		$appointment_date_time	=	strtotime($appointment_date." ".$appointment_time);
		$current_time	=	strtotime("now");
		#$appointment_date $appointment_time  $clinic_id $doctor_id $patient_id
		
		
		$patient_id = $this->post('patient_id');

		$user_id = $this->post('user_id');
		

		if(empty($appointment_date) || empty($appointment_time) || empty($clinic_id) ||  empty($doctor_id))
		{
			$rs = array("message"=>"please provide appt_date,appt_time,clinic_id,doctor_id","status" =>0);
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code 
		}
		
		if($current_time>$appointment_date_time)
		{
			$rs = array("message"=>"appointment cannot be booked for past dates","status" =>0);
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code 
		}

		$time = substr($appointment_time,0,5);
		$scheduled_time = date("Y-m-d H:i:s",strtotime($appointment_date." ".$time));
		
		$data = array
		(
			'patient_name'=>$patient_name,
			'patient_email'=>$patient_email,
			'patient_gender'=>$patient_gender,
			'doctor_id'=>$doctor_id,
			'clinic_id'=>$clinic_id,
			'mobile_number'=>$mobile_number,
			'reason_for_visit'=>$reason_for_visit,
			'scheduled_time'=>$scheduled_time,
			'DATE'=>$appointment_date,
			'TIME'=>$time,
			'status' => 1,
			'confirmation' => 1
		);
		
		//	if patient does not exist then add the patient
		if(!$patient_id)
		{
			$patient_data = array
			(
				'email'=>$patient_email,
				'name'=>$patient_name,
				'gender'=>$patient_gender,
				'address'=>$patient_address,
				'email'=>$patient_email,
				'dob' => $patient_dob,
				'mobile_number'=>$mobile_number
			);
			
			$patient_id = $this->patient_model->insert_patient($patient_data); 
			if($patient_id)
			{
				$patient_doctor_data	=	array(
																	'doctor_id'=>$doctor_id,
																	'patient_id'=>$patient_id
																);
				
				$patient_doctor_id = $this->patient_model->insert_patient_doctor_map($patient_doctor_data); 
			}
			

		}
		else
		{
			if($user_id == "")
			{
				$patient_data = array(
					'email'=>$patient_email,
					'name'=>$patient_name,
					'gender'=>$patient_gender,
					'address'=>$patient_address,
					'email'=>$patient_email,
					'dob' => $patient_dob,
					'mobile_number'=>$mobile_number
				);
				$this->patient_model->update_patient($patient_data,$patient_id); 
			}
		}
		
		$data['patient_id'] = $patient_id;
		
		if($appointment_id == "")
		{
			$appointment_id	=	$this->appointment_model->get_appointments_by_status($scheduled_time,$doctor_id,$clinic_id);
			if($appointment_id)
			{
				$rs = array("message"=>"The time slot you have selected for your appointment is already booked. Kindly choose another time",
				"status" =>0);			
				$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code 
			}		

			$appointment_id	=	$this->appointment_model->add_appointment_details($data);
			if($appointment_id)
			{
				//send sms to patient_model
				$doctor_data = $this->doctor_model->get_doctor_name($doctor_id);
				$clinic_data = $this->clinic_model->get_clinic_data($clinic_id);
				
				$sms_array = array
				(
					'dr_name' => $doctor_data->name,
					'doctor_image' => $doctor_data->image,
					'clinic_name' => $clinic_data->name,
					'clinic_address' => $clinic_data->address." ". $clinic_data->location,
					'clinic_contact' => $clinic_data->contact_number,
					'time' => date("D, jS M, Y h:i a",$appointment_date_time)
				);
	
				$this->sendsms_model->send_appointment_confirmation_sms($mobile_number,$sms_array);
				
				if($patient_email){
					// send email to patient
					$mail_array = array
					(
						'name' => $patient_name,
						'dr_name' => $doctor_data->name,
						'clinic_name' => $clinic_data->name,
						'clinic_address' => $clinic_data->address." ". $clinic_data->location,
						'clinic_number' => $clinic_data->contact_number,
						'appointment_time' => date("D, jS M, Y h:i a",$appointment_date_time),
						'reason_for_visit'=>$reason_for_visit
					);
					$this->mail_model->appointmentconfirmation($patient_email, $patient_name,$mail_array);
				}
				$this->appointment_model->edit_appointment_details($appointment_id,array('city_id'=>$clinic_data->city_id));
				$rs = array("message"=>"successfully added appointment","status"=>1);

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
				$rs = array("message"=>"successfully edited appointment","status"=>1);
			}
			else 
			{
				$rs = array("message"=>"The time slot you have selected for your appointment is already booked. Kindly choose another time","status" =>0,
				"erorr"=>$this->db->_error_message());
			}
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code 
		}
	}

	function RecheduleAppointment_post()
	{
		$appointment_id = $this->post('appointment_id');
		$doctor_id = $this->post('doctor_id');
		$clinic_id = $this->post('clinic_id');
		$mobile_number = $this->post('patient_contact_no');
		$patient_email = $this->post('patient_email');
		$patient_name = $this->post('patient_name');
		$re_date = date("Y-m-d",strtotime($this->post('date')));
		$re_time = date("H:i:s",strtotime($this->post('appt_time')));
		$is_re_date_time	= strtotime($re_date." ".$re_time);
		$user_type	=	($this->post('user_type'))?$this->post('user_type'):2;
		
		
		if(empty($appointment_id) || empty($doctor_id) || empty($mobile_number) ||  empty($patient_name) || $is_re_date_time==false)
		{
			$rs = array("message"=>"please provide appointment_id,doctor_id,clinic_id,patient_contact_no,patient_name,date,appt_time ","status" =>0);
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code 
		}

		if(!is_numeric($mobile_number))
		{
			$rs = array("message"=>"please provide patient_contact_no in 888888888 format ","status"=>0);	
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code 
		}
		$re_date_time	= date("Y-m-d H:i:s",strtotime($re_date." ".$re_time));
		$data = array
				(
					'clinic_id'=>$clinic_id,
					'date'=>$re_date,
					'time'=>$re_time,
					'scheduled_time'=>$re_date_time
				);
		if($user_type==1)
		{
			$data['status']	=	1;	
			$data['confirmation']	=	0;	
		}		
		//echo "<pre>".print_r($data,true); exit;

		if($appointment_id)
		{
			$this->appointment_model->edit_appointment_details($appointment_id, $data);
		}
		
		if ($this->db->affected_rows())
		{
            $rs = array("message"=>"successfully rescheduled appointment","status"=>1);
			if($user_type!=1)
			{
	            //send sms to patient_model - doctor name, clinic name,location,time,contact no
	            $doctor_data = $this->doctor_model->get_doctor_name($doctor_id);
	            $clinic_data = $this->clinic_model->get_clinic_data($clinic_id);
	            
				$sms_array = array
				(
					'dr_name' => $doctor_data->name,
					'clinic_name' => $clinic_data->name,
					'clinic_location' => $clinic_data->address." ". $clinic_data->location,
					'clinic_contact' => $clinic_data->contact_number,
					'time' => $re_date." ".$re_time
				);
				#echo "<pre>".print_r($sms_array,true);
				$this->sendsms_model->send_appointment_confirmation_sms($mobile_number,$sms_array);
				
				if($patient_email)
				{
					// send email to patient if email id exists
					$mail_array = array
					(
						'name' => $patient_name,
						'dr_name' => $doctor_data->name,
						'clinic_name' => $clinic_data->name,
						'clinic_address' => $clinic_data->address." ". $clinic_data->location,
						'clinic_number' => $clinic_data->contact_number,
						'new_scheduled_time'=>$re_date." ".$re_time
					);
					$this->mail_model->appointment_rescheduled($patient_email, $patient_name,$mail_array);
				}
			}
		}
		else
		{
            $rs = array("message"=>"The time slot you have selected for your appointment is already booked. Kindly choose another time","status" =>0,
			"error"=>$this->db->_error_message());
        }
        $this->response(array("response"=>$rs), 200); // 200 being the HTTP response code 
	}

	function DeleteAppointment_post()
	{
		$appointment_id = $this->post('appointment_id');
		#$contact = $this->post('contact_number');
		$doctor_id = $this->post('doctor_id');
		$clinic_id = $this->post('clinic_id');
		
		
		if($appointment_id) {
			$apt_rs = $this->db->query("select scheduled_time,reason_for_visit,patient_name,patient_email,mobile_number from appointment where id=".$appointment_id);
			$apt_row = $apt_rs->row_array();
			
			
			$affected_rows = $this->appointment_model->cancel_appointment_by_id($appointment_id);
			if($affected_rows)
			{
				if($doctor_id && $clinic_id)
				{
					//send sms to patient_model
					$doctor_data = $this->doctor_model->get_doctor_name($doctor_id);
					$clinic_data = $this->clinic_model->get_clinic_data($clinic_id);
					
					if(!empty($apt_row['mobile_number']))
					{
						$contact	=	$apt_row['mobile_number'];
						$sms_array = array(
							'dr_name'			=>	$doctor_data->name,
							'clinic_name'		=>	$clinic_data->name,
							'clinic_location'	=>	$clinic_data->address." ". $clinic_data->location,
							'clinic_contact'	=>	$clinic_data->contact_number,
							'time'				=>	$apt_row['scheduled_time']
						);
						$this->sendsms_model->send_appointment_cancellation_sms($contact,$sms_array);
					}
					if(!empty($apt_row["patient_email"]))
					{
						/*$mail_arr = array(
								'name'				=>$apt_row['patient_name'],
								'dr_name'			=>$doctor_data->name,
								'clinic_name'		=>$clinic_data->name,
								'clinic_address'	=>$clinic_data->address." ". $clinic_data->location,
								'reason_for_visit'	=>$apt_row['reason_for_visit'],
								'doctor_image'		=> ($doctor_data->image)? BASE_URL.$doctor_data->image: IMAGE_URL."default_doctor.png" ,
								);
						$mail_res = $this->mail_model->appointmentcancellation($apt_row["patient_email"],$aptData["patient_name"],$mail_arr);*/
					}
				
				
				}
				$rs = array("message"=>"successfully deleted appointment","status"=>1);
			}
			else
			{
				$rs = array("message"=>"no such appointment or appointment allready deleted","status"=>0);
			}
		}
		else
		{
            $rs = array("message"=>"please provide appointment_id","status" =>0,"erorr"=>$this->db->_error_message());
		}
		$this->response(array("response"=>$rs), 200);
	}
	
	function BlockSlot_post()
	{
		$doctor_id = intval($this->post('doctor_id'));
		$clinic_id = intval($this->post('clinic_id'));
		$from_date = date("Y-m-d H:i:s",strtotime($this->post('start_date_time')));
		$to_date = date("Y-m-d H:i:s",strtotime($this->post('end_date_time')));
		
		$is_from_date	= 	strtotime($this->post('start_date_time'));
		$is_to_date		= 	strtotime($this->post('end_date_time'));
		
		if(!$doctor_id || $is_from_date==false || $is_to_date==false)
		{
			$rs = array("message"=>"please provide doctor_id and start_date_time and end_date_time","status" =>0);
			$this->response(array("response"=>$rs), 200);
		}
		//check if any appointment is scheduled in that time slot
		$cancelled_appointments = $this->appointment_model->get_appointments_by_date_range($from_date,$to_date,$doctor_id,$clinic_id);
		
		if(!empty($cancelled_appointments)){
			$appointment_id_arr = array();
			foreach($cancelled_appointments as $a)
			{
				$appointment_id_arr[] = $a['id'];
			}
			//cancel appoitnments of that time slot
			$this->appointment_model->cancel_slot_appointments($appointment_id_arr);
			
			if ($this->db->affected_rows()) {
				//send_sms to the patients for appointment cancellation
				
				/*$sms_array = array(
				'dr_name' => $doctor_data->name,
				'clinic_name' => $clinic_data->name,
				'clinic_location' => $clinic_data->address." ". $clinic_data->location,
				'clinic_contact' => $clinic_data->contact_number,
				'time' => $re_date." ".$re_time
				);
				echo "<pre>".print_r($sms_array,true);
				$this->sendsms_model->send_appointment_confirmation_sms($mobile_number,$sms_array);*/
			}
		}
		
		$data = array(
		'doctor_id' => $doctor_id,
		'clinic_id'=> $clinic_id,
		'from_date'=> $from_date,
		'to_date'=> $to_date
		);
		
		$insert_id = $this->appointment_model->block_time_slots($data);
		if ($this->db->affected_rows()) {
			$sql	=	"SELECT u.name,u.email_id,u.contact_number FROM USER u JOIN doctor d ON d.user_id=u.`id` WHERE d.id=".$doctor_id;
			$user_rs	=	 $this->db->query($sql);
			if($user_rs->num_rows()>0)
			{
					$user_details	=	$user_rs->row();
					if(!empty($user_details->email_id) && !empty($user_details->name))
					{
						$this->mail_model->block_appointments_update($user_details->email_id,$user_details->name,$from_date,$to_date);
					}
					if(!empty($user_details->contact_number))
					{
						$this->sendsms_model->block_appointments_update($user_details->contact_number,array('from_date'=>$from_date,'to_date'=>$to_date));
					}
					
			}
			$rs = array("blocked_id"=>$insert_id,"message"=>"successfully blocked slot","status"=>1);
		} else{
		$rs = array("message"=>"block failed","status" =>0,"erorr"=>$this->db->_error_message());
		}
		$this->response(array("response"=>$rs), 200);
    }

    function DeleteBlockSlot_post()
	{
		$blocked_id = $this->post('block_slot_id');
		if(!$blocked_id){
			$rs = array("message"=>"please provide block_slot_id","status" =>0);
			$this->response(array("response"=>$rs), 200);
		}
		$slot_data	=	$this->appointment_model->get_blocked_slots(0,0,$blocked_id);
		$this->appointment_model->delete_blocked_slots($blocked_id);
		if ($this->db->affected_rows()) {
			#process to shoot mail
			$slot_data	=	 current($slot_data);
			$from_date = date("Y-m-d H:i:s",strtotime($slot_data['from_date']));
			$to_date = date("Y-m-d H:i:s",strtotime($slot_data['to_date']));
			$sql	=	"SELECT u.name,u.email_id,u.contact_number FROM USER u JOIN doctor d ON d.user_id = u.`id` 
			JOIN schedule_block sc ON sc.`doctor_id`=d.id WHERE d.id = ".$slot_data['doctor_id']." AND sc.id=".$blocked_id;
			$user_rs	=	 $this->db->query($sql);
			if($user_rs->num_rows()>0)
			{
				$user_details	=	$user_rs->row();
				if(!empty($user_details->email_id) && !empty($user_details->name))
				{
					$this->mail_model->unblock_slot($user_details->email_id,$user_details->name,$from_date,$to_date);
				}
				if(!empty($user_details->contact_number))
				{
					$this->sendsms_model->unblock_appointments_update($user_details->contact_number,array('from_date'=>$from_date,'to_date'=>$to_date));
				}
			}
			#process to shoot mail
						
			$rs = array("message"=>"blocked slot delete successful","status"=>1);
		}
		else
		{
			$rs = array("message"=>"block delete failed","status" =>0,"erorr"=>$this->db->_error_message());
		}
		$this->response(array("response"=>$rs), 200);
	}
	
	function GetAllPatientsByDoctorId_post()
	{
		$doctor_id			=	$this->post('doctor_id');
		$page_id				=	intval($this->post('page_id'));
		$patient_name		=	$this->post('patient_name');
		$patient_email	=	$this->post('patient_email');
		$page_id				=	($page_id)?$page_id:1;	
		$limit					=	1000;#LIMIT;
		$offset					=	($page_id-1)*$limit;
		$t							=	$this->post('t');
		
		if(!$doctor_id)
		{
			$rs = array("message"=>"please provide doctor id","status" =>0);
			$this->response(array("response"=>$rs), 200);
		}
		$patient_data 	= $this->patient_model->get_patient_list_without_appt(array('doctor_id'=>$doctor_id,'limit'=>$limit,'offset'=>$offset,'patient_name'=>$patient_name,'patient_email'=>$patient_email));
		if($t)
		{
			echo $this->patient_model;exit;
		}
		$patient_count 	= $this->patient_model->get_patient_list_without_appt_count(array('doctor_id'=>$doctor_id,'patient_name'=>$patient_name,'patient_email'=>$patient_email));
		
		if(is_array($patient_data) && sizeof($patient_data)>0)
		{
			foreach($patient_data as $key=>$val)
			{
				$tmp_data[$key]['user_id']		=	intval($val['user_id']); // integer
				$tmp_data[$key]['patient_id']		=	intval($val['id']); // integer
				$tmp_data[$key]['patient_address']	=	($val['address'])?$val['address']:''; // string
				$tmp_data[$key]['patient_contact']	= 	($val['mobile_number'])?$val['mobile_number']:'';  // string
				$tmp_data[$key]['patient_dob']		= 	($val['dob'])?date("d-m-Y",strtotime($val['dob'])):''; // string date in yyyy-mm-dd format
				$tmp_data[$key]['patient_email']	= 	$val['email']; // string
				$tmp_data[$key]['patient_gender']	= 	($val['gender'])?$val['gender']:'';// string
				$tmp_data[$key]['patient_name']		= 	($val['name'])?$val['name']:'';// string
				$tmp_data[$key]['patient_image']	= 	($val['image'])? BASE_URL.$val['image']:'';

			}	
			if(isset($tmp_data) && is_array($tmp_data) && sizeof($tmp_data)>0)
			{
				$rs = array("patients"=>$tmp_data,"count"=>$patient_count,"status" =>1,"next_page"=>$page_id+1);
				$this->response(array("response"=>$rs), 200);
				
			}
		}
		else
		{
			$rs = array("message"=>"No patients registered for this doctor id","status" =>0);
			$this->response(array("response"=>$rs), 200);

		}
	}
	
	function GetAvailableSlotByDate_post()
	{
		$doctor_id	=	$this->post('doctor_id');
		$date		=	date("Y-m-d",strtotime($this->post('date')));
		$clinic_id	=	$this->post('clinic_id');
		$is_date	=	strtotime($this->post('date'));		
		#get_appointments_by_date
		if(!$doctor_id || !$clinic_id && $is_date==false)
		{
			$rs = array("message"=>"please provide doctor_id,clinic_id and date","status" =>0);
			$this->response(array("response"=>$rs), 200);
			
		}
		$available_slots	=	$this->appointment_model->get_available_slots_by_date($doctor_id,$clinic_id,$date);
		if(is_array($available_slots)	&& sizeof($available_slots)>0)
		{
			$rs = array("slots"=>$available_slots,"status" =>1);
		}
		else
		{
			$rs = array("message"=>"no slots available","status" =>0);
		}	
		$this->response(array("response"=>$rs), 200);
	}

	function GetAvailableSlotByDate1_post()
	{
		$doctor_id	=	$this->post('doctor_id');
		$date		=	date("Y-m-d",strtotime($this->post('date')));
		$clinic_id	=	$this->post('clinic_id');
		$is_date	=	strtotime($this->post('date'));		
		#get_appointments_by_date
		if(!$doctor_id || !$clinic_id && $is_date==false)
		{
			$rs = array("message"=>"please provide doctor_id,clinic_id and date","status" =>0);
			$this->response(array("response"=>$rs), 200);
			
		}
		$available_slots	=	$this->appointment_model->get_available_slots_by_date1($doctor_id,$clinic_id,$date);
		print_r($available_slots);
		if(is_array($available_slots)	&& sizeof($available_slots)>0)
		{
			$rs = array("slots"=>$available_slots,"status" =>1);
		}
		else
		{
			$rs = array("message"=>"no slots available","status" =>0);
		}	
		$this->response(array("response"=>$rs), 200);
	}
	
	function AddPatient_post()
	{
		$doctor_id			=	$this->post('doctor_id');
		$clinic_id			=	$this->post('clinic_id');
		$patient_email	=	($this->post('patient_email'))?$this->post('patient_email'):NULL;
		$patient_name		=	$this->post('patient_name');
		$patient_gender		=	($this->post('patient_gender'))?$this->post('patient_gender'):NULL;
		$patient_address	=	($this->post('patient_address'))?$this->post('patient_address'):NULL; 
		$patient_dob 		=	($this->post('patient_dob'))? date("Y-m-d",strtotime($this->post('patient_dob'))):NULL;
		$mobile_number		=	$this->post('patient_contact_no');
		$image				=	($this->post('image'))?$this->post('image'):NULL;
		
		$is_patient_dob	=	strtotime($this->post('patient_dob'));
				
		if(empty($doctor_id) ||empty($clinic_id)  ||empty($patient_name) ||empty($mobile_number))
		{
			$rs = array("message"=>"please provide doctor_id, clinic_id, patient_name, patient_contact_no","status"=>0);	
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code 
		}
		if($patient_dob && $is_patient_dob==false)
		{
			$rs = array("message"=>"please provide valid date of birth","status"=>0);	
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code 
		}
		
		if(!is_numeric($mobile_number))
		{
			$rs = array("message"=>"please provide patient_contact_no in \"888888888\" format ","status"=>0);	
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code 
		}

		$file_log = DOCUMENT_ROOT."logs/scheduler_app_log_".date("Y-m-d").".log";
		$this->log_file = fopen($file_log, "a+"); 

		$this->log_message($this->log_file,"post_data: ".json_encode($this->post).NEW_LINE);

		$patient_data = array
												(
													'image'=>$image,
													'name'=>$patient_name,
													'gender'=>$patient_gender,
													'address'=>$patient_address,
													'email'=>$patient_email,
													'dob' => $patient_dob,
													'mobile_number'=>$mobile_number
												);
		
		$patient_id = $this->patient_model->insert_patient($patient_data);
		$this->log_message($this->log_file,"query: ".$this->db->last_query().NEW_LINE);
		if($patient_id)
		{
			$patient_doctor_data	=	array(
																'doctor_id'=>$doctor_id,
																'patient_id'=>$patient_id
															);
			
			$patient_doctor_id = $this->patient_model->insert_patient_doctor_map($patient_doctor_data); 

			$rs = array("message"=>"successfully added patient","patient_id"=>$patient_id,"status"=>1);	
		}
		else
		{
			$rs = array("message"=>"patient not added","status"=>0,"erorr"=>$this->db->_error_message());	
		}			
		$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code 
	}
	
	function EditPatient_post()
	{
			#$user_id					=	$this->post('user_id');
			$patient_id				=	$this->post('patient_id');
			$patient_email		=	$this->post('patient_email');
			$patient_name			=	$this->post('patient_name');
			$patient_gender		=	$this->post('patient_gender');
			$patient_address	=	$this->post('patient_address'); 
			$patient_dob			=	$this->post('patient_dob');
			$mobile_number		=	$this->post('patient_contact_no');
			$image						=	$this->post('image');

			$is_patient_dob	=	strtotime($this->post('patient_dob'));
			
			if(empty($patient_id))
			{
				$rs = array("message"=>"please provide patient_id","status"=>0);	
				$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code 
			}

			if($patient_dob)
			{
				if($is_patient_dob==false)
				{
					$rs = array("message"=>"please provide valid date of birth","status"=>0);	
					$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code 
				}
				$patient_dob	=	 date("Y-m-d",$is_patient_dob);
			}
			
			if(!empty($mobile_number) && !is_numeric($mobile_number))
			{
				$rs = array("message"=>"please provide patient_contact_no in \"888888888\" format ","status"=>0);	
				$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code 
			}

		$patient_data = array();
		if($patient_email)
		{
			$patient_data['email']=$patient_email;
		}
		if($patient_name)
		{
			$patient_data['name']=$patient_name;
		}
		if($patient_gender)
		{
			$patient_data['gender']=$patient_gender;
		}
		if($patient_address)
		{
			$patient_data['address']=$patient_address;
		}
		if($patient_dob)
		{
			$patient_data['dob']=$patient_dob;
		}
		if($mobile_number)
		{
			$patient_data['mobile_number']=$mobile_number;
		}
		if($image)
		{
			$patient_data['image']	=	$image;
		}
		if(sizeof($patient_data)==0)
		{
			$rs = array("message"=>"please proivde atleast one paramteter to update from patient_email, patient_name, patient_gender, patient_address, patient_dob, patient_contact_no, image","status"=>0);	
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code 
		}
		$this->patient_model->update_patient($patient_data,$patient_id); 

		
		if($this->db->affected_rows()>0)
		{
			$rs = array("message"=>"successfully updated patient","patient_id"=>$patient_id,"status"=>1);	
		}
		else
		{
			$rs = array("message"=>"patient not updated","status"=>0,"erorr"=>$this->db->_error_message());	
		}
		$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code 
	}	
	
	function get_appt_verification_number_post()
	{
		$rs = array("date"=>"02249425883","status"=>1);	

		$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code 
	
	}
	

}

