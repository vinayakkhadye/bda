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

class Reminders extends REST_Controller
{
	public $user_id										=	NULL;
	public $communication_id					=	NULL;
	public $communication_name				=	NULL;
	public $communication_type				=	NULL;
	public $communication_text				=	NULL;
	public $communication_run_type		=	NULL;
	public $communication_recipients	=	NULL;
	public $health_checkup_days				=	NULL;
	public $occasion_date							=	NULL;
	public $occasion_name							=	NULL;
	
	

	public $running_late	=	1;
	public $appointment_cancellaion	=	2;
	public $customized	=	3;
	public $birthday	=	4;
	public $general_health_check_up	=	5;
	public $occasions	=	6;
	public $communication_name_type	=	array("running_late","appointment_cancellaion","customized","birthday","general_health_check_up","occasions");

	private $log_file = ""; 

	function __construct()
	{
		parent::__construct();
		$this->load->model(array('sms_package_model'));
	}

	public function log_message($myfile,$query)
	{
		fwrite($myfile, $query);
		return false;
	}
	
	function get_sms_packages_post()
	{
		$rs = $this->sms_package_model->get_sms_packages();
		if($rs)
		{
			$rs = array("sms_package_data"=>$rs,"message"=>"successful","status"=>1);
		}
		else
		{
			$rs = array("message"=>"no sms packages found","status"=>0);
		}
		$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
	
	}
	
	function get_user_packages_post()
	{
		$user_id		=	intval($this->post('user_id'));
		if(empty($user_id))
		{
			$rs = array("message"=>"please provide user_id","status"=>0);
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		}
		$rs = $this->sms_package_model->get_user_packages($user_id);
		if($rs)
		{
			$rs = array("data"=>$rs,"status"=>1);
		}
		else
		{
			$rs = array("message"=>"no packages available","status"=>0);
		}
		$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
	}
	
	/* this method will not be used as it will hard coded in the app*/
	function get_communication_post()
	{
		$rs = $this->sms_package_model->get_communication();
		if($rs)
		{
			$rs = array("communication_data"=>$rs,"message"=>"successful","status"=>1);
		}
		else
		{
			$rs = array("message"=>"no communications found","status"=>0);
		}
		$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
	}
		
	/* this method will give you all template available for the communication */			
	function get_template_by_communication_post()
	{
		$communication_id		=	intval($this->post('communication_id'));
		$communication_type	=	$this->post('communication_type');
		$occasion_name			=	$this->post('occasion_name');
		
		if(empty($communication_id) || empty($communication_type))
		{
			$rs = array("message"=>"Please provide communication_id, communication_type","status"=>0);
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code	
		}

		$rs = $this->sms_package_model->get_template_by_communication($communication_id,$communication_type,$occasion_name);
		if($rs)
		{
			$rs = array("template_data"=>$rs,"message"=>"successful","status"=>1);
		}
		else
		{
			$rs = array("message"=>"no template found","status"=>0);
		}
		$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
	}
	
