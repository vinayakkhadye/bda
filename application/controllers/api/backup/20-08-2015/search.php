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

class Search extends REST_Controller
{
	function __construct()
	{
		parent::__construct();
	}
	public function speciality_post()
	{
		$this->load->model(array('common_model'));
		
		$city_id = $this->post('city_id'); 
		$t = $this->post('t'); 
		$query =  urldecode($this->post('name')); 
		$t	=	$this->post('t'); 
		if(empty($city_id))
		{
			$rs = array("message"=>"please provide city_id .","status"=>0);
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		}
		/*$sql	=	"SELECT sp.id,sp.name,sp.display_name,sp.status,scp.speciality_id 
        FROM `speciality` sp 
        left join speciality_city_map scp on sp.id=scp.speciality_id 
        where sp.status in(1,2) and scp.city_id=".$city_id." 
        order by sp.status desc,sp.sort asc,sp.name asc";*/
		$sql	=	"SELECT sp.id,sp.name,sp.display_name,sp.status,scp.speciality_id 
		FROM `speciality` sp 
		left join speciality_city_map scp on sp.id=scp.speciality_id and city_id=".$city_id." 
		where sp.status in(1,2)
		order by sp.status desc,sp.sort asc,sp.name asc";
				
		if($t)
		{
			echo $sql;exit;
		}
		$query	=	$this->db->query($sql);
		if($query->num_rows>0)
		{
			$speciality = $query->result_array();
			foreach($speciality as $key=>$val)
			{
				$speciality_data[$key]['id']	=	$val['id'];
				$speciality_data[$key]['name']	=	ucwords($val['name']);
				$speciality_data[$key]['display_name']	=	$val['display_name'];
				$speciality_data[$key]['type']	=	($val['status']==2)?'top':'other';
				$speciality_data[$key]['status']	=	($val['speciality_id']==NULL)?'disable':'enable';
			}
			$rs = array("speciality_data"=>$speciality_data,"message"=>"Successful","status"=>1);
		}
		else
		{
			$rs = array("message"=>"No Speciality Found.","status"=>0);
		}
		if($t)
		{
			print_r($speciality);
			echo $this->common_model;
		}
		$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
	}	

	public function top_speciality_post()
	{
		$this->load->model(array('common_model'));
		
		$city_id = $this->post('city_id'); 
		$query =  urldecode($this->post('name')); 
		$t	=	$this->post('t'); 
		if(empty($city_id))
		{
			$rs = array("message"=>"please provide city_id .","status"=>0);
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		}
		
		$speciality = $this->common_model->getSpecialityByCity(array('name'=>urldecode($query),'status'=>2,'column'=>array('sp.id,sp.name,sp.display_name,sp.display_image'),'city_id'=>$city_id,'orderby'=>'sp.name asc'));
		if($t)
		{
			print_r($this->db);
			print_r($speciality);
			echo $this->common_model;
		}
		
		if(is_array($speciality))
		{
			$rs = array("speciality_data"=>$speciality,"message"=>"Successful","status"=>1);
		}
		else
		{
			$rs = array("message"=>"No Speciality Found.","status"=>0);
		}
		$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
	}	
	public function other_speciality_post()
	{
		$this->load->model(array('common_model'));
		
		$city_id = $this->post('city_id'); 
		$query =  urldecode($this->post('name')); 
		
		if(empty($city_id))
		{
			$rs = array("message"=>"please provide city_id .","status"=>0);
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		}
		
		$speciality = $this->common_model->getSpecialityByCity(array('name'=>urldecode($query),'status'=>ACTIVE,'column'=>array('sp.id,sp.name,sp.display_name,sp.display_image'),
		'city_id'=>$city_id,'orderby'=>'sp.name asc'));
		
		if(is_array($speciality))
		{
			$rs = array("speciality_data"=>$speciality,"message"=>"Successful","status"=>1);
		}
		else
		{
			$rs = array("message"=>"No Speciality Found.","status"=>0);
		}
		$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
	}	

	public function doctor_suggest_post()
	{
		$this->load->model(array('common_model','doctor_model'));
		
		$city_id = intval($this->post('city_id')); 
		$query =  strtolower($this->post('doctor_name')); 
		$t				=	$this->post('t'); 
		
		if(empty($query) || empty($city_id))
		{
			$rs = array("message"=>"please provide doctor_name and city_id.","status"=>0);
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		}
		
		$doctor = $this->doctor_model->getDoctorByClinicId(
			array('doctor_name'=>$query,'column'=>array('doc.name'),'city_id'=>$city_id,'status'=>ACTIVE)
		);
		
		if(is_array($doctor) && sizeof($doctor) > 0)
		{
			$retArray	=	array();
			foreach($doctor as $key=>$val)
			{
				$space_count = substr_count($query, " ");
				$pos_val = strpos(strtolower($val['name']),$query);
				$val['name'] = substr($val['name'],$pos_val,strlen($val['name']));
				
				$space = strpos($query," ")+1;
				$retArray[$key] =  substr($val['name'],strpos(strtolower($val['name']),$query));
				$tmpArray = explode(" ",$retArray[$key]);
				if($space)
				{
					if($space_count==1)
					{
						$retArray[$key] = ucwords($tmpArray[0]." ".@$tmpArray[1]); 
					}
					else if($space_count==2)
					{
						$retArray[$key] = ucwords($tmpArray[0]." ".@$tmpArray[1]." ".@$tmpArray[2]); 
					}else if($space_count==3)
					{
						$retArray[$key] = ucwords($tmpArray[0]." ".@$tmpArray[1]." ".@$tmpArray[2]." ".@$tmpArray[3]); 
					}else if($space_count==4)
					{
						$retArray[$key] = ucwords($tmpArray[0]." ".@$tmpArray[1]." ".@$tmpArray[2]." ".@$tmpArray[3]." ".@$tmpArray[4]); 
					}else if($space_count==5)
					{
						$retArray[$key] = ucwords($tmpArray[0]." ".@$tmpArray[1]." ".@$tmpArray[2]." ".@$tmpArray[3]." ".@$tmpArray[4]." ".@$tmpArray[5]); 
					}
					
				}else
				{
					$retArray[$key] = ucwords(current($tmpArray)); 						
				}
				$retArray[$key] = ucwords($retArray[$key]); 
			}
			$retArray = array_unique($retArray);
			sort($retArray);
			$rs = array("doctor_data"=>$retArray,"message"=>"Successful.","status"=>1);
		}
		else
		{
		$rs = array("message"=>"no doctor found.","status"=>0);
		}
		$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
	}
	public function clinic_suggest_post()
	{
		$this->load->model(array('common_model','clinic_model'));
		$city_id	=	intval($this->post('city_id')); 
		$query		=	$this->post('clinic_name'); 
		$t				=	$this->post('t'); 
		

		if(empty($query) || empty($city_id))
		{
			$rs = array("message"=>"please provide clinic_name and city_id.","status"=>0);
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		}
		
		$retArray = array();
		
		$clinic	=	$this->clinic_model->getClinic(array('name'=>urldecode($query),'city_id'=>$city_id,'column'=>array('name'),'status'=>ACTIVE));
		
		if(is_array($clinic) && sizeof($clinic) > 0)
		{
			foreach($clinic as $key=>$val)
			{
				$space_count = substr_count($query, " ");
				$pos_val = strpos(strtolower($val['name']),$query);
				$val['name'] = substr($val['name'],$pos_val,strlen($val['name']));
				
				$space = strpos($query," ")+1;
				$retArray[$key] =  substr($val['name'],strpos(strtolower($val['name']),$query));
				$tmpArray = explode(" ",$retArray[$key]);
				if($space)
				{
					if($space_count==1)
					{
						$retArray[$key] = ucwords($tmpArray[0]." ".@$tmpArray[1]); 
					}
					else if($space_count==2)
					{
						$retArray[$key] = ucwords($tmpArray[0]." ".@$tmpArray[1]." ".@$tmpArray[2]); 
					}else if($space_count==3)
					{
						$retArray[$key] = ucwords($tmpArray[0]." ".@$tmpArray[1]." ".@$tmpArray[2]." ".@$tmpArray[3]); 
					}else if($space_count==4)
					{
						$retArray[$key] = ucwords($tmpArray[0]." ".@$tmpArray[1]." ".@$tmpArray[2]." ".@$tmpArray[3]." ".@$tmpArray[4]); 
					}else if($space_count==5)
					{
						$retArray[$key] = ucwords($tmpArray[0]." ".@$tmpArray[1]." ".@$tmpArray[2]." ".@$tmpArray[3]." ".@$tmpArray[4]." ".@$tmpArray[5]); 
					}
					
				}else
				{
				$retArray[$key] = ucwords(current($tmpArray)); 						
				}
				$retArray[$key] = ucwords($retArray[$key]); 
			}
			$retArray = array_unique($retArray);
			sort($retArray);
			$rs = array("clinic_data"=>$retArray,"message"=>"Successful.","status"=>1);
		}
		else
		{
			$rs = array("message"=>"no clinic found.","status"=>0);
		}
		$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
	}
	public function nearest_location($latitude, $longitude, $city_id)
	{
		
		$this->load->model(array('location_model'));
		$rs	=	$this->location_model->get_location_orderby_latlng($latitude,$longitude,$city_id,1);
		if(is_array($rs) && sizeof($rs)>0)
		{
			$rs	=	 current($rs);
			$rs['distance']	=	number_format($rs['distance'],2);
			return $rs;
		}
		return false;
	}
	
