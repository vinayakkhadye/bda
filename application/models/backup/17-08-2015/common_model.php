<?php
class common_model extends CI_Model {
	private $data = array();
	private $SQL ="";
		
	function getMetadata($a=array())
	{
		$meta_data['title'] =  "Book Doctor Appointment Online for Free | Find Doctors - Book Dr Appointment";
		$meta_data['description'] =  "Book Doctor Appointment allows Patients to search doctors and book appointments instantly and helps Doctors to manage practice in a Smart and easy way.";
		$meta_data['keywords'] =  "book doctor appointment, book doctor appointment for free, book dr appointment, book dr appointment for free, doctor appointment online, doctor appointment online  for free, doctor appointment online free, free doctor appointment online, find doctors, find doctors for free";
		return $meta_data;
	}
	function getHeader($a=array())
	{
		$data = array();
		$this->load->model(array('user_model'));
		#$this->session->set_userdata('id',1);
		if($this->session->userdata('id')) {
			$user = $this->user_model->getUser(array('id'=>$this->session->userdata('id'),'column'=>array('id','name','type','image','gender'),'limit'=>1));
			if($user){
				$data['userData'] = current($user);
				if(empty($data['userData']['image']))
				{
					$data['userData']['image']	=	 IMAGE_URL."default_404.jpg";
				}
			}else{
				$data['userData'] = false;
			}
		}
		return $data;
	}
	function getSitemap($a=array())
	{
		$data =array();
		return $data;
	}
	function getFooter($a=array())
	{
		$data['speciality'] = $this->common_model->getSpeciality(array('featured'=>ACTIVE,'limit'=>25,'column'=>array('id','name')));
		if(is_array($data['speciality']) && sizeof($data['speciality'])>0){
			$data['speciality'] = array_chunk($data['speciality'],4);
		}
		
		$data['strip']['BDA'] = array(
			array("text"=>"About Us","link"=>BASE_URL."about-us.html","title"=>"About Us"),
			array("text"=>"Contact Us","link"=>BASE_URL."contact-us.html","title"=>"Contact Us"),
			array("text"=>"Patient FAQ","link"=>BASE_URL."patient-faq.html","title"=>"Patient FAQ"),
			array("text"=>"Doctor FAQ","link"=>BASE_URL."doctor-faq.html","title"=>"Doctor FAQ"),
			array("text"=>"Privacy Policy","link"=>BASE_URL."privacy-policy.html","title"=>"Privacy Policy"),
			array("text"=>"Terms and Conditions","link"=>BASE_URL."terms-conditions.html","title"=>"Terms and Conditions"),
		);
		
		$data['strip']['Find Doctor By'] = array(
			array("text"=>"Speciality","link"=>"javascript:;","title"=>"Speciality"),
			array("text"=>"Doctor Name","link"=>"javascript:;","title"=>"Doctor Name"),
			array("text"=>"Clinic / Hospital Name","link"=>"javascript:;","title"=>"Clinic / Hospital Name"),
		);
		$data['strip']['Get in Touch'] = array(
			array("text"=>"022 - 25361097","link"=>"tel:022 - 25361097","title"=>"022 - 25361097"),
			array("text"=>"support@bookdrappointment.com","link"=>"mailto:support@bookdrappointment.com","title"=>"support@bookdrappointment.com"),
		);
		
		$data['strip']['Follow Us'] = array(
			array("image"=>IMAGE_URL."f_facebook.png","link"=>"https://www.facebook.com/bookdrappointment","title"=>"Facebook"),
			array("image"=>IMAGE_URL."f_google.png","link"=>"https://plus.google.com/+BookdrappointmentOnline","title"=>"Google"),
			array("image"=>IMAGE_URL."f_twitter.png","link"=>"https://twitter.com/BookDrAppointm","title"=>"Twitter"),
			array("image"=>IMAGE_URL."f_linkedin.png","link"=>"https://www.linkedin.com/company/book-dr-appointment-com","title"=>"Linked In"),
			array("image"=>IMAGE_URL."f_pinterest.png","link"=>"http://www.pinterest.com/BookDrAppoint/","title"=>"Pinterest"),
			array("image"=>IMAGE_URL."f_youtube.png","link"=>"https://www.youtube.com/channel/UCL7C1Er7FMfviHDoZ87E-PQ/feed","title"=>"Youtube"),
		);
		$data['copyright_year'] = date("Y");
		
		return  $data;
	}
	function setCurrentCity($a=array())
	{
		
		if(isset($a['cityName']) && !empty($a['cityName'])){
			if($a['cityName']==$this->input->cookie('bda_cityName')){
				return array($this->input->cookie('bda_cityName'),$this->input->cookie('bda_cityId')); 
			}else{
				$cityName = $a['cityName'];
				$cookie = array(
					'name'   => 'cityName',
					'value'  => $cityName,
					'expire' => '0',
					'domain' => '.bookdrappointment.com'
				);
				$this->input->set_cookie($cookie);
			}
		}else if(!$this->input->cookie('bda_cityName')){
			$cityName = "pune"; # get city from geoip
			$cookie = array(
				'name'   => 'cityName',
				'value'  => $cityName,
				'expire' => '0',
				'domain' => '.bookdrappointment.com'
			);
			$this->input->set_cookie($cookie);
		}else{
			$cityName = $this->input->cookie('bda_cityName'); 
		}
		
		$city = $this->common_model->getCity(array('limit'=>1,'column'=>array('id','name'),'name'=>reverse_url_string($cityName),'status'=>array(1,2)));
		if(is_array($city) && sizeof($city)>0){
			$cityId = $city[0]['id'];
		}

		$cookie = array(
			'name'   => 'cityId',
			'value'  => $cityId,
			'expire' => '0',
			'domain' => '.bookdrappointment.com'
		);
		$this->input->set_cookie($cookie);
		return array($cityName,$cityId);
	}
	function getAllData($a=array())
	{
		$this->data['city'] = $this->common_model->getCity(array('status'=>1,'column'=>array('id','name'),'replace_specialchars'=>TRUE,'orderby'=>'sort asc'));
		$this->data['other_city'] = $this->common_model->getCity(array('status'=>2,'column'=>array('id','name'),'replace_specialchars'=>TRUE));
		$this->data['metadata'] = $this->getMetadata();
		$this->data['header'] = $this->getHeader();
		$this->data['footer'] = $this->getFooter();
		$this->data['sitemap'] =$this-> getSitemap();
		return $this->data;
	}
	function getCity($a=array())
	{
		$res = false;
		$a = $this->filterData($a);
		$this->SQL = $where = "";
		$where .=" where 1";
		if(!empty($a['id'])  ){
			$where .=" AND id = ".$a['id'];
		}
		if(!empty($a['name'])  ){
			$where .=" AND name = '".$a['name']."'";
		}

		if(!empty($a['state_id'])  ){
			$where .=" AND state_id = ".$a['state_id'];
		}
		if(isset($a['status']))
		{
			if(is_array($a['status']) && sizeof($a['status'])>0)
			{
				$where .=" AND status in (".implode(",",$a['status']).")";#status	
			}
			else if(strlen($a['status'])>0)
			{
				$where .=" AND status = ".$a['status'];#status
			}
		}
		
		$this->SQL .= "select ".$a['column']." from city".$where.$this->groupby.$this->orderby.$this->limit;
		
		$query = $this->db->query($this->SQL);
		if($query->num_rows>0){
			foreach ($query->result_array() as $key=>$row){
				if(isset($a['replace_specialchars']))
				{
					$row['url_name']	=	url_string($row['name']);
				}
				$res[$key] =  $row;
			}
		}
		return $res;
	}
	function getSpeciality($a=array())
	{
		$res = false;
		$a = $this->filterData($a);
		$this->SQL = $where = "";
		$where .=" where 1";
		if(isset($a['id']) && !empty($a['id'])  ){
			$where .=" AND id = ".$a['id'];
		}
		if(isset($a['ids']) && !empty($a['ids'])  ){
			$where .=" AND id IN(".$a['ids'].")";
		}
		if(!empty($a['exact_name'])  ){
			$where .=" AND name = '".$a['exact_name']."'";
		}
		if(!empty($a['url_name'])  ){
			$where .=" AND url_name = '".$a['url_name']."'";
		}

		if(!empty($a['name'])  ){
			$where .=" AND name LIKE '%".$a['name']."%'";
		}

		if(isset($a['status']))
		{
			if(is_array($a['status']) && sizeof($a['status'])>0)
			{
				$where .=" AND status in (".implode(",",$a['status']).")";#status	
			}
			else if(strlen($a['status'])>0)
			{
				$where .=" AND status = ".$a['status'];#status
			}
		}
		
		if(isset($a['featured']) && strlen($a['featured'])>0){
			$where .=" AND is_featured = ".$a['featured'];
		}

		$this->SQL .= "select ".$a['column']." from speciality".$where.$this->groupby.$this->orderby.$this->limit;
		
		$query = $this->db->query($this->SQL);
		if($query->num_rows>0){
			foreach ($query->result_array() as $row){
				if(isset($row['name'])){
					$row['name'] = ucwords($row['name']);
				}
				if(isset($a['id_as_key']))
				{
					$res[$row['id']] =  $row;
				}
				else
				{
					$res[] =  $row;
				}
				
			}
		}
		return $res;
	}
	function getSpecialization($a=array())
	{
		$res = false;
		$a = $this->filterData($a);
		$this->SQL = $where = "";
		$where .=" where 1";
		if(isset($a['id']) && !empty($a['id'])  ){
			$where .=" AND id = ".$a['id'];
		}
		if(isset($a['ids']) && !empty($a['ids'])  ){
			$where .=" AND id IN(".$a['ids'].")";
		}
		if(!empty($a['exact_name'])  ){
			$where .=" AND name = '".$a['exact_name']."'";
		}

		if(!empty($a['name'])  ){
			$where .=" AND name LIKE '%".$a['name']."%'";
		}
		if(isset($a['status']) && strlen($a['status'])>0){
			$where .=" AND status = ".$a['status'];
		}
		if(isset($a['featured']) && strlen($a['featured'])>0){
			$where .=" AND is_featured = ".$a['featured'];
		}

		$this->SQL .= "select ".$a['column']." from specialization".$where.$this->groupby.$this->orderby.$this->limit;
		
		$query = $this->db->query($this->SQL);
		if($query->num_rows>0){
			foreach ($query->result_array() as $row){
				$res[] =  $row;
			}
		}
		return $res;
	}
	function getSpecialityByCity($a=array())
	{
		$res = false;$whereArray = array();
		$this->db->from('speciality as `sp`');
		$this->db->join('speciality_city_map  as `scp`', 'sp.id=scp.`speciality_id`');
		$this->filterData_active($a);
		if(!empty($a['name']) ){
			$this->db->like("sp.name",$a['name'],'both');
		}
		
		if(!empty($a['city_id'])  ){
			if(is_array($a['city_id']) && sizeof($a['city_id'])>0)
			{
			  $this->db->where_in('scp.city_id', $a['city_id']);
			}
			else
			{
				$whereArray['scp.city_id'] = $a['city_id'];
			}
			
		}
		$whereArray['scp.status'] = 1;
		if(!empty($a['status']))
		{
			if(is_array($a['status']))
			{
				$this->db->where_in('sp.status',$a['status']);
			}
			else
			{
				$whereArray['sp.status'] = $a['status'];			
			}
		}
				
		$this->db->where($whereArray);

		$query = $this->db->get();
		if($query->num_rows>0){
			foreach ($query->result_array() as $row){
				$res[] =  $row;
			}
		}
		
		return $res;
	}
	function getQualification($a=array())
	{
		$res = false;
		$a = $this->filterData($a);
		$this->SQL = $where = "";
		$where .=" where 1";
		if(isset($a['id']) && !empty($a['id'])  ){
			$where .=" AND id = ".$a['id'];
		}
		if(isset($a['ids']) && !empty($a['ids'])  ){
			$where .=" AND id IN(".trim($a['ids'],',').")";
		}

		if(!empty($a['exact_name'])  ){
			$where .=" AND name = '".$a['exact_name']."'";
		}

		if(!empty($a['name'])  ){
			$where .=" AND name LIKE '%".$a['name']."%'";
		}
		if(isset($a['status']) && strlen($a['status'])>0){
			$where .=" AND status = ".$a['status'];
		}
		if(isset($a['featured']) && strlen($a['featured'])>0){
			$where .=" AND is_featured = ".$a['featured'];
		}

		$this->SQL .= "select ".$a['column']." from qualification".$where.$this->groupby.$this->orderby.$this->limit;
		
		$query = $this->db->query($this->SQL);
		if($query->num_rows>0){
			foreach ($query->result_array() as $row){
				if(isset($a['id_as_key']))
				{
					$res[$row['id']] =  $row;
				}
				else
				{
					$res[] =  $row;
				}
			}
		}
		return $res;
	}
	function getCouncils($a=array())
	{
		$res = false;$whereArray = array();
		$this->db->from('council');
		$this->filterData_active($a);

		$whereArray['status'] = '1';
		if(isset($a['id'])  ){
			$whereArray['id'] = $a['id'];
		}
		$this->db->where($whereArray);

		$query = $this->db->get();
		$this->row_count = $query->num_rows;	
		if($query->num_rows>0){
			foreach ($query->result_array() as $row){
				$res[] =  $row;
			}
		}
		
		return $res;
	}
	function getLocation($a=array())
	{
		$res = false;
		$a = $this->filterData($a);
		$this->SQL = $where = "";
		$where .=" where 1";
		if(!empty($a['id'])  ){
			$where .=" AND lc.id = ".$a['id'];
		}
		if(!empty($a['name'])  ){
			$where .=" AND lc.name = '".$a['name']."'";
		}
		if(!empty($a['url_name'])  ){
			$where .=" AND lc.url_name = '".$a['url_name']."'";
		}

		if(isset($a['city_id']) && !empty($a['city_id'])){
			$where .=" AND lc.city_id = ".$a['city_id'];
		}
		if(isset($a['status']) && strlen($a['status'])>0){
			$where .=" AND lc.status = ".$a['status'];
		}
		if(isset($a['join']) && is_array($a['join'])){
			if(in_array('city',$a['join'])){
				$this->join = " JOIN city as `ci` ON  lc.city_id = ci.id";	
			}
		}

		$this->SQL .= "select ".$a['column']." from location lc ".$this->join.$where.$this->groupby.$this->orderby.$this->limit;

		
		$query = $this->db->query($this->SQL);
		if($query->num_rows>0){
			foreach ($query->result_array() as $row){
				$res[$row['id']] =  $row;
			}
		}
		return $res;
	
	}
	function getState($a=array())
	{
		$res = false;$whereArray = array();
		$this->db->from('states as `st`');
		$this->filterData_active($a);

		if(!empty($a['id'])  ){
			$whereArray['st.id'] = $a['id'];
		}
		if(!empty($a['city_id'])  ){
			$whereArray['st.city_id'] = $a['city_id'];
		}
		
		$this->db->where($whereArray);

		$query = $this->db->get();
		if($query->num_rows>0){
			foreach ($query->result_array() as $row){
				$res[] =  $row;
			}
		}
		
		return $res;
	}
	function getRating($a=array())
	{
		$res = false;$whereArray = array();
		$this->db->from('ratings');
		$this->filterData_active($a);
		$a['rate_to'] = 1123; # hack for getting value remove it later
		if(!empty($a['rate_to'])){
			$whereArray['rate_to'] = $a['rate_to'];
		}
		$whereArray['reviews !='] = '';
		$this->db->where($whereArray);

		$query = $this->db->get();
		$this->row_count = $query->num_rows;	
		if($query->num_rows>0){
			foreach ($query->result_array() as $row){
				$res[] =  $row;
			}
		}
		
		return $res;
	}

