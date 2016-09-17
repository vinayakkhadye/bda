<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');
class Health_utsav extends CI_Controller
{
	private $data = array();
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('common_model','user_model','location_model','page_model','clinic_model'));
	}
	public function index($city)
	{
		$this->load->model('doctor_model');
		$this->data = $this->common_model->getAllData();
		$city_detail = $this->common_model->setCurrentCity(array('cityName'=>$city));
		$this->data['cityId'] = $city_detail[1];
		$this->data['cityName'] = $city_detail[0];
		$cityName = ucfirst($this->data['cityName']);
		$this->data['class_name'] = $this->router->fetch_class();
		$this->data['method_name'] = 'index';
		
		$this->data['query']['pageId'] 		= $pageId = isset($this->get['page'])?$this->get['page']:1;		
		$this->data['query']['city'] 			= $this->data['cityName'];
		
		$this->load->helper('string');
		$offset	= ($pageId - 1) * LIMIT;
		$this->data['location'] = $this->common_model->getLocation(array('status' =>ACTIVE,'city_id'=>$this->data['cityId'],'orderby'=>'name asc','column'=>array('id','name','url_name')));
		$this->data['speciality'] = $this->common_model->getSpecialityByCity(array('city_id'=>$this->data['cityId'],'orderby'=>'name asc','column'=>array('name','url_name')));		
		$this->load->model(array('doctor_model','reviews_model'));

		$column = array('doc.id as doctor_id','doc.user_id','doc.name as doctor_name','doc.gender as doctor_gender','doc.summary','cli.location_id as clinic_location_id','doc.image as doctor_image','doc.speciality','doc.qualification as qualification','doc.yoe','doc.is_ver_reg','doc.url_name','cli.health_utsav','cli.id as clinic_id','cli.name as clinic_name','cli.tele_fees','cli.online_fees','cli.express_fees','cli.timings','cli.duration','cli.consultation_fees','cli.image as \'clinic_images\'','cli.is_number_verified');
		$searchArray = array('offset' =>$offset,'limit'  =>LIMIT,'count'  =>1,'column' =>$column,'city_id'=>$this->data['cityId']);

			$searchArray['orderby'] = 'doc.`sponsored` DESC, doc.`paid` DESC, doc.`sort` DESC, doc.`image` DESC, doc.`is_ver_reg` DESC';
			
			$searchArray['status'] = 1;
			$searchArray['health_utsav'] = 1;
			if(isset($_GET['place']))
			{
				$searchArray['health_utsav_place'] = $_GET['place'];
			}
			$cityName = ucfirst($this->data['cityName']);
			$this->data['metadata']['title'] = 'Find Doctors and Clinics in '.$cityName.(($pageId>1)?' | Page - '.$pageId:'.');
			$this->data['metadata']['description'] = 'Find Doctors and Clinics in '.$cityName.'. Book confirmed doctor appointments online for FREE, view clinic address &amp; timings, and access your health records online. Book Doctor appointment.';
			$this->data['metadata']['keywords'] = 'Find Doctors and Clinics in '.$cityName.'. Book confirmed doctor appointments online for FREE, view clinic address &amp; timings, and access your health records online. Book Doctor appointment.';
			$this->data['metadata']['h1_text'] = '';
			$doctors = $this->doctor_model->getDoctorByName($searchArray);
		
	
		if(isset($_GET['t']))
		{
			echo $this->doctor_model;exit;
		}
		
		$this->page_model->url = BASE_URL.$city."/health-utsav/?page={page}";
		$this->page_model->url_first = BASE_URL.$city."/health-utsav/";
		
		$this->page_model->total = $this->doctor_model->row_count;
		$this->page_model->page = $pageId;
		$this->page_model->limit = LIMIT;
		$this->data['page_id']	=	$pageId;
		$this->data['pagination'] = $this->page_model->render();

		if(isset($this->data['pagination']['nextPage']))
		{
			$this->data['metadata']['next_url'] = $this->data['pagination']['nextPage']['url'];
		}
		if(isset($this->data['pagination']['prePage']))
		{
			$this->data['metadata']['prev_url'] = $this->data['pagination']['prePage']['url'];
		}

		if(is_array($doctors) && sizeof($doctors) > 0)
		{
			$qualification_data	=	$this->common_model->getQualification(array('column'=>array('name','id'),'id_as_key'=>TRUE));
			$speciality_data = $this->common_model->getSpeciality(array('column'=>array('name','id'),'id_as_key'=>TRUE));
			foreach($doctors as $key=>$val)
			{
				$val['specialityStr'] = '';
				if(!empty($val['speciality']))
				{
					$val['speciality']	=	explode(',',$val['speciality']);
					foreach($val['speciality'] as $spKey=>$spVal)
					{
						$val['specialityStr'] .= $speciality_data[$spVal]['name'].", ";
					}
					$val['specialityStr'] = trim($val['specialityStr'],", ");
				}
				if(!empty($val['other_speciality']))
				{
					$val['specialityStr'] .= " ".$val['other_speciality']; 
				}
				if(isset($this->data['query']['speciality']))
				{
					$val['specialityStr'] = $this->data['query']['speciality'];
				}
				$val['qualificationStr'] = '';
				if(!empty($val['qualification']))
				{
					$val['qualification']	=	explode(',',$val['qualification']);
					foreach($val['qualification'] as $spKey=>$spVal)
					{
						$val['qualificationStr'] .= $qualification_data[$spVal]['name'].", ";
					}
					$val['qualificationStr'] = trim($val['qualificationStr'],", ");
				}
				if(!empty($val['other_qualification']))
				{
					$val['qualificationStr'] .= " ".$val['other_qualification']; 
				}
				if(empty($val['doctor_image']))
				{
					if(strtolower($val['doctor_gender']) == "m")
					{
						$val['doctor_image'] = BASE_URL."static/images/default_doctor.png";
					}else if(strtolower($val['doctor_gender']) == "f")
					{
						$val['doctor_image'] = BASE_URL."static/images/female_doctor.jpg";
					}else if(strtolower($val['doctor_gender']) == "o")
					{
						$val['doctor_image'] = BASE_URL."static/images/default_404.jpg";
					}else
					{
						$val['doctor_image'] = BASE_URL."static/images/default_404.jpg";
					}
				}
				else
				{
					if(strpos($val['doctor_image'],"http") !== false)
					{
						$val['doctor_image'] = $val['doctor_image'];
					}
					else
					{
						$val['doctor_image'] = BASE_URL.$val['doctor_image']."?wm";
					}
				}
				
				$val['package'] = $this->doctor_model->get_all_doctor_packages($val['user_id']);
				$val['quick_appointment']	=	0;
				if(isset($val['package'][0]->package_id) && $val['package'][0]->package_id==30)
				{
					$val['quick_appointment']	=1;
				}
				$val['disptimings'] = $this->clinic_model->get_clinic_formatted_time($val['timings']);
				if(isset($this->data['location'][$val['clinic_location_id']]) && !empty($val['clinic_location_id']))
				{
					$val['clinic_location_name'] = $this->data['location'][$val['clinic_location_id']]['name'];
				}
				else
				{
					$val['clinic_location_name'] = "";
				}

				if(!empty($val['clinic_images']))
				{
					$val['clinic_images']	=	 explode(",",$val['clinic_images']);
				}
				$val['consultation_fees'] = $this->doctor_model->get_clinic_consultation_fees($val['consultation_fees']);
				$val['happy_reviews_count'] = $this->reviews_model->get_happy_reviews_count($val['doctor_id']);

				unset($val['speciality'],$val['qualification']);
				$doctors[$key] = $val;
			}

			$this->data['doctors'] = $doctors;
			if(isset($this->data['query']['speciality']))
			{		
				$this->data['query']['speciality'] = str_replace("-"," ",$this->data['query']['speciality']);
			}
	
			if(isset($this->data['query']['query']))
			{
				$this->data['query']['query'] = str_replace("-"," ",$this->data['query']['query']);
			}
			$this->load->view('search.php',$this->data);			
		}
		else
		{
			$this->load->view('errors/page_missing',$this->data);
		}
	}
}
/* End of file home.php */
/* Location: ./application/controllers/home.php */