	public function doctorlist_by_speciality_location_post()
	{
		$city_id = $this->post('city_id'); 
		$speciality_id = $this->post('speciality_id'); 
		$location_id = intval($this->post('location_id')); 
		$page_id = intval($this->post('page_id')); 
		$device_latitude = (string)$this->post('device_latitude'); 
		$device_longitude = (string)$this->post('device_longitude'); 
		$t =	$this->post('t');
		$patient_id = intval($this->post('patient_id')); 
		
		$offset	=	($page_id-1)*LIMIT;

		if(empty($city_id) || empty($speciality_id))
		{
			$rs = array("message"=>"please provide city_id, speciality_id.","status"=>0);
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		}
		$this->load->model(array('common_model','doctor_model','location_model','reviews_model','favourite_doctor_model'));
		#$column = array('doc.id as doctor_id','doc.name as doctor_name','doc.gender as doctor_gender','doc.summary','cli.location_id as clinic_location_id','doc.image as doctor_image','doc.speciality','doc.qualification as qualification','doc.yoe','cli.id as clinic_id','cli.name as clinic_name','cli.tele_fees','cli.online_fees','cli.express_fees','cli.timings','cli.duration','cli.consultation_fees');
		
		$column = array('doc.user_id','doc.id as doctor_id','doc.name as doctor_name','doc.gender as doctor_gender','doc.image as doctor_image','doc.speciality','doc.yoe','doc.is_ver_reg','cli.id as clinic_id','cli.name as clinic_name','cli.consultation_fees','cli.latitude as clinic_latitude','cli.longitude as clinic_longitude','cli.location_id as clinic_location_id','cli.other_location as clinic_other_location','cli.address as clinic_address','cli.image as clinic_images','cli.is_number_verified');
		
		$searchArray = array('offset' =>$offset,'limit'  =>LIMIT,'count'  =>1,'column' =>$column,'city_id'=>$city_id);
		$searchArray['speciality_id'] = $speciality_id;


		if(is_numeric($location_id) && !empty($location_id))
		{
			$location_array = $this->common_model->getLocation(array('status' =>ACTIVE,'id'=>$location_id,'city_id'=>$city_id,'limit'  =>1
			,'orderby'=>'name asc','column' =>array('id','latitude','longitude')));			
			if(is_array($location_array) && sizeof($location_array)>0 )
			{
				$location_array	= current($location_array);
				$location_inarray = $this->location_model->get_location_orderby_latlng($location_array['latitude'],$location_array['longitude'],$city_id);
				foreach($location_inarray as $locKey=>$locVal)
				{
					$location_in[] = $locVal['id'];
				}
				$searchArray['location_in'] = $location_in;		
			}
			else
			{
				$searchArray['orderby'] = 'doc.`sponsored` DESC, doc.`paid` DESC, doc.`sort` DESC,doc.`is_ver_reg` DESC, doc.`image` DESC';
			}
		}
		else
		{
			if(!empty($device_latitude) && !empty($device_longitude))
			{
				$location_inarray = $this->location_model->get_location_orderby_latlng($device_latitude,$device_longitude,$city_id);
				if(is_array($location_inarray) && sizeof($location_inarray)>0)
				{
					$location_id	=	$location_inarray[0]['id'];
					foreach($location_inarray as $locKey=>$locVal)
					{
						$location_in[] = $locVal['id'];
					}
					$searchArray['location_in'] = $location_in;				
					$location_array = $this->common_model->getLocation(array('status' =>ACTIVE,'id'=>$location_id,'city_id'=>$city_id,'limit'  =>1,'orderby'=>'name asc','column' =>array('id','latitude','longitude')));			
					$location_array	=	 current($location_array);
				}
			}
			else
			{
				$searchArray['orderby'] = 'doc.`sponsored` DESC, doc.`paid` DESC, doc.`sort` DESC,doc.`is_ver_reg` DESC, doc.`image` DESC';
			}
		}

		$searchArray['status'] = 1;
		$doctors = $this->doctor_model->getDoctorBySpecialityId($searchArray);
		if($t)
		{
			echo $this->doctor_model;exit;
		}
		$city_locations = $this->common_model->getLocation(array('status'=>ACTIVE,'city_id'=>$city_id,'orderby'=>'name asc','column' =>array('id','latitude','longitude')));		

		if(is_array($doctors) && sizeof($doctors)>0)
		{
			$speciality_data = $this->common_model->getSpeciality(array('column'=>array('name','id'),'id_as_key'=>TRUE));
			$location_data = $this->common_model->getLocation(array('column'=>array('name','id'),'city_id'=>$city_id));//'status' =>ACTIVE,
			if($patient_id)
			{
				$favourite_doctors	=	$this->favourite_doctor_model->get_favourite_doctors($patient_id);
			}
			
			foreach($doctors as $dKey=>$dVal)
			{
				$speciality_str	=	'';
				if(!empty($dVal['speciality']))
				{
					$speciality_arr	=	explode(',',$dVal['speciality']);
					foreach($speciality_arr as $spcKey=>$spcVal)
					{
						if($spcVal==$speciality_id)
						{
							$speciality_str	.=	$speciality_data[$spcVal]['name'].",";
						}
					}
				$doctors[$dKey]['speciality']	=	rtrim($speciality_str,",");
				}

				if(empty($dVal['doctor_image']))
				{
					if(strtolower($dVal['doctor_gender']) == "m")
					{
						$doctors[$dKey]['doctor_image'] = "./static/images/default_doctor.png";
					}else if(strtolower($dVal['doctor_gender']) == "f")
					{
						$doctors[$dKey]['doctor_image'] = "./static/images/female_doctor.jpg";
					}else if(strtolower($dVal['doctor_gender']) == "o")
					{
						$doctors[$dKey]['doctor_image'] = "./static/images/default_404.jpg";
					}
				}
				else
				{
					$doctors[$dKey]['doctor_image'] = $dVal['doctor_image']."?wm";
				}
				
				$doctors[$dKey]['happy_patient_count'] = $this->reviews_model->get_happy_reviews_count($dVal['doctor_id']);
				
				if(isset($dVal['clinic_location_id']) &&!empty($dVal['clinic_location_id']))
				{
					if(isset($location_data[$dVal['clinic_location_id']]))
					{
						$doctors[$dKey]['clinic_location_name']	=	ucwords($location_data[$dVal['clinic_location_id']]['name']);
					}
					else
					{
						$doctors[$dKey]['clinic_location_name']	=	ucwords($dVal['clinic_location_id']);
					}

				}else if(isset($dVal['clinic_other_location']) &&!empty($dVal['clinic_other_location']))
				{
					$doctors[$dKey]['clinic_location_name']	=	ucwords($dVal['clinic_other_location']);
				}
				else
				{
					$doctors[$dKey]['clinic_location_name']	=	'';
				}
				
				#unset($doctors[$dKey]['clinic_location_id'],$doctors[$dKey]['clinic_other_location']);

				$doctors[$dKey]['yoe'] = intval($dVal['yoe']);
				$doctors[$dKey]['doctor_id'] = intval($dVal['doctor_id']);
				$doctors[$dKey]['clinic_id'] = intval($dVal['clinic_id']);
				$doctors[$dKey]['doctor_name'] = "Dr. ".ucwords(str_replace("dr.","",strtolower($dVal['doctor_name'])));
				$doctors[$dKey]['clinic_latitude'] = (string)$dVal['clinic_latitude'];
				$doctors[$dKey]['clinic_longitude'] = (string)$dVal['clinic_longitude'];
				
				
				if(!empty($doctors[$dKey]['clinic_latitude']) && !empty($doctors[$dKey]['clinic_longitude']) 
				&& !empty($device_latitude) && !empty($device_longitude))
				{
					$doctors[$dKey]['distance'] = number_format($this->location_model->distance_by_lat_lng($doctors[$dKey]['clinic_latitude'],$doctors[$dKey]['clinic_longitude'],$device_latitude,$device_longitude,"K"),0);
				}
				else if(isset($city_locations[$dVal['clinic_location_id']]['latitude']) && isset($city_locations[$dVal['clinic_location_id']]['longitude']) 
				&& !empty($device_latitude) && !empty($device_longitude)  )
				{
					$doctors[$dKey]['distance'] = number_format($this->location_model->distance_by_lat_lng($city_locations[$dVal['clinic_location_id']]['latitude'],$city_locations[$dVal['clinic_location_id']]['longitude'],$device_latitude,$device_longitude,"K"),0);
				}
				else if(!empty($doctors[$dKey]['clinic_latitude']) && !empty($doctors[$dKey]['clinic_longitude']) 
				&& isset($location_array['latitude']) && isset($location_array['longitude']))
				{
					$doctors[$dKey]['distance'] = number_format($this->location_model->distance_by_lat_lng($doctors[$dKey]['clinic_latitude'],$doctors[$dKey]['clinic_longitude'],$location_array['latitude'],$location_array['longitude'],"K"),0);
				}
				if(!empty($dVal['clinic_images']))
				{
					$doctors[$dKey]['clinic_images']	=	 explode(",",$dVal['clinic_images']);
				}
				else
				{
					#unset($doctors[$dKey]['clinic_images']);
				}
				
				$consult_fees	=	$dVal['consultation_fees'];
				if($consult_fees==1)
				{
					$consult_fees	=	"100-300";
				}else if($consult_fees==2)
				{
					$consult_fees	=	"301-500";
				}else if($consult_fees==3)
				{
					$consult_fees	=	"501-750";
				}else if($consult_fees==4)
				{
					$consult_fees	=	"751-1000";
				}else if($consult_fees==5)
				{
					$consult_fees	=	"more than 1000";
				}else
				{
					$consult_fees	=	$dVal['consultation_fees'];
				}
				$doctors[$dKey]['consultation_fees']	=	$consult_fees;

				$doctors[$dKey]['package'] = $this->doctor_model->get_all_doctor_packages($doctors[$dKey]['user_id']);
				$doctors[$dKey]['quick_appointment']	=	0;
				if(isset($doctors[$dKey]['package'][0]->package_id) && $doctors[$dKey]['package'][0]->package_id==30)
				{
					$doctors[$dKey]['quick_appointment']	=1;
				}
				if($doctors[$dKey]['quick_appointment']==1)
				{
					$doctors[$dKey]['appointment_type']	=	 'quickbookdrappointment';
				}
				else if($doctors[$dKey]['is_ver_reg']>0 || $doctors[$dKey]['is_number_verified']==1)
				{
					#$doctors[$dKey]['appointment_type']	=	 'appointmentviaphone';
					$doctors[$dKey]['appointment_type']	=	 'bookdrappointment';
				}
				else 
				{
					$doctors[$dKey]['appointment_type']	=	 'bookdrappointment';
				}
				
				$doctors[$dKey]['is_favourite']	=	 0;
				if(isset($favourite_doctors[$doctors[$dKey]['doctor_id']]))
				{
					$doctors[$dKey]['is_favourite']	=	 $favourite_doctors[$doctors[$dKey]['doctor_id']];
				}
			}
			
			$total_rows = $this->doctor_model->row_count;
			
			$rs = array("next_page"=>($page_id+1),"total_rows"=>$total_rows,"doctor_data"=>$doctors,"message"=>"Successful.","status"=>1);
		}
		else
		{
			$rs = array("message"=>"no doctors found.","status"=>0);	
		}
		
		$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code

	}

