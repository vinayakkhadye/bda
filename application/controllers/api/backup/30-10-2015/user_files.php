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
		$this->load->model(array('user_files_model'));

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
			$rs	=	array("message"=>"data uploaded successful", "file_data"=>array("file_id"=>$file_id,"file_path"=>$file_path,"title"=>$title,"report_date"=>$report_date), "status"=>1);
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
		
		$title						=	$this->post('title');
		$report_type			=	$this->post('report_type');

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
		
		$file_list	=	$this->user_files_model->get_file_details(array('patient_id'=>$patient_id,'doctor_id'=>$doctor_id,
		'from_report_date'=>$from_report_date,'to_report_date'=>$to_report_date,'report_type'=>$report_type,'title'=>$title));
		
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
			$rs = array("file_data"=>$file_list,"status" =>1,"message"=>"Successful");
		}
		else
		{
				$rs = array("message"=>"No Records Available","status" =>0);
		}
		$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
	}
	
	function download_get()
	{
		$user_type			=	intval($this->get('user_type'));
		$file_id				=	$this->get('file_id');
		$patient_id			=	($this->get('patient_id'))?$this->get('patient_id'):NULL;
		$doctor_id			=	($this->get('doctor_id'))?$this->get('doctor_id'):NULL;
		
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
			$this->filedownload($file_detail);
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
		
		if(empty($user_type) || empty($patient_id) || empty($file_id) || empty($file_path) )
		{
			$rs = array("message"=>"please provide user_type, patient_id, file_id, file_path","status" =>0);
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
			$file_path	=	 $file_path;
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
	
	function filedownload($file_details)
	{
		if(empty($file_details['file_path']))
		{
			$rs = array("message"=>"file not available","status" =>0);
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		}
		$file	=	DOCUMENT_ROOT.$file_details['file_path'];
		if (file_exists($file)) 
		{
				header('Content-Description: File Transfer');
				header('Content-Type: application/octet-stream');
				header('Content-Disposition: attachment; filename='.$file_details['file_name']);
				header('Expires: 0');
				header('Cache-Control: must-revalidate');
				header('Pragma: public');
				header('Content-Length: ' . filesize($file));
				readfile($file);
				exit;
		}

	}

	function fileupload_multipart($file)
	{
		$allowed_file_types = array('image/jpeg','image/png','image/gif','application/vnd.ms-excel','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet','application/vnd.openxmlformats-officedocument.wordprocessingml.document','application/msword','text/plain','application/pdf','application/zip','application/x-zip','application/x-zip-compressed');
		
		if(isset($file['filedata']['type']) && !in_array($file['filedata']['type'],$allowed_file_types)){
			return array(FALSE,"Sorry, allowed image types are jpeg,png,gif,pdf,document,excel");
		}
		if(isset($file["filedata"]["name"]))
		{
			
			if($file["filedata"]["size"]> $this->max_file_size)
			{
				return array(FALSE,"File size cannot grater than 2 MB");
			}
			
			$target_file	=	$this->createfilepath($file["filedata"]["name"]);
			if(move_uploaded_file($file["filedata"]["tmp_name"], $target_file))
			{
				if(in_array($file['filedata']['type'],array('image/jpeg','image/jpg','image/png','image/gif')))
				{
					$thumbnail	=	$this->create_thumbnail($target_file);
				}
				else if($file['filedata']['type']=='application/pdf')
				{
					$thumbnail	=	'./static/images/pdf_image.jpg';
				}
				else if(in_array($file['filedata']['type'],
				array('application/vnd.openxmlformats-officedocument.wordprocessingml.document','application/msword')))
				{
					$thumbnail	=	'./static/images/document_image.jpg';
				}
				else
				{
					$thumbnail	=	'./static/images/other_image.jpg';
				}
				
				$path	=	pathinfo($target_file);
				$path['thumbnail']	=	$thumbnail;
				return $path;
			}
			else
			{
				return array(FALSE,"Sorry, there was an error uploading your file.");
			}
		}
	}	

	function fileupload($base64_file,$file_name)
	{

		if(empty($base64_file) || empty($file_name) )
		{
			return array(FALSE,"no base64 format provided");
		}
		
		$isvalidb64 = $this->is_base64($base64_file);
		if(!$isvalidb64)
		{
			return array(FALSE,"invalid base64 format");
		}

		$ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
		if(empty($ext))
		{
			return array(FALSE,"invalid extension");
		}
		else
		{
			if(!in_array($ext,array('jpg','jpeg','png','pdf','doc','docx','txt'))){
				return array(FALSE,"invalid extension");
			}
		}

		// setup the image new file name
		$filename      = md5($file_name.strtotime("now"));#.rand(10000,99999)
		// Get extension of the file
		$ext           = pathinfo($file_name, PATHINFO_EXTENSION);

		$md        = substr($filename,0,2)."/".substr($filename,2,1)  ;// getting the current month, year and fist letter of image for folder name
		$structure = "./media/reports/".$md; // setting the folder path

		// Check if the directory with that particular name is present or not
		if(!is_dir($structure)){
			// If directory not present, then create the directory
			$this->mkpath($structure,0777);
		}
		// get the full filename with full path as it needs to be entered in the db
		$filename_path = $structure."/".$filename.".".$ext;
		$decoded_pic   = base64_decode($base64_file);
		if(file_put_contents($filename_path, $decoded_pic))
		{
			$file	=	DOCUMENT_ROOT.$filename_path;
			if(filesize($file) > $this->max_file_size)
			{
					$this->delete_file($file);
					return array(FALSE,"File size cannot grater than 2 MB");
			}

			$finfo = new finfo(FILEINFO_MIME);
			$type = $finfo->file($file);

			$type	=	 explode(";",$type);
			$type	=	 current($type);
			if(!in_array($type,$this->file_application_types))
			{
				$this->delete_file($file);
				return array(FALSE,"invalid file type");
			}
			
			$file_type	=	$this->get_file_type(strtolower($ext));
			$thumbnail	=	'';
			
			if($file_type=='image' && !in_array($type,array("application/zip", "application/x-zip", "application/x-zip-compressed","application/pdf")))
			{
				$thumbnail	=	$this->create_thumbnail($filename_path);
			}
			else if($file_type=='pdf')
			{
				$thumbnail	=	'./static/images/pdf_image.jpg';
			}
			else if($file_type=='document')
			{
				$thumbnail	=	'./static/images/document_image.jpg';
			}
			else
			{
				$thumbnail	=	'./static/images/other_image.jpg';
			}
			$path	=	pathinfo($filename_path);
			$path['thumbnail']	=	$thumbnail;
			return $path;
		}
		else
		{
			return array(FALSE,"file not uploaded to $filename_path");
		}
	}	
	
	function create_thumbnail($file_path)
	{
		$file	=	DOCUMENT_ROOT.$file_path;
		$file_data	=	pathinfo($file_path);
		$new_file	=	$file_data['dirname']."/".$file_data['filename']."_t.".$file_data['extension'];
		$new_file_path	=	DOCUMENT_ROOT.$new_file;
		$image_type	=	exif_imagetype($file);
		$thumbWidth	=	 640;
		if($image_type==1)
		{
			$img = @imagecreatefromgif($file);
		}
		else if($image_type==2)
		{
			$img = @imagecreatefromjpeg($file);
		}
		else if($image_type==3)
		{
			$img = @imagecreatefrompng($file);
		}
		else
		{
			$img = @imagecreatefromjpeg($file);
		}
		
		// load image and get image size
		$width = imagesx( $img );
		$height = imagesy( $img );

		// calculate thumbnail size
		$new_width = $thumbWidth;
		$new_height = floor( $height * ( $thumbWidth / $width ) );

		// create a new temporary image
		$tmp_img = imagecreatetruecolor( $new_width, $new_height );

		// copy and resize old image into new image 
		imagecopyresized( $tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height );

		// save thumbnail into a file
		
		if($image_type==1)
		{
			if(imagegif( $tmp_img, $new_file_path ))
			{
				return $new_file;
			}
		}
		else if($image_type==2)
		{
			if(imagejpeg( $tmp_img, $new_file_path ))
			{
				return $new_file;
			}
		}
		else if($image_type==3)
		{
			if(imagepng( $tmp_img, $new_file_path ))
			{
				return $new_file;
			}
		}
		else
		{
			if(imagejpeg( $tmp_img, $new_file_path ))
			{
				return $new_file;
			}
		}
		return false;		
	}
	
	function is_base64($s)
	{
		return base64_decode($s,true);
	}

	function mkpath($path,$perm)
	{
		if(@mkdir($path) or file_exists($path)) return true;
		return ($this->mkpath(dirname($path),$perm) and mkdir($path,$perm));
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

	function get_file_content_type($extension)
	{
		if(in_array($extension,array("jpg","jpeg","png")))
		{
			if($extension=="png")
				return "image/png";
			else if($extension=="jpg")	
				return "image/jpg";
			else if($extension=="jpeg")
				return "image/jpeg";
		}
		else if($extension=="pdf")
		{
			return "application/pdf";
		}
		else if(in_array($extension,array("doc","docx","txt")))
		{
			if($extension=="doc")
				return "application/msword";
			else if($extension=="docx")	
				return "application/msword";#"application/vnd.openxmlformats-officedocument.wordprocessingml.document";
			else if($extension=="txt")
				return "text/plain";
		}
		else
		{
			return "application/octet-stream";
		}
	}
	
	public function createfilepath($image_name)
	{
		
		$image_name	= pathinfo($image_name,PATHINFO_BASENAME);
		$md        = substr(strtolower($image_name),0,2)."/".substr(strtolower($image_name),2,1)  ;// getting the current month, year and fist letter of image for folder name
		$structure = "./media/reports/".$md; // setting the folder path

		// Check if the directory with that particular name is present or not
		if(!is_dir($structure)){
			// If directory not present, then create the directory
			$this->mkpath($structure,0777);
		}
		// setup the image new file name
		$filename      = md5($image_name);
		// Get extension of the file
		$ext           = pathinfo($image_name, PATHINFO_EXTENSION);
		// get the full filename with full path as it needs to be entered in the db
		$filename_path = $structure."/".$filename.".".$ext;
		return $filename_path;
	}
	
	function delete_file($file_path)
	{
		if($file_path)
		{
			$file_path = DOCUMENT_ROOT.$file_path;
			if(file_exists($file_path))
			{
				$unlink = unlink($file_path);
				if($unlink)
				{
					/* code to delete thumbnail if type is image */
					$file_path_array	=	pathinfo($file_path);
					$extension				=	$this->get_file_type($file_path_array['extension']);
					if($extension	==	"image")
					{
						$file_thumbnail	=	$file_path_array['dirname']."/".$file_path_array['filename']."_t".".".$file_path_array['extension'];
						$$file_thumbnail = DOCUMENT_ROOT.$file_thumbnail;
						if(file_exists($file_thumbnail))
						{
							$unlink = unlink($file_thumbnail);
						}
					}
					/* code to delete thumbnail if type is image */
					
					return 1;
				}
			}
		}
		return 0;
	}

	function __toString()
	{
		return (string) $this->db->last_query();
	}
}