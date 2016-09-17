<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');

class mail_model extends CI_Model
{
	private $log_file = ""; 

	function __construct()
	{
		parent::__construct();
		$this->load->library('mandrill');
	}
	public function log_message($myfile,$query)
	{
		fwrite($myfile, $query);
		return false;
	}
	
	function sendmail($to_email, $to_name, $subject, $message)
	{
		if(!empty($to_email) && !empty($to_name))
		{
			$file_log = DOCUMENT_ROOT."logs/mail.log";
			$this->log_file = fopen($file_log, "a+"); 

	    $mandrill = new Mandrill($this->config->item('mandrill_api_key'));
	    $message = array(
	        'html' => $message,
	        'subject' => $subject,
	        'from_email' => 'noreply@bookdrappointment.com',
	        'from_name' => 'BookDrAppointment',
	        'to' => array(
	            array(
	                'email' => $to_email,
	                'name' => $to_name,
	                'type' => 'to'
	            )
	        )
	    );
	    $async = false;
	    $result = $mandrill->messages->send($message, $async);
			$this->log_message($this->log_file,"subject: ".$subject.", to_email:".$to_email.", time:".date("Y-m-d h:i a").NEW_LINE);
			#$this->log_message($this->log_file,json_encode($result).NEW_LINE);
			$this->log_message($this->log_file,"--------------------------------------------".NEW_LINE);

		return $result;
		}
		return false;
	}

	function changepasswordmail($to_email, $to_name)
	{

		$html = $this->load->view('mailers/Password_Successfully_Changed', array('to_name'=>$to_name), true);
		$subject = 'BDA Password Successfully Reset';
		return $this->sendmail($to_email, $to_name, $subject, $html);

	}

	function sendresetpasswordmail($to_email, $to_name, $code)
	{
		$resetcode = "http://www.bookdrappointment.com/resetpassword?email=$to_email&code=$code";
		$html = $this->load->view('mailers/Reset_Password_Request',array('resetcode'=>$resetcode,'to_name'=>$to_name),true);
		$subject = 'Reset your BDA Password';
		return $this->sendmail($to_email, $to_name, $subject, $html);
	}

	function appointmentrequest($to_email, $to_name,$a=array())
	{
		$html = $this->load->view('mailers/Appointment_Requested', array('name'=>$a['name'],'dr_name'=>$a['dr_name'],'clinic_name'=>$a['clinic_name'],'clinic_address'=>$a['clinic_address'],'reason_for_visit'=>$a['reason_for_visit'],'doctor_image'=>$a['doctor_image'],'appointment_time'=>$a['appointment_time'],'clinic_number'=>$a['clinic_number']), true);
		$subject = 'Appointment Request: '.$a['name'].','.$a['appointment_time'];
		return $this->sendmail($to_email, $to_name, $subject, $html);
		#------------

	}

	function appointment_confirmation($to_email, $to_name,$a=array())
	{
		$html = $this->load->view('mailers/Appointment_Confirmation', array('name'=>$a['name'],'dr_name'=>$a['dr_name'],'clinic_name'=>$a['clinic_name']), true		);
		$fancy_date	=	isset($a['time'])?', '.date("dS F Y h:i A",strtotime($a['time'])):'';
		$subject = 'Appointment Confirmed with '.(isset($a['dr_name'])?$a['dr_name']:'').$fancy_date;
		return $this->sendmail($to_email, $to_name, $subject, $html);
		#------------
	}
	
	function appointmentconfirmation($to_email, $to_name,$a=array())
	{
		$html = $this->load->view('mailers/Appointment_Confirmed', array('name'=>$a['name'],'dr_name'=>$a['dr_name'],'clinic_name'=>$a['clinic_name'],'clinic_address'=>$a['clinic_address'],'reason_for_visit'=>$a['reason_for_visit'],'doctor_image'=>$a['doctor_image'],'appointment_time'=>$a['appointment_time'],'clinic_number'=>$a['clinic_number']), true);
		$subject = 'Appointment Confirmed: '.$a['name'].','.$a['appointment_time'];
		return $this->sendmail($to_email, $to_name, $subject, $html);
		#------------
	}
	function appointmentcancellation($to_email, $to_name,$a=array())
	{
		$html = $this->load->view('mailers/Appointment_Cancellation', array('name'=>$a['name'],'dr_name'=>$a['dr_name'],'clinic_name'=>$a['clinic_name'],'clinic_address'=>$a['clinic_address'],'reason_for_visit'=>$a['reason_for_visit'],'doctor_image'=>$a['doctor_image'],'appointment_time'=>$a['appointment_time'],'clinic_number'=>$a['clinic_number']), true);
		$subject = 'Appointment Cancellation: '.$a['name'].','.$a['appointment_time'];
		return $this->sendmail($to_email, $to_name, $subject, $html);
		#------------
	}

