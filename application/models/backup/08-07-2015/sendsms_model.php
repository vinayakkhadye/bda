<?php
if(!defined('BASEPATH')) exit('No direct access allowed');

class sendsms_model extends CI_Model
{	
	private $log_file = ""; 
	public function __construct()
	{
		parent::__construct();
	}
	public function log_message($myfile,$query)
	{
		fwrite($myfile, $query);
		return false;
	}

	public function send_sms($mobile,$message)
	{
		$file_log = DOCUMENT_ROOT."logs/sms_logs/".date("Y-m-d").".log";
		$url = "http://49.50.69.90/api/smsapi.aspx?username=sachinmisra&password=sachin123&to=".$mobile."&from=BKDRAP&message=".$message."";
		$this->log_file = fopen($file_log, "a+"); 

		$this->log_message($this->log_file,"time : ".date("dS M Y h:i a").", mobile : ".$mobile.", message : ". urldecode($message).NEW_LINE);

		$curl= curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HEADER, false);
		$str = curl_exec($curl);
		curl_close($curl);
		#$this->log_message($this->log_file,$str.NEW_LINE);
		$this->log_message($this->log_file,"--------------------------------------------".NEW_LINE);
		return $str;
	}
	
	public function send_verification_sms_code($mobile, $code)
	{
		$message = urlencode("Your BookDrAppointment Verification code is ".$code."");
		$rs      = $this->send_sms($mobile,$message);
		return $code;
	}
	
	public function send_appointment_request_sms($mobile,$a = array())
	{
		#$message = urlencode("We have just received your request for an appointment with Dr. ".$a['dr_name'].", ".$a['clinic_name'].", ".$a['clinic_address']." on ".$a['time'].". We are in process of confirming your appointment. You will hear from us soon.");#".$a['clinic_location'].",

		$message = urlencode("We have blocked your appointment with Dr. ".$a['dr_name'].", ".$a['clinic_name'].", ".$a['clinic_address']." on ".$a['time']." . You will hear from us soon regarding the confirmation.");
		
		$rs      = $this->send_sms($mobile,$message);
	}
	function send_welcome_sms_patient($mobile, $email)
	{
		$msg = "Welcome to BookDrAppointment.com! Your account has been successfully created using username ".$email." You can now sign in to your account to get access to the best Doctors in town!";
		$message = urlencode($msg);
		$this->send_sms($mobile,$message);
	}
	function send_welcome_sms_doctor($mobile)
	{
		//$code    = rand(1000, 9999);
		$msg = "Thank you for Signing up with BookDrAppointment.com! Your Profile will be live once we verify your details.";
		$message = urlencode($msg);
		$this->send_sms($mobile,$message);
	}
	function send_account_not_created($mobile)
	{
		$msg = "Your Account is not created please try again or call - 022-49426426.";
		$message = urlencode($msg);
		$this->send_sms($mobile,$message);
	}

	function smart_appointment($mobile, $packagename, $email)
	{
		$msg = "Congratulations on your successful Profile upgrade to Smart Appointment! You can now Login & manage all your existing and new patient appointments easily through your mobile.";
		$message = urlencode($msg);
		$this->send_sms($mobile,$message);
	}

	function smart_receptionist($mobile, $packagename, $email)
	{
		$msg = "Thank you for Subscribing for Smart Receptionist. Our staff will get in touch with you soon to help you get started";
		$message = urlencode($msg);
		$this->send_sms($mobile,$message);
	}

	function doctor_upgrade_package_sms($mobile, $packagename, $email)
	{
		$msg = "Thank you for Subscribing for ".$packagename.". Our staff will get in touch with you soon to help you get started";
		$message = urlencode($msg);
		$this->send_sms($mobile,$message);
	}
	
	public function send_appointment_confirmation_sms($mobile,$a = array())
	{
		$a['clinic_contact']	= trim($a['clinic_contact']);
		/*$message = urlencode("Your appointment is confirmed with Dr. ".$a['dr_name'].", ".$a['clinic_name'].", ".$a['clinic_address']." on ".$a['time'].
		(!empty($a['clinic_contact'])? ' Contact No. '.$a['clinic_contact'].'.':'.')." If this time no longer works for you, please reschedule or cancel. Any query call - 022-49426426. Downaload our App https://play.google.com/store/apps/details?id=com.bda.patientapp");*/
		$message = urlencode("Your appointment is confirmed with Dr. ".$a['dr_name'].", ".$a['clinic_name'].", ".$a['clinic_address']." on ".$a['time'].
		(!empty($a['clinic_contact'])? ' Contact No. '.$a['clinic_contact'].'.':'.')." For any query call - 022-49426426. Downaload our App https://play.google.com/store/apps/details?id=com.bda.patientapp");
		
		$rs      = $this->send_sms($mobile,$message);
	}

	public function send_appointment_confirmation_doctor_sms($mobile,$a = array())
	{
		$message = urlencode("Patient ".$a['name']." (".$a['mobile_number'].") has just booked an Appointment with you via BookDrAppointment.com at ".$a['clinic_name']." on ".$a['time'].". Reason: ".$a['reason_for_visit'].".");

		$rs      = $this->send_sms($mobile,$message);
	}
	
	public function send_appointment_reminder_sms($mobile,$a = array()){
		
		$message = urlencode("You have an appointment with Dr. ".$a['dr_name'].", ".$a['clinic_name'].", ".$a['clinic_location']." today at ".$a['time'].". Contact No. ".$a['clinic_contact'].". If this time no longer works for you, please reschedule or cancel. Any query call - 022-49426426.");
		$rs      = $this->send_sms($mobile,$message);
		
	}
	
	public function send_appointment_cancellation_sms($mobile,$a = array()){
		
		$message = urlencode("Your appointment with Dr. ".$a['dr_name'].", ".$a['clinic_name'].", ".$a['clinic_location']." on ".$a['time']." is cancelled. To book another appointment log onto www.bookdrappointment.com");
		$rs  = $this->send_sms($mobile,$message);
		
	}
	public function account_verified($mobile,$a = array()){
		$message = urlencode("Your BDA account has been verified and listed on BookDrAppointment.com. You can now Login & Update your Profile and make your listing more informative & noticeable!");
		$rs  = $this->send_sms($mobile,$message);
	}
	public function account_not_verified($mobile,$a = array()){
		$message = urlencode("You had recently signed up for an account with BookDrAppointment. Unfortunately we were unable to validate your credentials. Kindly get in touch with us on 022-49426426 to activate your account.");
		$rs  = $this->send_sms($mobile,$message);
		
	}
	public function free_trial($mobile,$a = array()){
		
		$message = urlencode("We are delighted to receive your request for a free trial. Your 15 Days Free Trial is live & will be active till ".$a['date'].". You can get in touch on 022-49426426 for any of your queries.");
		$rs  = $this->send_sms($mobile,$message);
		
	}
	public function block_appointments_update($mobile,$a = array()){
		$message = urlencode("You have just blocked your Appointments from ".$a['from_date']." - ".$a['to_date'].".");
		$rs  = $this->send_sms($mobile,$message);
	}
	public function unblock_appointments_update($mobile,$a = array()){
		$message = urlencode("You have just unblocked your Appointments from ".$a['from_date']." - ".$a['to_date'].".");
		$rs  = $this->send_sms($mobile,$message);
	}
	public function appointment_rescheduled($mobile,$a = array())
	{
		$fancy_date	=	isset($a['new_scheduled_time'])?' '.date('dS M Y \a\t h:i a',strtotime($a['new_scheduled_time'])):'';
		$message = urlencode("We have just rescheduled your appointment with Dr. ".$a['dr_name'].", ".$a['clinic_name'].", ".$a['clinic_address']." on ".$fancy_date.".");
		$rs      = $this->send_sms($mobile,$message);
	}
}