	public function doctorlist_by_doctorname_post()
	{
		$city_id = $this->post('city_id'); 
		$doctor_name 			= $this->post('doctor_name'); 
		$page_id 					= intval($this->post('page_id')); 
		$device_latitude 	= (string)$this->post('device_latitude'); 
		$device_longitude = (string)$this->post('device_longitude'); 
		$patient_id 			= intval($this->post('patient_id')); 
		
		$t	=	$this->post('t'); 
		$offset	=	($page_id-1)*LIMIT;
		
		if(empty($city_id) || empty($doctor_name))
		{
			$rs = array("message"=>"please provide city_id, doctor_name.","status"=>0);
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		}
		$this->load->model(array('common_model','doctor_model','location_model','reviews_model','favourite_doctor_model'));

		$column = array('doc.user_id','doc.id as doctor_id','doc.name as doctor_name','doc.gender as doctor_gender','doc.image as doctor_image','doc.speciality','doc.yoe','doc.is_ver_reg','cli.id as clinic_id','cli.name as clinic_name','cli.consultation_fees','cli.latitude as clinic_latitude','cli.longitude as clinic_longitude','cli.location_id as clinic_location_id','cli.other_location as clinic_other_location','cli.address as clinic_address','cli.image as clinic_images','cli.is_number_verified');

		$searchArray = array('offset' =>$offset,'limit'  =>LIMIT,'count'  =>1,'column' =>$column,'city_id'=>$city_id);
		$searchArray['name_like'] = $doctor_name;
		$searchArray['status'] = 1;

		$doctors = $this->doctor_model->getDoctorByName($searchArray);
		if($t)
		{
			#echo $this->doctor_model;exit;
		}
		
		if(is_array($doctors) && sizeof($doctors)>0)
		{
			$speciality_data = $this->common_model->getSpeciality(array('column'=>array('name','id'),'id_as_key'=>TRUE));
			$location_data = $this->common_model->getLocation(array('column'=>array('name','id','latitude','longitude'),'city_id'=>$city_id));//'status' =>ACTIVE,
			if($patient_id)
			{
				$favourite_doctors	=	$this->favourite_doctor_model->get_favourite_doctors($patient_id);
			}
			
			foreach($doctors as $dKey=>$dVal)
			{
				$speciality_str	=	'';
				if(!empty($dVal['speciality']))
				{
					$speciality_arr	=	explode(',',$dVal['speciality']);
					foreach($speciality_arr as $spcKey=>$spcVal)
					{
						$speciality_str	.=	$speciality_data[$spcVal]['name'].",";
					}
				$doctors[$dKey]['speciality']	=	rtrim($speciality_str,",");
				}

				if(empty($dVal['doctor_image']))
				{
					if(strtolower($dVal['doctor_gender']) == "m")
					{
						$doctors[$dKey]['doctor_image'] = "./static/images/default_doctor.png";
					}else if(strtolower($dVal['doctor_gender']) == "f")
					{
						$doctors[$dKey]['doctor_image'] = "./static/images/female_doctor.jpg";
					}else if(strtolower($dVal['doctor_gender']) == "o")
					{
						$doctors[$dKey]['doctor_image'] = "./static/images/default_404.jpg";
					}
				}
				else
				{
					$doctors[$dKey]['doctor_image'] = $dVal['doctor_image']."?wm";
				}

				$doctors[$dKey]['happy_patient_count'] = $this->reviews_model->get_happy_reviews_count($dVal['doctor_id']);
				
				if(isset($dVal['clinic_location_id']) &&!empty($dVal['clinic_location_id']))
				{
					if(isset($location_data[$dVal['clinic_location_id']]['latitude']))
					{
						$location_latitude	=	$location_data[$dVal['clinic_location_id']]['latitude'];
					}
					if(isset($location_data[$dVal['clinic_location_id']]['longitude']))
					{
						$location_longitude	=	$location_data[$dVal['clinic_location_id']]['longitude'];
					}
					
					if(isset($location_data[$dVal['clinic_location_id']]))
					{
						$doctors[$dKey]['clinic_location_name']	=	ucwords($location_data[$dVal['clinic_location_id']]['name']);
					}
					else
					{
						$doctors[$dKey]['clinic_location_name']	=	ucwords($dVal['clinic_location_id']);
					}

				}else if(isset($dVal['clinic_other_location']) &&!empty($dVal['clinic_other_location']))
				{
					$doctors[$dKey]['clinic_location_name']	=	ucwords($dVal['clinic_other_location']);
				}
				else
				{
					$doctors[$dKey]['clinic_location_name']	=	'';
				}
				#unset($doctors[$dKey]['clinic_location_id'],$doctors[$dKey]['clinic_other_location']);

				$doctors[$dKey]['yoe'] = intval($dVal['yoe']);
				$doctors[$dKey]['doctor_id'] = intval($dVal['doctor_id']);
				$doctors[$dKey]['clinic_id'] = intval($dVal['clinic_id']);
				$doctors[$dKey]['doctor_name'] = "Dr. ".trim(ucwords($dVal['doctor_name']));
				$doctors[$dKey]['clinic_latitude'] = (string)$dVal['clinic_latitude'];
				$doctors[$dKey]['clinic_longitude'] = (string)$dVal['clinic_longitude'];
				
				if(!empty($doctors[$dKey]['clinic_latitude']) && !empty($doctors[$dKey]['clinic_longitude']) 
				&& !empty($device_latitude) && !empty($device_longitude))
				{
					$doctors[$dKey]['distance'] = number_format($this->location_model->distance_by_lat_lng($doctors[$dKey]['clinic_latitude'],$doctors[$dKey]['clinic_longitude'],$device_latitude,$device_longitude,"K"),0);
				}
				else if(isset($location_latitude) && isset($location_longitude) && !empty($device_latitude) && !empty($device_longitude))
				{
					$doctors[$dKey]['distance'] = number_format($this->location_model->distance_by_lat_lng($location_latitude,$location_longitude,
					$device_latitude,$device_longitude,"K"),0);
				}

				if(!empty($dVal['clinic_images']))
				{
					$doctors[$dKey]['clinic_images']	=	 explode(",",$dVal['clinic_images']);
				}
				else
				{
					#unset($doctors[$dKey]['clinic_images']);
				}
				
		
				$consult_fees	=	$dVal['consultation_fees'];
				if($consult_fees==1)
				{
					$consult_fees	=	"100-300";
				}else if($consult_fees==2)
				{
					$consult_fees	=	"301-500";
				}else if($consult_fees==3)
				{
					$consult_fees	=	"501-750";
				}else if($consult_fees==4)
				{
					$consult_fees	=	"751-1000";
				}else if($consult_fees==5)
				{
					$consult_fees	=	"more than 1000";
				}else
				{
					$consult_fees	=	$dVal['consultation_fees'];
				}
				$doctors[$dKey]['consultation_fees']	=	$consult_fees;

				$doctors[$dKey]['package'] = $this->doctor_model->get_all_doctor_packages($doctors[$dKey]['user_id']);
				$doctors[$dKey]['quick_appointment']	=	0;
				if(isset($doctors[$dKey]['package'][0]->package_id) && $doctors[$dKey]['package'][0]->package_id==30)
				{
					$doctors[$dKey]['quick_appointment']	=1;
				}
				
				if($doctors[$dKey]['quick_appointment']==1)
				{
					$doctors[$dKey]['appointment_type']	=	 'quickbookdrappointment';
				}
				else if($doctors[$dKey]['is_ver_reg']>0 || $doctors[$dKey]['is_number_verified']==1)
				{
					#$doctors[$dKey]['appointment_type']	=	 'appointmentviaphone';
					$doctors[$dKey]['appointment_type']	=	 'bookdrappointment';
				}
				else
				{
					$doctors[$dKey]['appointment_type']	=	 'bookdrappointment';
				}
				
				$doctors[$dKey]['is_favourite']	=	 0;
				if(isset($favourite_doctors[$doctors[$dKey]['doctor_id']]))
				{
					$doctors[$dKey]['is_favourite']	=	 $favourite_doctors[$doctors[$dKey]['doctor_id']];
				}
			}
			
			$total_rows = $this->doctor_model->row_count;
			
			$rs = array("next_page"=>($page_id+1),"total_rows"=>$total_rows,"doctor_data"=>$doctors,"message"=>"Successful.","status"=>1);
		}
		else
		{
			$rs = array("message"=>"no doctors found.","status"=>0);	
		}
		
		$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code

	}

