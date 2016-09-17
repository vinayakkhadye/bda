<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');
set_time_limit(1000);
class export extends CI_Controller{
	private $data = array();
	private $log_file = ""; 
	private $current_tab = '';

	public function __construct()
	{
	
		parent::__construct();
		$this->data['class_name'] = $this->router->fetch_class();
		$this->load->model(array('common_model','doctor_model','location_model','clinic_model','reviews_model'));
		$adminid = $this->session->userdata('admin_id');
		$admin_user_type = $this->session->userdata('admin_user_type');

		if(empty($adminid) || empty($admin_user_type) || !in_array($admin_user_type,array('1','2'))){
			redirect('/bdabdabda/login');
			exit();
		}
		
	}
	public function log_message($myfile,$query)
	{
		fwrite($myfile, $query);
		return false;
	}

	public function doctor_wise_data()
	{
		$this->load->model(array('clinic_model'));
		$csv_column_array	=	array('doctor_id','clinic_id','Dr Photograph','Gender','Dr Name','Degree','Speciality','Brief about Dr','Years of Experience','Doctor Mobile Number','is_doctor_verified_registered','clinic_name','clinic_number','clinic_is_number_verified','clinic_latitude','clinic_longitude','clinic_timings','clinic_consultation_fees','clinic_address','clinic_location','clinic_pincode');#18
		
		$sql	=	"SELECT 
  d.id AS 'doctor_id',
  c.id AS 'clinic_id',
  d.image AS 'Dr Photograph',
  d.gender AS 'Gender',
  d.name AS 'Dr Name',
  d.`qualification` AS 'Degree',
  d.speciality AS 'Speciality',
  d.summary AS 'Brief about Dr',
  d.yoe AS 'Years of experience',
  d.contact_number AS 'Doctor Mobile Number',
  d.is_ver_reg AS 'is_doctor_verified_registered',
  c.name AS 'clinic_name',
  c.contact_number AS 'clinic_number',
  c.is_number_verified AS 'clinic_is_number_verified',
  c.latitude AS 'clinic_latitude',
  c.longitude AS 'clinic_longitude',
  c.timings AS 'clinic_timings',
  c.consultation_fees AS 'clinic_consultation_fees',
  c.address AS 'clinic_address',
  c.location_id AS 'clinic_location',
  c.pincode AS 'clinic_pincode' 
FROM
   doctor d 
  JOIN clinic c ON c.`doctor_id` = d.id 
WHERE c.city_id = 7 and d.status	=	1 and c.status	=	1 order by d.id asc,c.id asc";
		$rs	=	$this->db->query($sql);

		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename=data.csv');
		$output = fopen('php://output', 'w');
		fputcsv($output, $csv_column_array);
		$data = $rs->result_array();
		
		$sql	=	"select id,name from speciality";
		$speciality_rs	=	$this->db->query($sql);
		$spec_result		= $speciality_rs->result_array();
		foreach($spec_result as $spec_row)
		{
			$specialty_data[$spec_row['id']]	=	$spec_row['name'];
		}
		unset($spec_result);

		$sql	=	"select id,name from qualification";
		$qualification_rs	=	$this->db->query($sql);
		$qua_result		= $qualification_rs->result_array();
		foreach($qua_result as $qua_row)
		{
			$qualification_data[$qua_row['id']]	=	$qua_row['name'];
		}
		unset($qua_result);

		$sql	=	"select id,name from location";
		$location_rs	=	$this->db->query($sql);
		$loc_result		= $location_rs->result_array();
		foreach($loc_result as $loc_row)
		{
			$location_data[$loc_row['id']]	=	$loc_row['name'];
		}
		unset($loc_result);
		
		foreach($data as $row)
		{
			$spec	=	explode(",",$row['Speciality']);
			$row['Speciality']	=	'';
			foreach($spec as $val)
			{
				$row['Speciality']	.=	$specialty_data[$val].",";
			}
			$row['Speciality']	=	 rtrim($row['Speciality'],', ');

			$deg	=	explode(",",$row['Degree']);
			$row['Degree']	='';
			foreach($deg as $val)
			{
				$row['Degree']	.=	$qualification_data[$val].",";
			}
			$row['Degree']	=	 rtrim($row['Degree'],', ');
			$row['clinic_location']	=	$location_data[$row['clinic_location']];
			$row['clinic_timings']	=	$this->clinic_model->get_clinic_formatted_time($row['clinic_timings']);
			
			$tmp_time	='';
			foreach($row['clinic_timings'] as $time_key=>$time_val)
			{
				$tmp_time	.=	$time_val['label']."=>".$time_val['value']." ## ";
			}
			$tmp_time	=	 rtrim($tmp_time,'## ');
			$row['clinic_timings']	=	$tmp_time;
			fputcsv($output, $row);
		}
		
	}

