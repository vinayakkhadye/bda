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

class favourite_doctor extends REST_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('favourite_doctor_model');
	}
	
	function add_post()
	{
		$doctor_id	=	intval($this->post('doctor_id'));
		$patient_id	=	intval($this->post('patient_id'));

		if(empty($doctor_id) || empty($patient_id))
		{
			$rs = array("message"=>"please provide patient_id and  doctor_id","status" =>0);
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		}
	
		$rs = $this->favourite_doctor_model->add($doctor_id,$patient_id);			
		if($rs)
		{
			$rs = array("message"=>"Added to favourite successfully","status" =>1);
		}
		else
		{
			$rs = array("message"=>"Oops!! Not added to favourites","status" =>0);
		}
		$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
	}

	function delete_post()
	{
		$id					=	intval($this->post('favourite_doctor_id'));
		$doctor_id	=	intval($this->post('doctor_id'));
		$patient_id	=	intval($this->post('patient_id'));

		if(empty($id) && (empty($doctor_id) || empty($patient_id)))
		{
			$rs = array("message"=>"please provide favourite_doctor_id / doctor_id and patient_id","status" =>0);
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		}
		$rs = $this->favourite_doctor_model->delete($id,$doctor_id,$patient_id);			
		if($rs)
		{
			$rs = array("message"=>"Deleted from favourite successfully","status" =>1);
		}
		else
		{
			$rs = array("message"=>"Oops!! Not deleted from favourite","status" =>0);
		}
		$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
	}

	function get_list_post()
	{
		$patient_id	=	intval($this->post('patient_id'));
		$page_id		=	intval($this->post('page_id'));
		$limit			= LIMIT;
		$offset			= ($page_id - 1) * LIMIT;

		if(empty($patient_id))
		{
			$rs = array("message"=>"please provide patient_id","status" =>0);
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		}

		$a	=	array('limit'=>$limit,'offset'=>$offset);
		$rs = $this->favourite_doctor_model->get_list($patient_id,$a);			
		if($rs)
		{
			$rs = array("data"=>$rs,"status" =>1,"message"=>"successful","count"=>$this->favourite_doctor_model->row_count);
			if($page_id)
			{
				$rs['next_page'] = $page_id+1;
			}
		}
		else
		{
			$rs = array("message"=>"no data available","status" =>0);
		}		
		$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code

	}
	
	}

