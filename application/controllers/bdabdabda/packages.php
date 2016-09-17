<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');

class Packages extends CI_Controller
{
	public $data = array();
	private $current_tab = 'packages';
	public $perms	=	array();	
	function __construct()
	{
		parent::__construct();
		$this->load->model(array('admin/admindoctor_model','admin/adminpackages_model','page_model','reviews_model','doctor_model','sendsms_model','mail_model'));
		$this->load->library("pagination");
		$this->load->helper("url");

		$this->perms		=	$this->session->userdata('allowed_perms'); 
		$admin_home_url	=	$this->session->userdata('admin_home_url');
		if($this->perms[ADMIN_PACKAGES]['view']	==	0)
		{
			redirect(($admin_home_url)?$admin_home_url:'/bdabdabda');
			exit();
		}
	}

	function index()
	{
		$this->data['current_tab'] = $this->current_tab;
		
		$this->data = array();
		if(sizeof($this->post) > 0)
		{
			/*if($this->post['url'])
			{
				redirect($this->post['url']);
			}*/
		}
		$this->search();
		$this->data['perms']	=	$this->perms;
		$this->load->view('admin/packages_view', $this->data);
	}

	function search()
	{
		$this->data['current_tab'] = $this->current_tab;

		$config['base_url'] = BASE_URL.'bdabdabda/packages?';
		$config['per_page'] = 50;
		if(count($_GET) > 1)
		{
			$config['base_url'] = $config['base_url'] . http_build_query($_GET, '', '&');
		}

		$page = !empty($_GET['start']) ? $_GET['start'] : 0;
		
		$scharr= array('limit'  =>$config["per_page"],'offset' =>$page,'orderby'=>'package_registration.id desc');
		if($this->input->get('doctor_id'))
		{
			$scharr['doctor_id'] = $this->input->get('doctor_id');
		}
		if($this->input->get('doctor_name'))
		{
			$scharr['doctor_name'] = $this->input->get('doctor_name');
		}
		if(strlen($this->input->get('status')) > 0)
		{
			$scharr['status'] = $this->input->get('status');
		}
		$this->data['results'] = $this->adminpackages_model->get_packages($scharr);
		#echo $this->adminpackages_model;
		$config['total_rows'] = $this->adminpackages_model->row_count;
		
		unset($scharr['offset'],$scharr['limit'],$scharr['orderby']);
		$request_str = http_build_query($scharr);
		foreach($scharr as $scKey=>$scVal)
		{
			$this->data[$scKey] = $scVal;
		}

		$this->pagination->initialize($config); 

	}

	function edit_package_details($package_registration_id = NULL)
	{
		if($package_registration_id == NULL)
		{
			redirect('/bdabdabda/packages');
		}
		else
		{
			$this->data['current_tab'] = $this->current_tab;

			if(isset($_POST['submit']))
			{
				$this->adminpackages_model->update_package_alloted_details($package_registration_id, $_POST);
			}

			$this->data['packages_list'] = $this->adminpackages_model->get_all_packages_list();
			$this->data['user_package_details'] = $this->adminpackages_model->get_package_details_by_packageid($package_registration_id);
		}
		$this->data['perms']	=	$this->perms;
		$this->load->view('admin/packages_edit', $this->data);
	}
	
	function add_package($userid = NULL)
	{
		$this->data['current_tab'] = $this->current_tab;
		
		$user_packages = $this->adminpackages_model->get_user_packages($userid);
		#echo $this->adminpackages_model;exit;
		foreach($user_packages as $key=>$value)
		{
			$existing_packages[] = $value['package_id'];
		}
		
		$this->data['package'] = $this->adminpackages_model->get_all_packages($existing_packages);
		#echo $this->adminpackages_model;exit;
		
		if($userid != NULL && is_numeric($userid))
		{
			if(isset($_POST['submit']))
			{
				$packageid	=	isset($_POST['packageid'])?$_POST['packageid']:0;
				if(!empty($_POST['start_date']) && !empty($_POST['end_date']))
				{
					$chk = $this->adminpackages_model->check_doctor_package_eligibility($userid, $packageid);
					if($chk === TRUE)
					{
						$insert_id	=	$this->adminpackages_model->insert_package($userid, $packageid, $_POST['start_date'], $_POST['end_date']);
						if($insert_id)
						{
								$d	=	$this->admindoctor_model->get_user_detail_by_user_id($userid);
								if(isset($d->contact_number) && isset($d->email_id))
								{
									// send sms and mail if package is smart appointment
									if($_POST['packageid']==30) #smart appointment
									{
										$this->sendsms_model->smart_appointment($d->contact_number, $d->name, $d->email_id);
										$this->mail_model->smart_appointment($d->email_id,$d->name);
									}
									// send mail if package is smart appointment
						
									// send mail if package is smart receptionist
									if($_POST['packageid']==40) #smart receptionist
									{
										$this->sendsms_model->smart_receptionist($d->contact_number, $d->name, $d->email_id);
										$this->mail_model->smart_receptionist($d->email_id,$d->name);
									}
									// send mail if package is smart receptionis

									// send mail if package is free trial
									if($_POST['packageid']==100) #free trial
									{
										$this->mail_model->free_trial($d->email_id, $d->name,date('dS M Y', strtotime("+15 days")));
										$this->sendsms_model->free_trial($d->contact_number,array('date'=>date('dS M Y', strtotime("+15 days"))));
										
									}
									// send mail if package is free trial
								}
						}
					}
					redirect('/bdabdabda/packages');
				}
			}
			$this->data['perms']	=	$this->perms;
			$this->load->view('admin/packages_add_view', $this->data);
		}
		else
		{
			redirect('/bdabdabda/packages');
		}
	}
	
}