	public function doctor_user_wise_data()
	{
		$this->load->model(array('clinic_model'));
		$csv_column_array	=	array('doctor_id','clinic_id','Dr Photograph','Gender','Dr Name','Degree','Speciality','Brief about Dr','Years of Experience','Doctor Mobile Number','is_doctor_verified_registered','clinic_name','clinic_number','clinic_is_number_verified','clinic_latitude','clinic_longitude','clinic_timings','clinic_consultation_fees','clinic_address','clinic_location','clinic_pincode');#18
		
		$sql	=	"SELECT 
  d.id AS 'doctor_id',
  c.id AS 'clinic_id',
  d.image AS 'Dr Photograph',
  d.gender AS 'Gender',
  d.name AS 'Dr Name',
  d.`qualification` AS 'Degree',
  d.speciality AS 'Speciality',
  d.summary AS 'Brief about Dr',
  d.yoe AS 'Years of experience',
  d.contact_number AS 'Doctor Mobile Number',
  d.is_ver_reg AS 'is_doctor_verified_registered',
  c.name AS 'clinic_name',
  c.contact_number AS 'clinic_number',
  c.is_number_verified AS 'clinic_is_number_verified',
  c.latitude AS 'clinic_latitude',
  c.longitude AS 'clinic_longitude',
  c.timings AS 'clinic_timings',
  c.consultation_fees AS 'clinic_consultation_fees',
  c.address AS 'clinic_address',
  c.location_id AS 'clinic_location',
  c.pincode AS 'clinic_pincode' 
FROM
  `user` u 
  JOIN doctor d ON u.id = d.user_id 
  JOIN clinic c ON c.`doctor_id` = d.id 
WHERE c.city_id = 7 
  AND u.created_on > '2015-05-01 00:00:00' order by u.created_on asc"	;
		$rs	=	$this->db->query($sql);

		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename=data.csv');
		$output = fopen('php://output', 'w');
		fputcsv($output, $csv_column_array);
		$data = $rs->result_array();
		
		$sql	=	"select id,name from speciality";
		$speciality_rs	=	$this->db->query($sql);
		$spec_result		= $speciality_rs->result_array();
		foreach($spec_result as $spec_row)
		{
			$specialty_data[$spec_row['id']]	=	$spec_row['name'];
		}
		unset($spec_result);

		$sql	=	"select id,name from qualification";
		$qualification_rs	=	$this->db->query($sql);
		$qua_result		= $qualification_rs->result_array();
		foreach($qua_result as $qua_row)
		{
			$qualification_data[$qua_row['id']]	=	$qua_row['name'];
		}
		unset($qua_result);

		$sql	=	"select id,name from location";
		$location_rs	=	$this->db->query($sql);
		$loc_result		= $location_rs->result_array();
		foreach($loc_result as $loc_row)
		{
			$location_data[$loc_row['id']]	=	$loc_row['name'];
		}
		unset($loc_result);
		
		foreach($data as $row)
		{
			$spec	=	explode(",",$row['Speciality']);
			$row['Speciality']	=	'';
			foreach($spec as $val)
			{
				$row['Speciality']	.=	$specialty_data[$val].",";
			}
			$row['Speciality']	=	 rtrim($row['Speciality'],', ');

			$deg	=	explode(",",$row['Degree']);
			$row['Degree']	='';
			foreach($deg as $val)
			{
				$row['Degree']	.=	$qualification_data[$val].",";
			}
			$row['Degree']	=	 rtrim($row['Degree'],', ');
			$row['clinic_location']	=	$location_data[$row['clinic_location']];
			$row['clinic_timings']	=	$this->clinic_model->get_clinic_formatted_time($row['clinic_timings']);
			
			$tmp_time	='';
			foreach($row['clinic_timings'] as $time_key=>$time_val)
			{
				$tmp_time	.=	$time_val['label']."=>".$time_val['value']." ## ";
			}
			$tmp_time	=	 rtrim($tmp_time,'## ');
			$row['clinic_timings']	=	$tmp_time;
			fputcsv($output, $row);
		}
		
	}
	
