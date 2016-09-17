<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cronreminder extends CI_Controller {
	private $data = array();
	function __construct()
	{
		parent::__construct();
		$this->load->model(array('doctor_model','sendsms_model','mail_model','patient_model','clinic_model','appointment_model'));
	}
	
	function appointment_reminder(){
		$appointments_today = $this->appointment_model->get_appointments_by_date(date('Y-m-d'));
		foreach($appointments_today as $a){
			$doctor_data = $this->doctor_model->get_doctor_name($a->doctor_id);
            $clinic_data = $this->clinic_model->get_clinic_data($a->clinic_id);
            
            $sms_array = array(
				'dr_name' => $doctor_data->name,
				'clinic_name' => $clinic_data->name,
				'clinic_location' => $clinic_data->address." ". $clinic_data->location,
				'clinic_contact' => $clinic_data->contact_number,
				'time' => $a->TIME
			);
			//echo "<pre>".print_r($sms_array,true);
			$this->sendsms_model->send_appointment_reminder_sms($a->mobile_number,$sms_array);

		}
	}
}