	function running_late_post()
	{
		$doctor_id 		= intval($this->post('doctor_id'));
		$is_from_date	= strtotime($this->post('start_date_time'));
		$is_to_date		= strtotime($this->post('end_date_time'));

		$this->user_id			=	intval($this->post('user_id'));	

		/* these params you will get from  /reminders/get_communication */
		$this->communication_id					=	$this->running_late;#;$this->post('communication_id');	
		$this->communication_text				=	$this->post('communication_text');	

		$this->communication_name				=	"running_late";#$this->post('communication_name');	
		$this->communication_type				=	"sms";#$this->post('communication_type');	
		$this->communication_run_type		=	"O";#$this->post('communication_run_type');	
		$this->communication_recipients	=	"S";#$this->post('communication_recipients');

		$doctor_name							=	$this->post('doctor_name');
		$time											=	$this->post('time');

		if(empty($doctor_id) || $is_from_date==false || $is_to_date==false || empty($this->user_id) || empty($this->communication_id) || empty($this->communication_text) || empty($doctor_name))# || empty($time)
		{
			$rs = array("message"=>"please provide user_id, doctor_id and start_date_time, end_date_time, communication_text, doctor_name","status" =>0);
			#, time
			$this->response(array("response"=>$rs), 200);
		}

		$from_date = date("Y-m-d H:i:s",strtotime($this->post('start_date_time')));
		$to_date = date("Y-m-d H:i:s",strtotime($this->post('end_date_time')));
		
		$this->load->model(array('appointment_model'));
		//check if any appointment is scheduled in that time slot
		$running_late_appointments = $this->appointment_model->get_appointments_by_date_range($from_date,$to_date,$doctor_id,'',1);

		if(is_array($running_late_appointments) && sizeof($running_late_appointments)>0)
		{
			$communication_trans_id	=	$this->add_communication_for_user();
			if($communication_trans_id)
			{
				$sms_package_balance = $this->sms_package_model->get_user_packages($this->user_id);
				$blanace_sms	=	$sms_package_balance->sms_balance;
				if($blanace_sms==0)
				{
					$rs	=	array("message"=>"no sms available","status" =>0);
					$this->response(array("response"=>$rs), 200);
				}

				$sms_responce	=	 array();
				foreach($running_late_appointments as $a)
				{
					//send_sms to the patients for running late
					$sms_text	=	$this->communication_text;
					$sms_text	=	str_replace("{doctor_name}",$doctor_name,$sms_text);
					$sms_text	=	str_replace("{time}",$time,$sms_text);
					$sms_text_count	=	strlen($sms_text);
					$sms_cont	=	ceil($sms_text_count/160);
					
					$sms_text	.=	$sms_text." - Dr. ".$doctor_name;
					$response					=	$this->sendsms_model->send_sms($a['mobile_number'],urlencode($sms_text));				
					$response_array		=	explode('<!DOCTYPE',$response);
					$response_string	= trim(current($response_array));
					$this->sms_package_model->sms_log($this->user_id, $a['patient_id'], $communication_trans_id, $a['mobile_number'], $this->communication_name, $this->communication_type, 
					$this->communication_run_type, $response_string);
					for($sms_i=1;$sms_i<=$sms_cont;$sms_i++)
					{
						$this->sms_package_model->decrease_user_balance($this->user_id);
						$blanace_sms	=	$blanace_sms-1;
						if($blanace_sms==0)
						{
							$sms_responce["id-".$a['id']] = "sms sent";	
							$rs	=	array("data"=>$sms_responce,"status" =>0,"message"=>"last sms sent now buy more");
							$this->sms_package_model->delete_communication_for_user($this->communication_name, $this->communication_type, $this->user_id,NULL,NULL);
							$this->response(array("response"=>$rs), 200);
						}
					}
					$sms_responce["id-".$a['id']] = "sms sent";
				}
				$this->sms_package_model->delete_communication_for_user($this->communication_name, $this->communication_type, $this->user_id,NULL,NULL);
				$rs	=	array("status" =>1,"message"=>"successful");#"data"=>$sms_responce,
			}
			else
			{
					$rs	=	array("message"=>"communication failed","status" =>0);
			}
		}
		else
		{
			$rs	=	array("message"=>"no appointments available for this slot","status" =>0);
		}
		$this->response(array("response"=>$rs), 200);
	}
	
	function cancel_appointments_post()
	{
		$doctor_id = intval($this->post('doctor_id'));
		$from_date = date("Y-m-d H:i:s",strtotime($this->post('start_date_time')));
		$to_date = date("Y-m-d H:i:s",strtotime($this->post('end_date_time')));
		
		$this->user_id				=	$this->post('user_id');	
		$count					=	$this->post('count_of_appointments');	

		$this->communication_id				=	$this->appointment_cancellaion; #$this->post('communication_id');	
		$this->communication_text			=	$this->post('communication_text');	
		
		$this->communication_name				=	"appointment_cancellaion"; #$this->post('communication_name');	
		$this->communication_type				=	"sms";#$this->post('communication_type');	
		$this->communication_run_type		=	"O";#$this->post('communication_run_type');	
		$this->communication_recipients	=	"S";#$this->post('communication_recipients');
		

		$doctor_name						=	$this->post('doctor_name');
		
		
		$is_from_date	= 	strtotime($this->post('start_date_time'));
		$is_to_date		= 	strtotime($this->post('end_date_time'));
		
		if(empty($this->user_id) || empty($doctor_id) || $is_from_date==false || $is_to_date==false || empty($this->communication_id) || empty($this->communication_text) 
		|| empty($doctor_name))
		{
			$rs = array("message"=>"please provide user_id, doctor_id and start_date_time, end_date_time, communication_text, doctor_name","status" =>0);
			$this->response(array("response"=>$rs), 200);
		}

		$this->load->model(array('appointment_model'));
		//check if any appointment is scheduled in that time slot
		$cancelled_appointments = $this->appointment_model->get_appointments_by_date_range($from_date,$to_date,$doctor_id);
		#print_r($cancelled_appointments);exit;
		#$file_log = DOCUMENT_ROOT."logs/reminder_app_log_".date("Y-m-d").".log";
		#$this->log_file = fopen($file_log, "a+"); 
		
		#$this->log_message($this->log_file,"last_query : ".$this->db->last_query().NEW_LINE);
		
		if($count)
		{
			$rs	=	array("data"=>sizeof($cancelled_appointments),"status" =>1);
			$this->response(array("response"=>$rs), 200);
		}
		if(!empty($cancelled_appointments))
		{
			$communication_trans_id	=	$this->add_communication_for_user();
			if($communication_trans_id)
			{
				$sms_package_balance = $this->sms_package_model->get_user_packages($this->user_id);
				$blanace_sms	=	$sms_package_balance->sms_balance;
				if($blanace_sms==0)
				{
					$rs	=	array("message"=>"no sms available","status" =>0);
					$this->response(array("response"=>$rs), 200);
				}
				
				$appointment_id_arr = array();
				foreach($cancelled_appointments as $a)
				{
					$appointment_id_arr[] = $a['id'];
				}
				//cancel appoitnments of that time slot
				$this->appointment_model->cancel_slot_appointments($appointment_id_arr);
				
				reset($cancelled_appointments);
				foreach($cancelled_appointments as $a)
				{
					//send_sms to the patients for appointment cancellation
					$sms_text	=	$this->communication_text;
					
					$sms_text	=	str_replace("{patient_name}",$a['patient_name'],$sms_text);
					$sms_text	=	str_replace("{doctor_name}",$doctor_name,$sms_text);
					$sms_text_count	=	strlen($sms_text);
					$sms_cont	=	ceil($sms_text_count/160);

					$response					=	$this->sendsms_model->send_sms($a['mobile_number'],urlencode($sms_text));				
					$response_array		=	explode('<!DOCTYPE',$response);
					$response_string	= trim(current($response_array));
					$this->sms_package_model->sms_log($this->user_id, $a['patient_id'], $communication_trans_id, $a['mobile_number'], $this->communication_name, $this->communication_type, 
					$this->communication_run_type, $response_string);
					
					for($sms_i=1;$sms_i<=$sms_cont;$sms_i++)
					{
						$this->sms_package_model->decrease_user_balance($this->user_id);
						$blanace_sms	=	$blanace_sms-1;
						if($blanace_sms==0)
						{
							$sms_responce[$a['id']] = "sms sent";	

							$rs	=	array("data"=>$sms_responce,"status" =>0,"message"=>"last sms sent now buy more",
							"doctor_sms"=>"all appointments cancelled, sms sent to limited patient because of shortage of sms");
							
							$this->sms_package_model->delete_communication_for_user($this->communication_name, $this->communication_type, $this->user_id,NULL,NULL);
							$this->response(array("response"=>$rs), 200);
						}
						$sms_responce[$a['id']] = "sms sent";	
					}
				}
				$this->sms_package_model->delete_communication_for_user($this->communication_name, $this->communication_type, $this->user_id,NULL,NULL);
				$rs	=	array("status" =>1,"message"=>"successful");#"data"=>$sms_responce,
			}
			else
			{
				$rs	=	array("message"=>"communication failed","status" =>1);
			}

		}
		else
		{
			$rs	=	array("message"=>"no appointments to cancel","status" =>0);
		}
		$this->response(array("response"=>$rs), 200);
		}