	public function doctor_speciality_wise_data()
	{

		$this->load->model(array('clinic_model'));
		$csv_column_array	=	array('doctor_id','clinic_id','Dr Photograph','Gender','Dr Name','Degree','Speciality','Brief about Dr','Years of Experience','Doctor Mobile Number','is_doctor_verified_registered','clinic_name','clinic_number','clinic_is_number_verified','clinic_latitude','clinic_longitude','clinic_timings','clinic_consultation_fees','clinic_address','clinic_location','clinic_pincode');#18
		$blank_column_array	=	array('','','','','','','','','','','','','','','','','','','','','');#18
		
		$sql	=	"SELECT 
		d.id AS 'doctor_id',
		c.id AS 'clinic_id',
		d.image AS 'Dr Photograph',
		d.gender AS 'Gender',
		d.name AS 'Dr Name',
		d.`qualification` AS 'Degree',
		d.speciality AS 'Speciality',
		d.summary AS 'Brief about Dr',
		d.yoe AS 'Years of experience',
		d.contact_number AS 'Doctor Mobile Number',
		d.is_ver_reg AS 'is_doctor_verified_registered',
		c.name AS 'clinic_name',
		c.contact_number AS 'clinic_number',
		c.is_number_verified AS 'clinic_is_number_verified',
		c.latitude AS 'clinic_latitude',
		c.longitude AS 'clinic_longitude',
		c.timings AS 'clinic_timings',
		c.consultation_fees AS 'clinic_consultation_fees',
		c.address AS 'clinic_address',
		c.location_id AS 'clinic_location',
		c.pincode AS 'clinic_pincode' 
		FROM
		doctor d 
		JOIN clinic c ON c.`doctor_id` = d.id
		WHERE c.city_id = 1
		AND d.status = '1' 
		AND c.status = '1' 
		order by d.created_on desc";# limit 100
		#echo $sql;exit;
		$rs	=	$this->db->query($sql);
		
		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename=data.csv');
		$output = fopen('php://output', 'w');
		#fputcsv($output, $csv_column_array);
		$data = $rs->result_array();
		
		$sql	=	"select id,name from speciality where status in (1,2)";
		$speciality_rs	=	$this->db->query($sql);
		$spec_result		= $speciality_rs->result_array();
		foreach($spec_result as $spec_row)
		{
			$specialty_data[$spec_row['id']]	=	$spec_row['name'];
			$speciality_wise_data[$spec_row['id']]	=	array();

		}
		unset($spec_result,$speciality_rs);
		
		$sql	=	"select id,name from qualification where status=1";
		$qualification_rs	=	$this->db->query($sql);
		$qua_result		= $qualification_rs->result_array();
		foreach($qua_result as $qua_row)
		{
			$qualification_data[$qua_row['id']]	=	$qua_row['name'];
		}
		unset($qua_result,$qualification_rs);
		
		$sql	=	"select id,name from location where status=1";
		$location_rs	=	$this->db->query($sql);
		$loc_result		= $location_rs->result_array();
		foreach($loc_result as $loc_row)
		{
			$location_data[$loc_row['id']]	=	$loc_row['name'];
		}
		unset($loc_result,$location_rs);
		
		foreach($data as $row)
		{
			$spec	=	explode(",",$row['Speciality']);
			#print_r($spec);
			$row['Speciality']	=	'';
			foreach($spec as $val)
			{
				$row['Speciality']	.=	$specialty_data[$val].",";
			}
			$row['Speciality']	=	 rtrim($row['Speciality'],', ');
			reset($spec);
			$first_speciality	=	current($spec);
			
			$deg	=	explode(",",$row['Degree']);
			$row['Degree']	='';
			foreach($deg as $val)
			{
				$row['Degree']	.=	$qualification_data[$val].",";
			}
			$row['Degree']	=	 rtrim($row['Degree'],', ');
			$row['clinic_location']	=	$location_data[$row['clinic_location']];
			$row['clinic_timings']	=	$this->clinic_model->get_clinic_formatted_time($row['clinic_timings']);
			
			$tmp_time	='';
			foreach($row['clinic_timings'] as $time_key=>$time_val)
			{
				$tmp_time	.=	$time_val['label']."=>".$time_val['value']." ## ";
			}
			$tmp_time	=	 rtrim($tmp_time,'## ');
			$row['clinic_timings']	=	$tmp_time;
			#print_r($speciality_wise_data);
			#print_r($row);
			#echo $first_speciality;
			#exit;
			if(isset($speciality_wise_data[$first_speciality]))
			{
				$speciality_wise_data[$first_speciality][]	=	$row;
			}
			#fputcsv($output, $row);
		}
		unset($data,$row);
		
		foreach($speciality_wise_data as $key=>$value)
		{
			if(is_array($value) && sizeof($value)>0)
			{
				fputcsv($output, $blank_column_array);
				$blank_column_array[0]	=	$specialty_data[$key];
				fputcsv($output, $blank_column_array);
				fputcsv($output, $csv_column_array);
				foreach($value as $row)
				{
					fputcsv($output, $row);
				}
				$blank_column_array[0]	=	'';
			}
		
		}
		unset($speciality_wise_data);
					
	}

