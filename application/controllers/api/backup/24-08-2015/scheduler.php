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

class Scheduler extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
		#$this->_parseParams();
		$this->load->model(array('doctor_model','sendsms_model','mail_model','patient_model','clinic_model','appointment_model'));
    }
	
	/*	private function _parseParams() 
	{
		$method = $this->router->method;
		$this->$method();
	}*/	
	
	function get_appointments_get()
	{
		$doctor_id = $this->get('did');
		$clinic_id = $this->get('cid');
		$start = $this->get('start');
		$end = $this->get('end');
		$view = $this->get('view');
		$count = 0;
		
		$blocked_slots = $this->appointment_model->get_blocked_slots($doctor_id);
		#echo $this->appointment_model;
		if(!empty($blocked_slots)){
			foreach($blocked_slots as $key=>$val){
				$tmpData[$count]['id'] = $val['id'];
				$tmpData[$count]['type'] = 'blockedSlot';
				$tmpData[$count]['start'] = date("Y-m-d H:i:s",strtotime($val['from_date']));
				$tmpData[$count]['end'] = date("Y-m-d H:i:s", strtotime($val['to_date']));
				$tmpData[$count]['rendering'] = "background";
				$tmpData[$count]['color'] = "#000";
				$tmpData[$count]['overlap'] = false;
				$count++;
			}
			$rs = $tmpData;
		}

		if($start && $end ){

			if($clinic_id != ""){

				//fetch background events (get time slot availability)
				$clinic_data = $this->doctor_model->get_clinic_timings($clinic_id);
				
				if(sizeof($clinic_data)>0){
					$timings = json_decode($clinic_data->timings);
					if($view == "agendaDay"){
						$day = date('w', strtotime($start));
						$selectedDayTimings = $timings[$day];
						foreach($selectedDayTimings as $key=>$val){
							if($val[0] != "" && $val[1]!= "") {
								$tmpData[$count]['id'] = 'availableTimeSlot';
								$tmpData[$count]['start'] = date("Y-m-d H:i:s",strtotime($start." ".$val[0]));
								$tmpData[$count]['end'] = date("Y-m-d H:i:s", strtotime($start." ".$val[1]));
								$tmpData[$count]['rendering'] = "background";
								
								$count++;
							}
						}
					}else if($view == "agendaWeek"){
						$timings = json_decode($clinic_data->timings);
						$weekbegin = new DateTime( $start );
						$weekend = new DateTime( $end );

						$interval = DateInterval::createFromDateString('1 day');
						$period = new DatePeriod($weekbegin, $interval, $weekend);
						foreach ( $period as $dt ){
							$cdate = $dt->format( "l Y-m-d" );
							$day = date('w', strtotime($cdate));
							$selectedDayTimings = $timings[$day];
							foreach($selectedDayTimings as $key=>$val){
								if($val[0] != "" && $val[1]!= ""){
									$tmpData[$count]['id'] = 'availableTimeSlot';
									$tmpData[$count]['start'] = date("Y-m-d H:i:s",strtotime($cdate." ".$val[0]));
									$tmpData[$count]['end'] = date("Y-m-d H:i:s", strtotime($cdate." ".$val[1]));
									$tmpData[$count]['rendering'] = "background";
									$count++;
								}
							}
						}
					}
					if(isset($tmpData)){
						$rs = $tmpData;
						$count = count($tmpData);
					}
				}	

				//get appointments 
				$data = $this->appointment_model->get_scheduler_appointment($doctor_id,$clinic_id,$start,$end);
				if(is_array($data) && sizeof($data)>0){
					foreach($data as $key=>$val){
						$cur_time = strtotime($val['DATE']." ".$val['TIME']);
						$tmpData[$count]['id'] = $val['id'];
						if($view == "agendaDay"){
							$tmpData[$count]['title'] = $val['title']." (".ucfirst($val['patient_gender']).")"." - ".$val['reason_for_visit'];
							$tmpData[$count]['mobile_number'] = $val['mobile_number'];
							$tmpData[$count]['patient_email'] = $val['patient_email'];
							$tmpData[$count]['patient_name'] = $val['title'];
							$tmpData[$count]['reason_for_visit'] = $val['reason_for_visit'];
						}else if($view == "agendaWeek"){
							$tmpData[$count]['title'] = $val['title']." (".ucfirst($val['patient_gender']).")";
							$tmpData[$count]['mobile_number'] = $val['mobile_number'];
							$tmpData[$count]['patient_email'] = $val['patient_email'];
							$tmpData[$count]['patient_name'] = $val['title'];
						}
						$tmpData[$count]['start'] = date("Y-m-d H:i:s",$cur_time);
						$tmpData[$count]['end'] = date("Y-m-d H:i:s",strtotime("+".$val['duration']." minutes", $cur_time));
						//$tmpData[$count]['constraint'] = 'availableTimeSlot';
						$count++;
					}
					$rs = $tmpData;
				}
				//$rs = array("appointment_data"=>$tmpData,"message"=>"successfull","status"=>1);
			}
		}
		if(!isset($rs))
			$rs = array("message"=>"unsuccessful","status"=>0);
			
        $this->response($rs, 200); // 200 being the HTTP response code
	}

	function get_appointments_count_get()
	{
		$doctor_id = $this->get('did');
		$clinic_id = $this->get('cid');
		$start = $this->get('start');
		$end = $this->get('end');
		if($start && $end ){
			$data = $this->appointment_model->get_scheduler_appointment_count($doctor_id,$clinic_id,$start,$end);
			if(is_array($data) && sizeof($data)>0){
				foreach($data as $key=>$val){
					$tmpData[$key]['title'] = $val['title'];
					$tmpData[$key]['start'] = $val['start'];
					$tmpData[$key]['editable'] = false;
				}
				$rs = $tmpData;
			}else{
				$rs = array("message"=>"unsuccessful","status"=>0);
			}
		}else{
			$rs = array("message"=>"unsuccessful","status"=>0);
		}
        $this->response($rs, 200); // 200 being the HTTP response code
	}
	
	function save_appointment_post()
	{

		$appointment_id = $this->post('appt_id');
		$doctor_id = $this->post('doctor_id');
		$clinic_id = $this->post('clinic_id');
		$old_patient_id = $this->post('old_patient_id');
		$old_patient_contact_no = $this->post('old_patient_contact_no');
		$patient_id = $this->post('patient_id');
		$user_id = $this->post('user_id');
		$patient_name = $this->post('patient_name');
		$mobile_number = $this->post('patient_contact_no');
		$patient_email = $this->post('patient_email');
		$patient_gender = $this->post('patient_gender');
		$patient_dob = date("Y-m-d",strtotime($this->post('patient_dob')));
		$patient_address = $this->post('patient_address'); 
		$reason_for_visit = $this->post('reason_for_visit');
		$appointment_date = date("Y-m-d",strtotime($this->post('appt_date')));
		$appointment_time = $this->post('appt_time');
		$time = substr($appointment_time,0,5);
		$scheduled_time = date("Y-m-d H:i:s",strtotime($appointment_date." ".$time));
		
		$patient_id = $this->patient_model->get_patientid_byemail($patient_email);
		
		$data = array(
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
		
//		if patient does not exist already then add the patient
		if(!$patient_id){
			$patient_data = array(
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

		}else{
			if($user_id == ""){
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
		
		if($appointment_id == ""){
			$this->appointment_model->add_appointment_details($data);
			
			//send sms to patient_model
            $doctor_data = $this->doctor_model->get_doctor_name($doctor_id);
            $clinic_data = $this->clinic_model->get_clinic_data($clinic_id);
            
			$sms_array = array(
				'dr_name' => $doctor_data->name,
				'clinic_name' => $clinic_data->name,
				'clinic_location' => $clinic_data->address." ". $clinic_data->location,
				'clinic_contact' => $clinic_data->contact_number,
				'time' => $appointment_date." ".$appointment_time
			);
			/*echo "<pre>".print_r($sms_array,true);*/
			$this->sendsms_model->send_appointment_confirmation_sms($mobile_number,$sms_array);
			
			if($patient_email){
				// send email to patient
				$mail_array = array(
					'name' => $patient_name,
					'dr_name' => $doctor_data->name,
					'clinic_name' => $clinic_data->name,
					'clinic_location' => $clinic_data->address." ". $clinic_data->location,
					'clinic_contact' => $clinic_data->contact_number,
					'time' => $appointment_time
				);
				$this->mail_model->appointment_confirmation($patient_email, $patient_name,$mail_array);
//				echo(print_r($mail_array,true));exit;
			}
	
		}else{
			$this->appointment_model->edit_appointment_details($appointment_id, $data);
			//if patient is changed.. send sms to prev user for appointment cancellation
			if($old_patient_id !== $patient_id){
				//send sms to patient_model
	            $doctor_data = $this->doctor_model->get_doctor_name($doctor_id);
	            $clinic_data = $this->clinic_model->get_clinic_data($clinic_id);
	            
				$sms_array = array(
					'dr_name' => $doctor_data->name,
					'clinic_name' => $clinic_data->name,
					'clinic_location' => $clinic_data->address." ". $clinic_data->location,
					'clinic_contact' => $clinic_data->contact_number,
					'time' => $appointment_date." ".$appointment_time
				);
				//echo "<pre>".print_r($sms_array,true);
				$this->sendsms_model->send_appointment_cancellation_sms($old_patient_contact_no,$sms_array);
			}
		}
		
		if ($this->db->affected_rows()) {
            $rs = array("message"=>"successfully added appointment","status"=>1);
        }
        else {
            $rs = array("message"=>"appointment not added","status" =>0,"erorr"=>$this->db->_error_message());
        }
        $this->response(array("response"=>$rs), 200); // 200 being the HTTP response code 
	}
	
	function get_appointment_by_id_get()
	{
		$appointment_id = $this->get('id');
		if($appointment_id){
			$data = $this->appointment_model->get_scheduler_appointment_byId($appointment_id);
			if($data && sizeof($data)>0){
				
				$cur_time = strtotime($data->DATE." ".$data->TIME);
				$tmpData['id'] = $data->id;
				$tmpData['patient_name'] = $data->patient_name;
				$tmpData['patient_gender'] = $data->patient_gender;
				$tmpData['reason_for_visit'] = $data->reason_for_visit;
				$tmpData['patient_contact_no'] = $data->mobile_number;
				$tmpData['clinic_id'] = $data->clinic_id;
				$tmpData['patient_id'] = $data->patient_id;
				$tmpData['user_id'] = $data->user_id;
				$tmpData['patient_email'] = $data->patient_email;
				$tmpData['patient_address'] = $data->address;
				$tmpData['patient_dob'] = date("d-m-Y",strtotime($data->dob));
				$tmpData['appointment_time'] = date("H:i",$cur_time);
				//$tmpData['patient_end_time'] = date("Y-m-d H:i:s",strtotime("+".$data->duration." minutes", $cur_time));
				
				$rs = array("appointment_data"=>$tmpData,"message"=>"successfull","status"=>1);
				$rs = $tmpData;
			}else{
				$rs = array("message"=>"unsuccessfull","status"=>0);
			}
		}else{
			$rs = array("message"=>"unsuccessfull","status"=>0);
		}
        $this->response($rs, 200); // 200 being the HTTP response code
	}
	
	function delete_appointment_post()
	{
		$appointment_id = $this->post('appt_id');
		$contact = $this->post('contact');
		$doctor_id = $this->post('doctor_id');
		$clinic_id = $this->post('clinic_id');
		
		if($appointment_id) {
			$this->appointment_model->cancel_appointment_by_id($appointment_id);
			
			#echo $this->appointment_model;
			//send sms to patient_model
			$doctor_data = $this->doctor_model->get_doctor_name($doctor_id);
			$clinic_data = $this->clinic_model->get_clinic_data($clinic_id);
			$apt_data	=	$this->appointment_model->get_appointment_by_id($appointment_id);
					
			$sms_array = array(
				'dr_name' => $doctor_data->name,
				'clinic_name' => $clinic_data->name,
				'clinic_location' => $clinic_data->address." ". $clinic_data->location,
				'clinic_contact' => $clinic_data->contact_number,
				'time' => $apt_data->scheduled_time
			);
			//echo "<pre>".print_r($sms_array,true);
			$this->sendsms_model->send_appointment_cancellation_sms($contact,$sms_array);
      $rs = array("message"=>"successfully deleted appointment","status"=>1);
		}else{
            $rs = array("message"=>"appointment not deleted","status" =>0,"erorr"=>$this->db->_error_message());
		}
		$this->response(array("response"=>$rs), 200);
	}
	
	function reschedule_appointment_post()
	{
		$appointment_id 	= $this->post('appt_id');
		$doctor_id 				= $this->post('doctor_id');
		$clinic_id 				= $this->post('clinic_id');
		$mobile_number 		= $this->post('mobile_number');
		$patient_email 		= $this->post('patient_email');
		$patient_name 		= $this->post('patient_name');
		
		$dr_name					=	$this->post('dr_name');
		$clinic_address 	= $this->post('clinic_address');
		$clinic_name 			= $this->post('clinic_name');
		$reason_for_visit = $this->post('reason_for_visit');
		$clinic_number 		= $this->post('clinic_number');
		
		
		$re_date = date("Y-m-d",strtotime($this->post('re_date')));
		$re_time = $this->post('re_time');
		$data = array(
			'clinic_id'=>$clinic_id,
			'DATE'=>$re_date,
			'TIME'=>$re_time
		);
		//echo "<pre>".print_r($data,true); exit;

		if($appointment_id) {
			$this->appointment_model->edit_appointment_details($appointment_id, $data);
		}
		
		if ($this->db->affected_rows()) {
            $rs = array("message"=>"successfully rescheduled appointment","status"=>1);
            //send sms to patient_model - doctor name, clinic name,location,time,contact no
            
            $doctor_data = $this->doctor_model->get_doctor_name($doctor_id);
            $clinic_data = $this->clinic_model->get_clinic_data($clinic_id);
            
			$sms_array = array(
				'dr_name' => $doctor_data->name,
				'clinic_name' => $clinic_data->name,
				'clinic_location' => $clinic_data->address." ". $clinic_data->location,
				'clinic_contact' => $clinic_data->contact_number,
				'time' => $re_date." ".$re_time
			);
			#echo "<pre>".print_r($sms_array,true);
			$this->sendsms_model->send_appointment_confirmation_sms($mobile_number,$sms_array);
			
			if($patient_email){
				// send email to patient if email id exists
				$mail_array = array(
					'name' => $patient_name,
					'dr_name' => $doctor_data->name,
					'clinic_name' => $clinic_data->name,
					'clinic_location' => $clinic_data->address." ". $clinic_data->location,
					'clinic_contact' => $clinic_data->contact_number,
					'time' => $re_date." ".$re_time
				);
				$this->mail_model->appointment_confirmation($patient_email, $patient_name,$mail_array);
			}
			
			
        } else {
            $rs = array("message"=>"appointment not rescheduled","status" =>0,"erorr"=>$this->db->_error_message());
        }
        $this->response(array("response"=>$rs), 200); // 200 being the HTTP response code 
	}
	
	function change_clinic_id_post()
	{
		$clinic_id = $this->post('id');
		$duration = $this->post('duration');
		$this->session->set_userdata('scheduler_clinic_id',$clinic_id);
		$this->session->set_userdata('scheduler_clinic_duration',$duration);
		$rs = array("message"=>"success","status"=>1);
		$this->response(array("response"=>$rs), 200);
	}
	
	function set_scheduler_view_post()
	{
		$view = $this->post('view');
		$this->session->set_userdata('scheduler_view',$view);
		$rs = array("message"=>"success","status"=>1);
		$this->response(array("response"=>$rs), 200);
	}
	
	function block_slot_post()
	{
		
		$doctor_id = $this->post('doctor_id');
		$clinic_id = $this->post('clinic_id');
		$from_date = date("Y-m-d H:i:s",strtotime($this->post('block_start_date')));
		$to_date = date("Y-m-d H:i:s",strtotime($this->post('block_end_date')));
		$doctor_email	=	$this->post('doctor_email');
		$doctor_name	=	$this->post('doctor_name');
		$contact_number	=	$this->post('contact_number');
		
		if(!$doctor_id){
		    $rs = array("message"=>"please provide doctor_id","status" =>0);
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
						if($doctor_email && $doctor_name)
						{
							$this->mail_model->block_appointments_update($doctor_email,$doctor_name,$from_date,$to_date);
						}
						if($contact_number)
						{
							$this->sendsms_model->block_appointments_update($contact_number,array('from_date'=>$from_date,'to_date'=>$to_date));

						}
            $rs = array("blocked_id"=>$insert_id,"message"=>"successfully blocked slot","status"=>1);
        } else{
            $rs = array("message"=>"block failed","status" =>0,"erorr"=>$this->db->_error_message());
        }
        $this->response(array("response"=>$rs), 200);
    }
    
		function delete_blocked_slots_post()
		{
			$blocked_id = $this->post('id');
			$doctor_email	=	$this->post('doctor_email');
			$doctor_name	=	$this->post('doctor_name');
			$contact_number	=	$this->post('contact_number');
			
			$slot_data	=	$this->appointment_model->get_blocked_slots(0,0,$blocked_id);
			if(!$blocked_id){
				$rs = array("message"=>"please provide block id","status" =>0);
			}
			$this->appointment_model->delete_blocked_slots($blocked_id);
			if ($this->db->affected_rows())
			{
				if($doctor_email && $doctor_name)
				{
					$slot_data	=	 current($slot_data);
					$from_date = date("Y-m-d H:i:s",strtotime($slot_data['from_date']));
					$to_date = date("Y-m-d H:i:s",strtotime($slot_data['to_date']));
					$this->mail_model->unblock_slot($doctor_email,$doctor_name,$from_date,$to_date);
				}
				if($contact_number)
				{
					$this->sendsms_model->unblock_appointments_update($contact_number,array('from_date'=>$from_date,'to_date'=>$to_date));
				}

				$rs = array("message"=>"blocked slot delete successful","status"=>1);
			}
			else
			{
				$rs = array("message"=>"block delete failed","status" =>0,"erorr"=>$this->db->_error_message());
			}
			$this->response(array("response"=>$rs), 200);
		}
}