	function send_custom_sms_post()
	{ 
		$this->user_id			=	intval($this->post('user_id'));	

		/* these params you will get from  /reminders/get_communication */
		$this->communication_id					=	$this->customized;#$this->post('communication_id');	
		$this->communication_text				=	$this->post('communication_text');	

		$this->communication_name				=	"customized";#$this->post('communication_name');	
		$this->communication_type				=	"sms";#$this->post('communication_type');	
		$this->communication_run_type		=	"O";#$this->post('communication_run_type');	
		$this->communication_recipients	=	"S";#$this->post('communication_recipients');

		$patient_mobile						=	$this->post('patient_mobile');
		$doctor_name							=	$this->post('doctor_name');
		$time											=	$this->post('time');
		$doctor_id								=	intval($this->post('doctor_id'));

		if(empty($this->communication_id) || empty($this->communication_text) || empty($this->user_id) || empty($patient_mobile))
		{
			$rs = array("message"=>"please provide user_id, communication_text, patient_mobile","status" =>0);
			$this->response(array("response"=>$rs), 200);
		}

		$communication_trans_id	=	$this->add_communication_for_user();
		if($communication_trans_id)
		{
			$rs	=	 '';
			$sms_package_balance = $this->sms_package_model->get_user_packages($this->user_id);
			$blanace_sms	=	$sms_package_balance->sms_balance;
			if($blanace_sms==0)
			{
				$rs	=	array("message"=>"no sms available","status" =>0);
				$this->response(array("response"=>$rs), 200);
			}
			
			if($patient_mobile	==	'all')
			{
				if(empty($doctor_id))
				{
					$rs = array("message"=>"please provide doctor_id","status" =>0);
					$this->response(array("response"=>$rs), 200);
				}
				$this->load->model('patient_model');
				$patient_data 	= $this->patient_model->get_patient_list(array('doctor_id'=>$doctor_id));
				if(isset($patient_data) && is_array($patient_data) && sizeof($patient_data)>0)
				{
						foreach($patient_data as $pkey=>$pval)
						{
							$patient_mobile_array[]	=	$pval['id']."#".$pval['name']."#".$pval['mobile_number'];
						}
				}	
			}
			else
			{
				$patient_mobile_array			=	explode(",",$patient_mobile);
			}
			
			if(isset($patient_mobile_array) && is_array($patient_mobile_array) && sizeof($patient_mobile_array)>0)
			{
				foreach($patient_mobile_array as $key=>$val)
				{
					#print_r($patient_mobile_array);exit;
					$val_array	=	explode("#",$val);
					if(is_array($val_array) && sizeof($val_array)==3)
					{
						$patient_id			=	intval($val_array[0]);
						$patient_name		=	$val_array[1];
						$mobile_number	=	$val_array[2];
						if(empty($patient_id) || empty($patient_name) || empty($mobile_number))
						{
							$rs[$key]	=	array("message"=>"invalid string $val","status"=>0);
						}
						else
						{
							$sms_text	=	$this->communication_text;
							$sms_text	=	str_replace("{patient_name}",$patient_name,$sms_text);
							$sms_text	=	str_replace("{doctor_name}",$doctor_name,$sms_text);
							$sms_text	=	str_replace("{time}",$time,$sms_text);
							$sms_text_count	=	strlen($sms_text);
							$sms_cont	=	ceil($sms_text_count/160);
							
							#append doctor name
							$sms_text	.=	$sms_text." - Dr. ".$doctor_name;
							$response					=	$this->sendsms_model->send_sms($mobile_number,urlencode($sms_text));				
							$response_array		=	explode('<!DOCTYPE',$response);
							$response_string	= trim(current($response_array));
							
							$this->sms_package_model->sms_log($this->user_id, $patient_id, $communication_trans_id, $mobile_number, $this->communication_name, $this->communication_type, 
							$this->communication_run_type, $response_string);
	
							for($sms_i=1;$sms_i<=$sms_cont;$sms_i++)
							{
								$this->sms_package_model->decrease_user_balance($this->user_id);
								$blanace_sms	=	$blanace_sms-1;
								if($blanace_sms==0)
								{
									$sms_responce[$patient_id] = "sms sent";	
									$rs	=	array("data"=>$sms_responce,"status" =>0,"message"=>"last sms sent now buy more");
	
									$this->sms_package_model->delete_communication_for_user($this->communication_name, $this->communication_type, $this->user_id,NULL,NULL);
									$this->response(array("response"=>$rs), 200);
								}
							}
												
							## set status 2 for communication transaction
							$rs[$key]	=	array("patient_name"=>$patient_name,"status"=>1,"message_response"=>$response_string);
						}
						
					}
					else
					{
						$rs[$key]	=	array("message"=>"invalid string $val","status"=>0);
					}
				}
			}
			else
			{
				$rs	=	"no patients found";
			}	
			$this->sms_package_model->delete_communication_for_user($this->communication_name, $this->communication_type, $this->user_id,NULL,NULL);
			$rs	=	array("data"=>$rs,"status" =>1,"message" =>"successful");
			
		}
		else
		{
				$rs	=	array("message"=>"communication failed","status" =>0);
		}

		$this->response(array("response"=>$rs), 200);
	}
	
