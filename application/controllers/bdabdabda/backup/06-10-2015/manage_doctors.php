<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Manage_Doctors extends CI_Controller
{
    public $data = array();
    public $perms = array();
    private $current_tab = 'doctor';
    
    function __construct()
    {
        parent::__construct();
        #$this->output->enable_profiler(TRUE);
        $this->load->model(array(
            'admin/admindoctor_model',
            'doctor_model',
            'location_model',
            'page_model',
            'user_model',
            'doctor_details_model',
            'common_model'
        ));
        $this->load->library("pagination");
        $this->load->helper("url");
        
				$this->perms		=	$this->session->userdata('allowed_perms'); 
				$admin_home_url	=	$this->session->userdata('admin_home_url');
        if ($this->perms[ADMIN_DOCTORS]['view'] == 0) {
            redirect(($admin_home_url)?$admin_home_url:'/bdabdabda');
            exit();
        }
        
    }
    
    function index()
    {
        $this->load->model('admin/adminmasters_model');
        $this->data['current_tab'] = $this->current_tab;
        $this->data                = array();
        $this->search();
        $this->load->model('location_model');
        $this->data['cities']        = $this->location_model->get_name_cities();
        $this->data['locality']      = $this->adminmasters_model->get_active_locality_master();
        $this->data['specialities']  = $this->admindoctor_model->get_specialities_name();
        $this->data['qualification'] = $this->admindoctor_model->get_qualification_name();
        if (isset($this->data['results'])) {
            foreach ($this->data['results'] as $key => $val) {
                $speciality = explode(",", $val->speciality);
                $val->spec  = '';
                foreach ($speciality as $s_v) {
                    if (isset($this->data['specialities'][$s_v]['name'])) {
                        $val->spec .= $this->data['specialities'][$s_v]['name'] . ", ";
                    }
                }
                $val->spec = rtrim($val->spec, ' ,');
                
                $qualification = explode(",", $val->qualification);
                $val->qual     = '';
                foreach ($qualification as $q_v) {
                    if (isset($this->data['qualification'][$q_v]['name'])) {
                        $val->qual .= $this->data['qualification'][$q_v]['name'] . ", ";
                    }
                }
                $val->qual                   = rtrim($val->qual, ' ,');
                $this->data['results'][$key] = $val;
            }
        }
        $this->data['perms'] = $this->perms;
				$this->data['doctor_status']	=	 array('1'=>'doctor_approve','-1'=>'doctor_disapprove','0'=>'doctor_pending','-2'=>'doctor_delete','3'=>'doctor_duplicate'); 
				$this->data['doctor_display_status']	=	 array('doctor_approve'=>'Approved','doctor_disapprove'=>'Disapproved','doctor_pending'=>'Pending','doctor_delete'=>'Deleted','doctor_duplicate'=>'Duplicate'); 
				#print_r($this->data);exit;
        $this->load->view('admin/doctor_view', $this->data);
    }
    
    function search()
    {
        $this->data['current_tab'] = $this->current_tab;
        $config['base_url']        = BASE_URL . 'bdabdabda/manage_doctors?';
        $config['per_page']        = 10;
        if (count($_GET) > 1) {
            $config['base_url'] = $config['base_url'] . http_build_query($_GET, '', '&');
        }
        
        $page = !empty($_GET['start']) ? $_GET['start'] : 0;
        
        $scharr = array(
            'limit' => $config["per_page"],
            'offset' => $page
            // 'orderby' => 'doc.updated_on desc'
        );
        if ($this->input->get('id')) {
            $scharr['id'] = $this->input->get('id');
        }
        if ($this->input->get('doctor_name')) {
            $scharr['doctor_name'] = $this->input->get('doctor_name');
        }
        if ($this->input->get('specialities')) {
            $scharr['specialities'] = $this->input->get('specialities');
        }
        if ($this->input->get('locality')) {
            $scharr['locality'] = $this->input->get('locality');
        }
        if ($this->input->get('city')) {
            $scharr['city'] = $this->input->get('city');
        }
        if (strlen($this->input->get('status')) > 0) {
            $scharr['status'] = $this->input->get('status');
        }
        if (strlen($this->input->get('health_utsav')) > 0) {
            $scharr['health_utsav'] = $this->input->get('health_utsav');
        }				
				
        if (strlen($this->input->get('sort_by')) > 0) {
            $scharr['sort_by'] = $this->input->get('sort_by');
        }
        if (strlen($this->input->get('asc_desc')) > 0) {
            $scharr['asc_desc'] = $this->input->get('asc_desc');
        }
        
        $this->data['results'] = $this->admindoctor_model->get_doctors($scharr);
        $config['total_rows']  = $this->admindoctor_model->row_count;
        
        
        unset($scharr['offset'], $scharr['limit'], $scharr['orderby']);
        $request_str = http_build_query($scharr);
        foreach ($scharr as $scKey => $scVal) {
            $this->data[$scKey] = $scVal;
        }
        $this->data['cur_url'] = $_SERVER['REQUEST_URI'];
        $this->pagination->initialize($config);
    }
    
    function post_doctor_extra_details($doctor_id = NULL)
    {
        if ($doctor_id == NULL) {
            redirect('/bdabdabda/mamanage_doctors');
            exit;
        } else {
            $this->load->model('doctor_details_model');
            $docDetailArray = array();
            if (isset($_POST['services']) && is_array($_POST['services']) && sizeof($_POST['services']) > 0) {
                foreach ($_POST['services'] as $key => $val) {
                    if (!empty($val)) {
                        $docDetailArray[] = array(
                            'doctor_id' => $doctor_id,
                            'attribute' => 'Services',
                            'description1' => $val,
                            'sort' => $key + 1
                        );
                    }
                    
                }
            }
            
            if (isset($_POST['specializations']) && is_array($_POST['specializations']) && sizeof($_POST['specializations']) > 0) {
                foreach ($_POST['specializations'] as $key => $val) {
                    if (!empty($val)) {
                        $docDetailArray[] = array(
                            'doctor_id' => $doctor_id,
                            'attribute' => 'Specializations',
                            'description1' => $val,
                            'sort' => $key + 1
                        );
                    }
                }
            }
            
            if (isset($_POST['membership']) && is_array($_POST['membership']) && sizeof($_POST['membership']) > 0) {
                foreach ($_POST['membership'] as $key => $val) {
                    if (!empty($val)) {
                        $docDetailArray[] = array(
                            'doctor_id' => $doctor_id,
                            'attribute' => 'Membership',
                            'description1' => $val,
                            'sort' => $key + 1
                        );
                    }
                }
            }
            
            if (isset($_POST['qualifications']) && is_array($_POST['qualifications']) && sizeof($_POST['qualifications']) > 0) {
                foreach ($_POST['qualifications'] as $key => $val) {
                    if (!empty($val)) {
                        $docDetailArray[] = array(
                            'doctor_id' => $doctor_id,
                            'attribute' => 'Qualifications',
                            'description1' => $val,
                            'sort' => $key + 1
                        );
                    }
                }
            }
            
            if (isset($_POST['paperspublished']) && is_array($_POST['paperspublished']) && sizeof($_POST['paperspublished']) > 0) {
                foreach ($_POST['paperspublished'] as $key => $val) {
                    if (!empty($val)) {
                        $docDetailArray[] = array(
                            'doctor_id' => $doctor_id,
                            'attribute' => 'PapersPublished',
                            'description1' => $val,
                            'sort' => $key + 1
                        );
                    }
                }
            }
            
            if (isset($_POST['education_qualification']) && is_array($_POST['education_qualification']) && sizeof($_POST['education_qualification']) > 0) {
                foreach ($_POST['education_qualification'] as $key => $val) {
                    if (!empty($val)) {
                        $from_year        = !empty($_POST['education_from_year'][$key]) ? $_POST['education_from_year'][$key] : NULL;
                        $docDetailArray[] = array(
                            'doctor_id' => $doctor_id,
                            'attribute' => 'Education',
                            'description1' => $val,
                            'description2' => $_POST['education_college'][$key],
                            'from_year' => $from_year,
                            'sort' => $key + 1
                        );
                    }
                }
            }
            
            if (isset($_POST['registrations_council']) && is_array($_POST['registrations_council']) && sizeof($_POST['registrations_council']) > 0) {
                foreach ($_POST['registrations_council'] as $key => $val) {
                    if (!empty($val)) {
                        $from_year        = !empty($_POST['registrations_year'][$key]) ? $_POST['registrations_year'][$key] : NULL;
                        $docDetailArray[] = array(
                            'doctor_id' => $doctor_id,
                            'attribute' => 'Registrations',
                            'description1' => $_POST['registrations_no'][$key],
                            'description2' => $val,
                            'from_year' => $from_year,
                            'sort' => $key + 1
                        );
                    }
                }
            }
            
            if (isset($_POST['experience_role']) && is_array($_POST['experience_role']) && sizeof($_POST['experience_role']) > 0) {
                foreach ($_POST['experience_role'] as $key => $val) {
                    if (!empty($val)) {
                        $from_year        = !empty($_POST['experience_from_year'][$key]) ? $_POST['experience_from_year'][$key] : NULL;
                        $to_year          = !empty($_POST['experience_to_year'][$key]) ? $_POST['experience_to_year'][$key] : NULL;
                        $docDetailArray[] = array(
                            'doctor_id' => $doctor_id,
                            'attribute' => 'Experience',
                            'description1' => $val,
                            'description2' => $_POST['experience_hospital'][$key],
                            'description3' => $_POST['experience_city'][$key],
                            'from_year' => $from_year,
                            'to_year' => $to_year,
                            'sort' => $key + 1
                        );
                    }
                }
            }
            
            if (isset($_POST['awardsandrecognitions_award']) && is_array($_POST['awardsandrecognitions_award']) && sizeof($_POST['awardsandrecognitions_award']) > 0) {
                foreach ($_POST['awardsandrecognitions_award'] as $key => $val) {
                    if (!empty($val)) {
                        $from_year        = !empty($_POST['awardsandrecognitions_from_year'][$key]) ? $_POST['awardsandrecognitions_from_year'][$key] : NULL;
                        $docDetailArray[] = array(
                            'doctor_id' => $doctor_id,
                            'attribute' => 'AwardsAndRecognitions',
                            'description1' => $val,
                            'from_year' => $from_year,
                            'sort' => $key + 1
                        );
                    }
                }
            }
            
            $doc_del_rs = $this->doctor_model->deleteDoctorDetailById(array(
                'doctor_id' => $doctor_id
            )); # this will delete doctor detail for a doctor_id
            if (is_array($docDetailArray) && sizeof($docDetailArray) > 0) {
                foreach ($docDetailArray as $key => $val) {
                    $insert_ids[] = $this->doctor_model->insertDoctorSingleDetail($val);
                }
            }
            
            if (!empty($_POST['doctor_summary']) && !empty($doctor_id)) {
                $this->doctor_model->updateDoctor(array(
                    'set' => array(
                        'summary' => $_POST['doctor_summary']
                    ),
                    'where' => array(
                        'id' => $doctor_id
                    )
                ));
            }
            
            foreach ($_POST['patient_name'] as $key => $val) {
                if (!empty($val) && $_POST['patient_number'][$key]) {
                    $patients[$key] = array(
                        'doctor_id' => $doctor_id,
                        'patient_name' => $val,
                        'patient_number' => $_POST['patient_number'][$key]
                    );
                }
            }
            
            $patient_del_rs = $this->doctor_model->deletePatientNumbersByDoctorId(array(
                'doctor_id' => $doctor_id
            )); # this will delete patient numbers for a doctor_id
            if (isset($patients) && is_array($patients) && sizeof($patients) > 0) {
                $res = $this->doctor_model->insertPatientNumbersByBatch($patients);
            }
            
            redirect('/bdabdabda/manage_doctors/viewprofile/' . $doctor_id);
        }
    }
    
    function viewprofile($doctor_id = NULL)
    {
        $data['current_tab'] = $this->current_tab;
        
        if ($doctor_id == NULL) {
            redirect('/bdabdabda/manage_doctors');
        } else {
            $data['all_details']     = $this->admindoctor_model->get_all_doctor_details($doctor_id);
            $data['patient_reviews'] = $this->admindoctor_model->get_patient_reviews($doctor_id);
            $doctor_extra_details    = $this->admindoctor_model->get_doctor_extra_details($doctor_id);
            if ($doctor_extra_details !== FALSE) {
                $data['doctor_extra_details'] = $doctor_extra_details;
            } else {
                $data['doctor_extra_details'] = '0';
            }
            
            if (isset($_POST['submit']) && $_POST['submit'] == 'Submit Review') {
                $this->admindoctor_model->insert_reviews($_POST, $doctor_id);
                $this->admindoctor_model->update_reviewed($_POST);
            }
            
            $data['perms'] = $this->perms;
            $this->load->view('admin/doctor_viewprofile', $data);
        }
    }
    
    function editbasicprofile($doctor_id = NULL)
    {
        $data['current_tab'] = $this->current_tab;
        
        if ($doctor_id == NULL) {
            redirect('/bdabdabda/manage_doctors');
        } else {
            if (isset($_POST['submit']) && !empty($_POST['submit'])) {
                $newfilename = $this->input->post('profile_pic_base64_name');
                if (!empty($newfilename)) {
                    $md        = date('M') . date('Y'); // getting the current month and year for folder name
                    $structure = "./media/photos/" . $md; // setting the folder path
                    // Check if the directory with that particular name is present or not
                    if (!is_dir("./media/photos/" . $md)) {
                        // If directory not present, then create the directory
                        mkdir($structure, 0777);
                    }
                    // setup the image new file name
                    $filename      = md5($newfilename) . rand(10000, 99999);
                    // Get extension of the file
                    $ext           = pathinfo($newfilename, PATHINFO_EXTENSION);
                    // get the full filename with full path as it needs to be entered in the db
                    $filename_path = $structure . "/" . $filename . "." . $ext;
                    
                    $decoded_pic = base64_decode($this->input->post('profile_pic_base64'));
					file_put_contents($filename_path, $decoded_pic);
                } else {
                    $filename_path = NULL;
                }
                $userid = $this->admindoctor_model->get_doctor_userid($doctor_id);
                if ($userid != NULL) {
                    $this->user_model->update_account($_POST, $filename_path, $userid);
                    $this->doctor_model->update_doctor_professional_details($_POST, $filename_path, $userid,$doctor_id);
                } else {
                    $this->admindoctor_model->update_doctor_details_nonbda($_POST, $filename_path, $doctor_id);
                }
                redirect('/bdabdabda/manage_doctors/viewprofile/' . $doctor_id);
            }
            
            $data['council']        = $this->doctor_model->get_council();
            $data['qualifications'] = $this->doctor_model->get_all_degree();
            $data['speciality']     = $this->doctor_model->get_all_speciality();
            
            $data['all_details']  = $this->admindoctor_model->get_all_doctor_details($doctor_id);
            $doctor_extra_details = $this->admindoctor_model->get_doctor_extra_details($doctor_id);
            if ($doctor_extra_details !== FALSE) {
                $data['doctor_extra_details'] = $doctor_extra_details;
            } else {
                $data['doctor_extra_details'] = '0';
            }
            $data['perms'] = $this->perms;
            $this->load->view('admin/doctor_editbasicdetails', $data);
        }
    }
    
    function editdetailedprofile($doctor_id = NULL)
    {
        $data['current_tab'] = $this->current_tab;
        
        if ($doctor_id == NULL) {
            redirect('/bdabdabda/manage_doctors');
        } else {
            if (isset($_POST['submit']) && !empty($_POST['submit'])) {
                $userid = $this->admindoctor_model->get_doctor_userid($doctor_id);
            }
            
            $data['services'] = $this->doctor_details_model->getServices(array(
                'limit' => 500
            ));
            
            $data['specializations'] = $this->common_model->getSpeciality(array(
                'limit' => 1000,
                'column' => array(
                    'id',
                    'name'
                )
            ));
            $data['qualification']   = $this->doctor_details_model->getQualification(array(
                'limit' => 500
            ));
            $data['college']         = $this->doctor_details_model->getCollege(array(
                'limit' => 500
            ));
            $data['city']            = $this->common_model->getCity(array(
                'column' => array(
                    'id',
                    'name'
                ),
                'orderby' => 'name asc'
            ));
            
            $data['from_year'] = range(1980, 2014);
            $data['to_year']   = range(1980, 2014);
            
            $data['membership']     = $this->doctor_details_model->getMembership(array(
                'limit' => 500
            ));
            $data['council']        = $this->doctor_details_model->getCouncil(array(
                'limit' => 500
            ));
            $data['doctor_summary'] = $this->doctor_model->getDoctor(array(
                'limit' => 1,
                'id' => $doctor_id,
                'column' => array(
                    'summary'
                )
            ));
            
            if (is_array($data['doctor_summary']) && sizeof($data['doctor_summary']) > 0) {
                $data['doctor_summary'] = $data['doctor_summary'][0]['summary'];
            } else {
                $data['doctor_summary'] = '';
            }
            
            $data['patient_numbers'] = $this->doctor_details_model->getPatientNumbers(array(
                'limit' => 20,
                'doctor_id' => $doctor_id,
                'orderby' => 'id asc'
            ));
            
            $data['all_details']  = $this->admindoctor_model->get_all_doctor_details($doctor_id);
            $doctor_extra_details = $this->admindoctor_model->get_doctor_extra_details($doctor_id);
            if ($doctor_extra_details !== FALSE) {
                $data['doctor_extra_details'] = $doctor_extra_details;
            } else {
                $data['doctor_extra_details'] = '0';
            }
            $data['perms'] = $this->perms;
            $this->load->view('admin/doctor_editdetailedprofile', $data);
        }
    }
    
    function login_as($doctor_id = NULL)
    {
        
        if ($this->perms[ADMIN_DOCTORS]['loginas'] == '1') {
            $this->load->model('user_model');
            
            if ($doctor_id == NULL) {
            } else {
                $userid      = $this->admindoctor_model->get_doctor_userid($doctor_id);
                $userdetails = $this->user_model->get_all_userdetails($userid);
                $details     = array(
                    'id' => $userid,
                    'type' => $userdetails->type,
                    'name' => $userdetails->name
                );
                $details     = json_decode(json_encode($details), FALSE);
                $this->user_model->login_user($details);
                redirect('/login');
            }
        }
    }
    
    function approve()
    {
        $status         = 1;
        $ids            = array_keys($this->post['doctor_id']);
        $user_ids       = $this->post['user_id'];
        $speciality_ids = $this->post['speciality'];
        $city_ids       = $this->post['city'];
        foreach ($ids as $id) {
            $user_id       = $user_ids[$id];
            $speciality_id = $speciality_ids[$id];
            $city_id       = $city_ids[$id];
            
            $affected_rows = $this->admindoctor_model->update_doctor_status($status, $id);
            $this->admindoctor_model->add_speciality_city_mapping(explode(",", $speciality_id), $city_id);
            if ($affected_rows > 0) {
                $this->admindoctor_model->autoapprove_trial_package($id);
                
                if (!empty($user_id)) {
                    $user_details = $this->admindoctor_model->get_user_detail_by_user_id($user_id);
                    $this->doctor_approve_mail_msg($user_details);
                }
            }
        }
    }
    
    function disapprove()
    {
        $status   = -1;
        $ids      = array_keys($this->post['doctor_id']);
        $user_ids = $this->post['user_id'];
        foreach ($ids as $id) {
            $user_id       = $user_ids[$id];
            $affected_rows = $this->admindoctor_model->update_doctor_status($status, $id);
            
            if ($affected_rows > 0) {
                if (!empty($user_id)) {
                    $user_details = $this->admindoctor_model->get_user_detail_by_user_id($user_id);
                    $this->doctor_disapprove_mail_msg($user_details);
                }
            }
        }
        
    }
    
    function pending()
    {
        $status = 0;
        $ids    = array_keys($this->post['doctor_id']);
        foreach ($ids as $id) {
            $this->admindoctor_model->update_doctor_status($status, $id);
        }
    }
    
    function duplicate()
    {
        $status = 3;
        $ids    = array_keys($this->post['doctor_id']);
        foreach ($ids as $id) {
            $this->admindoctor_model->update_doctor_status($status, $id);
        }
    }
    
    function register_doctor($doctor_id = NULL)
    {
        $this->load->library('form_validation');
        $this->load->helper(array(
            'form',
            'url'
        ));
        
        if (!empty($doctor_id) && is_numeric($doctor_id)) {
            $data['all_details'] = $this->admindoctor_model->get_doc_reginfo($doctor_id);
            $data['perms']       = $this->perms;
            //print_r($data['all_details']);
            if (isset($_POST['submit']) && !empty($_POST['submit'])) {
                $config = array(
                    array(
                        'field' => 'name',
                        'label' => 'Name',
                        'rules' => 'required|trim|min_length[4]|max_length[50]|xss_clean'
                    ),
                    array(
                        'field' => 'email',
                        'label' => 'Email',
                        'rules' => 'required|trim|valid_email|callback_check_email_exists'
                    ),
                    array(
                        'field' => 'pass',
                        'label' => 'Password',
                        'rules' => 'required|min_length[6]|max_length[24]'
                    ),
                    array(
                        'field' => 'cnfmpass',
                        'label' => 'Confirm Password',
                        'rules' => 'required|matches[pass]'
                    ),
                    array(
                        'field' => 'mob',
                        'label' => 'Mobile Number',
                        #'rules'=> 'required|trim|min_length[10]|max_length[10]|callback_checkmobexist'
                        'rules' => 'trim|min_length[10]|max_length[10]|callback_checkmobexist'
                        // SMS verification removal
                        //'rules'=> 'required | trim | min_length[10] | max_length[10] | callback_checkmobverified'
                    ),
                    array(
                        'field' => 'dob',
                        'label' => 'Date of Birth',
                        'rules' => ''
                    ),
                    array(
                        'field' => 'gender',
                        'label' => 'Gender',
                        'rules' => 'required'
                    )
                );
                $this->form_validation->set_rules($config);
                if ($this->form_validation->run() !== FALSE) {
                    // check if file is uploaded or not
                    $newfilename = $this->input->post('profile_pic_base64_name');
                    if (!empty($newfilename)) {
                        //echo getcwd();
                        $md        = date('M') . date('Y'); // getting the current month and year for folder name
                        $structure = "./media/photos/" . $md; // setting the folder path
                        // Check if the directory with that particular name is present or not
                        if (!is_dir("./media/photos/" . $md)) {
                            // If directory not present, then create the directory
                            mkdir($structure, 0777);
                        }
                        // setup the image new file name
                        $filename      = md5($newfilename) . rand(10000, 99999);
                        // Get extension of the file
                        $ext           = pathinfo($newfilename, PATHINFO_EXTENSION);
                        // get the full filename with full path as it needs to be entered in the db
                        $filename_path = $structure . "/" . $filename . "." . $ext;
                        $decoded_pic   = base64_decode($this->input->post('profile_pic_base64'));
                        file_put_contents($filename_path, $decoded_pic);
                    } else {
                        $filename_path = $data['all_details']['image'];
                    }
                    
                    $id = $this->admindoctor_model->create_account($_POST, $filename_path);
                    if ($id) {
                        $this->admindoctor_model->update_doctor_userid($id, $doctor_id,$_POST,$filename_path);
                        $this->admindoctor_model->set_doctor_pending($id, $doctor_id);
                    } else {
                        
                    }
                    redirect('/bdabdabda/manage_doctors/editbasicprofile/' . $doctor_id);
                }
            }
            
            $this->load->view('admin/doctor_register', isset($data) ? $data : NULL);
        }
    }
    
    function check_email_exists($email)
    {
        $query = $this->db->get_where('user', array(
            'email_id' => $email
        ), 1);
        
        if ($query->num_rows() >= 1) {
            $this->form_validation->set_message('check_email_exists', 'Email ID already in use');
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    function edit_clinic($clinic_id = NULL)
    {
        if (isset($_POST['submit'])) {
            print_r($_POST);
            exit;
            $this->admindoctor_model->update_clinic_details($clinic_id, $_POST);
        }
        $data['cities']         = $this->location_model->get_all_cities();
        $data['all_details']    = $this->admindoctor_model->get_clinic_details($clinic_id);
        $data['clinic_timings'] = json_decode($data['all_details']['timings'], true);
        $data['perms']          = $this->perms;
        $this->load->view('admin/doctor_editclinic', isset($data) ? $data : NULL);
    }
    
    function addclinic($doctor_id = NULL)
    {
        $this->load->library('form_validation');
        //$userid = $this->session->userdata('id');
        //$data['name'] = $this->session->userdata('name');
        //$data['userdetails'] = $this->user_model->get_all_userdetails($userid);
        
        $data['council']     = $this->doctor_model->get_council();
        $data['doctor_data'] = $this->admindoctor_model->get_doctor_data($doctor_id);
        //$data['doctor_data'] = $this->doctor_model->get_doctor_data($userid);
        $data['speciality']  = $this->doctor_model->get_all_speciality();
        $data['degree']      = $this->doctor_model->get_all_degree();
        $data['cities']      = $this->location_model->get_all_cities();
        $data['perms']       = $this->perms;
        
        $data['sor_eligible'] = '1';
        
        $data['doctorid'] = $doctor_id;
        
        $sl_step2_submit = $this->input->post('sl_step2');
        
        if (isset($sl_step2_submit) && $sl_step2_submit == 'sl_step2') {
            $config = array(
                array(
                    'field' => 'clinic_name',
                    'label' => 'Clinic Name',
                    'rules' => 'required|trim'
                ),
                array(
                    'field' => 'clinic_address',
                    'label' => 'Clinic Address',
                    'rules' => 'required|trim'
                ),
                array(
                    'field' => 'city',
                    'label' => 'City',
                    'rules' => 'required|trim'
                ),
                array(
                    'field' => 'locality',
                    'label' => 'Locality',
                    'rules' => 'trim'
                ),
                array(
                    'field' => 'pincode',
                    'label' => 'Pincode',
                    'rules' => 'required|trim|numeric'
                ),
                array(
                    'field' => 'clinic_number',
                    'label' => 'Clinic Number',
                    'rules' => 'required|trim'
                ),
                array(
                    'field' => 'clinic_number_code',
                    'label' => 'Clinic Code',
                    'rules' => 'trim|numeric'
                ),
                array(
                    'field' => 'days',
                    'label' => 'Appointment Days',
                    'rules' => 'required'
                ),
                array(
                    'field' => 'consult_fee',
                    'label' => 'Consultation Fee',
                    'rules' => 'trim'
                ),
                array(
                    'field' => 'avg_patient_duration',
                    'label' => 'Average duration per patient',
                    'rules' => 'required|trim'
                )
            );
            $this->form_validation->set_rules($config);
            if ($this->form_validation->run() !== FALSE) {
                // Merge clinic contact number
                if (!empty($_POST['clinic_number_code']))
                    $_POST['clinic_number'] = $_POST['clinic_number_code'] . '-' . $_POST['clinic_number'];
                else
                    $_POST['clinic_number'] = $_POST['clinic_number'];
                
                // Insert details in clinic table
                $clinic_id = $this->admindoctor_model->insert_clinic($doctor_id, $this->input->post());
                
                if (isset($_POST['add_more_clinic_x'])) {
                    $this->session->set_flashdata('errormessage', 'Clinic Added Successfully');
                    redirect(current_url());
                } else {
                    $this->session->set_flashdata('errormessage', 'Clinic Added Successfully');
                    redirect('/bdabdabda/manage_doctors/viewprofile/' . $doctor_id);
                }
            }
        }
        
        $this->load->view('admin/doctor_edit_add_clinic_copy_post', isset($data) ? $data : NULL);
    }
    
    function editclinic($clinicid = NULL, $doctor_id = NULL)
    {
        
        
        $this->load->library('form_validation');
        
        if ($clinicid != NULL && $doctor_id != NULL) {
            
            $data['doctor_data']    = $this->admindoctor_model->get_doctor_data($doctor_id);
            $data['doctorid']       = $doctor_id;
            $data['cities']         = $this->location_model->get_all_cities();
            $data['editclinic']     = 'editclinic';
            $data['clinic_details'] = $this->doctor_model->get_clinic_details($clinicid, $doctor_id);
            $data['sor_eligible']   = '1';
            $data['perms']          = $this->perms;
            
            if ($data['clinic_details']->location_id > 0) {
                $localities         = $this->location_model->get_locality($data['clinic_details']->city_id);
                $data['localities'] = $localities;
            } else {
                $data['other_locality'] = $data['clinic_details']->other_location;
            }
            
            // Timings conversion begins
            $timings                = $data['clinic_details']->timings;
            $data['clinic_timings'] = json_decode($timings, true);
            $data['clinic_details']->timings;
            //			print_r($timings);
            //			print_r($data['clinic_timings']);
            
            $sl_step2_submit = $this->input->post('sl_step2');
            if (isset($sl_step2_submit) && $sl_step2_submit == 'sl_step2') {
                $config = array(
                    array(
                        'field' => 'clinic_name',
                        'label' => 'Clinic Name',
                        'rules' => 'required|trim'
                    ),
                    array(
                        'field' => 'clinic_address',
                        'label' => 'Clinic Address',
                        'rules' => 'required|trim'
                    ),
                    array(
                        'field' => 'city',
                        'label' => 'City',
                        'rules' => 'required|trim'
                    ),
                    array(
                        'field' => 'locality',
                        'label' => 'Locality',
                        'rules' => 'trim'
                    ),
                    array(
                        'field' => 'pincode',
                        'label' => 'Pincode',
                        'rules' => 'required|trim|numeric'
                    ),
                    array(
                        'field' => 'clinic_number',
                        'label' => 'Clinic Number',
                        'rules' => 'required|trim'
                    ),
                    array(
                        'field' => 'clinic_number_code',
                        'label' => 'Clinic Code',
                        'rules' => 'trim|numeric'
                    ),
                    array(
                        'field' => 'days',
                        'label' => 'Appointment Days',
                        'rules' => 'required'
                    ),
                    array(
                        'field' => 'consult_fee',
                        'label' => 'Consultation Fee',
                        'rules' => 'trim'
                    ),
                    array(
                        'field' => 'avg_patient_duration',
                        'label' => 'Average duration per patient',
                        'rules' => 'required|trim|integer'
                    )
                );
                
                $this->form_validation->set_rules($config);
                if ($this->form_validation->run() == FALSE) {
                    // Invalid form details
                } else {
                    // Merge clinic number
                    if (!empty($_POST['clinic_number_code']))
                        $_POST['clinic_number'] = $_POST['clinic_number_code'] . '-' . $_POST['clinic_number'];
                    else
                        $_POST['clinic_number'] = $_POST['clinic_number'];
                    
                    // Update details in clinic table
                    $clinic_id = $this->admindoctor_model->update_clinic($doctor_id, $clinicid, $this->input->post());
                    
                    $this->session->set_flashdata('errormessage', 'Edit Clinic Successful');
                    redirect('/bdabdabda/manage_doctors/viewprofile/' . $doctor_id);
                }
            }
            $this->load->view('admin/doctor_edit_add_clinic_copy_post', isset($data) ? $data : NULL);
        } else {
            redirect('/bdabdabda/manage_doctors');
        }
    }
    
    function delete_clinic($clinic_id = NULL)
    {
        if (isset($clinic_id) && !empty($clinic_id) && is_numeric($clinic_id)) {
            $status = $this->admindoctor_model->delete_clinic($clinic_id);
            if ($status > 0) {
                echo '1';
            } else {
                echo '0';
            }
        }
    }
    
    function add_doctor()
    {
        $this->load->library('form_validation');
        $this->load->helper(array(
            'form',
            'url'
        ));
        $this->load->model('sendsms_model');
        
        if (isset($_POST['submit']) && !empty($_POST['submit'])) {
            $config = array(
                array(
                    'field' => 'name',
                    'label' => 'Name',
                    'rules' => 'required|trim|min_length[4]|max_length[30]|xss_clean'
                ),
                array(
                    'field' => 'email',
                    'label' => 'Email',
                    'rules' => 'required|trim|valid_email|callback_check_email_exists'
                ),
                array(
                    'field' => 'pass',
                    'label' => 'Password',
                    'rules' => 'required|min_length[6]|max_length[24]'
                ),
                array(
                    'field' => 'cnfmpass',
                    'label' => 'Confirm Password',
                    'rules' => 'required|matches[pass]'
                ),
                array(
                    'field' => 'mob',
                    'label' => 'Mobile Number',
                    'rules' => 'required|trim|min_length[10]|max_length[10]|callback_checkmobexist'
                    // SMS verification removal
                    //'rules'=> 'required | trim | min_length[10] | max_length[10] | callback_checkmobverified'
                ),
                array(
                    'field' => 'dob',
                    'label' => 'Date of Birth',
                    'rules' => 'required'
                ),
                array(
                    'field' => 'gender',
                    'label' => 'Gender',
                    'rules' => 'required'
                )
            );
            $this->form_validation->set_rules($config);
            if ($this->form_validation->run() !== FALSE) {
                // check if file is uploaded or not
                $newfilename = $this->input->post('profile_pic_base64_name');
                if (!empty($newfilename)) {
                    //echo getcwd();
                    $md        = date('M') . date('Y'); // getting the current month and year for folder name
                    $structure = "./media/photos/" . $md; // setting the folder path
                    // Check if the directory with that particular name is present or not
                    if (!is_dir("./media/photos/" . $md)) {
                        // If directory not present, then create the directory
                        mkdir($structure, 0777);
                    }
                    // setup the image new file name
                    $filename      = md5($newfilename) . rand(10000, 99999);
                    // Get extension of the file
                    $ext           = pathinfo($newfilename, PATHINFO_EXTENSION);
                    // get the full filename with full path as it needs to be entered in the db
                    $filename_path = $structure . "/" . $filename . "." . $ext;
                    $decoded_pic   = base64_decode($this->input->post('profile_pic_base64'));
                    file_put_contents($filename_path, $decoded_pic);
                } else {
                    $filename_path = '';
                }
                echo $filename_path . "<br/>";
                echo $userid = $this->admindoctor_model->create_account($_POST, $filename_path);
                echo "<br><br>";
                //$this->sendsms_model->send_welcome_sms_doctor($_POST["mob"]);
                echo $doctor_id = $this->admindoctor_model->create_doctor_entry($_POST, $filename_path, $userid);
                
                redirect('/bdabdabda/manage_doctors/editbasicprofile/' . $doctor_id);
            }
        }
        $data['perms'] = $this->perms;
        $this->load->view('admin/doctor_add', isset($data) ? $data : NULL);
    }
    
    function checkmobexist()
    {
        $mobile = $this->input->post('mob');
        $check  = $this->user_model->check_mobno_exists($mobile);
        if ($check === TRUE) {
            $this->form_validation->set_message('checkmobexist', 'Mobile Number already exist');
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    function sendsms($mobile = NULL)
    {
        if (isset($mobile) && !empty($mobile) && is_numeric($mobile)) {
            $encoded_msg = urlencode($_POST['message']);
            $this->sendsms_model->send_sms($mobile, $encoded_msg);
        }
    }
    
    function get_checklist($doctor_id = NULL)
    {
        if ($doctor_id != NULL) {
            if (isset($_POST['category']) && !empty($_POST['category'])) {
                $user_id   			= $_POST['uid'];
								$speciality_id  = $_POST['speciality_id'];
								$city_id   			= $_POST['city_id'];
                $checklist 			= $this->admindoctor_model->get_checklist($_POST['category']);
								#echo $this->admindoctor_model;
								#print_r($checklist);exit;
                if ($checklist !== FALSE) {
                    foreach ($checklist as $row) {
                        $checklistenrty = $this->admindoctor_model->get_checklistenrty($doctor_id, $row->id);
                        if (isset($checklistenrty->value) && !empty($checklistenrty->value) && $checklistenrty->value == 1)
                            $checked = 'checked="checked"';
                        else
                            $checked = '';
                        //						print_r($checklistenrty);
                        if ($row->type == '1') {
                            echo '
							<div class="checkbox">
								 <label><input type="checkbox" class="resp-checkbox" ' . $checked . ' name="statuscheckbox[' . $row->id . ']" />' . $row->desc . '</label>
							</div>
							';
                            if ($row->have_comment == 1)
                                echo '
							<div class="form-group">
								<input type="text" value="' . @$checklistenrty->comment . '" class="resp-text from-control" name="checkboxcomment[' . $row->id . ']" placeholder="Comment" /><br/>
							</div><br/>
							';
                        } elseif ($row->type == '9') {
                            echo '<div class="form-group">
							<textarea required="required" name="checkboxcomment[' . $row->id . ']" class="form-control resp-textarea" id="' . $row->id . '" placeholder="Notes">' . @$checklistenrty->comment . '</textarea>
							</div>
							';
                        }
                        echo '<input type="hidden" name="checklisttype[' . $row->id . ']" value="' . $row->type . '" />';
                    }
                    echo '<input type="hidden" name="doctor_id" value="' . $doctor_id . '" />
										<input type="hidden" name="user_id" value="' . $user_id . '" />
										<input type="hidden" name="speciality_id" value="' . $speciality_id . '" />
										<input type="hidden" name="city_id" value="' . $city_id . '" />';
                    
                    if ($row->category == 'doctor_approve') {
                        echo '<div class="form-group"><input class="btn btn-primary save-form-btn" type="submit" value="Save Changes" />
							<input class="btn btn-primary submit-form-btn" type="submit" value="Update Status" />
							</div>
							';
                    } else {
                        echo '<div class="form-group"><input class="btn btn-primary submit-form-btn" type="submit" value="Update Status" /></div>';
                    }
                } else {
                    
                }
            }
        }
    }
    
    function statuspost()
    {
			if (isset($_POST['doctor_id']) && !empty($_POST['doctor_id'])) {
			$doctor_display_status	=	 array('doctor_approve'=>'Approved','doctor_disapprove'=>'Disapproved','doctor_pending'=>'Pending','doctor_delete'=>'Deleted','doctor_duplicate'=>'Duplicate'); 				
			$doctor_display_label_status	=	 array('doctor_approve'=>'label-success','doctor_disapprove'=>'label-danger','doctor_pending'=>'label-info','doctor_delete'=>'label-danger','doctor_duplicate'=>'label-warning'); 				
			
					$doctor_id = $_POST['doctor_id'];
					$user_id   = $_POST['user_id'];
					$speciality_id	=	$_POST['speciality_id'];
					$city_id	=	$_POST['city_id'];
					$category     = $_POST['status'];
					foreach ($_POST['checklisttype'] as $key => $value)
					{
						$checklist_id = $key;
						$type         = $value;
						$comment      = isset($_POST['checkboxcomment'][$key]) && !empty($_POST['checkboxcomment'][$key]) ? $_POST['checkboxcomment'][$key] : '';
						$value2       = (isset($_POST['statuscheckbox'][$key]) && !empty($_POST['statuscheckbox'][$key])) || $type == '9' ? '1' : '0';
						if ($value != '0')
						{
								$check = $this->admindoctor_model->insert_checklist_entry($category, $value2, $comment, $type, $checklist_id, $doctor_id);
						}
					}

					if ($category == 'doctor_approve')$status = '1';
					elseif ($category == 'doctor_disapprove')$status = '-1';
					elseif ($category == 'doctor_pending')$status = '0';
					elseif ($category == 'doctor_delete')$status = '-2';
					elseif ($category == 'doctor_duplicate')$status = '3';
					else $status = NULL;
					
					 if ($status !== NULL)
					 {
						$ids     = array($doctor_id);
						$status2 = $this->admindoctor_model->update_doctor_status($status, $ids);
						if ($status == 1)
						{
								$user_details = $this->admindoctor_model->get_user_detail_by_user_id($user_id);
								$this->doctor_approve_mail_msg($user_details);
								$speciality_ids	=	 explode(",",$speciality_id);
								$this->admindoctor_model->add_speciality_city_mapping($speciality_ids, $city_id);
						}else if ($status == -1)
						{
								$user_details = $this->admindoctor_model->get_user_detail_by_user_id($user_id);
								$this->doctor_disapprove_mail_msg($user_details);
						}
					}
			echo json_encode(array('category'=>$category,"doctor_id"=>$doctor_id,'category_display'=>$doctor_display_status[$category]
			,'category_display_label'=>$doctor_display_label_status[$category]));
			}
    }
    
    function doctor_approve_mail_msg($details)
    {
        $mail_res = $this->mail_model->account_verified($details->email_id, $details->name);
        $sms_res  = $this->sendsms_model->account_verified($details->contact_number);
    }
    
    function doctor_disapprove_mail_msg($details)
    {
        $mail_res = $this->mail_model->account_not_verified($details->email_id, $details->name);
        $sms_res  = $this->sendsms_model->account_not_verified($details->contact_number);
    }
    
    function doctor_status_approve_save_changes()
    {
        if (isset($_POST['doctor_id']) && !empty($_POST['doctor_id'])) {
            $doctor_id = $_POST['doctor_id'];
            //			print_r($_POST);
            foreach ($_POST['checklisttype'] as $key => $value) {
                //				echo $key . ' => ' . $value . ';  ';
                $checklist_id = $key;
                $category     = $_POST['status'];
                $type         = $value;
                $comment      = isset($_POST['checkboxcomment'][$key]) && !empty($_POST['checkboxcomment'][$key]) ? $_POST['checkboxcomment'][$key] : '';
                $value2       = (isset($_POST['statuscheckbox'][$key]) && !empty($_POST['statuscheckbox'][$key])) || $type == '9' ? '1' : '0';
                if ($value != '0') {
                    $check = $this->admindoctor_model->insert_checklist_entry($category, $value2, $comment, $type, $checklist_id, $doctor_id);
                }
            }
        }
    }
    
    function search_duplicates()
    {
        if (isset($_POST['chkbox']) && !empty($_POST['chkbox'])) {
            /*echo '<pre>';
            print_r($_POST);
            echo '</pre>';*/
            if (isset($_POST['similardocids']) && !empty($_POST['similardocids'])) {
                $this->admindoctor_model->update_duplicates($_POST['similardocids']);
            } else {
                echo 2;
            }
        }
        
        if (isset($_GET['name']) && !empty($_GET['name'])) {
            if (isset($_GET['perct']) && !empty($_GET['perct']) && is_numeric($_GET['perct']) && $_GET['perct'] > 0 && $_GET['perct'] < 101) {
                $perct = $_GET['perct'];
            } else {
                $perct = '80';
            }
            $name                = $_GET['name'];
            $all_doctors         = $this->admindoctor_model->get_all_doctors($name);
            $data['all_doctors'] = $all_doctors;
            $similar_docs        = array();
            foreach ($all_doctors as $row) {
                similar_text($row['name'], $name, $percent);
                //				echo $percent.'<br/>';
                if ($percent >= $perct) {
                    $row['percent'] = $percent;
                    $similar_docs[] = $row;
                }
            }
            $data['similar_docs'] = $similar_docs;
        }
        $data['perms'] = $this->perms;
        $this->load->view('admin/doctor_duplicates', isset($data) ? $data : NULL);
    }
    
    function search_duplicates_list()
    {
        $duplicates         = $this->admindoctor_model->get_duplicates_list();
        $data['duplicates'] = $duplicates;
        $data['perms']      = $this->perms;
        $this->load->view('admin/doctor_duplicates_list', isset($data) ? $data : NULL);
    }
    
    function remove_duplicate($duplicate_id = '')
    {
        if (!empty($duplicate_id) && is_numeric($duplicate_id))
            $this->admindoctor_model->remove_duplicates($duplicate_id);
        redirect('/bdabdabda/manage_doctors/search_duplicates_list');
    }
    
    function deleteclinicphoto()
    {
        $this->doctor_model->deleteclinicphoto($_POST['doctorid'], $_POST['clinicid'], $_POST['photoid']);
    }
    
    function add_new_doctor()
    {
			#print_r($_POST);exit;
        // $this->load->model('admin/adminmasters_model');
        $this->data['current_tab'] = $this->current_tab;
        
        if (isset($_POST['submit']) && !empty($_POST['submit'])) {
            
            
            $newfilename   = $this->input->post('profile_pic_base64_name');
            $filename_path = NULL;
            if (!empty($newfilename)) {
                $image     = $_POST['profile_pic_base64_name'];
                //echo getcwd();
                $md        = date('M') . date('Y') . "/" . strtolower(substr($image, 0, 1)); #.rand(1,60); // getting the current month and year for folder name
                $structure = "./media/photos/" . $md; // setting the folder path
                // Check if the directory with that particular name is present or not
                if (!is_dir("./media/photos/" . $md)) {
                    // If directory not present, then create the directory
                    mkdir($structure, 0777);
                }
                // setup the image new file name
                $filename      = md5($newfilename);
                // Get extension of the file
                $ext           = pathinfo($newfilename, PATHINFO_EXTENSION);
                // get the full filename with full path as it needs to be entered in the db
                $filename_path = $structure . "/" . $filename . "." . $ext;
                
                $decoded_pic = base64_decode($this->input->post('profile_pic_base64'));
                
                file_put_contents($filename_path, $decoded_pic);
            }
            
            $data = array(
                'name' => $_POST['doctor_name'],
                'gender' => $_POST['gender'],
                'summary' => $_POST['summary'],
                'reg_no' => $_POST['reg_no'],
                'council_id' => $_POST['council_id'][0],
                'speciality' => $_POST['speciality'][0],
                'qualification' => $_POST['qualification'][0],
                'yoe' => $_POST['year_exp'],
                'image' => $filename_path,
                'contact_number' => $_POST['contact_number'],
                'is_ver_reg' => $_POST['is_ver_reg'],
                'status' => $_POST['status'],
                'created_on' => $_POST['created_on'],
                'sponsored' => $_POST['sponsored'],
                'paid' => $_POST['paid'],
                'sort' => (($_POST['sort'])?$_POST['sort']:99)
            );
            
            #print_r($data);
            // echo $_POST['council_id'][0];
            
            $this->db->insert('doctor', $data);
             #print_r($this->db->last_query());exit;
            // redirect('/bdabdabda/manage_doctors');
            
        }
        
        
        
        $this->data['council']        = $this->doctor_model->get_council();
        $this->data['qualifications'] = $this->doctor_model->get_all_degree();
        $this->data['speciality']     = $this->doctor_model->get_all_speciality();
        // print_r($data['speciality']);
        $this->data['perms']          = $this->perms;
        
        
        $this->load->view('admin/doctor_add', $this->data);
        
    }
    
}