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

class Advertise extends REST_Controller
{
	function __construct()
	{
		parent::__construct();
	}
	public function get_post()
	{
		$this->load->model(array('admin/adminadvertisements_model'));
		$doctor_id = intval($this->post('doctor_id')); 
		$resolution	=	intval($this->post('resolution')); 

		$t	=	$this->post('t'); 
		$rs	= array();
		if(empty($doctor_id))
		{
			$rs = array("message"=>"please provide doctor_id.","status"=>0);
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		}

		$campaing_url=	BASE_URL."/static/images/logo.png";
		
		$data	=	$this->adminadvertisements_model->get_campaign_doctors(0,$doctor_id);
		if(is_array($data) && sizeof($data)>0)
		{
			$data	=	current($data);
			$campaing_data	=	$this->adminadvertisements_model->get_all_details_campaign($data['campaign_id']);

			$updated_on	=	$data['updated_on'];
			$no_of_days	=	$campaing_data['no_of_days'];
			$current_date	=	 date("Y-m-d");
			$subscription_end_date	=	 date("Y-m-d",strtotime($updated_on."+".$no_of_days." days"));
			
			if(strtotime($current_date)<strtotime($subscription_end_date))
			{
				switch($resolution)
				{
					case "mdpiandroid":$campaing_url=BASE_URL.$campaing_data["ad_img_mres"];break;
					case "hdpiandroid":$campaing_url=BASE_URL.$campaing_data["ad_img_hres"];break;
					case "xhdpiandroid":$campaing_url=BASE_URL.$campaing_data["ad_img_hres"];break;
					case "xxhdpiandroid":$campaing_url=BASE_URL.$campaing_data["ad_img_ures"];break;
					case "xxxhdpiandroid":$campaing_url=BASE_URL.$campaing_data["ad_img_ures"];break;
					case "10inch":$campaing_url=BASE_URL.$campaing_data["ad_img_ures"];break;
					case "7inch":$campaing_url=BASE_URL.$campaing_data["ad_img_ures"];break;
					default:$campaing_url=BASE_URL.$campaing_data["ad_img_ures"];break;
				}
				
				$rs = array("campaing_url"=>$campaing_url,"message"=>"successful.","status"=>1);
			}
			else
			{
				#$rs = array("message"=>"package expired for this doctor.","status"=>0);
				$rs = array("campaing_url"=>$campaing_url,"message"=>"successful.","status"=>1);
			}
		}
		else
		{
			#$rs = array("message"=>"no packages applicable for this doctor.","status"=>0);
			$rs = array("campaing_url"=>$campaing_url,"message"=>"successful.","status"=>1);
		}

		$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
	}	

}