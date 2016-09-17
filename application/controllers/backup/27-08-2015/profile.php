<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');
class Profile extends CI_Controller
{
	private $data = array();
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('common_model','user_model'));
		$this->data 	= $this->common_model->getAllData();
		$this->data['class_name'] = $this->router->fetch_class();
	}
	
	public function doctor($city_name = '',$url_name = '')
	{
		$this->load->config('facebook');
		if(empty($url_name) || empty($city_name))
		{
			$this->load->view('errors/page_missing',$this->data);
		}

		$this->load->model(array('clinic_model','doctor_model','package_registration_model','reviews_model','common_model'));
		if(is_numeric($city_name))
		{
			$search_array	=	array('id'=>$city_name,'column'=>array('doc.url_name','cli.city_id'),'limit' =>1,'status'=>1);
			$doctor 			= $this->doctor_model->getDoctorById($search_array);
			if(is_array($doctor) && sizeof($doctor)>0)
			{
				$doctor	=	 current($doctor);
				$city = $this->common_model->getCity(array('limit'=>1,'column'=>array('id','name'),'id'=>$doctor['city_id'],'status'=>array(1,2)));
				redirect(url_string("/".$city[0]['name']."/profile/".$doctor['url_name']), 'location', 301);
			}
		}

		$this->data['method_name'] = 'doctor';
		$city_detail 	= $this->common_model->setCurrentCity(array('cityName'=>$city_name));
		$this->data['cityId'] = $city_detail[1];
		$this->data['cityName'] = $city_detail[0];
		
		$search_array	=	array('url_name'=>$url_name,'city_id'=>$this->data['cityId'],'detail'=>TRUE,'column'=>array('doc.user_id','doc.id as doctor_id','doc.gender as doctor_gender','doc.name as doctor_name','doc.summary','doc.image as doctor_image','doc.speciality','doc.other_speciality','doc.qualification as qualification','doc.yoe','doc.is_ver_reg','doc.health_utsav'),'limit' =>1);
		$search_array['status']	=	1;
		
		if(isset($_GET['ck']))
		{
			$search_array['status']	=	array(1,0);
		}
		
		$this->data['doctor'] = $this->doctor_model->getDoctorById($search_array);
		$this->data['location'] = $this->common_model->getLocation(array('status' =>ACTIVE,'city_id'=>$this->data['cityId'],'orderby'=>'name asc','column'=>array('id','name','url_name')));
		$this->data['speciality'] = $this->common_model->getSpecialityByCity(array('city_id'=>$this->data['cityId'],'orderby'=>'name asc','column'=>array('name','url_name')));
		if(is_array($this->data['doctor']) && sizeof($this->data['doctor']) > 0)
		{
			$this->data['doctor'] = current($this->data['doctor']);

			$this->data['doctor']['specialityStr'] = '';
			if(!empty($this->data['doctor']['speciality']))
			{
				$this->data['doctor']['speciality'] = $this->common_model->getSpeciality(array('ids'=>$this->data['doctor']['speciality'],'column'=>array('name','id','url_name')));
				$this->data['doctor']['specialityStr'] = '';
				if(is_array($this->data['doctor']['speciality']))
				{
					foreach($this->data['doctor']['speciality'] as $spKey=>$spVal)
					{
						$this->data['doctor']['specialityStr'] .= $spVal['name'].", ";
					}
				}
				$main_speciality	=	$this->data['doctor']['specialityStr'] = trim($this->data['doctor']['specialityStr'],", ");
			}
			if(!empty($this->data['doctor']['other_speciality']))
			{
				$this->data['doctor']['specialityStr'] .= " ".$this->data['doctor']['other_speciality']; 
			}


			$this->data['doctor']['qualificationStr'] = '';
			if(!empty($this->data['doctor']['qualification']))
			{
				$this->data['doctor']['qualification'] = $this->common_model->getQualification(array('ids'   =>$this->data['doctor']['qualification'],'limit' =>100,'column'=>array('name','id')));
				$this->data['doctor']['qualificationStr'] = '';
				if(is_array($this->data['doctor']['qualification']))
				{
					foreach($this->data['doctor']['qualification'] as $spKey=>$spVal)
					{
						$this->data['doctor']['qualificationStr'] .= $spVal['name'].", ";
					}
				}
				$this->data['doctor']['qualificationStr'] = trim($this->data['doctor']['qualificationStr'],", ");
			}
			if(!empty($this->data['doctor']['other_qualification']))
			{
				$this->data['doctor']['qualificationStr'] .= " ".$this->data['doctor']['other_qualification']; 
			}

			$package = $this->doctor_model->get_all_doctor_packages($this->data['doctor']['user_id']); 
			$this->data['doctor']['quick_appointment']	=	0;
			if(isset($package[0]->package_id) && $package[0]->package_id==30)
			{
				$this->data['doctor']['quick_appointment']	=	1;
			}					
			
			$title_location	=	'';
			$title_city	=	'';
			$clinicData = $this->clinic_model->getClinicScheduleByDoctorId(array('doctor_id'=>$this->data['doctor']['doctor_id'],'column'   =>array('cli.name as clinic_name','cli.address as clinic_address','cli.location_id','cli.id as clinic_id','cli.timings','cli.duration','cli.doctor_id','cli.latitude as clinic_latitude','cli.longitude as clinic_longitude','cli.consultation_fees','cli.tele_fees','cli.online_fees','cli.express_fees','cli.image as clinic_images','cli.is_number_verified')));
			if(is_array($clinicData) && sizeof($clinicData) > 0)
			{
				#print_r($clinicData);exit;
				foreach($clinicData as $clKey=>$clVal)
				{
					#echo $clVal['location_id'];exit;
					if($clVal['location_id'])
					{
						$clVal['location'] = $this->common_model->getLocation(array('id'    =>$clVal['location_id'],'join'  =>array('city'),'column'=>array('lc.id','lc.name as location_name','ci.name as city_name','lc.longitude as `location_longitude`','lc.latitude as `location_latitude`','lc.url_name')));
	
						$clVal['location'] = current($clVal['location']);
						$title_location .=	ucwords($clVal['location']['location_name']).", ";
						if(empty($title_city))
						{
							$title_city =	$clVal['location']['city_name'];
						}						
					}
					
					if(!empty($clVal['clinic_images']))
					{
						$clVal['clinic_images']	=	 explode(",",$clVal['clinic_images']);
					}
					$clVal['disptimings'] = $this->clinic_model->get_clinic_formatted_time($clVal['timings']);
					$clinicData[$clKey] = $clVal;
				}
				$title_location = trim($title_location,", ");
				$this->data['clinicData'] = $clinicData;
			}
			$loginchk = $this->checksession();
			if($loginchk === TRUE)
			{
				$this->data['loginchk'] = 1;
			}
			else
			{
				$this->data['loginchk'] = 0;				
			}
			$this->data['happy_reviews_count'] = $this->reviews_model->get_happy_reviews_count($this->data['doctor']['doctor_id']);
			$this->data['reviews'] = $this->reviews_model->get_all_reviews($this->data['doctor']['doctor_id']);
			$this->data['doctor_id'] = $this->data['doctor']['doctor_id'];
			$this->data['metadata']['title']	=	"Dr. ".$this->data['doctor']['doctor_name']." - ".$this->data['doctor']['specialityStr']." in ".$title_city.", ".$title_location." | Book Dr Appointment";
			$this->data['metadata']['description'] = "Dr.".$this->data['doctor']['doctor_name']." is a specialized in ".$this->data['doctor']['specialityStr']." with qualification ".$this->data['doctor']['qualificationStr'];
			
			$this->load->view('doctor_profile',$this->data);
		}
		else
		{
			$this->load->view('errors/page_missing',$this->data);
		}
	}
	
	function postreview()
	{
		$this->load->model('reviews_model');
		if(isset($_SERVER['HTTP_REFERER']))
		{
			$doctorid = $_REQUEST['doctorid'];
			$message = $_REQUEST['message'];
			$rating = $_REQUEST['rating'];
			$name = $_REQUEST['name'];
			$email = $_REQUEST['email'];
			$fbid = $_REQUEST['fbid'];
			
			$this->reviews_model->insert_review($doctorid, $message, $rating, $name, $email, $fbid);	
			$this->session->set_userdata('message','1');
		}
	}
	
	function checksession()
	{
		$session_userid   = $this->session->userdata('id');
		if(empty($session_userid))
		{
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	
	function set_url_in_session()
	{
		$this->session->set_userdata('redirect_url', $_SERVER['HTTP_REFERER']);
	}
}
/* End of file home.php */
/* Location: ./application/controllers/home.php */