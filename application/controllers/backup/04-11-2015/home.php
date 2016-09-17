<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class Home extends CI_Controller
{
	private $data = array();
	public function __construct()
	{
			parent::__construct();
			$this->load->model(array('common_model','user_model','location_model','page_model','clinic_model','doctor_model','reviews_model','boxmanager_model'));
	}
	
	public function _remap($method, $params)
	{
		if (isset($params[3]) && is_numeric($params[3]))
		{
				$url = BASE_URL . $params[0] . "/" . $params[1] . "/" . $params[2]; #."?page=".$params[3];
				redirect($url, 'location', '301');
				exit;
		}
		$this->$method($params);
	}
	
	public function index($params)
	{
		
		$this->data   = $this->common_model->getAllData();
		if(sizeof($params)==0)
		{
			$city_detail  = $this->common_model->setCurrentCity(array());
			$params[0]							=	$city_detail[0];
			$this->data['metadata']['title']         = 'Find trusted Doctors and book appointment | Book Doctor Appointment';
			$this->data['metadata']['canonical_url'] = BASE_URL;
			$this->data['metadata']['keywords']      = 'Book doctor appointment, book doctor appointment for free, book dr appointment, book dr appointment for free, doctor appointment online, doctor appointment online  for free, doctor appointment online free, free doctor appointment online, find doctors fo free';
			$this->data['metadata']['h1_text']       = 'Find Best Doctors';
		}
		else
		{
			$city_detail  = $this->common_model->setCurrentCity(array('cityName' => $params[0]));			
			$cityName                  = ucwords(reverse_url_string($params[0]));
			$this->data['metadata']['title']         = 'Find trusted Doctors in ' . $cityName . ' and book appointment | Book Doctor Appointment';
			$this->data['metadata']['canonical_url'] = BASE_URL;
			$this->data['metadata']['keywords']      = 'Book doctor appointment, book doctor appointment for free, book dr appointment, book dr appointment for free, doctor appointment online, doctor appointment online  for free, doctor appointment online free, free doctor appointment online, find doctors, find doctors in ' . ucfirst(reverse_url_string($params[0])) . ', find doctors ' . $cityName . ' free, find doctors in ' . $cityName . ' for free';
			$this->data['metadata']['h1_text']       = 'Best Doctors in ' . $cityName;
		}
		

		$this->data['cityId']      = $city_detail[1];
		$this->data['cityName']    = $city_detail[0];
		$cityName                  = ucwords(reverse_url_string($this->data['cityName']));
		$this->data['class_name']  = $this->router->fetch_class();
		$this->data['method_name'] = 'index';
		if (isset($params) && is_array($params) && sizeof($params) == 1)
		{
			$this->data['location']	= $this->common_model->getLocation(array('status' => ACTIVE,'city_id' => $this->data['cityId'],'orderby' => 'name asc','column' => array('id','name','url_name')));
			
			$this->data['speciality']     = $this->common_model->getSpecialityByCity(array('city_id' => $this->data['cityId'],'orderby' => 'name asc','column' => array('name','url_name'),'status' => array(1,2)));
			$this->data['top_speciality'] = $this->common_model->getSpecialityByCity(array('status' => 2,'column' => array('sp.id,sp.name,sp.display_name,sp.display_image,sp.url_name'),'city_id' => $this->data['cityId'],'orderby' => 'sp.sort asc'));
			
			$city_incr = 1;
			foreach ($this->data['city'] as $city_val)
			{
				$city_id_array[$city_val['id']]   = $city_val['id'];
				$city_name_array[$city_val['id']] = $city_val['name'];
				if ($city_incr == 6)break;
				$city_incr++;
			}
			$city_top_speciality = $this->common_model->getSpecialityByCity(array('status' => 2,'column' => array('scp.city_id,sp.id,sp.name,sp.display_name,sp.display_image,sp.url_name'),'city_id' => $city_id_array,'orderby' => 'scp.city_id,sp.display_name asc'));
			foreach ($city_top_speciality as $city_top_key => $city_top_val)
			{
					$this->data['city_top_speciality'][$city_name_array[$city_top_val['city_id']]][] = $city_top_val;
			}
			$this->data['platform'] = $this->getOS();
			$health_utsav	=	$this->boxmanager_model->get_data('health_usav',$this->data['cityId']);
			$this->data['health_utsav']	=	'';
			if($health_utsav && is_array($health_utsav))
			{
				$this->data['health_utsav'] = current($health_utsav);
			}
			
			$this->load->view('home', $this->data);
		}
		else if (is_array($params) && sizeof($params) > 1)
		{
			$this->search($params);
		}
	}
	
	public function search($params)
	{
			$this->data['method_name'] = 'search';
			$this->load->helper('string');
			$arr = array('clinic','doctor');
			if (in_array($params[1], $arr))
			{
				$this->data['query']['city']     = $city = isset($params[0]) ? $params[0] : '';
				$this->data['query'][$params[1]] = $$params[1] = $params[1];
				$this->data['query']['query']    = $query = isset($params[2]) ? $params[2] : '';
				$this->data['query']['pageId']   = $pageId = isset($this->get['page']) ? $this->get['page'] : 1;
				$this->page_model->url           = BASE_URL . $city . "/" . $params[1] . "/" . $query . "?page={page}";
				$this->page_model->url_first     = BASE_URL . $city . "/" . $params[1] . "/" . $query;
			}
			else
			{
				$this->data['query']['city']       = $city = isset($params[0]) ? $params[0] : '';
				$this->data['query']['speciality'] = $speciality = isset($params[1]) ? $params[1] : '';
				$this->data['query']['location']   = $location = isset($params[2]) ? $params[2] : 'all';
				$this->data['query']['pageId']     = $pageId = isset($this->get['page']) ? $this->get['page'] : 1;
				$this->data['url_speciality']      = $speciality;
				$this->data['url_location']        = $location;
				$this->page_model->url             = BASE_URL . $city . "/" . $speciality . "/" . $location . "?page={page}";
				$this->page_model->url_first       = BASE_URL . $city . "/" . $speciality .($location=='all'?'':"/".$location);
			}
			$offset                		= ($pageId - 1) * LIMIT;
			$this->data['location']   = $this->common_model->getLocation(array('status' => ACTIVE,'city_id' => $this->data['cityId'],'orderby' => 'name asc',
			'column' => array('id','name','url_name'),'id_as_key'=>TRUE));
			$this->data['speciality'] = $this->common_model->getSpecialityByCity(array('city_id' => $this->data['cityId'],'orderby' => 'name asc','column' => array('name','url_name'),'status' => array(1,2)));
			
			
			$column = array(
					'doc.id as doctor_id',
					'doc.user_id',
					'doc.name as doctor_name',
					'doc.gender as doctor_gender',
					'doc.summary',
					'cli.location_id as clinic_location_id',
					'doc.image as doctor_image',
					'doc.speciality',
					'doc.qualification as qualification',
					'doc.yoe',
					'doc.is_ver_reg',
					'doc.url_name',
					'cli.health_utsav',
					'cli.health_utsav_text',
					'cli.id as clinic_id',
					'cli.name as clinic_name',
					'cli.tele_fees',
					'cli.online_fees',
					'cli.express_fees',
					'cli.timings',
					'cli.duration',
					'cli.consultation_fees',
					'cli.image as \'clinic_images\'',
					'cli.is_number_verified'
			);
			
			$searchArray = array(
					'offset' => $offset,
					'limit' => LIMIT,
					'count' => 1,
					'column' => $column,
					'city_id' => $this->data['cityId']
			);
			if (isset($speciality))
			{
					$searchArray['speciality_id'] = 0;
					$specialityArray              = $this->common_model->getSpeciality(array('url_name' => $speciality,'limit' => 1,'status'=>array(1,2)));
					if (is_array($specialityArray) && sizeof($specialityArray) > 0)
					{
							$searchArray['speciality_id'] = $specialityArray[0]['id'];
					}
					else
					{
							echo $this->load->view('errors/page_missing', array(),true);exit;
					}
					$speciality_name = $this->data['query']['speciality'] = $specialityArray[0]['name'];
					$cityName        = ucwords(reverse_url_string($this->data['cityName']));
					$location_name   = '';

					if (isset($location) && !empty($location) && $location !== 'all')
					{
							$locArray = $this->common_model->getLocation(array('status' => ACTIVE,'url_name' => $location,'city_id' => $this->data['cityId'],'limit' => 1,'orderby' => 'name asc','column' => array('name','id','latitude','longitude')));
							if (is_array($locArray) && sizeof($locArray) > 0)
							{
									$locArray         = current($locArray);
									$location_inarray = $this->location_model->get_location_orderby_latlng($locArray['latitude'], $locArray['longitude'], $this->data['cityId']);
									foreach ($location_inarray as $locKey => $locVal)
									{
											$location_in[] = $locVal['id'];
									}
									$searchArray['location_in'] = $location_in;
									$location_name              = $this->data['query']['location'] = ucwords($locArray['name']);
							}
							else
							{
									echo $this->load->view('errors/page_missing', array(),true);exit;
									$searchArray['orderby'] = 'doc.city_sponsored ASC, doc.`sponsored` ASC, doc.`paid` ASC, doc.`sort` ASC, doc.`image` DESC, doc.`is_ver_reg` DESC';
							}
							
							$this->data['metadata']['title']       = ucwords($speciality_name) . ' Doctors in ' . ucwords($location_name) . ', ' . $cityName . ' | Book Dr Appointment' . (($pageId > 1) ? ' | Page - ' . $pageId : '');
							$this->data['metadata']['description'] = 'Find the best ' . ucwords($speciality) . ' Doctors, ' . ucwords($speciality) . ' hospitals near you in ' . $cityName . ' - ' . ucwords($location) . '. Visit bookdrappointment.com to book ' . ucwords($speciality) . ' Doctors in ' . $cityName . ' - ' . ucwords($location) . ' and more.';
							$this->data['metadata']['keywords']    = 'Best ' . ucwords($speciality) . ' in ' . $cityName . ' - ' . ucwords($location) . ', Find ' . ucwords($speciality) . ' in ' . $cityName . ' - ' . ucwords($location);
							$this->data['metadata']['h1_text']     = ucwords($speciality_name) . ' in ' . ucwords($location_name) . ', ' .$cityName ;
					}
					else
					{
							$this->data['metadata']['title']       = ucwords($speciality_name) . ' Doctors in ' . $cityName .' | Book Dr Appointment' . (($pageId > 1) ? ' | Page - ' . $pageId : '');
							$this->data['metadata']['description'] = 'Find the best ' . ucwords($speciality) . ' Doctors, ' . ucwords($speciality) . ' hospitals near you in ' . $cityName . '. Visit bookdrappointment.com to book ' . ucwords($speciality) . ' Doctors in ' . $cityName. ' and more.';
							$this->data['metadata']['keywords']    = 'Best ' . ucwords($speciality) . ' in ' . $cityName . ', Find ' . ucwords($speciality) . ' in ' . $cityName;
							$searchArray['orderby']                = 'doc.city_sponsored ASC, doc.`sponsored` ASC, doc.`paid` ASC, doc.`sort` ASC, doc.`image` DESC, doc.`is_ver_reg` DESC';
							$this->data['metadata']['h1_text']     = ucwords($speciality_name) . ' in ' . $cityName;
					}
					$searchArray['status'] = 1;
					# speciality inforamtion
					$this->data['speciality_info'][1]	=	$this->common_model->specialiy_inforamtion($searchArray['speciality_id'],1);
					$this->data['speciality_info'][2]	=	$this->common_model->specialiy_inforamtion($searchArray['speciality_id'],2);
					$this->data['speciality_info'][3]	=	$this->common_model->specialiy_inforamtion($searchArray['speciality_id'],3);
					$doctors               = $this->doctor_model->getDoctorBySpecialityId($searchArray);
					
			}
			else if (isset($doctor) && !empty($doctor))
			{
					$searchArray['orderby']  = 'doc.city_sponsored ASC, doc.`sponsored` ASC, doc.`paid` ASC, doc.`sort` ASC, doc.`image` DESC, doc.`is_ver_reg` DESC';
					$name_like               = str_replace("-", " ", $query);
					$searchArray['url_name'] = $query;
					
					$searchArray['status']                 = 1;
					$cityName                              = ucfirst(reverse_url_string($this->data['cityName']));
					$this->data['metadata']['title']       = $query . ' - Find Doctors and Clinics in ' . $cityName . (($pageId > 1) ? ' | Page ' . ' - '.$pageId : '');
					$this->data['metadata']['description'] = 'Find Doctors and Clinics in ' . $cityName . '. Book confirmed doctor appointments online for FREE, view clinic address &amp; timings, and access your health records online. Book Doctor appointment';
					$this->data['metadata']['keywords']    = 'Find Doctors and Clinics in ' . $cityName . '. Book confirmed doctor appointments online for FREE, view clinic address &amp; timings, and access your health records online. Book Doctor appointment.';
					$this->data['metadata']['h1_text']     = 'Dr. ' . ucwords($name_like) . ' in ' . $cityName;
					
					$doctors = $this->doctor_model->getDoctorByName($searchArray);
			}
			else if (isset($clinic) && !empty($clinic))
			{
					$searchArray['orderby']                = 'doc.city_sponsored ASC, doc.`sponsored` ASC, doc.`paid` ASC, doc.`sort` ASC, doc.`image` DESC, doc.`is_ver_reg` DESC';
					$name_like                             = str_replace("-", " ", $query);
					$searchArray['url_name']               = $query;
					$searchArray['status']                 = 1;
					$cityName                              = ucfirst(reverse_url_string($this->data['cityName']));
					$this->data['metadata']['title']       = $query . ' - Find Doctors and Clinics in ' . $cityName . (($pageId > 1) ? ' | Page ' . ' - '.$pageId : '.');
					$this->data['metadata']['description'] = 'Find Doctors and Clinics in ' . $cityName . '. Book confirmed doctor appointments online for FREE, view clinic address &amp; timings, and access your health records online. Book Doctor appointment.';
					$this->data['metadata']['keywords']    = 'Find Doctors and Clinics in ' . $cityName . '. Book confirmed doctor appointments online for FREE, view clinic address &amp; timings, and access your health records online. Book Doctor appointment.';
					$this->data['metadata']['h1_text']     = ucwords($name_like) . ' in ' . $cityName;
					
					$doctors = $this->doctor_model->getDoctorByClinicId($searchArray);
			}
			else
			{
					echo $this->load->view('errors/page_missing', array(),true);exit;
			}
			if (isset($_GET['t']))
			{
				echo $this->doctor_model;
				exit;
			}
			
			$this->page_model->total  = $this->doctor_model->row_count;
			$this->page_model->page   = $pageId;
			$this->page_model->limit  = LIMIT;
			$this->data['page_id']    = $pageId;
			$this->data['pagination'] = $this->page_model->render();
			
			if (isset($this->data['pagination']['nextPage']))
			{
					$this->data['metadata']['next_url'] = $this->data['pagination']['nextPage']['url'];
			}
			if (isset($this->data['pagination']['prePage']))
			{
					$this->data['metadata']['prev_url'] = $this->data['pagination']['prePage']['url'];
			}
			
			if (is_array($doctors) && sizeof($doctors) > 0)
			{
					$qualification_data = $this->common_model->getQualification(array('column' => array('name','id'),'id_as_key' => TRUE));
					$speciality_data    = $this->common_model->getSpeciality(array('column' => array('name','id'),'id_as_key' => TRUE));
					
					foreach ($doctors as $key => $val)
					{
							$val['specialityStr'] = '';
							if (!empty($val['speciality']))
							{
									$val['speciality'] = explode(',', $val['speciality']);
									foreach ($val['speciality'] as $spKey => $spVal)
									{
											$val['specialityStr'] .= $speciality_data[$spVal]['name'] . ", ";
									}
									$val['specialityStr'] = trim($val['specialityStr'], ", ");
							}
							if (!empty($val['other_speciality']))
							{
									$val['specialityStr'] .= " " . $val['other_speciality'];
							}
							if (isset($this->data['query']['speciality']))
							{
									$val['specialityStr'] = $this->data['query']['speciality'];
							}
							$val['qualificationStr'] = '';
							if (!empty($val['qualification']))
							{
									$val['qualification'] = explode(',', $val['qualification']);
									foreach ($val['qualification'] as $spKey => $spVal)
									{
											$val['qualificationStr'] .= $qualification_data[$spVal]['name'] . ", ";
									}
									$val['qualificationStr'] = trim($val['qualificationStr'], ", ");
							}
							if (!empty($val['other_qualification']))
							{
									$val['qualificationStr'] .= " " . $val['other_qualification'];
							}
							if (empty($val['doctor_image']))
							{
									if (strtolower($val['doctor_gender']) == "m")
									{
											$val['doctor_image'] = BASE_URL . "static/images/default_doctor.png";
									}
									else if (strtolower($val['doctor_gender']) == "f")
									{
											$val['doctor_image'] = BASE_URL . "static/images/female_doctor.jpg";
									}
									else if (strtolower($val['doctor_gender']) == "o")
									{
											$val['doctor_image'] = BASE_URL . "static/images/default_404.jpg";
									}
									else
									{
											$val['doctor_image'] = BASE_URL . "static/images/default_404.jpg";
									}
							}
							else
							{
									if (strpos($val['doctor_image'], "http") !== false)
									{
											$val['doctor_image'] = $val['doctor_image'];
									}
									else
									{
											$val['doctor_image'] = BASE_URL . $val['doctor_image'] . "?wm";
									}
							}
							
							$val['package']           = $this->doctor_model->get_all_doctor_packages($val['user_id']);
							$val['quick_appointment'] = 0;
							if (isset($val['package'][0]->package_id) && $val['package'][0]->package_id == 30)
							{
									$val['quick_appointment'] = 1;
							}
							$val['disptimings'] = $this->clinic_model->get_clinic_formatted_time($val['timings']);
							if (isset($this->data['location'][$val['clinic_location_id']]) && !empty($val['clinic_location_id']))
							{
									$val['clinic_location_name'] = $this->data['location'][$val['clinic_location_id']]['name'];
							}
							else
							{
									$val['clinic_location_name'] = "";
							}
							
							if (!empty($val['clinic_images']))
							{
									$val['clinic_images'] = explode(",", $val['clinic_images']);
							}
							$val['consultation_fees']   = $this->doctor_model->get_clinic_consultation_fees($val['consultation_fees']);
							$val['happy_reviews_count'] = $this->reviews_model->get_happy_reviews_count($val['doctor_id']);
							
							unset($val['speciality'], $val['qualification']);
							$doctors[$key] = $val;
					}
					
					$this->data['doctors'] = $doctors;
					if (isset($this->data['query']['speciality']))
					{
							$this->data['query']['speciality'] = str_replace("-", " ", $this->data['query']['speciality']);
					}
					
					if (isset($this->data['query']['query']))
					{
							$this->data['query']['query'] = str_replace("-", " ", $this->data['query']['query']);
					}
					$this->load->view('search.php', $this->data);
			}
			else
			{
					echo $this->load->view('errors/page_missing', array(),true);exit;
			}
	}

	public function getOS()
	{
		$user_agent = $_SERVER['HTTP_USER_AGENT'];
		$os_platform    =   "Unknown OS Platform";
		$os_array       =   array(
		'/windows nt 10/i'     =>  'Windows 10',
		'/windows nt 6.3/i'     =>  'Windows 8.1',
		'/windows nt 6.2/i'     =>  'Windows 8',
		'/windows nt 6.1/i'     =>  'Windows 7',
		'/windows nt 6.0/i'     =>  'Windows Vista',
		'/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
		'/windows nt 5.1/i'     =>  'Windows XP',
		'/windows xp/i'         =>  'Windows XP',
		'/windows nt 5.0/i'     =>  'Windows 2000',
		'/windows me/i'         =>  'Windows ME',
		'/win98/i'              =>  'Windows 98',
		'/win95/i'              =>  'Windows 95',
		'/win16/i'              =>  'Windows 3.11',
		'/macintosh|mac os x/i' =>  'Mac OS X',
		'/mac_powerpc/i'        =>  'Mac OS 9',
		'/linux/i'              =>  'Linux',
		'/ubuntu/i'             =>  'Ubuntu',
		'/iphone/i'             =>  'iPhone',
		'/ipod/i'               =>  'iPod',
		'/ipad/i'               =>  'iPad',
		'/android/i'            =>  'Android',
		'/blackberry/i'         =>  'BlackBerry',
		'/webos/i'              =>  'Mobile'
		);
		foreach ($os_array as $regex => $value)
		{ 
			if (preg_match($regex, $user_agent))
			{
				$os_platform    =   $value;

			}
		}   
		return $os_platform;
	}			
	
}
/* End of file home.php */
/* Location: ./application/controllers/home.php */