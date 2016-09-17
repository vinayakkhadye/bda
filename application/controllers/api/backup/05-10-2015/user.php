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
class User extends REST_Controller
{
	private $log_file = ""; 
	function __construct()
	{
		parent::__construct();
		$this->load->model(array('user_model'));
	}
	public function log_message($myfile,$query)
	{
		fwrite($myfile, $query);
		return false;
	}
	function login_post()
	{
		$rs = array("message"=>"Please provided type as facebook or google or normal.","status" =>0);
		$type = $this->post('type'); #normal facebook google
		$t = $this->post('t'); #test api
		if($type == "facebook")
		{
			$facebook_id = $this->post('facebook_id');
			if($facebook_id){
				$fb_user = $this->user_model->check_fbuser_exists($facebook_id);
				if(!$fb_user){
					$rs = array("message"     =>"Facebook ID not registered.","status"      =>0,"request_type"=>$type);
				}
				else
				{
					$rs = $this->user_model->get_all_userdetails($fb_user->user_id);
				}
			}
			else
			{
				$rs = array("message"     =>"Please Provide Facebook ID.","status"      =>0,"request_type"=>$type);
			}
		}
		else if($type == "google")
		{
			$google_id = $this->post('google_id');
			if($google_id){
				$google_user = $this->user_model->check_googleuser_exists($google_id);
				if(!$google_user){
					$rs = array("message"     =>"Google ID not registered.","status"      =>0,"request_type"=>$type);
				}
				else
				{
					$rs = $this->user_model->get_all_userdetails($google_user->user_id);
				}
			}
			else
			{
				$rs = array("message"     =>"Please Provide Google ID.","status"      =>0,"request_type"=>$type);
			}
		}
		else if($type == "normal")
		{
			$email_id = $this->post('user_name');
			$password = $this->post('password');
			if($email_id && $password)
			{
				$rs = $this->user_model->check_login($email_id,$password);
				if(!$rs)
				{
					$rs = array("message"     =>"Invalid Email Id or Password","status"      =>0,"request_type"=>$type);
				}
			}
			else
			{
				$rs = array("message"     =>"Please enter Email Id and Password","status"      =>0,"request_type"=>$type);
			}
		}
		else if($type == "email")
		{
			$email_id = $this->post('user_name');
			if($email_id)
			{
				$rs = $this->user_model->check_login_email($email_id);
				if(!$rs)
				{
					$rs = array("message"     =>"invalid Email Id","status"      =>0,"request_type"=>$type);
				}
			}
			else
			{
				$rs = array("message"     =>"Please enter Email Id","status"      =>0,"request_type"=>$type);
			}
		}
		if($rs)
		{
			if(isset($rs->type) && $rs->type == 2)
			{
				$this->load->model(array('doctor_model','common_model','sms_package_model'));
				$rsDoctor = $this->doctor_model->get_doctor_data($rs->id);
				$package = $this->doctor_model->get_doctor_package_details($rs->id);
				$sms_package_balance = $this->sms_package_model->get_user_packages($rs->id);
				$rs->name	=	"Dr. ".trim(ucwords(str_replace("dr.","",strtolower($rs->name))));
				$rs->device_id	= "";
				if(isset($package) && !empty($package))
				{
					$rs->package = $package;
					$rs->package_id = $package[0]->package_id;
				}
				if($sms_package_balance)
				{
					$rs->total_sms = $sms_package_balance->total_sms;
					$rs->sms_balance = $sms_package_balance->sms_balance;
				}
				if($rsDoctor)
				{
					if(empty($rsDoctor->image))
					{
						if(strtolower($rsDoctor->gender) == "m")
						{
							$rs->image = "./static/images/default_doctor.png";
						}else if(strtolower($rsDoctor->gender) == "f")
						{
							$rs->image = "./static/images/female_doctor.jpg";
						}else if(strtolower($rsDoctor->gender) == "o")
						{
							$rs->image = "./static/images/default_404.jpg";
						}
					}
					#$rs->speciality = $this->common->getSpeciality(array('status'=>ACTIVE,'limit'=>10,'ids'=>$rsDoctor->speciality,'column'=>array('id','name')));
					#$rs->qualification = $this->common->getQualification(array('status'=>ACTIVE,'ids'=>$rsDoctor->qualification,'column'=>array('id','name')));
					$rs->doctor_id = $rsDoctor->id;
				}
				$rs = array("user_data"   =>$rs,"message"     =>"Login Successful","status"      =>1,"request_type"=>$type);
			}
			else if(isset($rs->type) && $rs->type == 1)
			{
				$this->load->model(array('patient_model'));
					if(empty($rs->image))
					{
						if(strtolower($rs->gender) == "m")
						{
							$rs->image = "./static/images/default_404.jpg";
						}
						else
						if(strtolower($rs->gender) == "f")
						{
							$rs->image = "./static/images/default_404.jpg";
						}
					}
					$from = new DateTime($rs->dob);
					$to   = new DateTime('today');
					$age = $from->diff($to)->y;
					$rs->age = $age;
					$rs->patient	=	$this->patient_model->get_patient_details($rs->id);
				
				$rs = array("user_data" =>$rs,"message"=>"Login Successful","status"      =>1,"request_type"=>$type);
			}
		}
		$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
	}
	public function mkpath($path,$perm)
	{
		if(@mkdir($path) or file_exists($path)) return true;
		return ($this->mkpath(dirname($path),$perm) and mkdir($path,$perm));
	}
	public function deleteimage_post()
	{
		$image_path = $this->post('image_path');
		if($image_path)
		{
			$image_path = DOCUMENT_ROOT.$this->post('image_path');
			if(file_exists($image_path))
			{
				$unlink = unlink($image_path);
				if($unlink)
				{
					$rs = array("message"=>" image removed successfully ","status" =>1);
				}
				else
				{
					$rs = array("message"=>"image not removed ","status" =>0);
				}
			}
			else
			{
				$rs = array("message"=>"file does not exists ".$image_path,"status" =>0);
			}
		}
		else
		{
			$rs = array("message"=>"please provide image path","status" =>0);
		}
		$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
	}
	public function imageuploadmulti_post()
	{
		$this->load->model(array('doctor_model'));
		$uploadOk            = 1;
		// Check file size
		/*		if($_FILES['filedata1']['size'] > 500000 || $_FILES['filedata2']['size'] > 500000 || $_FILES['filedata3']['size'] > 500000 || $_FILES['filedata4']['size'] > 500000 || $_FILES['filedata5']['size'] > 500000 )
		{
		$rs = array("message"=>"Sorry, your file is too large.","status" =>0);
		$uploadOk = 0;
		}*/
		// Check file type
		$allowed_image_types = array('image/jpeg','image/gif','image/png');
		if(isset($_FILES['filedata1']['type']) && !in_array($_FILES['filedata1']['type'],$allowed_image_types)){
			$uploadOk = 0;
			$rs[1] = array("message"=>"Sorry, allowed image types are image/jpeg,image/gif,image/png.","status" =>0);
		}
		if(isset($_FILES['filedata2']['type']) && !in_array($_FILES['filedata2']['type'],$allowed_image_types)){
			$uploadOk = 0;
			$rs[2] = array("message"=>"Sorry, allowed image types are image/jpeg,image/gif,image/png.","status" =>0);
		}
		if(isset($_FILES['filedata3']['type']) && !in_array($_FILES['filedata3']['type'],$allowed_image_types)){
			$uploadOk = 0;
			$rs[3] = array("message"=>"Sorry, allowed image types are image/jpeg,image/gif,image/png.","status" =>0);
		}
		if(isset($_FILES['filedata4']['type']) && !in_array($_FILES['filedata4']['type'],$allowed_image_types)){
			$uploadOk = 0;
			$rs[4] = array("message"=>"Sorry, allowed image types are image/jpeg,image/gif,image/png.","status" =>0);
		}
		if(isset($_FILES['filedata5']['type']) && !in_array($_FILES['filedata5']['type'],$allowed_image_types)){
			$uploadOk = 0;
			$rs[5] = array("message"=>"Sorry, allowed image types are image/jpeg,image/gif,image/png.","status" =>0);
		}
		// Check if $uploadOk is set to 0 by an error
		if($uploadOk == 1)
		{
			$clinic_image = array(0=>"",1=>"",2=>"",3=>"",4=>"");
			if(isset($_FILES["filedata1"]["name"]))
			{
				$target_file = $this->createimagepath($_FILES["filedata1"]["name"]);
				if(move_uploaded_file($_FILES["filedata1"]["tmp_name"], $target_file))
				{
					$rs[1] = array("file_path"=>$target_file,"message"  =>"The file ". basename($_FILES["filedata1"]["name"]). " has been uploaded.","status"   =>1);
					$clinic_image[0] = $target_file;
				}
				else
				{
					$rs[1] = array("message"=>"Sorry, there was an error uploading your file.","status" =>0);
				}
			}
			if(isset($_FILES["filedata2"]["name"]))
			{
				$target_file = $this->createimagepath($_FILES["filedata2"]["name"]);
				if(move_uploaded_file($_FILES["filedata2"]["tmp_name"], $target_file))
				{
					$rs[2] = array("file_path"=>$target_file,"message"  =>"The file ". basename($_FILES["filedata2"]["name"]). " has been uploaded.","status"   =>1);
					$clinic_image[1] = $target_file;
				}
				else
				{
					$rs[2] = array("message"=>"Sorry, there was an error uploading your file.","status" =>0);
				}
			}
			if(isset($_FILES["filedata3"]["name"]))
			{
				$target_file = $this->createimagepath($_FILES["filedata3"]["name"]);
				if(move_uploaded_file($_FILES["filedata3"]["tmp_name"], $target_file))
				{
					$rs[3] = array("file_path"=>$target_file,"message"  =>"The file ". basename($_FILES["filedata3"]["name"]). " has been uploaded.","status"   =>1);
					$clinic_image[2] = $target_file;
				}
				else
				{
					$rs[3] = array("message"=>"Sorry, there was an error uploading your file.","status" =>0);
				}
			}
			if(isset($_FILES["filedata4"]["name"]))
			{
				$target_file = $this->createimagepath($_FILES["filedata4"]["name"]);
				if(move_uploaded_file($_FILES["filedata4"]["tmp_name"], $target_file))
				{
					$rs[4] = array("file_path"=>$target_file,"message"  =>"The file ". basename($_FILES["filedata4"]["name"]). " has been uploaded.","status"   =>1);
					$clinic_image[3] = $target_file;
				}
				else
				{
					$rs[4] = array("message"=>"Sorry, there was an error uploading your file.","status" =>0);
				}
			}
			if(isset($_FILES["filedata5"]["name"]))
			{
				$target_file = $this->createimagepath($_FILES["filedata5"]["name"]);
				if(move_uploaded_file($_FILES["filedata5"]["tmp_name"], $target_file))
				{
					$rs[5] = array("file_path"=>$target_file,"message"  =>"The file ". basename($_FILES["filedata5"]["name"]). " has been uploaded.","status"   =>1);
					$clinic_image[4] = $target_file;
				}
				else
				{
					$rs[5] = array("message"=>"Sorry, there was an error uploading your file.","status" =>0);
				}
			}
			if(isset($_POST["clinic_id"]) && is_array($clinic_image) && sizeof($clinic_image) > 0){
				$clinic_id        = $_POST["clinic_id"];
				$db_clinic_images = $this->doctor_model->get_clinic_photo($clinic_id);
				if(!empty($db_clinic_images))
				{
					$db_clinic_images = explode(",",$db_clinic_images);
					foreach($clinic_image as $db_key => $db_val){
						if(!empty($clinic_image[$db_key]))
						{
							$db_clinic_images[$db_key] = $clinic_image[$db_key];
						}
					}
					$image = implode(",",$db_clinic_images);
				}
				else
				{
					$image = implode(",",$clinic_image);
				}
				$affrows = $this->doctor_model->update_clinic_photo($clinic_id, $image);
				if($affrows){
					$rs['clinic'] = array("message"=>"Clinic Photos Updated","status" =>1);
				}
				else
				{
					$rs['clinic'] = array("message"=>"Clinic Photos Not Updated","status" =>0);
				}
			}
			if(!isset($rs)){
				$rs = array("status" =>0,"message"=>"no image uploaded");
			}
		}
		else
		{
			$rs = array("status" =>0,"message"=>"no image uploaded","error"  =>$rs);
		}
		$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
	}
	public function createimagepath($image_name)
	{
		$md        = date('M').date('Y')."/".strtolower(substr($image_name,0,1));// getting the current month, year and fist letter of image for folder name
		$structure = "./media/photos/".$md; // setting the folder path
		// Check if the directory with that particular name is present or not
		if(!is_dir($structure)){
			// If directory not present, then create the directory
			$this->mkpath($structure,0777);
		}
		// setup the image new file name
		$filename      = md5($image_name);
		// Get extension of the file
		$ext           = pathinfo($image_name, PATHINFO_EXTENSION);
		// get the full filename with full path as it needs to be entered in the db
		$filename_path = $structure."/".$filename.".".$ext;
		return $filename_path;
	}
	function is_base64($s)
	{
		return (bool) preg_match('/^[a-zA-Z0-9\/\r\n+]*={0,2}$/', $s);
	}
	public function imageupload_post()
	{
		$base64_image = $this->post('base64_image');
		$image_name   = pathinfo($this->post('image_name'), PATHINFO_BASENAME);
		$ext = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
		
		if(empty($base64_image) || empty($image_name) ){
			$rs = array("message"=>"please provide base64_image and image_name","status" =>0);
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		}
		$isvalidb64 = $this->is_base64($base64_image);
		if(!$isvalidb64){
			// not valid
			$rs = array("message"=>"please provide base64_image in base64 format","status" =>0);
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		}
		#$file_log = DOCUMENT_ROOT."logs/user_image_upload.log";
		#$this->log_file = fopen($file_log, "a+"); 
		
		#$this->log_message($this->log_file,"image_name : ".$image_name.NEW_LINE);
		
		if(empty($ext)){
			$rs = array("message"=>"please provide valid image_name","status" =>0);
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		}
		else
		{
			if(!in_array($ext,array('jpg','gif','jpeg','png'))){
				$rs = array("message"=>"please provide valid image_name with extension 'jpg','gif','jpeg','png'","status" =>0);
				$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
			}
		}
		$md        = date('M').date('Y')."/".strtolower(substr($image_name,0,1));// getting the current month, year and fist letter of image for folder name
		$structure = "./media/photos/".$md; // setting the folder path
		// Check if the directory with that particular name is present or not
		if(!is_dir($structure)){
			// If directory not present, then create the directory
			$this->mkpath($structure,0777);
		}
		// setup the image new file name
		$filename      = md5($image_name);#.rand(10000,99999)
		// Get extension of the file
		$ext           = pathinfo($image_name, PATHINFO_EXTENSION);
		// get the full filename with full path as it needs to be entered in the db
		$filename_path = $structure."/".$filename.".".$ext;
		$decoded_pic   = base64_decode($base64_image);
		#echo $decoded_pic;exit;
		#$this->log_message($this->log_file,"base64_image : ".$base64_image.NEW_LINE);
		
		if(file_put_contents($filename_path, $decoded_pic))
		{
			$image_type = @exif_imagetype($_SERVER['DOCUMENT_ROOT'].ltrim($filename_path,'.'));
			if($image_type)
			{
				$rs = array("image_data"=>$filename_path,"message"   =>"Image uploaded successfully","status"    =>1);
			}
			else
			{
				unlink($filename_path);
				$rs = array("message"            =>"base64_image format is incorrect, image not uploaded.","status"             =>0,"image_uploaded_path"=>BASE_URL.$filename_path);
			}
		}
		else
		{
			$rs = array("message"=>"image not uploaded","status" =>0);
		}
		$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		#return array("image"=>$filename_path);
	}
	function signup_post()
	{
		$this->load->model(array('doctor_model'));
		$data['name'] = ($this->post('name'))?$this->post('name'):'';
		$data['email'] = ($this->post('email'))?$this->post('email'):'';
		$data['pass'] = ($this->post('pass'))?$this->post('pass'):'';
		$data['mob'] = ($this->post('mob'))?$this->post('mob'):'';
		$data['gender'] = ($this->post('gender'))?strtoupper($this->post('gender')):'';
		$data['dob'] = ($this->post('dob'))?$this->post('dob'):'';
		$is_dob	=	strtotime($this->post('dob'));		
		$data['usertype'] = $this->post('usertype');
		$data['device_id'] = $this->post('device_id');
		
		#print_r($data);exit;
		$image_path   = $this->post('image_path');
		$facebook_id  = $this->post('facebook_id');
		$google_id    = $this->post('google_id');
		$google_image = $this->post('google_image');
		if($facebook_id)
		{
			if(!is_numeric($facebook_id)){
				$rs = array("message"    =>"facebook id is invalid","status"     =>0,"description"=>"fb id can be 100000642604255.");
				$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
			}
			if($image_path)
			{
				$filename = $image_path;
			}
			else
			{
				$filename = "http://graph.facebook.com/".$facebook_id."/picture?type=normal";
			}
			$type = "facebook";
		}
		else
		if($google_id)
		{
			if(!is_numeric($google_id)){
				$rs = array("message"    =>"google id is invalid","status"     =>0,"description"=>"google id can be 103240572165896195014.");
				$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
			}
			if($image_path)
			{
				$filename = $image_path;
			}
			else
			{
				$filename = $google_image;
			}
			$type = "google";
		}
		else
		if($image_path)
		{
			$filename = $image_path;
			$type     = "normal";
		}
		else
		{
			$filename = NULL;
			$type = "normal";
		}
		if(empty($data['name'])){
			$rs = array("message"=>"name is mandatory ","status" =>0);
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		}
		if(empty($data['email'])){
			$rs = array("message"=>"email is mandatory ","status" =>0);
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		}
		if(empty($data['pass']) && empty($facebook_id) && empty($google_id))
		{
			$rs = array("message"=>"please provide pass or facebook_id or google_id","status" =>0);
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		}
		
		if(empty($data['mob'])){
			$rs = array("message"=>"Mobile No. is mendatory","status" =>0);
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		}
		if(empty($data['gender'])){
			$rs = array("message"=>"gender is mandatory ","status" =>0);
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		}
		if(empty($data['dob'])){
			$rs = array("message"=>"Date of Birth is mendatory","status" =>0);
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		}
		if(empty($data['usertype'])){
			$rs = array("message"=>"usertype is mandatory ","status" =>0);
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		}
		
		if (!is_numeric($data['mob'])  && strlen($data['mob']) <= 9)
		{
				$rs = array("message"=>"Please Provide valid mobile number","status" =>0);
				$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		}
		if($data['mob']){
			$user_id = $this->user_model->get_all_userdetails_by_contact_number($data['mob']);
			if($user_id){
				$rs = array("message"=>"user mobile number already exists","status" =>0);
				$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
			}
		}
		
		if(!in_array($data['gender'],array('M','F','O')))
		{
				$rs = array("message"=>"Please Provide gender (M,F,O)","status" =>0);
				$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		
		}
		if($is_dob==false)
		{
				$rs = array("message"=>"Please Provide valid dob","status" =>0);
				$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		}
		if($is_dob>time())
		{
				$rs = array("message"=>"Future date cannot be on valid dob","status" =>0);
				$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		}
		if(!in_array($data['usertype'],array('1','2')))
		{
				$rs = array("message"=>"Please Provide usertype (1-patient,2-doctor)","status" =>0);
				$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		
		}
		if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL))
		{
				$rs = array("message"=>"Please Provide valid email","status" =>0);
				$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		}
		if($data['email']){
			$user_id = $this->user_model->get_all_userdetails_byemail($data['email']);
			if($user_id){
				$rs = array("message"=>"user email already exists","status" =>0);
				$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
			}
		}
	
		$file_log = DOCUMENT_ROOT."logs/doctor_signup.log";
		$this->log_file = fopen($file_log, "a+"); 
		$this->log_message($this->log_file,"-----------------------------------".NEW_LINE);
		$this->log_message($this->log_file,"Process Stated :".date("Y-m-d H:i:s").NEW_LINE);
		$this->db->trans_start();
		$user_id = $this->user_model->create_account_app($data,$filename);	
		$this->log_message($this->log_file,"\t Account Created :".$user_id.", Data :". json_encode($data).NEW_LINE);
		if($user_id)
		{
			// Check if the user is using facebbok for Sign up. If yes, then link the user id with the facebbok id
			if(!empty($facebook_id) && is_numeric($facebook_id))
			{
				$this->user_model->link_fbid($user_id,$facebook_id);
				$this->log_message($this->log_file,"\t Link Fb ID :".$facebook_id.NEW_LINE);
			}
			// Check if the user is using google for Sign up. If yes, then link the user id with the google id
			if(!empty($google_id) && is_numeric($google_id))
			{
				$this->user_model->link_googleid($user_id, $google_id);
				$this->log_message($this->log_file,"\t Link Google ID :".$google_id.NEW_LINE);
			}
			if($data['usertype'] == DOCTOR )
			{
				$this->load->model(array('doctor_model'));
				$amount    = 0; // zero package amount
				$packageid = 10; // Smart Listing package id is 10
				$this->doctor_model->update_doctor_package($user_id, $packageid, $amount);
				$packageid	=	20;
				$this->doctor_model->insert_package($user_id, $packageid, $amount, 0);#this we have changed to because we want doctor to get directly Smart Online Reputation Package
				$this->log_message($this->log_file,"\t Package ID :".$packageid." Amount ".$amount.NEW_LINE);
			
				$rs        = $this->user_model->get_all_userdetails($user_id);
				$doctor_id = $this->add_doctor($user_id);
				
				if(!$doctor_id)
				{
					$this->log_message($this->log_file,"\t Doctor Not Added : Error ".$this->db->_error_message()." Query ".$this->db->last_query().NEW_LINE);
					$rs = array("message"=>"doctor not added","status" =>0,"erorr"=>$this->db->_error_message());
					$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code			
				}
				else
				{
					$this->log_message($this->log_file,"\t Doctor Added : Query ".$this->db->last_query().NEW_LINE);
				}
				$rs->doctor_id = $doctor_id;
				if(empty($rs->image))
				{
					if(strtolower($rs->gender) == "m")
					{
						$rs->image = "./static/images/default_doctor.png";
					}
					else
					if(strtolower($rs->gender) == "f")
					{
						$rs->image = "./static/images/female_doctor.jpg";
					}
				}
				$package = $this->doctor_model->get_doctor_package_details($user_id);
				if(is_array($package) && sizeof($package) > 0)
				{
					$rs->package = $package;
					#$rs->package_id = $package->package_id;
					$rs->package_id = $package[0]->package_id;
					#exit;
				}
				$rs = array("user_data"   =>$rs,"request_type"=>$type,"message"=>"Successfully added Doctor","status"      =>1);
			}
			else
			if($data['usertype'] == PATIENT )
			{
				$patient_data = array(
					'email'=>$data['email'],
					'user_id'=>$user_id,
					'name'=>$data['name'],
					'gender'=>$data['gender'],
					'dob' => date('Y-m-d', strtotime($data["dob"])),
					'mobile_number'=>$data['mob'],
					'image'=>$filename
				);
				$patient_id = $this->patient_model->insert_patient($patient_data); 
				if(!$patient_id)
				{
					$this->log_message($this->log_file,"\t Patinet Not Added : Error ".$this->db->_error_message()." Query ".$this->db->last_query().NEW_LINE);
				}
				$rs = $this->user_model->get_all_userdetails($user_id);
				$rs->patient_id	=	$patient_id;
				$rs = array("user_data"=>$rs,"message"  =>"Patient added successfully.","status"   =>1);
				//$rs = array("user_data"=>array("user_id"=>$user_id),"message"  =>"successfully added Patient user","status"   =>1);
			}
		}
		else
		{
			$rs = array("message"=>"user not added","status" =>0);
		}
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE)
		{
				$this->log_message($this->log_file,"Failed Trans Status last error:". $this->db->_error_message().NEW_LINE);
				$rs = array("message"=>"user not added","status" =>0);
				$this->sendsms_model->send_account_not_created($data["mob"]);
		}
		else
		{
			if($data['usertype'] == DOCTOR )
			{
				$this->mail_model->request_for_activation($data["email"], $data["name"]);
				$this->sendsms_model->send_welcome_sms_doctor($data["mob"]);
			}
			if($data['usertype'] == PATIENT)
			{
				$this->mail_model->welcome_patient($data["email"], $data["name"]);
				$this->sendsms_model->send_welcome_sms_patient($data["mob"], $data["email"]);
			}
			
		
		} 		
		$this->log_message($this->log_file,"Process Ended :".date("Y-m-d H:i:s").NEW_LINE);
		$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
	}
	function add_doctor($user_id)
	{
		if($user_id)
		{
			// insert doctor details
			if($this->post('speciality'))$post['speciality'] = $this->post('speciality');
			if($this->post('speciality_other'))$post['speciality_other'] = $this->post('speciality_other');
			if($this->post('degree'))$post['degree'] = $this->post('degree');
			if($this->post('degree_other'))$post['degree_other'] = $this->post('degree_other');
			if($this->post('name'))$post['name'] = $this->post('name');
			$post['regno'] = ($this->post('regno'))? $this->post('regno'):NULL;
			if($this->post('mob'))$post['mob'] = $this->post('mob');
			if($this->post('gender'))$post['gender'] = $this->post('gender');
			$post['council'] = ($this->post('council'))? $this->post('council'):NULL;
			if($this->post('yoe'))$post['yoe'] = $this->post('yoe');
			#print_r($post);exit;
			$doctor_id = $this->doctor_model->insert_doctor_professional_details($post, NULL, $user_id);
			#echo $this->doctor_model;
			#$this->doctor_model->insert_cityid_doctor($user_id, array('city'=>$this->post('city_id'))); # update city_id of doctor according to its city_id
			#echo $this->doctor_model;
			return $doctor_id;
		}
	}
	function delete_post()
	{
		$user_id    = $this->post('user_id');
		$type       = $this->post('type');
		$patient_id = $this->post('patient_id');
		$unlink = $this->post('unlink');
		if($user_id && $type == 2)
		{
			$user_id_arr = explode(",",$user_id);
			if(is_array($user_id_arr) && sizeof($user_id_arr) > 0)
      {
				foreach($user_id_arr as $user_val)
				{
					$this->db->trans_start();
					
					$sql       = "delete from user where id = ".$user_val;
					$this->db->query($sql);
					$sql       = "delete FROM fb_user where user_id = ".$user_val;
					$this->db->query($sql);
					$sql       = "delete FROM google_user where user_id = ".$user_val;
					$this->db->query($sql);
					$sql       = "delete from package_registration where user_id = ".$user_val;
					$this->db->query($sql);
					if($unlink)
					{
						$sql       = "update doctor set user_id = 0 where user_id = ".$user_val;
						$this->db->query($sql);
						$result[$user_val]['user'] = array("message"=>"user unlinked from doctor","status" =>1);
					}
					else
					{
						$sql       = "select id from doctor where user_id = ".$user_val;
						$rsq       = $this->db->query($sql);
						$doctor_data = $rsq->result_array();
						if(is_array($doctor_data) && sizeof($doctor_data)>0)
						{
							$doctor_id = $doctor_data[0]['id'];
	
							$sql       = "delete from doctor where id = ".$doctor_id;
							$this->db->query($sql);
	
							$sql       = "delete from clinic where doctor_id = ".$doctor_id;
							$this->db->query($sql);
							$result[$user_val]['doctor'] = array("message"=>"doctor details deleted successfully","status" =>1);
						}
					}
					$this->db->trans_complete();
					if ($this->db->trans_status() === FALSE)
					{
						$result[$user_val]['trans'] = array("message"=>"transaction failed","status" =>0);
					}
					else
					{
						$result[$user_val]['trans'] = array("message"=>"transaction successfull","status" =>0);
					}
					
					}
				}
    }
		else if($user_id && $type == 1)
		{
			$user_id_arr = explode(",",$user_id);
			if(is_array($user_id_arr) && sizeof($user_id_arr) > 0)
			{
				foreach($user_id_arr as $user_val)
				{
					$this->db->trans_start();
					
					$sql = "delete from user where id = ".$user_val;
					$rs  = $this->db->query($sql);
					$sql       = "delete FROM fb_user where user_id = ".$user_val;
					$this->db->query($sql);
					$sql       = "delete FROM google_user where user_id = ".$user_val;
					$this->db->query($sql);
					$sql       = "delete from package_registration where user_id = ".$user_val;
					$this->db->query($sql);
					$sql = "update patient set user_id =  NULL where user_id = ".$user_val;
					$rs  = $this->db->query($sql);

					$this->db->trans_complete();
					if ($this->db->trans_status() === FALSE)
					{	
						$result[$user_val]['trans'] = array("message"=>"transaction failed","status" =>0);
					}
					else
					{
						$result[$user_val]['trans'] = array("message"=>"transaction successfull","status" =>0);
					}
				}
			}
		}
		else
		{
			$result = array("message"=>"proive user_id, type","status" =>0);
		}
		$this->response(array("response"=>$result), 200); // 200 being the HTTP response code
	}
}