	function happy_birthday_post()
	{

		$this->user_id			=	intval($this->post('user_id'));	

		/* these params you will get from  /reminders/get_communication */
		$this->communication_id					=	$this->birthday;#$this->post('communication_id');	
		$this->communication_text				=	$this->post('communication_text');	

		$this->communication_name				=	"birthday";#$this->post('communication_name');	
		$this->communication_type				=	"sms";#$this->post('communication_type');	
		$this->communication_run_type		=	"S";#$this->post('communication_run_type');	
		$this->communication_recipients	=	"A";#$this->post('communication_recipients');

		$doctor_name	=	$this->post('doctor_name');
		$method_type	=	$this->post('method_type');

		if(empty($this->user_id))
		{
			$rs = array("message"=>"Please provide user_id","status"=>0);
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code	
		}

		switch($method_type)
		{
		case 'get_communication':
			$rs	=	$this->get_communication_of_user();
			if($rs)
			{
				$rs = array("data"=>current($rs),"status" =>1);
			}
			else
			{
				$rs = array("message"=>"no communication found","status" =>0);
			}
			$this->response(array("response"=>$rs), 200);
		break;

		case 'add_communication':
			if(empty($this->communication_text))
			{
				$rs = array("message"=>"Please provide communication_text","status"=>0);
				$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code	
			}
			$this->communication_text	=	$this->process_communication_text($this->communication_text,array('doctor_name'=>$doctor_name));
			$rs	=	$this->add_communication_for_user();
			if($rs)
			{
				$rs = array("data"=>array("id"=>$rs),"status" =>1,"message"=>"communication added successful");
			}
			else
			{
				$rs = array("message"=>"no communication added","status" =>0);
			}
			$this->response(array("response"=>$rs), 200);
		break;

		case 'delete_communication':
			$rs	=	$this->delete_communication_for_user();
			if($rs)
			{
				$rs = array("data"=>array("id"=>$rs),"status" =>1,"message"=>"communication deleted successfully");
			}
			else
			{
				$rs = array("message"=>"no communication found","status" =>0);
			}
			$this->response(array("response"=>$rs), 200);
		break;
		default:
			$rs = array("message"=>"please select method_type as get_communication, add_communication or delete_communication ","status" =>0);
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code	
		break;
		}
	}

