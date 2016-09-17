<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');
set_time_limit(1000);
class knowlarity extends CI_Controller{
	private $current_tab = '';
	private $max_call_record;// store max id value from cdr_table table 

	function __construct()
	{
		parent::__construct();
		$this->load->library("pagination");
		$this->load->model(array('admin/adminknowlarity_model'));

		$this->perms	=	$this->session->userdata('allowed_perms'); 
		if($this->perms[ADMIN_KNOWLARITY]['view']	==	0)
		{	
			redirect('/bdabdabda/');
			exit();
		}
	}

	function update_value()
	{	
		$this->data['current_tab'] = "knowlarity";
		
 		if(!empty($this->post))
 		{

 			$status = $this->post['working'];
 			$affected_rows	=	$this->adminknowlarity_model->update_status($status);
 		} 			
 			
 		$this->data['flag']= $this->adminknowlarity_model->current_status();
 		//$this->data['flag']="0";
		$this->data['perms']	=	$this->perms;
		$this->load->view('admin/working_hr',$this->data); 

	}

	function call_record()
	{	
		$this->data['current_tab'] = "knowlarity";
		$config['base_url'] = BASE_URL.'bdabdabda/knowlarity/call_record?';
		$config['per_page'] = 30;
		if(count($_GET) > 1)
		{
			$config['base_url'] = $config['base_url'] . http_build_query($_GET, '', '&');
		}

		$page = !empty($_GET['start']) ? $_GET['start'] : 0;
		 	
		 $config['total_rows'] = $this->adminknowlarity_model->view_data_count();
		$this->pagination->initialize($config); 

 		$this->data['flag']= $this->adminknowlarity_model->view_data($config['per_page'],$page); 
		// $this->max_call_record = $this->adminknowlarity_model->max_id_call_record(); 
		$this->data['perms']	=	$this->perms;
		$this->load->view('admin/knowlarity_call_record',$this->data);
 		 // $this->new_call_record();		
	}
 

	function max_call_record()
	{	 
		$max_call_record = $this->adminknowlarity_model->max_id_call_record();
		echo json_encode($max_call_record); 		 
	}

	function new_call_record()
	{
		 $max_row	=	 $_POST['max_row'];  
		// $max_row	=	 65;  
		if($max_row)
		{
			$data	= $this->adminknowlarity_model->new_row_call_record($max_row);
		}  
		echo json_encode($data);
		//echo json_encode($results);
	}


	function caller_info()
	{	
		$this->data['current_tab'] = "knowlarity";
		$config['base_url'] = BASE_URL.'bdabdabda/knowlarity/caller_info?';
		$config['per_page'] = 10;
		if(count($_GET) > 1)
		{
			$config['base_url'] = $config['base_url'] . http_build_query($_GET, '', '&');
		}

		$page = !empty($_GET['start']) ? $_GET['start'] : 0;
		 	
		 $config['total_rows'] = $this->adminknowlarity_model->caller_info_details_count();
		$this->pagination->initialize($config); 
		 	
 		$this->data['flag']= $this->adminknowlarity_model->caller_info_details($config['per_page'],$page); 
		// $this->max_call_record = $this->adminknowlarity_model->max_id_call_record(); 
		$this->data['perms']	=	$this->perms;
		$this->load->view('admin/knowlarity_caller_info',$this->data);
 		 // $this->new_call_record();		
	}

	function agents()
	{	
		$this->data['current_tab'] = "knowlarity";
		$config['base_url'] = BASE_URL.'bdabdabda/knowlarity/agents?';
		$config['per_page'] = 10;
		if(count($_GET) > 1)
		{
			$config['base_url'] = $config['base_url'] . http_build_query($_GET, '', '&');
		}

		$page = !empty($_GET['start']) ? $_GET['start'] : 0;
		 	
		 $config['total_rows'] = $this->adminknowlarity_model->agents_count();
		$this->pagination->initialize($config); 
		 	
 		$this->data['flag']= $this->adminknowlarity_model->agents($config['per_page'],$page); 
		// $this->max_call_record = $this->adminknowlarity_model->max_id_call_record(); 
		$this->data['perms']	=	$this->perms;
		$this->load->view('admin/knowlarity_agents_view',$this->data);
 		 // $this->new_call_record();		
	}

	function agent_add()
	{
		$this->data['current_tab'] = "knowlarity";
		if(isset($_POST['submit']))
		{
			$this->adminknowlarity_model->add_agent($_POST['agent_name'],$_POST['agent_number']);
			redirect("/bdabdabda/knowlarity/agents");
		}
		$this->data['perms']	=	$this->perms;
		$this->load->view('admin/knowlarity_agent_add',$this->data);
	}
	function agent_edit($id)
	{
		$this->data['current_tab'] = "knowlarity";
		if(isset($_POST['submit']))
		{
			$this->adminknowlarity_model->edit_agent($_POST['agent_id'],$_POST['agent_name'],$_POST['agent_number'],$_POST['agent_busy'],
			$_POST['agent_status']);
			redirect("/bdabdabda/knowlarity/agents");
		}
		$this->data['agent_detail']= $this->adminknowlarity_model->agents(1,0,$id); 
		$this->data['agent_detail']	= current($this->data['agent_detail']);
		$this->data['perms']	=	$this->perms;
		$this->load->view('admin/knowlarity_agent_edit',$this->data);
	}

	function max_caller_info()
	{	 
		$max_caller_info = $this->adminknowlarity_model->max_id_caller_info();
		echo json_encode($max_caller_info); 		 
	}
	
	function new_caller_info()
	{
		 $max_row	=	 $_POST['max_row'];  
		// $max_row	=	 65;  
		if($max_row)
		{
			$data	= $this->adminknowlarity_model->new_row_caller_info($max_row);
		}  
		echo json_encode($data);
		//echo json_encode($results);
	}
	  


}