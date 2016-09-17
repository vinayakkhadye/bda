<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Example
 *
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array.
 *
 * @package		CodeIgniter
 * @subpackage	Rest Server
 * @category	Controller
 * @author		Phil Sturgeon
 * @link		http://philsturgeon.co.uk/code/
*/

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH.'/libraries/REST_Controller.php';

class Location extends REST_Controller
{
	function __construct()
    {
        parent::__construct();
    }
    function index_post()
    {
			$city_id = intval($this->post('city_id'));
			if(empty($city_id))
			{
				$rs = array("message"=>"Please provide city_id","status"=>0);
				$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code	
			}
			
			$this->load->model(array('location_model'));
			$rs = $this->location_model->get_location($city_id);
			if($rs)
			{
				foreach($rs as $key=>$val)
				{
					$rs[$key]->name = ucwords($val->name);
				}
				$rs = array("location_data"=>$rs,"message"=>"successfull","status"=>1);
			}
			else
			{
				$rs = array("location_data"=>array(),"message"=>"no location found for this city","status"=>0);
			}
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
    }

    function city_post()
    {
			$state_id = $this->post('state_id');
			$is_patient = $this->post('is_patient');
			$this->load->model(array('location_model','common_model'));
			$rs_main	=	$rs_other	=	array();
			if($state_id){
				$rs_main = $this->location_model->get_city($state_id,array('status'=>array(1,2)));
				if(!$is_patient)
				{
					$rs_other = $this->location_model->get_city($state_id,array('status'=>0));
				}
			}else{
				if($is_patient)
				{
					#$rs_main = $this->common_model->getCity(array('status'=>1,'orderby'=>'sort asc','column'=>array('id','name')));
					$rs_main = $this->location_model->get_city(0,array('status'=>array(1),'orderby'=>array('sort','asc')));
				}
				else
				{
					$rs_main = $this->location_model->get_city(0,array('status'=>array(1,2)));
					$rs_other = $this->location_model->get_city(0,array('status'=>0));
				}
			}

			foreach($rs_main as $key=>$val){
				if(isset($val->name))
				{
					$rs_main[$key]->name = ucwords($val->name);
				}
				else if(isset($val['name']))
				{
					$rs_main[$key]->name = ucwords($val['name']);
				}
			}
			foreach($rs_other as $key=>$val){
				$rs_other[$key]->name = ucwords($val->name);
			}
			$rs	=	array_merge($rs_main,$rs_other);
			if($rs){
				$rs = array("city_data"=>$rs,"message"=>"successful","status"=>1);
			}else{
				$rs = array("message"=>"no city found for this state","status"=>0);
			}
					$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
    }
    function main_city_post()
    {
			
			$this->load->model(array('location_model'));
			$rs = $this->location_model->get_city(0,array('status'=>1));
					
			foreach($rs as $key=>$val){
				$rs[$key]->name = ucwords($val->name);
			}
			if($rs){
				$rs = array("city_data"=>$rs,"message"=>"successfull","status"=>1);
			}else{
				$rs = array("message"=>"no city found","status"=>0);
			}
					$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
    }		
    function other_city_post()
    {
			$this->load->model(array('location_model'));
			$rs = $this->location_model->get_city(0,array('status'=>0));
					
			foreach($rs as $key=>$val){
				$rs[$key]->name = ucwords($val->name);
			}
			if($rs){
				$rs = array("city_data"=>$rs,"message"=>"successfull","status"=>1);
			}else{
				$rs = array("message"=>"no city found","status"=>0);
			}
					$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
    }		

    function state_post()
    {
		$this->load->model(array('location_model'));
        $rs = $this->location_model->get_state();
		if($rs){
			$rs = array("state_data"=>$rs,"message"=>"successfull","status"=>1);
		}else{
			$rs = array("message"=>"no state found for this country","status"=>0);
		}
        $this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
    }
		public function nearest_location_post()
		{
			
			$latitude		=	$this->post('latitude'); 
			$longitude	=	$this->post('longitude'); 
			$city_id		=	$this->post('city_id'); 
			if(empty($latitude) || empty($longitude) && $city_id)
			{
				$rs = array("message"=>"please provide latitude, longitude and city_id.","status"=>0);
				$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
			}
			if(!is_numeric($city_id))
			{
				$rs = array("message"=>"please provide valid city_id.","status"=>0);
				$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
			}
			$lat_preg	=	preg_match('/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/', $latitude);
			if(empty($lat_preg))
			{
				$rs = array("message"=>"please provide valid latitude.","status"=>0);
				$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
			}
	
			$lng_preg	=	preg_match('/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/', $longitude);
			if(empty($lng_preg))
			{
				$rs = array("message"=>"please provide valid longitude.","status"=>0);
				$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
			}

			$this->load->model(array('location_model'));
			$rs	=	$this->location_model->get_location_orderby_latlng($latitude,$longitude,$city_id,1);
			if(is_array($rs) && sizeof($rs)>0)
			{
				$rs	=	 current($rs);
				$rs['distance']	=	number_format($rs['distance'],2);
				$rs = array("location_data"=>$rs,"message"=>"successfull","status"=>1);
			}
			else
			{
				$rs = array("message"=>"no location found","status"=>0);
			
			}
				$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		
		}
	
    
}