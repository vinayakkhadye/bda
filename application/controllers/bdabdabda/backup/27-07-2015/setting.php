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
				$this->data1['time_from'] = $this->post['time_from'];
				$this->data1['time_to'] = $this->post['time_to'];
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
						
						$spec_str	=	rtrim($spec_str,' ,');
						// print_r($value);exit;
						$value->speciality = $spec_str;
						}
						$this->data['count_data'][$key]=$value;
					}
				}
				echo json_encode($this->data['count_data']);
			  

		}
		
		function download_csv()
		{
			header('Content-Type: text/csv; charset=utf-8');
			header('Content-Disposition: attachment; filename=data.csv');

			// create a file pointer connected to the output stream
			$output = fopen('php://output', 'w');

			// output the column headings
			fputcsv($output, array( 'Date', 'Patient Name','Patient Number','Doctor Name', 'City','Clinic_No', 'Appointment Date', 'Status'));

			// fetch the data 
				$this->data1['date_from'] = $this->post['date_from'];
				$this->data1['date_to'] = $this->post['date_to']; 
				$this->data1['time_from'] = $this->post['time_from'];
				$this->data1['time_to'] = $this->post['time_to'];
				

				$this->data['data']  = $this->adminsetting_model->report_download_csv($this->data1);
				foreach ($this->data['data']  as $fields)
				{
					$out_data	=	 array();
					$out_data['added_on']	=	$fields['added_on'];
					$out_data['patient_name']	=	$fields['patient_name'];
					$out_data['mobile_number']	=	$fields['mobile_number'];
					$out_data['dr_name']	=	$fields['dr_name'];
					$out_data['city_name']	=	$fields['city_name'];
					$out_data['contact_number']	=	$fields['contact_number'];
					$out_data['scheduled_time']	=	$fields['scheduled_time'];
					
					if($fields['status']==1)
					{
						if($fields['confirmation']==0)
						{
							$out_data['cur_status']	=	"Pending";
						}else if($fields['confirmation']==1)
						{
							$out_data['cur_status']	=	"Confirmed";
						}else if($fields['confirmation']==2)
						{
							$out_data['cur_status']	=	"In Process";
						}
						
					}else if($fields['status']==0)
					{
						$out_data['cur_status']	=	"Cancelled";
					}
					
				fputcsv($output, $out_data);

				}
				fclose($output);
		}

		function get_speciality_name()
		{ 
			$this->data1['speciality'] = $this->post['speciality'];
			$this->data['get_name'] = $this->adminsetting_model->get_speciality_name($this->data1);
			echo json_encode($this->data);
		}


		function appointment_drreport()
		{
			$this->data['current_tab'] = "setting"; 
			$this->data['count_data']="Search first"; 
			
			$this->data['doctor'] = $this->adminsetting_model->doctor_list();
			$this->data['city']   = $this->adminsetting_model->city_list();
			$this->data['speciality'] = $this->adminsetting_model->speciality_list();  
			$this->data['perms']	=	$this->perms;
			$this->load->view('admin/setting_drreport', $this->data);
		}
		function appointment_final_report_dr()
		{
		    $this->data1['city'] = $this->post['city'];
				$this->data1['speciality'] = $this->post['speciality'];
				$this->data1['status'] = $this->post['status'];
				$this->data1['doctor'] = $this->post['doctor'];
				$this->data1['date_from'] = $this->post['date_from'];
				$this->data1['date_to'] = $this->post['date_to'];
				$this->data1['group_by'] = $this->post['group_by'];
				
				 // echo json_encode($this->data1);

				$this->data['count_data'] = $this->adminsetting_model->report_dr($this->data1);

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
						
						$spec_str	=	rtrim($spec_str,' ,');
						// print_r($value);exit;
						$value->speciality = $spec_str;
						}
						$this->data['count_data'][$key]=$value;
					}
				}
				echo json_encode($this->data['count_data']);
			  

		}



		function custom_sms()
		{
			if(isset($_POST['submit']))
			{
				$encoded_msg = urlencode($_POST['message']);
				$mobile_number = $_POST['mobile_number'];
				$this->sendsms_model->send_sms($mobile_number, $encoded_msg);
			}			
			$this->data['perms']	=	$this->perms;			
			$this->load->view('admin/custom_sms', $this->data);	
		}


}