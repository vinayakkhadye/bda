<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');

class patient_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
	}
	function insert_patient_details($details, $user_id)
	{
		$userdetails = $this->user_model->get_all_userdetails($user_id);
		$patient = array(
			'user_id'            =>$user_id,
			'name'               =>$userdetails->name,
			'image'              =>$userdetails->image,
			'blood_group'        =>$details['blood_group'],
			'location_id'        =>$details['locality'],
			'city_id'            =>$details['city'],
			'address'            =>$details['address'],
			'pin_code'           =>$details['pincode'],
			'food_habits'        =>$details['food_habits'],
			'alcohol'            =>$details['alcohol'],
			'smoking'            =>$details['smoking'],
			'ciggi_per_day'      =>$details['no_of_cig'],
			'tobacco_consumption'=>$details['tobacco'],
			'allergic'           =>$details['allergic_to'],
			'ongoing_medications'=>$details['ongoing_meditation']
		);
		$this->db->insert('patient', $patient);
		$patient_id = $this->db->insert_id();

		$bmi        = array(
			'user_id'      =>$user_id,
			'height_feet'  =>$details['height_feet'],
			'height_inches'=>$details['height_inches'],
			'weight'       =>$details['weight'],
			'bmi_value'    =>''
		);
		$this->db->insert('bmi', $bmi);

		$patient_family_detail = array(
			'patient_id' =>$patient_id,
			'disease'    =>$details['disease_name'],
			'member_name'=>implode('#&#', $details['member_name']),
			'summary'    =>$details['detail_info']
		);
		$this->db->insert('patient_family_detail', $patient_family_detail);
		
		// conversion of disease_from_date and disease_to_date in proper format
			$e = '1-'.$details['incident_month'].'-'.$details['incident_year'];
			$disease_from_date = date('Y-m-d', strtotime($e));
			
			$f = '+'.$details['duration_year'].'year '.$details['duration_month'].' months';
			$disease_to_date = date('Y-m-d', strtotime($e.$f));
			
			if($details['duration_year'] == 0 && $details['duration_month'] == 0)
			$disease_to_date = $disease_from_date;
			
			if(!empty($details['surgery_date']))
			{
				$surgery_date = date('Y-m-d', strtotime($details['surgery_date']));
			}
			else
			{
				$surgery_date = NULL;
			}
		// conversion ends
		
		$patient_history = array(
			'patient_id'       =>$patient_id,
			'disease'          =>$details['past_disease'],
			'disease_from_date'=>$disease_from_date,
			'disease_to_date'  =>$disease_to_date,
			'disease_details'  =>$details['disease_details'],
			'surgery'          =>$details['surgery_name'],
			'surgery_reason'   =>$details['surgery_reason'],
			'surgery_date'     =>$surgery_date,
			'attachments'      =>''
		);
		$this->db->insert('patient_history', $patient_history);
	}
	public function mkpath($path,$perm){
		if(@mkdir($path) or file_exists($path)) return true;
		return ($this->mkpath(dirname($path),$perm) and mkdir($path,$perm));
	}
	function insert_patient_bmi($details){
			
		$bmi = array(
			
			'height_feet'  =>$details['height_feet'],
			'height_inches'=>$details['height_inches'],
			'weight'       =>$details['weight'],
			'bmi_value'    =>$details['bmi_value'],
		);
		if(isset($details['patient_id'])){
			$bmi['patient_id'] = $details['patient_id'];
		}
	
		if(isset($details['user_id'])){
			$bmi['user_id'] = $details['user_id'];
		}
		
		$this->db->insert('bmi', $bmi);
	}
	
	function insert_patient_family_history($details){
	
		$patient_family_detail = array(
			'disease'    =>$details['family_disease'],
			'member_name'=>implode('#&#', $details['family_member_name']),
			'summary'    =>$details['family_summary']
		);
		if(isset($details['patient_id'])){
			$patient_family_detail['patient_id'] = $details['patient_id'];
		}

		$this->db->insert('patient_family_detail', $patient_family_detail);
	}
	function update_patient_family_history($id,$details){
		if($id){
			$patient_family_detail = array(
				'disease'    =>$details['family_disease'],
				'member_name'=>implode('#&#', $details['family_member_name']),
				'summary'    =>$details['family_summary']
			);
			$this->db->where('id', $id);
			$this->db->update('patient_family_detail', $patient_family_detail);
			return $this->db->affected_rows();
		}
		return false;
	}
	
	function insert_patient_past_disease($details){
		$patient_past_disease = array(
			'disease_name'    		=>$details['disease_name'],
			'disease_from_month'    =>$details['disease_from_month'],
			'disease_from_year'    	=>$details['disease_from_year'],
			'disease_duration'    	=>$details['disease_duration'],
			'disease_details'    	=>$details['disease_details']
		);
		if(isset($details['patient_id'])){
			$patient_past_disease['patient_id'] = $details['patient_id'];
		}
		$this->db->insert('patient_past_disease', $patient_past_disease);
	}
	function update_patient_past_disease($id,$details){
		if($id){
			$patient_past_disease = array(
				'disease_name'    		=>$details['disease_name'],
				'disease_from_month'    =>$details['disease_from_month'],
				'disease_from_year'    	=>$details['disease_from_year'],
				'disease_duration'    	=>$details['disease_duration'],
				'disease_details'    	=>$details['disease_details']
			);
			$this->db->where('id', $id);
			$this->db->update('patient_past_disease', $patient_past_disease);	
			return $this->db->affected_rows();
		}
		return false;
	}

	function insert_patient_past_surgery($details){
		$patient_past_surgery = array(
			'surgery_name'	=>$details['surgery_name'],
			'reason'    	=> $details['surgery_reason'],
			'surgery_date' 	=> date("Y-m-d",strtotime($details['surgery_date']))
		);
		if(isset($details['patient_id'])){
			$patient_past_surgery['patient_id'] = $details['patient_id'];
		}
		$this->db->insert('patient_past_surgery', $patient_past_surgery);
	}
	function update_patient_past_surgery($id,$details){
		if($id){
			$patient_past_surgery = array(
				'surgery_name'	=>$details['surgery_name'],
				'reason'    	=> $details['surgery_reason'],
				'surgery_date' 	=> date("Y-m-d",strtotime($details['surgery_date']))
			);
			$this->db->where('id', $id);

			$this->db->update('patient_past_surgery', $patient_past_surgery);
			return $this->db->affected_rows();
		}
		return false;
	}

	function insert_patient_medication($details){

		$patient_medication = array(
			'medication'  =>$details['medication']
		);
		if(isset($details['patient_id'])){
			$patient_medication['patient_id'] = $details['patient_id'];
		}
		
		$this->db->insert('patient_medication', $patient_medication);
	}
	function update_patient_medication($id,$details){
		if($id){
			$patient_medication = array(
				'medication'  =>$details['medication']
			);
			$this->db->where('id', $id);
			$this->db->update('patient_medication', $patient_medication);
			return $this->db->affected_rows();
		}
		return false;
	}

	function insert_patient_allergic($details){
		$patient_allergic = array(
			'allergic'    		=>$details['allergic'],
			'allery_type'    		=>$details['allery_type']
		);
		if(isset($details['patient_id'])){
			$patient_allergic['patient_id'] = $details['patient_id'];
		}
		$this->db->insert('patient_allergic', $patient_allergic);
	}
	function update_patient_allergic($id,$details){
		if($id){
			$patient_allergic = array(
				'allergic'    		=>$details['allergic'],
				'allery_type'    		=>$details['allery_type']
			);
			$this->db->where('id', $id);
			$this->db->update('patient_allergic', $patient_allergic);
			return $this->db->affected_rows();
		}
		return false;
	}

	function insert_patient_report($details){
		$patient_report = array(
			'date'    		=>$details['report_date'],
			'reason'    		=>$details['report_reason'],
			'category'    		=>$details['report_category'],
			'attachment'    	=>$details['report_attachment']
		);
		if(isset($details['patient_id'])){
			$patient_report['patient_id'] = $details['patient_id'];
		}
		$this->db->insert('patient_report', $patient_report);
	}

	function update_patient_report($id,$details){
		if($id){
			if(isset($details['report_date']) && !empty($details['report_date'])){
				$patient_report['date'] = $details['report_date'];
			}

			if(isset($details['report_reason']) && !empty($details['report_reason'])){
				$patient_report['reason'] = $details['report_reason'];
			}

			if(isset($details['report_category']) && !empty($details['report_category'])){
				$patient_report['category'] = $details['report_category'];
			}

			if(isset($details['report_attachment']) && !empty($details['report_attachment'])){
				$patient_report['attachment'] = $details['report_attachment'];
			}
			if(isset($patient_report) && sizeof($patient_report)>0 && $id){
				$this->db->where('id', $id);
				$this->db->update('patient_report', $patient_report);
				return $this->db->affected_rows();
			}else{
				return false;
			}
		}
		return false;
	}

	function insert_patient($details){
		$insert_query = $this->db->insert_string('patient',$details);
		$insert_query = str_replace('INSERT INTO','INSERT IGNORE INTO',$insert_query);
		$rs           = $this->db->query($insert_query);
		if($this->db->affected_rows()>0)
		{
			return $this->db->insert_id();
		}
		else
		{
			return false;;
		}
	}
	function insert_patient_doctor_map($details){
		$insert_query = $this->db->insert_string('doctor_patient_map',$details);
		$insert_query = str_replace('INSERT INTO','INSERT IGNORE INTO',$insert_query);
		$rs           = $this->db->query($insert_query);
		$patient_doctor_id = $this->db->insert_id();
		return $patient_doctor_id;
	}
	
	function insert_patient_details_withuout_user($details)
	{
		
		$patient = array(
			'name'               =>$details['patient_name'],
			'image'              =>$details['patient_image'],
			'blood_group'        =>$details['blood_group'],
			'location_id'        =>$details['locality'],
			'city_id'            =>$details['city'],
			'address'            =>$details['address'],
			'pin_code'           =>$details['pincode'],
			'food_habits'        =>$details['food_habits'],
			'alcohol'            =>$details['alcohol'],
			'smoking'            =>$details['smoking'],
			'ciggi_per_day'      =>$details['no_of_cig'],
			'tobacco_consumption'=>$details['tobacco'],
			'allergic'           =>$details['allergic_to'],
			'ongoing_medications'=>$details['ongoing_meditation'],
			'email'				=>$details['email']
		);
		
		$this->db->insert('patient', $patient);
		$patient_id = $this->db->insert_id();

		$bmi        = array(
			'user_id'      =>$user_id,
			'height_feet'  =>$details['height_feet'],
			'height_inches'=>$details['height_inches'],
			'weight'       =>$details['weight'],
			'bmi_value'    =>''
		);
		$this->db->insert('bmi', $bmi);

		$patient_family_detail = array(
			'patient_id' =>$patient_id,
			'disease'    =>$details['disease_name'],
			'member_name'=>implode('#&#', $details['member_name']),
			'summary'    =>$details['detail_info']
		);
		$this->db->insert('patient_family_detail', $patient_family_detail);
		
		// conversion of disease_from_date and disease_to_date in proper format
			$e = '1-'.$details['incident_month'].'-'.$details['incident_year'];
			$disease_from_date = date('Y-m-d', strtotime($e));
			
			$f = '+'.$details['duration_year'].'year '.$details['duration_month'].' months';
			$disease_to_date = date('Y-m-d', strtotime($e.$f));
			
			if($details['duration_year'] == 0 && $details['duration_month'] == 0)
			$disease_to_date = $disease_from_date;
			
			if(!empty($details['surgery_date']))
			{
				$surgery_date = date('Y-m-d', strtotime($details['surgery_date']));
			}
			else
			{
				$surgery_date = NULL;
			}
		// conversion ends
		
		$patient_history = array(
			'patient_id'       =>$patient_id,
			'disease'          =>$details['past_disease'],
			'disease_from_date'=>$disease_from_date,
			'disease_to_date'  =>$disease_to_date,
			'disease_details'  =>$details['disease_details'],
			'surgery'          =>$details['surgery_name'],
			'surgery_reason'   =>$details['surgery_reason'],
			'surgery_date'     =>$surgery_date,
			'attachments'      =>''
		);
		$this->db->insert('patient_history', $patient_history);
	}

	function get_patient_details($userid)
	{
		$query = $this->db->get_where('patient', array('user_id'=>$userid));
		if($query->num_rows() >= 1)
		{
			return $query->row();
		}
		else
		{
			return FALSE;
		}
	}
	function get_patient_details_byid($id)
	{
		$query = $this->db->get_where('patient', array('id'=>$id,'status'=>1));
		if($query->num_rows() >= 1)
		{
			return $query->row();
		}
		else
		{
			return FALSE;
		}
	}
	function get_patientid_byuserid($userid)
	{
		$query = $this->db->get_where('patient', array('user_id'=>$userid,'status'=>1));
		if($query->num_rows() >= 1)
		{
			return $query->row('id');
		}
		else
		{
			return FALSE;
		}
	}

	function get_patientid_byemail($email)
	{
		$query = $this->db->get_where('patient', array('email'=>$email,'status'=>1));
		if($query->num_rows() >= 1)
		{
			return $query->row('id');
		}
		else
		{
			return FALSE;
		}
	}
	function update_patient_userid_by_emailid($email,$userid){
		$this->db->where('email', $email);
		$this->db->update('patient', array('user_id'=>$userid));
	}

	function get_patient_list($a=array())
	{
		$this->filterData_active($a);
		$srcArr = array();
		
		if(isset($a['doctor_id']))
		{
			$this->db->where("(apt.doctor_id='".$a['doctor_id']."' OR dpm.doctor_id='".$a['doctor_id']."')", NULL, FALSE);
		}
		if(isset($a['clinic_id']) && !empty($a['clinic_id']))
		{
			$srcArr['apt.clinic_id'] = $a['clinic_id'];
		}
		if(isset($a['patient_name']) && !empty($a['patient_name']))
		{
			$this->db->like('p.name',$a['patient_name']);
		}
		if(isset($a['patient_email']) && !empty($a['patient_email']))
		{
			$srcArr['p.email'] = $a['patient_email'];
		}
		$srcArr['p.status'] = 1;

		$this->db->select('`p`.`id`, `p`.`user_id`, `p`.`name`, `p`.`mobile_number`, `p`.`address`, `p`.`dob`, `p`.`email`, `p`.`gender`, `p`.`image`, 
		`apt`.`clinic_id`, `apt`.`doctor_id` AS `apt_doctor_id`,`dpm`.`doctor_id` AS `dpm_doctor_id`,`p`.`created_on`');
		$this->db->where($srcArr);
		$this->db->from('`patient` as p');
		$this->db->join('`appointment` apt', 'apt.patient_id = p.id','left');
		$this->db->join('`doctor_patient_map` dpm', 'p.id= dpm.patient_id','left');

		$this->db->group_by("p.id");
		$query = $this->db->get();

		if($query->num_rows() >= 1)
		{
			return $query->result_array();
		}
		else
		{
			return FALSE;
		}
	}
	function get_patient_list_count($a=array())
	{

		$this->filterData_active($a);
		$srcArr = array();
		
		if(isset($a['doctor_id']))
		{
			$this->db->where("(apt.doctor_id='".$a['doctor_id']."' OR dpm.doctor_id='".$a['doctor_id']."')", NULL, FALSE);
		}
		if(isset($a['clinic_id']) && !empty($a['clinic_id']))
		{
			$srcArr['apt.clinic_id'] = $a['clinic_id'];
		}
		if(isset($a['patient_name']) && !empty($a['patient_name']))
		{
			$this->db->like('p.name',$a['patient_name']);
		}
		if(isset($a['patient_email']) && !empty($a['patient_email']))
		{
			$srcArr['p.email'] = $a['patient_email'];
		}
		$srcArr['p.status'] = 1;

		$this->db->select('count(*) as num_rows');
		$this->db->where($srcArr);
		$this->db->from('`patient` as p');
		$this->db->join('`appointment` apt', 'apt.patient_id = p.id','left');
		$this->db->join('`doctor_patient_map` dpm', 'p.id= dpm.patient_id','left');

		$this->db->group_by("p.id");

		$query = $this->db->get();

		if($query->num_rows() >= 1)
		{
			return $query->num_rows();
		}
		else
		{
			return FALSE;
		}
	}

	function get_patient_list_without_appt($a=array())
	{
		$this->filterData_active($a);
		$srcArr = array();
		
		if(isset($a['doctor_id']))
		{
			$this->db->where("dpm.doctor_id='".$a['doctor_id']."'", NULL, FALSE);
		}
		if(isset($a['clinic_id']) && !empty($a['clinic_id']))
		{
			$srcArr['apt.clinic_id'] = $a['clinic_id'];
		}
		if(isset($a['patient_name']) && !empty($a['patient_name']))
		{
			$this->db->like('p.name',$a['patient_name']);
		}
		if(isset($a['patient_email']) && !empty($a['patient_email']))
		{
			$srcArr['p.email'] = $a['patient_email'];
		}
		$srcArr['p.status'] = 1;

		$this->db->select('`p`.`id`, `p`.`user_id`, `p`.`name`, `p`.`mobile_number`, `p`.`address`, `p`.`dob`,
		`p`.`email`,`p`.`gender`,`p`.`image`,`p`.`created_on`');
		$this->db->where($srcArr);
		$this->db->from('`patient` as p');
		$this->db->join('`doctor_patient_map` dpm', 'p.id= dpm.patient_id');
		#$this->db->order_by("p.name");
		
		$query = $this->db->get();

		if($query->num_rows() >= 1)
		{
			return $query->result_array();
		}
		else
		{
			return FALSE;
		}
	}
	function get_patient_list_without_appt_count($a=array())
	{
		$this->filterData_active($a);
		$srcArr = array();
		
		if(isset($a['doctor_id']))
		{
			$this->db->where("(dpm.doctor_id='".$a['doctor_id']."')", NULL, FALSE);
		}
		if(isset($a['clinic_id']) && !empty($a['clinic_id']))
		{
			$srcArr['apt.clinic_id'] = $a['clinic_id'];
		}
		if(isset($a['patient_name']) && !empty($a['patient_name']))
		{
			$this->db->like('p.name',$a['patient_name']);
		}
		if(isset($a['patient_email']) && !empty($a['patient_email']))
		{
			$srcArr['p.email'] = $a['patient_email'];
		}
		$srcArr['p.status'] = 1;

		$this->db->select('count(*) as num_rows');
		$this->db->where($srcArr);
		$this->db->from('`patient` as p');
		$this->db->join('`doctor_patient_map` dpm', 'p.id= dpm.patient_id');

		$query = $this->db->get();

		if($query->num_rows() >= 1)
		{
			return $query->num_rows();
		}
		else
		{
			return FALSE;
		}
	}
	
	function get_patient_bmi_details($patient_id)
	{
		$this->db->where('patient_id', $patient_id);
		$this->db->where('status', 1);
		$this->db->order_by('date', 'desc');
		$query = $this->db->get('bmi');
		#echo $this->db->last_query();
		if($query->num_rows() >= 1)
		{
			return $query->result();
		}
		else
		{
			return FALSE;
		}
	}
	
	function get_patient_family_details($patientid)
	{
		$this->db->where('patient_id', $patientid);
		$this->db->where('status', 1);
		$this->db->order_by('id', 'desc');
		$query = $this->db->get('patient_family_detail');
		if($query->num_rows() >= 1)
		{
			return $query->result();
		}
		else
		{
			return FALSE;
		}
	}
	
	function get_patient_past_disease($patientid)
	{
		$this->db->where('patient_id', $patientid);
		$this->db->where('status',1);
		$this->db->order_by('id', 'desc');
		$query = $this->db->get('patient_past_disease');
		if($query->num_rows() >= 1)
		{
			return $query->result();
		}
		else
		{
			return FALSE;
		}
	}
	function get_patient_past_surgery($patientid)
	{
		$this->db->where('patient_id', $patientid);
		$this->db->where('status',1);
		$this->db->order_by('id', 'desc');
		$query = $this->db->get('patient_past_surgery');
		if($query->num_rows() >= 1)
		{
			return $query->result();
		}
		else
		{
			return FALSE;
		}
	}

	function get_patient_medication($patientid)
	{
		$this->db->where('patient_id', $patientid);
		$this->db->where('status',1);
		$this->db->order_by('id', 'desc');
		
		$query = $this->db->get('patient_medication');
		if($query->num_rows() >= 1)
		{
			return $query->result();
		}
		else
		{
			return FALSE;
		}
	}
	function get_patient_allergy($patientid)
	{
		$this->db->where('patient_id', $patientid);
		$this->db->where('status',1);
		$this->db->order_by('id', 'desc');
		$query = $this->db->get('patient_allergic');
		if($query->num_rows() >= 1)
		{
			return $query->result();
		}
		else
		{
			return FALSE;
		}
	}

	function get_patient_reports($patientid)
	{
		$this->db->where('patient_id', $patientid);
		$this->db->where('status',1);
		$this->db->order_by('id', 'desc');
		$query = $this->db->get('patient_report');
		#echo $this->db->last_query();exit;
		if($query->num_rows() >= 1)
		{
			return $query->result();
		}
		else
		{
			return FALSE;
		}
	}

	

	function get_patient_history($userid, $patientid)
	{
		$this->db->where('patient_id', $patientid);
		$this->db->order_by('id', 'desc');
		$query = $this->db->get('patient_history');
		if($query->num_rows() >= 1)
		{
			return $query->row();
		}
		else
		{
			return FALSE;
		}
	}
	function update_patient($details,$patient_id,$user_id='')
	{
		$where_arr	=	 array();
		if(!empty($user_id))
		{
			#$this->db->where('user_id', $user_id);
			$where_arr['user_id']	=	$user_id;
		}

		if(!empty($patient_id))
		{
			$where_arr['id']	=	$patient_id;
		}
		
		#print_r($details);
		if(sizeof($where_arr)>0)
		{
			$this->db->update('patient', $details, $where_arr);
			if($this->db->affected_rows()>0 && $user_id)
			{
				if(isset($details['name']) && !empty($details['name']))$user_details['name']	=	$details['name'];
				if(isset($details['gender']) && !empty($details['gender']))$user_details['gender']	=	$details['gender'];
				if(isset($details['dob']) && !empty($details['dob']))$user_details['dob']	=	$details['dob'];
				if(isset($details['mobile_number']) && !empty($details['mobile_number']))$user_details['contact_number']	=	$details['mobile_number'];
				if(isset($details['image']) && !empty($details['image']))$user_details['image']	=	$details['image'];
				if(isset($user_details) && sizeof($user_details)>0)
				{
					$this->db->update('user',$user_details,array('id'=>$user_id));	
				}
			}
		}

	}
	
	function update_patient_details($details, $user_id, $patient_id)
	{
		//print_r($details);
		$userdetails = $this->user_model->get_all_userdetails($user_id);
		$patient = array(
			'user_id'            =>$user_id,
			'name'               =>$userdetails->name,
			'image'              =>$userdetails->image,
			'blood_group'        =>$details['blood_group'],
			'location_id'        =>$details['locality'],
			'city_id'            =>$details['city'],
			'address'            =>$details['address'],
			'pin_code'           =>$details['pincode'],
			'food_habits'        =>isset($details['food_habits']) ? $details['food_habits'] : NULL,
			'alcohol'            =>isset($details['alcohol']) ? $details['alcohol'] : NULL,
			'smoking'            =>isset($details['smoking']) ? $details['smoking'] : NULL,
			'ciggi_per_day'      =>$details['no_of_cig'],
			'tobacco_consumption'=>isset($details['tobacco']) ? $details['tobacco'] : NULL,
			'allergic'           =>$details['allergic_to'],
			'ongoing_medications'=>$details['ongoing_meditation']
		);
		$this->db->where('id', $patient_id);
		$this->db->update('patient', $patient);
		//echo $this->db->last_query();
//		$patient_id = $this->db->insert_id();

		$bmi        = array(
			'user_id'      =>$user_id,
			'height_feet'  =>$details['height_feet'],
			'height_inches'=>$details['height_inches'],
			'weight'       =>$details['weight'],
			'bmi_value'    =>''
		);
		$this->db->insert('bmi', $bmi);

		$patient_family_detail = array(
			'patient_id' =>$patient_id,
			'disease'    =>$details['disease_name'],
			'member_name'=>implode('#&#', $details['member_name']),
			'summary'    =>$details['detail_info']
		);
		//$this->db->insert('patient_family_detail', $patient_family_detail);
		
		// conversion of disease_from_date and disease_to_date in proper format
			$e = '1-'.$details['incident_month'].'-'.$details['incident_year'];
			$disease_from_date = date('Y-m-d', strtotime($e));
			
			$f = '+'.$details['duration_year'].'year '.$details['duration_month'].' months';
			$disease_to_date = date('Y-m-d', strtotime($e.$f));
			
			if($details['duration_year'] == 0 && $details['duration_month'] == 0)
			$disease_to_date = $disease_from_date;
			
			if(!empty($details['surgery_date']))
			{
				$surgery_date = date('Y-m-d', strtotime($details['surgery_date']));
			}
			else
			{
				$surgery_date = NULL;
			}
		// conversion ends
		
		$patient_history = array(
			'patient_id'       =>$patient_id,
			'disease'          =>$details['past_disease'],
			'disease_from_date'=>$disease_from_date,
			'disease_to_date'  =>$disease_to_date,
			'disease_details'  =>$details['disease_details'],
			'surgery'          =>$details['surgery_name'],
			'surgery_reason'   =>$details['surgery_reason'],
			'surgery_date'     =>$surgery_date,
			'attachments'      =>''
		);
		//$this->db->insert('patient_history', $patient_history);
	}
	function getBlockedAppointmentsByScheduleId($a = array())
	{
		$res = false;$whereArray = array();$appointmentArray = array();
		$this->filterData_active($a);
		$this->db->from('schedule_block as `sb`');
		$whereArray["status"] = 1;
		$whereArray["doctor_id"] = $a['doctor_id'];

		$this->db->where($whereArray);
		$query = $this->db->get();
		if($query->num_rows > 0)
		{
			foreach($query->result_array() as $row)
			{
				$timings = create_date_time_range($row['from_date'],$row['to_date'],$a['duration']." mins");
				if(is_array($timings))
				{
					$appointmentArray = array_merge_recursive($appointmentArray, $timings);
				}
			}
		}

		return $appointmentArray;
	}
	function getDoctorAppointment($a = array())
	{
		$res = false;$whereArray = array();

		$this->filterData_active($a);
		$this->db->from('appointment as `dap`');

		if(!empty($a['doctor_id'])  )
		{
			$whereArray['dap.doctor_id'] = $a['doctor_id'];
		}
		if(!empty($a['date'])  )
		{
			$whereArray['dap.date'] = $a['date'];
		}
		if(!empty($a['date'])  )
		{
			$whereArray['dap.date'] = $a['date'];
		}
		if(!empty($a['start_date']) && !empty($a['end_date']))
		{
			$whereArray['dap.date >='] = $a['start_date'];
			$whereArray['dap.date <='] = $a['end_date'];
		}
		$whereArray['dap.status'] = 1;

		if(!empty($a['time']))
		{
			$whereArray['dap.time'] = $a['time'];
		}
		if(!empty($a['patient_id'])  )
		{
			$whereArray['dap.patient_id'] = $a['patient_id'];
		}
		if(!empty($a['clinic_id'])  )
		{
			$whereArray['dap.clinic_id'] = $a['clinic_id'];
		}
		$this->db->where($whereArray);
		$query = $this->db->get();
		#echo $this->db->last_query();exit;

		if($query->num_rows > 0)
		{
			foreach($query->result_array() as $row)
			{
				$res[date("Y-m-d",strtotime($row['scheduled_time']))][] = date("g:i A",strtotime($row['scheduled_time']));
			}
		}
		return $res;
	}
	
	function getAppointmenByDateAndDoctorId($a = array())
	{
		$appointmentArray	= array();
		$bookedAppoitnemtns = $this->patient_model->getDoctorAppointment(array('column'=>array('dap.time','dap.date','dap.scheduled_time'),
		'doctor_id' =>$a['doctor_id'],'clinic_id' =>$a['clinic_id'],'start_date'=>$a['start_date'],'end_date'  =>$a['end_date'],'orderby'=>'dap.date asc'));

		$blockedAppoitnemtns = $this->patient_model->getBlockedAppointmentsByScheduleId(array('doctor_id'=>$a['doctor_id'],'duration' =>$a['duration']));
		
		if(is_array($blockedAppoitnemtns) && is_array($bookedAppoitnemtns))
		{
			$appointmentArray = array_merge_recursive($blockedAppoitnemtns, $bookedAppoitnemtns);
		}
		else if(is_array($blockedAppoitnemtns))
		{
			$appointmentArray = $blockedAppoitnemtns;
		}
		else if(is_array($bookedAppoitnemtns))
		{
			$appointmentArray = $bookedAppoitnemtns;
		}

		return $appointmentArray;
	}
	
	function __toString(){
		return $this->db->last_query();
	}
	
}