	function general_health_check_up_post()
	{

		$this->user_id			=	intval($this->post('user_id'));	

		/* these params you will get from  /reminders/get_communication */
		$this->communication_id					=	$this->general_health_check_up;#$this->post('communication_id');	
		$this->communication_text				=	$this->post('communication_text');	
		

		$this->communication_name				=	"general_health_check_up";#$this->post('communication_name');	
		$this->communication_type				=	"sms";#$this->post('communication_type');	
		$this->communication_run_type		=	"S";#$this->post('communication_run_type');	
		#$this->communication_recipients	=	"S";#$this->post('communication_recipients'); # we need to change this

		$doctor_name										=	$this->post('doctor_name');
		$this->health_checkup_days			=	intval($this->post('health_checkup_days'));
		$method_type										=	$this->post('method_type');
		

		if(empty($this->user_id))
		{
			$rs = array("message"=>"Please provide user_id","status"=>0);
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code	
		}


		switch($method_type)
		{
		case 'get_communication':
			$rs	=	$this->get_communication_of_user();
			if($rs)
			{
				$rs = array("data"=>current($rs),"status" =>1);
			}
			else
			{
				$rs = array("message"=>"no communication found","status" =>0);
			}
			$this->response(array("response"=>$rs), 200);
		break;

		case 'add_communication':
			$this->communication_recipients	=	$this->post('communication_recipients');
			if(!in_array($this->communication_recipients,array("S","A")))
			{
				$rs = array("message"=>"Please provide communication_recipients as S - for selected or A - for all","status"=>0);
				$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code	
			}

			if(empty($this->communication_text) || empty($this->health_checkup_days))
			{
				$rs = array("message"=>"Please provide communication_text, health_checkup_days","status"=>0);
				$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code	
			}
			$this->communication_text	=	$this->process_communication_text($this->communication_text,array('doctor_name'=>$doctor_name));

			$rs	=	$this->add_communication_for_user();
			if($rs)
			{
				$rs = array("data"=>array("id"=>$rs),"status" =>1,"message"=>"communication added successful");
			}
			else
			{
				$rs = array("message"=>"no communication added","status" =>0);
			}
			$this->response(array("response"=>$rs), 200);
		break;

		case 'delete_communication':
			$rs	=	$this->delete_communication_for_user();
			if($rs)
			{
				$rs = array("data"=>array("id"=>$rs),"status" =>1,"message"=>"communication deleted successfully");
			}
			else
			{
				$rs = array("message"=>"no communication found","status" =>0);
			}
			$this->response(array("response"=>$rs), 200);
		break;
		default:
			$rs = array("message"=>"please select method_type as get_communication, add_communication or delete_communication ","status" =>0);
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code	
		break;
		}
	}

	function occasions_post()
	{

		$this->user_id			=	intval($this->post('user_id'));	

		/* these params you will get from  /reminders/get_communication */
		$this->communication_id					=	$this->occasions;#$this->post('communication_id');	
		$this->communication_text				=	$this->post('communication_text');	
		

		$this->communication_name				=	"occasions";#$this->post('communication_name');	
		$this->communication_type				=	"sms";#$this->post('communication_type');	
		$this->communication_run_type		=	"S";#$this->post('communication_run_type');	
		#$this->communication_recipients	=	"S";#$this->post('communication_recipients'); # we need to change this

		$doctor_name							=	$this->post('doctor_name');
		$method_type							=	$this->post('method_type');
		$this->occasion_name			=	$this->post('occasion_name');	
		

		if(empty($this->user_id))
		{
			$rs = array("message"=>"Please provide user_id","status"=>0);
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code	
		}
		

		switch($method_type)
		{
		case 'get_communication':
			$rs	=	$this->get_communication_of_user();
			if($rs)
			{
				$rs = array("data"=>$rs,"status" =>1);
			}
			else
			{
				$rs = array("message"=>"no communication found","status" =>0);
			}
			$this->response(array("response"=>$rs), 200);
		break;

		case 'add_communication':
			$this->communication_recipients	=	$this->post('communication_recipients');
			if(!in_array($this->communication_recipients,array("S","A")))
			{
				$rs = array("message"=>"Please provide communication_recipients as S - for selected or A - for all","status"=>0);
				$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code	
			}
		
			if(empty($this->communication_text) || empty($this->occasion_name))
			{
				$rs = array("message"=>"Please provide communication_text, occasion_name","status"=>0);
				$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code	
			}

			$occasion_data	=	$this->get_festival_list($this->occasion_name);
			if($occasion_data)
			{
			$this->occasion_date	=	$occasion_data[0]->date;
			}
			else
			{
				$rs = array("message"=>"Please provide valid occasion name","status"=>0);
				$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code	
			
			}

			$this->communication_text	=	$this->process_communication_text($this->communication_text,array('doctor_name'=>$doctor_name));

			$rs	=	$this->add_communication_for_user();
			if($rs)
			{
				$rs = array("data"=>array("id"=>$rs),"status" =>1,"message"=>"communication added successful");
			}
			else
			{
				$rs = array("message"=>"no communication added","status" =>0);
			}
			$this->response(array("response"=>$rs), 200);
		break;

		case 'delete_communication':
			$rs	=	$this->delete_communication_for_user();
			if($rs)
			{
				$rs = array("data"=>array("id"=>$rs),"status" =>1,"message"=>"communication deleted successfully");
			}
			else
			{
				$rs = array("message"=>"no communication found","status" =>0);
			}
			$this->response(array("response"=>$rs), 200);
		break;
		default:
			$rs = array("message"=>"please select method_type as get_communication, add_communication or delete_communication ","status" =>0);
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code	
		break;
		}
	}

