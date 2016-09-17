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

class Masters extends REST_Controller
{
	function __construct()
    {
        parent::__construct();
		$this->load->model(array('common_model','doctor_details_model'));
    }
    function speciality_post()
    {
		$rs = $this->common_model->getSpeciality(array('status'=>array(1,2),'limit'=>1000,'column'=>array('id','name')));
		//$rs1 = $this->common_model->getSpecialization(array('status'=>ACTIVE,'limit'=>1000,'column'=>array('id','name')));
		
		if($rs ){//&& $rs1
			//$rs = array_merge($rs,$rs1);
			foreach($rs as $key=>$val){
				$rs[$key]['name'] = ucwords($val['name']);
			}
			//print_r($rs);exit;
			//$rs = array_unique($rs);
			
			$rs = array("speciality_data"=>$rs,"message"=>"successfull","status"=>1);
		}else{
			$rs = array("message"=>"no specialities found","status"=>0);
		}
        $this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
    }
    function specialization_post()
    {
		$rs = $this->common_model->getSpecialization(array('status'=>ACTIVE,'limit'=>1000,'column'=>array('id','name')));
		
		if($rs ){
			foreach($rs as $key=>$val){
				$rs[$key]['name'] = ucwords($val['name']);
			}
			$rs = array("specialization_data"=>$rs,"message"=>"successfull","status"=>1);
		}else{
			$rs = array("message"=>"no specialization found","status"=>0);
		}
        $this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
    }

    function qualification_post()
    {
		$rs = $this->common_model->getQualification(array('status'=>ACTIVE,'limit'=>1000,'column'=>array('id','name'),'orderby'=>'sort asc'));
		
		if($rs){
			$rs = array("qualification_data"=>$rs,"message"=>"successfull","status"=>1);
		}else{
			$rs = array("message"=>"no qualifications found","status"=>0);
		}
        $this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
    }
    function councils_post()
    {
		$rs = $this->common_model->getCouncils(array('status'=>ACTIVE,'limit'=>1000,'column'=>array('id','name')));
		
		if($rs){
			$rs = array("councils_data"=>$rs,"message"=>"successfull","status"=>1);
		}else{
			$rs = array("message"=>"no councils found","status"=>0);
		}
        $this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
    }
    function college_post()
    {
		$rs = $this->doctor_details_model->getCollege(array('limit'=>500));
		
		if($rs){
			$rs = array("college_data"=>$rs,"message"=>"successfull","status"=>1);
		}else{
			$rs = array("message"=>"no college found","status"=>0);
		}
        $this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
    }
    function membership_post()
    {
		$rs = $this->doctor_details_model->getMembership(array('limit'=>500));
		
		if($rs){
			$rs = array("membership_data"=>$rs,"message"=>"successfull","status"=>1);
		}else{
			$rs = array("message"=>"no membership found","status"=>0);
		}
        $this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
    }
    function services_post()
    {
		$rs = $this->doctor_details_model->getServices(array('limit'=>500));
		
		if($rs){
			$rs = array("services_data"=>$rs,"message"=>"successfull","status"=>1);
		}else{
			$rs = array("message"=>"no services found","status"=>0);
		}
        $this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
    }

		function services_get()
		{
			$name	=	 $this->get('query');
			$rs = $this->doctor_details_model->getServices(array('name'=>$name));
			$new_arr	= array();
			if($rs)
			{
				foreach($rs as $key=>$val)
				{
					$new_arr[$key]['label']	=	$val['name'];
					$new_arr[$key]['value']	=	$val['name'];
				}
			}
			echo  json_encode($new_arr);
			return false;			
		}

		function specializations_get()
		{
			$name	=	 $this->get('query');
			$rs = $this->common_model->getSpeciality(array('status'=>array(1,2),'name'=>$name,'column'=>array('id','name')));
			$new_arr	= array();
			if($rs)
			{
				foreach($rs as $key=>$val)
				{
					$new_arr[$key]['label']	=	$val['name'];
					$new_arr[$key]['value']	=	$val['name'];
				}
			}
			echo  json_encode($new_arr);
			return false;			
		}

