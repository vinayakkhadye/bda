<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');

class Appointments extends CI_Controller
{
	private $current_tab = 'appointments';
	private $perm	=	'';
	
	function __construct()
	{
		parent::__construct();
		$this->load->model(array('appointment_model','admin/adminappointments_model','admin/admindoctor_model','page_model','admin/adminuser_model'));
		$this->load->library("pagination");
		$this->load->helper("url");
		
		$this->perms		=	$this->session->userdata('allowed_perms'); 
		$admin_home_url	=	$this->session->userdata('admin_home_url');
		if($this->perms[ADMIN_APPOINTMENTS]['view']==0)
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
			if(!empty($this->post['approve']))
			{
				$this->update_confirmation('1');
			}
			else
			if(!empty($this->post['disapprove']))
			{
				$this->update_status('0');
			}
			else
			if(!empty($this->post['pending']))
			{
				$this->update_confirmation('0');
			}
			else
			if(!empty($this->post['progress']))
			{
				$this->update_confirmation('2');
			}
			else
			if(!empty($this->post['duplicate']))
			{
				$this->update_confirmation('3');
			}
                        
			if($this->post['url'])
			{
				echo $this->post['url'];
				redirect($this->post['url']);
			}
		}
                
		$this->search();
		$this->data['perms']	=	$this->perms;
		$this->load->view('admin/appointments', $this->data);
	}
	
	function search()
	{
		$this->data['current_tab'] = $this->current_tab;
		
		$config['base_url'] = BASE_URL.'bdabdabda/appointments?';
		$config['per_page'] = 10;
		if(count($_GET) > 1)
		{
			$config['base_url'] = $config['base_url'] . http_build_query($_GET, '', '&');
		}

		$page = !empty($_GET['start']) ? $_GET['start'] : 0;
		
		$scharr= array('limit'=>$config["per_page"],'offset'=>$page);
		
		if($this->input->get('doctor_id'))
		{
			$scharr['doctor_id'] = $this->input->get('doctor_id');
		}
		if($this->input->get('order'))
		{
			$scharr['order_by'] = $this->input->get('order');
		}
		if($this->input->get('doctor_name'))
		{
			$scharr['doctor_name'] = $this->input->get('doctor_name');
		}

		if($this->input->get('patient_name'))
		{
			$scharr['patient_name'] = $this->input->get('patient_name');
		}

		if(isset($_GET['status']))
		{
			$scharr['status'] = $this->input->get('status');
		}

		if(isset($_GET['confirmation']))
		{
			$scharr['confirmation'] = $this->input->get('confirmation');
		}
		
		$this->data['results'] = $this->adminappointments_model->get_appointments($scharr);

		if($this->input->get('t')==1)
		{
			echo $this->adminappointments_model;exit;
		}
		
		$config['total_rows'] = $this->adminappointments_model->row_count;
		

		unset($scharr['offset'],$scharr['limit'],$scharr['orderby']);
		$request_str = http_build_query($scharr);
		foreach($scharr as $scKey=>$scVal)
		{
			$this->data[$scKey] = $scVal;
		}
		
		$this->data['cur_url'] = $_SERVER['REQUEST_URI'];
		$this->pagination->initialize($config); 
	}

	function update_status($status)
	{
		if($this->perms[ADMIN_APPOINTMENTS]['delete'] == '1')
		{	
			$ids = array_keys($this->post['appointment_id']);
			$affected_rows	=	$this->adminappointments_model->update_appointment_status($status, $ids);
		}	
		if( $affected_rows && $status==0)
		{

			$this->appointment_cancellation_mail_msg($ids);
		}
	}
	function update_confirmation($status)
	{
		$affected_rows	=	0;
		#if($this->perms[ADMIN_APPOINTMENTS]['delete']	== '1')
		#{	
			$ids = array_keys($this->post['appointment_id']);
			if(is_array($ids) && sizeof($ids)>0)
			{
				$affected_rows	=	$this->adminappointments_model->update_appointment_confirmation($status, $ids);
				if($affected_rows && $status==1)
				{
					$this->appointment_confirmation_mail_msg($ids);
				}
			}
		#}
	}
	
	public function appointment_confirmation_mail_msg($ids)
	{

		$this->load->model(array('common_model','doctor_model','sendsms_model','mail_model'));
		foreach($ids as $id)
		{
			$apt_data = $this->doctor_model->showAppointmentDetail(array('app_id'=>$id,'column'=>array("d.id AS doctor_id","d.name AS doctor_name","d.image AS doctor_image","d.gender AS doctor_gender","d.speciality","d.qualification","d.contact_number AS doctor_contact_number","apt.date AS appointment_date","apt.time AS appointment_time","apt.patient_name AS patient_name","apt.patient_email AS patient_email",
"apt.reason_for_visit","apt.id AS appointment_id","apt.mobile_number AS patient_contact_number","c.name AS clinic_name","c.address AS clinic_address","c.contact_number AS clinic_contact_number","c.knowlarity_number","c.knowlarity_extension","l.name AS 'location_name'")));
			if(is_array($apt_data) && sizeof($apt_data) > 0)
			{
				$apt_data = current($apt_data);
				$msgArray	=	array(
					'dr_name'				 	=>$apt_data['doctor_name'],
					'clinic_name'    	=>$apt_data['clinic_name'],
					'clinic_location'	=>$apt_data['location_name'],
					'clinic_address'	=>$apt_data['clinic_address'],
					'time'           	=>date('dS M Y \a\t h:i a',strtotime($apt_data['appointment_date']." ".$apt_data['appointment_time'])),
					'clinic_contact'	=>($apt_data['clinic_contact_number'])?$apt_data['clinic_contact_number']:$apt_data['doctor_contact_number']
				);
				$this->sendsms_model->send_appointment_confirmation_sms($apt_data['patient_contact_number'],$msgArray);

				$doc_msg_arr	=	array(
				'name'							=>	$apt_data['patient_name'],
				'mobile_number'			=>	$apt_data['patient_contact_number'],
				'time'           		=>	date('dS M Y \a\t h:i a',strtotime($apt_data['appointment_date']." ".$apt_data['appointment_time'])),
				'clinic_name'    		=>	$apt_data['clinic_name'],
				'reason_for_visit'	=>	$apt_data['reason_for_visit'],
				);
				$this->sendsms_model->send_appointment_confirmation_doctor_sms($apt_data['doctor_contact_number'],$doc_msg_arr);
					
				
				if(!empty($apt_data["patient_email"]))
				{
					$mail_arr = array(
						'name'									=>	$apt_data['patient_name'],
						'dr_name'								=>	$apt_data['doctor_name'],
						'clinic_name'						=>	$apt_data['clinic_name'],
						'clinic_address'				=>	$apt_data['clinic_address'],
						'reason_for_visit'			=>	$apt_data['reason_for_visit'],
						'doctor_image'					=> 	($apt_data['doctor_image'])? BASE_URL.$apt_data['doctor_image']: IMAGE_URL."default_doctor.png" ,
						'appointment_time' 			=>	date('dS M Y \a\t h:i a',strtotime($apt_data['appointment_date']." ".$apt_data['appointment_time'])),
						'clinic_number'					=>	$apt_data['clinic_contact_number'],
						'knowlarity_number'			=>	$apt_data['knowlarity_number'],
						'knowlarity_extension'	=>	$apt_data['knowlarity_extension']
					);
					$mail_res = $this->mail_model->appointmentconfirmation($apt_data["patient_email"],$apt_data["patient_name"],$mail_arr);
				}
			}
		}
	}
	public function appointment_cancellation_mail_msg($ids)
	{

		$this->load->model(array('common_model','doctor_model','sendsms_model','mail_model'));
		foreach($ids as $id)
		{
			$apt_data = $this->doctor_model->showAppointmentDetail(array('app_id'=>$id,'column'=>array("d.name AS doctor_name","d.image AS doctor_image","d.gender AS doctor_gender",
			"apt.date AS appointment_date","apt.doctor_id","apt.time AS appointment_time","apt.patient_name AS patient_name","apt.patient_email AS patient_email","d.speciality","d.qualification","c.name AS 'clinic_name'",
			"c.address AS 'clinic_address'","c.contact_number AS 'clinic_number'","c.knowlarity_number","c.knowlarity_extension","apt.reason_for_visit","apt.id AS 'appointment_id'",
			"apt.mobile_number","l.name as 'location_name'")));
	
			if(is_array($apt_data) && sizeof($apt_data) > 0){
				
				$apt_data = current($apt_data);
				$msgArray= array('dr_name'        =>$apt_data['doctor_name'],
				'clinic_name'    =>$apt_data['clinic_name'],
				'clinic_location'=>$apt_data['location_name'],
				'clinic_address'=>$apt_data['clinic_address'],
				'time'           =>date('dS M Y \a\t h:i a',strtotime($apt_data['appointment_date']." ".$apt_data['appointment_time']))
				);
				#print_r($msgArray);
				$this->sendsms_model->send_appointment_cancellation_sms($apt_data['mobile_number'],$msgArray);
				if(!empty($apt_data["patient_email"]))
				{
					$mail_arr = array(
						'name'				=>$apt_data['patient_name'],
						'dr_name'			=>$apt_data['doctor_name'],
						'clinic_name'		=>$apt_data['clinic_name'],
						'clinic_address'	=>$apt_data['clinic_address'],
						'reason_for_visit'	=>$apt_data['reason_for_visit'],
						'doctor_image'			=> ($apt_data['doctor_image'])? BASE_URL.$apt_data['doctor_image']: IMAGE_URL."default_doctor.png" ,
						'appointment_time'           =>date('dS M Y \a\t h:i a',strtotime($apt_data['appointment_date']." ".$apt_data['appointment_time'])),
						'clinic_number'	=>	$apt_data['clinic_number'],
						'knowlarity_number'	=>	$apt_data['knowlarity_number'],
						'knowlarity_extension'	=>	$apt_data['knowlarity_extension'],
					);
					$mail_res = $this->mail_model->appointmentcancellation($apt_data["patient_email"],$apt_data["patient_name"],$mail_arr);
				}
	
			}
		}
	}

	
	function view_appointment($appointment_id = NULL)
	{
		$this->data['current_tab'] = $this->current_tab;
		
		if($appointment_id == NULL)
		{
			redirect('/bdabdabda/appointments');
			exit();
		}
		else
		{
			$this->data['all_details'] = $this->adminappointments_model->get_all_details_appointment($appointment_id);
			$this->data['perms']	=	$this->perms;
			$this->load->view('admin/appointments_viewdetails', $this->data);
		}
	}
	
	function editappointment($appointment_id = NULL)
	{
		$this->data['current_tab'] = $this->current_tab;
		
		if($appointment_id == NULL)
		{
			redirect('/bdabdabda/appointments');
			exit();
		}
		else
		{
			if($this->perms[ADMIN_APPOINTMENTS]['edit'] != '1')
			{
				redirect('/bdabdabda/home');
				exit;
			}
			else
			{
				if(isset($_POST['submit']))
				{
					//print_r($_POST);exit;
					$this->adminappointments_model->edit_appointment_details($_POST, $appointment_id);
					redirect("/bdabdabda/appointments/view_appointment/{$appointment_id}");
				}
				$this->data['all_details'] = $this->adminappointments_model->get_all_details_appointment($appointment_id);
				$this->data['perms']	=	$this->perms;
				$this->load->view('admin/appointments_editdetails', $this->data);
			}
		}
	}
	
	function addappointment()
	{
		if($this->perms[ADMIN_APPOINTMENTS]['add'] != '1')
		{
			redirect('/bdabdabda/home');
			exit;
		}
		else
		{
			$this->data['current_tab'] = $this->current_tab;
			if(isset($_POST['submit']))
			{
				$appointment_id = $this->adminappointments_model->add_appointment($_POST);
				redirect("/bdabdabda/appointments/view_appointment/{$appointment_id}");
			}
			$this->data['perms']	=	$this->perms;		
			$this->load->view('admin/appointments_addappointment', $this->data);
		}
	}
	
	function get_doctor_details()
	{
		$doctorid = $_POST['doctorid'];
		$clinics = $this->admindoctor_model->get_doctor_clinics_by_doctorid($doctorid);
		if($clinics !== FALSE)
		{
			echo "<select name='clinicid' id='clinicid' class='form-control'>";
			echo "<option value=''>Select a clinic</option>";
			foreach($clinics as $row)
			{
				echo "<option value='".$row->id."'>".$row->name."</option>";
			}
			echo "</select>";
		}
	}

	function get_doctor_name()
	{
		$doctorid = $_POST['doctorid'];
		$doctorname = $this->admindoctor_model->get_doctor_name_byid($doctorid);
		if($doctorname !== FALSE)
		{
			echo $doctorname->name;
		}
	}
	
	function get_clinic_details()
	{
		$clinicid = $_POST['clinicid'];
		$clinicdetails = $this->admindoctor_model->get_clinic_details_byid($clinicid);
		if($clinicdetails !== FALSE)
		{
			echo json_encode($clinicdetails);
		}
	}

	function get_doctor_speciality()
	{
		$doctorid = $_POST['doctorid'];
		$doctorspec = $this->admindoctor_model->get_doctor_speciality_bydocid($doctorid);
		$spec	=	'';
		if($doctorspec !== FALSE)
		{
			if(isset($doctorspec['other_speciality']))
			{
				$otherspec = explode(',',$doctorspec['other_speciality']);
				foreach($otherspec as $row)
				{
					echo $row.'<br/>';
				}
			}
			foreach($doctorspec['speciality'] as $row)
			{
				$spec.= $row['speciality_name'].'<br/>';
			}
			echo $spec;
		}
	}
       
	/** * new_appointment */
	function pending_appointment()
	{
		$order	=	@$_GET['order'];
		$doctor_id	=	@$_GET['doctor_id'];
		$doctor_name	=	@$_GET['doctor_name'];
		$patient_name	=	@$_GET['patient_name'];
		$t	=	@$_GET['t'];
		$this->data['new_apponts'] = $this->adminappointments_model->get_all_scheduled_appointments(array("order_by"=>$order,"doctor_id"=>$doctor_id,"patient_name"=>$patient_name,"doctor_name"=>$doctor_name));
		if($t==1)
		{
			echo $this->adminappointments_model;exit;
		}
		$this->data['cur_url'] = $_SERVER['REQUEST_URI'];
		$this->data['perms']	=	$this->perms;
		$this->load->view('admin/pending_appointment', $this->data);
	}
	function inprocess_appointment()
	{
		$this->data['new_apponts'] = $this->adminappointments_model->get_all_inprocess_appointments();
		$this->data['cur_url'] = $_SERVER['REQUEST_URI'];
		$this->data['perms']	=	$this->perms;
		$this->load->view('admin/inprocess_appointment', $this->data);
	}

	/** * getServerTimeStamp */
	function getServerTimeStamp()
	{
		$this->data['server_time'] = time();
		$this->load->view('admin/new_appointment', $this->data);
	}

	/**
	* 
	* @param type $datetime
	* @return type
	*/
	function getNewPosts()
	{
		$max_id	=	 $_POST['id'];  
		if($max_id)
		{
			$data	= $this->adminappointments_model->getNewPosts($max_id);
		}  
		echo json_encode($data);
	}
	function get_latest_appointment()
	{
		$max_ap_id = $this->adminappointments_model->max_appointement_id();
		echo json_encode($max_ap_id); 
	}

	function save_notes()
	{
		$appt_notes = $_POST['appt_notes'];
		$id_detls = $_POST['id_detls'];
		$update_notes = $this->adminappointments_model->save_extra_appt_details($appt_notes, $id_detls);
		if($update_notes)
		{
			echo "Notes Added";
		}
	}

	function submit_revisited_date()
	{
		$revisited_date = date('Y-m-d', strtotime($_POST['rev_date']));
		$revisited_time = date('H:i:s', strtotime($_POST['rev_time']));
		$revisited_full_date = $revisited_date.' '.$revisited_time;
		$id_detls = $_POST['id_detls'];
		$save_revisted_date = $this->adminappointments_model->save_revisited_date($revisited_full_date, $id_detls);
		if($save_revisted_date)
		{
			echo "Revisited date added";
		} 
	}

	/**
	* 
	* @return booleanupdate_is_no_verified
	*/
	function update_is_no_verified()
	{
		$verified_no = $_POST['verify_status'];
		$appt_id = $_POST['appt_id'];
		if(isset($verified_no))
		{
			$this->db->where('id', $appt_id);
			$update_verified_no = $this->db->update('appointment', array('is_verified' => $verified_no));
			if($update_verified_no)
			{
				return true;
			}
		}
	}
}