	public function doctorlist_by_clinicname_post()
	{
		$city_id = $this->post('city_id'); 
		$clinic_name = $this->post('clinic_name'); 
		$device_latitude = (string)$this->post('device_latitude'); 
		$device_longitude = (string)$this->post('device_longitude'); 
		$patient_id 			= intval($this->post('patient_id')); 
		
		$clinic_name = $this->post('clinic_name'); 
		$page_id = intval($this->post('page_id')); 
		$offset	=	($page_id-1)*LIMIT;

		if(empty($city_id) || empty($clinic_name))
		{
			$rs = array("message"=>"please provide city_id, clinic_name.","status"=>0);
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		}
		$this->load->model(array('common_model','doctor_model','location_model','reviews_model','favourite_doctor_model'));

		$column = array('doc.user_id','doc.id as doctor_id','doc.name as doctor_name','doc.gender as doctor_gender','doc.image as doctor_image','doc.speciality','doc.yoe','doc.is_ver_reg','cli.id as clinic_id','cli.name as clinic_name','cli.consultation_fees','cli.latitude as clinic_latitude','cli.longitude as clinic_longitude','cli.location_id as clinic_location_id','cli.other_location as clinic_other_location','cli.address as clinic_address','cli.image as clinic_images','cli.is_number_verified');

		
		$searchArray = array('offset' =>$offset,'limit'  =>LIMIT,'count'  =>1,'column' =>$column,'city_id'=>$city_id);
		$searchArray['name_like'] = $clinic_name;
		$searchArray['status'] = 1;

		$doctors = $this->doctor_model->getDoctorByClinicId($searchArray);
		
		if(is_array($doctors) && sizeof($doctors)>0)
		{
			$speciality_data = $this->common_model->getSpeciality(array('column'=>array('name','id'),'id_as_key'=>TRUE));
			$location_data = $this->common_model->getLocation(array('column'=>array('name','id','latitude','longitude'),'city_id'=>$city_id));//'status' =>ACTIVE,
			if($patient_id)
			{
				$favourite_doctors	=	$this->favourite_doctor_model->get_favourite_doctors($patient_id);
			}
			
			foreach($doctors as $dKey=>$dVal)
			{
				$speciality_str	=	'';
				if(!empty($dVal['speciality']))
				{
					$speciality_arr	=	explode(',',$dVal['speciality']);
					foreach($speciality_arr as $spcKey=>$spcVal)
					{
						$speciality_str	.=	$speciality_data[$spcVal]['name'].",";
					}
				$doctors[$dKey]['speciality']	=	rtrim($speciality_str,",");
				}

				if(empty($dVal['doctor_image']))
				{
					if(strtolower($dVal['doctor_gender']) == "m")
					{
						$doctors[$dKey]['doctor_image'] = "./static/images/default_doctor.png";
					}else if(strtolower($dVal['doctor_gender']) == "f")
					{
						$doctors[$dKey]['doctor_image'] = "./static/images/female_doctor.jpg";
					}else if(strtolower($dVal['doctor_gender']) == "o")
					{
						$doctors[$dKey]['doctor_image'] = "./static/images/default_404.jpg";
					}
				}
				else
				{
					$doctors[$dKey]['doctor_image'] = $dVal['doctor_image']."?wm";
				}

				$doctors[$dKey]['happy_patient_count'] = $this->reviews_model->get_happy_reviews_count($dVal['doctor_id']);
				
				if(isset($dVal['clinic_location_id']) &&!empty($dVal['clinic_location_id']))
				{
					if(isset($location_data[$dVal['clinic_location_id']]['latitude']))
					{
						$location_latitude	=	$location_data[$dVal['clinic_location_id']]['latitude'];
					}
					if(isset($location_data[$dVal['clinic_location_id']]['longitude']))
					{
						$location_longitude	=	$location_data[$dVal['clinic_location_id']]['longitude'];
					}
					
					if(isset($location_data[$dVal['clinic_location_id']]))
					{
						$doctors[$dKey]['clinic_location_name']	=	ucwords($location_data[$dVal['clinic_location_id']]['name']);
					}
					else
					{
						$doctors[$dKey]['clinic_location_name']	=	$dVal['clinic_location_id'];
					}
				}else if(isset($dVal['clinic_other_location']) &&!empty($dVal['clinic_other_location']))
				{
					$doctors[$dKey]['clinic_location_name']	=	ucwords($dVal['clinic_other_location']);
				}
				else
				{
					$doctors[$dKey]['clinic_location_name']	=	'';
				}
				
				#unset($doctors[$dKey]['clinic_location_id'],$doctors[$dKey]['clinic_other_location']);

				$doctors[$dKey]['yoe'] = intval($dVal['yoe']);
				$doctors[$dKey]['doctor_id'] = intval($dVal['doctor_id']);
				$doctors[$dKey]['clinic_id'] = intval($dVal['clinic_id']);
				$doctors[$dKey]['doctor_name'] = "Dr. ".trim(ucwords($dVal['doctor_name']));
				$doctors[$dKey]['clinic_latitude'] = (string)$dVal['clinic_latitude'];
				$doctors[$dKey]['clinic_longitude'] = (string)$dVal['clinic_longitude'];
				#var_dump($doctors[$dKey]['clinic_latitude'],$doctors[$dKey]['clinic_longitude'],$location_latitude,$location_longitude,"K");
				if(!empty($doctors[$dKey]['clinic_latitude']) && !empty($doctors[$dKey]['clinic_longitude']) 
				&& !empty($device_latitude) && !empty($device_longitude)  )
				{
					$doctors[$dKey]['distance'] = number_format($this->location_model->distance_by_lat_lng($doctors[$dKey]['clinic_latitude'],$doctors[$dKey]['clinic_longitude'],$device_latitude,$device_longitude,"K"),0);
				}
				else if(isset($location_latitude) && isset($location_longitude) && !empty($device_latitude) && !empty($device_longitude))
				{
					$doctors[$dKey]['distance'] = number_format($this->location_model->distance_by_lat_lng($location_latitude,$location_longitude,
					$device_latitude,$device_longitude,"K"),0);
				}
				/*else if(!empty($doctors[$dKey]['clinic_latitude']) && !empty($doctors[$dKey]['clinic_longitude']) && isset($location_latitude) && isset($location_longitude))
				{
					$doctors[$dKey]['distance'] = number_format($this->location_model->distance_by_lat_lng($doctors[$dKey]['clinic_latitude'],$doctors[$dKey]['clinic_longitude'],$location_latitude,$location_longitude,"K"),0);
				}*/
				/*else if(isset($location_latitude) && isset($location_longitude) && !empty($device_latitude) && !empty($device_longitude) )
				{
					$doctors[$dKey]['distance'] = number_format($this->location_model->distance_by_lat_lng($location_latitude,$location_longitude,$device_latitude,$device_longitude,"K"),0);
				}*/
				
				if(!empty($dVal['clinic_images']))
				{
					$doctors[$dKey]['clinic_images']	=	 explode(",",$dVal['clinic_images']);
				}
				else
				{
					#unset($doctors[$dKey]['clinic_images']);
				}

		
				$consult_fees	=	$dVal['consultation_fees'];
				if($consult_fees==1)
				{
					$consult_fees	=	"100-300";
				}else if($consult_fees==2)
				{
					$consult_fees	=	"301-500";
				}else if($consult_fees==3)
				{
					$consult_fees	=	"501-750";
				}else if($consult_fees==4)
				{
					$consult_fees	=	"751-1000";
				}else if($consult_fees==5)
				{
					$consult_fees	=	"more than 1000";
				}else
				{
					$consult_fees	=	$dVal['consultation_fees'];
				}
				$doctors[$dKey]['consultation_fees']	=	$consult_fees;

				$doctors[$dKey]['package'] = $this->doctor_model->get_all_doctor_packages($doctors[$dKey]['user_id']);
				$doctors[$dKey]['quick_appointment']	=	0;
				if(isset($doctors[$dKey]['package'][0]->package_id) && $doctors[$dKey]['package'][0]->package_id==30)
				{
					$doctors[$dKey]['quick_appointment']	=1;
				}
				
				if($doctors[$dKey]['quick_appointment']==1)
				{
					$doctors[$dKey]['appointment_type']	=	 'quickbookdrappointment';
				}
				else if($doctors[$dKey]['is_ver_reg']>0 || $doctors[$dKey]['is_number_verified']==1)
				{
					#$doctors[$dKey]['appointment_type']	=	 'appointmentviaphone';
					$doctors[$dKey]['appointment_type']	=	 'bookdrappointment';
				}
				else
				{
					$doctors[$dKey]['appointment_type']	=	 'bookdrappointment';
				}

				$doctors[$dKey]['is_favourite']	=	 0;
				if(isset($favourite_doctors[$doctors[$dKey]['doctor_id']]))
				{
					$doctors[$dKey]['is_favourite']	=	 $favourite_doctors[$doctors[$dKey]['doctor_id']];
				}
			}
			
			$total_rows = $this->doctor_model->row_count;
			
			$rs = array("next_page"=>($page_id+1),"total_rows"=>$total_rows,"doctor_data"=>$doctors,"message"=>"Successful.","status"=>1);

		}
		else
		{
			$rs = array("message"=>"no doctors found.","status"=>0);	
		}
		
		$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code

	}
	