	function insertSpecialityCityMap($a=array())
	{
		$insert_query = $this->db->insert_string('speciality_city_map',$a);
		$insert_query = str_replace('INSERT INTO','INSERT IGNORE INTO',$insert_query);
		$rs = $this->db->query($insert_query);  	
		
		if($rs){
			return $this->db->insert_id();
		}else{
			return false;
		}
	}
	function insertSpecializationCityMap($a=array())
	{
		$insert_query = $this->db->insert_string('specialization_city_map',$a);
		$insert_query = str_replace('INSERT INTO','INSERT IGNORE INTO',$insert_query);
		$rs = $this->db->query($insert_query);  	
		
		if($rs){
			return $this->db->insert_id();
		}else{
			return false;
		}
	}
	function insertSpeciality($a=array())
	{
		$insert_query = $this->db->insert_string('speciality',$a);
		$insert_query = str_replace('INSERT INTO','INSERT IGNORE INTO',$insert_query);
		$rs = $this->db->query($insert_query);  	
		
		if($rs){
			return $this->db->insert_id();
		}else{
			return false;
		}
	}
	function insertSpecialization($a=array())
	{
		$insert_query = $this->db->insert_string('specialization',$a);
		$insert_query = str_replace('INSERT INTO','INSERT IGNORE INTO',$insert_query);
		$rs = $this->db->query($insert_query);  	
		
		if($rs){
			return $this->db->insert_id();
		}else{
			return false;
		}
	}

	
	function insertQualification($a=array())
	{
		$insert_query = $this->db->insert_string('qualification',$a);
		$insert_query = str_replace('INSERT INTO','INSERT IGNORE INTO',$insert_query);
		$rs = $this->db->query($insert_query);  	
		
		if($rs){
			return $this->db->insert_id();
		}else{
			return false;
		}
	}

	function insertSpecialityBatch($a=array())
	{
		$rs = $this->db->insert_batch('reviews', $a); 
		if($rs){
			return $this->db->insert_id();
		}else{
			return false;
		}
	
	}
	
	function get_blood_group()
	{
		$this->db->select('name,id');
		$this->db->order_by('name','asc');
		$query = $this->db->get('blood_group');
		return $query->result();
	}
	function specialiy_inforamtion($speciality_id,$statement_type)
	{
		$this->db->select('description');
		$this->db->order_by('rand()');
		$this->db->where('statement_type', $statement_type);
		$this->db->where('speiciality_id', $speciality_id);
		$this->db->limit(1);
		$query = $this->db->get('speciality_information');
		return $query->row_array();
	
	}
	function __toString()
	{
		#return (string)$this->SQL;
		return (string)end($this->db->queries);
	}
	
	
}
?>