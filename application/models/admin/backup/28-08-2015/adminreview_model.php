<?php
if(!defined('BASEPATH')) exit('No direct access allowed');

class adminreview_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	function get_reviews($a = array())
	{
		$this->db->select('reviews.*, doctor.name as doctor_name, doctor.id as doctor_id');#, speciality.name as speciality city.name as city_name, doctor.speciality as speciality

			
		$whereArray = array();

		$this->filterData_active($a);
		$this->db->from('reviews');

		if(!empty($a['doctor_id']))
		{
			$whereArray['doctor.id'] = $a['doctor_id'];
		}
		if(!empty($a['doctor_name']))
		{
			$this->db->like("doctor.name",$a['doctor_name'],'both');
		}
		if(!empty($a['user_name']))
		{
			$this->db->like("reviews.name",$a['user_name'],'right');
		}
		if(!empty($a['user_email']))
		{
			$this->db->like("reviews.email",$a['user_email'],'right');
		}
		if(!empty($a['user_comment']))
		{
			$this->db->like("reviews.comment",$a['user_comment'],'both');
		}
		if(!empty($a['user_rating']))
		{
			$whereArray['reviews.rating'] = $a['user_rating'];
		}

		if(!empty($a['clinic_name']))
		{
			$this->db->like("clinic.name",$a['clinic_name'],'both');
		}
		if(!empty($a['city_id']))
		{
			$whereArray['clinic.city_id'] = $a['city_id'];
		}

		if(isset($a['status']) && strlen($a['status']) > 0)
		{
			$whereArray['reviews.status'] = $a['status'];
		}
		
		$this->db->join('doctor','reviews.doctor_id = doctor.id');
		#$this->db->join('clinic','clinic.doctor_id = doctor.id');
		#$this->db->join('speciality','doctor.speciality = speciality.id');
		#$this->db->join('city','clinic.city_id = city.id');
		$this->db->where($whereArray);
		#$this->db->group_by('clinic.doctor_id');
		$this->db->order_by('reviews.id desc');
		$query = $this->db->get();
		#echo $this->db->last_query();exit;
		if($query->num_rows() >= 1)
		{
			$res = $query->result();
		}
		
		return $res;
	}

	function get_reviews_count($a = array())
	{
		$this->db->select('COUNT(*) AS `numrows`');

		$res = false; 
		$whereArray = array();

		$this->filterData_active($a);
		$this->db->from('reviews');

		if(!empty($a['doctor_id']))
		{
			$whereArray['doctor.id'] = $a['doctor_id'];
		}
		if(!empty($a['doctor_name']))
		{
			$this->db->like("doctor.name",$a['doctor_name'],'both');
		}
		if(!empty($a['user_name']))
		{
			$this->db->like("reviews.name",$a['user_name'],'right');
		}
		if(!empty($a['user_email']))
		{
			$this->db->like("reviews.email",$a['user_email'],'right');
		}
		if(!empty($a['user_comment']))
		{
			$this->db->like("reviews.comment",$a['user_comment'],'both');
		}
		if(!empty($a['user_rating']))
		{
			$whereArray['reviews.rating'] = $a['user_rating'];
		}

		if(!empty($a['clinic_name']))
		{
			$this->db->like("clinic.name",$a['clinic_name'],'both');
		}
		if(!empty($a['city_id']))
		{
			$whereArray['clinic.city_id'] = $a['city_id'];
		}

		if(isset($a['status']) && strlen($a['status']) > 0)
		{
			$whereArray['reviews.status'] = $a['status'];
		}
		
		$this->db->join('doctor','reviews.doctor_id = doctor.id');
		#$this->db->join('clinic','clinic.doctor_id = doctor.id');
		#$this->db->join('speciality','doctor.speciality = speciality.id');
		#$this->db->join('city','clinic.city_id = city.id');
		$this->db->where($whereArray);
		#$this->db->group_by('clinic.doctor_id');
		$query = $this->db->get();
		#echo $this->db->last_query();exit;
		if($query->num_rows())
		{
			return $query->row_array();
		}
		
		return $res;
	}

	function update_review_status($status,$ids)
	{
		if(is_array($ids))
		{
			$this->db->where_in('id', $ids); //$ids should be an array
			$update = array('status'=> $status);
			$this->db->update('reviews',$update);
			if($this->db->affected_rows() > 0)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		return false;
	}

	function insert_review($doctorid, $message, $rating, $name, $email, $image, $status=0)
	{
		$data = array(
		'doctor_id'	=>	$doctorid,
		'name'		=>	$name,
		'email'		=>	$email,
		'image'		=>	$image,
		'comment'	=>	urldecode($message),
		'rating'	=>	$rating,
		'status'	=>	$status
		);
		$this->db->insert('reviews', $data);
		return $this->db->insert_id();
	}
	
	function __toString()
	{
		return $this->db->last_query();
	}


}