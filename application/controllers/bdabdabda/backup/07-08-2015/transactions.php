<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');

class Transactions extends CI_Controller
{
	public $data = array();
	private $current_tab = 'transactions';
	public $perms	=	array();	

	function __construct()
	{
		parent::__construct();
		$this->load->model(array('admin/admindoctor_model','admin/adminpackages_model','page_model','admin/admintransactions_model','doctor_model'));
		$this->load->library("pagination");
		$this->load->helper("url");

		$this->perms	=	$this->session->userdata('allowed_perms'); 
		if($this->perms[ADMIN_TRANSACTIONS]['view']	==	0)
		{
			redirect('/bdabdabda/');
			exit();
		}
	}

	function index()
	{
		$this->data['current_tab'] = $this->current_tab;
		
		$this->data = array();
		if(sizeof($this->post) > 0)
		{
			if($this->post['url'])
			{
				echo $this->post['url'];
				redirect($this->post['url']);
			}
		}
		$this->search();
		$this->data['perms']	=	$this->perms;
		$this->load->view('admin/transactions', $this->data);
	}
	
	function search()
	{
		
		$this->data['current_tab'] = $this->current_tab;

		$config['base_url'] = BASE_URL.'bdabdabda/transactions?';
		$config['per_page'] = 10;
		if(count($_GET) > 1)
		{
			$config['base_url'] = $config['base_url'] . http_build_query($_GET, '', '&');
		}
		$page = !empty($_GET['start']) ? $_GET['start'] : 0;
		
		
		
		$scharr	= array('limit'=>$config['per_page'],'offset' =>$page,'orderby'=>'transactions.transaction_started_on desc');
		if($this->input->get('order_id'))
		{
			$scharr['order_id'] = $this->input->get('order_id');
		}
		if($this->input->get('doctor_name'))
		{
			$scharr['doctor_name'] = $this->input->get('doctor_name');
		}
		if(strlen($this->input->get('order_status'))>0)
		{
			$scharr['order_status'] = $this->input->get('order_status');
		}
		if($this->input->get('package_type'))
		{
			$scharr['package_type'] = $this->input->get('package_type');
		}

		
		
		$this->data['results'] = $this->admintransactions_model->get_transactions($scharr);
		$config['total_rows'] = $this->admintransactions_model->row_count;
		
		#$this->page_model->total = $transactions_count;
		#$this->page_model->page = $page_id;
		#$this->page_model->limit = $limit;

		#unset($scharr['offset'],$scharr['limit'],$scharr['orderby']);
		#$request_str = http_build_query($scharr);
		foreach($scharr as $scKey=>$scVal)
		{
			$this->data[$scKey] = $scVal;
		}
		#print_r($this->data);exit;
		#$this->page_model->url = BASE_URL."bdabdabda/transactions?page_id={page}".((empty($request_str))?'':'&'.$request_str);
		#$this->data['limit'] = $limit;
		#$this->data['offset'] = ($page_id - 1) * $limit;
		#$this->data['total'] = $transactions_count;
		#$this->data['page_id'] = $page_id;
		#$this->data['cur_url'] = $_SERVER['REQUEST_URI'];
		#$this->data['pagination'] = $this->page_model->render();
		#print_r($config);exit;
		$this->pagination->initialize($config); 

	}

	function viewdetails($order_id = NULL)
	{
		if($order_id == NULL)
		{
			redirect('/bdabdabda/transactions');
			exit();
		}
		else
		{
			$this->data['current_tab'] = $this->current_tab;

			$this->data['order_details'] = $this->admintransactions_model->get_all_order_details($order_id);

			$this->load->view('admin/transactions_viewdetails', $this->data);
		}
	}
	
}