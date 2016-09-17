<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');

class user_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->model(array('mail_model','sendsms_model'));
	}
	function getUser($a=array())
	{
		$res = false;
		$a = $this->filterData($a);
		$this->SQL = $where = "";
		$where .=" where 1";
		
		if(!empty($a['id'])  )
		{
			$where .=" AND `id` = ".$a['id'];
		}
		$this->SQL .= "select ".$a['column']." from user".$where;
		
		$query = $this->db->query($this->SQL);
		if($query->num_rows>0)
		{
			foreach ($query->result_array() as $row)
			{
				$res[] =  $row;
			}
		}
		return $res;
	}

	function create_account($data, $filename)
	{
		$password = md5($data["pass"]);

		$data_n = array(
			'name'          => $data["name"],
			'email_id'      => $data["email"],
			'password'      => $password,
			'contact_number'=> $data["mob"],
			'gender'        => $data["gender"],
			'dob'           => date('Y-m-d', strtotime($data["dob"])),
			'image'         => $filename,
			'type'          => $data["usertype"],
			'is_verified'   => '1',
		);
		$this->db->insert('user' , $data_n);
		$insertid = $this->db->insert_id();
		#echo $this->db->last_query();
		if($data["usertype"] == '2')
		{
			#$this->mail_model->welcome_doctor($data["email"], $data["name"]);
			$this->mail_model->request_for_activation($data["email"], $data["name"]);
			$this->sendsms_model->send_welcome_sms_doctor($data["mob"]);
			$this->load->model('doctor_model');
			$this->doctor_model->add_package($insertid);
			#echo $this->db->last_query();
		}
		elseif($data["usertype"] == '1')
		{
			$this->load->model(array('patient_model'));
			$this->patient_model->update_patient_userid_by_emailid($data["email"],$insertid);
			$this->mail_model->welcome_patient($data["email"], $data["name"]);
			$this->sendsms_model->send_welcome_sms_patient($data["mob"], $data["email"]);
		}
		return $insertid;
	}
	function create_account_app($data, $filename)
	{
		$password = md5($data["pass"]);

		$data_n = array(
			'name'          => $data["name"],
			'email_id'      => $data["email"],
			'password'      => $password,
			'contact_number'=> $data["mob"],
			'gender'        => $data["gender"],
			'dob'           => date('Y-m-d', strtotime($data["dob"])),
			'image'         => $filename,
			'type'          => $data["usertype"],
			'is_verified'   => '1',
		);
		
		if(isset($data["device_id"]) && !empty($data["device_id"]))
		{
			$data_n['device_id']	=	$data["device_id"];
		}
		
		$this->db->insert('user' , $data_n);
		$insertid = $this->db->insert_id();
		#echo $this->db->last_query();
		if($data["usertype"] == '2')
		{
			$this->load->model('doctor_model');
			$this->doctor_model->add_package($insertid);
			#echo $this->db->last_query();
		}
		elseif($data["usertype"] == '1')
		{
			$this->load->model(array('patient_model'));
			$this->patient_model->update_patient_userid_by_emailid($data["email"],$insertid);
		}
		return $insertid;
	}
	
	function login_user($details)
	{
		// Set login session
		$this->session->set_userdata('id', $details->id);
		$this->session->set_userdata('name', $details->name);
		$this->session->set_userdata('usertype', $details->type);
		
		//Check if the user is linked to facebook
		$checkfbuser = $this->user_model->check_fb_linked($details->id);
		if($checkfbuser)
		{
			$this->session->set_userdata('facebook_id', $checkfbuser->facebook_id);
		}

		//print_r($this->session->all_userdata());
		$userid    = $this->session->userdata('id');
		$usersname = $this->session->userdata('name');
		
		// Redirect code for review panel
		$redirect_url = $this->session->userdata('redirect_url');
		if(isset($redirect_url) && !empty($redirect_url))
		{
			$this->session->unset_userdata('redirect_url');
			redirect($redirect_url.'#review_panel');
			exit();
		}
		
		if($details->type == '2')
		{
			redirect('/doctor/smartlisting');
		}
		elseif($details->type == '1')
		{
			
			redirect('/patient/details');
		}
		else
		{
			redirect('/logout');
		}
	}
	
	function update_account($data, $filename, $userid)
	{
		if($filename == NULL)
		{
				$data = array(
				'name'          => $data["name"],
				'email_id'      => $data["email"],
				'contact_number'=> $data["mob"],
				'gender'        => $data["gender"],
				'dob'           => date('Y-m-d', strtotime($data["dob"])),
				'is_verified'   => '1',
			);
		}
		else
		{
				$data = array(
				'name'          => $data["name"],
				'email_id'      => $data["email"],
				'contact_number'=> $data["mob"],
				'gender'        => $data["gender"],
				'dob'           => date('Y-m-d', strtotime($data["dob"])),
				'image'         => $filename,
				'is_verified'   => '1',
			);
		}
		
		$this->db->where('id', $userid);
		$this->db->update('user', $data);
	}
	
	function check_email($email)
	{
		if(!empty($email))
		{
			$query = $this->db->get_where('user', array('email_id'=> $email), 1);
			if($query->num_rows() >= 1)
			{
				return TRUE;
			}
			else
			{
				return FALSE;
			}
		}
		else
		{
			return FALSE;
		}
	}
	
	function insert_forgotpass($email, $resetcode)
	{
		$data = array(
			'email'		=>	$email,
			'resetcode'	=>	$resetcode
		);
		$this->db->insert('forgot_pass', $data);
	}
	
	function change_resetcode_status($email, $resetcode)
	{
		$data = array(
			'status'	=>	'0'
		);
		$this->db->where('email', $email);
		$this->db->where('resetcode', $resetcode);
		$this->db->update('forgot_pass', $data);
	}
	
	function check_resetpassword_code($email, $resetcode)
	{
		$query = $this->db->get_where('forgot_pass', array('email'=> $email, 'resetcode'=> $resetcode, 'status'=>'1'), 1);
		if($query->num_rows() >= 1)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	function check_login($email, $password)
	{
		$password = md5($password);
		$query = $this->db->get_where('user', array('email_id'=> $email, 'password'=> $password), 1);
		if($query->num_rows() >= 1)
		{
			return $query->row();
		}
		else
		{
			return FALSE;
		}
	}
	function check_login_email($email)
	{
		$query = $this->db->get_where('user', array('email_id'=> $email), 1);
		if($query->num_rows() >= 1)
		{
			return $query->row();
		}
		else
		{
			return FALSE;
		}
	}
	
	function check_password($userid, $password)
	{
		$password = md5($password);
		$query = $this->db->get_where('user', array('id'=> $userid, 'password'=> $password), 1);
//		echo $this->db->last_query();
//		echo $query->num_rows();
//		exit;
		if($query->num_rows() > 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	function change_password($userid, $password)
	{
		$password = md5($password);
		$data = array('password' => $password);
		$this->db->where('id', $userid);
		$this->db->update('user', $data);
		return $password;
	}
	
	function change_password_with_code($email, $newpass)
	{
		$password = md5($newpass);
		$data = array('password' => $password);
		$this->db->where('email_id', $email);
		$this->db->update('user', $data);
	}
	
	function check_fbuser_exists($fbid)
	{
		$query = $this->db->get_where('fb_user', array('facebook_id'=> $fbid), 1);
		if($query->num_rows() >= 1)
		{
			return $query->row();
		}
		else
		{
			return FALSE;
		}
	}
	
	function check_mobno_exists($mobno)
	{
		if(!empty($mobno))
		{
			$query = $this->db->get_where('user', array('contact_number'=> $mobno), 1);
			if($query->num_rows() >= 1)
			{
				return TRUE;
			}
			else
			{
				return FALSE;
			}
		}
		else
		{
			return FALSE;
		}
	}
	
	function check_googleuser_exists($googleid)
	{
		$query = $this->db->get_where('google_user', array('google_id'=> $googleid), 1);
		if($query->num_rows() >= 1)
		{
			return $query->row();
		}
		else
		{
			return FALSE;
		}
	}
	
	function link_fbid($id, $fbid)
	{
		$data = array(
		'user_id'		=>	$id,
		'facebook_id'	=>	$fbid
		);
		$this->db->insert('fb_user' , $data);
	}
	
	function link_googleid($id, $googleid)
	{
		$data = array(
		'user_id'		=>	$id,
		'google_id'	=>	$googleid
		);
		$this->db->insert('google_user' , $data);
	}
	
	function get_all_userdetails($user_id)
	{
		$query = $this->db->get_where('user', array('id'=>$user_id), 1);
		if($query->num_rows() >= 1)
		{
			return $query->row();
		}
		else
		{
			return FALSE;
		}
	}

	function get_all_userdetails_byemail($email_id)
	{
		$query = $this->db->get_where('user', array('email_id'=>$email_id), 1);
		if($query->num_rows() >= 1)
		{
			return $query->row();
		}
		else
		{
			return FALSE;
		}
	}	
	function get_all_userdetails_by_contact_number($contact_number)
	{
		$query = $this->db->get_where('user', array('contact_number'=>$contact_number), 1);
		if($query->num_rows() >= 1)
		{
			return $query->row();
		}
		else
		{
			return FALSE;
		}
	}	
	
	function get_user_image($user_id)
	{
		$this->db->select('image');
		$query = $this->db->get_where('user', array('id'=>$user_id), 1);
		if($query->num_rows() >= 1)
		{
			$rs = $query->row();
			return $rs->image;
		}
		else
		{
			return FALSE;
		}
	}
	
	function __toString()
	{
		return (string)$this->db->last_query();
	}
	
	function check_fb_linked($userid)
	{
		$query = $this->db->get_where('fb_user', array('user_id'=> $userid), 1);
		if($query->num_rows() >= 1)
		{
			return $query->row();
		}
		else
		{
			return FALSE;
		}
	}
	
	function check_google_linked($userid)
	{
		$query = $this->db->get_where('google_user', array('user_id'=> $userid), 1);
		if($query->num_rows() >= 1)
		{
			return $query->row();
		}
		else
		{
			return FALSE;
		}
	}

	function appointment_login_user($details)
	{
		// Set login session
		$this->session->set_userdata('id', $details->id);
		$this->session->set_userdata('name', $details->name);
		$this->session->set_userdata('usertype', $details->type);
		
		//Check if the user is linked to facebook
		$checkfbuser = $this->user_model->check_fb_linked($details->id);
		if($checkfbuser)
		{
			$this->session->set_userdata('facebook_id', $checkfbuser->facebook_id);
		}
		$checkgoogleuser = $this->user_model->check_google_linked($details->id);
		if($checkgoogleuser)
		{
			$this->session->set_userdata('google_id', $checkgoogleuser->google_id);
		}
	}
	
}