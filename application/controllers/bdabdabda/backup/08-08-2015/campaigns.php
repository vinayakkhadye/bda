<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');

class Campaigns extends CI_Controller
{

	private $current_tab = 'advertisements';
	function __construct()
	{
		parent::__construct();
		$this->load->model(array('admin/adminadvertisements_model','page_model'));
		$this->load->library("pagination");
		$this->load->helper("url");

		$this->perms		=	$this->session->userdata('allowed_perms'); 
		$admin_home_url	=	$this->session->userdata('admin_home_url');
		if(empty($adminid))
		{
			redirect($admin_home_url);
			exit();
		}
	}
	
	function check_doctor_eligible_campaign()
	{
		if((isset($_POST['doctor_id']) && !empty($_POST['doctor_id']) && is_numeric($_POST['doctor_id'])) && (isset($_POST['campaign_id']) && !empty($_POST['campaign_id']) && is_numeric($_POST['campaign_id'])))
		{
			$doctor_id = $_POST['doctor_id'];
			$campaign_id = $_POST['campaign_id'];
			//check if doctor is already present in some other campaign
			$chk1 = $this->adminadvertisements_model->check_doctor_present_in_campaigns($doctor_id);
			//Check if doctor has a paid package
			$chk2 = $this->adminadvertisements_model->check_doctor_paid_packages($doctor_id);
//			var_dump($chk1);
//			var_dump($chk2);
			
			if($chk1 == FALSE && $chk2 == FALSE)
			{
				$this->adminadvertisements_model->add_doctor_to_campaign($doctor_id, $campaign_id, $_POST);
				echo "success";
			}
			else
			{
				if($chk1 != FALSE)
				{
					echo "Doctor already present in campaign id : ".$chk1->id;
				}
				elseif($chk2 != FALSE)
				{
					echo "Doctor already have a paid package";
				}
			}
		}
	}
	
	function remove_doctor_campaign()
	{
		if((isset($_POST['doctor_id']) && !empty($_POST['doctor_id']) && is_numeric($_POST['doctor_id'])) && (isset($_POST['campaign_id']) && !empty($_POST['campaign_id']) && is_numeric($_POST['campaign_id'])))
		{
			$doctor_id = $_POST['doctor_id'];
			$campaign_id = $_POST['campaign_id'];
			
			$chk1 = $this->adminadvertisements_model->remove_doctor_from_campaign($doctor_id, $campaign_id);
			echo "success";
		}
	}

	function activate_doctor_package()
	{
		if((isset($_POST['doctor_id']) && !empty($_POST['doctor_id']) && is_numeric($_POST['doctor_id'])) && (isset($_POST['campaign_id']) && !empty($_POST['campaign_id']) && is_numeric($_POST['campaign_id'])))
		{
			$doctor_id = $_POST['doctor_id'];
			$campaign_id = $_POST['campaign_id'];
			
			$chk1 = $this->adminadvertisements_model->check_doctor_userid_exists($doctor_id);
			if($chk1 === FALSE)
			{
				echo "Doctor not registered as a user";
			}
			else
			{
				$chk2 = $this->adminadvertisements_model->activate_doctor_package_campaign($doctor_id, $campaign_id, $chk1);
				echo "success";
			}
		}
	}

}