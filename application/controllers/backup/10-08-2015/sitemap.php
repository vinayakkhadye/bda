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
	
	/* this is html sitemap function*/
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
		
		$rs	=	$this->db->query("SELECT s.id,s.name as 'speciality', s.url_name AS 'speciality_url_name',scp.city_id,c.name as 'city_name',l.name AS 'location_name',l.url_name AS 'location_url_name' FROM speciality_city_map scp INNER JOIN speciality s ON s.id=scp.speciality_id INNER JOIN city c ON c.id=scp.city_id INNER JOIN location l ON l.city_id=c.id WHERE l.city_id = $city_id and l.url_name is not null and l.status=1 and s.status in(1,2) and scp.status=1 ORDER BY scp.city_id,l.url_name");
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
	/* this is html sitemap function*/
	
	/* this is xml sitemap function*/
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
				$sql	=	"SELECT s.id,s.name as 'speciality', s.url_name AS 'speciality_url_name',scp.city_id,c.name as 'city_name',l.name AS 'location_name',l.url_name AS 'location_url_name' FROM speciality_city_map scp INNER JOIN speciality s ON s.id=scp.speciality_id INNER JOIN city c ON c.id=scp.city_id INNER JOIN location l ON l.city_id=c.id WHERE l.city_id =$city_id and l.url_name is not null and l.status=1 and s.status in(1,2) and scp.status=1 ORDER BY scp.city_id,s.url_name";
				#and s.id = $speciality_id 
				$rs	=	$this->db->query($sql);
				if($rs->num_rows>0)
				{
					$result	=	$rs->result_array();
					$main_url	=	 array();
					if(is_array($result) && sizeof($result)>0)
					{
						foreach($result as $key=>$val)
						{
							if($val['location_url_name'])
							{
								$url_data[]	=	array(
														'url'=>BASE_URL.url_string($val['city_name']).'/'.$val['speciality_url_name'].'/'.$val['location_url_name'],
														'priority'=>'0.8',
														'changefreq'=>'weekly',
														'lastmod'=>date("Y-m-d")
														);
								if(!isset($mail_url[$val['id']]))
								{
									$main_url[$val['id']]	= array(
														'url'=>BASE_URL.url_string($val['city_name']).'/'.$val['speciality_url_name'],
														'priority'=>'0.8',
														'changefreq'=>'weekly',
														'lastmod'=>date("Y-m-d")
														);
								}
							}
						}
						#print_r($main_url);exit;
					}
					$url_data	=	array_merge($main_url,$url_data);
				}
				$this->load->view('website_sitemap_xml',array("url_data"=>$url_data));
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
	
	function website_links()
	{
		$url_data[0]	=	array('url'=>BASE_URL."patient",'priority'=>'0.8','changefreq'=>'weekly','lastmod'=>date("Y-m-d"));
		$url_data[1]	=	array('url'=>BASE_URL."doctor-practice-management",'priority'=>'0.8','changefreq'=>'weekly','lastmod'=>date("Y-m-d"));		
		$url_data[2]	=	array('url'=>BASE_URL."about-us",'priority'=>'0.8','changefreq'=>'weekly','lastmod'=>date("Y-m-d"));
		$url_data[3]	=	array('url'=>BASE_URL."contact-us",'priority'=>'0.8','changefreq'=>'weekly','lastmod'=>date("Y-m-d"));
		$url_data[4]	=	array('url'=>BASE_URL."patient-faq",'priority'=>'0.8','changefreq'=>'weekly','lastmod'=>date("Y-m-d"));
		$url_data[5]	=	array('url'=>BASE_URL."doctor-faq",'priority'=>'0.8','changefreq'=>'weekly','lastmod'=>date("Y-m-d"));
		$url_data[6]	=	array('url'=>BASE_URL."privacy-policy",'priority'=>'0.8','changefreq'=>'weekly','lastmod'=>date("Y-m-d"));
		$url_data[7]	=	array('url'=>BASE_URL."terms-conditions",'priority'=>'0.8','changefreq'=>'weekly','lastmod'=>date("Y-m-d"));

		$this->load->view('website_sitemap_xml',array("url_data"=>$url_data));
	}
	
	function urls()
	{
		$url_data[0]	=	array('url'=>BASE_URL."sitemap/website.xml",'priority'=>'0.8','changefreq'=>'weekly','lastmod'=>date("Y-m-d"));
		
		$rs	=	$this->db->query("SELECT id as 'city_id',NAME as 'city_name' FROM city WHERE status in (1,2)");
		if($rs->num_rows>0)
		{
			$result	=	$rs->result_array();
			foreach($result as $key=>$val)
			{
				if($val['city_name'])
				{
					$url_data[]	=	array('url'=>BASE_URL."sitemap/".url_string($val['city_name']).".xml",'priority'=>'0.8','changefreq'=>'weekly','lastmod'=>date("Y-m-d"));
				}
			}
		}
		$this->load->view('website_sitemap_xml',array("url_data"=>$url_data));
	}
	/* this is xml sitemap function*/
}