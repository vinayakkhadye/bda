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

class User_files extends REST_Controller
{
	private $log_file 	= ""; 
	private $max_file_size	=	2097152;#in bytes
	private $file_application_types	=	array("application/zip", "application/x-zip", "application/x-zip-compressed","application/pdf","image/jpeg","image/png","application/vnd.openxmlformats-officedocument.wordprocessingml.document");#in bytes
	
	function __construct()
	{
		parent::__construct();
		$this->load->model(array('user_files_model','page_model','media_model'));
	}
	
	public function log_message($myfile,$query)
	{
		fwrite($myfile, $query);
		return false;
	}

	function create_1_post()
	{
		$user_type				=	intval($this->post('user_type'));
		$doctor_id				=	($this->post('doctor_id'))?$this->post('doctor_id'):NULL;
		$patient_id				=	$this->post('patient_id');
		$appointment_id		=	($this->post('appointment_id'))?$this->post('appointment_id'):NULL;
		$filedata					=	$_FILES;
		$file_name				= $this->post('file_name');
		$report_type			=	$this->post('report_type');
		$notes						=	($this->post('notes'))?$this->post('notes'):NULL;
		$title						=	$this->post('title');
		$is_report_date		=	strtotime($this->post('report_date'));
		$report_date			=	date("Y-m-d",$is_report_date);	
		
		if(empty($user_type) || empty($patient_id) || empty($filedata) || empty($file_name) || empty($report_type) || empty($title) || empty($report_date) )
		{
			$rs = array("message"=>"please provide title, user_type, patient_id, filedata, file_name, report_type, report_date","status" =>0);
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		}
		if(!in_array($user_type,array(1,2)))
		{
			$rs = array("message"=>"please provide user_type as 1-patient or 2-doctor","status" =>0);
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		}
		if(!empty($patient_id) && !is_numeric($patient_id))
		{
			$rs = array("message"=>"please provide valid patient_id","status" =>0);
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		}
		if(!empty($doctor_id) && !is_numeric($doctor_id))
		{
			$rs = array("message"=>"please provide valid doctor_id","status" =>0);
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		}
		if(!empty($appointment_id) && !is_numeric($appointment_id))
		{
			$rs = array("message"=>"please provide valid appointment_id","status" =>0);
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		}
		if($is_report_date==false)
		{
			$rs = array("message"=>"please provide valid report_date","status" =>0);
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		}
		
		$file_name	= pathinfo($file_name,PATHINFO_BASENAME);
		$file_data	=	$this->fileupload_multipart($filedata);
		if(isset($file_data[0]))
		{
			$rs = array("message"=>$file_data[1],"status" => 0);
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		}

		$this->db->trans_start();
		$file_path											=	$file_data['dirname']."/".$file_data['basename'];
		$create_data['file_name']				=	$file_name;
		$create_data['file_path']				=	$file_path;
		$create_data['file_thumbnail']	=	$file_data['thumbnail'];
		$create_data['file_type']				=	$this->get_file_type(strtolower($file_data['extension']));
		$create_data['report_type']			=	$report_type;
		$create_data['report_date']			=	$report_date;
		$create_data['title']						=	$title;
		$create_data['notes']						=	$notes;
		$create_data['patient_id']			=	$patient_id;
		$create_data['doctor_id']				=	$doctor_id;
		$create_data['appointment_id']	=	$appointment_id;
		$create_data['created_on']			=	date("Y-m-d H:i:s",strtotime("now"));

		
		$file_id	=	$this->user_files_model->insert_user_files($create_data);
		
		if($file_id)
		{
			$share_data['file_id']		=	$file_id;
			$share_data['patient_id']	=	$patient_id;
			$share_data['doctor_id']	=	$doctor_id;
			$share_data['owner_id']		=	$doctor_id;	
			if($user_type==1)
			{
				$share_data['owner_id']	=	$patient_id;	
			}
			$shared_file_id	=	$this->user_files_model->insert_user_shared_files($share_data);	
		}

		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE)
		{
				$file_delete	=	$this->delete_file($file_path);
				$rs	=	array("message"=>"Failed Trans Status last error:". $this->db->_error_message(),"file_deleted"=>$file_delete,"status"=>0);
		}
		else
		{
			$rs	=	array("message"=>"data uploaded successful", "file_data"=>array("file_id"=>$file_id,"file_path"=>$file_path,"title"=>$title,"report_date"=>$report_date,"report_type"=>$report_type,"notes"=>$notes,"file_thumbnail"=>$file_data['thumbnail']), "status"=>1);
		}

