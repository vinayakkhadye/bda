<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');

class generate_random_reviews extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->perms		=	$this->session->userdata('allowed_perms'); 
		$admin_home_url	=	$this->session->userdata('admin_home_url');
		if(empty($adminid)){
			redirect(($admin_home_url)?$admin_home_url:'/bdabdabda');
			exit();
		}
	}

	function generate_reviews($limit = 10, $start_doctorid = 1, $end_doctorid = 999999999)
	{
		$this->db->select('id,gender,speciality');
		$this->db->from('doctor');
		$this->db->where("id between $start_doctorid and $end_doctorid");
		$this->db->limit($limit);
		$query = $this->db->get();
		$res = $query->result();
		/*echo '<pre>';
			print_r($res);
		echo '</pre>';*/
		$narray = array();
		foreach($res as $row)
		{
			$limit = rand(3,6);
			$this->db->select('`review`,`review_gender`,`review_spec`,(SELECT lname FROM random_names ORDER BY RAND() LIMIT 1) AS lname,fname,gender');
			$this->db->from('random_names,random_reviews');
			$this->db->where('review_spec IN ('.$row->speciality.') OR review_spec IS NULL', '', false);
			$this->db->where('gender', $row->gender);
			$this->db->order_by('RAND()', 'asc');
			$this->db->limit($limit);
			$query = $this->db->get();
//			echo $this->db->last_query();
			$row2 = $query->result();
			/*echo '<pre>';
				print_r($row2);
			echo '</pre>';*/
			foreach($row2 as $rev)
			{
				$review_arr = array();
				$review_arr['doctor_id'] = $row->id;
				$review_arr['name'] = $rev->fname.' '.$rev->lname;
				$review_arr['comment'] = $rev->review;
				$review_arr['added_on']	= date('Y-m-d');
				$review_arr['status'] = '0';
				$narray[$row->id][] = $review_arr;
				unset($review_arr);
			}
		}
		echo '<pre>';
//			print_r($narray);
		echo '</pre>';
		
		$newnarray = array();
		foreach($narray as $docarray)
		{
			$dates_arr = array();
			$size = sizeof($docarray);
//			echo 'Size of DocArray: '.$size;
//			echo "<br>";
			$dates_arr = $this->get_random_dates($size);
//			echo "<br>";
//			echo sizeof($dates_arr);
//			echo '<pre>';
//				print_r($dates_arr);
//			echo '</pre>';
			$i = 0;
//			echo 'size of returned array:'.sizeof($dates_arr);
			
			foreach($dates_arr as $key => $value){
				$docarray[$i]['date'] = $value;
				$i++;
			}
			echo '<pre>';
//				print_r($docarray);
			echo '</pre>';
			$newnarray[] = $docarray;
		}
		echo '<pre>';
//			print_r($newnarray);
		echo '</pre>';
		foreach($newnarray as $newrow)
		{
			foreach($newrow as $newrow2)
			{
				echo '<pre>';
//				print_r($newrow2);
				echo '</pre>';
				
				$data = array(
					'doctor_id'=>	$newrow2['doctor_id'],
					'name'     =>	$newrow2['name'],
					'rating'   =>	rand(1,2),
					'comment'  =>	$newrow2['comment'],
					'added_on' =>	$newrow2['date'],
				);
				$this->db->insert('reviews_temp', $data);
				echo $this->db->last_query();
				unset($data);
			}
		}
		
	}
	
	function get_random_dates($size)
	{
		do
		{
			$st = 0;
			$nn = array();
			for($n=0; $n<$size; $n++)
			{
				echo $rand_date = $this->rand_date();
				$interval = $this->datediff($rand_date,date('Y-m-d', time()));
				$nn[$interval] = $rand_date;
				echo "<br>";
			}
			ksort($nn);
	//		$interval = key($nn);
			reset($nn);
			$k = key($nn);
	//		echo "<br>";
			foreach($nn as $keyval)
			{
				if(key($nn) != '')
				{
					/*echo 'Current key: '.key($nn);
					echo "<br>";
					echo 'Difference between keys: '.(key($nn) - $k);
					echo "<br>";*/
					if((key($nn) - $k) <= 3)
					{
						$st = 1;
					}
					$k = key($nn);
	//				echo "<br>";
					next($nn);
				}
	//			echo 'st value: '.$st;
			}
			echo sizeof($nn).'<br/>'.sizeof($size).'<br/><br/>';
		}
//		echo '<br/>s: '.sizeof($nn).'<br/>';
//		echo '<br/>s2: '.$size.'<br/>';
		while($st == 0 && sizeof($nn) == $size);
		return $nn;
		
		/*echo '<pre>';
			print_r($nn);
		echo '</pre>';*/
	}
	
	function datediff($date1,$date2)
	{
		$datetime1 = date_create(date('d-m-Y', strtotime($date1)));
		$datetime2 = date_create(date('d-m-Y', strtotime($date2)));
		$interval = date_diff($datetime1, $datetime2);
		return $interval = $interval->format('%a');
	}

	function rand_date()
	{
		$min_epoch = strtotime(date('d-m-Y').'-4 months');
		$max_epoch = strtotime(date('d-m-Y').'-1 day');

		$rand_epoch = rand($min_epoch, $max_epoch);

		return date('Y-m-d', $rand_epoch);
	}

}