	public function speciality_get(){
		$this->load->model(array('common_model'));

		$city = $this->get('city_name'); 
		$query =  urldecode($this->get('query')); 

		$retArray = array();
		if(!empty($query))
		{
		if(!$this->input->cookie('bda_cityName')){
			$city = $this->common_model->getCity(array('limit'=>1,'status'=>1,'column'=>array('id','name'),'name'=>$city));
			$this->data['cityId'] = $city[0]['id']; 
		}else{
			#echo "from cookie";
			$this->data['cityId'] = $this->input->cookie('bda_cityId'); 
		}

			$data['speciality'] = $this->common_model->getSpecialityByCity(array('name'=>urldecode($query),'status'=>ACTIVE,'limit'=>100,'column'=>array('sp.name'),'city_id'=>$this->data['cityId'],'orderby'=>'sp.name asc'));
			#echo $this->common;
			#print_r($data['speciality']);
			$data['specialization'] = $this->common_model->getSpecializationByCity(array('name'=>urldecode($query),'status'=>ACTIVE,'limit'=>100,'column'=>array('sp.name'),'city_id'=>$this->data['cityId'],'orderby'=>'sp.name asc'));
			#echo $this->common;
			#print_r($data['specialization']);
			if(is_array($data['speciality']) && $data['specialization']){
				$data['speciality'] = array_merge($data['speciality'],$data['specialization']);
			}else if(is_array($data['speciality'])){
				$data['speciality'] = $data['speciality'];
			}else{
				$data['speciality'] = $data['specialization'];
			}
			
			#print_r($data['speciality']);
			#	echo $this->common;exit;
			if(is_array($data['speciality']) && sizeof($data['speciality']) > 0)
			{
				foreach($data['speciality'] as $val)
				{
					$retArray[] = ucwords($val['name']);
				}
				
				
			}
		}
		$retArray = array_unique($retArray);
		sort($retArray);
		echo  json_encode($retArray);
		return false;
	}