	/*this method will be used to add recipeients for the user  */
	function add_communication_recipients_for_user_post()
	{
		$this->user_id						=	$this->post('user_id');
		$this->communication_name	=	$this->post('communication_name');
		$this->communication_type	=	"sms";
		$patient_id								=	$this->post('patient_id');
		$this->occasion_name			=	$this->post('occasion_name');
	
		if(empty($this->communication_name) || empty($patient_id) || empty($this->user_id))		
		{
				$rs = array("status" =>0,"message"=>"please provide communication_name, patient_id and user_id");
				$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code	
		}

		if(!in_array($this->communication_name,$this->communication_name_type))
		{
			$rs = array("status" =>0,"message"=>"please provide communication_name as running_late,appointment_cancellaion,customized,birthday,general_health_check_up,occasions");
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code	
		}

		if($this->communication_name=="occasions")		
		{
				$occasion_data	=	$this->get_festival_list($this->occasion_name);
				if($occasion_data)
				{
					$this->occasion_date	=	$occasion_data[0]->date;
					$this->occasion_name	=	$occasion_data[0]->name;
				}
				else
				{
					$rs = array("message"=>"Please provide valid occasion_name as holi,diwali,customized,eid,ganesh_chaturthi,christmas","status"=>0);
					$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code	
				
				}
		}
		
		$user_communication	=	$this->get_communication_of_user();
		if(!isset($user_communication[0]->id))
		{
			$rs = array("message"=>"communication is not available","status"=>0);
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code	
		}
		$rs	=	$this->sms_package_model->add_communication_recipients_for_user($user_communication[0]->id, $patient_id);	
		if($rs)
		{
				$rs = array("message"=>"communication recipients successfully added","status"=>1);
		}
		else
		{
			$rs = array("message"=>"communication recipients not added","status"=>0);
		}
		$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
	}

	/*this method will be used to remove recipeients from the user  */
	function delete_communication_recipients_for_user_post()
	{
		$this->user_id						=	$this->post('user_id');
		$this->communication_name	=	$this->post('communication_name');
		$this->communication_type	=	"sms";
		$patient_id								=	$this->post('patient_id');
		$this->occasion_name			=	$this->post('occasion_name');
	
		if(empty($this->communication_name) || empty($patient_id) || empty($this->user_id))		
		{
				$rs = array("status" =>0,"message"=>"please provide communication_name, patient_id and user_id");
				$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code	
		}

		if(!in_array($this->communication_name,$this->communication_name_type))
		{
			$rs = array("status" =>0,"message"=>"please provide communication_name as running_late,appointment_cancellaion,customized,birthday,general_health_check_up,occasions");
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code	
		}

		if($this->communication_name=="occasions")		
		{
				$occasion_data	=	$this->get_festival_list($this->occasion_name);
				if($occasion_data)
				{
					$this->occasion_date	=	$occasion_data[0]->date;
					$this->occasion_name	=	$occasion_data[0]->name;
				}
				else
				{
					$rs = array("message"=>"Please provide valid occasion_name as holi,diwali,customized,eid,ganesh_chaturthi,christmas","status"=>0);
					$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code	
				
				}
		}
		
		$user_communication	=	$this->get_communication_of_user();
		if(!isset($user_communication[0]->id))
		{
			$rs = array("message"=>"communication is not available","status"=>0);
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code	
		}
		$rs	=	$this->sms_package_model->delete_communication_recipients_for_user($user_communication[0]->id, $patient_id);	
		if($rs)
		{
				$rs = array("message"=>"communication recipients deleted successfully","status"=>1);
		}
		else
		{
			$rs = array("message"=>"communication recipients not deleted","status"=>0);
		}
		$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
	}

