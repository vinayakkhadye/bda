<?php
if(!defined('BASEPATH')) exit('No direct access allowed');

class admindoctor_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	function get_doctors($a = array())
	{
		$res = false; 
		$whereArray = array();

		$this->filterData_active($a);

		if(!empty($a['id']))
		{
			$whereArray['doc.id'] = $a['id'];
		}
		if(!empty($a['name']))
		{
			$whereArray["doc.name"] = $a['name'];
		}
		if(!empty($a['user_id']))
		{
			$whereArray["doc.user_id"] = $a['user_id'];
		}
		
		if(!empty($a['city']))
		{
			$whereArray["clinic.city_id"] = $a['city'];
		}
		
		if(!empty($a['doctor_name']))
		{
			$this->db->like("doc.name",$a['doctor_name'],'both');
		}
		
		if(isset($a['health_utsav']) && strlen($a['health_utsav']) > 0)
		{
			$whereArray['clinic.health_utsav'] = $a['health_utsav'];
		}
		
		if(isset($a['status']) && strlen($a['status']) > 0)
		{
			$whereArray['doc.status'] = $a['status'];
			
		}
		else
		{
			$whereArray['doc.status'] = 1;
		}
		#$whereArray['clinic.status'] = 1; commented for now need to find solution
		#$whereArray['doc.status'] = 1;

		if(!empty($a['featured'])  )
		{
			$whereArray['doc.is_featured'] = $a['featured'];
		}
		if(!empty($a['specialities'])  )
		{
			$this->db->where("FIND_IN_SET('".trim($a['specialities'])."', doc.speciality)");
		}
		if(!empty($a['locality'])  )
		{
			$whereArray['clinic.location_id'] = $a['locality'];
		}
		if(!empty($a['city_id'])  )
		{
			$whereArray['doc.city_id'] = $a['city_id'];
		}
		if(!empty($a['qualification'])  )
		{
			$this->db->where("FIND_IN_SET('".trim($a['qualification'])."', doc.qualification)");
		}
		if(!empty($a['qualification_exact'])  )
		{
			$whereArray['doc.qualification'] = $a['qualification_exact'];
		}
		if(!empty($a['speciality'])  )
		{
			$whereArray['doc.speciality'] = $a['speciality'];
		}
		
		if(!empty($a['sort_by'])  )
		{
				if ($a['sort_by'] == "doc.site")
				{
					$sort_by = "doc.`sponsored` DESC, doc.`paid` DESC, doc.`sort` DESC, doc.`image` DESC, doc.`is_ver_reg` DESC";
					$asc_desc = '';
				}
				else
				{
				    $sort_by = $a['sort_by'];

						if(!empty($a['asc_desc'])  )
						{
						$asc_desc = $a['asc_desc'];
						}
						else
						{
						$asc_desc = 'desc';
						}

				} 
		}
		else
		{
			$sort_by = 'doc.updated_on desc, doc.created_on';
			$asc_desc = '';
		}
		
		
		#$this->db->select("doc.id, doc.user_id, doc.name, doc.status, doc.speciality, doc.qualification, doc.status, speciality.name as speciality_name, qualification.name as qualification_name, city.name as city_name, (SELECT GROUP_CONCAT(NAME SEPARATOR ', ') FROM speciality WHERE FIND_IN_SET(id, doc.speciality)) AS spec, (SELECT GROUP_CONCAT(NAME SEPARATOR ', ') FROM qualification WHERE FIND_IN_SET(id, doc.qualification)) AS qual,COUNT(clinic.id) AS clinic_count, user.created_on, fb_user.facebook_id", FALSE);
		$this->db->select("doc.id, doc.user_id, doc.name, doc.status, doc.speciality, doc.qualification, doc.status,clinic.city_id,COUNT(clinic.id) AS clinic_count, doc.created_on", FALSE);#,fb_user.facebook_id
		
		$this->db->from('doctor as `doc`');
		
		#$this->db->join('speciality','doc.speciality = speciality.id','left');
		#$this->db->join('qualification','doc.qualification = qualification.id','left');
		$this->db->join('clinic','doc.id = clinic.doctor_id and clinic.status=1','left');#
		#$this->db->join('city','clinic.city_id = city.id','left');
		#$this->db->join('user','user.id = doc.user_id', 'left');
		#$this->db->join('fb_user','user.id = fb_user.user_id', 'left');
		
		$this->db->where($whereArray);
		
		$this->db->group_by('doc.id');
		
		$this->db->order_by($sort_by, $asc_desc);
		
		// Clone the query for counting number of records
		$tempdb = clone $this->db;
		
		$query = $this->db->get();
		if(isset($_GET['t']))
		{
			echo $this->db->last_query();exit;
		}
		
		
		// Count number of rows
		#$tempdb->limit(1569325056);
		$this->row_count = "1569325056";#$tempdb->get()->num_rows();
		$arr = array();
		if($query->num_rows() >= 1){
			$res = $query->result();
			$arr = array();
			foreach($res as $row)
			{
				#$row->approval_in_progress = $this->check_if_approval_in_progress($row->id);
				$arr[] = $row;
			}
		}
		return json_decode(json_encode($arr));
	}
	
	function check_if_approval_in_progress($doctor_id)
	{
		$this->db->select('count(*) as count');
		$this->db->from('checklist_entry');
		$this->db->where('doctor_id', $doctor_id);
		$this->db->where('status', '1');
		$this->db->where('category', 'doctor_approve');
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			$qr = $query->row();
			if($qr->count > 0)
			return 1;
			else
			return 0;
		}
	}
	function update_doctor_status($status,$ids)
	{
		if(is_array($ids))
		{
			$this->db->where_in('id', $ids); //$ids should be an array
			$update = array('status'=> $status);
			if($status	==	1)
			{
				$update['is_ver_reg']	=	2;
			}
			$this->db->update('doctor',$update);
			if($this->db->affected_rows() > 0)
			{
				$this->autoapprove_trial_package($ids);
				return true;
			}
			else
			{
				return false;
			}
		}
		return false;
	}
	
	function get_patient_reviews($doctor_id)
	{
		$query = $this->db->get_where('doctor_patient_review_detail', array('doctor_id'=>$doctor_id));
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return FALSE;
		}
	}
	function add_speciality_city_mapping($speciality_id,$city_id)
	{
		if(is_array($speciality_id) && sizeof($speciality_id)>0)
		{
			foreach($speciality_id as $key=>$val)
			{
				$a	= array('speciality_id'=>$val,'city_id'=>$city_id);
				$insert_query = $this->db->insert_string('speciality_city_map',$a);
				$insert_query = str_replace('INSERT INTO','INSERT IGNORE INTO',$insert_query);
				$rs           = $this->db->query($insert_query);
			}
		}
	}
	function get_user_detail_by_user_id($user_id)
	{
		$this->db->from('user');
		$this->db->where('id', $user_id);
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			return $query->row();
		}
		else
		{
			return FALSE;
		}
	}
	
	function insert_reviews($postdata, $doctor_id)
	{
		$data = array(
			'doctor_id'=>	$doctor_id,
			'name'     =>	$postdata['rname'],
			'email'    =>	$postdata['remail'],
			'comment'  =>	$postdata['rcomment'],
			'rating'   =>	$postdata['rrating'],
			'status'   =>	0,
			'added_on' =>	date('Y-m-d h:i:s')
		);
		$this->db->insert('reviews', $data);
	}
	
	function update_reviewed($postdata)
	{
		$data = array(
			'reviewed'  =>	1,
			'updated_on'=>	date('Y-m-d h:i:s')
		);
		$this->db->where('id', $postdata['rid']);
		$this->db->update('doctor_patient_review_detail', $data);
	}
	
	function autoapprove_trial_package($ids)
	{
		foreach($ids as $doctor_id)
		{
			$user_details = $this->get_doctor_userid($doctor_id);
			// check if trial package request is pending
			$this->db->from('package_registration');
			$this->db->where('user_id', $user_details);
			$this->db->where('package_id', '100');
			$this->db->where('status', '0');
			$qry = $this->db->get();
			if($qry->num_rows() > 0)
			{
				$result = $qry->row();
				$data = array(
					'start_date'	=>	date('Y-m-d'),
					'end_date'		=>	date('Y-m-d', strtotime("+7 days")),
					'status'		=>	'1'
				);
				$this->db->where('user_id', $user_details);
				$this->db->where('package_id', '100');
				$this->db->where('status', '0');
				$this->db->update('package_registration', $data);
			}
		}
//		exit;
	}
	
	function get_doctor_userid($doctor_id)
	{
		$this->db->select('user_id');
		$this->db->from('doctor');
		$this->db->where('id', $doctor_id);
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			$res = $query->row();
			return $res->user_id;
		}
		else
		{
			return FALSE;
		}
	}
	
	function get_doctor_userimage($userid)
	{
		$this->db->select('image');
		$this->db->from('user');
		$this->db->where('id', $userid);
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			$res = $query->row();
			return $res->image;
		}
		else
		{
			return FALSE;
		}
	}
	
	function get_all_doctor_details($doctorid)
	{
		$this->load->model('admin/adminpackages_model');
		$this->db->select('d.name,d.user_id,u.email_id,u.contact_number as user_contact_number,d.contact_number as doc_contact_number,u.dob,
		u.gender as user_gender, d.gender doc_gender, c.name as council_name, d.id as doctor_id, d.name as name, d.contact_number as doc_contact_number,`d`.`image` AS doc_image,d.speciality,d.other_speciality,d.qualification,d.other_qualification,d.yoe,d.reg_no,d.council_id,d.summary, d.sponsored, d.paid, d.sort, d.health_utsav');
		
		$this->db->from('doctor as d');
		$this->db->join('user as u', 'd.user_id=u.id','left');
		$this->db->join('speciality as s','d.speciality = s.id','left');
		$this->db->join('qualification as q','d.qualification = q.id','left');
		$this->db->join('council as c','d.council_id = c.id','left');
		$this->db->where('d.id', $doctorid);
		$query = $this->db->get();

		// print_r($this->db->last_query());

		$result = $query->row_array();
		//Get qualification names and add to the final array
		if(isset($result['qualification']) && !empty($result['qualification']))
		{
			$qualifications = $this->get_qualifications($result['qualification']);
			if($qualifications !== FALSE)
			{
				$temp = array();
				foreach($qualifications as $row)
				{
					array_push($temp, $row['qualification_name']);
				}
				$result['qualification_name'] = $temp;
				unset($temp);
			}
		}

		//Get speciality names and add to the final array
		if(isset($result['speciality']) && !empty($result['speciality']))
		{
			$speciality = $this->get_speciality($result['speciality']);
			if($speciality !== FALSE)
			{
				$temp = array();
				foreach($speciality as $row)
				{
					array_push($temp, $row['speciality_name']);
				}
				$result['speciality_name'] = $temp;
				unset($temp);
			}
		}
		// Get user id of doctor
		$result['userid'] = $this->get_doctor_userid($doctorid);
		if($result['userid'] === FALSE)
		{
			$result['userid'] = NULL;
		}
		
		// Insert doctor in result array
		$result['doctor_id'] = $doctorid;
		
		// Get image of doctor
		if(!empty($result['userid']))
		{
			$result['userimage'] = $this->get_doctor_userimage($result['userid']);
		}
		else
		{
			$result['userimage'] = NULL;
		}
		
		// Check for google or facebook id linking
		if(!empty($result['userid']))
		{
			$fb_check = $this->check_fb_linked($result['userid']);
			if($fb_check !== FALSE)
			{
				$result['fbid'] = $fb_check;
			}
		}
		else
		{
			$result['fbid'] = NULL;
		}
		/*$google_check = $this->check_google_linked($result['userid']);
		if($google_check !== FALSE)
		{
			$result['googleid'] = $google_check;
		}*/
		
		// Get all user packages
		if(!empty($result['userid']))
		{
			$packages = $this->adminpackages_model->get_user_packages($result['userid']);
			if($packages !== FALSE)
			{
				$result['packages'] = $packages;
			}
			else
			{
				$result['packages'] = NULL;
			}
		}
		else
		{
			$result['packages'] = NULL;
		}

		// Get all doctor clinic
		$clinics = $this->get_doctor_clinics($doctorid);
		if($clinics !== FALSE)
		{
			$result['clinics'] = $clinics;
		}
		else
		{
			$result['clinics'] = NULL;
		}
		
		// Check if the doctor has the privilege of filling up additional details
		// $check_sor_eligible = $this->doctor_model->check_sor_eligibility($result['user_id']);
		// if($check_sor_eligible === TRUE)
		// {
			$result['check_sor_eligible'] = 1;
		// 	//Get doctor additional details
		// 	$result['additional_details'] = $this->doctor_model->getDoctorDetail($a = array("doctor_id"=>$result['doctor_id'],"limit"=>1000));
		// }
		// else
		// {
		// 	$result['check_sor_eligible'] = 0;
		// }
		return $result;
	}
	
	function get_doctor_clinics($doctorid)
	{
		$this->db->select('clinic.*, city.name as city');
		$this->db->from('clinic');
		$this->db->join('city','clinic.city_id = city.id');
		$this->db->where('clinic.doctor_id', $doctorid);
		$this->db->where('clinic.status', '1');
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			return $result = $query->result_array();
		}
		else
		{
			return FALSE;
		}
	}
	
	function check_fb_linked($userid)
	{
		$query = $this->db->get_where('fb_user', array('user_id' => $userid));
		if($query->num_rows() > 0)
		{
			$result = $query->row();
			return $result->facebook_id;
		}
		else
		{
			return FALSE;
		}
	}
	
	function check_google_linked($userid)
	{
		$query = $this->db->get_where('google_user', array('user_id' => $userid));
		if($query->num_rows() > 0)
		{
			$result = $query->row();
			return $result->google_id;
		}
		else
		{
			return FALSE;
		}
	}
	
	function get_doctor_extra_details($doctor_id)
	{
		$this->db->from('doctor_detail');
		$this->db->where('doctor_id', $doctor_id);
		$this->db->order_by('sort','asc');
		$query = $this->db->get();
//		echo $this->db->last_query();
//		echo $query->num_rows();exit;
		if($query->num_rows() > 0)
		{
			return $rs = $query->result_array();
		}
		else
		{
			return FALSE;
		}
	}
	
	function get_qualifications($qualifications)
	{
		$qualifications = trim($qualifications,',');
		$where = "id in ($qualifications)";
//		$this->db->_protect_identifiers = FALSE;
		$this->db->select('name as qualification_name');
		$this->db->from('qualification');
		$this->db->where($where);
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			return $query = $query->result_array();
		}
		else
		{
			return FALSE;
		}
	}
	
	function get_speciality_master()
	{
		$this->db->from('speciality');
		$this->db->order_by('name', 'asc');
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			return $query = $query->result();
		}
		else
		{
			return FALSE;
		}
	}
	
	function get_speciality($speciality)
	{
		$speciality = trim($speciality,',');
		$where = "id in ($speciality)";
//		$this->db->_protect_identifiers = FALSE;
		$this->db->select('name as speciality_name');
		$this->db->from('speciality');
		$this->db->where($where);
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			return $query = $query->result_array();
		}
		else
		{
			return FALSE;
		}
	}
	
	function get_doctor_speciality_bydocid($doctorid)
	{
		$this->db->select('speciality,other_speciality');
		$this->db->from('doctor');
		$this->db->where('id', $doctorid);
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			$rs = $query->row_array();
			$rs['speciality'] = $this->get_speciality($rs['speciality']);
			return $rs;
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

	function get_doctor_clinics_by_doctorid($doctorid)
	{
		$this->db->select('clinic.id, clinic.name, clinic.doctor_id, doctor.name as doctor_name');
		$this->db->from('clinic');
		$this->db->join('doctor', 'doctor.id = clinic.doctor_id');
		$this->db->where('clinic.doctor_id', $doctorid);
		$this->db->where('clinic.status', '1');
		$query = $this->db->get();
		//echo $this->db->last_query();
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return FALSE;
		}
	}

	function get_doctor_name_byid($doctorid)
	{
		$this->db->select('name');
		$this->db->from('doctor');
		$this->db->where('id', $doctorid);
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			$rs = $query->row();
			return $rs;
		}
		else
		{
			return FALSE;
		}
	}

	function get_clinic_details_byid($clinicid)
	{
		$this->db->select('clinic.city_id, clinic.address, clinic.name, clinic.city_id, clinic.contact_number, clinic.id, city.name as city');
		$this->db->from('clinic');
		$this->db->join('city','clinic.city_id = city.id');
		$this->db->where('clinic.id', $clinicid);
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			return $result = $query->result_array();
		}
		else
		{
			return FALSE;
		}
	}

	function update_doctor_details_nonbda($post, $filename_path, $doctor_id)
	{
		if(isset($post['speciality']))
		{
			ksort($post['speciality']);
			$speciality = NULL;
			foreach($post['speciality'] as $spec)
			{
				if(!empty($spec))
				$speciality .= $spec.',';
			}
			$speciality = trim($speciality,",");
		}
		else
		{
			$speciality = NULL;
		}
		
		if(isset($post['speciality_other']))
		{
			ksort($post['speciality_other']);
			$speciality_other = NULL;
			foreach($post['speciality_other'] as $spec_oth)
			{
				if(!empty($spec_oth))
				$speciality_other .= $spec_oth.',';
			}
			$speciality_other = trim($speciality_other,",");
		}
		else
		{
			$speciality_other = NULL;
		}

		if(isset($post['specialization']))
		{
			ksort($post['specialization']);
			$specialization = NULL;
			foreach($post['specialization'] as $spez)
			{
				if(!empty($spez))
				$specialization .= $spez.',';
			}
			$specialization = trim($specialization,",");
		}
		else
		{
			$specialization = NULL;
		}
		
		if(isset($post['specialization_other']))
		{
			ksort($post['specialization_other']);
			$specialization_other = NULL;
			foreach($post['specialization_other'] as $spez_oth)
			{
				if(!empty($spez_oth))
				$specialization_other .= $spez_oth.',';
			}
			$specialization_other = trim($specialization_other,",");
		}
		else
		{
			$specialization_other = NULL;
		}

		if(isset($post['degree']))
		{
			ksort($post['degree']);
			$degree = NULL;
			foreach($post['degree'] as $deg)
			{
				if(!empty($deg))
				$degree .= $deg.',';
			}
			$degree = trim($degree,",");
		}
		else
		{
			$degree = NULL;
		}

		if(isset($post['degree_other']))
		{
			ksort($post['degree_other']);
			$degree_other = NULL;
			foreach($post['degree_other'] as $deg_oth)
			{
				if(!empty($deg_oth))
				$degree_other .= $deg_oth.',';
			}
			$degree_other = trim($degree_other,",");
		}
		else
		{
			$degree_other = NULL;
		}
		
		$sponsored	=	 999;
		if(isset($post['sponsored']) && !empty($post['sponsored']))
		{
			$sponsored = intval($post['sponsored']);
		}

		$paid 			= 999;
		if(isset($post['paid']) && !empty($post['paid']))
		{
			$paid = intval($post['paid']);
		}
		
		$sort 			= 999;
		if(isset($post['sort']) && !empty($post['sort']))
		{
			$sort = intval($post['sort']);
		}

		if($filename_path == NULL)
		{
			$data = array(
				'name'               	=>	$post['name'],
				'gender'             	=>	(isset($post['gender']) && !empty($post['gender']))?$post['gender']:'',
				'reg_no'             	=>	(isset($post['regno']) && !empty($post['regno']))?$post['regno']:'',
				'council_id'         	=>	(isset($post['council']) && !empty($post['council']))?$post['council']:'',
				'speciality'         	=>	$speciality,
				'other_speciality'   	=>	$speciality_other,
				'qualification'      	=>	$degree,
				'other_qualification'	=>	$degree_other,
				'contact_number'     	=>	(isset($post['mob']) && !empty($post['mob']))?$post['mob']:'',
				'yoe'					=>	!empty($post['yoe']) ? $post['yoe'] : NULL,
				'updated_on'         	=>	date('Y-m-d h:i:s'),
				'sponsored'				=> $sponsored,
				'paid'					=> $paid,
				'sort'					=> $sort
			);
		}
		else
		{
			$data = array(
				'name'               =>	$post['name'],
				'gender'             =>	(isset($post['gender']) && !empty($post['gender']))?$post['gender']:'',
				'reg_no'             =>	(isset($post['regno']) && !empty($post['regno']))?$post['regno']:'',
				'council_id'         =>	(isset($post['council']) && !empty($post['council']))?$post['council']:'',
				'speciality'         =>	$speciality,
				'other_speciality'   =>	$speciality_other,
				'qualification'      =>	$degree,
				'other_qualification'=>	$degree_other,
				'image'              =>	$filename_path,
				'contact_number'     =>	(isset($post['mob']) && !empty($post['mob']))?$post['mob']:'',
				'yoe'    			 =>	!empty($post['yoe']) ? $post['yoe'] : NULL,
				'updated_on'         =>	date('Y-m-d h:i:s'),
				'sponsored'			 => $sponsored,
				'paid'				 => $paid,
				'sort'				 => $sort
			);			
		}
		$this->db->where('id', $doctor_id);
		$this->db->update('doctor', $data);
		#echo $this->db->last_query();exit;
	}

	function get_doc_reginfo($doctor_id)
	{
		$this->db->select('id,name,image,gender,contact_number');
		$this->db->from('doctor');
		$this->db->where('id', $doctor_id);
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			return $query->row_array();
		}
		else
		{
			return FALSE;
		}
	}
	
	function create_account($data, $filename)
	{
		$password = md5($data["pass"]);

		$data_n = array(
			'name'          => $data["name"],
			'email_id'      => $data["email"],
			'password'      => $password,
			'contact_number'=> ($data["mob"])?$data["mob"]:NULL,
			'gender'        => $data["gender"],
			'dob'           => date('Y-m-d', strtotime($data["dob"])),
			'image'         => $filename,
			'type'          => '2',
			'is_verified'   => '1',
		);
		$this->db->insert('user' , $data_n);
		$insertid = $this->db->insert_id();
		//$this->mail_model->welcome_doctor($data["email"], $data["name"]);
		//$this->sendsms_model->send_welcome_sms_doctor($data["mob"]);
		$this->load->model('doctor_model');
		$this->doctor_model->add_package($insertid);

		$packageid	=	 20;
		$this->doctor_model->update_doctor_package($insertid, $packageid, 0);

		#$packageid	=	20;
		#$this->doctor_model->insert_package($insertid, $packageid, 0, 0);#this we have changed to because we want doctor to get directly Smart Online Reputation Package

		#echo $this->db->last_query();
		return $insertid;
	}
	
	function update_doctor_userid($id, $doctor_id,$a=array(),$image='')
	{
		$data = array(
			'user_id'     	   =>	$id,
			'created_on'       =>	date('Y-m-d h:i:s'),
			'updated_on'       =>	date('Y-m-d h:i:s')
		);
		if(sizeof($a)>0)
		{
			if(isset($a['name']) && !empty($a['name'])){$data['name']	=	$a['name'];}
			if(isset($a['mob']) && !empty($a['mob'])){$data['contact_number']	=	$a['mob'];}
			if(isset($a['gender']) && !empty($a['gender'])){$data['gender']	=	$a['gender'];}
			if(isset($image) && !empty($image)){$data['image']	=	$image;}
		}
		$this->db->where('id', $doctor_id);
		$this->db->update('doctor', $data);
	}
	function create_doctor_entry($postdata ,$filename_path,$userid)
	{
		$data = array(
			'user_id'       =>	$userid,
			'name'          =>	$postdata['name'],
			'gender'        =>	$postdata['gender'],
			'image'         =>	$filename_path,
			'contact_number'=>	$postdata['mob'],
			'created_on'    =>	date('Y-m-d h:i:s')
		);
		$this->db->insert('doctor', $data);
		//echo $this->db->last_query();
		$doctor_id = $this->db->insert_id();
		return $doctor_id;
	}
	function set_doctor_pending($id, $doctor_id)
	{
		$data = array(
			'status'     	   =>	0,
			'updated_on'       =>	date('Y-m-d H:i:s')
		);
		$this->db->where('id', $doctor_id);
		$this->db->update('doctor', $data);
	}

	function get_clinic_details($clinic_id)
	{
		$this->db->from('clinic');
		$this->db->where('id', $clinic_id);
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			return $query->row_array();
		}
		else
		{
			return FALSE;
		}
	}
	
	function get_doctor_data($doctor_id)
	{
		$query = $this->db->get_where('doctor', array('id'=> $doctor_id), 1);
		if($query->num_rows() >= 1)
		{
			return $query->row();
		}
		else
		{
			return FALSE;
		}
	}
	
	function update_clinic_details($clinic_id, $postdata)
	{
		$data = array(
			'name'             =>	empty($postdata['name']) ? '' : $postdata['name'],
			'location_id'      =>	isset($postdata['locality']) && !empty($postdata['locality']) ? $postdata['locality'] : '',
			'other_location'   =>	isset($postdata['other_locality']) && !empty($postdata['other_locality']) ? $postdata['other_locality'] : '',
			'city_id'          =>	empty($postdata['city']) ? '' : $postdata['city'],
			'address'          =>	empty($postdata['address']) ? '' : $postdata['address'],
			'contact_number'   =>	empty($postdata['contact_number']) ? '' : $postdata['contact_number'],
			'pincode'          =>	empty($postdata['pincode']) ? '' : $postdata['pincode'],
			'duration'         =>	empty($postdata['avg_patient_duration']) ? '' : $postdata['avg_patient_duration'],
			'consultation_fees'=>	empty($postdata['consult_fee']) ? '' : $postdata['consult_fee'],
			'tele_fees'        =>	empty($postdata['tele_fees']) ? '' : $postdata['tele_fees'],
			'online_fees'      =>	empty($postdata['online_fees']) ? '' : $postdata['online_fees'],
			'express_fees'     =>	empty($postdata['express_fees']) ? '' : $postdata['express_fees'],
			'updated_on'       =>	date('Y-m-d h:i:s')
		);
		$this->db->where('id', $clinic_id);
		$this->db->update('clinic', $data);
		//echo $this->db->last_query();
	}
	
	function delete_clinic($clinic_id)
	{
		$data = array(
			'status'     		=>	'0',
			'updated_on'       =>	date('Y-m-d h:i:s')
		);
		$this->db->where('id', $clinic_id);
		$this->db->update('clinic', $data);
		return $this->db->affected_rows();
	}
	
	function insert_clinic($doctorid, $post)
	{
		$this->load->model('sendsms_model');
		$timings = json_encode(array(
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
		
		if(!empty($post['latlong']))
		{
			$latlong = explode(',', $post['latlong']);
		}
			
		$data = array(
			'name'             =>	$post['clinic_name'],
			'address'          =>	$post['clinic_address'],
			'location_id'      =>	isset($post['locality']) ? $post['locality'] : '0',
			'other_location'   =>	isset($post['other_locality']) ? $post['other_locality'] : NULL,
			'city_id'          =>	$post['city'],
			'pincode'          =>	$post['pincode'],
			'contact_number'   =>	$post['clinic_number'],
			'doctor_id'        =>	$doctorid,
			'timings'          =>	$timings,
			'duration'         =>	$post['avg_patient_duration'],
			'consultation_fees'=>	!empty($post['consult_fee']) ? $post['consult_fee'] : NULL,
			'tele_fees'        =>	!empty($post['tele_fees']) ? $post['tele_fees'] : '0',
			'online_fees'      =>	!empty($post['online_fees']) ? $post['online_fees'] : '0',
			'express_fees'     =>	!empty($post['express_fees']) ? $post['express_fees'] : '0',
			'is_number_verified'=>	empty($post['is_number_verified']) ? 0 : $post['is_number_verified'],
			'longitude'  	   =>	isset($latlong[1]) ? $latlong[1] : NULL,
			'latitude' 	   =>	isset($latlong[0]) ? $latlong[0] : NULL
		);

		$this->db->insert('clinic', $data);
		$clinicid = $this->db->insert_id();

		if(
		(isset($post['clinicphotoname1']) && !empty($post['clinicphotoname1'])) ||
		(isset($post['clinicphotoname2']) && !empty($post['clinicphotoname2'])) ||
		(isset($post['clinicphotoname3']) && !empty($post['clinicphotoname3'])) ||
		(isset($post['clinicphotoname4']) && !empty($post['clinicphotoname4'])) ||
		(isset($post['clinicphotoname5']) && !empty($post['clinicphotoname5']))
		)
		{
			$img1 = $post['clinicphotoimg1'];
			$img2 = $post['clinicphotoimg2'];
			$img3 = $post['clinicphotoimg3'];
			$img4 = $post['clinicphotoimg4'];
			$img5 = $post['clinicphotoimg5'];
			
			$this->insert_clinic_photos($post,$clinicid,$doctorid);
		}
		return $clinicid;
	}
	
	function insert_clinic_photos($post, $clinicid, $doctorid)
	{
		$img1 = $post['clinicphotoimg1'];
		$imgname1 = $post['clinicphotoname1'];
		$img2 = $post['clinicphotoimg2'];
		$imgname2 = $post['clinicphotoname2'];
		$img3 = $post['clinicphotoimg3'];
		$imgname3 = $post['clinicphotoname3'];
		$img4 = $post['clinicphotoimg4'];
		$imgname4 = $post['clinicphotoname4'];
		$img5 = $post['clinicphotoimg5'];
		$imgname5 = $post['clinicphotoname5'];
				
		if((!empty($imgname1)) || (!empty($imgname2)) || (!empty($imgname3)) || (!empty($imgname4)) || (!empty($imgname5)))
		{
			$structure = "./media/photos/".date('M').date('Y')."/".substr($clinicid,0,2);
			if(!is_dir($structure))
			{
				mkdir($structure, 0777);
			}
			$photodata=array();
			$photodata[1]['name'] = $imgname1;
			$photodata[1]['image'] = $img1;
			$photodata[2]['name'] = $imgname2;
			$photodata[2]['image'] = $img2;
			$photodata[3]['name'] = $imgname3;
			$photodata[3]['image'] = $img3;
			$photodata[4]['name'] = $imgname4;
			$photodata[4]['image'] = $img4;
			$photodata[5]['name'] = $imgname5;
			$photodata[5]['image'] = $img5;
			$images = NULL;
			#print_r($photodata);exit;
			foreach($photodata as $photos)
			{
				$newfilename = $photos['name'];
				if(!empty($newfilename))
				{
					$filename      = md5($newfilename);
					$ext           = pathinfo($newfilename, PATHINFO_EXTENSION);
					$filename_path = $structure."/".$filename.".".$ext;
					$decoded_pic   = base64_decode($photos['image']);
					file_put_contents($filename_path, $decoded_pic);
				
					$images.=$filename_path.',';
				}
				else
				{
					$images.=',';
				}
			}
			$imagefinal = trim($images);
			$imagedata = array(
			'image'          =>	$imagefinal
			);

			$this->db->where('id', $clinicid);
			$this->db->where('doctor_id', $doctorid);
			$this->db->update('clinic', $imagedata);
			#echo $this->db->last_query();exit;
		}
	}

	function update_clinic($doctorid, $clinicid, $post)
	{
		$timings = json_encode(array(
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
				),
			));
			
		if(!empty($post['latlong']))
		{
			$latlong = explode(',', $post['latlong']);
		}
		
		$data = array(
			'name'             =>	$post['clinic_name'],
			'address'          =>	$post['clinic_address'],
			'location_id'      =>	isset($post['locality']) ? $post['locality'] : '0',
			'other_location'   =>	isset($post['other_locality']) ? $post['other_locality'] : NULL,
			'city_id'          =>	$post['city'],
			'pincode'          =>	$post['pincode'],
			'contact_number'   =>	$post['clinic_number'],
			'timings'          =>	$timings,
			'duration'         =>	$post['avg_patient_duration'],
			'consultation_fees'=>	!empty($post['consult_fee']) ? $post['consult_fee'] : NULL,
			'tele_fees'        =>	!empty($post['tele_fees']) ? $post['tele_fees'] : '0',
			'online_fees'      =>	!empty($post['online_fees']) ? $post['online_fees'] : '0',
			'express_fees'     =>	!empty($post['express_fees']) ? $post['express_fees'] : '0',
			'updated_on'       =>	date('Y-m-d h:i:s'),
			'is_number_verified'=>	empty($post['is_number_verified']) ? 0 : $post['is_number_verified'],
			'longitude'  		   	=>	isset($latlong[1]) ? $latlong[1] : NULL,
			'latitude' 	 	  		=>	isset($latlong[0]) ? $latlong[0] : NULL,
			'health_utsav'     =>	empty($post['health_utsav']) ? NULL : $post['health_utsav'],
			'health_utsav_place'	=>	empty($post['health_utsav_place']) ? NULL : $post['health_utsav_place']
		);
		$this->db->where('id', $clinicid);
		$this->db->where('doctor_id', $doctorid);
		$this->db->update('clinic', $data);
		if(
		(isset($post['clinicphotoname1']) && !empty($post['clinicphotoname1'])) ||
		(isset($post['clinicphotoname2']) && !empty($post['clinicphotoname2'])) ||
		(isset($post['clinicphotoname3']) && !empty($post['clinicphotoname3'])) ||
		(isset($post['clinicphotoname4']) && !empty($post['clinicphotoname4'])) ||
		(isset($post['clinicphotoname5']) && !empty($post['clinicphotoname5']))
		)
		{
			$img1 = $post['clinicphotoimg1'];
			$img2 = $post['clinicphotoimg2'];
			$img3 = $post['clinicphotoimg3'];
			$img4 = $post['clinicphotoimg4'];
			$img5 = $post['clinicphotoimg5'];
			
			$this->insert_clinic_photos($post,$clinicid,$doctorid);
		}
	}

	
	function insert_review($doctorid, $message, $rating, $name, $email, $status = 0)
	{
		$data = array(
			'doctor_id'=>	$doctorid,
			'name'     =>	$name,
			'email'    =>	$email,
			'comment'  =>	urldecode($message),
			'rating'   =>	$rating,
			'status'   =>	$status
		);
		$this->db->insert('reviews', $data);
	}
	
	function get_checklist($category)
	{
		$this->db->from('checklist');
		$this->db->where('status', 1);
		$this->db->where('category', $category);
		$this->db->order_by('type', 'asc');
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return FALSE;
		}
	}
	
	function get_checklistenrty($doctor_id, $checklist_id)
	{
		$where = "(SELECT MAX(updated_on) FROM checklist_entry WHERE checklist_id = '".$checklist_id."' AND doctor_id	= '".$doctor_id."' AND STATUS=1)";
		$this->db->from('checklist_entry');
		$this->db->where('status', 1);
		$this->db->where('doctor_id', $doctor_id);
		$this->db->where('checklist_id', $checklist_id);
		$this->db->where('updated_on =', $where, false);
		$this->db->group_by('checklist_id');
//		$this->db->limit(1,0);
		$query = $this->db->get();
//		echo $this->db->last_query();
		if($query->num_rows() > 0)
		{
			return $query->row();
		}
		else
		{
			return FALSE;
		}
	}
	
	function insert_checklist_entry($category, $value, $comment, $type, $checklist_id, $doctor_id)
	{
		$data = array(
			'category'    =>	$category,
			'doctor_id'   =>	$doctor_id,
			'value'       =>	$value,
			'comment'     =>	$comment,
			'type'        =>	$type,
			'checklist_id'=>	$checklist_id,
			'added_by'    =>$this->session->userdata('admin_name'),
			'updated_by'  =>$this->session->userdata('admin_name'),
			'updated_on'  =>date('Y-m-d h:i:s'),
			'added_on'    =>date('Y-m-d h:i:s')
		);
		$this->db->insert('checklist_entry', $data);
		return ($this->db->affected_rows() >= 1) ? true : false;
		
	}
	
	function get_all_specialities()
	{
		$this->db->from('speciality');
		$this->db->where('status <>', '0');
		$this->db->order_by('name', 'asc');
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return FALSE;
		}
	}

	function get_specialities_name()
	{
		$this->db->select('id,name');
		$this->db->from('speciality');
		$this->db->where_in('status', array(1,2));
		$this->db->order_by('name', 'asc');
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			$data	=	$query->result_array();
			foreach($data as $row)
			{
				$row_data[$row['id']]	=	$row;
			}
			return $row_data;
		}
		else
		{
			return FALSE;
		}
	}	

	function get_qualification_name()
	{
		$this->db->select('id,name');
		$this->db->from('qualification');
		$this->db->where('status', 1);
		$this->db->order_by('name', 'asc');
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			$data	=	$query->result_array();
			foreach($data as $row)
			{
				$row_data[$row['id']]	=	$row;
			}
			return $row_data;
		}
		else
		{
			return FALSE;
		}
	}	

	function get_all_doctors($name)
	{
		$this->db->select('doctor.name,doctor.id,doctor.status');
		$this->db->from('doctor');
//		$this->db->where('status', '1');
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			return $query->result_array();
		}
		else
		{
			return FALSE;
		}
	}
	
	function update_duplicates($similardocids)
	{
		$docid = $similardocids[0];
		foreach($similardocids as $row)
		{
			$data = array(
				'duplicate'        =>	$docid,
				'updated_on'       =>	date('Y-m-d h:i:s')
			);
			$this->db->where('id', $row);
			$this->db->update('doctor', $data);;
		}
	}
	
	function get_duplicates_list()
	{
		$this->db->select('doctor.name,doctor.id,doctor.status,doctor.duplicate');
		$this->db->from('doctor');
		$this->db->where('duplicate IS NOT NULL', '', FALSE);
		$this->db->order_by('duplicate', 'asc');
		$this->db->order_by('updated_on', 'desc');
		$query = $this->db->get();
//		echo $this->db->last_query();
		if($query->num_rows() > 0)
		{
			return $query->result_array();
		}
		else
		{
			return FALSE;
		}
	}
	
	function remove_duplicates($duplicate_id)
	{
		$data = array(
			'duplicate'    	   =>	NULL,
			'updated_on'       =>	date('Y-m-d h:i:s')
		);
		$this->db->where('duplicate', $duplicate_id);
		$this->db->update('doctor', $data);
	}
	
}