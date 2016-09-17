<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
* Example
*
* This is an example of a few basic user interaction methods you could use
* all done with a hardcoded array.
*
* @package		CodeIgniter
* @subpackage	Rest Server
* @category	Controller
* @author		Phil Sturgeon
* @link		http://philsturgeon.co.uk/code/
*/

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH.'/libraries/REST_Controller.php';

class Verification extends REST_Controller
{
	function __construct()
	{
		parent::__construct();

	}
	function mobile_post()
	{
		$this->load->model(array('sendsms_model','user_model'));
		$mobile_number = $this->post('mobile_number');
		$code          = rand(1000, 9999);
		if($mobile_number)
		{
			$coders = $this->sendsms_model->send_verification_sms_code($mobile_number,$code);
			$rs     = array("code_data"=>$code,"message"  =>"message code sent successfully","status"   =>1);
		}
		else
		{
			$rs = array("message"=>"please provide mobile number","status" =>0);
		}
		$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
	}
	function mobile_email_exists_post()
	{
		$this->load->model(array('sendsms_model','user_model'));
		$mobile_number = ($this->post('mobile_number'))?$this->post('mobile_number'):''; ;
		$email_id      = ($this->post('email_id'))?$this->post('email_id'):'';
		if($mobile_number || $email_id )
		{
			$check       = $this->user_model->check_mobno_exists($mobile_number);
			$check_email = $this->user_model->check_email($email_id);
			if($check === TRUE && $check_email == TRUE)
			{
				$rs = array("message"=>"Mobile number AND email Id already exists","status" =>0);
			}
			else
			if($check === TRUE)
			{
				$rs = array("message"=>"Mobile number already exists","status" =>0);
			}
			else
			if($check_email == TRUE)
			{
				$rs = array("message"=>"Email ID already exists","status" =>0);
			}
			else
			{
				$rs = array("message"=>"Good to go","status" =>1);
			}
		}
		else
		{
			$rs = array("message"=>"please provide mobile_number or email_id","status" =>0);
		}

		$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
	}

}