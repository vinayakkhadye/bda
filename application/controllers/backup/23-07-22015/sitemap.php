<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sitemap extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model(array('common_model'));
	}
	function index()
	{
		header('HTTP/1.0 403 Forbidden');
		echo '403 Forbidden!';
	}
	function city()
	{
		$data = $this->common_model->getAllData(); 

		$rs	=	$this->db->query("SELECT id as 'city_id',NAME as 'city_name' FROM city WHERE status in (1,2)");
		if($rs->num_rows>0)
		{
			$result	=	$rs->result_array();
			foreach($result as $key=>$val)
			{
				if($val['city_name'])
				{
					$url_data[$val['city_name']]	=	array(
															'url'=>BASE_URL.url_string("sitemap/speciality/".$val['city_name']."/".$val['city_id']),
																		'label'=>$val['city_name']
																	);
				}
			}
		}
		$data['url_data']	=	$url_data;
		// print_r($data['url_data']);
		$this->load->view('city_sitemap',$data);

	}
	function speciality($city_name,$city_id)
	{
		$data = $this->common_model->getAllData();
		
		$rs	=	$this->db->query("SELECT s.id,s.name as 'speciality', s.url_name AS 'speciality_url_name',scp.city_id,c.name as 'city_name',l.name AS 'location_name',l.url_name AS 'location_url_name' FROM speciality_city_map scp INNER JOIN speciality s ON s.id=scp.speciality_id INNER JOIN city c ON c.id=scp.city_id INNER JOIN location l ON l.city_id=c.id WHERE l.city_id = $city_id ORDER BY scp.city_id,l.url_name");
		if($rs->num_rows>0)
		{
			$result	=	$rs->result_array();
			foreach($result as $key=>$val)
			{
				if($val['location_url_name'])
				{
					$url_data[$val['city_name']][$val['location_url_name']][]	=	array(
																		'url'=>BASE_URL.url_string($val['city_name']).'/'.$val['speciality_url_name'].'/'.$val['location_url_name'],
																		'label'=>$val['speciality'].' in '.$val['location_name'].", ".$val['city_name']
																	);
				}
			}
		}
		$data['url_data']	=	$url_data;
		// print_r($data['url_data']);
		$this->load->view('speciality_sitemap',$data);
	}
	/*function sitemap_xml_url($city_name)
	{
		$url_data	=	 array();
		$this->load->model(array('common_model'));
		$city 			= $this->common_model->getCity(array('limit'=>1,'column'=>array('id','name'),'name'=>reverse_url_string($city_name)));
		if(is_array($city) && sizeof($city)>0)
		{
			$city_id	=	 $city[0]['id'];
			$sql	=	"SELECT s.id,s.name as 'speciality', s.url_name AS 'speciality_url_name',scp.city_id FROM speciality_city_map scp INNER JOIN speciality s ON s.id=scp.speciality_id WHERE scp.city_id =$city_id ORDER BY scp.city_id,s.name limit 10";
			$rs	=	$this->db->query($sql);
			if($rs->num_rows>0)
			{
				$result	=	$rs->result_array();
				
				foreach($result as $key=>$val)
				{

						$url_data[]	=	array(
												'url'=>BASE_URL."sitemap/sitemap_xml/".url_string($city_name).'/'.$val['speciality_url_name'],
												'label'=>$val['speciality'].' in '.$city_name
												);
					
				}
				#print_r($url_data);exit;
			}
		}
		$this->load->view('speciality_sitemap_xml',array("url_data"=>$url_data));
	}*/
	function sitemap_xml($city_name)
	{
		if($city_name)
		{
			$url_data	=	 array();
			$this->load->model(array('common_model'));
			$city 			= $this->common_model->getCity(array('limit'=>1,'column'=>array('id','name'),'name'=>reverse_url_string($city_name)));
			#$speciality = $this->common_model->getSpeciality(array('limit'=>1,'column'=>array('id','name'),'url_name'=>$speciality_name));
			$url_data	=	 array();
			if(is_array($city) && sizeof($city)>0)
			{
				$city_id	=	 $city[0]['id'];
				#$speciality_id	=	 $speciality[0]['id'];
				$sql	=	"SELECT s.id,s.name as 'speciality', s.url_name AS 'speciality_url_name',scp.city_id,c.name as 'city_name',l.name AS 'location_name',l.url_name AS 'location_url_name' FROM speciality_city_map scp INNER JOIN speciality s ON s.id=scp.speciality_id INNER JOIN city c ON c.id=scp.city_id INNER JOIN location l ON l.city_id=c.id WHERE l.city_id =$city_id and l.url_name is not null and l.status=1 ORDER BY scp.city_id,l.url_name";
				#and s.id = $speciality_id 
				$rs	=	$this->db->query($sql);
				if($rs->num_rows>0)
				{
					$result	=	$rs->result_array();
					
					foreach($result as $key=>$val)
					{
						if($val['location_url_name'])
						{
							$url_data[]	=	array(
													'url'=>BASE_URL.url_string($val['city_name']).'/'.$val['speciality_url_name'].'/'.$val['location_url_name'],
													'label'=>$val['speciality'].' in '.$val['location_name'].", ".$val['city_name']
													);
						}
					}
				}
				$this->load->view('speciality_sitemap_xml',array("url_data"=>$url_data));
			}
			else
			{
				header('HTTP/1.0 403 Forbidden');
				echo '403 Forbidden!';
			}
		}
		else
		{
			header('HTTP/1.0 403 Forbidden');
			echo '403 Forbidden!';
		}
	}
}