<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
* Example
*
* This is an example of a few basic user interaction methods you could use
* all done with a hardcoded array.
*
* @package        CodeIgniter
* @subpackage    Rest Server
* @category    Controller
* @author        Phil Sturgeon
* @link        http://philsturgeon.co.uk/code/
*/

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH.'/libraries/REST_Controller.php';

class Doctor extends REST_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model(array('doctor_model','common_model','reviews_model'));
	}
	
	function addclinic_post()
	{
		$user_id   = $this->post('user_id');
		$doctor_id = $this->post('doctor_id');
		#print_r($this->post());exit;
		$clinic_id = $this->doctor_model->insert_clinic($user_id, $doctor_id, $this->post());
		if($clinic_id)
		{
			$rs = array("clinic_data"=>array("id"=>$clinic_id),"message"    =>"successfully added clinic","status"     =>1);
		}
		else
		{
			$rs = array("message"=>"clinic not added","status" =>0);
		}
		$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code

	}

	function updateclinic_post()
	{
		$clinic_id = intval($this->post('clinic_id'));
		$user_id   = intval($this->post('user_id'));
		$doctor_id = intval($this->post('doctor_id'));
		if($clinic_id && $user_id && $doctor_id ){
			$this->doctor_model->update_clinic($user_id, $doctor_id, $clinic_id, $this->post);
			if($this->db->affected_rows())
			{
				$rs = array("clinic_data"=>"clinic updated","message"    =>"successfully updated clinic","status"     =>1);
			}
			else
			{
				$rs = array("message"=>"clinic not updated","status" =>0);
				if($this->db->_error_message()){
					$rs['error'] = $this->db->_error_message();
				}
			}
		}
		else
		{
			$rs = array("message"=>"please provide valid clinic_id, user_id, doctor_id ","status" =>0);
		}
		$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
	}

	function delete_clinic_post()
	{
		$clinic_id = intval($this->post('clinic_id'));
		$doctor_id = intval($this->post('doctor_id'));
		if(empty($clinic_id) || empty($doctor_id)){
			$rs = array("message"=>"please provide clinic_id and  doctor_id","status" =>0);
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		}

		$rs = $this->doctor_model->delete_clinic($clinic_id, $doctor_id);
		if($rs){
			$rs = array("message"=>"clinic deleted successfully","status" =>1);
		}
		else
		{
			$rs = array("message"=>"clinic not deleted","status" =>0);
		}

		$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
	}

	function getclinic_post()
	{
		
		$this->load->model(array('clinic_model','location_model'));
		$doctor_id = intval($this->post('doctor_id'));
		$clinic_id = intval($this->post('clinic_id'));
		$device_latitude = (string)$this->post('device_latitude'); 
		$device_longitude = (string)$this->post('device_longitude'); 
		
		$t = $this->post('t');
		if($doctor_id)
		{
			$doctor_data = $this->doctor_model->get_doctor_data(0,$doctor_id);
			$package = $this->doctor_model->get_all_doctor_packages($doctor_data->user_id);
			$doctor_data->quick_appointment	=	0;
			if(isset($package[0]->package_id) && $package[0]->package_id==30)
			{
				$doctor_data->quick_appointment	=	1;
			}
			
			$clinic = $this->clinic_model->getClinic(array('doctor_id'=>$doctor_id,'column'=>array('id','name','location_id','city_id','other_location','latitude','longitude','address','timings','is_number_verified')));
			if($t)
			{
				print_r($doctor_data);exit;
			echo $this->clinic_model;exit;
			}
			
			if($clinic){
				foreach($clinic as $key=>$val){
					$clinic[$key]['city_name'] = $this->common_model->getCity(array('limit' =>1,'column'=>array('id','name'),'id'    =>$val['city_id']));
					$clinic[$key]['city_name'] = current($clinic[$key]['city_name']);
					$clinic[$key]['city_name'] = $clinic[$key]['city_name']['name'];
					if($val['location_id']){
						$clinic[$key]['location_name'] = $this->common_model->getLocation(array('limit' =>1,'status'=>1,'column'=>array('id','name'),'id'    =>$val['location_id']));
						$clinic[$key]['location_name'] = current($clinic[$key]['location_name']);
						$clinic[$key]['location_name'] = ucwords($clinic[$key]['location_name']['name']);
					}
					else
					{
						$clinic[$key]['location_name'] = $val['other_location'];
					}
					if(!empty($val['latitude']) && !empty($val['longitude']) && $device_latitude && $device_longitude)
					{
						$clinic[$key]['distance'] = number_format($this->location_model->distance_by_lat_lng($val['latitude'],$val['longitude'],$device_latitude,$device_longitude,"K"),2);
					}
					$clinic[$key]['display_timings']	=	 $this->clinic_model->get_clinic_formatted_time($val['timings']);
					
					if($doctor_data->quick_appointment==1)
					{
						$clinic[$key]['appointment_type']	=	 'quickbookdrappointment';
					}
					else if($doctor_data->is_ver_reg>0 || $clinic[$key]['is_number_verified']==1)
					{
						$clinic[$key]['appointment_type']	=	 'appointmentviaphone';
					}
					else
					{
						$clinic[$key]['appointment_type']	=	 'bookdrappointment';
					}

					unset($clinic[$key]['timings'],$clinic[$key]['is_number_verified']);
				}
				$rs = array("clinic_data" =>$clinic,"clinic_count"=>sizeof($clinic),"message"     =>"successful","status"      =>1);
			}
			else
			{
				$rs = array("message"=>"clinic not present","status" =>0);
			}
		}
		else if($clinic_id)
		{
			$clinic = $this->clinic_model->getClinic(array('id'   =>$clinic_id,'limit'=>'1'));
			if($clinic)
			{
				$clinic = current($clinic);

				$doctor_data = $this->doctor_model->get_doctor_data(0,$clinic['doctor_id']);

				$package = $this->doctor_model->get_all_doctor_packages($doctor_data->user_id);
				$doctor_data->quick_appointment	=	0;
				if(isset($package[0]->package_id) && $package[0]->package_id==30)
				{
					$doctor_data->quick_appointment	=1;
				}
				
				#$clinic['doctor_data']	=	$doctor_data;
				$clinic['doctor_name']	=	"Dr. ".$doctor_data->name;
				$clinic['doctor_image']	=	$doctor_data->image;
				if(empty($doctor_data->image))
				{
					if(strtolower($doctor_data->gender) == "m")
					{
						$clinic['doctor_image'] = "./static/images/default_doctor.png";
					}else if(strtolower($doctor_data->gender) == "f")
					{
						$clinic['doctor_image'] = "./static/images/female_doctor.jpg";
					}else if(strtolower($doctor_data->gender) == "o")
					{
						$clinic['doctor_image'] = "./static/images/default_404.jpg";
					}
				}
				
				$clinic['doctor_speciality'] = $this->common_model->getSpeciality(array('ids'=>$doctor_data->speciality,'column'=>array('id','name'),'limit'=>20,'orderby'=>'field(id,'.$doctor_data->speciality.')'));
				$clinic['doctor_yoe']	=	$doctor_data->yoe;
				$clinic['doctor_summary']	=	$doctor_data->summary;
				$clinic['doctor_gender']	=	$doctor_data->gender;
				$clinic['doctor_qualification'] = $this->common_model->getQualification(array('ids'=>$doctor_data->qualification,'column'=>array('id','name'),'orderby'=>'field(id,'.$doctor_data->qualification.')'));
				$clinic['disptimings_clinic']	=	 $this->clinic_model->get_clinic_formatted_time($clinic['timings']);

				if($doctor_data->quick_appointment == 1)
				{
					$clinic['appointment_type']	=	 'quickbookdrappointment';
				}
				else if($doctor_data->is_ver_reg>0 || $clinic['is_number_verified']==1)
				{
					$clinic['appointment_type']	=	 'appointmentviaphone';
				}
				else				
				{
					$clinic['appointment_type']	=	 'bookdrappointment';
				}
				
				$clinic['city_data'] = $this->common_model->getCity(array('limit' =>1,'column'=>array('id','name','state_id'),'id'    =>$clinic['city_id']));
				$clinic['city_data'] = current($clinic['city_data']);
				$clinic['city_name'] = $clinic['city_data']['name'];
				$clinic['state_id'] = $clinic['city_data']['state_id'];

				$clinic['state_data'] = $this->common_model->getState(array('limit' =>1,'column'=>array('id','name'),'id'    =>$clinic['state_id']));
				$clinic['state_data'] = current($clinic['state_data']);
				$clinic['state_name'] = $clinic['state_data']['name'];
				$clinic['lattitude']	=	$clinic['latitude'];

				if(!empty($clinic['latitude']) && !empty($clinic['longitude']) && $device_latitude && $device_longitude)
				{
					$clinic['distance'] = number_format($this->location_model->distance_by_lat_lng($clinic['latitude'],$clinic['longitude'],$device_latitude,$device_longitude,"K"),2);
				}
				
				unset($clinic['state_data'],$clinic['city_data']);
				
				if(!empty($clinic['image'])){
					$clinic['image'] = explode(",",$clinic['image']);
					if(is_array($clinic['image']) && sizeof($clinic['image']) == 0){
						unset($clinic['image']);
					}
				}

				if($clinic['location_id'])
				{
					$clinic['location'] = $this->common_model->getLocation(array('limit' =>1,'status'=>1,'column'=>array('id','name','latitude','longitude'),'id'    =>$clinic['location_id']));
					$clinic['location'] = current($clinic['location']);

					$clinic['location_name'] = ucwords($clinic['location']['name']);
					if(empty($clinic['lattitude']))
					{
						$clinic['latitude']		=	$clinic['location']['latitude'];	
						$clinic['longitude']	=	$clinic['location']['longitude'];		
						$clinic['lattitude']	=	$clinic['location']['latitude'];	
					}
					unset($clinic['location']);	
				}else if($clinic['other_location'])
				{
					$clinic['location_name'] = ucwords($clinic['other_location']);
				}
				$clinic['disptimings_clinic']	=	 $this->clinic_model->get_clinic_formatted_time($clinic['timings']);
				$clinic['disptimings']	=	 $this->clinic_model->get_clinic_formatted_separate_time($clinic['timings']);
				$clinic['timings']	=	 $this->clinic_model->get_clinic_half_time_format($clinic['timings']);

				

				foreach($clinic as $cliKey=>$cliVal){
					if(empty($clinic[$cliKey])){
						unset($clinic[$cliKey]);
					}
				}
				#unset($clinic['timings']);
				$rs = array("clinic_data"=>$clinic,"message"    =>"successful","status"     =>1);
			}
			else
			{
				$rs = array("message"=>"clinic not present","status" =>0);
			}

		}
		else
		{
			$rs = array("message"=>"please provide clinic_id / doctor_id","status" =>0);
		}
		$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code

	}

	function profile_post()
	{
		$doctor_id = $this->post('doctor_id');
		$user_id   = $this->post('user_id');
		$user_type = $this->post('user_type');
		$package_id	= $this->post('package_id');
		$rs        = array("message"=>"Please Provide user_id, user_type and package_id","status" =>0);
		if(($user_id || $doctor_id ) && $user_type == "2" ){
			#$package = $this->doctor_model->get_doctor_package_details($user_id);
			if($package_id == "20" || $package_id == "30" || $package_id == "40")
			{
				$data = $this->doctor_model->get_doctor_data($user_id,$doctor_id);
				if($data){
					if(empty($data->image)){
						if(strtolower($data->gender) == "m"){
							$data->image = "./static/images/default_doctor.png";;
						}
						else
						if(strtolower($data->gender) == "f"){
							$data->image = "./static/images/female_doctor.jpg";
						}
					}
					if(!empty($data->speciality))
					{
					$data->speciality = $this->common_model->getSpeciality(array('ids'=>$data->speciality,'column'      =>array('id','name'),'limit'  =>20,'orderby'=>'field(id,'.$data->speciality.')'));
					}
					
					if(!empty($data->qualification))
					{
					$data->qualification = $this->common_model->getQualification(array('ids'=>$data->qualification,'column'=>array('id','name'),'orderby'=>'field(id,'.$data->qualification.')'));
					}
					#echo $this->common;exit;
					if(!empty($data->council_id)){
						$data->council = $this->common_model->getCouncils(array('id'    =>$data->council_id,'column'=>array('id','name')));
					}

					if(isset($data->other_qualification) && !empty($data->other_qualification)){
						$data->other_qualification = explode(",",$data->other_qualification);
					}
					if(isset($data->other_speciality) && !empty($data->other_speciality)){
						$data->other_speciality = explode(",",ucwords($data->other_speciality));
					}

					if(isset($data->council) && is_array($data->council) && sizeof($data->council) > 0){
						$data->council_name = $data->council[0]['name'];
					}
					unset($data->council);

					$data->happy_patient_count = $this->reviews_model->get_happy_reviews_count($doctor_id);
					
					$data->name = "Dr. ".trim(ucwords(str_replace("dr.","",strtolower($data->name))));
					
					foreach($data as $nKey=>$nVal){
						if(empty($data->$nKey)){
							unset($data->$nKey);
						}
					}
					
					if(!isset($data->happy_patient_count))
					{
						$data->happy_patient_count	=	0;
					}
					if(isset($data->id))
					{
						$doctor_detail = $this->doctor_model->getDoctorDetail(array('doctor_id'=>$data->id,'limit'    =>1000));
					}
					#echo $this->doctor_model;
					$dd_array = array();
					if(isset($doctor_detail) && is_array($doctor_detail) && sizeof($doctor_detail) > 0){
						foreach($doctor_detail as $dInKey=>$dInVal){
							foreach($dInVal as $fdKey=>$fdVal){

								if($dInKey == "Education"){
									$dd_array['Education'][$fdKey] = trim((!empty($fdVal['description1'])?$fdVal['description1']:''));
									$dd_array['Education'][$fdKey] .= (!empty($fdVal['description2'])?" - ".$fdVal['description2']:'');
									$dd_array['Education'][$fdKey] .= (!empty($fdVal['description3'])?", ".$fdVal['description3']:'');
									$dd_array['Education'][$fdKey] .= (!empty($fdVal['from_year'])?" ".$fdVal['from_year']:'');
								}
								else
								if($dInKey == "Registrations"){
									$dd_array['Registrations'][$fdKey] = (!empty($fdVal['description1'])?$fdVal['description1']:'');
									$dd_array['Registrations'][$fdKey] .= (!empty($fdVal['description2'])?" - ".$fdVal['description2']:'');
									$dd_array['Registrations'][$fdKey] .= (!empty($fdVal['from_year'])?", ".$fdVal['from_year']:'');
								}
								else
								if($dInKey == "Experience"){
									$dd_array['Experience'][$fdKey] = (!empty($fdVal['from_year'])?$fdVal['from_year']:'');
									$dd_array['Experience'][$fdKey] .= (!empty($fdVal['to_year'])?" - ".$fdVal['to_year']:'');
									$dd_array['Experience'][$fdKey] .= (!empty($fdVal['description1'])?" ".$fdVal['description1']:'');
									$dd_array['Experience'][$fdKey] .= (!empty($fdVal['description2'])?" at ".$fdVal['description2']:'');
									$dd_array['Experience'][$fdKey] .= (!empty($fdVal['description3'])?" - ".$fdVal['description3']:'');
								}
								else
								if($dInKey == "AwardsAndRecognitions"){
									$dd_array['AwardsAndRecognitions'][$fdKey] = (!empty($fdVal['description1'])?$fdVal['description1']:'');
									$dd_array['AwardsAndRecognitions'][$fdKey] .= (!empty($fdVal['from_year'])?" - ".$fdVal['from_year']:'');
								}
								else
								{
									$dd_array[$dInKey][$fdKey] = $fdVal['description1'];
								}
							}
						}
					}

					$rs = array("basic"=>$data);
					if(is_array($dd_array) && sizeof($dd_array)){
						$rs["advance"] = $dd_array;
					}

					$rs = array("doctor_data"=>$rs,"message"=>"successful","status"=>1);

				}
				else
				{
					$rs = array("message"=>"no such user","status" =>0);
				}

			}
			else
			{

				$data = $this->doctor_model->get_doctor_data($user_id,$doctor_id);
				if($data){
					if(empty($data->image)){
						if(strtolower($data->gender) == "m")
						{
							$data->image = "./static/images/default_doctor.png";;
						}
						else
						if(strtolower($data->gender) == "f")
						{
							$data->image = "./static/images/female_doctor.jpg";
						}
					}
					if(!empty($data->speciality))
					{
					$data->speciality = $this->common_model->getSpeciality(array('ids'    =>$data->speciality,'column'      =>array('id','name'),'orderby'=>'field(id,'.$data->speciality.')'));
					}
					if(!empty($data->qualification))
					{
					$data->qualification = $this->common_model->getQualification(array('ids'    =>$data->qualification,'column'      =>array('id','name'),'orderby'=>'field(id,'.$data->qualification.')'));
					}
					if(!empty($data->council_id))
					{
						$data->council = $this->common_model->getCouncils(array('id'    =>$data->council_id,'column'=>array('id','name')));
					}

				
					if(isset($data->other_qualification) && !empty($data->other_qualification)){
						$data->other_qualification = explode(",",$data->other_qualification);
					}
					if(isset($data->other_speciality) && !empty($data->other_speciality)){
						$data->other_speciality = explode(",",$data->other_speciality);
					}
					if(isset($data->other_specialization) && !empty($data->other_specialization)){
						$data->other_specialization = explode(",",$data->other_specialization);
					}

					if(isset($data->council) && is_array($data->council) && sizeof($data->council) > 0){
						$data->council_name = $data->council[0]['name'];

					}
					unset($data->council);
					$data->name = "Dr. ".trim(ucwords(str_replace("dr.","",strtolower($data->name))));
					$data->happy_patient_count = $this->reviews_model->get_happy_reviews_count($doctor_id);
					
					foreach($data as $nKey=>$nVal){
						if(empty($data->$nKey)){
							unset($data->$nKey);
						}
					}

					if(!isset($data->happy_patient_count))
					{
						$data->happy_patient_count	=	0;
					}
					
					$rs = array("doctor_data"=>array("basic"=>$data),"message"    =>"successful","status"     =>1);
				}
				else
				{
					$rs = array("message"=>"no such user","status" =>0);
				}


			}
		}
		$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
	}
	
	function getadvanceprofile_post()
	{
		$this->load->model('doctor_details_model');
		$doctor_id = $this->post('doctor_id');
		if($doctor_id)
		{
			$rs = array();
			$advance_data = $this->doctor_model->getDoctorDetail(array('doctor_id'=>$doctor_id));
			if($advance_data)
			{
				$rs['advance_data'] = $advance_data;
			}
			
			$patient = $this->doctor_details_model->getPatientNumbers(array('doctor_id'=>$doctor_id,'orderby'=>'id asc'));
			if(is_array($patient) && sizeof($patient) > 0)
			{
				$rs['patient'] = $patient;
			}

			$doctor_summary = $this->doctor_model->getDoctor(array('limit' =>1,'id'    =>$doctor_id,'column'=>array('summary')));
			if(isset($doctor_summary[0]['summary']) && !empty($doctor_summary[0]['summary']))
			{
				$rs['doctor_summary'] = trim($doctor_summary[0]['summary']);
			}
			if(empty($rs))
			{
				$rs = array("doctor_data"=>$rs,"message"=>"data not available","status"=>1);
			}
			else
			{
					$rs = array("doctor_data"=>$rs,"message"=>"successful","status"=>1);
			}
		}
		else
		{
			$rs = array("message"=>"please provide doctor_id","status" =>0);
		}

		$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
	}
	
	function updatebasicprofile_post()
	{
		$user_id    = intval($this->post('user_id'));
		$image_path = ($this->post('image_path'))?$this->post('image_path'):'';
		if($user_id){
			if(isset($this->post['speciality']))ksort($this->post['speciality']);
			if(isset($this->post['degree']))ksort($this->post['degree']);
			if(isset($this->post['speciality_other']))ksort($this->post['speciality_other']);
			if(isset($this->post['degree_other']))ksort($this->post['degree_other']);

			#print_r($this->post);exit;
			$this->doctor_model->update_doctor_professional_details($this->post, $image_path, $user_id);
			if($this->db->affected_rows())
			{
				$rs = array("profile_data"=>"basic profile updated","message"     =>"successfully updated basic profile","status"      =>1);
			}
			else
			{
				$rs = array("message"=>"basic profile not updated","status" =>0,"erorr"  =>$this->db->_error_message());
			}
		}
		else
		{
			$rs = array("message"=>"please provide user_id","status" =>0);
		}
		$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
	}
	
	function saveadvanceprofile_post()
	{
		$this->load->model('doctor_details_model');
		$doctor_id = $this->post('doctor_id');
		if($doctor_id){
			$docDetailArray = array();
			if(isset($this->post['services']) && is_array($this->post['services']))
			{
				ksort($this->post['services']);
				foreach($this->post['services'] as $key=>$val)
				{
					if(!empty($val))
					{
						$docDetailArray[] = array(
							'doctor_id'   =>$doctor_id,
							'attribute'   =>'Services',
							'description1'=>$val,
							'sort'        =>$key + 1
						);
					}

				}
			}

			if(isset($this->post['specializations']) && is_array($this->post['specializations']))
			{

				ksort($this->post['specializations']);
				foreach($this->post['specializations'] as $key=>$val)
				{
					if(!empty($val))
					{
						$docDetailArray[] = array(
							'doctor_id'   =>$doctor_id,
							'attribute'   =>'Specializations',
							'description1'=>$val,
							'sort'        =>$key + 1
						);
					}
				}
			}
			if(isset($this->post['membership']) && is_array($this->post['membership']))
			{
				ksort($this->post['membership']);
				foreach($this->post['membership'] as $key=>$val)
				{
					if(!empty($val))
					{
						$docDetailArray[] = array(
							'doctor_id'   =>$doctor_id,
							'attribute'   =>'Membership',
							'description1'=>$val,
							'sort'        =>$key + 1
						);
					}
				}
			}
			if(isset($this->post['qualifications']) && is_array($this->post['qualifications']))
			{
				ksort($this->post['qualifications']);
				foreach($this->post['qualifications'] as $key=>$val)
				{
					if(!empty($val))
					{
						$docDetailArray[] = array(
							'doctor_id'   =>$doctor_id,
							'attribute'   =>'Qualifications',
							'description1'=>$val,
							'sort'        =>$key + 1
						);
					}
				}
			}
			if(isset($this->post['paperspublished']) && is_array($this->post['paperspublished']))
			{
				ksort($this->post['paperspublished']);
				foreach($this->post['paperspublished'] as $key=>$val)
				{
					if(!empty($val))
					{
						$docDetailArray[] = array(
							'doctor_id'   =>$doctor_id,
							'attribute'   =>'PapersPublished',
							'description1'=>$val,
							'sort'        =>$key + 1
						);
					}
				}
			}
			if(isset($this->post['education_qualification']) && is_array($this->post['education_qualification']))
			{
				ksort($this->post['education_qualification']);
				foreach($this->post['education_qualification'] as $key=>$val)
				{
					if(!empty($val))
					{
						$from_year = !empty($this->post['education_from_year'][$key])?$this->post['education_from_year'][$key]:NULL;
						$docDetailArray[] = array(
							'doctor_id'   =>$doctor_id,
							'attribute'   =>'Education',
							'description1'=>$val,
							'description2'=>$this->post['education_college'][$key],
							'from_year'   =>$from_year,
							'sort'        =>$key + 1
						);
					}
				}
			}
			if(isset($this->post['registrations_council']) && is_array($this->post['registrations_council']))
			{
				ksort($this->post['registrations_council']);
				foreach($this->post['registrations_council'] as $key=>$val)
				{
					if(!empty($val))
					{
						$from_year = !empty($this->post['registrations_year'][$key])?$this->post['registrations_year'][$key]:NULL;
						$docDetailArray[] = array(
							'doctor_id'   =>$doctor_id,
							'attribute'   =>'Registrations',
							'description1'=>$this->post['registrations_no'][$key],
							'description2'=>$val,
							'from_year'   =>$from_year,
							'sort'        =>$key + 1
						);
					}
				}
			}
			if(isset($this->post['experience_role']) && is_array($this->post['experience_role']))
			{
				ksort($this->post['experience_role']);
				foreach($this->post['experience_role'] as $key=>$val)
				{
					if(!empty($val))
					{
						$from_year = !empty($this->post['experience_from_year'][$key])?$this->post['experience_from_year'][$key]:NULL;
						$to_year = !empty($this->post['experience_to_year'][$key])?$this->post['experience_to_year'][$key]:NULL;
						$docDetailArray[] = array(
							'doctor_id'   =>$doctor_id,
							'attribute'   =>'Experience',
							'description1'=>$val,
							'description2'=>$this->post['experience_hospital'][$key],
							'description3'=>$this->post['experience_city'][$key],
							'from_year'   =>$from_year,
							'to_year'     =>$to_year,
							'sort'        =>$key + 1
						);
					}
				}
			}
			if(isset($this->post['awardsandrecognitions_award']) && is_array($this->post['awardsandrecognitions_award']))
			{
				ksort($this->post['awardsandrecognitions_award']);
				foreach($this->post['awardsandrecognitions_award'] as $key=>$val)
				{
					if(!empty($val))
					{
						$from_year = !empty($this->post['awardsandrecognitions_from_year'][$key])?$this->post['awardsandrecognitions_from_year'][$key]:NULL;
						$docDetailArray[] = array(
							'doctor_id'   =>$doctor_id,
							'attribute'   =>'AwardsAndRecognitions',
							'description1'=>$val,
							'from_year'   =>$from_year,
							'sort'        =>$key + 1
						);
					}
				}
			}

			#print_r($docDetailArray);exit;
			$doc_del_rs = $this->doctor_model->deleteDoctorDetailById(array('doctor_id'=>$doctor_id)); # this will delete doctor detail for a doctor_id

			if(is_array($docDetailArray) && sizeof($docDetailArray) > 0)
			{
				foreach($docDetailArray as $key=>$val)
				{
					$insert_ids[] = $this->doctor_model->insertDoctorSingleDetail($val);

				}
				$rs['advance_details'] = array("message"=>"details inserted","status" =>1);

			}
			else
			{
				$rs['advance_details'] = array("message"=>"no details provided","status" =>0);
			}

			if(isset($this->post['doctor_summary']) && !empty($this->post['doctor_summary']))
			{
				$this->doctor_model->updateDoctor(array(
						'set'                  =>array(
							'summary'=>$this->post['doctor_summary']),
						'where'=>array('id'=>$doctor_id))
				);
				$rs['doctor_summary'] = array("message"=>"summary updated","status" =>1);
			}
			else
			{
				$rs['doctor_summary'] = array("message"=>"no summary provided","status" =>0);
			}

			if(isset($this->post['patient_name']) && sizeof($this->post['patient_name']) > 0){
				foreach($this->post['patient_name'] as $key=>$val)
				{
					if(!empty($val) && isset($this->post['patient_number'][$key]))
					{
						$patients[$key] = array(
							'doctor_id'     =>$doctor_id,
							'patient_name'  =>$val,
							'patient_number'=>$this->post['patient_number'][$key]
						);
					}
				}
			}

			if(isset($patients) && is_array($patients) && sizeof($patients) > 0)
			{
				$patient_del_rs = $this->doctor_model->deletePatientNumbersByDoctorId(array('doctor_id'=>$doctor_id)); # this will delete patient numbers for a doctor_id
				$res = $this->doctor_model->insertPatientNumbersByBatch($patients);
				if($res){
					$rs['patient'] = array("message"=>"patients inserted","status" =>1);
				}
				else
				{
					$rs['patient'] = array("message"=>"patients not inserted","status" =>0);
				}

			}
			else
			{
				$rs['patient'] = array("message"=>"no patients list provided","status" =>0);
			}
			$rs['message'] = "successful";
			$rs['status'] = 1;
		}
		else
		{
			$rs = array("message"=>"please provide doctor_id","status" =>0);
		}
		$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
	}

	function get_clinic_timings_post()
	{
		
		$doctor_id = intval($this->post('doctor_id'));
		$is_date	=	strtotime($this->post('date'));				
		$date = date("Y-m-d",$is_date);
		$cur_datetime = date("Y-m-d H:i:s");
		
		if(empty($doctor_id) || $is_date===false)
		{
			$rs = array("message"=>"please provide doctor_id, date","status"=>0);
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		}
		$this->load->model(array('clinic_model'));		
		$clinic = $this->clinic_model->getClinic(array('doctor_id'=>$doctor_id,'column'=>array('id','name','timings','is_number_verified')));
		
		if($clinic)
		{
			foreach($clinic as $key=>$val)
			{
				#$timings[$key]['display_timings']	=	 $this->clinic_model->get_clinic_time_bydate($val['timings'],$date);#get_clinic_time_bydate
				$display_timings	=	 $this->clinic_model->get_clinic_time_bydate($val['timings'],$date);#get_clinic_time_bydate
				if(isset($display_timings[0]))
				{
					$timings[$key]								=	 $display_timings[0];
					$timings[$key]['clinic_name']	=	 $val['name'];
					$timings[$key]['clinic_id']		=	 $val['id'];
					if(isset($timings[$key]['time1']))
					{
						$tmp	=	 NULL;
						$tmp	= explode("-",$timings[$key]['time1']);
						if(sizeof($tmp)==2)
						{
							$tmp[0]												=	date("Y-m-d H:i:s",strtotime($date." ".$tmp[0])); 
							$tmp[1]												=	date("Y-m-d H:i:s",strtotime($date." ".$tmp[1])); 
							$timings[$key]['datetime1']		= $tmp;
							
							$timings[$key]['statustime1']		= "OFF";
							#echo $cur_datetime." -- ".$tmp[1];exit;
							if(strtotime($cur_datetime)<strtotime($tmp[1]))
							{
								$timings[$key]['statustime1']	= "ON";
							}
							
						}
					}
					if(isset($timings[$key]['time2']))
					{
						$tmp	=	 NULL;
						$tmp	= explode("-",$timings[$key]['time2']);
						if(sizeof($tmp)==2)
						{
							$tmp[0]	=	date("Y-m-d H:i:s",strtotime($date." ".$tmp[0])); 
							$tmp[1]	=	date("Y-m-d H:i:s",strtotime($date." ".$tmp[1])); 
							$timings[$key]['datetime2']	= $tmp;
							
							$timings[$key]['statustime2']		= "OFF";
							if(strtotime($cur_datetime)<strtotime($tmp[1]))
							{
								$timings[$key]['statustime2']	= "ON";
							}
						}
					}
					
					
				}
			}
			if(isset($timings))
			{
				$rs = array("data"=>$timings,"message"=>"successful","status"=>1);
			}
			else
			{
				$rs = array("message"=>"doctor is not available on this day in any of his clinic","status"=>0);
			}
		}
		else
		{
			$rs = array("message"=>"clinic not available for this doctor","status"=>0);
		}
		$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		
	}
	
	function delete_doctor_detail_byid_post()
	{
		$id = intval($this->post('id'));
		if($id)
		{
			$sql	= "delete from doctor_detail where id='".$id."'";
			$this->db->query($sql);
			echo json_encode(array("success"=>$this->db->affected_rows()));
		}
		else
		{
			echo json_encode(array("error"=>"please select id"));
		}
	}
	function add_doctor_detail_by_attribute_post()
	{
		$doctor_id 		= $this->post('doctor_id');
		$attribute 		= trim($this->post('attribute'));
		$description1 = trim($this->post('description1'));
		$description2 = trim($this->post('description2'));
		$description3 = trim($this->post('description3'));
		$from_year 		= trim($this->post('from_year'));
		$to_year 			= trim($this->post('to_year'));
		
		if($description1 && $doctor_id && $attribute)
		{
			$insert_arr	=	array('doctor_id'=>$doctor_id,'attribute'=>$attribute,'description1'=>$description1);
			if($description2)
			{
				$insert_arr['description2']	=	$description2;
			}
			if($description3)
			{
				$insert_arr['description3']	=	$description3;
			}
			if($from_year)
			{
				$insert_arr['from_year']	=	$from_year;
			}
			if($to_year)
			{
				$insert_arr['to_year']	=	$to_year;
			}
			
			$this->db->insert('doctor_detail',$insert_arr);
			echo json_encode(array("success"=>$this->db->insert_id()));
		}
		else
		{
			echo json_encode(array("error"=>"please select value"));
		}
	}

	function update_doctor_summary_byid_post()
	{
		$doctor_id 	= intval($this->post('id'));
		$summary 		= trim($this->post('summary'));
		
		if($doctor_id && $summary)
		{
			$this->db->update('doctor',array('summary'=>$summary),array('id'=>$doctor_id));
			echo json_encode(array("success"=>$this->db->affected_rows(),"query"=>$this->db->last_query()));
		}
		else
		{
			echo json_encode(array("error"=>"please provide summary and doctor_id"));
		}
	}
	function add_patient_family_details_post()
	{
		$array['patient_id']	=	$this->post('patient_id');
		$array['disease']			=	$this->post('disease');
		$array['member_name']	=	$this->post('member_name');
		$array['summary']			=	$this->post('summary');
		
		if($this->post('patient_id') && is_array($array) && sizeof($array)>0)
		{
			$this->db->insert('patient_family_detail',$array);		
		}
		echo json_encode(array("success"=>$this->db->insert_id()));
	}
	function remove_patient_family_details_post()
	{
		$id	=	$this->post('id');
		if($id)
		{
			$this->db->delete('patient_family_detail',array('id'=>$id));
			echo json_encode(array("success"=>$this->db->affected_rows()));
		}
		else
		{
			echo json_encode(array("success"=>0));
		}
	}
	function add_patient_past_disease_post()
	{
		$array['patient_id']				=	$this->post('patient_id');
		$array['disease_name']			=	$this->post('disease_name');
		$array['disease_from_month']=	$this->post('disease_from_month');
		$array['disease_from_year']	=	$this->post('disease_from_year');
		$array['disease_duration']	=	$this->post('disease_duration');
		$array['disease_details']		=	$this->post('disease_details');
		
		if($this->post('patient_id') && is_array($array) && sizeof($array)>0)
		{
			$this->db->insert('patient_past_disease',$array);		
		}
		echo json_encode(array("success"=>$this->db->insert_id()));
	}
	function remove_patient_past_disease_post()
	{
		$id	=	$this->post('id');
		if($id)
		{
			$this->db->delete('patient_past_disease',array('id'=>$id));
			echo json_encode(array("success"=>$this->db->affected_rows()));
		}
		else
		{
			echo json_encode(array("success"=>0));
		}
	}

	function add_patient_past_surgery_post()
	{
		$array['patient_id']		=	$this->post('patient_id');
		$array['surgery_name']	=	$this->post('surgery_name');
		$array['reason']				=	$this->post('reason');
		$array['surgery_date']	=	$this->post('surgery_date');
		
		if($this->post('patient_id') && is_array($array) && sizeof($array)>0)
		{
			$this->db->insert('patient_past_surgery',$array);		
		}
		echo json_encode(array("success"=>$this->db->insert_id()));
	}

	function remove_patient_past_surgery_post()
	{
		$id	=	$this->post('id');
		if($id)
		{
			$this->db->delete('patient_past_surgery',array('id'=>$id));
			echo json_encode(array("success"=>$this->db->affected_rows(),"query"=>$this->db->last_query()));
		}
		else
		{
			echo json_encode(array("success"=>0));
		}
	}

	function add_patient_allergic_post()
	{
		$array['patient_id']		=	$this->post('patient_id');
		$array['allery_type']	=	$this->post('allery_type');
		$array['allergic']				=	$this->post('allergic');
		
		if($this->post('patient_id') && is_array($array) && sizeof($array)>0)
		{
			$this->db->insert('patient_allergic',$array);		
		}
		echo json_encode(array("success"=>$this->db->insert_id()));
	}

	function remove_patient_allergic_post()
	{
		$id	=	$this->post('id');
		if($id)
		{
			$this->db->delete('patient_allergic',array('id'=>$id));
			echo json_encode(array("success"=>$this->db->affected_rows(),"query"=>$this->db->last_query()));
		}
		else
		{
			echo json_encode(array("success"=>0));
		}
	}
	function add_patient_medication_post()
	{
		$array['patient_id']	=	$this->post('patient_id');
		$array['medication']	=	$this->post('medication');
		
		if($this->post('patient_id') && is_array($array) && sizeof($array)>0)
		{
			$this->db->insert('patient_medication',$array);		
		}
		echo json_encode(array("success"=>$this->db->insert_id()));
	}

	function remove_patient_medication_post()
	{
		$id	=	$this->post('id');
		if($id)
		{
			$this->db->delete('patient_medication',array('id'=>$id));
			echo json_encode(array("success"=>$this->db->affected_rows(),"query"=>$this->db->last_query()));
		}
		else
		{
			echo json_encode(array("success"=>0));
		}
	}
	function add_patient_bmi_post()
	{
		$array['patient_id']		=	$this->post('patient_id');
		$array['bmi_value']			=	$this->post('bmi_value');
		$array['weight']				=	$this->post('weight');
		$array['height_inches']	=	$this->post('height_inches');
		$array['height_feet']		=	$this->post('height_feet');
		
		if($this->post('patient_id') && is_array($array) && sizeof($array)>0)
		{
			$this->db->insert('bmi',$array);		
		}
		echo json_encode(array("success"=>$this->db->insert_id()));
	}
	function remove_patient_bmi_post()
	{
		$id	=	$this->post('id');
		if($id)
		{
			$this->db->delete('bmi',array('id'=>$id));
			echo json_encode(array("success"=>$this->db->affected_rows(),"query"=>$this->db->last_query()));
		}
		else
		{
			echo json_encode(array("success"=>0));
		}
	}
	
	function update_patient_post()
	{
		$patient_id	=	$this->post('patient_id');
		
		if($this->post('blood_group'))
		{
			$array['blood_group']	=	$this->post('blood_group');
		}
		if($this->post('food_habits'))
		{
			$array['food_habits']	=	$this->post('food_habits');
		}
		if($this->post('alcohol'))
		{
			$array['alcohol']			=	$this->post('alcohol');
		}
		if($this->post('smoking'))
		{
			$array['smoking']			=	$this->post('smoking');
		}
		if($this->post('ciggi_per_day'))
		{
			$array['ciggi_per_day']	=	$this->post('ciggi_per_day');
		}
		if($this->post('tobacco_consumption'))
		{
			$array['tobacco_consumption']	=	$this->post('tobacco_consumption');
		}

		if($patient_id && is_array($array) && sizeof($array)>0)
		{
			$this->db->update('patient',$array,array('id'=>$patient_id));		
			echo json_encode(array("success"=>$this->db->affected_rows(),'query'=>$this->db->last_query()));
		}else
		{
			echo json_encode(array("success"=>0));
		}
	}
}

