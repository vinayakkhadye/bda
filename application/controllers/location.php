<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');

class location extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('location_model');
	}
	
	function index()
	{
		/*
		//json encode example
		$a = array('0',array('10','20'),array('30','40','50'),array());
		print_r($a);
		echo json_encode($a);
		*/
		
		/*
		// conversion of time from 12 hr format to 24 hr format
		$t = "09:00PM";
		echo date('H:i', strtotime($t));
		*/
		
	}
	
	function city()
	{
		$stateid = $this->input->post('state_id');
		$cities = $this->location_model->get_city($stateid);
		if($cities)
		{
			//print_r($cities);
			foreach($cities as $row)
			{
				echo "<option value='$row->id'>{$row->name}</option>";
			}
		}
		else
		{
			echo '0';
		}
	}
	
	function locality()
	{
		$cityid = $this->input->post('city_id');
		$location_id = $this->input->post('location_id');
		$locality = $this->location_model->get_locality($cityid);
		if($locality)
		{
			//print_r($cities);
			foreach($locality as $row)
			{
				echo "<option value='$row->id' ".(($row->id==$location_id)?'selected="selected"':'').">".ucwords($row->name)."</option>";
			}
		}
		else
		{
			echo '0';
		}
	}
	
}