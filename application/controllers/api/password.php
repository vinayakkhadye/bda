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

class Password extends REST_Controller
{
	function __construct(){
        parent::__construct();
		$this->load->model(array('user_model','mail_model'));
    }
	function forgot_post()
	{
		$email = $this->post('email');
		if($email)
		{
			// check if email is present in the database
			$check = $this->user_model->check_email($email);
			if($check === TRUE)
			{
				$resetcode = md5($email).rand(1000,9999).rand(1000,9999);
				$this->user_model->insert_forgotpass($email, $resetcode);
				$userdetails = $this->user_model->get_all_userdetails_byemail($email);
				$mail_check = $this->mail_model->sendresetpasswordmail($email, $userdetails->name, $resetcode);
				$rs = array("forgot_data"=>"success","message"=>"Verification mail is Successfully sent to your Email Id","status"=>1);
			}
			else
			{
				$rs = array("message"=>"Email Id does not exists","status"=>0);
			}
		}
		else
		{
			$rs = array("message"=>"Please provide email","status"=>0);
		}
		$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
	}
	
	function change_post()
	{
		$user_id	=	$this->post('user_id');
		$newpass	=	$this->post('newpass');
		if($user_id && $newpass)
		{
			$this->load->model('mail_model','user_model');
			$userdetails = $this->user_model->get_all_userdetails($user_id);
			if($userdetails){
				$password = $this->user_model->change_password($user_id,$newpass);
				//send mailer
				$this->mail_model->changepasswordmail($userdetails->email_id, $userdetails->name);
				$rs = array("change_data"=>$password,"message"=>"You have Successfully changed your Password","status"=>1);
			}else{
				$rs = array("message"=>"Invalid user_id","status"=>0);	
			}
		}
		else
		{
			if(empty($user_id) && empty($newpass))
			{
				$rs = array("message"=>"Please provide user_id, and newpass","status"=>0);	
			}else if(empty($user_id))
			{
				$rs = array("message"=>"Please provide user_id","status"=>0);	
			}else
			{
				$rs = array("message"=>"Please provide newpass","status"=>0);	
			}
		}
		$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
	}

}

