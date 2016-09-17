<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reviews extends CI_Controller
{
	public $data = array();
	private $current_tab = 'reviews';
	public $perms	=	array();
	function __construct()
	{
		parent::__construct();
		$this->load->model(array('admin/admindoctor_model','admin/adminreview_model','admin/adminmasters_model','page_model','reviews_model','doctor_model'));
		$this->load->library("pagination");
		$this->load->helper("url");

		$this->perms		=	$this->session->userdata('allowed_perms'); 
		$admin_home_url	=	$this->session->userdata('admin_home_url');
		if($this->perms[ADMIN_REVIEWS]['view']	==	0)
		{
			redirect($admin_home_url);
			exit();
		}
	}

	function index()
	{
		$this->data['current_tab'] = $this->current_tab;

		$this->data = array();
		if(sizeof($this->post) > 0)
		{
			if(!empty($this->post['approve']))
			{
				$this->update_status('1');
			}
			else
			if(!empty($this->post['disapprove']))
			{
				$this->update_status('-1');
			}
			else
			if(!empty($this->post['pending']))
			{
				$this->update_status('0');
			}
			/*if($this->post['url'])
			{
				echo $this->post['url'];
				redirect($this->post['url']);
			}*/

		}
		$this->search();
		
		$this->data['perms']	=	$this->perms;
		$this->load->view('admin/reviews_view', $this->data);
	}

	function search()
	{
		$this->data['current_tab'] = $this->current_tab;

		$config['base_url'] = BASE_URL.'bdabdabda/reviews?';
		$config['per_page'] = 50;
		if(count($_GET) > 1)
		{
			$config['base_url'] = $config['base_url'] . http_build_query($_GET, '', '&');
		}
		$page = !empty($_GET['start']) ? $_GET['start'] : 0;
		

		$scharr= array('limit'  =>$config['per_page'],'offset' =>$page,'orderby'=>'reviews.added_on desc');
		
		if($this->input->get('doctor_id'))
		{
			$scharr['doctor_id'] = $this->input->get('doctor_id');
		}
		if($this->input->get('doctor_name'))
		{
			$scharr['doctor_name'] = $this->input->get('doctor_name');
		}
		if($this->input->get('clinic_name'))
		{
			$scharr['clinic_name'] = $this->input->get('clinic_name');
		}		
		if($this->input->get('city_id'))
		{
			$scharr['city_id'] = $this->input->get('city_id');
		}		

		if($this->input->get('user_name'))
		{
			$scharr['user_name'] = $this->input->get('user_name');
		}
		if($this->input->get('user_email'))
		{
			$scharr['user_email'] = $this->input->get('user_email');
		}
		if($this->input->get('user_comment'))
		{
			$scharr['user_comment'] = $this->input->get('user_comment');
		}
		if($this->input->get('user_rating'))
		{
			$scharr['user_rating'] = $this->input->get('user_rating');
		}

		if(strlen($this->input->get('status')) > 0)
		{
			$scharr['status'] = $this->input->get('status');
		}

		$this->data['results'] = $this->adminreview_model->get_reviews($scharr);
		
		#$this->data['city_list'] = $this->adminmasters_model->get_city_list(0,0,array('column'=>array('id','name'),'status'=>array(1,2)));
		
		
		unset($scharr['limit'],$scharr['offset']);
		$config['total_rows'] = $this->adminreview_model->get_reviews_count($scharr);
		$config['total_rows']	=	$config['total_rows']['numrows'];

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

	function update_status($status)
	{
		if(isset($this->post['reviews_id']) && is_array($this->post['reviews_id']))
		{
			$ids = array_keys($this->post['reviews_id']);
			$this->adminreview_model->update_review_status($status, $ids);
		}
	}
	public function doctor_image_import($city,$image){
		$filename_path = '';
		$sourceUrl = "./uploads/doctor_images/".$city."_photos/";
		if(!empty($image)){
			$md        = date('M').date('Y')."/".strtolower(substr($image,0,1));#.rand(1,60); // getting the current month and year for folder name
			$structure = "./media/photos/".$md; // setting the folder path
			// Check if the directory with that particular name is present or not
			if(!is_dir($structure)){
				$this->mkpath($structure,0777);
			}
			// setup the image new file name
			$newfilename   = md5($image);#.rand(10,99)
			
			// Get extension of the file
			$ext = pathinfo($image, PATHINFO_EXTENSION);
			// get the full filename with full path as it needs to be entered in the db
		

			if(file_exists(DOCUMENT_ROOT.$sourceUrl.$image)){
				$filename_path = $structure."/".$newfilename.".".$ext;
				rename(DOCUMENT_ROOT.$sourceUrl.$image,DOCUMENT_ROOT.$filename_path);
				$this->log_message($this->log_file,"\t Image : moved :".$sourceUrl.$image ."=>". $filename_path.NEW_LINE);	
			}else{
				$this->log_message($this->log_file,"\t Image : no such file  :".$sourceUrl.$image ."=>". $filename_path.NEW_LINE);	
			}
		}
		return  $filename_path;
	}
	
	function add_reviews()
	{
		$this->data['current_tab'] = $this->current_tab;
		if(isset($_POST['submit']))
		{
				$newfilename = $this->input->post('profile_pic_base64_name');
				$filename_path = NULL;
				if(!empty($newfilename))
				{
					$image	=	$_POST['profile_pic_base64_name'];
					//echo getcwd();
					$md        = date('M').date('Y')."/".strtolower(substr($image,0,1));#.rand(1,60); // getting the current month and year for folder name
					$structure = "./media/photos/".$md; // setting the folder path
					// Check if the directory with that particular name is present or not
					if(!is_dir("./media/photos/".$md))
					{
						// If directory not present, then create the directory
						mkdir($structure, 0777);
					}
					// setup the image new file name
					$filename      = md5($newfilename).rand(10000,99999);
					// Get extension of the file
					$ext           = pathinfo($newfilename, PATHINFO_EXTENSION);
					// get the full filename with full path as it needs to be entered in the db
					$filename_path = $structure."/".$filename.".".$ext;

					$decoded_pic   = base64_decode($this->input->post('profile_pic_base64'));

					file_put_contents($filename_path, $decoded_pic);
				}
			if(!empty($_POST['doctorid']) && !empty($_POST['username']) && !empty($_POST['message']) && !empty($_POST['rating']) && is_numeric($_POST['doctorid']))
			{
				#print_r($_POST);
				//$this->reviews_model->insert_review($doctorid, $message, $rating, $name, $email, $fbid, $status=0);
				$this->adminreview_model->insert_review($_POST['doctorid'], $_POST['message'], $_POST['rating'], $_POST['username'], NULL, $filename_path, '1');
				#echo $this->adminreview_model;
				#exit;
				redirect('/bdabdabda/reviews');
				
			}
		}
		$this->data['perms']	=	$this->perms;
		$this->load->view('admin/reviews_add_view', $this->data);
	}
	
}