		function qualification_get()
		{
			$name	=	 $this->get('query');
			$rs 	= $this->common_model->getQualification(array('status'=>ACTIVE,'column'=>array('id','name'),'orderby'=>'sort asc','name'=>$name));
			$new_arr	= array();
			if($rs)
			{
				foreach($rs as $key=>$val)
				{
					$new_arr[$key]['label']	=	$val['name'];
					$new_arr[$key]['value']	=	$val['name'];
				}
			}
			echo  json_encode($new_arr);
			return false;			
		}
		function college_get()
		{
			$name	=	 $this->get('query');
			$rs 	= $this->doctor_details_model->getCollege(array('status'=>ACTIVE,'column'=>array('id','name'),'orderby'=>'sort asc','name'=>$name));
			$new_arr	= array();
			if($rs)
			{
				foreach($rs as $key=>$val)
				{
					$new_arr[$key]['label']	=	$val['name'];
					$new_arr[$key]['value']	=	$val['name'];
				}
			}
			echo  json_encode($new_arr);
			return false;			
		}		

		function city_get()
		{
			$name	=	 $this->get('query');
			$rs 	= $this->common_model->getCity(array('status'=>ACTIVE,'column'=>array('id','name'),'orderby'=>'sort asc','name_like'=>$name));
			$new_arr	= array();
			if($rs)
			{
				foreach($rs as $key=>$val)
				{
					$new_arr[$key]['label']	=	$val['name'];
					$new_arr[$key]['value']	=	$val['name'];
					$new_arr[$key]['db_id']	=	$val['id'];
				}
			}
			echo  json_encode($new_arr);
			return false;			
		}		
		function location_get()
		{
			$name			=	 $this->get('query');
			$city_id	=	 $this->get('city_id');
			
			$rs 	= $this->common_model->getLocation(array('status'=>ACTIVE,'column'=>array('id','name'),'orderby'=>'sort asc','name_like'=>$name,'city_id'=>$city_id));
			$new_arr	= array();
			if($rs)
			{
				foreach($rs as $key=>$val)
				{
					$new_arr[$key]['label']	=	ucwords($val['name']);
					$new_arr[$key]['value']	=	ucwords($val['name']);
					$new_arr[$key]['db_id']	=	$val['id'];
				}
			}
			echo  json_encode($new_arr);
			return false;			
		}		

		function membership_get()
		{
			$name	=	 $this->get('query');
			$rs = $this->doctor_details_model->getMembership(array('status'=>ACTIVE,'column'=>array('id','name'),'orderby'=>'sort asc','name'=>$name));
			$new_arr	= array();
			if($rs)
			{
				foreach($rs as $key=>$val)
				{
					$new_arr[$key]['label']	=	$val['name'];
					$new_arr[$key]['value']	=	$val['name'];
				}
			}
			echo  json_encode($new_arr);
			return false;			
		}		
		function councils_get()
		{
			$name	=	 $this->get('query');
			$rs = $this->common_model->getCouncils(array('status'=>ACTIVE,'column'=>array('id','name'),'name'=>$name));
			$new_arr	= array();
			if($rs)
			{
				foreach($rs as $key=>$val)
				{
					$new_arr[$key]['label']	=	$val['name'];
					$new_arr[$key]['value']	=	$val['name'];
					$new_arr[$key]['db_id']	=	$val['id'];
				}
			}
			echo  json_encode($new_arr);
			return false;			
		}				
		
		
		

	function packages_post(){
		$this->load->model(array('doctor_model'));
		$rs = $this->doctor_model->get_all_packages();
		
		if($rs){
			$rs = array("packages_data"=>$rs,"message"=>"successfull","status"=>1);
		}else{
			$rs = array("message"=>"no packages found","status"=>0);
		}
        $this->response(array("response"=>$rs), 200); // 200 being the HTTP response code

		
	}	
	
 	function year_range_post(){
		$rs = range(1960,date("Y"));
		$rs = array("year_range"=>$rs,"message"=>"successfull","status"=>1);
	    $this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
	
	}   
 	function tnc_post(){
		$tnc = $this->load->view('tnc_app',array(),true);
		
		$rs = array("response"=>array("tnc_data"=> htmlspecialchars($tnc),"message"=>"successfull","status"=>1));
		echo json_encode($rs);
	   # $this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
	
	}   

}