	public function doctor_appointment_wise_data()
	{
		$csv_column_array	=	array('appointment_date','patient_name','patient_mobile_number','doctor_name','Speciality','Degree','clinic_name',
		'clinic_address','clinic_contact_number','clinic_location');#10
		$blank_column_array	=	array('','','','','','','','','','');#9
		$sql	=	"SELECT apt.scheduled_time as 'appointment_date',apt.`patient_name`,apt.`mobile_number` as 'patient_mobile_number',d.`name` AS doctor_name,d.speciality AS 'Speciality',d.qualification AS 'Degree',c.`name` AS clinic_name,c.`address` AS clinic_address,c.contact_number as 'clinic_contact_number',c.`location_id` AS 'location_name' 
						FROM appointment apt 
						JOIN doctor d ON apt.`doctor_id`=d.`id` 
						JOIN clinic c ON apt.`clinic_id`=c.`id` 
						WHERE apt.city_id=7 and apt.confirmation	=	1 and apt.status	=	1 order by added_on desc";# limit 100
		$rs	=	$this->db->query($sql);
		
		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename=data.csv');
		$output = fopen('php://output', 'w');
		fputcsv($output, $csv_column_array);
		$data = $rs->result_array();

		$sql	=	"select id,name from location where status =1 and city_id=7";
		$location_rs	=	$this->db->query($sql);
		$loc_result		= $location_rs->result_array();
		foreach($loc_result as $loc_row)
		{
			$location_result[$loc_row['id']]	=	$loc_row['name'];
		}
		
		$sql	=	"select id,name from speciality where status in (1,2)";
		$speciality_rs	=	$this->db->query($sql);
		$spec_result		= $speciality_rs->result_array();
		foreach($spec_result as $spec_row)
		{
			$specialty_data[$spec_row['id']]	=	$spec_row['name'];
			$speciality_wise_data[$spec_row['id']]	=	array();
		}
		unset($spec_result,$speciality_rs);

		$sql	=	"select id,name from qualification";
		$qualification_rs	=	$this->db->query($sql);
		$qua_result		= $qualification_rs->result_array();
		foreach($qua_result as $qua_row)
		{
			$qualification_data[$qua_row['id']]	=	$qua_row['name'];
		}
		unset($qua_result);
		
		foreach($data as $row)
		{
			$spec	=	explode(",",$row['Speciality']);
			$row['Speciality']	=	'';
			foreach($spec as $val)
			{
				$row['Speciality']	.=	$specialty_data[$val].",";
			}
			$row['Speciality']	=	 rtrim($row['Speciality'],', ');

			$deg	=	explode(",",$row['Degree']);
			$row['Degree']	='';
			foreach($deg as $val)
			{
				$row['Degree']	.=	$qualification_data[$val].",";
			}
			$row['Degree']	=	 rtrim($row['Degree'],', ');
			$row['location_name']	= $location_result[$row['location_name']];
			fputcsv($output, $row);
		}
	}
	
	public function download_file()
	{
		$file_name =	DOCUMENT_ROOT.$_GET['file_name'];
		if(file_exists($file_name))
		{
			$path_parts = pathinfo($file_name);

			// headers to send your file
			header('Content-Type: text/csv; charset=utf-8');
			header("Content-Length: " . filesize($file_name));
			header('Content-Disposition: attachment; filename="' . $path_parts['basename']. '"');

			// upload the file to the user and quit
			readfile($file_name);
			exit;		
		}
		else
		{
			header('Content-Type: plain/text; charset=utf-8');
			header('Content-Disposition: attachment; filename=not_exists.txt');
			echo "file ".$_GET['file_name']." does not exists ";
			exit;		
		}
	}

}