	public function doctor_get(){
		$city = $this->get('city_name'); 
		$query =  urldecode($this->get('query')); 

		$this->load->model(array('common_model','doctor_model'));
		
		if(!$this->input->cookie('bda_cityName')){
			$city = $this->common_model->getCity(array('limit'=>1,'status'=>1,'column'=>array('id','name'),'name'=>$city));
			$this->data['cityId'] = $city[0]['id']; 
		}else{
			#echo "from cookie";
			$this->data['cityId'] = $this->input->cookie('bda_cityId'); 
		}

		$retArray = array();
		if(!empty($query))
		{
			$data['doctor'] = $this->doctor_model->getDoctorByClinicId(array('doctor_name'=>$query,'column'=>array('doc.name'),'city_id'=>$this->data['cityId'],'status'=>ACTIVE));
			#print_r($data['doctor']);exit;
		if(is_array($data['doctor']) && sizeof($data['doctor']) > 0)
		{
			$retArray	=	array();
			foreach($data['doctor'] as $key=>$val)
			{
				$space_count = substr_count($query, " ")+1;
				$pos_val = strpos(strtolower($val['name']),$query);
				$val['name'] = substr($val['name'],$pos_val,strlen($val['name']));
				
				$space = strpos($query," ")+1;
				$retArray[$key] =  substr($val['name'],strpos(strtolower($val['name']),$query));
				$tmpArray = explode(" ",$retArray[$key]);
				if($space)
				{
					if($space_count==1)
					{
						$retArray[$key] = ucwords($tmpArray[0]." ".@$tmpArray[1]); 
					}
					else if($space_count==2)
					{
						$retArray[$key] = ucwords($tmpArray[0]." ".@$tmpArray[1]." ".@$tmpArray[2]); 
					}else if($space_count==3)
					{
						$retArray[$key] = ucwords($tmpArray[0]." ".@$tmpArray[1]." ".@$tmpArray[2]." ".@$tmpArray[3]); 
					}else if($space_count==4)
					{
						$retArray[$key] = ucwords($tmpArray[0]." ".@$tmpArray[1]." ".@$tmpArray[2]." ".@$tmpArray[3]." ".@$tmpArray[4]); 
					}else if($space_count==5)
					{
						$retArray[$key] = ucwords($tmpArray[0]." ".@$tmpArray[1]." ".@$tmpArray[2]." ".@$tmpArray[3]." ".@$tmpArray[4]." ".@$tmpArray[5]); 
					}
					
				}else
				{
					$retArray[$key] = ucwords(current($tmpArray)); 						
				}
				$retArray[$key] = ucwords($retArray[$key]); 
			}
			$retArray = array_unique($retArray);
			sort($retArray);
		}
			
		}
		$retArray = array_unique($retArray);
		sort($retArray);
		#print_r($this->db->queries);
		echo  json_encode($retArray);
		return false;
	}
	public function clinic_get(){
		$this->load->model(array('common_model'));
		$city = $this->get('city_name'); 
		$query =  str_replace("-"," ",urldecode($this->get('query'))); 

		if(!$this->input->cookie('bda_cityName')){
			$city = $this->common_model->getCity(array('limit'=>1,'status'=>1,'column'=>array('id','name'),'name'=>$city));
			$this->data['cityId'] = $city[0]['id']; 
		}else{
			#echo "from cookie";
			$this->data['cityId'] = $this->input->cookie('bda_cityId'); 
		}
		
		if(!$this->load->_is_model_loaded('clinic_model'))
		{
			$this->load->model(array('clinic_model'));
		}
		$retArray = array();
		if(!empty($query))
		{
			$data['clinic'] = $this->clinic_model->getClinic(array('name'=>urldecode($query),'city_id'=>$this->data['cityId'],'limit'=>100,'column'=>array('name')));//'status'=>ACTIVE,
			#echo $this->clinic;exit;

			if(is_array($data['clinic']) && sizeof($data['clinic']) > 0)
			{
			foreach($data['clinic'] as $key=>$val)
			{
				$space_count = substr_count($query, " ")+1;
				$pos_val = strpos(strtolower($val['name']),$query);
				$val['name'] = substr($val['name'],$pos_val,strlen($val['name']));
				
				$space = strpos($query," ")+1;
				$retArray[$key] =  substr($val['name'],strpos(strtolower($val['name']),$query));
				$tmpArray = explode(" ",$retArray[$key]);
				if($space)
				{
					if($space_count==1)
					{
						$retArray[$key] = ucwords($tmpArray[0]." ".@$tmpArray[1]); 
					}
					else if($space_count==2)
					{
						$retArray[$key] = ucwords($tmpArray[0]." ".@$tmpArray[1]." ".@$tmpArray[2]); 
					}else if($space_count==3)
					{
						$retArray[$key] = ucwords($tmpArray[0]." ".@$tmpArray[1]." ".@$tmpArray[2]." ".@$tmpArray[3]); 
					}else if($space_count==4)
					{
						$retArray[$key] = ucwords($tmpArray[0]." ".@$tmpArray[1]." ".@$tmpArray[2]." ".@$tmpArray[3]." ".@$tmpArray[4]); 
					}else if($space_count==5)
					{
						$retArray[$key] = ucwords($tmpArray[0]." ".@$tmpArray[1]." ".@$tmpArray[2]." ".@$tmpArray[3]." ".@$tmpArray[4]." ".@$tmpArray[5]); 
					}
					
				}else
				{
					$retArray[$key] = ucwords(current($tmpArray)); 						
				}
				$retArray[$key] = ucwords($retArray[$key]); 
			}

			}
		}
		$retArray = array_unique($retArray);
		sort($retArray);
		
		echo  json_encode($retArray);
		return false;
	}
  public function phone_number_post()
	{
		$clinic_id = $this->post('clinic_id'); 
		$doctor_id = $this->post('doctor_id'); 
		if(empty($clinic_id) || empty($doctor_id) )
		{
			$rs = array("message"=>"please provide clinic_id and doctor_id.","status"=>0);
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		}
		if(!is_numeric($clinic_id) || !is_numeric($doctor_id) )
		{
			$rs = array("message"=>"clinic_id and  doctor_id should be numeric.","status"=>0);
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		}
		
		$sql	=	"select cli.name as clinic_name,cli.address as clinic_address,doc.name as doctor_name,doc.speciality,doc.image as doctor_image,doc.gender as doctor_gender 
		from doctor doc join clinic cli on doc.id=cli.doctor_id where cli.id=".$clinic_id." and doc.id=".$doctor_id;
		
		$query =	$this->db->query($sql);
		if($query->num_rows > 0)
		{
			$details	=	$query->result_array();
			$details	=	current($details);
			
			if($details['speciality'])
			{
				$spe_sql	=	"select name from speciality where id in(".$details['speciality'].")";
				$spe_query =	$this->db->query($spe_sql);
				if($spe_query->num_rows > 0)
				{
					$spe_details	=	$spe_query->result_array();
					$details['speciality']	=	'';
					foreach($spe_details as $sp_val)
					{
						$details['speciality']	.=	ucwords($sp_val['name']).", ";
					}
					$details['speciality']	=	rtrim($details['speciality'],', ');
				}
			}
			else
			{
				$details['speciality']	=	'';
			}
			$details['doctor_name'] = "Dr. ".trim(ucwords($details['doctor_name']));
			if(empty($details['doctor_image']))
			{
				if(strtolower($details['doctor_gender']) == "m")
				{
					$details['doctor_image'] = "./static/images/default_doctor.png";
				}else if(strtolower($details['doctor_gender']) == "f")
				{
					$details['doctor_image'] = "./static/images/female_doctor.jpg";
				}else if(strtolower($details['doctor_gender']) == "o")
				{
					$details['doctor_image'] = "./static/images/default_404.jpg";
				}
			}			
		}
		
		$sql	=	"select contact_number from clinic where id=".$clinic_id;
		$query =	$this->db->query($sql);
		if($query->num_rows > 0)
		{
			$data	=	$query->result_array();
			if(!empty($data[0]['contact_number']))
			{
				$rs = array("number_data"=>$data[0]['contact_number'],"status"=>1,"message"=>"successful","query"=>$sql);
				if(isset($details))
				{
					$rs['details']	=	$details;
				}
				$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
			}
		}
		
		$sql	=	"select contact_number from doctor where id=".$doctor_id;
		$query =	$this->db->query($sql);
		if($query->num_rows > 0)
		{
			$data	=	$query->result_array();
			if(!empty($data[0]['contact_number']))
			{
				$rs = array("number_data"=>$data[0]['contact_number'],"status"=>1,"message"=>"successful","query"=>$sql);
				if(isset($details))
				{
					$rs['details']	=	$details;
				}

				$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
			}
		}

		$rs = array("number_data"=>"022 49 426 426","status"=>1,"message"=>"successful");
		$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
	}  
	public function available_slots_post()
	{
		$clinic_id 	= $this->post('clinic_id'); 
		$doctor_id 	= $this->post('doctor_id'); 
		$is_patient = $this->post('is_patient'); 
		if(empty($clinic_id) || empty($doctor_id) )
		{
			$rs = array("message"=>"please provide clinic_id and doctor_id.","status"=>0);
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		}
		if(!is_numeric($clinic_id) || !is_numeric($doctor_id) )
		{
			$rs = array("message"=>"clinic_id and  doctor_id should be numeric.","status"=>0);
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		}
		
		$today_date	=	 date("Y-m-d");
		$end_date = date("Y-m-d",strtotime("+20 days",strtotime($today_date)));
		$cur_timestamp = strtotime($today_date);
		
		$this->load->model(array('doctor_model'));
		$sql	=	"select timings,duration from clinic where id=".$clinic_id;
		$query =	$this->db->query($sql);
		if($query->num_rows > 0)
		{
			$date_range	=	array();
			$current_date	=	 date("Y-m-d");
			for($a = 0; $a <= 6; $a++)
			{
				array_push($date_range,date('Y-m-d', strtotime("+$a day", $cur_timestamp)));
			}
			$data	=	$query->result_array();
			$time_data = $this->doctor_model->getTimeArrayFromTimings(array('timings' =>$data[0]['timings'],'duration'=>$data[0]['duration']));
			
			if($is_patient)
			{
				$this->load->model('patient_model');
				$appointment_data = $this->patient_model->getAppointmenByDateAndDoctorId(array('start_date'=>$today_date,'end_date'=>$end_date,'doctor_id'=>$doctor_id,'clinic_id' =>$clinic_id,'duration'=>$data[0]['duration']));			
			}
			else
			{
				$appointment_data = $this->doctor_model->getAppointmenByDateAndDoctorId(array('start_date'=>$today_date,'end_date'=>$end_date,'doctor_id'=>$doctor_id,'clinic_id' =>$clinic_id,'duration'=>$data[0]['duration']));			
			
			}
			
			#print_r($time_data);
			#print_r($appointment_data);exit;
			$time_array	=	 array();
			foreach($date_range as $date_key=>$date_value)
			{
				$time_array[$date_key]['week_day']	=	date("D",strtotime($date_value));
				$time_array[$date_key]['date']	=	date("d M",strtotime($date_value));
				$time_array[$date_key]['org_date']	=	date("Y-m-d",strtotime($date_value));
				$week_day	=	date("w",strtotime($date_value));
				
				if(isset($time_data[$week_day][0]) && is_array($time_data[$week_day][0]) && sizeof($time_data[$week_day][0])>0)
				{
					if(isset($appointment_data[$date_value]))
					{
						$time_array[$date_key]['time'][0]	=  array_diff($time_data[$week_day][0],$appointment_data[$date_value]);
						if(is_array($time_array[$date_key]['time'][0]) && sizeof($time_array[$date_key]['time'][0])>0)
						{
							$time_array[$date_key]['time'][0]	=	 array_values($time_array[$date_key]['time'][0]);
						}
					}
					else
					{
						if(is_array($time_data[$week_day][0]) && sizeof($time_data[$week_day][0])>0)
						{
							$time_array[$date_key]['time'][0]	=	 $time_data[$week_day][0];
						}
					}
					if($current_date	==	$time_array[$date_key]['org_date'])
					{
						$org_filter_array	=	array_filter($time_array[$date_key]['time'][0],array('Search','remove_past_time'));
						$time_array[$date_key]['time'][0]	=	array_values($org_filter_array);
						#$time_array[$date_key]['time'][0]
					}
				}
				else
				{
					$time_array[$date_key]['time'][0]	=	 array();
				}

				if(isset($time_data[$week_day][1]) && is_array($time_data[$week_day][1]) && sizeof($time_data[$week_day][1])>0)
				{
					if(isset($appointment_data[$date_value]))
					{
						$time_array[$date_key]['time'][1]	= (array)array_diff($time_data[$week_day][1],$appointment_data[$date_value]);
						if(is_array($time_array[$date_key]['time'][1]) && sizeof($time_array[$date_key]['time'][1])>0)
						{
							$time_array[$date_key]['time'][1]	=	 array_values($time_array[$date_key]['time'][1]);
						}
					}
					else
					{
						if(is_array($time_data[$week_day][1]) && sizeof($time_data[$week_day][1])>0)
						{
							$time_array[$date_key]['time'][1]	=	 $time_data[$week_day][1];
						}
					}
					if($current_date	==	$time_array[$date_key]['org_date'])
					{
						$org_filter_array	=	array_filter($time_array[$date_key]['time'][1],array('Search','remove_past_time'));
						$time_array[$date_key]['time'][1]	=	array_values($org_filter_array);
						
					}
				}
				else
				{
					$time_array[$date_key]['time'][1]	=	array();
				}
			}
			if(is_array($time_array))
			{
				$rs = array("slots_data"=>$time_array,"status"=>1,"message"=>"successful");	
			}	
			else
			{
				$rs = array("status"=>0,"message"=>"no slots available");	
			}
		}
		$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
	}
	function remove_past_time($var)
	{
		$date	=	 date("Y-m-d");
		if(strtotime($date." ".$var)>strtotime("now"))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	function get_expiry_date($registation_date)
	{
		date_default_timezone_set('Asia/Kolkata');
		$registation_date	= date("Y-m-d",strtotime($registation_date));
		$today = date('l',strtotime($registation_date));
		
		if ($today == 'Thursday'){$expitydate = date('Y-m-d', strtotime($registation_date."+4 days"));}
		elseif ($today == 'Friday') {$expitydate = date('Y-m-d', strtotime($registation_date."+4 days"));}
		elseif ($today == 'Saturday') {$expitydate = date('Y-m-d', strtotime($registation_date."+3 days"));}
		else {$expitydate = date('Y-m-d', strtotime($registation_date."+2 days"));}
		return $expitydate;
	}
}