<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');

class doctor_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->model(array('user_model','sendsms_model','mail_model'));
	}

	function get_all_degree()
	{
		$this->db->select('name,id');
		$this->db->order_by('name','asc');
		$query = $this->db->get('qualification');
		return $query->result();
	}

	function get_all_speciality()
	{
		$this->db->select('name,id');
		$this->db->order_by('name','asc');
		$this->db->where_in('status',array(1,2));
		$query = $this->db->get('speciality');
		return $query->result();
	}

	function get_speciality()
	{
		$this->db->select('name');
		$this->db->order_by('name','asc');
		$query = $this->db->get('speciality');
		return $query->result();
	}

	function get_qualification()
	{
		$this->db->select('name');
		$this->db->order_by('name','asc');
		$query = $this->db->get('qualification');
		return $query->result();
	}

	function check_doctor_details_exist($userid)
	{
		$query = $this->db->get_where('doctor', array('user_id'=>$userid));
		if($query->num_rows() >= 1)
		{
			return $query->row();
		}
		else
		{
			return FALSE;
		}
	}

	function insert_doctor($userid, $post)
	{
		$this->load->model('user_model');
		$userimg       = $this->user_model->get_all_userdetails($userid);

		$qualification = implode('#&#',$post['qualification']);

		$data          = array(
			'user_id'       =>	$userid,
			'name'          =>	$userimg->name,
			'speciality'    =>	$post['speciality'],
			'qualification' =>	$qualification,
			'city_id'       =>	$post['city'],
			'reg_no'        =>	$post['doc_reg_no'],
			'yoe'           =>	$post['experience'],
			'image'         =>	$userimg->image,
			'contact_number'=>	$userimg->contact_number
		);

		$this->db->insert('doctor', $data);
		return $this->db->insert_id();
	}

	function insert_cityid_doctor($userid, $post)
	{
		$data = array(
			'city_id'=>	$post['city']
		);
		$this->db->where('user_id', $userid);
		$this->db->update('doctor', $data);
	}

	function insert_clinic($userid, $doctorid, $post)
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
			'longitude'  	   =>	isset($latlong[1]) ? $latlong[1] : NULL,
			'latitude' 	   =>	isset($latlong[0]) ? $latlong[0] : NULL
		);

		$this->db->insert('clinic', $data);
		#echo $this->db->last_query();
		$clinicid = $this->db->insert_id();
		
		$amount = 0; // zero package amount
		$packageid = 10; // Smart Listing package id is 10
		
		// Check if eligible for upgrade
		$check_eligibility = $this->check_doctor_package_eligibility($userid, $packageid);
		if($check_eligibility === TRUE)
		{
			$d = $this->user_model->get_all_userdetails($userid);
			$this->doctor_model->update_doctor_package($userid, $packageid, $amount);
			//$this->sendsms_model->send_welcome_sms_doctor($d->contact_number);

			$packageid	=	20;

			$this->doctor_model->insert_package($userid, $packageid, $amount, 0);#this we have changed to because we want doctor to get directly Smart Online Reputation Package

			

		}
		
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
//		exit;
		return $clinicid;
	}
	
	function insert_clinic_photos($post,$clinicid,$doctorid)
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
			$md        = date('M').date('Y');
			$structure = "./media/photos/".$md."/clinic";
			if(!is_dir("./media/photos/".$md."/clinic"))
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
			foreach($photodata as $photos)
			{
				$newfilename = $photos['name'];
				if(!empty($newfilename))
				{
					$filename      = md5($newfilename).rand(10000000,99999999);
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
		}
	}

	function update_clinic($userid, $doctorid, $clinicid, $post)
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
			'longitude'  	   =>	isset($latlong[1]) ? $latlong[1] : NULL,
			'latitude' 	   =>	isset($latlong[0]) ? $latlong[0] : NULL
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
	function get_clinic_photo($clinic_id)
	{
		$query = $this->db->get_where('clinic', array('id' => $clinic_id));
		$rs = $query->row();
		return $rs->image;
	}	
	function get_clinicid_by_doctorid($doctor_id)
	{
		$query = $this->db->get_where('clinic', array('doctor_id' => $doctor_id));
		$rs = $query->result();
		if($rs)
		{
			return $rs;
		}
		return false;
		
	}	

	function update_clinic_photo($clinic_id,$images)
	{
		$this->db->where('id', $clinic_id);
		$data = array(
					'image' =>$images      
				);	
		$this->db->update('clinic', $data);
		return 	$this->db->affected_rows();
	}
	function get_city_name($city_id)
	{
		$query = $this->db->get_where('city', array('id' => $city_id));
		$rs = $query->row();
		return $rs->name;
	}
	
	function get_locality_name($location_id, $other_location)
	{
		if($location_id > 0)
		{
			$query = $this->db->get_where('location', array('id' => $location_id));
			$rs = $query->row();
			return $rs->name;
		}
		else
		{
			return $other_location;
		}
	}
	
	function get_council()
	{
		$query = $this->db->get('council');
		return $query->result();
	}

	function get_doctor_data($userid=0,$doctor_id=0)
	{
		if($userid)
		{
			$search_array['user_id']	=	$userid;
		}
		if($doctor_id)
		{
			$search_array['id']	=	$doctor_id;
		}
		
		if(isset($search_array) && sizeof($search_array)>0)
		{
			$query = $this->db->get_where('doctor', $search_array, 1);
			if($query->num_rows() >= 1)
			{
				return $query->row();
			}
		}
		return FALSE;
	}
	
	function get_doctor_name($doctor_id)
	{
		$this->db->select('name,image');
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

	function insert_doctor_professional_details($post, $filename_path, $userid)
	{
		$this->load->model('user_model');
		$userimg = $this->user_model->get_all_userdetails($userid);

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

		if($filename_path == NULL)
		{
			$data = array(
				'user_id'            =>	$userid,
				'name'               =>	$post['name'],
				'gender'             =>	$post['gender'],
				'reg_no'             =>	$post['regno'],
				'council_id'         =>	$post['council'],
				'speciality'         =>	$speciality,
				'other_speciality'   =>	$speciality_other,
				'qualification'      =>	$degree,
				'other_qualification'=>	$degree_other,
				'image'              =>	$userimg->image,
				'contact_number'     =>	$post['mob'],
				'yoe'     			 =>	!empty($post['yoe']) ? $post['yoe'] : NULL,
				'updated_on'         =>	date('Y-m-d h:i:s')
			);
		}
		else
		{
			$data = array(
				'user_id'            =>	$userid,
				'name'               =>	$post['name'],
				'gender'             =>	$post['gender'],
				'reg_no'             =>	$post['regno'],
				'speciality'         =>	$speciality,
				'other_speciality'   =>	$speciality_other,
				'qualification'      =>	$degree,
				'other_qualification'=>	$degree_other,
				'council_id'         =>	$post['council'],
				'image'              =>	$filename_path,
				'contact_number'     =>	$post['mob'],
				'yoe'    			 =>	!empty($post['yoe']) ? $post['yoe'] : NULL,
				'updated_on'         =>	date('Y-m-d h:i:s')
			);
		}

		$rs_insert = $this->db->insert('doctor', $data);
		if($this->db->affected_rows())
		{
			return $this->db->insert_id();
		}
		else
		{
			return false;
		}
	//		echo $this->db->last_query();
	//		exit;
		
	}

	function update_doctor_professional_details($post, $filename_path, $userid,$doctor_id)
	{
		$this->load->model('user_model');
		$userimg = $this->user_model->get_all_userdetails($userid);
//		print_r($post['speciality']);exit;

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

		if(isset($post['sponsored']))
		{
			  
			// $sponsored = $post['sponsored'];
			$sponsored = 1;
		}
		// else
		// {
		// 	$sponsored = NULL;
		// }

		if(isset($post['paid']))
		{
			  
			$paid = $post['paid'];
		}
		// else
		// {
		// 	$paid = NULL;
		// }

		if(isset($post['sort']))
		{
			  
			$sort = $post['sort'];
		}

		if(isset($post['health_utsav']))
		{
			  
			$health_utsav = $post['health_utsav'];
		}
			// else
		// {
		// 	$sort = NULL;
		// }
 


		$post['name']	=	ucwords(str_replace("dr.","",strtolower($post['name'])));
		if($filename_path == NULL)
		{
			$data = array(
				'user_id'            =>	$userid,
				'name'               =>	$post['name'],
				'gender'             =>	(isset($post['gender']) && !empty($post['gender']))?$post['gender']:'',
				'reg_no'             =>	(isset($post['regno']) && !empty($post['regno']))?$post['regno']:'',
				'council_id'         =>	(isset($post['council']) && !empty($post['council']))?$post['council']:'',
				'image'              =>	$userimg->image,
				'speciality'         =>	$speciality,
				'other_speciality'   =>	$speciality_other,
				'qualification'      =>	$degree,
				'other_qualification'=>	$degree_other,
				'contact_number'     =>	(isset($post['mob']) && !empty($post['mob']))?$post['mob']:'',
				'yoe'    			 =>	!empty($post['yoe']) ? $post['yoe'] : NULL,
				'sponsored'			 => $sponsored,
				'paid'				 => $paid,
				'sort'				 => $sort,
				'health_utsav'		 => $health_utsav,
				'updated_on'         =>	date('Y-m-d h:i:s')
			);
			$this->db->where('id', $userid);	
			$this->db->update('user', array('name'=>$post['name'],'gender'=>$post['gender'],'contact_number'=>$post['mob']));	
		}
		else
		{
			$data = array(
				'user_id'            =>	$userid,
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
				'sponsored'			 => $sponsored,
				'paid'				 => $paid,
				'sort'				 => $sort,
				'health_utsav'		 => $health_utsav,
				'updated_on'         =>	date('Y-m-d h:i:s')
			);
			$this->db->where('id', $userid);	
			$this->db->update('user', array('name'=>$post['name'],'gender'=>$post['gender'],'contact_number'=>$post['mob'],'image'=>$filename_path));	
			
		}
		$this->db->where('user_id', $userid);
		$this->db->update('doctor', $data);
	}

	function get_all_clinics($doctorid)
	{
		$query = $this->db->get_where('clinic', array('doctor_id'=> $doctorid));
		return $query->result();
	}
	function get_all_clinics_json($doctorid,$a=array())
	{
		$this->db->select('id, name, duration, address, contact_number, knowlarity_number, knowlarity_extension');
		$this->db->from('clinic');
		$this->db->order_by('created_on');
		$this->db->where('doctor_id', $doctorid);
		$data = array();
		$i = 0;
		$query = $this->db->get();
		if(isset($a['is_as_key']))
		{
			if($query->num_rows>0)
			{
				$data	=	$query->result_array();
				foreach($data as $row)
				{
					$row_data[$row['id']]	=	$row;
				}
			}
			return $row_data;
		}
		else
		{
			return $query->result_array();
		}
		//return json_encode($query->result_array());
		
	}
	function get_clinic_timings($clinic_id)
	{
		$this->db->select('timings,duration');
		$query = $this->db->get_where('clinic', array('id'=> $clinic_id));
//		echo print_r($query->row());exit;
		return $query->row();
	}
	
	function delete_clinic($clinicid, $doctorid)
	{
		if($clinicid && $doctorid)
		{
			$this->db->delete('clinic', array('id' => $clinicid,'doctor_id'=> $doctorid));
			return $this->db->affected_rows(); 
		}
		else
		{
			return false;
		}	
	}

	function check_clinic_present($doctorid)
	{
		$query = $this->db->get_where('clinic', array('doctor_id'=> $doctorid));
		if($query->num_rows() >= 1)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	function check_clinic_exist($doctorid, $clinicid)
	{
		$query = $this->db->get_where('clinic', array('doctor_id'=> $doctorid,'id'       => $clinicid));
		if($query->num_rows() >= 1)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	function get_doctor_id($userid)
	{
		$this->db->select('id,user_id,name');
		$this->db->from('doctor');
		$this->db->where('user_id', $userid);
		$query = $this->db->limit(1);
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

	function get_clinic_details($clinicid, $doctorid)
	{
		$this->db->from('clinic');
		$this->db->where('id', $clinicid);
		$this->db->where('doctor_id', $doctorid);
		$query = $this->db->get();
		if($query->num_rows() >= 1)
		{
			return $query->row();
		}
		else
		{
			return FALSE;
		}
	}
	
	function naved()
	{
//		$this->db->select('id, name');
		$query = $this->db->get_where('user', array('type' => '2'));
		if($query->num_rows() > 0)
		{
			$results = $query->result();
			foreach($results as $row)
			{
				$package_id = 0;
				$doctor = $this->get_doctor_id($row->id);
				if($doctor != FALSE)
				{
					$clinicpresent = $this->check_clinic_present($doctor->id);
					if($clinicpresent != FALSE)
					{
						$package_id = 10;
					}
				}
				$data = array(
				'user_id'		=>	$row->id,
				'user_type'		=>	$row->type,
				'package_id'	=>	$package_id,
				'start_date'	=>	date('Y-m-d', strtotime($row->created_on)),
				'end_date'		=>	'2016-01-01',
				'amount_paid'	=>	'0',
				'status'		=>	'1'
				);
				//$this->db->insert('package_registration', $data);
			}
		}
	}
	
	function add_package($insertid)
	{

		$data2 = array(
			'user_id'		=>	$insertid,
			'user_type'		=>	'2',
			'package_id'	=>	'0',
			'start_date'	=>	date('Y-m-d'),
			'end_date'		=>	date('Y-m-d', strtotime("+1 year -1 day")),
			'amount_paid'	=>	'0',
			'status'		=>	'1'
			);
		$this->db->insert('package_registration', $data2);
	}
	
	function update_doctor_package($userid, $packageid, $amount)
	{
		$data2 = array(
			'package_id'	=>	$packageid,
			'start_date'	=>	date('Y-m-d'),
			'end_date'		=>	date('Y-m-d', strtotime("+1 year -1 day")),
			'amount_paid'	=>	$amount,
			'status'		=>	'1'
			);
		$this->db->where('user_id', $userid);
		$this->db->update('package_registration', $data2);
	}
	
	function insert_package($userid, $packageid, $amount, $orderid)
	{
		if($userid)
		{
			if($packageid!=40)
			{
				$this->db->update('package_registration', array('status'=>0),array('user_id'=>$userid,'package_id <>'=>'40'));
			}
		}
		$data2 = array(
			'user_id'		=>	$userid,
			'user_type'		=>	'2',
			'package_id'	=>	$packageid,
			'start_date'	=>	date('Y-m-d'),
			'end_date'		=>	date('Y-m-d', strtotime("+1 year -1 day")),
			'amount_paid'	=>	$amount,
			'order_id'		=>	$orderid,
			'status'		=>	'1'
			);
		$this->db->insert('package_registration', $data2);
	}
	
	function check_doctor_package_eligibility($userid, $newpackageid)
	{
		$query = $this->db->get_where('package_registration', array('user_id' => $userid, 'status' => '1', 'end_date >=' => date('Y-m-d')));
//		echo $this->db->last_query();
//		exit;
		if($query->num_rows() > 0)
		{
			$results = $query->result();
			$packageids = array();
//			print_r($results);
			foreach($results as $result)
			{
				// get all the package ids in an array
				array_push($packageids, $result->package_id);
			}
			// Sort package ids in descending order
			arsort($packageids);
			// Check if smart receptionist is present as a current package or not
			if(in_array('40', $packageids)) // Smart receptionist is present
			{
				// Remove the 1st package id i.e.40 (smart receptionist)
				array_shift($packageids);
				// Check if new package id is greater than the max of current package which the doctor holds
				if((($newpackageid > max($packageids)) || (max($packageids) == '100')) && $newpackageid != '40') // where 100 is trial package
				{
					return TRUE;
				}
				else
				{
					return FALSE;
				}
			}
			else
			{
				if(($newpackageid > max($packageids)) || (max($packageids) == '100')) // where 100 is trial package
				{
					return TRUE;
				}
				else
				{
					return FALSE;
				}
			}
		}
		else
		{
			return FALSE;
		}
	}
	
	function check_sor_eligibility($userid)
	{
		$query = $this->db->get_where('package_registration', array('user_id' => $userid, 'status' => '1', 'end_date >=' => date('Y-m-d')));
		if($query->num_rows() > 0)
		{
			$results = $query->result();
			$packageids = array();
			foreach($results as $result)
			{
				array_push($packageids, $result->package_id);
			}
			if(in_array('20', $packageids) || in_array('30', $packageids) || in_array('100', $packageids))
			{
				return TRUE;
			}
			else
			{
				return FALSE;
			}
		}
		else
		{
			return FALSE;
		}
	}
	function check_sa_eligibility($userid)
	{
		$query = $this->db->get_where('package_registration', array('user_id' => $userid, 'status' => '1', 'end_date >=' => date('Y-m-d')));
		if($query->num_rows() > 0)
		{
			$results = $query->result();
			$packageids = array();
			foreach($results as $result)
			{
				array_push($packageids, $result->package_id);
			}
			if(in_array('30', $packageids) || in_array('100', $packageids))
			{
				return TRUE;
			}
			else
			{
				return FALSE;
			}
		}
		else
		{
			return FALSE;
		}
	}


	function check_packageid_exist($packageid)
	{
		$query = $this->db->get_where('packages', array('id' => $packageid, 'status' => '1'));
		if($query->num_rows() > 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	function get_package_details($packageid)
	{
		$query = $this->db->get_where('packages', array('id' => $packageid, 'status' => '1'));
		if($query->num_rows() > 0)
		{
			return $query->row();
		}
		else
		{
			return FALSE;
		}
	}
	function get_all_packages()
	{
		$query = $this->db->get_where('packages');
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return FALSE;
		}
	}
	
	function get_doctor_package_details_1($userid)
	{
		#$this->db->orderby('id desc');
		$res = array();
		$this->db->order_by('id desc'); 
		$query = $this->db->get_where('package_registration', array('user_id' => $userid, 'status' => '1',"package_id != "=>"40"));
		if($query->num_rows() > 0)
		{
//			$res[] = $query->row();
			$res = $query->row();
		}
		/*
		$query_expl = $this->db->get_where('package_registration', array('user_id' => $userid, 'status' => '1','package_id'=>'40'));
		if($query_expl->num_rows() > 0)
		{
			$res[] = $query_expl->row();
		}
		*/
		
			return $res;
	/*	if(sizeof($res)>0)
		{
		}
		else
		{
			return false;
		}*/
	}

	function get_doctor_package_details($userid)
	{
		#$this->db->orderby('id desc');
		$res = array();
		$this->db->order_by('id desc'); 
		$query = $this->db->get_where('package_registration', array('user_id' => $userid, 'status' => '1',"package_id != "=>"40"));
		if($query->num_rows() > 0)
		{
			$res[] = $query->row();
			//$res = $query->row();
		}
		
		$query_expl = $this->db->get_where('package_registration', array('user_id' => $userid, 'status' => '1','package_id'=>'40'));
		if($query_expl->num_rows() > 0)
		{
			$res[] = $query_expl->row();
		}
		
		
		//return $res;
		if(sizeof($res)>0)
		{
			return $res;
		}
		else
		{
			return false;
		}
	}

	function get_all_doctor_packages($userid)
	{
		$this->db->from('packages');
		$this->db->join('package_registration', 'package_registration.package_id = packages.id');
		$this->db->where('package_registration.user_id', $userid);
		$this->db->where('package_registration.status', '1');
		$this->db->where('package_registration.end_date >=', date('Y-m-d'));
		$this->db->where('package_registration.id <>', '1');
		$this->db->where('package_registration.id <>', '40');
		$this->db->order_by('packages.id', 'desc');
		$this->db->limit(2, 0);
		$query = $this->db->get();
		//echo $this->db->last_query();
		//exit;
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return FALSE;
		}
	}

	function deleteclinicphoto($doctorid,$clinicid,$photoid)
	{
		echo $photoid = $photoid - 1;
		$check = $this->get_clinic_photos($doctorid,$clinicid);
		if($check !== FALSE)
		{
			$images = $check->image;
			$imagearray = explode(',', $images);
			//print_r($imagearray);
			unlink($imagearray[$photoid]); //deletes image from system
			
			$imagearray[$photoid] = '';
			$newimagearray = implode(',', $imagearray);
			$newimagearray = trim($newimagearray);
			//print_r($imagearray);
			$imagedata = array(
			'image'          =>	$newimagearray
			);

			$this->db->where('id', $clinicid);
			$this->db->where('doctor_id', $doctorid);
			$this->db->update('clinic', $imagedata);
			//print_r($imagearray);
		}
	}
	
	function get_clinic_photos($doctorid,$clinicid)
	{
		$query = $this->db->get_where('clinic', array('doctor_id' => $doctorid, 'id' => $clinicid));
		if($query->num_rows() > 0)
		{
			return $query->row();
		}
		else
		{
			return FALSE;
		}
	}
	
	function get_patients_by_id($doctorid)
	{
//		$this->db->select('patient.id,patient.name,patient.mobile_number');
		$this->db->select('p.id,p.name,p.gender,p.address,p.email,p.mobile_number,p.dob');
		#$this->db->from('patient');
		#$this->db->from('`appointment` as apt');
		#$this->db->join('`patient` p', 'apt.patient_id = p.id');

		$this->db->from('`patient` as p');
		$this->db->join('`appointment` apt', 'apt.patient_id = p.id','left');
		$this->db->join('`doctor_patient_map` dpm', 'p.id= dpm.patient_id','left');
		
		$this->db->order_by('p.name asc');
		#$this->db->where('apt.doctor_id', $doctorid); 
		$this->db->where("(apt.doctor_id='".$doctorid."' OR dpm.doctor_id='".$doctorid."')", NULL, FALSE);

		$query = $this->db->get();
		if($query->num_rows() > 0) {
			return $query->result_array();
		}
		else {
			return FALSE;
		}
	}
	
	function check_freetrial_eligible($doctorid, $userid)
	{
		$this->db->from('package_registration');
		$this->db->where('user_id', $userid);
		$this->db->where('package_id', '100');
		$count = $this->db->count_all_results();
//		echo $this->db->last_query();
		return $count;
	}
	
	function insert_free_trial($doctorid, $userid,$doctor_status)
	{
		if($doctor_status == 1)
		{
			$data = array(
			'user_id'		=>	$userid,
			'user_type'		=>	'2',
			'package_id'	=>	'100',
			'start_date'	=>	date('Y-m-d'),
			'end_date'		=>	date('Y-m-d', strtotime("+15 days")),
			'amount_paid'	=>	'0',
			'status'		=>	'1'
			);
		}
		else
		{
			$data = array(
			'user_id'		=>	$userid,
			'user_type'		=>	'2',
			'package_id'	=>	'100',
			'amount_paid'	=>	'0',
			'status'		=>	'0'
			);
		}
		$this->db->insert('package_registration', $data);
//		echo $this->db->last_query();
	}
	function update_doctor_status($status,$ids)
	{
		if(is_array($ids))
		{
			$this->db->where_in('id', $ids); //$ids should be an array
			$update = array('status'=> $status);
			$this->db->update('doctor',$update);
			if($this->db->affected_rows() > 0)
			{
				$this->autoapprove_trial_package($ids);
				return TRUE;
			}
			else
			{
				return FALSE;
			}
		}
		return FALSE;
	}

	// from doctor model 
	function getDoctorDetail($a = array())
	{
		$res = false;
		$a = $this->filterData($a);
		$this->SQL = $where = "";
		$where .= " where 1";

		if(!empty($a['doctor_id']))
		{
			$where .= " AND doc.doctor_id  ='".$a['doctor_id']."'";
		}

		if(!empty($a['attribute']))
		{
			$where .= " AND doc.attribute  ='".$a['attribute']."'";
		}

		$this->SQL .= "select ".$a['column']." from doctor_detail as `doc` ".$this->join.$where.$this->groupby.$this->orderby.$this->limit;

		$query = $this->db->query($this->SQL);
		$this->row_count = 0;
		if($query->num_rows > 0)
		{
			foreach($query->result_array() as $row)
			{
				$res[$row['attribute']][] = $row;
			}
		}
		return $res;

	}

	function getDoctor($a = array())
	{
		$res = false;$whereArray = array();

		$this->filterData_active($a);
		$this->db->from('doctor as `doc`');

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


		if(!empty($a['doctor_name']))
		{
			$this->db->like("doc.name",$a['doctor_name'],'both');
		}
		if(!empty($a['status'])  )
		{
			$whereArray['doc.status'] = $a['status'];
		}
		if(!empty($a['featured'])  )
		{
			$whereArray['doc.is_featured'] = $a['featured'];
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

		$this->db->where($whereArray);

		$query = $this->db->get();
		if($query->num_rows > 0)
		{
			foreach($query->result_array() as $row)
			{
				if(isset($a['detail']))
				{
					$row['detail'] = $this->getDoctorDetail(array('doctor_id'=>$row['doctor_id'],'limit'    =>100));
				}
				$res[] = $row;
			}
		}
		return $res;
	}

	function getDoctorBySpecialityId($a = array())
	{
		#print_r($a);
		$this->db->start_cache();
		$res = false;$whereArray = array();
		$this->filterData_active($a);
		$this->db->from('doctor as `doc`');
		#$this->db->join('`schedule` as `sc`', 'doc.id = sc.`doctor_id`');
		$this->db->join('`clinic` cli', 'doc.id=cli.`doctor_id`');
		#$this->db->join('`speciality` sp', 'sp.id = doc.speciality');
		#$this->db->join('`specialization` spe', 'spe.id = doc.specialization');
		if(!empty($a['location']))
		{
			$this->db->join('`location` lc', 'lc.id=cli.location_id');
			$whereArray['lc.name'] = str_replace("-"," ",$a['location']);
		}

		if(!empty($a['speciality_id']))
		{
			$this->db->where("FIND_IN_SET('".trim($a['speciality_id'])."', doc.speciality)");
		}

		$whereArray['cli.city_id'] = $a['city_id'];
		if(isset($a['location_in']) && !empty($a['location_in']))
		{
			$locstr  ='';
			$this->db->where_in('location_id', $a['location_in']);
			foreach($a['location_in'] as $lcVal){
				$locstr .=  $lcVal.",";
			}
			$locstr = trim($locstr,',');
			$this->db->_protect_identifiers = FALSE;
			$this->db->order_by("FIELD ( `location_id`,$locstr),doc.`sponsored` DESC, doc.`paid` DESC, doc.`sort` DESC, doc.`image` DESC, doc.`is_ver_reg` DESC");
			$this->db->_protect_identifiers = TRUE;
		}

		if(!empty($a['location_id']))
		{
			$whereArray['cli.location_id'] = $a['location_id'];
		}


		if(!empty($a['status'])  )
		{
			$whereArray['doc.status'] = $a['status'];
			$whereArray['cli.status'] = $a['status'];
		}

		$this->db->where($whereArray);
		$query = $this->db->get();
		if(isset($_GET['vin']))
		{
			echo $this->db->last_query();exit;
		}
		if(isset($a['count']) && $a['count'] == TRUE)
		{

			$this->row_count = $this->db->count_all_results();
			

		}
		$this->db->stop_cache();
		$this->db->flush_cache();
		if($query->num_rows > 0)
		{
			foreach($query->result_array() as $row)
			{
				if(isset($a['detail']))
				{
					$row['detail'] = $this->getDoctorDetail(array('doctor_id'=>$row['doctor_id'],'limit'    =>100));
				}
				$res[] = $row;
			}
		}
		return $res;
	}

	function getDoctorById($a = array())
	{
		$this->db->start_cache();
		$res = false;$whereArray = array();
		$this->filterData_active($a);
		$this->db->from('doctor as `doc`');
		#$this->db->join('`schedule` as `sc`', 'doc.id = sc.`doctor_id`');
		$this->db->join('`clinic` cli', 'doc.id=cli.`doctor_id`');
		if(!empty($a['id']))
		{
			$whereArray['doc.id'] = $a['id'];
		}
		if(!empty($a['url_name']))
		{
			$whereArray['doc.url_name'] = $a['url_name'];
		}
		if(!empty($a['user_id']))
		{
			$whereArray['doc.user_id'] = $a['user_id'];
		}
		if(!empty($a['city_id']))
		{
			$whereArray['cli.city_id'] = $a['city_id'];
		}

		if(isset($a['status'])  )
		{
			if($a['status']==1)
			{
				$whereArray['doc.status'] = $a['status'];
				$whereArray['cli.status'] = $a['status'];
			}
			else if($a['status']==0)
			{
				$whereArray['doc.status'] = $a['status'];
			}
			else if(is_array($a['status']))
			{
				$this->db->where_in('doc.status', $a['status']);
			}
		}
		else
		{
			$whereArray['doc.status'] = 1;
			$whereArray['cli.status'] = 1;
		}
		$this->db->where($whereArray);
		$query = $this->db->get();
		#print_r($query->result_array());
		#echo $this->db->last_query();exit;
		if(isset($a['count']) && $a['count'] == TRUE)
		{
			$this->row_count = $this->db->count_all_results();
		}
		$this->db->stop_cache();
		$this->db->flush_cache();
		if($query->num_rows > 0)
		{
			foreach($query->result_array() as $row)
			{
				if(isset($a['detail']))
				{
					$row['detail'] = $this->getDoctorDetail(array('doctor_id'=>$row['doctor_id'],'limit'    =>100));
				}
				if(isset($a['speciality']))
				{
					$this->load->model(array('common'));
					$row['speciality'] = "1,2";
					$row['speciality_detail'] = $this->common->getSpeciality(array('ids'   =>$row['speciality'],'status'=>ACTIVE,'limit' =>100,'column'=>array('name','id')));
				}

				$res[] = $row;
			}
		}
		return $res;
	}

	function getDoctorByName($a = array())
	{
		$this->db->start_cache();
		$res = false;$whereArray = array();
		$this->filterData_active($a);
		$this->db->from('doctor as `doc`');
		#$this->db->join('`schedule` as `sc`', 'doc.id = sc.`doctor_id`');
		$this->db->join('`clinic` cli', 'doc.id=cli.`doctor_id`');
		if(!empty($a['name_like']))
		{
			$this->db->like("doc.name",$a['name_like'],'both');
		}
		if(!empty($a['url_name']))
		{
			$this->db->like("doc.url_name",$a['url_name'],'both');
		}

		$whereArray['cli.city_id'] = $a['city_id'];
		if(!empty($a['status'])  )
		{
			$whereArray['doc.status'] = $a['status'];
			$whereArray['cli.status'] = $a['status'];
		}
		if(isset($a['health_utsav']) && !empty($a['health_utsav']))
		{
			$whereArray['doc.health_utsav'] = $a['health_utsav'];
		}

		$this->db->where($whereArray);
		$query = $this->db->get();
		if(isset($a['count']) && $a['count'] == TRUE)
		{
			$this->row_count = $this->db->count_all_results();
		}
		$this->db->stop_cache();
		$this->db->flush_cache();
		if($query->num_rows > 0)
		{
			foreach($query->result_array() as $row)
			{
				if(isset($a['detail']))
				{
					$row['detail'] = $this->getDoctorDetail(array('doctor_id'=>$row['doctor_id'],'limit'    =>100));
				}
				if(isset($a['speciality']))
				{
					$this->load->model(array('common'));
					$row['speciality'] = "1,2";
					$row['speciality_detail'] = $this->common->getSpeciality(array('ids'   =>$row['speciality'],'status'=>ACTIVE,'limit' =>100,'column'=>array('name','id')));
				}

				$res[] = $row;
			}
		}
		return $res;
	}

	function getDoctorByClinicId($a = array())
	{
		$this->db->start_cache();
		$res = false;$whereArray = array();
		$this->filterData_active($a);
		$this->db->from('doctor as `doc`');
		$this->db->join('`clinic` cli', 'doc.id=cli.`doctor_id`');
		if(!empty($a['clinic_id']))
		{
			$whereArray['cli.id'] = $a['clinic_id'];
		}
		if(!empty($a['name_like']))
		{
			$this->db->like("cli.name",$a['name_like'],'both');
		}
		if(!empty($a['url_name']))
		{
			$this->db->like("cli.url_name",$a['url_name'],'both');
		}
		
		if(isset($a['city_id']) && !empty($a['city_id'])){
			$whereArray['cli.city_id'] = $a['city_id'];
		}

		if(!empty($a['doctor_name']))
		{
			$this->db->like("doc.name",$a['doctor_name'],'both');
		}
		
		if(!empty($a['status'])  )
		{
			$whereArray['doc.status'] = $a['status'];
			$whereArray['cli.status'] = $a['status'];
		}
		$this->db->where($whereArray);

		$query = $this->db->get();
		if(isset($a['count']) && $a['count'] == TRUE)
		{
			$this->row_count = $this->db->count_all_results();
		}
		$this->db->stop_cache();
		$this->db->flush_cache();
		if($query->num_rows > 0)
		{
			foreach($query->result_array() as $row)
			{
				if(isset($a['detail']))
				{
					$row['detail'] = $this->getDoctorDetail(array('doctor_id'=>$row['doctor_id'],'limit'    =>100));
				}
				$res[] = $row;
			}
		}
		return $res;

	}

	function getAllDoctors($a = array())
	{
		$this->db->start_cache();
		$res = false;$whereArray = array();
		$this->filterData_active($a);
		$this->db->from('doctor as `doc`');
		#$this->db->join('`schedule` as `sc`', 'doc.id = sc.`doctor_id`');
		$this->db->join('`clinic` cli', 'doc.id=cli.`doctor_id`');
		if(!empty($a['status'])  )
		{
			$whereArray['doc.status'] = $a['status'];
			$whereArray['cli.status'] = $a['status'];
		}
		if(isset($a['city_id']) && !empty($a['city_id']))
		{
			$whereArray['cli.city_id'] = $a['city_id'];
		}


		$this->db->where($whereArray);
		$query = $this->db->get();
		if(isset($a['count']) && $a['count'] == TRUE)
		{
			$this->row_count = $this->db->count_all_results();
		}
		$this->db->stop_cache();
		$this->db->flush_cache();
		if($query->num_rows > 0)
		{
			foreach($query->result_array() as $row)
			{
				if(isset($a['detail']))
				{
					$row['detail'] = $this->getDoctorDetail(array('doctor_id'=>$row['doctor_id'],'limit'    =>100));
				}
				$res[] = $row;
			}
		}
		return $res;

	}

	function getFeaturedDoctors($a = array())
	{
		$res = false;$whereArray = array();
		$this->filterData_active($a);
		$this->db->from('doctor as `doc`');
		#$this->db->join('`schedule` as `sc`', 'doc.id = sc.`doctor_id`');
		#$this->db->join('`clinic` as `cli`', 'cli.id = sc.`clinic_id`');
		#$this->db->join('`location` as `lc`', 'lc.id = cli.`location_id`');

		if(!empty($a['status'])  )
		{
			$whereArray['doc.status'] = $a['status'];
		}
		if(!empty($a['city_id'])  )
		{
			$whereArray['doc.city_id'] = $a['city_id'];
		}
		$whereArray['doc.image !='] = '';
		if(!empty($a['featured'])  )
		{
			#$whereArray['doc.is_featured'] = $a['featured'];
			$whereArray['doc.status'] = $a['featured'];
		}

		$this->db->where($whereArray);
		$query = $this->db->get();
		if($query->num_rows > 0)
		{
			
			$this->load->model(array('common_model'));
			foreach($query->result_array() as $row)
			{
				if(isset($a['detail']))
				{
					$row['detail'] = $this->getDoctorDetail(array('doctor_id'=>$row['doctor_id'],'limit'    =>100));
				}
				if(!empty($row['speciality']))
				{
					
					$row['speciality_detail'] = $this->common_model->getSpeciality(array('ids'   =>$row['speciality'],'status'=>ACTIVE,'column'=>array('name','id')));
				}
				if(!empty($row['qualification']))
				{
					$row['qualification_detail'] = $this->common_model->getQualification(array('ids'=>$row['qualification'],'status'=>ACTIVE,'column'=>array('name','id')));				
				}
				$res[] = $row;
			}
		}
		return $res;

	}

	function insertDoctorDetail($a = array())
	{
		$rs = $this->db->insert_batch('doctor_detail', $a);
		if($rs)
		{
			return $this->db->insert_id();
		}
		else
		{
			return false;
		}
	}

	function insertPatientNumbersByBatch($a = array())
	{
		$rs = $this->db->insert_batch('doctor_patient_review_detail', $a);
		if($rs)
		{
			return $this->db->last_query();
		}
		else
		{
			return false;
		}
	}


	function deletePatientNumbersByDoctorId($a = array())
	{
		if(is_array($a) && sizeof($a) > 0)
		{
			$rs = $this->db->delete('doctor_patient_review_detail', $a);
		}
		else
		{
			$rs = false;
		}
		return $rs;
	}

	function deleteDoctorDetailById($a = array())
	{
		if(is_array($a) && sizeof($a) > 0)
		{
			$rs = $this->db->delete('doctor_detail', $a);
		}
		else
		{
			$rs = false;
		}
		return $rs;
	}

	function insertDoctorSingleDetail($a = array())
	{
		$rs = $this->db->insert('doctor_detail', $a);
		if($rs)
		{
			return $this->db->insert_id();
		}
		else
		{
			return false;
		}
	}

	function updateDoctor($a = array())
	{
		if(is_array($a['set']) && sizeof($a['set']) > 0 && is_array($a['where']) && sizeof($a['where']) > 0)
		{
			$this->db->update('doctor', $a['set'], $a['where']);
		}


	}

	function insertDoctor($a = array())
	{
		$insert_query = $this->db->insert_string('doctor',$a);
		$insert_query = str_replace('INSERT INTO','INSERT IGNORE INTO',$insert_query);
		$rs           = $this->db->query($insert_query);
		if($rs)
		{
			return $this->db->insert_id();
		}
		else
		{
			return false;
		}
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
		$whereArray['dap.confirmation'] = 1;

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
		#$appointment = get_data("doctor_appointment","doctor_id = '".$doc_data[$i]['doc_id']."' AND appointment_date = '".date('d - m - Y')."' AND appointment_time = '".$times[$b]."'","","appointment_date,appointment_time");

	}

	function saveAppointment($a = array())
	{
		$data = array(
			'doctor_id'       => $a['doctor_id'] ,
			'clinic_id'       => $a['clinic_id'],
			'user_id'         => $a['user_id'],
			'user_type'       => $a['user_type'],
			'reason_for_visit'=> $a['reason_for_visit'],
			'date'            => date("Y-m-d",strtotime($a['date'])) ,
			'time'            => date("H:i:s",strtotime($a['time'])),
			'scheduled_time'  => date("Y-m-d H:i:s",strtotime($a['date']." ".$a['time'])),
			'mobile_number'   => $a['mobile_number'],
			'patient_id'   => $a['patient_id'],
			'patient_name'   => $a['patient_name'],
			'patient_email'   => $a['email_id'],
			'patient_gender'   => $a['gender'],
			'city_id'   => $a['city_id']
		);
		$insert_query = $this->db->insert_string('appointment',$data);
		$insert_query = str_replace('INSERT INTO','INSERT IGNORE INTO',$insert_query);
		$rs           = $this->db->query($insert_query);
		
		#$rs = $this->db->insert('appointment', $data);
		
		if($rs)
		{
			return $this->db->conn_id->insert_id;
		}
		else
		{
			return false;
		}

	}

	function showAppointmentDetail($a = array())
	{
		$res = false;$whereArray = array();
		$this->filterData_active($a);
		$this->db->from('appointment as `apt`');
		$this->db->join('doctor as d', 'd.id = apt.doctor_id', 'left');
		$this->db->join('user as u', 'u.id=apt.user_id', 'left');
		$this->db->join('clinic as c', 'c.id=apt.clinic_id','left');
		$this->db->join('location as l', 'l.id=c.location_id','left');

		if(!empty($a['app_id']))
		{
			$whereArray['apt.id'] = $a['app_id'];
		}

		$this->db->where($whereArray);
		$query = $this->db->get();
		if($query->num_rows > 0)
		{
			foreach($query->result_array() as $row)
			{
				$res[] = $row;
			}
		}
		return $res;
	}

	function getTimeArrayFromTimings($a = array())
	{
		$dr_timings = json_decode($a['timings']);


		$timeArray  = array(); /* this array will have final weekly timings array from sunday to saturday , sunday =0 and saturday =6*/

		foreach($dr_timings as $drKey=>$drVal)
		{
			$timeArray[$drKey] = array(); /* $drKey over here is numeical value for sunday to mondau*/
			if(is_array($drVal) && sizeof($drVal) > 0)
			{
				foreach($drVal as $drInKey=>$drInVal)
				{
					/* $drVal over here will be all start end timings of appointment*/
					$openTime = (string)(isset($drInVal[0])?$drInVal[0]:''); /* $drInVal  will be an individual array of start and close time   */
					$closeTime = (string)(isset($drInVal[1])?$drInVal[1]:'');
					if(!empty($openTime) && !empty($closeTime)  )
					{
						$duration = $a['duration']?$a['duration']." mins":APPOINTMENT_DURATION;
						$timeArray[$drKey][$drInKey] = create_time_range($openTime,$closeTime,$duration);
					}
				}
			}
		}
		#print_r($timeArray);
		return $timeArray;
	}

	function getAppointmenByDateAndDoctorId($a = array())
	{
		$appointmentArray	= array();
		$bookedAppoitnemtns = $this->doctor_model->getDoctorAppointment(array('column'=>array('dap.time','dap.date','dap.scheduled_time'),
		'doctor_id' =>$a['doctor_id'],'clinic_id' =>$a['clinic_id'],'start_date'=>$a['start_date'],'end_date'  =>$a['end_date'],'orderby'=>'dap.date asc'));

		$blockedAppoitnemtns = $this->doctor_model->getBlockedAppointmentsByScheduleId(array('doctor_id'=>$a['doctor_id'],'duration' =>$a['duration']));
		
		/*foreach($date_range as $val)
		{
			if(isset($bookedAppoitnemtns[$val]))
			{
				$appointmentArray[$val]	= $bookedAppoitnemtns[$val];
			}
			if(isset($blockedAppoitnemtns[$val]))
			{
				$appointmentArray[$val]	+= $blockedAppoitnemtns[$val];
			}
		}*/
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
					/*$tKey = key($timings);
					if(array_key_exists($tKey,$appointmentArray)){
					$appointmentArray[$tKey] = array_merge($appointmentArray[$tKey],$timings[$tKey]);
					}else{
					$appointmentArray = array_merge($appointmentArray,$timings);
					}*/
					$appointmentArray = array_merge_recursive($appointmentArray, $timings);
				}
			}
		}

		return $appointmentArray;
	}
	function get_clinic_consultation_fees($id)
	{
		$fees = array(1=>"100~300",2=>"301~500",3=>"501~750",4=>"751~1000",5=>"more than 1000");
		if(isset($fees[$id])){
			return $fees[$id];
		}
		return  false;
	}

	function __toString()
	{
		return (string)$this->db->last_query();
	}

}