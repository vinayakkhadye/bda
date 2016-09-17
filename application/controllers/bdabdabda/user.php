<?php
if(! defined('BASEPATH')) exit('no diect script access allowed');

class User extends CI_Controller{

	private $current_tab="user";
	private $perm	=	'';

	function __construct()
	{
		parent::__construct();
		$this->load->library("pagination");
		$this->load->model(array('admin/adminalluser_model'));

		$this->perms		=	$this->session->userdata('allowed_perms'); 
		$admin_home_url	=	$this->session->userdata('admin_home_url');
		if($this->perms[ADMIN_SITE_USER]['view'] ==0)
		{
			redirect(($admin_home_url)?$admin_home_url:'/bdabdabda');
			exit();
		}
	}

	function index() 
	{

		$this->data['current_tab'] = "user";

		$this->data = array();
		// $config['base_url'] = BASE_URL.'bdabdabda/user/?';
		// $config['per_page'] = 30;

		// if(count($_GET) > 1)
		// {
		// 	$config['base_url'] = $config['base_url'] . http_build_query($_GET, '', '&');
		// }

		// $page = !empty($_GET['start']) ? $_GET['start'] : 0;



		 
		$this->search();
		
		// $this->data['user'] = $this->adminalluser_model->user_view($config['per_page'],$page); 
		$this->data['perms']	=	$this->perms;

		$this->load->view('admin/user_view',$this->data);

	}

	function search()
	{ 		

		$this->data['current_tab'] = $this->current_tab;

		$config['base_url'] = BASE_URL.'bdabdabda/user?';
		$config['per_page'] = 50;
		if(count($_GET) > 1)
		{
			$config['base_url'] = $config['base_url'] . http_build_query($_GET, '', '&');
		}
		$page = !empty($_GET['start']) ? $_GET['start'] : 0;
		

		$scharr= array('limit'  =>$config['per_page'],'offset' =>$page );

		
		if($this->input->get('id'))
		{
			$scharr['id'] = $this->input->get('id');
		}
		if($this->input->get('name'))
		{
			$scharr['name'] = $this->input->get('name');
		}
		if($this->input->get('contact'))
		{
			$scharr['contact'] = $this->input->get('contact');
		}		
		if($this->input->get('user_email'))
		{
			$scharr['user_email'] = $this->input->get('user_email'); 
		}		

		if($this->input->get('gender'))
		{
			$scharr['gender'] = $this->input->get('gender');
		}
		if($this->input->get('verified'))
		{
			$scharr['verified'] = $this->input->get('verified');
		} 
		if($this->input->get('type'))
		{
			$scharr['type'] = $this->input->get('type');
		}
		
		// print_r($scharr);
		$this->data['user'] = $this->adminalluser_model->user_view($scharr);
		// $this->data['user'] = $this->adminalluser_model->user_view($config['per_page'],$page); 
		
		// $this->data['city_list'] = $this->adminmasters_model->get_city_list(0,0,array('column'=>array('id','name'),'status'=>array(1,2)));
		
		
		unset($scharr['limit'],$scharr['offset']);
		$config['total_rows'] = $this->adminalluser_model->view_user_count($scharr);

		#$this->page_model->total = $reviews_count;
		#$this->page_model->page = $page_id;
		#$this->page_model->limit = $limit;

		unset($scharr['offset'],$scharr['limit'],$scharr['orderby']);
		$request_str = http_build_query($scharr);
		foreach($scharr as $scKey=>$scVal)
		{
			$this->data[$scKey] = $scVal;
		}

		#$this->page_model->url = BASE_URL."bdabdabda/reviews?page_id={page}".((empty($request_str))?'':'&'.$request_str);
		#$this->data['limit'] = $limit;
		#$this->data['offset'] = ($page_id - 1) * $limit;
		#$this->data['total'] = $reviews_count;
		#$this->data['page_id'] = $page_id;
		#$this->data['cur_url'] = $_SERVER['REQUEST_URI'];

		#$this->data['pagination'] = $this->page_model->render();
		$this->pagination->initialize($config); 
	}


}