		$file_log = DOCUMENT_ROOT."logs/user_files_log.log";
		$this->log_file = fopen($file_log, "a+"); 
		$this->log_message($this->log_file,json_encode($rs).NEW_LINE);
		$this->log_message($this->log_file,"-----------".NEW_LINE);

		$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
	}

	function create_post()
	{
		$user_type				=	intval($this->post('user_type'));
		$doctor_id				=	($this->post('doctor_id'))?$this->post('doctor_id'):NULL;
		$patient_id				=	$this->post('patient_id');
		$appointment_id		=	($this->post('appointment_id'))?$this->post('appointment_id'):NULL;
		$base64_file			=	$this->post('base64_file');
		$file_name				=	$this->post('file_name');
		$report_type			=	$this->post('report_type');
		$notes						=	($this->post('notes'))?$this->post('notes'):NULL;
		$title						=	$this->post('title');
		$is_report_date		=	strtotime($this->post('report_date'));
		$report_date			=	date("Y-m-d",$is_report_date);	
		
		if(empty($user_type) || empty($patient_id) || empty($base64_file) || empty($file_name) || empty($report_type) || empty($title) || empty($report_date) )
		{
			$rs = array("message"=>"please provide title, user_type, patient_id, base64_file, file_name, report_type, report_date","status" =>0);
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		}
		if(!in_array($user_type,array(1,2)))
		{
			$rs = array("message"=>"please provide user_type as 1-patient or 2-doctor","status" =>0);
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		}
		if(!empty($patient_id) && !is_numeric($patient_id))
		{
			$rs = array("message"=>"please provide valid patient_id","status" =>0);
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		}
		if(!empty($doctor_id) && !is_numeric($doctor_id))
		{
			$rs = array("message"=>"please provide valid doctor_id","status" =>0);
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		}
		if(!empty($appointment_id) && !is_numeric($appointment_id))
		{
			$rs = array("message"=>"please provide valid appointment_id","status" =>0);
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		}
		if($is_report_date==false)
		{
			$rs = array("message"=>"please provide valid report_date","status" =>0);
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		}
		

		$file_data	=	$this->fileupload($base64_file,$file_name);
		if(isset($file_data[0]))
		{
			$rs = array("message"=>$file_data[1],"status" => 0);
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		}

		$this->db->trans_start();
		$file_path											=	$file_data['dirname']."/".$file_data['basename'];
		$create_data['file_name']				=	$file_name;
		$create_data['file_path']				=	$file_path;
		$create_data['file_thumbnail']	=	$file_data['thumbnail'];
		$create_data['file_type']				=	$this->get_file_type(strtolower($file_data['extension']));
		$create_data['report_type']			=	$report_type;
		$create_data['report_date']			=	$report_date;
		$create_data['title']						=	$title;
		$create_data['notes']						=	$notes;
		$create_data['patient_id']			=	$patient_id;
		$create_data['doctor_id']				=	$doctor_id;
		$create_data['appointment_id']	=	$appointment_id;
		$create_data['created_on']			=	date("Y-m-d H:i:s",strtotime("now"));

		
		$file_id	=	$this->user_files_model->insert_user_files($create_data);
		
		if($file_id)
		{
			$share_data['file_id']		=	$file_id;
			$share_data['patient_id']	=	$patient_id;
			$share_data['doctor_id']	=	$doctor_id;
			$share_data['owner_id']		=	$doctor_id;	
			if($user_type==1)
			{
				$share_data['owner_id']	=	$patient_id;	
			}
			$shared_file_id	=	$this->user_files_model->insert_user_shared_files($share_data);	
		}

		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE)
		{
				$file_delete	=	$this->delete_file($file_path);
				$rs	=	array("message"=>"Failed Trans Status last error:". $this->db->_error_message(),"file_deleted"=>$file_delete,"status"=>0);
		}
		else
		{
			$rs	=	array("message"=>"data uploaded successful", "file_data"=>array("file_id"=>$file_id,"file_path"=>$file_path,"title"=>$title,"report_date"=>$report_date), "status"=>1);
		}
		$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
	}

	function share_post()
	{
		$user_type			=	$this->post('user_type');
		$file_id				=	$this->post('file_id');
		$patient_id			=	$this->post('patient_id');
		$doctor_id			=	($this->post('doctor_id'))?$this->post('doctor_id'):NULL;

		if(empty($user_type) || empty($file_id) || empty($patient_id))
		{
			$rs = array("message"=>"please provide user_type, file_id, patient_id","status" =>0);
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		}

		if(!in_array($user_type,array(1,2)))
		{
			$rs = array("message"=>"please provide user_type as 1-patient or 2-doctor","status" =>0);
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		}
		
		
		$owner_id			=	$patient_id;
		if($user_type==2)
		{
			if(empty($doctor_id))
			{
				$rs = array("message"=>"please provide doctor_id","status" =>0);
				$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
			}
			$owner_id			=	$doctor_id;
		}

		if(!empty($file_id) && !is_numeric($file_id))
		{
			$rs = array("message"=>"please provide valid file_id","status" =>0);
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		}
		if(!empty($patient_id) && !is_numeric($patient_id))
		{
			$rs = array("message"=>"please provide valid patient_id","status" =>0);
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		}
		if(!empty($doctor_id) && !is_numeric($doctor_id))
		{
			$rs = array("message"=>"please provide valid doctor_id","status" =>0);
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		}
		

		$share_data['file_id']		=	$file_id;
		$share_data['patient_id']	=	$patient_id;
		$share_data['doctor_id']	=	$doctor_id;
		$share_data['owner_id']		=	$owner_id;	
		if($user_type==1)
		{
			$share_data['owner_id']	=	$patient_id;	
		}
		$shared_file_id	=	$this->user_files_model->insert_user_shared_files($share_data);	
		$rs	=	array("message"=>"successful","status"=>1);
		$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code		
	}

	function unshare_post()
	{
		$user_type			=	$this->post('user_type');
		$file_id				=	$this->post('file_id');
		$patient_id			=	$this->post('patient_id');
		$doctor_id			=	($this->post('doctor_id'))?$this->post('doctor_id'):NULL;

		if(empty($user_type) || empty($file_id) || empty($patient_id))
		{
			$rs = array("message"=>"please provide user_type, file_id, patient_id","status" =>0);
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		}

		if(!in_array($user_type,array(1,2)))
		{
			$rs = array("message"=>"please provide user_type as 1-patient or 2-doctor","status" =>0);
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		}
		
		
		$owner_id			=	$patient_id;
		if($user_type==2)
		{
			if(empty($doctor_id))
			{
				$rs = array("message"=>"please provide doctor_id","status" =>0);
				$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
			}
			$owner_id			=	$doctor_id;
		}

		if(!empty($file_id) && !is_numeric($file_id))
		{
			$rs = array("message"=>"please provide valid file_id","status" =>0);
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		}
		if(!empty($patient_id) && !is_numeric($patient_id))
		{
			$rs = array("message"=>"please provide valid patient_id","status" =>0);
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		}
		if(!empty($doctor_id) && !is_numeric($doctor_id))
		{
			$rs = array("message"=>"please provide valid doctor_id","status" =>0);
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		}
		

		$share_data['file_id']		=	$file_id;
		$share_data['patient_id']	=	$patient_id;
		if($doctor_id)
		{
			$share_data['doctor_id']	=	$doctor_id;
		}
		$share_data['owner_id']		=	$owner_id;	

		$affected_rows	=	$this->user_files_model->delete_user_shared_files($share_data);	
		if($affected_rows)
		{
			$rs	=	array("message"=>"successful","status"=>1);
		}
		else
		{
				$rs	=	array("message"=>"unsuccessful","status"=>1);
		}
		
		$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code		
	}
	
	function list_post()
	{
		$user_type			=	intval($this->post('user_type'));
		$patient_id			=	$this->post('patient_id');
		$doctor_id			=	($this->post('doctor_id'))?$this->post('doctor_id'):NULL;
		
		$title					=	$this->post('title');
		$report_type		=	$this->post('report_type');
		$notes					=	$this->post('notes');
		$limit					=	($this->post('limit'))?$this->post('limit'):100;
		$page						=	($this->post('page'))?$this->post('page'):1;
		$offset      		= ($page - 1) * $limit;

		$is_from_report_date	= strtotime($this->post('from_report_date'));
		$is_to_report_date		= strtotime($this->post('to_report_date'));

		$from_report_date	=	($this->post('from_report_date'))?$this->post('from_report_date'):'';
		$to_report_date		=	($this->post('to_report_date'))?$this->post('to_report_date'):'';

		
		
		if(empty($user_type))
		{
			$rs = array("message"=>"please provide user_type","status" =>0);
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		}

		if(!in_array($user_type,array(1,2)))
		{
			$rs = array("message"=>"please provide user_type as 1-patient or 2-doctor","status" =>0);
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		}
		if($user_type==2)
		{
			if(empty($doctor_id))
			{
				$rs = array("message"=>"please provide doctor_id","status" =>0);
				$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
			}
			$owner_id	=	$doctor_id;
		}
		else if($user_type==1)
		{
			if(empty($patient_id))
			{
				$rs = array("message"=>"please provide patient_id","status" =>0);
				$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
			}
			$owner_id	=	$patient_id;
		}
		
		if($from_report_date && $to_report_date)
		{
			if($is_from_report_date==false || $is_to_report_date==false)
			{
				$rs = array("message"=>"please provide valid from_report_date, to_report_date","status" =>0);
				$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
			}
		}
		
		$file_list	=	$this->user_files_model->get_file_details(array('patient_id'=>$patient_id,'doctor_id'=>$doctor_id,'from_report_date'=>$from_report_date,'to_report_date'=>$to_report_date,'report_type'=>$report_type,'title'=>$title,'notes'=>$notes,'limit'=>$limit,'offset'=>$offset));
		
		$file_list_count	=	$this->user_files_model->get_file_details_count(array('patient_id'=>$patient_id,'doctor_id'=>$doctor_id,'from_report_date'=>$from_report_date,'to_report_date'=>$to_report_date,'report_type'=>$report_type,'title'=>$title,'notes'=>$notes));
		
		$this->page_model->onclick  = "return patient_documents_list(this,$patient_id,{page})";
		$this->page_model->total  = $file_list_count;
		$this->page_model->page   = $page;
		$this->page_model->limit  = $limit;
		$pagination								= $this->page_model->render();
		if($file_list)
		{
			if($file_list)
			{
				foreach($file_list as $key=>$val)
				{
						if($owner_id==$val['owner_id'])
						{
							$file_list[$key]['owner']	=	1;
						}
						else
						{
							$file_list[$key]['shared']	=	1;
						}
				}
			}
			$rs = array("file_data"=>$file_list,"status" =>1,"message"=>"Successful","next_page"=>($page+1),"pagination"=>$pagination,'file_count'=>$file_list_count);
		}
		else
		{
				$rs = array("message"=>"No Records Available","status" =>0);
		}
		$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
	}
	
	function download_get()
	{
		$file_id				=	$this->get('file_id');
		$patient_id			=	($this->get('patient_id'))?$this->get('patient_id'):NULL;
		$thumbnail			=	intval($this->get('thumbnail'));
		
		$doctor_id			=	NULL;
		if($this->get('doctor_id'))
		{
			$doctor_id		=	$this->get('doctor_id');
		}
		else if($this->session->userdata('doctor_id'))
		{
			$doctor_id		=	$this->session->userdata('doctor_id');
		}
		
		$user_type	=	NULL;
		if($this->get('user_type'))
		{
			$user_type		=	$this->get('user_type');
		}
		else if($this->session->userdata('usertype'))
		{
			$user_type		=	$this->session->userdata('usertype');
		}
		
		
		if(empty($user_type) || empty($file_id))
		{
			$rs = array("message"=>"please provide user_type, file_id","status" =>0);
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		}

		if(!in_array($user_type,array(1,2)))
		{
			$rs = array("message"=>"please provide user_type as 1-patient or 2-doctor","status" =>0);
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		}

		if(!empty($file_id) && !is_numeric($file_id))
		{
			$rs = array("message"=>"please provide valid file_id","status" =>0);
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		}

		if($user_type==2)
		{
			if(empty($doctor_id))
			{
				$rs = array("message"=>"please provide doctor_id","status" =>0);
				$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
			}
			$owner_id	=	$doctor_id;
		}
		else if($user_type==1)
		{
			if(empty($patient_id))
			{
				$rs = array("message"=>"please provide patient_id","status" =>0);
				$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
			}
			$owner_id	=	$patient_id;
		}
		$rs	=	 "file not available";
		$file_detail	=	$this->user_files_model->get_download_file(array('id'=>$file_id,'patient_id'=>$patient_id,'doctor_id'=>$doctor_id));
		if($file_detail)
		{
				$this->media_model->download($file_detail,$thumbnail);
		}
		else
		{
			$rs = array("message"=>"no file available for download","status" =>0);
		}
		
		$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
	
	}

	function display_get()
	{
		$file_id				=	$this->get('file_id');
		$patient_id			=	($this->get('patient_id'))?$this->get('patient_id'):NULL;
		$thumbnail			=	intval($this->get('thumbnail'));
		
		$doctor_id			=	NULL;
		if($this->get('doctor_id'))
		{
			$doctor_id		=	$this->get('doctor_id');
		}
		else if($this->session->userdata('doctor_id'))
		{
			$doctor_id		=	$this->session->userdata('doctor_id');
		}
		
		$user_type	=	NULL;
		if($this->get('user_type'))
		{
			$user_type		=	$this->get('user_type');
		}
		else if($this->session->userdata('usertype'))
		{
			$user_type		=	$this->session->userdata('usertype');
		}
		
		
		if(empty($user_type) || empty($file_id))
		{
			$rs = array("message"=>"please provide user_type, file_id","status" =>0);
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		}

		if(!in_array($user_type,array(1,2)))
		{
			$rs = array("message"=>"please provide user_type as 1-patient or 2-doctor","status" =>0);
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		}

		if(!empty($file_id) && !is_numeric($file_id))
		{
			$rs = array("message"=>"please provide valid file_id","status" =>0);
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		}

		if($user_type==2)
		{
			if(empty($doctor_id))
			{
				$rs = array("message"=>"please provide doctor_id","status" =>0);
				$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
			}
			$owner_id	=	$doctor_id;
		}
		else if($user_type==1)
		{
			if(empty($patient_id))
			{
				$rs = array("message"=>"please provide patient_id","status" =>0);
				$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
			}
			$owner_id	=	$patient_id;
		}
		$rs	=	 "file not available";
		$file_detail	=	$this->user_files_model->get_download_file(array('id'=>$file_id,'patient_id'=>$patient_id,'doctor_id'=>$doctor_id));
		if($file_detail)
		{
				$this->media_model->display($file_detail,$thumbnail);
		}
		else
		{
			$rs = array("message"=>"no file available for download","status" =>0);
		}
		
		$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
	
	}

	function delete_post()
	{
		$user_type				=	intval($this->post('user_type'));
		$doctor_id				=	($this->post('doctor_id'))?$this->post('doctor_id'):NULL;
		$patient_id				=	$this->post('patient_id');
		$appointment_id		=	($this->post('appointment_id'))?$this->post('appointment_id'):NULL;
		$file_id					=	$this->post('file_id');
		$file_path					=	$this->post('file_path');
		
		if(empty($user_type) || empty($patient_id) || empty($file_id))# || empty($file_path) 
		{
			$rs = array("message"=>"please provide user_type, patient_id, file_id","status" =>0);#, file_path
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		}
		if(!in_array($user_type,array(1,2)))
		{
			$rs = array("message"=>"please provide user_type as 1-patient or 2-doctor","status" =>0);
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		}
		if(!empty($patient_id) && !is_numeric($patient_id))
		{
			$rs = array("message"=>"please provide valid patient_id","status" =>0);
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		}
		if(!empty($doctor_id) && !is_numeric($doctor_id))
		{
			$rs = array("message"=>"please provide valid doctor_id","status" =>0);
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		}
		if(!empty($appointment_id) && !is_numeric($appointment_id))
		{
			$rs = array("message"=>"please provide valid appointment_id","status" =>0);
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		}
		if($user_type==2)
		{
			if(empty($doctor_id))
			{
				$rs = array("message"=>"please provide doctor_id","status" =>0);
				$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
			}
			$owner_id	=	$doctor_id;
		}
		else if($user_type==1)
		{
			if(empty($patient_id))
			{
				$rs = array("message"=>"please provide patient_id","status" =>0);
				$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
			}
			$owner_id	=	$patient_id;
		}
		
		$share_data['file_id']		=	$file_id;
		$share_data['patient_id']	=	$patient_id;
		if($doctor_id)
		{
			$share_data['doctor_id']	=	$doctor_id;
		}
		$share_data['owner_id']		=	$owner_id;	

		$check	=	$this->user_files_model->check_user_shared_files($share_data);	
		if(!$check)
		{
			$rs = array("message"=>"user should be owner of file to delete a file","status" =>0);
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		}
		$this->db->trans_start();
		
		$delete_data['id']							=	$file_id;
		$delete_data['patient_id']			=	$patient_id;
		if($doctor_id)
		{
			$delete_data['doctor_id']				=	$doctor_id;
		}
		$delete_data['appointment_id']	=	$appointment_id;

		$affected_rows	=	$this->user_files_model->delete_user_files($delete_data);
		
		if($affected_rows)
		{

			$shared_file_id	=	$this->user_files_model->delete_user_shared_files($share_data);	
		}

		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE)
		{
				$rs	=	array("message"=>"Failed Trans Status last error:". $this->db->_error_message(),"status"=>0);
		}
		else
		{
			$file_path	=	 $check->file_path;
			$file_delete	=	$this->delete_file($file_path);
			$rs	=	array("message"=>"successful", "status"=>1);
		}
		$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
	}

	function edit_1_post()
	{
		$user_type				=	intval($this->post('user_type'));
		$doctor_id				=	($this->post('doctor_id'))?$this->post('doctor_id'):NULL;
		$file_id					=	($this->post('file_id'))?$this->post('file_id'):NULL;
		$patient_id				=	$this->post('patient_id');
		$appointment_id		=	($this->post('appointment_id'))?$this->post('appointment_id'):NULL;
		$filedata					=	$_FILES;
		$file_name				=	$this->post('file_name');
		$report_type			=	$this->post('report_type');
		$notes						=	($this->post('notes'))?$this->post('notes'):NULL;
		$title						=	$this->post('title');
		
		$report_date			=	$this->post('report_date');	
		
		if(empty($user_type) || empty($patient_id) || empty($file_id))
		{
			$rs = array("message"=>"please provide user_type, patient_id, file_id","status" =>0);
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		}
		if(!in_array($user_type,array(1,2)))
		{
			$rs = array("message"=>"please provide user_type as 1-patient or 2-doctor","status" =>0);
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		}
		if(!empty($patient_id) && !is_numeric($patient_id))
		{
			$rs = array("message"=>"please provide valid patient_id","status" =>0);
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		}
		if(!empty($doctor_id) && !is_numeric($doctor_id))
		{
			$rs = array("message"=>"please provide valid doctor_id","status" =>0);
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		}
		if(!empty($appointment_id) && !is_numeric($appointment_id))
		{
			$rs = array("message"=>"please provide valid appointment_id","status" =>0);
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		}
		if(!empty($report_date))
		{
			$is_report_date		=	strtotime($report_date);
			if($is_report_date	==	false)
			{
				$rs = array("message"=>"please provide valid report_date","status" =>0);
				$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
			}
			$report_date			=	date("Y-m-d",$is_report_date);	
		}
		
		if(!empty($filedata) && empty($file_name) )
		{
				$rs = array("message"=>"please provide both filedata and file_name to upload a file","status" =>0);
				$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		}
		if(empty($filedata) && !empty($file_name) )
		{
				$rs = array("message"=>"please provide both filedata and file_name to upload a file","status" =>0);
				$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		}
		
		if($user_type==2)
		{
			if(empty($doctor_id))
			{
				$rs = array("message"=>"please provide doctor_id","status" =>0);
				$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
			}
			$owner_id	=	$doctor_id;
		}
		else if($user_type==1)
		{
			if(empty($patient_id))
			{
				$rs = array("message"=>"please provide patient_id","status" =>0);
				$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
			}
			$owner_id	=	$patient_id;
		}
		
		$share_data['file_id']		=	$file_id;
		$share_data['patient_id']	=	$patient_id;
		if($doctor_id)
		{
			$share_data['doctor_id']	=	$doctor_id;
		}
		$share_data['owner_id']		=	$owner_id;	

		$check	=	$this->user_files_model->check_user_shared_files($share_data);	
		
		if(!$check)
		{
			$rs = array("message"=>"user should be owner of file to delete a file","status" =>0);
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		}

		$file_name	= pathinfo($file_name,PATHINFO_BASENAME);
		if($filedata && $file_name)
		{
			$file_data	=	$this->fileupload_multipart($filedata);
			if(isset($file_data[0]))
			{
				$rs = array("message"=>$file_data[1],"status" => 0);
				$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
			}
		}

		$edit_data	=	array();
		if(isset($file_data))
		{
			$file_path										=	$file_data['dirname']."/".$file_data['basename'];
			$edit_data['file_path']				=	$file_path;
			$edit_data['file_thumbnail']	=	$file_data['thumbnail'];
			$edit_data['file_type']				=	$this->get_file_type(strtolower($file_data['extension']));
		}
		if($file_name)
		{
			$edit_data['file_name']				=	$file_name;
		}
		if($report_type)
		{
			$edit_data['report_type']			=	$report_type;
		}
		if($title)
		{
			$edit_data['title']			=	$title;
		}
		if($notes)
		{
			$edit_data['notes']			=	$notes;
		}
		
		if(sizeof($edit_data)==0)
		{
			$rs	=	array("message"=>"please provide file metadata to update like (filedata, file_name, report_type, title, notes) ","status"=>0);
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		}
		$affected_rows	=	$this->user_files_model->update_user_files($file_id,$edit_data);

		if ($affected_rows)
		{
			$file_delete	=	'';
			if($filedata && $file_name && isset($check->file_path) && !empty($check->file_path))
			{
				$file_delete	=	$this->delete_file($check->file_path);
			}
			$rs	=	array("message"=>"successful", "status"=>1,"old_file_deleted"=>$file_delete);
		}
		else
		{
			$rs	=	array("message"=>"unsuccessful","status"=>0);
		}
		$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
	}
	
	function edit_post()
	{
		$user_type				=	intval($this->post('user_type'));
		$doctor_id				=	($this->post('doctor_id'))?$this->post('doctor_id'):NULL;
		$file_id					=	($this->post('file_id'))?$this->post('file_id'):NULL;
		$patient_id				=	$this->post('patient_id');
		$appointment_id		=	($this->post('appointment_id'))?$this->post('appointment_id'):NULL;
		$base64_file			=	$this->post('base64_file');
		$file_name				=	$this->post('file_name');
		$report_type			=	$this->post('report_type');
		$notes						=	($this->post('notes'))?$this->post('notes'):NULL;
		$title						=	$this->post('title');
		
		$report_date			=	$this->post('report_date');	
		
		if(empty($user_type) || empty($patient_id) || empty($file_id))
		{
			$rs = array("message"=>"please provide user_type, patient_id, file_id","status" =>0);
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		}
		if(!in_array($user_type,array(1,2)))
		{
			$rs = array("message"=>"please provide user_type as 1-patient or 2-doctor","status" =>0);
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		}
		if(!empty($patient_id) && !is_numeric($patient_id))
		{
			$rs = array("message"=>"please provide valid patient_id","status" =>0);
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		}
		if(!empty($doctor_id) && !is_numeric($doctor_id))
		{
			$rs = array("message"=>"please provide valid doctor_id","status" =>0);
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		}
		if(!empty($appointment_id) && !is_numeric($appointment_id))
		{
			$rs = array("message"=>"please provide valid appointment_id","status" =>0);
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		}
		if(!empty($report_date))
		{
			$is_report_date		=	strtotime($report_date);
			if($is_report_date	==	false)
			{
				$rs = array("message"=>"please provide valid report_date","status" =>0);
				$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
			}
			$report_date			=	date("Y-m-d",$is_report_date);	
		}
		
		if(!empty($base64_file) && empty($file_name) )
		{
				$rs = array("message"=>"please provide both base64_file and file_name to upload a file","status" =>0);
				$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		}
		if(empty($base64_file) && !empty($file_name) )
		{
				$rs = array("message"=>"please provide both base64_file and file_name to upload a file","status" =>0);
				$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		}
		
		if($user_type==2)
		{
			if(empty($doctor_id))
			{
				$rs = array("message"=>"please provide doctor_id","status" =>0);
				$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
			}
			$owner_id	=	$doctor_id;
		}
		else if($user_type==1)
		{
			if(empty($patient_id))
			{
				$rs = array("message"=>"please provide patient_id","status" =>0);
				$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
			}
			$owner_id	=	$patient_id;
		}
		
		$share_data['file_id']		=	$file_id;
		$share_data['patient_id']	=	$patient_id;
		if($doctor_id)
		{
			$share_data['doctor_id']	=	$doctor_id;
		}
		$share_data['owner_id']		=	$owner_id;	

		$check	=	$this->user_files_model->check_user_shared_files($share_data);	
		
		if(!$check)
		{
			$rs = array("message"=>"user should be owner of file to delete a file","status" =>0);
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		}
		if($base64_file && $file_name)
		{
			$file_data	=	$this->fileupload($base64_file,$file_name);
			if(isset($file_data[0]))
			{
				$rs = array("message"=>$file_data[1],"status" => 0);
				$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
			}
		}

		$edit_data	=	array();
		if(isset($file_data))
		{
			$file_path										=	$file_data['dirname']."/".$file_data['basename'];
			$edit_data['file_path']				=	$file_path;
			$edit_data['file_thumbnail']	=	$file_data['thumbnail'];
			$edit_data['file_type']				=	$this->get_file_type(strtolower($file_data['extension']));
		}
		if($file_name)
		{
			$edit_data['file_name']				=	$file_name;
		}
		if($report_type)
		{
			$edit_data['report_type']			=	$report_type;
		}
		if($title)
		{
			$edit_data['title']			=	$title;
		}
		if($notes)
		{
			$edit_data['notes']			=	$notes;
		}
		
		if(sizeof($edit_data)==0)
		{
			$rs	=	array("message"=>"please provide file metadata to update like (base64_file, file_name, report_type, title, notes) ","status"=>0);
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		}
		$affected_rows	=	$this->user_files_model->update_user_files($file_id,$edit_data);

		if ($affected_rows)
		{
			$file_delete	=	'';
			if($base64_file && $file_name && isset($check->file_path) && !empty($check->file_path))
			{
				$file_delete	=	$this->delete_file($check->file_path);
			}
			$rs	=	array("message"=>"successful", "status"=>1,"old_file_deleted"=>$file_delete);
		}
		else
		{
			$rs	=	array("message"=>"unsuccessful","status"=>0);
		}
		$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
	}
	
	function fileupload_multipart($file)
	{
		$this->media_model->upload_type		=	'multipart';
		$this->media_model->content_type	=	'user_files';
		$this->media_model->file_data			=	$file;
		$this->media_model->file_path			=	FALSE;
		$file_data												=	$this->media_model->upload();
		return $file_data;
	}	

	function fileupload($base64_file,$file_name)
	{
		$this->media_model->upload_type		=	'base64';
		$this->media_model->content_type	=	'user_files';
		$this->media_model->base64_data		=	$base64_file;
		$this->media_model->file_name			=	$file_name;
		$this->media_model->file_path			=	FALSE;
		$file_data												=	$this->media_model->upload();
		return $file_data;
	}	

	function get_file_type($extension)
	{
		if(in_array($extension,array("jpg","jpeg","png")))
		{
			return "image";
		}
		else if($extension=="pdf")
		{
			return "pdf";
		}
		else if(in_array($extension,array("doc","docx","txt")))
		{
			return "document";
		}
		else
		{
			return "other";
		}
	}
	
	function delete_file($file_path)
	{
		$file_log = DOCUMENT_ROOT."logs/delete_user_files.log";
		$this->log_file = fopen($file_log, "a+"); 
		$this->log_message($this->log_file,$file_path.NEW_LINE);
		
		if($file_path)
		{
			$file_path = DOCUMENT_ROOT.$file_path;
			$this->log_message($this->log_file,$file_path.NEW_LINE);
			if(file_exists($file_path))
			{
				$this->log_message($this->log_file,"file_exists".NEW_LINE);
				$unlink = unlink($file_path);
				if($unlink)
				{
					$this->log_message($this->log_file,"file_unlink".NEW_LINE);
					/* code to delete thumbnail if type is image */
					$file_path_array	=	pathinfo($file_path);
					$extension				=	$this->get_file_type($file_path_array['extension']);
					if($extension	==	"image")
					{
						$file_thumbnail	=	$file_path_array['dirname']."/".$file_path_array['filename']."_t".".".$file_path_array['extension'];
						$this->log_message($this->log_file,$file_thumbnail.NEW_LINE);
						if(file_exists($file_thumbnail))
						{
							$this->log_message($this->log_file,"thumbnail_unlink".NEW_LINE);
							$unlink = unlink($file_thumbnail);
						}
					}
					/* code to delete thumbnail if type is image */
					$this->log_message($this->log_file,"---------------".NEW_LINE);				
					return 1;
				}
			}
		}
		$this->log_message($this->log_file,"---------------".NEW_LINE);				
		return 0;
	}

	function __toString()
	{
		return (string) $this->db->last_query();
	}
}