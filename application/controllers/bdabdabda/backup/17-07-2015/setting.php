<?php
if(!defined('BASEPATH')) exit('No Direct script access allowed');
set_time_limit(1000);
class setting extends CI_Controller{
	private $current_tab ='';

	function __construct()
		{
			parent::__construct();
			$this->load->model(array('admin/adminsetting_model'));
			$this->perms	=	$this->session->userdata('allowed_perms'); 
			if($this->perms[ADMIN_SETTINGS]['view']	==	0)
			{
				redirect('/bdabdabda/');
				exit();
			}

		}

		function appointment_report()
		{
			$this->data['current_tab'] = "setting"; 
			$this->data['count_data']="Search first"; 
			
			$this->data['city']   = $this->adminsetting_model->city_list();
			$this->data['speciality'] = $this->adminsetting_model->speciality_list();  
			$this->data['perms']	=	$this->perms;
			$this->load->view('admin/setting_report', $this->data);
				 
				
		}
		function appointment_final_report()
		{
			    $this->data1['city'] = $this->post['city'];
				$this->data1['speciality'] = $this->post['speciality'];
				$this->data1['status'] = $this->post['status'];
				$this->data1['from'] = $this->post['from'];
				$this->data1['date_from'] = $this->post['date_from'];
				$this->data1['date_to'] = $this->post['date_to'];
				$this->data1['group_by'] = $this->post['group_by'];
				
				//  echo json_encode($this->data1);

				$this->data['count_data'] = $this->adminsetting_model->report($this->data1);

				$speciality= $this->adminsetting_model->get_speciality_name();

				 // echo json_encode($this->data);

				// print_r( $speciality);
				// print_r( $this->data['count_data']);
				foreach ($speciality as  $value) {
					$speciality_data[$value['id']]	=	$value['name'];
					 
				}
				if(isset($this->data['count_data']) && is_array($this->data['count_data']) && sizeof($this->data['count_data'])>0)
				{
				foreach($this->data['count_data'] as $key	=>	$value)
				{
					if($value->speciality)
					{
					$spec_str	=	'';
					$tmp = explode(',', $value->speciality);
					// print_r($tmp);
					foreach ($tmp as $val) {
						# code...
							if(isset($speciality_data[$val]))
							{
								$spec_str	.=	$speciality_data[$val].", ";
							}
					}
					// $spec_str	=	trim(",",$spec_str);
					// print_r($value);exit;
					$value->speciality = $spec_str;
					}
					$this->data['count_data'][$key]=$value;
				}
			}
				echo json_encode($this->data['count_data']);
			  

		}
		function get_speciality_name()
		{ 
				$this->data1['speciality'] = $this->post['speciality'];
				// $this->data1['status'] = $this->post['status'];
				// $this->data1['from'] = $this->post['from']; 
				
				$this->data['get_name'] = $this->adminsetting_model->get_speciality_name($this->data1);
				echo json_encode($this->data);

		}



}