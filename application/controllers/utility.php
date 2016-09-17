<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Utility extends CI_Controller {
	private $data = array();
	public function sendmail(){	
		$this->data['method_name'] = $this->router->fetch_method();

		$this->data['contact_name'] = $this->post['contact_name'];
		$this->data['email_id'] = $this->post['email_id'];
		$this->data['mobile_number'] = $this->post['mobile_number'];
		$this->data['subject'] = $this->post['subject'];
		$this->data['message'] = $this->post['message'];
		
		$this->load->model(array('mail_model'));

		$message = $this->load->view('mailers/contactus_mail.tpl.php',$this->data,true);
		$to = "support@bookdrappointment.com";
		$to_name = "Book Doctor Appointment Support";
		$subject = 'Enquiry from BDA';
		$send_mail = $this->mail_model->sendmail($to,$to_name,$subject,$message);
		
		if($send_mail){
			echo "1";
		}else{
			echo "0";
		}
		return false;
	}	
}
/* End of file aboutus.php */
/* Location: ./application/controllers/aboutus.php */