	function get_festival_list_post()
	{

		$this->communication_name				=	"occasions";#$this->post('communication_name');	
		$this->communication_type				=	"sms";#$this->post('communication_type');	
		$this->user_id									=	intval($this->post('user_id'));
		$patient_id											=	intval($this->post('patient_id'));
		
		if(empty($this->user_id))		
		{
			$rs = array("message"=>"please provide user_id","status"=>0);
			$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code	
		}
		
		$rs 				=	$this->sms_package_model->get_festival_list();
		$comn_temp	=	$this->sms_package_model->get_template_by_communication($this->occasions,'sms');
		$comm_data	=	$this->get_communication_of_user();
		$communication_template	=	$communication_by_id	=	$communication_by_name	=	$communication_trans_ids	=	array();

		if($rs)
		{
			if($comn_temp)
			{
				foreach($comn_temp as $key=>$val)
				{
					$communication_template[$val->occasion_name][]	=	array('id'=>$val->id,'text'=>$val->text);
				}
			}
			
			if($comm_data)
			{
				foreach($comm_data as $key=>$val)
				{
					$communication_by_id[$val->id]	=	array('occasion_name'=>$val->occasion_name,'communication_text'=>$val->communication_text);
					$communication_by_name[$val->occasion_name]	=	array('id'=>$val->id,'communication_text'=>$val->communication_text);
					$communication_trans_ids[]	=	$val->id;
				}
			}
			
			if($patient_id)
			{
				$recp_data	=	$this->sms_package_model->get_communication_recipients_for_user($communication_trans_ids,$patient_id);	
				if($recp_data)
				{
					foreach($recp_data as $key=>$val)
					{
						if(isset($communication_by_id[$val->communication_transaction_id]['occasion_name']))
						{
							$recipients_data[$communication_by_id[$val->communication_transaction_id]['occasion_name']]	=	$val->id;
						}
					}
				}
			}

			
			foreach($rs as $key=>$val)
			{
				$val->display_name	=	ucwords(str_replace("_"," ",$val->name));
				if(isset($communication_template[$val->name]))
				{
					$val->communication_text	=	$communication_template[$val->name];
				}
				$val->status	=	0;
				if(isset($communication_by_name[$val->name]))
				{
					$val->status	=	1;
				}
				if($patient_id)
				{
					$val->patient_status	=	0;
					if(isset($recipients_data[$val->name]))
					{
						$val->patient_status	=	1;
					}
				}
				$rs[$key]	=	$val;
			}
			if($patient_id)
			{
				$rs[]	=	$this->get_transaction_recipients_for_user('general_health_check_up','sms',$patient_id);
			}
			$rs = array("data"=>$rs,"message"=>"successful","status"=>1);
		}
		else
		{
			$rs = array("message"=>"no festivals","status"=>0);
		}
		$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
	}


	function get_transaction_recipients_for_user($communication_name,$communication_type,$patient_id)
	{
			$communication_template	=	$communication_by_id	=	$communication_by_name	=	$communication_trans_ids	=	$recipients_data	=	array();
			$this->communication_name				=	$communication_name;#"general_health_check_up";#$this->post('communication_name');	
			$this->communication_type				=	$communication_type;#"sms";#$this->post('communication_type');	
			
			$recipients_data['name']						=	$communication_name;
			$recipients_data['status']					=	0;
			$recipients_data['patient_status']	=	0;
			

			$comm_data	=	$this->get_communication_of_user();
			if($comm_data)
			{
				$recipients_data['status']				=	1;
				foreach($comm_data as $key=>$val)
				{
					$communication_by_id[$val->id]	=	array('communication_name'=>$val->communication_name,'communication_text'=>$val->communication_text);
					$communication_trans_ids[$val->id]	=	$val->id;
				}
				if($patient_id)
				{
					$recp_data	=	$this->sms_package_model->get_communication_recipients_for_user($communication_trans_ids,$patient_id);	
					if($recp_data)
					{
						foreach($recp_data as $key=>$val)
						{
							if(isset($communication_by_id[$val->communication_transaction_id]['communication_name']))
							{
								$recipients_data['name']	=	$communication_by_id[$val->communication_transaction_id]['communication_name'];
								$recipients_data['patient_status']	=	1;
							}
						}
					}
				}
			}
			return (object)$recipients_data;
	}
	function get_doctor_reminder_post()
	{
		$doctor_id	=	$this->post('doctor_id');
		$t					=	$this->post('t');
		if(empty($doctor_id))
		{
			$rs = array("message"=>"please provide doctor_id","status" =>0);
			$this->response(array("response"=>$rs), 200);
		}		
		$rs = $this->sms_package_model->get_doctor_reminder($doctor_id);	
		if($t)
		{
			echo $this->sms_package_model;
		}
		
		if($rs)
		{
			$rs = array("doctor_reminder_data"=>$rs,"message"=>"successful","status"=>1);
		}
		else
		{
			$rs = array("message"=>"no doctor_reminder found","status"=>0);
		}
		$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
	}

	function add_doctor_reminder_post()
	{
		$doctor_id					=	$this->post('doctor_id');
		$doctor_reminder_id	=	$this->post('doctor_reminder_id');
		if(empty($doctor_id) || empty($doctor_reminder_id) )
		{
			$rs = array("message"=>"please provide doctor_id, doctor_reminder_id","status" =>0);
			$this->response(array("response"=>$rs), 200);
		}		
		
		$rs = $this->sms_package_model->add_doctor_reminder($doctor_reminder_id,$doctor_id);	
		if($rs)
		{
			$rs = array("data"=>$rs,"message"=>"successful","status"=>1);
		}
		else
		{
			$rs = array("message"=>"not added or allready added","status"=>0,"error"=>$this->db->_error_message());
		}
		$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
	}

