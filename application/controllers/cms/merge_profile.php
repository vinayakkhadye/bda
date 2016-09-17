<?php 
if( ! defined('BASEPATH')) exit('No direct script access allowed');

class Merge_profile extends CI_Controller{
	private $data = array();
	public function __construct(){
		parent::__construct();
		$this->load->model(array('common_model'));

	}
	public function doctor_post(){
		if(is_array($this->post) && sizeof($this->post)>0){
			
			$name = $this->post['name'];
			$email_id = $this->post['email_id'];
			$password = md5($this->post['password']);
			$contact_number = $this->post['contact_number'];
			$gender = $this->post['gender'];
			$dob = date("Y-m-d",strtotime($this->post['dob']));
			$type = 2;
			$is_verified = $this->post['is_verified'];
			$doctor_id = $this->post['doctor_id'];
			$insert_user =  "INSERT INTO `bda_vin`.`user`(`name`,`email_id`,`password`,`contact_number`,`gender`,`dob`,`type`,`is_verified`)
			VALUES ('".$name."','".$email_id."','".$password."','".$contact_number."','".$gender."','".$dob."','".$type."','".$is_verified."')";
			$rs = $this->db->query($insert_user);
			
			$insert_id = $this->db->insert_id();
			if($insert_id && $doctor_id){
				$update_doctor = "update doctor set user_id=".$insert_id." where id=".$doctor_id;
				$rs = $this->db->query($update_doctor);
			}
						
		}
	
	}
	public function doctor(){
		$this->load->view("cms/merge_doctor_profile");
	}
}
?>