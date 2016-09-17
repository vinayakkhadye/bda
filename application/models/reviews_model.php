<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');

class reviews_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	function getReviewsByPageId($a=array()){
		$res = false;$whereArray = array();

		$this->filterData_active($a);
		#$this->db->from('review_thread as `rt`');
		$this->db->from('reviews as `r`');
		#$this->db->join('`reviews` as `r`', 'r.thread_id = rt.`id`');
		if(!empty($a['doctor_id'])){
			$whereArray['r.doctor_id'] = $a['doctor_id'];
		}
		if(!empty($a['status'])){
			$whereArray['r.status'] = $a['status'];
		}else{
			$whereArray['r.status'] = 1;
		}

		$this->db->where($whereArray);
		
		$query = $this->db->get();

		if($query->num_rows>0){
			foreach ($query->result_array() as $row){
				$res[] =  $row;
			}
		}
		if(isset($a['count'])){
			$this->getReviewsCountByPageId($a);
		}
		return $res;
	}
	function getReviewsCountByPageId($a=array()){
		$res = false;$whereArray = array();

		$this->filterData_active($a);
		#$this->db->from('review_thread as `rt`');
		$this->db->from('reviews as `r`');
		#$this->db->join('`reviews` as `r`', 'r.thread_id = rt.`id`');
		if(!empty($a['doctor_id'])){
			$whereArray['r.doctor_id'] = $a['doctor_id'];
		}
		if(!empty($a['status'])){
			$whereArray['r.status'] = $a['status'];
		}else{
			$whereArray['r.status'] = 1;
		}

		$this->db->where($whereArray);
		
		$this->row_count = $this->db->count_all_results();
		

	}
	function insertReviewThread($a=array()){
		$rs = $this->db->insert('review_thread',$a);
		if($rs){
			return $this->db->insert_id();
		}else{
			return false;
		}
	}
	function insertReviewBatch($a=array()){
		$rs = $this->db->insert_batch('reviews', $a); 
		if($rs){
			return $this->db->insert_id();
		}else{
			return false;
		}
	
	}
	function get_all_reviews($doctor_id)
	{
		$this->db->from('reviews');
		$this->db->where('doctor_id', $doctor_id);
		$this->db->where('status', '1');
		$this->db->where('comment <>', '');
		$this->db->order_by('added_on', 'desc');
		$query = $this->db->get();
		return $query->result();
	}
	
	function insert_review($doctorid, $message, $rating, $name, $email, $fbid, $status=0)
	{
		$data = array(
		'doctor_id'	=>	$doctorid,
		'name'		=>	$name,
		'email'		=>	$email,
		'image'		=>	'https://graph.facebook.com/'.$fbid.'/picture?type=normal',
		'comment'	=>	urldecode($message),
		'rating'	=>	$rating,
		'status'	=>	$status
		);
		$rs	=	$this->db->insert('reviews', $data);
		if($rs)
		{
			return $this->db->insert_id();
		}
		return false;
		
	}
	
	function get_happy_reviews_count($doctor_id)
	{
		$this->db->from('reviews');
		$this->db->where('doctor_id', $doctor_id);
		$this->db->where('status', '1');
		$this->db->where('rating between 1 and 2', NULL, FALSE);
		return $this->db->count_all_results();
	}
	function __toString()
	{
		return $this->db->last_query();
	}
}