	function delete_doctor_reminder_post()
	{
		$doctor_id					=	$this->post('doctor_id');
		$doctor_reminder_id	=	$this->post('doctor_reminder_id');
		if(empty($doctor_id) || empty($doctor_reminder_id) )
		{
			$rs = array("message"=>"please provide doctor_id, doctor_reminder_id","status" =>0);
			$this->response(array("response"=>$rs), 200);
		}		
		
		$rs = $this->sms_package_model->delete_doctor_reminder($doctor_reminder_id,$doctor_id);	
		if($rs)
		{
			$rs = array("data"=>$rs,"message"=>"successful","status"=>1);
		}
		else
		{
			$rs = array("message"=>"not deleted or allready deleted","status"=>0,"error"=>$this->db->_error_message());
		}
		$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
	}

	/* method will be called internally to add communication for user*/
	function get_communication_of_user()
	{
		$user_id		=	$this->user_id;
		$communication_name		=	$this->communication_name;
		$occasion_name				=	$this->occasion_name;
		$communication_type		=	$this->communication_type;
		$health_checkup_days	=	$this->health_checkup_days;
		
		
		if(empty($user_id))
		{
			return false;
		}

		$rs = $this->sms_package_model->get_communication_for_user($user_id,$communication_name,$communication_type,'','',$occasion_name,$health_checkup_days);
		if($rs)
		{
			return $rs;
		}
		else
		{
			return false;
		}
	}

	/* method will be called internally to add communication */
	function add_communication_for_user()
	{
		$user_id									=	$this->user_id;
		$communication_name				=	$this->communication_name;
		$communication_type				=	$this->communication_type;
		$communication_text				=	$this->communication_text;
		$communication_run_type		=	$this->communication_run_type;
		$communication_recipients	=	$this->communication_recipients;
		$health_checkup_days			=	$this->health_checkup_days;
		$occasion_date						=	$this->occasion_date;
		$occasion_name						=	$this->occasion_name;
		
		$status	=	1;
		if(empty($user_id) || empty($communication_name) || empty($communication_type) || empty($communication_text) || empty($communication_run_type) || empty($communication_recipients))		
		{
			return false;		
		}
		$this->db->trans_start();
		$communication_transaction	=	$this->sms_package_model->check_communication_for_user_exists($communication_name, $communication_type, $user_id,$occasion_date,$occasion_name,$communication_run_type);

		if($communication_transaction)
		{
			$communication_trans_id	= $communication_transaction->id;
			if($communication_run_type=="O")
			{
				$this->sms_package_model->delete_communication_for_user($communication_name, $communication_type, $user_id,$health_checkup_days,$occasion_name);
				$communication_trans_id	=	$this->sms_package_model->add_communication_for_user($communication_name,$communication_type,$user_id,$communication_text,$communication_run_type,$status,$communication_recipients,$health_checkup_days,$occasion_name,$occasion_date);
			}
			else if($communication_run_type=="S")
			{
				$communication_affected_rows	=	$this->sms_package_model->active_communication_for_user($communication_trans_id,$communication_text,$communication_recipients,$health_checkup_days,$occasion_name,$occasion_date);	
			}
		}
		else
		{


			$communication_trans_id	=	$this->sms_package_model->add_communication_for_user($communication_name,$communication_type,$user_id,$communication_text,$communication_run_type,$status,$communication_recipients,$health_checkup_days,$occasion_name,$occasion_date);

			
		}
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE)
		{
			return false; 
		}
		else
		{

			return $communication_trans_id;
		}
	}
	
	/* this method will be used internally*/
	function delete_communication_for_user()
	{
		$user_id									=	intval($this->user_id);
		$communication_name				=	$this->communication_name;
		$communication_type				=	$this->communication_type;

		$health_checkup_days			=	$this->health_checkup_days;
		$occasion_name						=	$this->occasion_name;
		
		
		if(empty($user_id) || empty($communication_name) || empty($communication_type))		
		{
			return false;
		}
		$affected_rows	=	$this->sms_package_model->delete_communication_for_user($communication_name, $communication_type, $user_id,$health_checkup_days,$occasion_name);	
		if($affected_rows)
		{
				return $affected_rows;
		}
		else
		{
			return false;
		}
	}

	/*this method will be used internally  */
	function process_communication_text($communication_text,$a=array())
	{
		$sms_text	=	$communication_text;
		if(isset($a['patient_name']))
		{
			$sms_text	=	str_replace("{patient_name}",$a['patient_name'],$sms_text);
		}
		if(isset($a['doctor_name']))
		{
			$sms_text	=	str_replace("{doctor_name}",$a['doctor_name'],$sms_text);
		}

		if(isset($a['time']))
		{
			$sms_text	=	str_replace("{time}",$a['time'],$sms_text);
		}
		if(isset($a['health_checkup_days']))
		{
			$sms_text	=	str_replace("{health_checkup_days}",$a['health_checkup_days'],$sms_text);
		}
		return $sms_text;
	}

	/*this method will be used internally  */
	function get_festival_list($name)
	{
		if(empty($name))
		{
			return false;
		}
		$rs = $this->sms_package_model->get_festival_list($name);
		if($rs)
		{
			return $rs;
		}
		else
		{
			return false;
		}
	}

}