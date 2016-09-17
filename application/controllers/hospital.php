<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hospital extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model(array('common_model','user_model','patient_model','location_model','sendsms_model','media_model','page_model','doctor_model','hospital_model','clinic_model'));

		/* user login check code begins */
		$session_userid = $this->session->userdata('id');
		$session_usertype = $this->session->userdata('usertype');
		if(empty($session_userid))
		{
			redirect('/login', 'refresh');
			exit();
		}
		elseif($session_usertype != '3')
		{
			redirect('/login', 'refresh');
			exit();
		}
		/* user login check code ends */
	}
	
	function index()
	{
		$this->db->load->view('hospital_view');
	}
	
	function scheduler()
	{
		$data											=	array();
		$userid 									=	$this->session->userdata('id');
		$data['name'] 						= $this->session->userdata('name');
		$data['hospital_details']	=	$this->hospital_model->get_hosptial_data(array('user_id'=>$userid));
		$data['hospital_id']			=	$data['hospital_details']->id;
		$data['doctor_id']				=	$this->input->post('doctor_id');
		#$data['doctor_data']			=	$this->hospital_model->get_doctor_by_hospital_id(array('hospital_id'=>$data['hospital_id'],'id_as_key'=>true));
		$data['doctors'] 					= $this->hospital_model->get_all_doctors_json($data['hospital_id'],array('id_as_key'=>true)); 
		if(empty($data['doctors']))
		{
			redirect('/hospital/details');
		}
		
		$data['doctors_dd']				= $this->hospital_model->get_all_doctors_json($data['hospital_id']); 

		if($this->session->userdata('scheduler_doctor_id') != false)
		{
			$data['doctor_id']	= $this->session->userdata('scheduler_doctor_id');
			$data['doctor_data']	=	$doctor_data	=	$data['doctors'][$data['doctor_id']];
		}
		else
		{
			$data['doctor_data']	=	$doctor_data	=	current($data['doctors']);
			$data['doctor_id']	= $doctor_data['doctor_id'];			
		}

		if($this->session->userdata('scheduler_clinic_id') != false)
			$data['scheduler_clinic_id'] = $this->session->userdata('scheduler_clinic_id');
		else
			$data['scheduler_clinic_id'] = $doctor_data['clinic_id'];

			
		
		$data['userdetails'] 			= $this->user_model->get_all_userdetails($doctor_data['user_id']);
		
		
		#$data['clinics'] = $this->doctor_model->get_all_clinics_json($data['doctor_id']); 
		
		#$data['clinics_d'] = $this->doctor_model->get_all_clinics_json($data['doctor_id'],array('is_as_key'=>true));
		#if($this->session->userdata('scheduler_clinic_id'))
		#{
			#$data['clniic_details']	=	$data['clinics_d'][$this->session->userdata('scheduler_clinic_id')];
		#}
		#else
		#{
			#$data['clniic_details']	=	$data['clinics_d'][$doctor_data];
		#}
		
		$patients = $this->doctor_model->get_patients_by_id(0,$data['hospital_id']);
		$data['patients'] = array();
		if($patients)
		{
			foreach($patients as $p)
			{
				$tmp = array(
					'value'=>$p['id'], 
					'label'=>$p['name']." ".$p['mobile_number'],
					'email'=>$p['email'], 
					'address'=>$p['address'], 
					'dob'=>(empty($p['dob'])?'':date("d-m-Y",strtotime($p['dob']))), 
					'gender'=>$p['gender'], 
					);
				$data['patients'][]= $tmp;
			}
			$data['patients'] = preg_replace('/"([a-zA-Z]+[a-zA-Z0-9]*)":/','$1:',json_encode($data['patients']));
		}
		else
		{
		$data['patients']	=	json_encode(array());
		}
		

		if($this->session->userdata('scheduler_view') != false)
			$data['scheduler_view'] = $this->session->userdata('scheduler_view');
		else
			$data['scheduler_view'] = 'agendaDay';

		if($this->session->userdata('scheduler_clinic_duration') != false)
		{
			$data['scheduler_clinic_duration'] = "00:".$this->session->userdata('scheduler_clinic_duration').":00";
			$data['slots'] = $this->session->userdata('scheduler_clinic_duration');
		}
		else
		{
			$data['scheduler_clinic_duration'] = "00:".$doctor_data['duration'].":00";
			$data['slots'] = $doctor_data['duration'];
		}	
		#$data['clinics'] = json_encode($data['clinics']);
		$data['doctors'] = json_encode($data['doctors_dd']);
		$this->load->view('login/hospital_scheduler', isset($data) ? $data : NULL);
	}
	
	function details()
	{
		$data['current_tab'] = 'details';
		$this->load->library('form_validation');
		$userid = $this->session->userdata('id');
		$data['name'] = $this->session->userdata('name');
		$data['hospital_details']	=	$hospital_data = $this->hospital_model->get_hosptial_data(array('user_id'=>$userid));
		#print_r($data['hospital_details']);exit;
		$data['clinic_images']		=		explode(",",$data['hospital_details']->clinic_images);
		foreach($data['clinic_images'] as $clinic_key=>$clinic_image)
		{
			if($clinic_image)
			{
				$data['clinic_images'][$clinic_key]	=	$this->get_thumbnail($clinic_image);
			}
		}
		if($hospital_data->city_id)
		{
			$data['city'] = $this->common_model->getCity(array('limit'=>1,'column'=>array('id','name'),'id'=>$hospital_data->city_id,
			'status'=>array(1,2),'id_as_key'=>TRUE));		
			$data['city_name']	=	 $data['city'][$hospital_data->city_id]['name'];
			$data['city_id']	=	 $data['city'][$hospital_data->city_id]['id'];
		}
		if($hospital_data->location_id)
		{
			$data['locality'] = $this->common_model->getLocation(array('limit'=>1,'column'=>array('id','name'),
			'id'=>$hospital_data->location_id,'id_as_key'=>TRUE));
			$data['location_name']	=	 $data['locality'][$hospital_data->location_id]['name'];
			$data['location_id']	=	 $data['locality'][$hospital_data->location_id]['id'];
		}
		else
		{
			$data['location_name'] = $hospital_data->other_location;
			$data['location_id']	=	 "";
		}		

		if(sizeof($_POST)>0)
		{
			$post_data	=	 $this->input->post();
			if($this->input->post('profile_pic_base64'))
			{
				# base64 image upload code
				$this->media_model->upload_type		=	'base64';
				$this->media_model->content_type	=	'profile';
				$this->media_model->base64_data		=	$this->input->post('profile_pic_base64');
				$this->media_model->file_name			=	$this->input->post('profile_pic_base64_name');
				$file_data												=	$this->media_model->upload();
				
				if(isset($file_data[0]) && $file_data[0]==TRUE)
				{
					$post_data['image'] = $file_data[1];
				}
			}
			$hospital_images	=	explode(",",$data['hospital_details']->clinic_images);
			foreach($post_data['clinicphotoimg'] as $cli_key=>$cli_val)
			{
				if($cli_val)
				{
					# base64 image upload code
					$this->media_model->upload_type		=	'base64';
					$this->media_model->content_type	=	'profile';
					$this->media_model->base64_data		=	$cli_val;
					$this->media_model->file_name			=	$post_data['clinicphotoname'][$cli_key];
					$file_data												=	$this->media_model->upload();
					
					if(isset($file_data[0]) && $file_data[0]==TRUE)
					{
						$hospital_images[$cli_key]	=	$file_data[1];
					}
				}
			}
			$post_data['clinic_images']	=	implode(",",$hospital_images);
			
			unset($post_data['profile_pic_base64'],$post_data['profile_pic_base64_name'],$post_data['clinicphotoname'],$post_data['clinicphotoimg'],$post_data['add_clinic']);
			$updated_hospital = $this->hospital_model->update_hospital($userid, $post_data);
			redirect('/hospital/managedoctors/'.$data['hospital_details']->id, 'refresh');
		}
		$this->load->view('login/hospital_details',$data);
	}
	
	function managedoctors($hospital_id)
	{
		$data	=	 array();
		$userid = $this->session->userdata('id');
		$data['name'] = $this->session->userdata('name');
		$data['hospital_details']	=	$hospital_data = $this->hospital_model->get_hosptial_data(array('user_id'=>$userid));
		$data['doctor_data']	=	$this->hospital_model->get_doctor_by_hospital_id(array('hospital_id'=>$hospital_id,'id_as_key'=>true));
		if(is_array($data['doctor_data']) && sizeof($data['doctor_data'])>0)
		{
			foreach($data['doctor_data'] as $d_key=>$d_val)
			{
				$data['doctor_data'][$d_key]['disptimings']	=	$this->clinic_model->get_clinic_formatted_time($d_val['timings']);
			}
		}
		#if(is_array($data['doctor_data']) && sizeof($data['doctor_data'])>0)
		#{
			#$data['doctor_data']	= array_chunk($data['doctor_data'],2);
		#}
		
		$data['speciality_data'] = $this->common_model->getSpeciality(array('column'=>array('id','name'),'id_as_key'=>TRUE));
		
		$this->load->view('login/hospital_doctors',$data);
	}
	
	function adddoctor()
	{
		$data	=	 array();
		$userid = $this->session->userdata('id');
		$data['hospital_details']	=	$hospital_details = $this->hospital_model->get_hosptial_data(array('user_id'=>$userid));
		$data['name'] = $this->session->userdata('name');
		$this->load->library('form_validation');
		$add_hospital_doctor = $this->input->post('add_hospital_doctor');
		if($add_hospital_doctor=='Save')
		{
			$post	=	$this->input->post();
			if($this->input->post('profile_pic_base64'))
			{
				$this->media_model->upload_type		=	'base64';
				$this->media_model->content_type	=	'profile';
				$this->media_model->base64_data		=	$this->input->post('profile_pic_base64');
				$this->media_model->file_name			=	$this->input->post('profile_pic_base64_name');
				$file_data												=	$this->media_model->upload();

				if(isset($file_data[0]) && $file_data[0]==TRUE)
				{
					$filename_path = $file_data[1];
				}
			}
			$this->db->trans_start();
			$user_data['name']						=	$this->input->post('doctor_name');
			$user_data['email_id']				=	$this->input->post('doctor_email_id');
			$user_data['password']				=	md5($this->input->post('doctor_password'));
			$user_data['contact_number']	=	$this->input->post('doctor_contact_number');
			$user_data['gender']					=	$this->input->post('doctor_gender');
			$user_data['dob']							=	date("Y-m-d",strtotime($this->input->post('doctor_dob')));
			if($filename_path)
			{
				$user_data['image']	=	$doctor_data['image']	=	$filename_path;
			}
			$user_data['type']						=	2;#3 is for hospital
			$user_data['is_verified']			=	1;#3 is for hospital

			$user_id		=	$this->hospital_model->add_user($user_data);
			#echo $this->hospital_model;
			if($user_id)
			{
				$doctor_data['user_id']								=	$user_id;
				$doctor_data['hospital_id']						=	$hospital_details->id;
				$doctor_data['name']									=	$this->input->post('doctor_name');
				$doctor_data['gender']								=	$this->input->post('doctor_gender');
				$doctor_data['summary']								=	$this->input->post('doctor_summary');
				$doctor_data['reg_no']								=	$this->input->post('doctor_reg_no');
				$doctor_data['council_id']						=	$this->input->post('doctor_council');
				$doctor_data['speciality']						=	@rtrim(implode(",",$this->input->post('speciality')),",");
				$doctor_data['other_speciality']			=	@rtrim(implode(",",$this->input->post('speciality_other')),",");
				$doctor_data['qualification']					=	@rtrim(implode(",",$this->input->post('degree')),",");	
				$doctor_data['other_qualification']		=	@rtrim(implode(",",$this->input->post('degree_other')),",");

				$doctor_data['yoe']										=	$this->input->post('doctor_yoe');
				$doctor_data['contact_number']				=	$this->input->post('doctor_contact_number');
				$doctor_id	=	$this->hospital_model->add_doctor($doctor_data);
				#echo $this->hospital_model;exit;
				if($doctor_id)
				{
					$clinic_data['doctor_id']					=	$doctor_id;
					$clinic_data['hospital_id']				=	$hospital_details->id;
					$clinic_data['name']							=	$hospital_details->name;
					$clinic_data['location_id']				=	$hospital_details->location_id;
					$clinic_data['city_id']						=	$hospital_details->city_id;
					$clinic_data['address']						=	$hospital_details->address;
					$clinic_data['image']							=	$hospital_details->image;
					$clinic_data['contact_number']		=	$this->input->post('clinic_contact_number');
					$clinic_data['latitude']					=	$hospital_details->latitude;
					$clinic_data['longitude']					=	$hospital_details->longitude;
					$clinic_data['pincode']						=	$hospital_details->pincode;
					$clinic_data['consultation_fees']	=	$this->input->post('consult_fee');
					
					$clinic_data['duration']					=	$this->input->post('avg_patient_duration');
					$clinic_data['timings'] 					= json_encode(array(
																						array(
																							array(
																								!empty($post['sun_mor_open']) ? date('H:i:s', strtotime($post['sun_mor_open'])) : '',
																								!empty($post['sun_mor_close']) ? date('H:i:s', strtotime($post['sun_mor_close'])) : ''
																							),
																							array(
																								!empty($post['sun_eve_open']) ? date('H:i:s', strtotime($post['sun_eve_open'])) : '',
																								!empty($post['sun_eve_close']) ? date('H:i:s', strtotime($post['sun_eve_close'])) : ''
																							)
																						),
																						array(
																							array(
																								!empty($post['mon_mor_open']) ? date('H:i:s', strtotime($post['mon_mor_open'])) : '',
																								!empty($post['mon_mor_close']) ? date('H:i:s', strtotime($post['mon_mor_close'])) : ''
																							),
																							array(
																								!empty($post['mon_eve_open']) ? date('H:i:s', strtotime($post['mon_eve_open'])) : '',
																								!empty($post['mon_eve_close']) ? date('H:i:s', strtotime($post['mon_eve_close'])) : ''
																							)
																						),
																						array(
																							array(
																								!empty($post['tue_mor_open']) ? date('H:i:s', strtotime($post['tue_mor_open'])) : '',
																								!empty($post['tue_mor_close']) ? date('H:i:s', strtotime($post['tue_mor_close'])) : ''
																							),
																							array(
																								!empty($post['tue_eve_open']) ? date('H:i:s', strtotime($post['tue_eve_open'])) : '',
																								!empty($post['tue_eve_close']) ? date('H:i:s', strtotime($post['tue_eve_close'])) : ''
																							)
																						),
																						array(
																							array(
																								!empty($post['wed_mor_open']) ? date('H:i:s', strtotime($post['wed_mor_open'])) : '',
																								!empty($post['wed_mor_close']) ? date('H:i:s', strtotime($post['wed_mor_close'])) : ''
																							),
																							array(
																								!empty($post['wed_eve_open']) ? date('H:i:s', strtotime($post['wed_eve_open'])) : '',
																								!empty($post['wed_eve_close']) ? date('H:i:s', strtotime($post['wed_eve_close'])) : ''
																							)
																						),
																						array(
																							array(
																								!empty($post['thu_mor_open']) ? date('H:i:s', strtotime($post['thu_mor_open'])) : '',
																								!empty($post['thu_mor_close']) ? date('H:i:s', strtotime($post['thu_mor_close'])) : ''
																							),
																							array(
																								!empty($post['thu_eve_open']) ? date('H:i:s', strtotime($post['thu_eve_open'])) : '',
																								!empty($post['thu_eve_close']) ? date('H:i:s', strtotime($post['thu_eve_close'])) : ''
																							)
																						),
																						array(
																							array(
																								!empty($post['fri_mor_open']) ? date('H:i:s', strtotime($post['fri_mor_open'])) : '',
																								!empty($post['fri_mor_close']) ? date('H:i:s', strtotime($post['fri_mor_close'])) : ''
																							),
																							array(
																								!empty($post['fri_eve_open']) ? date('H:i:s', strtotime($post['fri_eve_open'])) : '',
																								!empty($post['fri_eve_close']) ? date('H:i:s', strtotime($post['fri_eve_close'])) : ''
																							)
																						),
																						array(
																							array(
																								!empty($post['sat_mor_open']) ? date('H:i:s', strtotime($post['sat_mor_open'])) : '',
																								!empty($post['sat_mor_close']) ? date('H:i:s', strtotime($post['sat_mor_close'])) : ''
																							),
																							array(
																								!empty($post['sat_eve_open']) ? date('H:i:s', strtotime($post['sat_eve_open'])) : '',
																								!empty($post['sat_eve_close']) ? date('H:i:s', strtotime($post['sat_eve_close'])) : ''
																							)
																						)
																					));							
					$clinic_id	=	$this->hospital_model->add_clinic($clinic_data);
					#echo $this->hospital_model;
				}
				
			}
			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE)
			{
			}
			else
			{
				#send email to the doctor
				//$this->mail_model->doctor_registered($this->input->post('doctor_email_id'), $this->input->post('doctor_name'),array('password'=>$this->input->post('doctor_password')));
				
				redirect('/hospital/managedoctors/'.$hospital_details->id);
			}
			
		}

		
		$data['council'] = $this->common_model->getCouncils(array('status'=>ACTIVE,'column'=>array('id','name'),'id_as_key'=>TRUE));
		foreach($data['council'] as $c_key=>$c_val)
		{
			$data['json_council'][]	= array("label"=>$c_val['name'],"db_id"=>$c_val['id']);	
		}
		$data['json_council']	=	 json_encode($data['json_council']);

		$data['speciality'] = $this->common_model->getSpeciality(array('satus'=>array(1,2),'column'=>array('id','name'),'id_as_key'=>TRUE));
		foreach($data['speciality'] as $sp_key=>$sp_val)
		{
			$data['json_speciality'][]	= array("label"=>$sp_val['name'],"db_id"=>$sp_val['id']);	
		}
		$data['json_speciality']	=	 json_encode($data['json_speciality']);

		
		$data['degree'] 		= $this->common_model->getQualification(array('satus'=>array(1,2),'column'=>array('id','name'),'id_as_key'=>TRUE));
		foreach($data['degree'] as $dg_key=>$dg_val)
		{
			$data['json_degree'][]	= array("label"=>$dg_val['name'],"db_id"=>$dg_val['id']);	
		}
		$data['json_degree']	=	 json_encode($data['json_degree']);
		$this->load->view('login/hospital_add_doctor',$data);
	}
	
	function editdoctor($doctor_id)
	{
		$data	=	 array();
		$userid = $this->session->userdata('id');
		$data['name'] = $this->session->userdata('name');

		$data['hospital_details']	=	$hospital_details = $this->hospital_model->get_hosptial_data(array('user_id'=>$userid));
		
		$data['doctor_details']	=	$this->hospital_model->get_doctor_data($doctor_id);
		$data['user_details']		=	$this->hospital_model->get_user_data($data['doctor_details']->user_id);
		
		$data['clinic_details']	=	$this->hospital_model->get_clinic_data($doctor_id,$hospital_details->id);
		$data['clinic_timings']	=	json_decode($data['clinic_details']->timings,true);
		
		$this->load->library('form_validation');
		$add_hospital_doctor = $this->input->post('add_hospital_doctor');
		if($add_hospital_doctor=='Save')
		{
			$post	=	$this->input->post();
			if($this->input->post('profile_pic_base64'))
			{
				$this->media_model->upload_type		=	'base64';
				$this->media_model->content_type	=	'profile';
				$this->media_model->base64_data		=	$this->input->post('profile_pic_base64');
				$this->media_model->file_name			=	$this->input->post('profile_pic_base64_name');
				$file_data												=	$this->media_model->upload();

				if(isset($file_data[0]) && $file_data[0]==TRUE)
				{
					$filename_path = $file_data[1];
				}
			}
			$this->db->trans_start();
			$user_data['name']						=	$this->input->post('doctor_name');
			$user_data['email_id']				=	$this->input->post('doctor_email_id');
			$doctor_password							=	$this->input->post('doctor_password');
			if(!empty($doctor_password))
			{
				$user_data['password']			=	md5($doctor_password);
			}
			$user_data['contact_number']	=	$this->input->post('doctor_contact_number');
			$user_data['gender']					=	$this->input->post('doctor_gender');
			$user_data['dob']							=	date("Y-m-d",strtotime($this->input->post('doctor_dob')));
			if(isset($filename_path))
			{
				$user_data['image']	=	$doctor_data['image']	=	$filename_path;
			}
			$user_data['type']						=	2;#3 is for hospital
			$user_data['is_verified']			=	1;#3 is for hospital
			$user_id_affected		=	$this->hospital_model->update_user($data['doctor_details']->user_id,$user_data);

			$doctor_data['name']									=	$this->input->post('doctor_name');
			$doctor_data['gender']								=	$this->input->post('doctor_gender');
			$doctor_data['summary']								=	$this->input->post('doctor_summary');
			$doctor_data['reg_no']								=	$this->input->post('doctor_reg_no');
			$doctor_data['council_id']						=	$this->input->post('doctor_council');
			
			$doctor_data['speciality']					=	@rtrim(implode(",",$this->input->post('speciality')),",");
			$doctor_data['other_speciality']		=	@rtrim(implode(",",$this->input->post('speciality_other')),",");
			$doctor_data['qualification']				=	@rtrim(implode(",",$this->input->post('degree')),",");	
			$doctor_data['other_qualification']	=	@rtrim(implode(",",$this->input->post('degree_other')),",");
			$doctor_data['yoe']										=	$this->input->post('doctor_yoe');
			$doctor_data['contact_number']				=	$this->input->post('doctor_contact_number');

			$doctor_id_affected	=	$this->hospital_model->update_doctor($doctor_id,$doctor_data);

			$clinic_data['contact_number']		=	$this->input->post('clinic_contact_number');
			$clinic_data['duration']					=	$this->input->post('avg_patient_duration');
			$clinic_data['consultation_fees']	=	$this->input->post('consult_fee');
			$clinic_data['timings'] 					= json_encode(array(
																				array(
																					array(
																						!empty($post['sun_mor_open']) ? date('H:i:s', strtotime($post['sun_mor_open'])) : '',
																						!empty($post['sun_mor_close']) ? date('H:i:s', strtotime($post['sun_mor_close'])) : ''
																					),
																					array(
																						!empty($post['sun_eve_open']) ? date('H:i:s', strtotime($post['sun_eve_open'])) : '',
																						!empty($post['sun_eve_close']) ? date('H:i:s', strtotime($post['sun_eve_close'])) : ''
																					)
																				),
																				array(
																					array(
																						!empty($post['mon_mor_open']) ? date('H:i:s', strtotime($post['mon_mor_open'])) : '',
																						!empty($post['mon_mor_close']) ? date('H:i:s', strtotime($post['mon_mor_close'])) : ''
																					),
																					array(
																						!empty($post['mon_eve_open']) ? date('H:i:s', strtotime($post['mon_eve_open'])) : '',
																						!empty($post['mon_eve_close']) ? date('H:i:s', strtotime($post['mon_eve_close'])) : ''
																					)
																				),
																				array(
																					array(
																						!empty($post['tue_mor_open']) ? date('H:i:s', strtotime($post['tue_mor_open'])) : '',
																						!empty($post['tue_mor_close']) ? date('H:i:s', strtotime($post['tue_mor_close'])) : ''
																					),
																					array(
																						!empty($post['tue_eve_open']) ? date('H:i:s', strtotime($post['tue_eve_open'])) : '',
																						!empty($post['tue_eve_close']) ? date('H:i:s', strtotime($post['tue_eve_close'])) : ''
																					)
																				),
																				array(
																					array(
																						!empty($post['wed_mor_open']) ? date('H:i:s', strtotime($post['wed_mor_open'])) : '',
																						!empty($post['wed_mor_close']) ? date('H:i:s', strtotime($post['wed_mor_close'])) : ''
																					),
																					array(
																						!empty($post['wed_eve_open']) ? date('H:i:s', strtotime($post['wed_eve_open'])) : '',
																						!empty($post['wed_eve_close']) ? date('H:i:s', strtotime($post['wed_eve_close'])) : ''
																					)
																				),
																				array(
																					array(
																						!empty($post['thu_mor_open']) ? date('H:i:s', strtotime($post['thu_mor_open'])) : '',
																						!empty($post['thu_mor_close']) ? date('H:i:s', strtotime($post['thu_mor_close'])) : ''
																					),
																					array(
																						!empty($post['thu_eve_open']) ? date('H:i:s', strtotime($post['thu_eve_open'])) : '',
																						!empty($post['thu_eve_close']) ? date('H:i:s', strtotime($post['thu_eve_close'])) : ''
																					)
																				),
																				array(
																					array(
																						!empty($post['fri_mor_open']) ? date('H:i:s', strtotime($post['fri_mor_open'])) : '',
																						!empty($post['fri_mor_close']) ? date('H:i:s', strtotime($post['fri_mor_close'])) : ''
																					),
																					array(
																						!empty($post['fri_eve_open']) ? date('H:i:s', strtotime($post['fri_eve_open'])) : '',
																						!empty($post['fri_eve_close']) ? date('H:i:s', strtotime($post['fri_eve_close'])) : ''
																					)
																				),
																				array(
																					array(
																						!empty($post['sat_mor_open']) ? date('H:i:s', strtotime($post['sat_mor_open'])) : '',
																						!empty($post['sat_mor_close']) ? date('H:i:s', strtotime($post['sat_mor_close'])) : ''
																					),
																					array(
																						!empty($post['sat_eve_open']) ? date('H:i:s', strtotime($post['sat_eve_open'])) : '',
																						!empty($post['sat_eve_close']) ? date('H:i:s', strtotime($post['sat_eve_close'])) : ''
																					)
																				)
																			));		
			$clinic_id	=	$this->hospital_model->update_clinic($data['clinic_details']->id,$clinic_data);
					
			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE)
			{
				#echo  $this->db->_error_message();exit;
			}
			else
			{
				redirect('/hospital/managedoctors/'.$hospital_details->id);
			}
			
		}

		$data['council'] = $this->common_model->getCouncils(array('status'=>ACTIVE,'column'=>array('id','name'),'id_as_key'=>TRUE));
		foreach($data['council'] as $c_key=>$c_val)
		{
			$data['json_council'][]	= array("label"=>$c_val['name'],"db_id"=>$c_val['id']);	
		}
		$data['json_council']	=	 json_encode($data['json_council']);

		$data['speciality'] = $this->common_model->getSpeciality(array('satus'=>array(1,2),'column'=>array('id','name'),'id_as_key'=>TRUE));
		foreach($data['speciality'] as $sp_key=>$sp_val)
		{
			$data['json_speciality'][]	= array("label"=>$sp_val['name'],"db_id"=>$sp_val['id']);	
		}
		$data['json_speciality']	=	 json_encode($data['json_speciality']);

		
		$data['degree'] 		= $this->common_model->getQualification(array('satus'=>array(1,2),'column'=>array('id','name'),'id_as_key'=>TRUE));
		foreach($data['degree'] as $dg_key=>$dg_val)
		{
			$data['json_degree'][]	= array("label"=>$dg_val['name'],"db_id"=>$dg_val['id']);	
		}
		$data['json_degree']	=	 json_encode($data['json_degree']);
		$this->load->view('login/hospital_update_doctor',$data);
	}
	
	function patient_manage()
	{
		$this->load->model(array('patient_model','clinic_model','page_model','doctor_model'));
		$userid = $this->session->userdata('id');
		$data['name'] = $this->session->userdata('name');
		$data['hospital_details']	=	$hospital_details = $this->hospital_model->get_hosptial_data(array('user_id'=>$userid));

		$data['doctor_data'] = $this->doctor_model->get_doctor_data(0,0,array('hospital_id'=>$data['hospital_details']->id,'multi'=>TRUE));
		#$data['userdetails'] = $this->user_model->get_all_userdetails($userid);
		$data['cities'] = $this->location_model->get_all_cities();
		$data['current_tab'] = 'patient_manage';

		$scharr = array();
		if($this->input->get('page_id'))
		{
			$page_id = $this->input->get('page_id');
		}
		else
		{
			$page_id = 1;
		}
		$limit = LIMIT;
		if(sizeof($_GET)>0)
		{
			foreach($_GET as $gKey=>$gVal)
			{
				$data['get_'.$gKey] = $gVal;
			}
		}
		$offset = ($page_id-1)*$limit;

		if($data['hospital_details']->id)
		{
			$scharr['hospital_id'] = $data['hospital_details']->id;
		}

		if($this->input->get('clinic_id'))
		{
			$scharr['clinic_id'] = $this->input->get('clinic_id');
		}

		if($this->input->get('patient_name'))
		{
			$scharr['patient_name'] = $this->input->get('patient_name');
		}
		if($this->input->get('patient_email'))
		{
			$scharr['patient_email'] = $this->input->get('patient_email');
		}
		$scharr['limit'] = $limit;
		$scharr['offset'] = $offset;
		$data['patient_data'] = $this->patient_model->get_patient_list($scharr);
		
		$patient_count = $this->patient_model->get_patient_list_count($scharr);
		
		if(isset($_GET['t']))
		{
			echo $this->patient_model;
			print_r($patient_count);exit;
		}
		
		$this->page_model->total = $patient_count['num_rows'];
		$this->page_model->page = $page_id;
		$this->page_model->limit = $limit;

		unset($scharr['doctor_id'],$scharr['offset'],$scharr['limit']);
		$request_str = http_build_query($scharr);
		$this->page_model->url = BASE_URL."doctor/patient_manage?page_id={page}".((empty($request_str))?'':'&'.$request_str);
		$data['limit'] = $limit;
		$data['offset'] = ($page_id-1)*$limit;
		$data['total'] = $patient_count;
		$data['pagination'] = $this->page_model->render();

		$this->load->view('login/hospital_manage_patient', isset($data) ? $data : NULL);
	}

	function patient_add()
	{
		# base64 image upload code
		$this->media_model->upload_type		=	'base64';
		$this->media_model->content_type	=	'profile';
		$this->media_model->base64_data		=	$this->input->post('profile_pic_base64');
		$this->media_model->file_name			=	$this->input->post('profile_pic_base64_name');
		$file_data												=	$this->media_model->upload();
		//$doctor_id												=	$_POST['doctor_name'];
		$hospital_id											=	$_POST['hospital_add_id'];
		
		$_POST['patient_image']	=	'';

		if(isset($file_data[0]) && $file_data[0]==TRUE)
		{
			$_POST['patient_image'] = $file_data[1];
		}
		else
		{
			if(isset($file_data[0]) && $file_data[0]==FALSE)
			{
				#echo json_encode(array("error"=>$file_data[1]));
			}
		}
		
		#$patient['name'] = (isset($_POST['patient_name']))?$_POST['patient_name']:'';
		if(isset($_POST['patient_name']) && !empty($_POST['patient_name']))$patient['name']=$_POST['patient_name'];
		
		#$patient['image'] = (isset($_POST['patient_image']))?$_POST['patient_image']:'';
		if(isset($_POST['patient_image']) && !empty($_POST['patient_image']))$patient['image']=$_POST['patient_image'];
		
		#$patient['blood_group'] = (isset($_POST['blood_group']) && !empty($_POST['blood_group']))?$_POST['blood_group']:'';
		if(isset($_POST['blood_group']) && !empty($_POST['blood_group']))$patient['blood_group']=$_POST['blood_group'];
		
		#$patient['location_id'] = (isset($_POST['locality']) && !empty($_POST['locality']))?$_POST['locality']:0;
		if(isset($_POST['locality']) && !empty($_POST['locality']))$patient['location_id']=$_POST['locality'];
		
		#$patient['city_id'] = (isset($_POST['city']) && !empty($_POST['city']))?$_POST['city']:0;
		if(isset($_POST['city']) && !empty($_POST['city']))$patient['city_id']=$_POST['city'];
		
		#$patient['email'] = (isset($_POST['email']))?$_POST['email']:'';
		if(isset($_POST['email']) && !empty($_POST['email']))$patient['email']=$_POST['email'];
		
		#$patient['gender'] = (isset($_POST['gender']))?$_POST['gender']:'';
		if(isset($_POST['gender']) && !empty($_POST['gender']))$patient['gender']=$_POST['gender'];
		
		#$patient['address'] = (isset($_POST['address']))?$_POST['address']:'';
		if(isset($_POST['address']) && !empty($_POST['address']))$patient['address']=$_POST['address'];
		
		#$patient['pin_code'] = (isset($_POST['pincode']))?$_POST['pincode']:'';
		if(isset($_POST['pincode']) && !empty($_POST['pincode']))$patient['pin_code']=$_POST['pincode'];
		
		if(isset($_POST['dob']) && !empty($_POST['dob']))$patient['dob']=date("Y-m-d",strtotime($_POST['dob']));
		
		#$patient['other_location'] = (isset($_POST['other_locality']))?$_POST['other_locality']:'';
		if(isset($_POST['other_locality']) && !empty($_POST['other_locality']))$patient['other_location']=$_POST['other_locality'];
		
		#$patient['mobile_number'] = (isset($_POST['mobile_number']))?$_POST['mobile_number']:'';
		if(isset($_POST['mobile_number']) && !empty($_POST['mobile_number']))$patient['mobile_number']=$_POST['mobile_number'];

		#$patient['food_habits'] = (isset($_POST['food_habits']))?$_POST['food_habits']:'';
		if(isset($_POST['food_habits']) && !empty($_POST['food_habits']))$patient['food_habits']=$_POST['food_habits'];
		
		#$patient['alcohol'] = (isset($_POST['alcohol']))?$_POST['alcohol']:'';
		if(isset($_POST['alcohol']) && !empty($_POST['alcohol']))$patient['alcohol']=$_POST['alcohol'];
		
		#$patient['smoking'] = (isset($_POST['smoking']))?$_POST['smoking']:'';
		if(isset($_POST['smoking']) && !empty($_POST['smoking']))$patient['smoking']=$_POST['smoking'];
		
				
		#$patient['ciggi_per_day'] = (isset($_POST['no_of_cig']))?intval($_POST['no_of_cig']):0;
		if(isset($_POST['no_of_cig']) && !empty($_POST['no_of_cig']))$patient['ciggi_per_day']=$_POST['no_of_cig'];
		
		#$patient['tobacco_consumption'] = (isset($_POST['tobacco']))?$_POST['tobacco']:'';
		if(isset($_POST['tobacco']) && !empty($_POST['tobacco']))$patient['tobacco_consumption']=$_POST['tobacco'];
		//$patient['doctor_id']		=	$doctor_id;
		$patient['hospital_id']	=	$hospital_id;
		
	
		$patient_id = (isset($_POST['patient_id']))?$_POST['patient_id']:'';
		
		if(empty($patient_id))
		{
			$patient_id = $this->patient_model->insert_patient($patient);
			echo json_encode(array("id"=>$patient_id,"name"=>$patient['name']));
		}
		else
		{
			$this->patient_model->update_patient($patient,$patient_id);
		}

		if($patient_id)
		{
			$bmi['height_feet'] = (isset($_POST['height_feet']))?$_POST['height_feet']:'';
			$bmi['height_inches'] = (isset($_POST['height_inches']))?$_POST['height_inches']:'';
			$bmi['weight'] = (isset($_POST['weight']))?$_POST['weight']:'';
			$bmi['bmi_value'] = (isset($_POST['bmi_value']))?$_POST['bmi_value']:'';
			$bmi['patient_id'] = $patient_id;
			$bmi['user_id'] = (isset($_POST['user_id']))?$_POST['user_id']:NULL;
			if($bmi['bmi_value'] && $bmi['weight'])
			{
				$patient_bmi = $this->patient_model->insert_patient_bmi($bmi);
			}
			
			$family_member_name = (isset($_POST['family_member_name']))?$_POST['family_member_name']:'';
			
			if(isset($family_member_name) && is_array($family_member_name) && sizeof($family_member_name)>0)
			{
				foreach($family_member_name as $key=>$val)
				{
					if(is_array($val) && sizeof($val)>0 && !empty($_POST['family_disease'][$key]))
					{
						$memebers = array_keys($val);
						$family_details['family_member_name'] = $memebers; 
						$family_details['family_summary'] = (isset($_POST['family_summary'][$key]))?$_POST['family_summary'][$key]:'';
						$family_details['family_disease'] = (isset($_POST['family_disease'][$key]))?$_POST['family_disease'][$key]:'';
						$family_details['patient_id'] = $patient_id;

						if(!empty($_POST['family_detail_id'][$key])){
							$this->patient_model->update_patient_family_history($_POST['family_detail_id'][$key],$family_details);
						}else{
							$this->patient_model->insert_patient_family_history($family_details);
						}
					}
				}
			}
			
			$disease_from_year = (isset($_POST['disease_from_year']))?$_POST['disease_from_year']:NULL;
			if(isset($disease_from_year) && is_array($disease_from_year) && sizeof($disease_from_year)>0)
			{
				foreach($disease_from_year as $key=>$val)
				{
					if(!empty($val))
					{
						$patient_past_disease['disease_name'] =  (isset($_POST['disease_name'][$key]))?$_POST['disease_name'][$key]:NULL; 
						$patient_past_disease['disease_from_year'] =  (isset($_POST['disease_from_year'][$key]))?$_POST['disease_from_year'][$key]:NULL; 
						$patient_past_disease['disease_from_month'] =  (isset($_POST['disease_from_month'][$key]))?$_POST['disease_from_month'][$key]:NULL; 
						$patient_past_disease['disease_duration'] =  (isset($_POST['disease_duration'][$key]))?$_POST['disease_duration'][$key]:NULL; 
						$patient_past_disease['disease_details'] =  (isset($_POST['disease_details'][$key]))?$_POST['disease_details'][$key]:NULL; 
						$patient_past_disease['patient_id'] = $patient_id;
						
						if(!empty($_POST['past_disease_id'][$key]))
						{
							$this->patient_model->update_patient_past_disease($_POST['past_disease_id'][$key],$patient_past_disease);
						}
						else
						{
							$this->patient_model->insert_patient_past_disease($patient_past_disease);
						}
					}
				}
			}

			$surgery_name = (isset($_POST['surgery_name']))?$_POST['surgery_name']:NULL;
			if(isset($surgery_name) && is_array($surgery_name) && sizeof($surgery_name)>0)
			{
				foreach($surgery_name as $key=>$val)
				{
					if(!empty($val))
					{
						$patient_past_surgery['surgery_name'] =  $val;
						$patient_past_surgery['surgery_reason'] =  (isset($_POST['surgery_reason'][$key]))?$_POST['surgery_reason'][$key]:NULL; 
						$patient_past_surgery['surgery_date'] =  (isset($_POST['surgery_date'][$key]))?$_POST['surgery_date'][$key]:NULL; 
						$patient_past_surgery['patient_id'] = $patient_id;
	
						if(!empty($_POST['past_surgery_id'][$key]))
						{
							$this->patient_model->update_patient_past_surgery($_POST['past_surgery_id'][$key],$patient_past_surgery);
						}
						else
						{
							$this->patient_model->insert_patient_past_surgery($patient_past_surgery);
						}
					}
				}
			}

			$ongoing_medications = (isset($_POST['ongoing_medications']))?$_POST['ongoing_medications']:NULL;	
			if(isset($ongoing_medications) && is_array($ongoing_medications) && sizeof($ongoing_medications)>0)
			{
				foreach($ongoing_medications as $key=>$val)
				{
					if(!empty($val))
					{
						$patient_medication['medication'] = $val;
						$patient_medication['patient_id'] = $patient_id;
						if(!empty($_POST['ongoing_medications_id'][$key]))
						{
							$this->patient_model->update_patient_medication($_POST['ongoing_medications_id'][$key],$patient_medication);
						}
						else
						{
							$this->patient_model->insert_patient_medication($patient_medication);
						}
					}
				}
			}

			$allergic = (isset($_POST['allergic']))?$_POST['allergic']:NULL;	
			if(isset($allergic) && is_array($allergic) && sizeof($allergic)>0)
			{
				foreach($allergic as $key=>$val)
				{
					if(!empty($val))
					{
						$patient_allergic['allergic'] = $val;
						$patient_allergic['allery_type'] = (!empty($_POST['allergic_list'][$key]))?$_POST['allergic_list'][$key]:NULL;
						$patient_allergic['patient_id'] = $patient_id;
						if(!empty($_POST['allergic_id'][$key]))
						{
							$this->patient_model->update_patient_allergic($_POST['allergic_id'][$key],$patient_allergic);
						}else
						{
							$this->patient_model->insert_patient_allergic($patient_allergic);
						}
					}
				}
			}
		}
	}
	
	function get_patient()
	{
		$id	=	$this->input->post('id');
		if($id)
		{
			$patientdetails = $this->patient_model->get_patient_details_byid($id);
			echo json_encode($patientdetails);
		}
	}

	function patient_manage_data()
	{
		$data	=	 array();
		$userid = $this->session->userdata('id');
		$data['name'] = $this->session->userdata('name');
		$hospital_id	=	$this->input->post('hospital_id');
		$doctor_id		=	$this->input->post('doctor_id');
			
		$scharr = array();
		if ($this->input->post('page_id'))
		{
				$page_id = $this->input->post('page_id');
		}
		else
		{
				$page_id = 1;
		}
		$limit = 15;
		if (sizeof($_POST) > 0)
		{
				foreach ($_POST as $gKey => $gVal)
				{
						$data['post_' . $gKey] = $gVal;
				}
		}
		$offset = ($page_id - 1) * $limit;

		if ($hospital_id)
		{
				$scharr['hospital_id'] = $hospital_id;
		}
		/*if ($doctor_id)
		{
				$scharr['doctor_id'] = $doctor_id;
		}*/

		if ($this->input->post('patient_name'))
		{
				$scharr['patient_name'] = $this->input->post('patient_name');
		}

		$scharr['limit']      = $limit;
		$scharr['offset']     = $offset;
		$data['patient_data'] = $this->patient_model->get_patient_list($scharr);
		$patient_count        = $this->patient_model->get_patient_list_count($scharr);
		if($patient_count['num_rows']>0)
		{
			$this->page_model->total = $patient_count['num_rows'];
			$this->page_model->page  = $page_id;
			$this->page_model->limit = $limit;
			
			unset($scharr['offset'], $scharr['limit']);
			$request_str           = http_build_query($scharr);
			$this->page_model->url =  "{page}" ;
			$data['limit']         = $limit;
			$data['offset']        = ($page_id - 1) * $limit;
			$data['total']         = $patient_count;
			$data['pagination']    = $this->page_model->render();
		}

		echo json_encode($data);
	}

	function get_patient_self_family_history()
	{
		$id	=	$this->input->post('id');
		if($id)
		{
			$data['patientdetails'] = $this->patient_model->get_patient_details_byid($id);
			$data['bmi'] 						= $this->patient_model->get_patient_bmi_details($id);
			$data['blood_group'] 		= $this->common_model->get_blood_group();
			$data['patient_id'] 		= $id;
			
			echo $this->load->view('/login/patient_self_family_history', $data);
			#echo json_encode(array('self'=>$patientdetails,'family'=>$patient_family));
		}
	}

	function patient_disease_surgeries()
	{
		$id	=	$this->input->post('id');
		if($id)
		{
			$data['family_details']	=	$this->patient_model->get_patient_family_details($id);
			$data['past_disease']	=	$this->patient_model->get_patient_past_disease($id);
			$data['patient_id'] 		= $id;
			$data['month'] = array(1=>'January',2=>'February',3=>'March',4=>'April',5=>'May',6=>'June',7=>'July',8=>'August',9=>'September',10=>'October',11=>'November',12=>'December');
			$data['past_surgery'] = $this->patient_model->get_patient_past_surgery($id);
			$data['allergic'] = $this->patient_model->get_patient_allergy($id);
			$data['allergy'] = array(1=>"Food Allergy",2=>"Durg Allergy",3=>"Environmental Allergy",4=>"Animal Allergy");
			$data['medication'] = $this->patient_model->get_patient_medication($id);			
			
			echo $this->load->view('/login/patient_past_disease_details', $data);
		}
	}
	function get_thumbnail($image)
	{
		$file_path	=	 pathinfo($image);
		$file_path['filename']	=	$file_path['filename']."_t";
		return $file_path['dirname']."/".$file_path['filename'].".".$file_path['extension'];
	}
	function deletehospitalphoto()
	{
		$this->hospital_model->deletehospitalphoto($_POST['hospitalid'],$_POST['photoid']);
	}
	function changepassword()
	{
		$userid				= $this->session->userdata('id');
		$data['name'] = $this->session->userdata('name');
		$userdetails	= $this->user_model->get_all_userdetails($userid);
		$data['hospital_details']	=	$this->hospital_model->get_hosptial_data(array('user_id'=>$userid));
		$this->load->library('form_validation');
		if(isset($_POST['submit']) && $_POST['submit']=='Change')
		{
			$config = array(
				array(
					'field'=> 'oldpass',
					'label'=> 'Current Password',
					'rules'=> 'required|callback_check_current_password'
				),
				array(
					'field'=> 'newpass',
					'label'=> 'New Password',
					'rules'=> 'required|min_length[6]|max_length[24]'
				),
				array(
					'field'=> 'cnfmnewpass',
					'label'=> 'New Password Confirm',
					'rules'=> 'required|matches[newpass]'
				)
			);
			$this->form_validation->set_rules($config);
			if($this->form_validation->run() !== FALSE)
			{
				//Change password
				$check = $this->user_model->change_password($userid,$_POST['newpass']);
				//send mailer
				$this->load->model('mail_model');
				$this->mail_model->changepasswordmail($userdetails->email_id, $userdetails->name);
				redirect('/hospital/scheduler');
			}
		}
		
		$this->load->view('login/hospital_changepassword', isset($data) ? $data : NULL);
	}
	

}