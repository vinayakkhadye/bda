<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');

class Doctor extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model(array('common_model','user_model','doctor_model','location_model','mail_model','patient_model','sendsms_model'));

		/* user login check code begins */
		$session_userid   = $this->session->userdata('id');
		$session_usertype = $this->session->userdata('usertype');
//		print_r($this->session);exit;
		if(empty($session_userid))
		{
			redirect('/login', 'refresh');
			exit();
		}
		elseif($session_usertype != '2')
		{
			redirect('/login', 'refresh');
			exit();
		}
		/* user login check code ends */
	}
	
	function index()
	{
		redirect('/doctor/dashboard');
	}

	function postsignup()
	{
		// Get userid from session
		$userid = $this->session->userdata('id');

		// Check if the details of doctor are present in the db
		$doctor_details = $this->doctor_model->check_doctor_details_exist($userid);

		if($doctor_details === FALSE) // details not present
		{
			$this->load->library('form_validation');
			$submit = $this->input->post('submit');
			if(!empty($submit))
			{
				//print_r($this->input->post());
				$config = array(
					array(
						'field'=> 'speciality',
						'label'=> 'Speciality',
						'rules'=> 'required|trim'
					),
					array(
						'field'=> 'qualification',
						'label'=> 'Qualification',
						'rules'=> 'required'
					),
					array(
						'field'=> 'doc_reg_no',
						'label'=> 'Registration Number',
						'rules'=> 'required|trim'
					),
					array(
						'field'=> 'experience',
						'label'=> 'Experience',
						'rules'=> 'required|trim'
					),
					array(
						'field'=> 'clinic_name',
						'label'=> 'Clinic Name',
						'rules'=> 'required|trim'
					),
					array(
						'field'=> 'clinic_address',
						'label'=> 'Clinic Address',
						'rules'=> 'required|trim'
					),
					array(
						'field'=> 'state',
						'label'=> 'State',
						'rules'=> 'required|trim'
					),
					array(
						'field'=> 'city',
						'label'=> 'City',
						'rules'=> 'required|trim'
					),
					array(
						'field'=> 'locality',
						'label'=> 'Locality',
						'rules'=> 'required|trim'
					),
					array(
						'field'=> 'pincode',
						'label'=> 'Pincode',
						'rules'=> 'required|trim|numeric'
					),
					array(
						'field'=> 'clinic_number',
						'label'=> 'Clinic Number',
						'rules'=> 'required|trim|numeric|callback_clinic_number_validation'
					),
					array(
						'field'=> 'clinic_number_code',
						'label'=> 'Clinic Code',
						'rules'=> 'trim|numeric'
					),
					array(
						'field'=> 'days',
						'label'=> 'Appointment Days',
						'rules'=> 'required'
					),
					array(
						'field'=> 'consult_fee',
						'label'=> 'Consultation Fee',
						'rules'=> 'trim'
					),
					array(
						'field'=> 'avg_patient_duration',
						'label'=> 'Average duration per patient',
						'rules'=> 'required|trim'
					)
				);
				$this->form_validation->set_rules($config);
				if($this->form_validation->run() == FALSE)
				{
					// Invalid form details
				}
				else
				{
					// Valid form details

					/* check if the entry is present in doctor table,
					If yes, then redirect to dashboard
					else display post signup page */
					
					// Merge clinic number
					if(!empty($_POST['clinic_number_code']))
					$_POST['clinic_number'] = $_POST['clinic_number_code'].'-'.$_POST['clinic_number'];
					else
					$_POST['clinic_number'] = $_POST['clinic_number'];
					
					// Insert details in doctor table
					$doctor_id = $this->doctor_model->insert_doctor($userid, $this->input->post());

					// Insert details in clinic table
					$clinic_id = $this->doctor_model->insert_clinic($userid, $doctor_id, $this->input->post());

//					// Insert into schedule table
//					$this->doctor_model->insert_schedule($userid, $doctor_id, $clinic_id, $this->input->post());

					redirect('doctor/dashboard', 'refresh');
				}
			}

			$data['speciality'] = $this->doctor_model->get_speciality();
			$data['qualification'] = $this->doctor_model->get_qualification();
			$data['states'] = $this->location_model->get_state();

			$this->load->view('postsignup', isset($data) ? $data : NULL);
		}
		else
		{
			redirect('doctor/dashboard', 'location');
		}
	}


	function smartlisting()
	{
		$this->load->library('form_validation');
		$userid = $this->session->userdata('id');
		if($this->doctor_model->check_sor_eligibility($userid))
		{
			$data['sor_eligible'] = '1';
		}
		$data['smartlisting'] = '1';
		$data['name'] = $this->session->userdata('name');
		$data['userdetails'] = $this->user_model->get_all_userdetails($userid);
		
		$data['council'] = $this->doctor_model->get_council();
		$data['doctor_data'] = $this->doctor_model->get_doctor_data($userid);
		#print_r($data['doctor_data']);exit;
		$data['speciality'] = $this->doctor_model->get_all_speciality();
		$data['degree'] = $this->doctor_model->get_all_degree();
		
		$data['cities'] = $this->location_model->get_all_cities();

		if(!empty($data['doctor_data']))
		{
			$doctorid = $data['doctor_data']->id;
			$data['doctorid'] = $doctorid;
			$data['clinic_present'] = $this->doctor_model->check_clinic_present($doctorid);
		}
		else
		{
			$doctorid = NULL;
			$data['doctorid'] = $doctorid;
			$data['clinic_present'] = NULL;
		}
		
		$current_package = $this->doctor_model->get_all_doctor_packages($userid);
		if($current_package)
		{
			$data['current_packages'] = $current_package;
		}
		
		$sor_eligibility = $this->doctor_model->check_sor_eligibility($userid);
		if($sor_eligibility)
		{
			$data['sor_eligibility'] = $sor_eligibility;
		}
		
		//print_r($data['clinic_present']);
		
		$sl_step1_submit = $this->input->post('sl_step1');
		$sl_step2_submit = $this->input->post('sl_step2');
		if(isset($sl_step1_submit) && $sl_step1_submit == 'sl_step1')
		{
			
			$config = array(
				array(
					'field'=> 'name',
					'label'=> 'Name',
					'rules'=> 'required|trim|min_length[4]|max_length[30]|xss_clean'
				),
				array(
					'field'=> 'email',
					'label'=> 'Email',
					'rules'=> 'required|trim|valid_email|callback_check_email_exists'
				),
				array(
					'field'=> 'mob',
					'label'=> 'Mobile Number',
					'rules'=> 'required|trim|min_length[10]|max_length[10]|callback_checkmobverified'
				),
				array(
					'field'=> 'dob',
					'label'=> 'Date of Birth',
					'rules'=> 'required'
				),
				array(
					'field'=> 'gender',
					'label'=> 'Gender',
					'rules'=> 'required'
				),
				array(
					'field'=> 'yoe',
					'label'=> 'Years of Experience',
					'rules'=> 'numeric|max_length[2]'
				),
				array(
					'field'=> 'degree',
					'label'=> 'Degree',
					'rules'=> 'callback_degree_check'
				),
				array(
					'field'=> 'speciality',
					'label'=> 'Speciality',
					'rules'=> 'callback_speciality_check'
				)
			);
			$this->form_validation->set_rules($config);
			//echo $this->input->post('fbid');
			//echo date('Y - m - d', strtotime($this->input->post('dob')));
			if($this->form_validation->run() === FALSE)
			{
				// Invalid details
			}
			else
			{
				$mob = $this->input->post('mob');
				// Details are valid
				$flag= $this->session->userdata('code_verified');
				if(($data['userdetails']->contact_number == $mob) || ($flag == '1'))
				{
					// check if file is uploaded or not
					$newfilename = $this->input->post('profile_pic_base64_name');
					if(!empty($newfilename))
					{
						//echo getcwd();
						$md        = date('M').date('Y'); // getting the current month and year for folder name
						$structure = "./media/photos/".$md; // setting the folder path
						// Check if the directory with that particular name is present or not
						if(!is_dir("./media/photos/".$md))
						{
							// If directory not present, then create the directory
							mkdir($structure, 0777);
						}
						// setup the image new file name
						$filename      = md5($newfilename).rand(10000,99999);
						// Get extension of the file
						$ext           = pathinfo($newfilename, PATHINFO_EXTENSION);
						// get the full filename with full path as it needs to be entered in the db
						$filename_path = $structure."/".$filename.".".$ext;

						$decoded_pic   = base64_decode($this->input->post('profile_pic_base64'));
						file_put_contents($filename_path, $decoded_pic);
					}
					else
					{
						$filename_path = NULL;
					}

					$id      = $this->user_model->update_account($_POST, $filename_path, $userid);
					$d_check = $this->doctor_model->check_doctor_details_exist($userid);
					if($d_check === FALSE)
					{
						$this->doctor_model->insert_doctor_professional_details($_POST, $filename_path, $userid);
					}
					else
					{
						$this->doctor_model->update_doctor_professional_details($_POST, $filename_path, $userid);
					}
					if($data['clinic_present'] == NULL)
					{
						// unset code verified status from the session
						$this->session->unset_userdata('code_verified');

						// Set a variable in session to identify the user has finished step 1
						$this->session->set_userdata('sl_step1', 'done');

						redirect('/doctor/smartlisting');
					}
					else
					{
						redirect('/doctor/smartlisting');
					}
				}
				else
				{
					$this->form_validation->set_message('mob', 'Mobile Number is not verified');
				}
			}
		}
		
		if(isset($sl_step2_submit) && $sl_step2_submit == 'sl_step2')
		{
			
			if($data['clinic_present'] == NULL)
			{
				$config = array(
					array(
						'field'=> 'clinic_name',
						'label'=> 'Clinic Name',
						'rules'=> 'required|trim'
					),
					array(
						'field'=> 'clinic_address',
						'label'=> 'Clinic Address',
						'rules'=> 'required|trim'
					),
					array(
						'field'=> 'city',
						'label'=> 'City',
						'rules'=> 'required|trim'
					),
					array(
						'field'=> 'locality',
						'label'=> 'Locality',
						'rules'=> 'trim|callback_locality_check'
					),
					array(
						'field'=> 'pincode',
						'label'=> 'Pincode',
						'rules'=> 'required|trim|numeric'
					),
					array(
						'field'=> 'clinic_number',
						'label'=> 'Clinic Number',
						'rules'=> 'required|trim|numeric|callback_clinic_number_validation'
					),
					array(
						'field'=> 'clinic_number_code',
						'label'=> 'Clinic Code',
						'rules'=> 'trim|numeric'
					),
					array(
						'field'=> 'days',
						'label'=> 'Appointment Days',
						'rules'=> 'required'
					),
					array(
						'field'=> 'consult_fee',
						'label'=> 'Consultation Fee',
						'rules'=> 'trim'
					),
					array(
						'field'=> 'avg_patient_duration',
						'label'=> 'Average duration per patient',
						'rules'=> 'required|trim'
					)
				);
				$this->form_validation->set_rules($config);
				if($this->form_validation->run() == FALSE)
				{
					// Invalid form details
				}
				else
				{
					// Merge clinic number
					if(!empty($_POST['clinic_number_code']))
					$_POST['clinic_number'] = $_POST['clinic_number_code'].'-'.$_POST['clinic_number'];
					else
					$_POST['clinic_number'] = $_POST['clinic_number'];
					
					// Insert details in doctor table
					#$this->doctor_model->insert_cityid_doctor($userid, $this->input->post());

					// Insert details in clinic table
					$clinic_id = $this->doctor_model->insert_clinic($userid, $doctorid, $this->input->post());

					// Insert into schedule table
//					$this->doctor_model->insert_schedule($userid, $doctorid, $clinic_id, $this->input->post());
					
					if(isset($_POST['add_more_clinic_x']))
					{
						redirect('/doctor/smartlisting');
					}
					else
					{
						// Set a variable in session to identify the user has finished step 2
						$this->session->set_userdata('sl_step2', 'done');
						// Unset step 1
						$this->session->unset_userdata('sl_step1');
						
						redirect('/doctor/smartlisting');
					}
					
				}
			}
			else
			{
				if(!empty($_POST['clinic_name']))	
				{
					$config = array(
						array(
							'field'=> 'clinic_name',
							'label'=> 'Clinic Name',
							'rules'=> 'required|trim'
						),
						array(
							'field'=> 'clinic_address',
							'label'=> 'Clinic Address',
							'rules'=> 'required|trim'
						),
						array(
							'field'=> 'city',
							'label'=> 'City',
							'rules'=> 'required|trim'
						),
						array(
							'field'=> 'locality',
							'label'=> 'Locality',
							'rules'=> 'trim|callback_locality_check'
						),
						array(
							'field'=> 'pincode',
							'label'=> 'Pincode',
							'rules'=> 'required|trim|numeric'
						),
						array(
							'field'=> 'clinic_number',
							'label'=> 'Clinic Number',
							'rules'=> 'required|trim|numeric|callback_clinic_number_validation'
						),
						array(
							'field'=> 'clinic_number_code',
							'label'=> 'Clinic Code',
							'rules'=> 'trim|numeric'
						),
						array(
							'field'=> 'days',
							'label'=> 'Appointment Days',
							'rules'=> 'required'
						),
						array(
							'field'=> 'consult_fee',
							'label'=> 'Consultation Fee',
							'rules'=> 'trim'
						),
						array(
							'field'=> 'avg_patient_duration',
							'label'=> 'Average duration per patient',
							'rules'=> 'required|trim'
						)
					);
					$this->form_validation->set_rules($config);
					if($this->form_validation->run() == FALSE)
					{
						// Invalid form details
					}
					else
					{
						// Merge clinic number
						if(!empty($_POST['clinic_number_code']))
						$_POST['clinic_number'] = $_POST['clinic_number_code'].'-'.$_POST['clinic_number'];
						else
						$_POST['clinic_number'] = $_POST['clinic_number'];
						
						// Insert details in doctor table
						#$this->doctor_model->insert_cityid_doctor($userid, $this->input->post());

						// Insert details in clinic table
						$clinic_id = $this->doctor_model->insert_clinic($userid, $doctorid, $this->input->post());

						// Insert into schedule table
//						$this->doctor_model->insert_schedule($userid, $doctorid, $clinic_id, $this->input->post());
						
						if(isset($_POST['add_more_clinic_x']))
						{
							redirect('/doctor/smartlisting');
						}
						else
						{
							// Set a variable in session to identify the user has finished step 2
							$this->session->set_userdata('sl_step2', 'done');
							// Unset step 1
							$this->session->unset_userdata('sl_step1');
						}
						
					}
				}
				else
				{
					// Set a variable in session to identify the user has finished step 2
					$this->session->set_userdata('sl_step2', 'done');
					// Unset step 1
					$this->session->unset_userdata('sl_step1');
				}
			}
		}

		$sl_step1 = $this->session->userdata('sl_step1');
		$sl_step2 = $this->session->userdata('sl_step2');

		if($sl_step1 == 'done')
		{
			$this->load->view('smartlisting_step2', isset($data) ? $data : NULL);
		}
		elseif($sl_step2 == 'done')
		{
			$this->session->unset_userdata('sl_step1');
			$this->session->unset_userdata('sl_step2');
			$eligible = $this->doctor_model->check_sor_eligibility($userid);
			if($eligible === TRUE)
			redirect('/doctor/onlinereputation');
			else
			$this->load->view('smartlisting_step3', isset($data) ? $data : NULL);
		}
		else
		{
			$this->load->view('smartlisting_step1', isset($data) ? $data : NULL);
		}
	}
	
	function addclinic()
	{
		$this->load->library('form_validation');
		$userid = $this->session->userdata('id');
		$data['name'] = $this->session->userdata('name');
		$data['userdetails'] = $this->user_model->get_all_userdetails($userid);
		
		$data['council'] = $this->doctor_model->get_council();
		$data['doctor_data'] = $this->doctor_model->get_doctor_data($userid);
		$data['speciality'] = $this->doctor_model->get_all_speciality();
		$data['degree'] = $this->doctor_model->get_all_degree();
		$data['cities'] = $this->location_model->get_all_cities();
		if($this->doctor_model->check_sor_eligibility($userid))
		{
			$data['sor_eligible'] = '1';
		}

		if(!empty($data['doctor_data']))
		{
			$doctorid = $data['doctor_data']->id;
			$data['doctorid'] = $doctorid;
			$data['clinic_present'] = $this->doctor_model->check_clinic_present($doctorid);
		}
		else
		{
			$doctorid = NULL;
			$data['doctorid'] = $doctorid;
			$data['clinic_present'] = NULL;
		}
		
		$sl_step2_submit = $this->input->post('sl_step2');
		if(isset($sl_step2_submit) && $sl_step2_submit == 'sl_step2')
		{
			if($data['clinic_present'] == NULL)
			{
				$config = array(
					array(
						'field'=> 'clinic_name',
						'label'=> 'Clinic Name',
						'rules'=> 'required|trim'
					),
					array(
						'field'=> 'clinic_address',
						'label'=> 'Clinic Address',
						'rules'=> 'required|trim'
					),
					array(
						'field'=> 'city',
						'label'=> 'City',
						'rules'=> 'required|trim'
					),
					array(
						'field'=> 'locality',
						'label'=> 'Locality',
						'rules'=> 'trim|callback_locality_check'
					),
					array(
						'field'=> 'pincode',
						'label'=> 'Pincode',
						'rules'=> 'required|trim|numeric'
					),
					array(
						'field'=> 'clinic_number',
						'label'=> 'Clinic Number',
						'rules'=> 'required|trim|numeric|callback_clinic_number_validation'
					),
					array(
						'field'=> 'clinic_number_code',
						'label'=> 'Clinic Code',
						'rules'=> 'trim|numeric'
					),
					array(
						'field'=> 'days',
						'label'=> 'Appointment Days',
						'rules'=> 'required'
					),
					array(
						'field'=> 'consult_fee',
						'label'=> 'Consultation Fee',
						'rules'=> 'trim'
					),
					array(
						'field'=> 'avg_patient_duration',
						'label'=> 'Average duration per patient',
						'rules'=> 'required|trim'
					)
				);
				$this->form_validation->set_rules($config);
				if($this->form_validation->run() == FALSE)
				{
					// Invalid form details
				}
				else
				{
					// Merge clinic number
					if(!empty($_POST['clinic_number_code']))
					$_POST['clinic_number'] = $_POST['clinic_number_code'].'-'.$_POST['clinic_number'];
					else
					$_POST['clinic_number'] = $_POST['clinic_number'];
					
					// Insert details in doctor table
					#$this->doctor_model->insert_cityid_doctor($userid, $this->input->post());

					// Insert details in clinic table
					$clinic_id = $this->doctor_model->insert_clinic($userid, $doctorid, $this->input->post());

					// Insert into schedule table
//					$this->doctor_model->insert_schedule($userid, $doctorid, $clinic_id, $this->input->post());
					
					if(isset($_POST['add_more_clinic_x']))
					{
						redirect('/doctor/smartlisting');
					}
					else
					{
						redirect('/doctor/addclinic');
					}
					
				}
			}
			else
			{
				if(!empty($_POST['clinic_name']))	
				{
					$config = array(
						array(
							'field'=> 'clinic_name',
							'label'=> 'Clinic Name',
							'rules'=> 'required|trim'
						),
						array(
							'field'=> 'clinic_address',
							'label'=> 'Clinic Address',
							'rules'=> 'required|trim'
						),
						array(
							'field'=> 'city',
							'label'=> 'City',
							'rules'=> 'required|trim'
						),
						array(
							'field'=> 'locality',
							'label'=> 'Locality',
							'rules'=> 'trim|callback_locality_check'
						),
						array(
							'field'=> 'pincode',
							'label'=> 'Pincode',
							'rules'=> 'required|trim|numeric'
						),
						array(
							'field'=> 'clinic_number',
							'label'=> 'Clinic Number',
							'rules'=> 'required|trim|numeric|callback_clinic_number_validation'
						),
						array(
							'field'=> 'clinic_number_code',
							'label'=> 'Clinic Code',
							'rules'=> 'trim|numeric'
						),
						array(
							'field'=> 'days',
							'label'=> 'Appointment Days',
							'rules'=> 'required'
						),
						array(
							'field'=> 'consult_fee',
							'label'=> 'Consultation Fee',
							'rules'=> 'trim'
						),
						array(
							'field'=> 'avg_patient_duration',
							'label'=> 'Average duration per patient',
							'rules'=> 'required|trim'
						)
					);
					$this->form_validation->set_rules($config);
					if($this->form_validation->run() == FALSE)
					{
						// Invalid form details
					}
					else
					{
						// Merge clinic number
						if(!empty($_POST['clinic_number_code']))
						$_POST['clinic_number'] = $_POST['clinic_number_code'].'-'.$_POST['clinic_number'];
						else
						$_POST['clinic_number'] = $_POST['clinic_number'];
						// Insert details in doctor table
						#$this->doctor_model->insert_cityid_doctor($userid, $this->input->post());

						// Insert details in clinic table
						$clinic_id = $this->doctor_model->insert_clinic($userid, $doctorid, $this->input->post());

						if(isset($_POST['add_more_clinic_x']))
						{
							redirect('/doctor/addclinic');
						}
						else
						{
							redirect('/doctor/manageclinic');
						}
					}
				}
				else
				{
					redirect('/doctor/manageclinic');
				}
			}
		}
		
		$this->load->view('smartlisting_step2', isset($data) ? $data : NULL);
	}
	
	function locality_check()
	{
		$locality = isset($_POST['locality']) ? $_POST['locality'] : NULL;
		$other_locality = isset($_POST['other_locality']) ? $_POST['other_locality'] : NULL;
		if(empty($locality) && empty($other_locality))
		{
			$this->form_validation->set_message('locality_check', 'The %s field is required');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	
	function unset_steps()
	{
		$this->session->unset_userdata('sl_step1');
		$this->session->unset_userdata('sl_step2');
		$this->session->unset_userdata('sl_step3');
	}
	
	function manageclinic()
	{
		$userid = $this->session->userdata('id');
		$data['name'] = $this->session->userdata('name');
		$data['userdetails'] = $this->user_model->get_all_userdetails($userid);
		
		$data['doctor_data'] = $this->doctor_model->get_doctor_data($userid);
		
		if(!empty($data['doctor_data']))
		{
			$doctorid = $data['doctor_data']->id;
			$data['doctorid'] = $doctorid;
			$data['clinic_present'] = $this->doctor_model->check_clinic_present($doctorid);
			$data['clinics'] = $this->doctor_model->get_all_clinics($doctorid);
			//print_r($data['clinics']);
		}
		else
		{
			$doctorid = NULL;
			$data['doctorid'] = $doctorid;
			$data['clinic_present'] = NULL;
		}
		
		if($data['clinic_present'] == NULL)
		{
			// Set a variable in session to identify the user has finished step 1
			$this->session->set_userdata('sl_step1', 'done');
			redirect('/doctor/smartlisting');
		}
		
		$this->load->view('manageclinic', isset($data) ? $data : NULL);
	}
	
	function dashboard()
	{
		$userid = $this->session->userdata('id');
		$data['name'] = $this->session->userdata('name');
		$data['userdetails'] = $this->user_model->get_all_userdetails($userid);
		$data['doctor_data'] = $this->doctor_model->get_doctor_data($userid);
		
		if(!empty($data['doctor_data']))
		{
			$doctorid = $data['doctor_data']->id;
			$data['doctorid'] = $doctorid;
			$data['clinic_present'] = $this->doctor_model->check_clinic_present($doctorid);
			$data['clinics'] = $this->doctor_model->get_all_clinics($doctorid);
			//print_r($data['clinics']);
		}
		else
		{
			$doctorid = NULL;
			$data['doctorid'] = $doctorid;
			$data['clinic_present'] = NULL;
		}
		if($this->doctor_model->check_sor_eligibility($userid))
		{
			$data['sor_eligible'] = '1';
		}
		if($this->doctor_model->check_sa_eligibility($userid))
		{
			$data['sa_eligible'] = '1';
		}

		
		
		
		$this->load->view('doctor_dashboard', isset($data) ? $data : NULL);
	}

	function patient_delete($id)
	{
		$rs = $this->db->update('patient', array("status"=>-1,"updated_on"=>date("Y-m-d H:i:s")), array('id' => $id));
		echo $rs;
	}

	function patient_delete_bytype()
	{
		print_r($_REUEST);exit;
		$rs = false;
		$id = isset($_POST['id'])?intval($_POST['id']):''; 
		$type = isset($_POST['type'])?$_POST['type']:''; 
		if($id){
			if($type == "family_detail"){
				$rs = $this->db->update('patient_family_detail', array("status"=>-1,"updated_on"=>date("Y-m-d H:i:s")), array('id' => $id));
				echo $this->db->last_query();
			}else if($type == "past_disease"){
				$rs = $this->db->update('patient_past_disease', array("status"=>-1,"updated_on"=>date("Y-m-d H:i:s")), array('id' => $id));
				echo $this->db->last_query();
			}else if($type == "past_surgery"){
				$rs = $this->db->update('patient_past_surgery', array("status"=>-1,"updated_on"=>date("Y-m-d H:i:s")), array('id' => $id));
				echo $this->db->last_query();
			}else if($type == "ongoing_medications"){
				$rs = $this->db->update('patient_medication', array("status"=>-1,"updated_on"=>date("Y-m-d H:i:s")), array('id' => $id));
				echo $this->db->last_query();
			}else if($type == "allergic"){
				$rs = $this->db->update('patient_allergic', array("status"=>-1,"updated_on"=>date("Y-m-d H:i:s")), array('id' => $id));
				echo $this->db->last_query();
			}else if($type == "report_detail"){
				$rs = $this->db->update('patient_report', array("status"=>-1,"updated_on"=>date("Y-m-d H:i:s")), array('id' => $id));
				echo $this->db->last_query();
			}
			
			if($rs){
				echo "1";
			}else{
				echo "0";
			}
		}
	}

	function patient_save($id='')
	{
		$userid = $this->session->userdata('id');
		$data['name'] = $this->session->userdata('name');
		$data['userdetails'] = $this->user_model->get_all_userdetails($userid);
		$data['doctor_data'] = $this->doctor_model->get_doctor_data($userid);
		
		if(!empty($data['doctor_data']))
		{
			$doctorid = $data['doctor_data']->id;
			$data['doctorid'] = $doctorid;
			$data['clinic_present'] = $this->doctor_model->check_clinic_present($doctorid);
			$data['clinics'] = $this->doctor_model->get_all_clinics($doctorid);
		}
		else
		{
			$doctorid = NULL;
			$data['doctorid'] = $doctorid;
			$data['clinic_present'] = NULL;
			redirect('/doctor/dashboard');
		}

		if(sizeof($_POST)>0){
			$_POST['doctor_id'] = $doctorid;
			$this->patient_add();
			#redirect("/doctor/patient_manage");
			return false;
		}else{
			$this->load->library('form_validation');
			
			
			$data['cities'] = $this->location_model->get_all_cities();
			$data['family_details_count'] =  $data['past_disease_count'] = $data['past_surgery_count'] =  $data['medication_count'] =  0;
			if(isset($id) && !empty($id)){
				$data['patientdetails'] = $this->patient_model->get_patient_details_byid($id);
				if(empty($data['patientdetails'])){
					redirect('/doctor/dashboard');
				}
				
				$localities = $this->location_model->get_locality($data['patientdetails']->city_id);
				
				$data['localities'] = $localities;
				
				$data['bmi'] = $this->patient_model->get_patient_bmi_details($data['patientdetails']->id);
				$data['family_details'] = $this->patient_model->get_patient_family_details($data['patientdetails']->id);
				$data['family_details_count'] = count($data['family_details'])-1;
				
				#print_r($data['bmi']);exit;
				if($data['patientdetails']->location_id == 0)
				{
					$data['other_locality'] = $data['patientdetails']->other_location;
				}
				
				$data['past_disease'] = $this->patient_model->get_patient_past_disease($data['patientdetails']->id);
				$data['past_disease_count'] = (count($data['past_disease']))?count($data['past_disease'])-1:0;

				$data['past_surgery'] = $this->patient_model->get_patient_past_surgery($data['patientdetails']->id);
				$data['past_surgery_count'] = (count($data['past_surgery']))?count($data['past_surgery'])-1:0;

				$data['medication'] = $this->patient_model->get_patient_medication($data['patientdetails']->id);
				$data['medication_count'] = (count($data['medication']))?count($data['medication'])-1:0;
				
				$data['allergic'] = $this->patient_model->get_patient_allergy($data['patientdetails']->id);
				$data['allergic_count'] = (count($data['allergic']))?count($data['allergic'])-1:0;
				
				#print_r($data['patient_past_disease']);exit;
				#print_r($data['patientdetails']);
			}
			$data['blood_group'] = $this->common_model->get_blood_group();
			$data['month'] = array(1=>'January',2=>'February',3=>'March',4=>'April',5=>'May',6=>'June',7=>'July',8=>'August',9=>'September',10=>'October',11=>'November',12=>'December');
			
			$data['year'] = range(date("Y",strtotime("now")),1970);
			$data['allergy_list'] = array(1=>"Food Allergy",2=>"Drug Allergy",3=>"Environmental Allergy",4=>"Animal Allergy");
			
			$this->load->view('doctor_patient_save', isset($data) ? $data : NULL);
		}
	}

	public function mkpath($path,$perm)
	{
		if(@mkdir($path) or file_exists($path)) return true;
		return ($this->mkpath(dirname($path),$perm) and mkdir($path,$perm));
	}
	
	function patient_add()
	{
		$newfilename = $this->input->post('profile_pic_base64_name');
		if(!empty($newfilename))
		{
			//echo getcwd();
			$md        = date('M').date('Y')."/".strtolower(substr($newfilename,0,1));#.rand(1,60); // getting the current month and year for folder name
			$structure = "./media/photos/".$md; // setting the folder path
			// Check if the directory with that particular name is present or not
			if(!is_dir($structure)){
				$this->mkpath($structure,0777);
			}
			// setup the image new file name
			$filename      = md5($newfilename);#rand(10000,99999)
			// Get extension of the file
			$ext           = pathinfo($newfilename, PATHINFO_EXTENSION);
			// get the full filename with full path as it needs to be entered in the db
			$filename_path = $structure."/".$filename.".".$ext;
	
			$decoded_pic   = base64_decode($this->input->post('profile_pic_base64'));
	
			file_put_contents($filename_path, $decoded_pic);
			$_POST['patient_image'] = $filename_path;
		
		}else{
			$_POST['patient_image'] = '';
		}
		#$patient['doctor_id'] = (isset($_POST['doctor_id']))?$_POST['doctor_id']:'';
		#$patient['clinic_id'] = (isset($_POST['clinic_id']))?$_POST['clinic_id']:'';
		$patient['name'] = (isset($_POST['patient_name']))?$_POST['patient_name']:'';
		$patient['image'] = (isset($_POST['patient_image']))?$_POST['patient_image']:'';
		$patient['blood_group'] = (isset($_POST['blood_group']) && !empty($_POST['blood_group']))?$_POST['blood_group']:'';
		$patient['location_id'] = (isset($_POST['locality']) && !empty($_POST['locality']))?$_POST['locality']:0;
		$patient['city_id'] = (isset($_POST['city']) && !empty($_POST['city']))?$_POST['city']:0;
		$patient['address'] = (isset($_POST['address']))?$_POST['address']:'';
		$patient['pin_code'] = (isset($_POST['pincode']))?$_POST['pincode']:'';
		$patient['food_habits'] = (isset($_POST['food_habits']))?$_POST['food_habits']:'';
		$patient['alcohol'] = (isset($_POST['alcohol']))?$_POST['alcohol']:'';
		$patient['smoking'] = (isset($_POST['smoking']))?$_POST['smoking']:'';
		$patient['ciggi_per_day'] = (isset($_POST['no_of_cig']))?intval($_POST['no_of_cig']):0;
		$patient['tobacco_consumption'] = (isset($_POST['tobacco']))?$_POST['tobacco']:'';
		$patient['email'] = (isset($_POST['email']))?$_POST['email']:'';
		$patient['gender'] = (isset($_POST['gender']))?$_POST['gender']:'';
		$patient['other_location'] = (isset($_POST['other_locality']))?$_POST['other_locality']:'';
		$patient['mobile_number'] = (isset($_POST['mobile_number']))?$_POST['mobile_number']:'';

		$patient_id = (isset($_POST['patient_id']))?$_POST['patient_id']:'';
		if(empty($patient_id)){
			$patient_id = $this->patient_model->insert_patient($patient);
		}else{
			$this->patient_model->update_patient($patient,$patient_id);
		}
		#echo $this->patient_model;
		if($patient_id){
			
			$bmi['height_feet'] = (isset($_POST['height_feet']))?$_POST['height_feet']:'';
			$bmi['height_inches'] = (isset($_POST['height_inches']))?$_POST['height_inches']:'';
			$bmi['weight'] = (isset($_POST['weight']))?$_POST['weight']:'';
			$bmi['bmi_value'] = (isset($_POST['bmi_value']))?$_POST['bmi_value']:'';
			$bmi['patient_id'] = $patient_id;
			$bmi['user_id'] = (isset($_POST['user_id']))?$_POST['user_id']:NULL;
			if($bmi['bmi_value'] && $bmi['weight']){
				$patient_bmi = $this->patient_model->insert_patient_bmi($bmi);
			}
			$family_member_name = (isset($_POST['family_member_name']))?$_POST['family_member_name']:'';
			
			if(isset($family_member_name) && is_array($family_member_name) && sizeof($family_member_name)>0){
				foreach($family_member_name as $key=>$val){
					if(is_array($val) && sizeof($val)>0 && !empty($_POST['family_disease'][$key])){
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
			if(isset($disease_from_year) && is_array($disease_from_year) && sizeof($disease_from_year)>0){
				foreach($disease_from_year as $key=>$val){
					if(!empty($val)){
						$patient_past_disease['disease_name'] =  (isset($_POST['disease_name'][$key]))?$_POST['disease_name'][$key]:NULL; 
						$patient_past_disease['disease_from_year'] =  (isset($_POST['disease_from_year'][$key]))?$_POST['disease_from_year'][$key]:NULL; 
						$patient_past_disease['disease_from_month'] =  (isset($_POST['disease_from_month'][$key]))?$_POST['disease_from_month'][$key]:NULL; 
						$patient_past_disease['disease_duration'] =  (isset($_POST['disease_duration'][$key]))?$_POST['disease_duration'][$key]:NULL; 
						$patient_past_disease['disease_details'] =  (isset($_POST['disease_details'][$key]))?$_POST['disease_details'][$key]:NULL; 
						$patient_past_disease['patient_id'] = $patient_id;
						
						if(!empty($_POST['past_disease_id'][$key])){
							$this->patient_model->update_patient_past_disease($_POST['past_disease_id'][$key],$patient_past_disease);
						}else{
							$this->patient_model->insert_patient_past_disease($patient_past_disease);
						}
					}

					#echo $this->patient_model;
				}
			}

			$surgery_name = (isset($_POST['surgery_name']))?$_POST['surgery_name']:NULL;
			if(isset($surgery_name) && is_array($surgery_name) && sizeof($surgery_name)>0){
				foreach($surgery_name as $key=>$val){
					if(!empty($val)){
						$patient_past_surgery['surgery_name'] =  $val;
						$patient_past_surgery['surgery_reason'] =  (isset($_POST['surgery_reason'][$key]))?$_POST['surgery_reason'][$key]:NULL; 
						$patient_past_surgery['surgery_date'] =  (isset($_POST['surgery_date'][$key]))?$_POST['surgery_date'][$key]:NULL; 
						$patient_past_surgery['patient_id'] = $patient_id;
	
						if(!empty($_POST['past_surgery_id'][$key])){
							$this->patient_model->update_patient_past_surgery($_POST['past_surgery_id'][$key],$patient_past_surgery);
						}else{
							$this->patient_model->insert_patient_past_surgery($patient_past_surgery);
						}
					}
					
				}
			}

			$ongoing_medications = (isset($_POST['ongoing_medications']))?$_POST['ongoing_medications']:NULL;	
			if(isset($ongoing_medications) && is_array($ongoing_medications) && sizeof($ongoing_medications)>0){
				foreach($ongoing_medications as $key=>$val){
					if(!empty($val)){
						$patient_medication['medication'] = $val;
						$patient_medication['patient_id'] = $patient_id;
						if(!empty($_POST['ongoing_medications_id'][$key])){
							$this->patient_model->update_patient_medication($_POST['ongoing_medications_id'][$key],$patient_medication);
							#echo $this->patient_model;
						}else{
							$this->patient_model->insert_patient_medication($patient_medication);
							#echo $this->patient_model;
						}
					}
				}
			}

			$allergic = (isset($_POST['allergic']))?$_POST['allergic']:NULL;	
			if(isset($allergic) && is_array($allergic) && sizeof($allergic)>0){
				foreach($allergic as $key=>$val){
					if(!empty($val)){
						$patient_allergic['allergic'] = $val;
						$patient_allergic['allery_type'] = (!empty($_POST['allergic_list'][$key]))?$_POST['allergic_list'][$key]:NULL;
						$patient_allergic['patient_id'] = $patient_id;
						if(!empty($_POST['allergic_id'][$key])){
							$this->patient_model->update_patient_allergic($_POST['allergic_id'][$key],$patient_allergic);
							#echo $this->patient_model;
						}else{
							#print_r($patient_allergic);
							$this->patient_model->insert_patient_allergic($patient_allergic);
							#echo $this->patient_model;
						}
					}
				}
			}
			#echo $this->patient_model;exit;

		}
	}

	function patient_edit($id,$post)
	{
		print_r($id);print_r($post);
	}

	function patient_manage()
	{

		$this->load->model(array('patient_model','clinic_model','page_model'));
		$userid = $this->session->userdata('id');
		$data['name'] = $this->session->userdata('name');
		$data['userdetails'] = $this->user_model->get_all_userdetails($userid);
		$data['doctor_data'] = $this->doctor_model->get_doctor_data($userid);
		
		if(!empty($data['doctor_data']))
		{
			$doctorid = $data['doctor_data']->id;
			$data['doctorid'] = $doctorid;
			$data['clinic_present'] = $this->doctor_model->check_clinic_present($doctorid);
			if($data['clinic_present']){
				$data['clinics'] = $this->clinic_model->getClinic(array('doctor_id'=>$doctorid,'column'=>array('id','name'),'limit'=>100,'idaskey'=>true));
				
			}else{
				redirect('/doctor/dashboard');
			}
		}
		else
		{
			$doctorid = NULL;
			$data['doctorid'] = $doctorid;
			$data['clinic_present'] = NULL;
			redirect('/doctor/dashboard');
		}

		$scharr = array();
		if($this->input->get('page_id')){
			$page_id = $this->input->get('page_id');
		}else{
			$page_id = 1;
		}
		$limit = LIMIT;
		if(sizeof($_GET)>0){
			foreach($_GET as $gKey=>$gVal){
				$data['get_'.$gKey] = $gVal;
			}
		}
		$offset = ($page_id-1)*$limit;

		if($this->input->get('clinic_id')){
			$scharr['clinic_id'] = $this->input->get('clinic_id');
		}
		if($doctorid){
			$scharr['doctor_id'] = $doctorid;
		}
		if($this->input->get('patient_name')){
			$scharr['patient_name'] = $this->input->get('patient_name');
		}
		if($this->input->get('patient_email')){
			$scharr['patient_email'] = $this->input->get('patient_email');
		}
		$scharr['limit'] = $limit;
		$scharr['offset'] = $offset;
		$data['patient_data'] = $this->patient_model->get_patient_list($scharr);
		
		$patient_count = $this->patient_model->row_count;
		$this->page_model->total = $patient_count;
		$this->page_model->page = $page_id;
		$this->page_model->limit = $limit;

		unset($scharr['doctor_id'],$scharr['offset'],$scharr['limit']);
		$request_str = http_build_query($scharr);
		$this->page_model->url = BASE_URL."doctor/patient_manage?page_id={page}".((empty($request_str))?'':'&'.$request_str);
		$data['limit'] = $limit;
		$data['offset'] = ($page_id-1)*$limit;
		$data['total'] = $patient_count;
		$data['pagination'] = $this->page_model->render();

		$this->load->view('doctor_manage_patient', isset($data) ? $data : NULL);
	}

	function deleteclinic($clinicid = NULL)
	{
		$doc_id = $this->doctor_model->get_doctor_id($this->session->userdata('id'));
		//print_r($doc_id);
		if($this->session->userdata('id') == $doc_id->user_id)
		{
			$this->doctor_model->delete_clinic($clinicid, $doc_id->id);
		}
	}
	
	function editclinic($clinicid = NULL)
	{
		$userid = $this->session->userdata('id');
		if($this->doctor_model->check_sor_eligibility($userid))
		{
			$data['sor_eligible'] = '1';
		}
		$this->load->library('form_validation');
		
		$doc_id = $this->doctor_model->get_doctor_id($userid);
		$clinic_exist = $this->doctor_model->check_clinic_exist($doc_id->id, $clinicid);
		if($clinic_exist === TRUE)
		{
			$data['name'] = $this->session->userdata('name');
			$data['userdetails'] = $this->user_model->get_all_userdetails($userid);
			
			$data['doctor_data'] = $this->doctor_model->get_doctor_data($userid);
			$data['cities'] = $this->location_model->get_all_cities();
			$data['editclinic'] = 'editclinic';
			$data['clinic_details'] = $this->doctor_model->get_clinic_details($clinicid, $doc_id->id);
			
			if($data['clinic_details']->location_id > 0)
			{
				$localities = $this->location_model->get_locality($data['clinic_details']->city_id);
				$data['localities'] = $localities;
			}
			else
			{
				$data['other_locality'] = $data['clinic_details']->other_location;
			}
			
			// Timings conversion begins
			$timings = $data['clinic_details']->timings;
			$data['clinic_timings'] = json_decode($timings,true);
			
			if(isset($_GET['t']))
			{
				print_r($data);exit;
			}
			// Timings conversion ends
			
			if(!empty($data['doctor_data']))
			{
				$doctorid = $data['doctor_data']->id;
				$data['doctorid'] = $doctorid;
				$data['clinic_present'] = $this->doctor_model->check_clinic_present($doctorid);
			}
			else
			{
				$doctorid = NULL;
				$data['doctorid'] = $doctorid;
				$data['clinic_present'] = NULL;
			}
		
		
			$sl_step2_submit = $this->input->post('sl_step2');
			if(isset($sl_step2_submit) && $sl_step2_submit == 'sl_step2')
			{
				$config = array(
					array(
						'field'=> 'clinic_name',
						'label'=> 'Clinic Name',
						'rules'=> 'required|trim'
					),
					array(
						'field'=> 'clinic_address',
						'label'=> 'Clinic Address',
						'rules'=> 'required|trim'
					),
					array(
						'field'=> 'city',
						'label'=> 'City',
						'rules'=> 'required|trim'
					),
					array(
						'field'=> 'locality',
						'label'=> 'Locality',
						'rules'=> 'trim|callback_locality_check'
					),
					array(
						'field'=> 'pincode',
						'label'=> 'Pincode',
						'rules'=> 'required|trim|numeric'
					),
					array(
						'field'=> 'clinic_number',
						'label'=> 'Clinic Number',
						'rules'=> 'required|trim|numeric|callback_clinic_number_validation'
					),
					array(
						'field'=> 'clinic_number_code',
						'label'=> 'Clinic Code',
						'rules'=> 'trim|numeric'
					),
					array(
						'field'=> 'days',
						'label'=> 'Appointment Days',
						'rules'=> 'required'
					),
					array(
						'field'=> 'consult_fee',
						'label'=> 'Consultation Fee',
						'rules'=> 'trim'
					),
					array(
						'field'=> 'avg_patient_duration',
						'label'=> 'Average duration per patient',
						'rules'=> 'required|trim|integer'
					)
				);
				$this->form_validation->set_rules($config);
				if($this->form_validation->run() == FALSE)
				{
					// Invalid form details
				}
				else
				{
					// Merge clinic number
					if(!empty($_POST['clinic_number_code']))
					$_POST['clinic_number'] = $_POST['clinic_number_code'].'-'.$_POST['clinic_number'];
					else
					$_POST['clinic_number'] = $_POST['clinic_number'];
					// Update details in clinic table
					$clinic_id = $this->doctor_model->update_clinic($userid, $doctorid, $clinicid, $this->input->post());
					
					redirect('/doctor/manageclinic');
				}
				
			}
		
			$this->load->view('smartlisting_step2', isset($data) ? $data : NULL);
		}
		else
		{
			redirect('/doctor');
		}
	}

	function send_verification_sms()
	{
		$mobile = $this->input->post('mob');

		// Check if the mobile number is a number and it is of length 10
		if(is_numeric($mobile) && strlen($mobile) == 10)
		{
			// Check if the mobile number is already present in the db
			$check = $this->user_model->check_mobno_exists($mobile);
			if($check === TRUE)
			{
				echo "Mobile number already exists";
			}
			else
			{
//				$this->load->model('sms_model');
//				echo $code = $this->sms_model->send_verification_sms($mobile);
//				$this->session->set_userdata('verification_code', $code);
//				$this->session->set_userdata('code_verified', '0');
//				echo "success";
//				
				// Generate a random 4 digit number
				$code = rand(1000, 9999);
				$this->session->set_userdata('verification_code', $code);
				$this->session->set_userdata('code_verified', '0');
				$this->load->model('sendsms_model');
				$this->sendsms_model->send_verification_sms_code($mobile, $code);
				echo "success";
				//echo $message = urlencode("Your Account Verification code is ".$code."");	
			}
		}
		else
		{
			echo "Not a valid mobile number";
		}
	}

	function check_verification_code()
	{
		$code = $this->input->post('code');
		// Check if the verification code is a number and it has only 4 didgits
		if(is_numeric($code) && strlen($code) == 4)
		{
			$actual_code = $this->session->userdata('verification_code');
			// Comapare the code entered by the user with the code present in the session
			if($actual_code == $code)
			{
				$this->session->set_userdata('code_verified', '1');
				echo 'success';
			}
			else
			{
				echo "Invalid Verification code";
			}
		}
		else
		{
			echo "Invalid Verification code";
		}
	}
	
	function degree_check($degree)
	{
		$val_check = 0;
		foreach($degree as $row)
		{
			if(!empty($row))
			$val_check = 1;
		}
		if($val_check == 0)
		{
			$this->form_validation->set_message('degree_check', 'Please select a degree');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	
	function speciality_check($speciality)
	{
		$val_check = 0;
		foreach($speciality as $row)
		{
			if(!empty($row))
			$val_check = 1;
		}
		if($val_check == 0)
		{
			$this->form_validation->set_message('speciality_check', 'Please select a speciality');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}

	function packages()
	{
		$userid = $this->session->userdata('id');
		$data['name'] = $this->session->userdata('name');
		$data['userdetails'] = $this->user_model->get_all_userdetails($userid);
		$data['doctor_data'] = $this->doctor_model->get_doctor_data($userid);
		$data['package_details'] = $this->doctor_model->get_doctor_package_details($userid);
		
		if(!empty($data['doctor_data']))
		{
			$doctorid = $data['doctor_data']->id;
			$data['doctorid'] = $doctorid;
			$data['clinic_present'] = $this->doctor_model->check_clinic_present($doctorid);
			$data['clinics'] = $this->doctor_model->get_all_clinics($doctorid);
			//print_r($data['clinics']);
		}
		else
		{
			$doctorid = NULL;
			$data['doctorid'] = $doctorid;
			$data['clinic_present'] = NULL;
		}
		
		$this->load->view('packages', isset($data) ? $data : NULL);
	}
	
	function paymentsuccess()
	{
		$userid = $this->session->userdata('id');
		$data['name'] = $this->session->userdata('name');
		$data['userdetails'] = $this->user_model->get_all_userdetails($userid);
		
		$data['doctor_data'] = $this->doctor_model->get_doctor_data($userid);
		
		if(!empty($data['doctor_data']))
		{
			$doctorid = $data['doctor_data']->id;
			$data['doctorid'] = $doctorid;
			$data['clinic_present'] = $this->doctor_model->check_clinic_present($doctorid);
			$data['clinics'] = $this->doctor_model->get_all_clinics($doctorid);
			//print_r($data['clinics']);
		}
		else
		{
			$doctorid = NULL;
			$data['doctorid'] = $doctorid;
			$data['clinic_present'] = NULL;
		}
		
		$this->load->view('transaction_success', isset($data) ? $data : NULL);
	}
	
	function paymentfailure()
	{
		$userid = $this->session->userdata('id');
		$data['name'] = $this->session->userdata('name');
		$data['userdetails'] = $this->user_model->get_all_userdetails($userid);
		
		$data['doctor_data'] = $this->doctor_model->get_doctor_data($userid);
		
		if(!empty($data['doctor_data']))
		{
			$doctorid = $data['doctor_data']->id;
			$data['doctorid'] = $doctorid;
			$data['clinic_present'] = $this->doctor_model->check_clinic_present($doctorid);
			$data['clinics'] = $this->doctor_model->get_all_clinics($doctorid);
			//print_r($data['clinics']);
		}
		else
		{
			$doctorid = NULL;
			$data['doctorid'] = $doctorid;
			$data['clinic_present'] = NULL;
		}
		
		$this->load->view('transaction_failure', isset($data) ? $data : NULL);
	}
	
	function clinic_number_validation($clinicnumber)
	{
		$code = $this->input->post('clinic_number_code');
		$numlen1 = strlen($clinicnumber);
		$numlen2 = strlen($code);
		$total_length = $numlen1+$numlen2;
		if($total_length < 10)
		{
			$this->form_validation->set_message('clinic_number_validation', 'Clinic Number should be minimum 10 characters in length');
			return FALSE;
		}
		elseif($total_length > 12)
		{
			$this->form_validation->set_message('clinic_number_validation', 'Clinic Number can contain a maximum of 12 characters only');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}

	function onlinereputation()
	{
		$userid = $this->session->userdata('id');
		$data['name'] = $this->session->userdata('name');
		$data['userdetails'] = $this->user_model->get_all_userdetails($userid);
		$data['doctor_data'] = $this->doctor_model->get_doctor_data($userid);
		
		if(!empty($data['doctor_data']))
		{
			$doctorid = $data['doctor_data']->id;
			$data['doctorid'] = $doctorid;
			$data['clinic_present'] = $this->doctor_model->check_clinic_present($doctorid);
			$data['clinics'] = $this->doctor_model->get_all_clinics($doctorid);
		}
		else
		{
			$doctorid = NULL;
			$data['doctorid'] = $doctorid;
			$data['clinic_present'] = NULL;
		}
		$eligible = $this->doctor_model->check_sor_eligibility($userid);
		if(($eligible === TRUE) && $data['clinic_present'] != NULL)
		{	
			$this->load->model(array('doctor_details_model','common_model'));

			$session_userid = $this->session->userdata('id');
			$userData       = $this->doctor_model->getDoctor(array('user_id'=>$session_userid,'column'   =>array('id','name')));
			$doctor_id = $userData[0]['id'];
			if(!$doctor_id){redirect('/doctor/packages');}
			$data['doctor_detail'] = $this->doctor_model->getDoctorDetail(array('doctor_id'=>$doctor_id));

			$data['services'] = $this->doctor_details_model->getServices(array());
			$data['specializations'] = $this->common_model->getSpeciality(array('column'=>array('id','name')));

			$data['qualification'] = $this->doctor_details_model->getQualification(array());
			$data['college'] = $this->doctor_details_model->getCollege(array());
			$data['city'] = $this->common_model->getCity(array('column'=>array('id','name'),'orderby'=>'name asc'));
			$data['from_year'] = range(1980,2014);
			$data['to_year'] = range(1980,2014);

			$data['membership'] = $this->doctor_details_model->getMembership(array());
			$data['council'] = $this->doctor_details_model->getCouncil(array());
			$data['doctor_summary'] = $this->doctor_model->getDoctor(array('limit' =>1,'id'    =>$doctor_id,'column'=>array('summary')));
			if(is_array($data['doctor_summary']) && sizeof($data['doctor_summary']) > 0)
			{
				$data['doctor_summary'] = $data['doctor_summary'][0]['summary'];
			}
			else
			{
				$data['doctor_summary'] = '';
			}

			$data['patient_numbers'] = $this->doctor_details_model->getPatientNumbers(array('limit'=>20,'doctor_id'=>$doctor_id,'orderby'  =>'id asc'));
			$current_package = $this->doctor_model->get_all_doctor_packages($userid);
			if($current_package)
			{
				$data['current_packages'] = $current_package;
			}

			
			$data['doctor_id'] = $doctor_id;
			$this->load->view('online_reputation', $data);
		}
		else
		{
			if($data['clinic_present'] == NULL)
			{
				redirect('/doctor/smartlisting');
			}
			else
			{
				redirect('/doctor/packages');
			}
		}
	}

	function post_onlinereputation()
	{
		$this->load->model('doctor_details_model');
		$session_userid = $this->session->userdata('id');
		$userData       = $this->doctor_model->getDoctor(array('user_id'=>$session_userid,'column'   =>array('id','name')));
		$doctor_id      = $userData[0]['id'];

		$docDetailArray = array();
		if(is_array($this->post['services']))
		{
			foreach($this->post['services'] as $key=>$val)
			{
				if(!empty($val))
				{
					$docDetailArray[] = array(
					'doctor_id'   =>$doctor_id,
					'attribute'   =>'Services',
					'description1'=>$val,
					'sort'        =>$key + 1
					);
				}

			}
		}
		
		if(is_array($this->post['specializations']))
		{
			foreach($this->post['specializations'] as $key=>$val)
			{
				if(!empty($val))
				{
					$docDetailArray[] = array(
					'doctor_id'   =>$doctor_id,
					'attribute'   =>'Specializations',
					'description1'=>$val,
					'sort'        =>$key + 1
					);
				}
			}
		}
		if(is_array($this->post['membership']))
		{
			foreach($this->post['membership'] as $key=>$val)
			{
				if(!empty($val))
				{
					$docDetailArray[] = array(
					'doctor_id'   =>$doctor_id,
					'attribute'   =>'Membership',
					'description1'=>$val,
					'sort'        =>$key + 1
					);
				}
			}
		}

		if(is_array($this->post['qualifications']))
		{
			foreach($this->post['qualifications'] as $key=>$val)
			{
				if(!empty($val))
				{
					$docDetailArray[] = array(
					'doctor_id'   =>$doctor_id,
					'attribute'   =>'Qualifications',
					'description1'=>$val,
					'sort'        =>$key + 1
					);
				}
			}
		}
		if(is_array($this->post['paperspublished']))
		{
			foreach($this->post['paperspublished'] as $key=>$val)
			{
				if(!empty($val))
				{
					$docDetailArray[] = array(
					'doctor_id'   =>$doctor_id,
					'attribute'   =>'PapersPublished',
					'description1'=>$val,
					'sort'        =>$key + 1
					);
				}
			}
		}
		if(is_array($this->post['education_qualification']))
		{
			foreach($this->post['education_qualification'] as $key=>$val)
			{
				if(!empty($val))
				{
					$from_year = !empty($this->post['education_from_year'][$key])?$this->post['education_from_year'][$key]:NULL;
					$docDetailArray[] = array(
					'doctor_id'   =>$doctor_id,
						'attribute'   =>'Education',
						'description1'=>$val,
						'description2'=>$this->post['education_college'][$key],
						'from_year'   =>$from_year,
						'sort'        =>$key + 1
					);
				}
			}
		}
		if(is_array($this->post['registrations_council']))
		{
			foreach($this->post['registrations_council'] as $key=>$val)
			{
				if(!empty($val))
				{
					$from_year = !empty($this->post['registrations_year'][$key])?$this->post['registrations_year'][$key]:NULL;
					$docDetailArray[] = array(
						'doctor_id'   =>$doctor_id,
						'attribute'   =>'Registrations',
						'description1'=>$this->post['registrations_no'][$key],
						'description2'=>$val,
						'from_year'   =>$from_year,
						'sort'        =>$key + 1
					);
				}
			}
		}

		if(is_array($this->post['experience_role']))
		{
			foreach($this->post['experience_role'] as $key=>$val)
			{
				if(!empty($val))
				{
					$from_year = !empty($this->post['experience_from_year'][$key])?$this->post['experience_from_year'][$key]:NULL;
					$to_year = !empty($this->post['experience_to_year'][$key])?$this->post['experience_to_year'][$key]:NULL;
					$docDetailArray[] = array(
						'doctor_id'   =>$doctor_id,
						'attribute'   =>'Experience',
						'description1'=>$val,
						'description2'=>$this->post['experience_hospital'][$key],
						'description3'=>$this->post['experience_city'][$key],
						'from_year'   =>$from_year,
						'to_year'     =>$to_year,
						'sort'        =>$key + 1
					);
				}
			}
		}
		if(is_array($this->post['awardsandrecognitions_award']))
		{
			foreach($this->post['awardsandrecognitions_award'] as $key=>$val)
			{
				if(!empty($val))
				{
					$from_year = !empty($this->post['awardsandrecognitions_from_year'][$key])?$this->post['awardsandrecognitions_from_year'][$key]:NULL;
					$docDetailArray[] = array(
						'doctor_id'   =>$doctor_id,
						'attribute'   =>'AwardsAndRecognitions',
						'description1'=>$val,
						'from_year'   =>$from_year,
						'sort'        =>$key + 1
					);
				}
			}
		}
		$doc_del_rs = $this->doctor_model->deleteDoctorDetailById(array('doctor_id'=>$doctor_id)); # this will delete doctor detail for a doctor_id
		if(is_array($docDetailArray) && sizeof($docDetailArray) > 0)
		{
			#print_r($docDetailArray);
			foreach($docDetailArray as $key=>$val)
			{	#print_r($val);
				$insert_ids[] = $this->doctor_model->insertDoctorSingleDetail($val);
			}
		}
		if(!empty($this->post['doctor_summary']) && !empty($doctor_id))
		{
			$this->doctor_model->updateDoctor(array(
			'set'      =>array(
				'summary'=>$this->post['doctor_summary']),
				'where'=>array('id'=>$doctor_id))
			);
		}
		foreach($this->post['patient_name'] as $key=>$val)
		{
			if(!empty($val) && $this->post['patient_number'][$key])
			{
				$patients[$key] = array(
				'doctor_id'     =>$doctor_id,
				'patient_name'  =>$val,
				'patient_number'=>$this->post['patient_number'][$key]
				);
			}
		}
		$patient_del_rs = $this->doctor_model->deletePatientNumbersByDoctorId(array('doctor_id'=>$doctor_id)); # this will delete patient numbers for a doctor_id
		if(isset($patients) && is_array($patients) && sizeof($patients) > 0)
		{
			$res = $this->doctor_model->insertPatientNumbersByBatch($patients);
			//send mail
			#$this->load->model('mail_model');
			#$this->mail_model->patient_reviews_update_notification($userData);
			
		}
		$redirect = $this->session->flashdata('adminchanges');
		if(!empty($redirect))
		{
			redirect($_SERVER['HTTP_REFERER']);
		}
		//return false;
	}
	
	function deleteclinicphoto()
	{
		//print_r($_POST);
		$this->doctor_model->deleteclinicphoto($_POST['doctorid'],$_POST['clinicid'],$_POST['photoid']);
	}

	function changepassword()
	{
		$userid = $this->session->userdata('id');
		$data['name'] = $this->session->userdata('name');
		$data['userdetails'] = $this->user_model->get_all_userdetails($userid);
		
		$data['doctor_data'] = $this->doctor_model->get_doctor_data($userid);
		
		if(!empty($data['doctor_data']))
		{
			$doctorid = $data['doctor_data']->id;
			$data['doctorid'] = $doctorid;
			$data['clinic_present'] = $this->doctor_model->check_clinic_present($doctorid);
			$data['clinics'] = $this->doctor_model->get_all_clinics($doctorid);
			//print_r($data['clinics']);
		}
		else
		{
			$doctorid = NULL;
			$data['doctorid'] = $doctorid;
			$data['clinic_present'] = NULL;
		}
		$this->load->library('form_validation');
		
		if(isset($_POST['submit_x']))
		{
			//print_r($_POST);
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
			if($this->form_validation->run() == FALSE)
			{
				// Invalid form details
			}
			else
			{
				//Change password
				$check = $this->user_model->change_password($userid,$_POST['newpass']);
				//send mailer
				$this->load->model('mail_model');
				$this->mail_model->changepasswordmail($data['userdetails']->email_id, $data['userdetails']->name);
				redirect('/doctor');
			}
		}
		
		$this->load->view('changepassword', isset($data) ? $data : NULL);
	}
	
	function check_current_password($pass)
	{
		$userid = $this->session->userdata('id');
		$check = $this->user_model->check_password($userid,$pass);
		var_dump($check);
		if($check === FALSE)
		{
			$this->form_validation->set_message('function patient_manage()
	{check_current_password', 'You have entered an incorrect password');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}

	function mailtest()
	{
		//$this->mail_model->welcome_patient('techteam@bookdrappointment.com', 'Naved');
	}
	
	function scheduler()
	{
		
		$userid = $this->session->userdata('id');
		$data['name'] = $this->session->userdata('name');
		$data['userdetails'] = $this->user_model->get_all_userdetails($userid);
		$data['doctor_data'] = $this->doctor_model->get_doctor_data($userid);
		if(!empty($data['doctor_data']))
		{
			$doctorid = $data['doctor_data']->id;
			$data['doctorid'] = $doctorid;
			$data['clinic_present'] = $this->doctor_model->check_clinic_present($doctorid);
			
			$data['clinics'] = $this->doctor_model->get_all_clinics_json($doctorid); // get the clinics in order of being added by the doc(currently alphabetical)
			$data['clinics_d'] = $this->doctor_model->get_all_clinics_json($doctorid,array('is_as_key'=>true)); // get the clinics in order of being added by the doc(currently alphabetical)
			if($this->session->userdata('scheduler_clinic_id'))
			{
				$data['clniic_details']	=	$data['clinics_d'][$this->session->userdata('scheduler_clinic_id')];
			}
			else
			{
				$data['clniic_details']	=	$data['clinics'][0];
			}
			

			$patients = $this->doctor_model->get_patients_by_id($doctorid);
			$data['patients'] = array();
			if($patients){
				foreach($patients as $p){
					$tmp = array(
						'value'=>$p['id'], 
						'label'=>$p['name']." ".$p['mobile_number'],
						'email'=>$p['email'], 
						'address'=>$p['address'], 
						'dob'=>date("d-m-Y",strtotime($p['dob'])), 
						'gender'=>$p['gender'], 
						);
	
					$data['patients'][]= $tmp;
				}
			}
//			echo "<pre>".print_r([0]['duration'],true);exit;
			$data['patients'] = preg_replace('/"([a-zA-Z]+[a-zA-Z0-9]*)":/','$1:',json_encode($data['patients']));
			if($this->session->userdata('scheduler_clinic_id') != false)
				$data['scheduler_clinic_id'] = $this->session->userdata('scheduler_clinic_id');
			else
				$data['scheduler_clinic_id'] = 0;
			if($this->session->userdata('scheduler_view') != false)
				$data['scheduler_view'] = $this->session->userdata('scheduler_view');
			else
				$data['scheduler_view'] = 'agendaDay';
				
			if($this->session->userdata('scheduler_clinic_duration') != false){
				$data['scheduler_clinic_duration'] = "00:".$this->session->userdata('scheduler_clinic_duration').":00";
				$data['slots'] = $this->session->userdata('scheduler_clinic_duration');
			}
			else{
				if($data['clinics']){
					$data['scheduler_clinic_duration'] = "00:".$data['clinics'][0]['duration'].":00";
					$data['slots'] = $data['clinics'][0]['duration'];
				}
				else{
					$data['scheduler_clinic_duration'] = "00:20:00";
					$data['slots'] = 20;
				}	
			}	
		$data['clinics'] = json_encode($data['clinics']);
		}
		else
		{
			redirect('/doctor/dashboard');
			$doctorid = NULL;
			$data['doctorid'] = $doctorid;
			$data['clinic_present'] = NULL;
		}
		$this->load->view('doctor_scheduler', isset($data) ? $data : NULL);
		
		
	}

	function freetrial()
	{
		$userid = $this->session->userdata('id');
		$data['name'] = $this->session->userdata('name');
		$data['userdetails'] = $this->user_model->get_all_userdetails($userid);
		$data['doctor_data'] = $this->doctor_model->get_doctor_data($userid);
		$data['package_details'] = $this->doctor_model->get_doctor_package_details($userid);
		
		if(!empty($data['doctor_data']))
		{
			$doctorid = $data['doctor_data']->id;
			$data['doctorid'] = $doctorid;
			$data['clinic_present'] = $this->doctor_model->check_clinic_present($doctorid);
			$data['clinics'] = $this->doctor_model->get_all_clinics($doctorid);
			//print_r($data['clinics']);
		}
		else
		{
			$doctorid = NULL;
			$data['doctorid'] = $doctorid;
			$data['clinic_present'] = NULL;
		}
		
		// Check free trial eligibility
		$check_freetrial_eligible = $this->doctor_model->check_freetrial_eligible($doctorid, $userid);
		if($check_freetrial_eligible == 0)
		{
			// Check if doctor approved
			$doctor_status = $data['doctor_data']->status;
			// Insert free trial
			$this->doctor_model->insert_free_trial($doctorid, $userid, $doctor_status == 1 ? '1' : '0');
			$this->mail_model->free_trial($data['userdetails']->email_id, $data['userdetails']->name,date('dS M Y', strtotime("+15 days")));
			$this->sendsms_model->free_trial($data['userdetails']->contact_number,array('date'=>date('dS M Y', strtotime("+15 days"))));
			
			
		}
		redirect('/doctor/smartlisting');
	}
}