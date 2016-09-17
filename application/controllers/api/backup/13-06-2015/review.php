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

class Review extends REST_Controller
{
	function __construct(){
        parent::__construct();
		$this->load->model(array('reviews_model'));
    }
	function list_post(){
		$doctor_id = $this->post('doctor_id');
		$patient_id = $this->post('patient_id');
		$is_patient_app = $this->post('is_patient_app');
		
		$limit = ($this->post('limit'))?intval($this->post('limit')):10;
		$offset = ($this->post('offset'))?intval($this->post('offset')):0;
		
		#if($doctor_id){$page_id = $doctor_id.DOCTOR; }
		#if($patient_id){$page_id = $patient_id.PATIENT; }
		
		if($doctor_id){		
			$reviews_fix = $this->reviews_model->getReviewsByPageId(array('doctor_id'=>$doctor_id,'orderby'=>'r.id desc','limit'=>$limit,'offset'=>$offset,'count'=>1));
			if(is_array($reviews_fix) && sizeof($reviews_fix)>0)
			{
				#print_r()
				foreach($reviews_fix as $key=>$val){
					#print_r($val);exit;
					if($val['comment'])
					{
						$reviews[$key]['patient_name'] = $val['name'];
						$reviews[$key]["patient_phone_number"]= "1234567890";
						$reviews[$key]["patient_image_path"]= $val['image'];
						$reviews[$key]["comment"]= $val['comment'];
						$reviews[$key]["rating"]= $val['rating'];
					}
				}
				$total_rows = $this->reviews_model->row_count;
			}

			if(isset($reviews) && is_array($reviews) && sizeof($reviews)>0)
			{
				$rs = array("review_data"=>$reviews,"review_count"=>$total_rows,"message"=>"successfull","status"=>1);
			}
			else
			{
				$rs = array("message"=>"no reviews available","status"=>0);
				if($is_patient_app==1)
				{
					$reviews	=	array();
				}
				else
				{
					$reviews[0]['patient_name'] = 'Richa Sharma '.$doctor_id;
					$reviews[0]["patient_phone_number"]= "9870456897";
					$reviews[0]["patient_image_path"]= BASE_URL."./media/photos/Jan2015/3/438a0e6d4b658a379b3fa775b723fdf8.jpg";
					$reviews[0]["comment"]= 'A very well experienced Doctor. Overall it was a nice experience!';
					$reviews[0]["rating"]= 3;
					
					$reviews[1]['patient_name'] = 'Devendra Singh';
					$reviews[1]["patient_phone_number"]= "8097568436";
					$reviews[1]["patient_image_path"]= BASE_URL."./media/photos/Jan2015/i/c501ae6c09d98208e748a064da3a5278.JPG";
					$reviews[1]["comment"]= 'The doctor is very talented and his treatment is also very good.';
					$reviews[1]["rating"]= 3;
					
					$reviews[2]['patient_name'] = 'Swati Pawar';
					$reviews[2]["patient_phone_number"]= "7718964454";
					$reviews[2]["patient_image_path"]= BASE_URL."./media/photos/Jan2015/h/e70907bed62ffc1120c1e0be8e76dae8.jpg";
					$reviews[2]["comment"]= 'Good and friendly doctor. Has good knowledge about the treatment.';
					$reviews[2]["rating"]= 3;
					
					$reviews[3]['patient_name'] = 'Nayan Mishra';
					$reviews[3]["patient_phone_number"]= "8286456659";
					$reviews[3]["patient_image_path"]= BASE_URL."./media/photos/Jan2015/s/4fd271798b902b503a790af59db306b9.jpg";
					$reviews[3]["comment"]= 'The treatment is very good. Doctor takes care of each and every small thing and doubts.';
					$reviews[3]["rating"]= 3;
				}
				
				$rs = array("review_data"=>$reviews,"review_count"=>4,"message"=>"successfull","status"=>2);
				
			}
		}else{
			$rs = array("message"=>"please provide doctor_id or patient id","status"=>0);
		}
		$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		
	}
	function post_post()
	{
		
		$doctor_id = $this->post('doctor_id');
		$name = trim($this->post('name'));
		$email_id = $this->post('email_id');
		$facebook_id = $this->post('facebook_id');
		$message = trim($this->post('message'));
		$rating = intval($this->post('rating'));
		
		if(empty($doctor_id) || empty($name) || empty($email_id) || empty($facebook_id)  || empty($rating) )
		{
			$rs = array("message"=>"please provide doctor_id, name, email_id, facebook_id, rating","status"=>0);
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		}

		if(!is_numeric($doctor_id))
		{
			$rs = array("message"    =>"doctor_id is invalid","status"=>0);
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		}		

		if(!is_numeric($rating))
		{
			$rs = array("message"    =>"rating is invalid","status"=>0);
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		}		
		if(!in_array($rating,array(1,2,3,4,5)))
		{
			$rs = array("message"    =>"rating should be in between 1 to 5","status"=>0);
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		}		

		if (!filter_var($email_id, FILTER_VALIDATE_EMAIL))
		{
				$rs = array("message"=>"Please Provide valid email_id","status" =>0);
				$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		}
		if(!is_numeric($facebook_id)){
			$rs = array("message"=>"facebook_id is invalid","status"=>0,"description"=>"fb id can be 100000642604255.");
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		}

		$insert_id	=	 $this->reviews_model->insert_review($doctor_id,$message,$rating,$name,$email_id,$facebook_id);
		if($insert_id)
		{
			$rs = array("message"=>"successfully posted review","status"=>1);
		}
		else
		{
			$rs = array("message"=>"review not posted","status"=>0);
		}
		$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code

	}
}