	function welcome_patient($to_email, $to_name)
	{
		$html = $this->load->view('mailers/welcome_patient', array('to_name'=>$to_name,'to_email'=>$to_email), true);
		$subject = 'Welcome to BookDrAppointment.com';
		return $this->sendmail($to_email, $to_name, $subject, $html);
		#------------
	}

	function request_for_activation($to_email, $to_name)
	{
		$html = $this->load->view('mailers/request_for_activation', array('to_name'=>$to_name,'to_email'=>$to_email), true);
		$subject = 'Thank you for Signing up with BookDrAppointment.com';
		return $this->sendmail($to_email, $to_name, $subject, $html);
		#------------
	}
	function account_verified($to_email, $to_name)
	{
		$html = $this->load->view('mailers/account_verified', array('to_name'=>$to_name,'to_email'=>$to_email), true);
		$subject = 'Your BDA account has been verified';
		return $this->sendmail($to_email, $to_name, $subject, $html);
		#------------
	}
	function account_not_verified($to_email, $to_name)
	{
		$html = $this->load->view('mailers/account_not_verified', array('to_name'=>$to_name,'to_email'=>$to_email), true);
		$subject = 'Your BDA account Not Verified';
		return $this->sendmail($to_email, $to_name, $subject, $html);
		#------------
	}
	function smart_receptionist($to_email, $to_name)
	{
		$html = $this->load->view('mailers/smart_receptionist', array('to_name'=>$to_name,'to_email'=>$to_email), true);
		$subject = 'Thank you for Subscribing to Smart Receptionist!';
		return $this->sendmail($to_email, $to_name, $subject, $html);
		#------------
	}
	function smart_appointment($to_email, $to_name)
	{
		$html = $this->load->view('mailers/smart_appointment', array('to_name'=>$to_name,'to_email'=>$to_email), true);
		$subject = 'Thank you for Subscribing to Smart Appointment!';
		return $this->sendmail($to_email, $to_name, $subject, $html);
		#------------
	}

	function free_trial($to_email, $to_name,$end_date)
	{
		$html = $this->load->view('mailers/free_trial', array('to_name'=>$to_name,'to_email'=>$to_email,'end_date'=>$end_date), true);
		$subject = '15 Days of Free Trial from BookDrAppointment.com';
		return $this->sendmail($to_email, $to_name, $subject, $html);
		#------------
	}
	
	
	function appointment_rescheduled($to_email, $to_name,$a=array())
	{
		$fancy_date	=	isset($a['new_scheduled_time'])?', '.date('dS M Y \a\t h:i a',strtotime($a['new_scheduled_time'])):'';
		$html = $this->load->view('mailers/Appointment_Rescheduled', array('name'=>$a['name'],'dr_name'=>$a['dr_name'],'clinic_name'=>$a['clinic_name'],
		'reason_for_visit'=> $a['reason_for_visit'],'new_scheduled_time'=>$fancy_date,'clinic_address'=>$a['clinic_address'],'clinic_number'=> $a['clinic_number']), true);

		
		$subject = 'Appointment Rescheduled with '.(isset($a['dr_name'])?$a['dr_name']:'').$fancy_date;
		return $this->sendmail($to_email, $to_name, $subject, $html);
		#------------
	}

	function patient_reviews_update_notification($to_email, $to_name,$a=array())
	{
		$html = "hi doctor someone has updated his reviews";
		$subject = 'Appointment Rescheduled';
		return $this->sendmail($to_email, $to_name, $subject, $html);
		#------------
	}
	function block_appointments_update($to_email,$to_name,$from_date,$to_date)
	{
		$mail_array	=	array('to_name'=>$to_name,'to_email'=>$to_email,'from_date'=>date("dS F Y h:i A",strtotime($from_date)),'to_date'=>date("dS F Y h:i A",strtotime($to_date)));
		$html = $this->load->view('mailers/block_appointments_update',$mail_array, true);
		$subject = 'Blocked Appointments Update';
		return $this->sendmail($to_email, $to_name, $subject, $html);
		#------------
	}
	function unblock_slot($to_email,$to_name,$from_date,$to_date)
	{
		$mail_array	=	array('to_name'=>$to_name,'to_email'=>$to_email,'from_date'=>date("dS F Y h:i A",strtotime($from_date)),'to_date'=>date("dS F Y h:i A",strtotime($to_date)));
		$html = $this->load->view('mailers/unblock_slot',$mail_array, true);
		$subject = 'Unblocked Appointments Update';
		return $this->sendmail($to_email, $to_name, $subject, $html);
		#------------
	}

	
}