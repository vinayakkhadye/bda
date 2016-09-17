<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');

class appointment_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->model(array('user_model','sendsms_model','mail_model'));
	}
	
	public function count_all_records($tablename)
	{
		return $this->db->count_all($tablename);
	}
	
	function get_all_appointments($limit, $start)
	{
		$this->db->select('appointment.id, appointment.patient_name, appointment.patient_email, appointment.patient_gender, appointment.doctor_id, appointment.clinic_id, appointment.city_id, appointment.reason_for_visit, appointment.date, appointment.time, appointment.mobile_number, appointment.consultation_type, appointment.status, appointment.confirmation, appointment.added_on, city.name as city_name, location.name as locality_name, doctor.name as doctor_name, doctor.speciality, doctor.other_speciality, clinic.other_location, clinic.contact_number as clinic_number');#, speciality.name as speciality_name
		$this->db->from('appointment');
		$this->db->join('doctor', 'appointment.doctor_id = doctor.id');
		$this->db->join('clinic', 'appointment.clinic_id = clinic.id');
		$this->db->join('location', 'clinic.location_id = location.id');
		$this->db->join('city', 'clinic.city_id = city.id');
		#$this->db->join('speciality', 'doctor.speciality = speciality.id');
		$this->db->where('appointment.status', '1');
		$this->db->order_by('added_on', 'desc');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		//echo $this->db->last_query();
		if($query->num_rows() > 0)
		{
			foreach($query->result() as $row)
			{
				$data[] = $row;
			}
			return $data;
		}
		return false;
	}
	
	function delete_appointment($apptid)
	{
		$this->db->where('id', $apptid);
		$this->db->update('appointment', array('status'=>'-1'));
	}
	
	function confirm_appointment($apptid)
	{
		$this->db->where('id', $apptid);
		$this->db->update('appointment', array('confirmation'=>'1'));
	}
	
	function edit_patient_details_appt($apptid, $pname, $pgender, $pmob, $pemail)
	{
		$data = array(
			'patient_name'=>$pname,
			'patient_email'=>$pemail,
			'patient_gender'=>$pgender,
			'mobile_number'=>$pmob
		);
		$this->db->where('id', $apptid);
		$this->db->update('appointment', $data);
	}
	function get_scheduler_appointment($doctor_id,$clinic_id,$start,$end){

		$this->db->select('appointment.id,appointment.patient_id,patient_name AS \'title\',patient_gender, reason_for_visit ,DATE,TIME,clinic.duration,appointment.mobile_number,appointment.patient_email,patient.dob,patient.address as patient_address,patient.image as patient_image,patient_name,appointment.mobile_number as \'patient_contact\'');
		$this->db->from('appointment');
		$this->db->join('doctor', 'appointment.doctor_id = doctor.id');
		$this->db->join('clinic', 'appointment.clinic_id = clinic.id');
		$this->db->join('patient', 'appointment.patient_id = patient.id','left');
		$this->db->order_by('appointment.DATE asc,appointment.TIME asc');
		$this->db->where('appointment.doctor_id', $doctor_id);
		$this->db->where('appointment.status', 1);
		$this->db->where('appointment.confirmation', 1);
		if($clinic_id != '0')
			$this->db->where('appointment.clinic_id', $clinic_id);
		$this->db->where('DATE >=', $start);
		$this->db->where('DATE <=', $end);
		$query = $this->db->get();
		#echo $this->db->last_query();
		if($query->num_rows() > 0){
			return $query->result_array();
		}
		return false;
	}	
	function get_scheduler_appointment_count($doctor_id,$clinic_id,$start,$end){

		$this->db->select('count(1) as "title",DATE as "start"');
		$this->db->from('appointment');
		$this->db->join('doctor', 'appointment.doctor_id = doctor.id');
		$this->db->join('clinic', 'appointment.clinic_id = clinic.id');
		$this->db->group_by('appointment.DATE asc'); 
		$this->db->where('appointment.doctor_id', $doctor_id);
		$this->db->where('appointment.status', 1);
		$this->db->where('appointment.confirmation', 1);
		if($clinic_id != '0')
			$this->db->where('appointment.clinic_id', $clinic_id);
		$this->db->where('DATE >=', $start);
		$this->db->where('DATE <=', $end);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result_array();
		}
		return false;
	}
	function get_scheduler_appointment_byId($appointment_id){

		$this->db->select('appointment.id, patient_name, patient_email, patient_gender,patient.image as patient_image, reason_for_visit, appointment.mobile_number, appointment.clinic_id, DATE, TIME, clinic.duration, patient.id as patient_id, patient.user_id, patient.address, patient.dob');
		$this->db->from('appointment');
		$this->db->join('doctor', 'appointment.doctor_id = doctor.id');
		$this->db->join('clinic', 'appointment.clinic_id = clinic.id');
		$this->db->join('patient', 'appointment.patient_id = patient.id');
		$this->db->order_by('appointment.DATE asc,appointment.TIME asc');
		$this->db->where('appointment.id', $appointment_id);
		$query = $this->db->get();
	
//		echo $this->db->last_query();exit;
		if($query->num_rows() > 0){
			return $query->row();
		}
		return false;
	}	
	function add_appointment_details($data)
	{
		$this->db->insert('appointment', $data);
		return $this->db->insert_id();
	}
	function edit_appointment_details($apptid, $data)
	{
		$this->db->where('id', $apptid);
		$this->db->update('appointment', $data);
		
	}
	function get_appointments_by_date($date,$doctor_id,$clinic_id){
		$this->db->select('appointment.id, patient_name, patient_email, doctor_id, clinic_id,mobile_number,TIME');
		$this->db->from('appointment');
		$this->db->where('date', $date);
		$this->db->where('doctor_id', $doctor_id);
		$this->db->where('clinic_id', $clinic_id);
		
		$query = $this->db->get();
	
		#echo $this->db->last_query();exit;
		if($query->num_rows() > 0){
			return $query->result();
		}
		return false;
	}
	
	
	function get_patients_details_by_id($id){
		$this->db->select('patient.id,patient.name,patient.gender,patient.address,patient.email,patient.mobile_number,patient.dob');
		$this->db->from('patient');
		$this->db->order_by('patient.name asc');
		$this->db->where('patient.id', $id); 
		$query = $this->db->get();
	
//		echo $this->db->last_query();
		if($query->num_rows() > 0){
			return $query->result_array();
		}
		return false;
	}
	
	function block_time_slots($data){
		$this->db->insert('schedule_block', $data);
		return $this->db->insert_id();
	}
	
	function cancel_appointment_by_id($appointment_id){
		$data = array("status" => 0);
		$this->db->where('id', $appointment_id);
		$this->db->update('appointment', $data);
		return 	$this->db->affected_rows();
	}
	function get_appointment_by_id($appointment_id){
		$this->db->from('appointment');
		$this->db->where('id', $appointment_id);
		$query = $this->db->get();
		#echo $this->db->last_query();exit;
		if($query->num_rows() > 0){
			return $query->row();
		}
		return false;
	}
	
	function cancel_slot_appointments($appointment_ids){
		$data = array("status" => 0);
		$this->db->where_in('id', $appointment_ids);
		$this->db->update('appointment', $data);
	}
	
	function get_appointments_by_date_range($from, $to,$doctor_id='',$clinic_id=''){
		$this->db->select('id');
		$this->db->from('appointment');
		if($doctor_id){
			$this->db->where("doctor_id",$doctor_id); 	
		}
		if($clinic_id){
			$this->db->where("clinic_id",$clinic_id); 	
		}

		$this->db->where("scheduled_time BETWEEN '$from' and '$to'"); 
		$query = $this->db->get();
	
		#echo $this->db->last_query();exit;
		if($query->num_rows() > 0){
			return $query->result_array();
		}
		return false;
	}
	
	function get_blocked_slots($doctor_id=0,$clinic_id=0,$id=0){
		$this->db->select();
		$this->db->from('schedule_block');
		if($doctor_id)
		{
			$this->db->where("doctor_id",$doctor_id);
		}
		if($id)
		{
			$this->db->where("id",$id);
		}

		if($clinic_id)
		{
			$this->db->where("clinic_id",$clinic_id);
		}
		//$this->db->where("scheduled_time BETWEEN '$from' and '$to'"); 
		$query = $this->db->get();
	
		//echo $this->db->last_query();
		if($query->num_rows() > 0){
			return $query->result_array();
		}
		return false;
	}
	
	function delete_blocked_slots($blocked_id){

		$this->db->delete('schedule_block', array('id' => $blocked_id));
	
	}
	function get_available_slots_by_date($doctor_id,$clinic_id,$date)
	{
		$is_date	=	strtotime($date);		
		if(!$doctor_id || !$clinic_id && $is_date==false)
		{
			return false; 
		}
		
		$this->db->select('duration');
		$this->db->from('clinic');
		$this->db->limit(1,0);
		$this->db->where("id",$clinic_id);
		$query = $this->db->get();
		#echo $this->db->last_query();
		
		if($query->num_rows() > 0)
		{
			$duration	=	$query->row()->duration;
			
			$booked_time = array();
			$booked_data	=	$this->get_appointments_by_date($date,$doctor_id,$clinic_id);
			foreach($booked_data as $key=>$val)
			{
				$booked_time[]= date('g:i a', strtotime($val->TIME));
			}	
			
			$blocked_time	=array();
			#$blocked_data	=	$this->get_blocked_slots($doctor_id,$clinic_id);
			$blocked_data	=	$this->get_blocked_slots($doctor_id,0);
			#print_r($blocked_data);exit;
			foreach($blocked_data as $key=>$val)
			{
				
				if(date("Y-m-d",strtotime($val['from_date']))	==	$date || date("Y-m-d",strtotime($val['to_date']))	== $date)
				{
				
					//$tmpData[$blockKey]=$blockVal;
					$blocked_time_range	=	create_time_range($val['from_date'],$val['to_date'],$duration." mins");
					$blocked_time		=	array_merge($blocked_time_range,$blocked_time);				
				}
				else if($is_date>strtotime($val['from_date']) && $is_date<strtotime($val['to_date']))
				{
					$blocked_time_range	=	create_time_range($val['from_date'],$val['to_date'],$duration." mins");
					$blocked_time		=	array_merge($blocked_time_range,$blocked_time);				
					#print_r($blocked_time_range);
					
					#print_r($val);var_dump($date);exit; 

					//$tmpData[$blockKey]=$blockVal;
				}
			}	
			
			

			$time_range	=	create_time_range($date." 08:00:00",$date." 23:59:59",$duration." mins");
			#print_r($booked_time);print_r($blocked_time);
			if(is_array($booked_time) && sizeof($booked_time)>0)
			{
				$time_range	=	array_diff($time_range,$booked_time);	
			}
			if(is_array($blocked_time) && sizeof($blocked_time)>0)
			{
				$time_range	=	array_diff($time_range,$blocked_time);	
			}
			
			
			#print_r($time_range);exit;
			if(is_array($time_range)	&& sizeof($time_range)>0)
			{
				$cnt	=	0 ;
				foreach($time_range as $key=>$val)
				{
					$cur_time = strtotime($date." ".$val);
					$tmp_data[$cnt]['id']		=	0;
					$tmp_data[$cnt]['type']		=	"availableTimeSlot";
					$tmp_data[$cnt]['start']	=	date("Y-m-d H:i:s",$cur_time);
					$tmp_data[$cnt]['end']		=	date("Y-m-d H:i:s",strtotime("+".$duration." minutes", $cur_time));
					$cnt ++;
				}
				ksort($tmp_data);
				return $tmp_data;
			}
			else
			{
				return false;
			}	
			
			
		}
		return false;
	}

	function get_available_slots_by_date1($doctor_id,$clinic_id,$date)
	{
		$is_date	=	strtotime($date);		
		if(!$doctor_id || !$clinic_id && $is_date==false)
		{
			return false; 
		}
		
		$this->db->select('duration');
		$this->db->from('clinic');
		$this->db->limit(1,0);
		$this->db->where("id",$clinic_id);
		$query = $this->db->get();
		#echo $this->db->last_query();
		
		if($query->num_rows() > 0)
		{
			$duration	=	$query->row()->duration;
			
			$booked_time = array();
			$booked_data	=	$this->get_appointments_by_date($date,$doctor_id,$clinic_id);
			foreach($booked_data as $key=>$val)
			{
				$booked_time[]= date('g:i a', strtotime($val->TIME));
			}	
			
			$blocked_time	=array();
			#$blocked_data	=	$this->get_blocked_slots($doctor_id,$clinic_id);
			$blocked_data	=	$this->get_blocked_slots($doctor_id,0);
			#print_r($blocked_data);exit;
			foreach($blocked_data as $key=>$val)
			{
				$blocked_time_range	=	create_time_range($val['from_date'],$val['to_date'],$duration." mins");
				#$blocked_time[]= date('g:i a', strtotime($val->TIME));
				$blocked_time		=	array_merge($blocked_time_range,$blocked_time);
			}	
			

			$time_range	=	create_time_range($date." 08:00:00",$date." 23:59:59",$duration." mins");
			$time_range	=	array_diff($time_range,$booked_time,$blocked_time);
			if(is_array($time_range)	&& sizeof($time_range)>0)
			{
				$cnt	=	0 ;
				foreach($time_range as $key=>$val)
				{
					$cur_time = strtotime($date." ".$val);
					$tmp_data[$cnt]['id']		=	0;
					$tmp_data[$cnt]['type']		=	"availableTimeSlot";
					$tmp_data[$cnt]['start']	=	date("Y-m-d H:i:s",$cur_time);
					$tmp_data[$cnt]['end']		=	date("Y-m-d H:i:s",strtotime("+".$duration." minutes", $cur_time));
					$cnt ++;
				}
				ksort($tmp_data);
				return $tmp_data;
			}
			else
			{
				return false;
			}	
			
			
		}
		return false;
	}

	function __toString(){
		return $this->db->last_query();
	}
}