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

class Knowlarity extends REST_Controller
{
	private $log_file = ""; 
	function __construct()
	{
		parent::__construct();

	}
	public function log_message($myfile,$query)
	{
		fwrite($myfile, $query);
		#file_put_contents(DOCUMENT_ROOT."logs/" .$log_file,$query,FILE_APPEND);
		#$this->load->view('errors/page_missing.tpl.php',$this->data);
		return false;
	}

	public function getagentlist_get()
	{
		$is_work_on = 0;
		$rs_work_on	=	$this->db->query("SELECT is_working_hour FROM cdr_working_hour");
		$is_work_on	=	$rs_work_on->row('is_working_hour');

		if($is_work_on)
		{
			$caller_number = $this->get('caller_number');
			$rs            = $this->db->query("SELECT id as 'agent_id',name as 'agent_name',number as 'agent_number' FROM agents WHERE STATUS=1 AND isbusy=0");
			if($rs->num_rows() > 0)
			{
				$rs = array("agentList"=>$rs->result_array(),"message"  =>"successfull","status"	=>1,"is_work_hour"=>"yes");
			}
			else
			{
				$rs = array("message"=>"all agents are buzy at the moment","status" =>0,"is_work_hour"=>"yes");
			}
		}
		else
		{
			$rs = array("message"=>"we are on leave","status" =>1,"is_work_hour"=>"no");
		}
		$this->response($rs, 200); // 200 being the HTTP response code
	}
	
	public function getpopup_get()
	{
		$caller_number = "+".trim($this->get('caller_number'));
		$agent_number  = "+".trim($this->get('agent_number'));
		$extension     = intval($this->get('extension'));
		$res = array("status"=>0);

		$busy = $this->makeagent_available($agent_number,1);
		if($busy)
		{
			$insert_client_arr	=	array(
								'caller_number'=>$caller_number,
								'agent_number'=>$agent_number,
								'extension'=>$extension,
								'last_call_time'=>date("YmdHis")
								);
			
			$rs_insert	=	$this->db->insert('cdr_caller_info',$insert_client_arr);	
			$res = array("status"=>1);
		}

		$this->response($res, 200); // 200 being the HTTP response code
	}
	
	public function makeagent_available_get($status)
	{
		$agent_number = $this->get('agent_number');
		$status       = ($this->get('status'))?$this->get('status'):$status;

		$file_log = DOCUMENT_ROOT."logs/knowlarity_logs/makeagent_available_".date("Y-m-d").".log";
		$this->log_file = fopen($file_log, "a+"); 

		if(!empty($agent_number) && in_array($status,array(1,0)))
		{
			$this->log_message($this->log_file,"agent_number : ".$agent_number.", status : ".$status.NEW_LINE);

			$rs = $this->db->query("update agents set  `isbusy` = $status where number = $agent_number and status = 1");
			if($this->db->affected_rows())
			{
				$rs = array("message"=>"successfull","status" =>1);
				$this->log_message($this->log_file,"successfull"."update agents set  `isbusy` = $status where number = $agent_number and status = 1".NEW_LINE);
			}
			else
			{
				$rs = array("message"=>"no changes made","status" =>0);
				$this->log_message($this->log_file,"no changes made".NEW_LINE);
			}
		}
		else
		{
			$rs = array("message"=>"please provide valid agent_number and status ","status" =>0);
			$this->log_message($this->log_file,"please provide valid agent_number and status, agent_number : ".$agent_number.", status : ".$status.NEW_LINE);
		}
		
		$this->log_message($this->log_file,"--------------------------------------------".NEW_LINE);
		$this->response($rs, 200); // 200 being the HTTP response code
	}

	public function pushcdr_get()
	{
		$date          = date("Y-m-d",strtotime($this->get('date')));
		$time          = date("H:i:s",strtotime($this->get('time')));
		$caller_number = "+".trim($this->get('caller_number'));
		$call_status   = trim($this->get('call_status'));
		$call_duration = trim($this->get('call_duration'));
		$extension     = trim($this->get('extension'));
		$agent_number  = "+".trim($this->get('agent_number'));
		$recording_url = trim($this->get('recording_url'));
		$call_id       = trim($this->get('call_id'));
		
		$busy = $this->makeagent_available($agent_number,0);
		
		if($call_id && $caller_number && $agent_number)
		{
			if($this->check_agent_number($agent_number))
			{
				$sql = "INSERT INTO `cdr_details`(`date`,`time`,`caller_number`,`call_status`,`call_duraton`,`extension`,`agent_number`,`recording_url`,`call_id`)
				VALUES ('".$date."','".$time."','".$caller_number."','".$call_status."','".$call_duration."','".$extension."','".$agent_number."','".$recording_url."','".$call_id."')";
				$rs  = $this->db->query($sql);
				if($rs)
				{
					$rs = array("message"=>"successfull","status" =>1);
				}
				else
				{
					$rs = array("message"=>"unsuccessfull","status" =>0);
				}
			}
			else
			{
				$rs = array("message"=>"no such agent avialable with agent_number $agent_number","status" =>0);
			}
		}
		else
		{
			$rs = array("message"=>"please provide call_id, caller_number && agent_number","status" =>0);
		}

		$this->response($rs, 200); // 200 being the HTTP response code
	}

	public function verify_caller_get()
	{
		$file_log = DOCUMENT_ROOT."logs/verify_caller.log";
		$this->log_file	= fopen($file_log, "a+"); 
		$caller_number	= $this->get('caller_number');
		$date						= $this->get('date');
		$time						= $this->get('time');
		$call_id				= $this->get('call_id');
		
		$this->log_message($this->log_file,json_encode($_GET)."Call_id : ".$call_id." Caller Number :".$caller_number." DateTime: ".$date." ".$time.NEW_LINE);
		
		$rs            = $this->db->query("SELECT MINUTE(TIMEDIFF(NOW(),created_on)) minutes FROM caller_verify WHERE status = 0 AND number = '".$caller_number."' order by created_on desc limit 1");
		if($rs->num_rows() > 0)
		{
			$data = $rs->row();
			if($data->minutes > 5)
			{
				$res = array("message"=>"number not verified","status" =>0);
				$this->log_message($this->log_file,"\t Number Not Verified".NEW_LINE);
			}
			else
			{
				$res = array("message"=>"number verified","status" =>1);
				$this->db->query("update caller_verify set STATUS=1 where number = '".$caller_number."'");
				$this->log_message($this->log_file,"\t Number Verified".NEW_LINE);
			}
		}
		else
		{
			$res = array("message"=>"No request for verification from this number","status" =>0);
			$this->log_message($this->log_file,"\t No request For Verification From This Number".NEW_LINE);
		}
		$this->log_message($this->log_file,"--------------------------------------------".NEW_LINE);
		$this->response($res, 200); // 200 being the HTTP response code
	}

	public function verified_caller_get()
	{
		$caller_number	=	trim($this->get('callernumber'));
		$date          	=	$this->get('date');
		$time          	=	$this->get('time');
		
		if($caller_number)
		{
			$caller_number = '+91'.$caller_number;
			$rs            	=	$this->db->query("SELECT MINUTE(TIMEDIFF(NOW(),created_on)) minutes FROM caller_verify WHERE status = 1 AND number = '".$caller_number."' order by created_on desc limit 1");
			if($rs->num_rows() > 0)
			{
				$data = $rs->row();
				if($data->minutes > 6)
				{
					$res = array("message"=>"number not verified","status" =>0);
				}
				else
				{
					$appointment_id	=	intval($this->get('appointment_id'));
					if($appointment_id)
					{
						$this->db->query("update appointment set is_verified=1 where appointment_id = '".$appointment_id."'");
					}
					#$this->session->set_userdata('verification_done', 1);
					$res = array("message"=>"number verified","status" =>1);
				}
			}
			else
			{
				$res = array("message"=>"No request for verification from this number","status" =>0);
			}
		}
		else
		{
			$res = array("message"=>"Please Provide Number","status"=>0);
		}
		
		$this->response($res, 200); // 200 being the HTTP response code
	}
	
	public function verified_caller_post()
	{
		$caller_number	=	trim($this->post('callernumber'));
		$date          	=	$this->post('date');
		$time          	=	$this->post('time');
		
		if($caller_number)
		{
			$caller_number = '+91'.$caller_number;
			$rs            	=	$this->db->query("SELECT MINUTE(TIMEDIFF(NOW(),created_on)) minutes FROM caller_verify WHERE status = 1 AND number = '".$caller_number."' order by created_on desc limit 1");
			if($rs->num_rows() > 0)
			{
				$data = $rs->row();
				if($data->minutes > 6)
				{
					$res = array("message"=>"number not verified","status" =>0);
				}
				else
				{
					$appointment_id	=	intval($this->post('appointment_id'));
					if($appointment_id)
					{
						$this->db->query("update appointment set is_verified=1 where appointment_id = '".$appointment_id."'");
					}
					#$this->session->set_userdata('verification_done', 1);
					$res = array("message"=>"number verified","status" =>1);
				}
			}
			else
			{
				$res = array("message"=>"No request for verification from this number","status" =>0);
			}
		}
		else
		{
			$res = array("message"=>"Please Provide Number","status"=>0);
		}
		
		$this->response($res, 200); // 200 being the HTTP response code
	}
	
	public function send_for_verification_get()
	{
		$caller_number = $this->get('callernumber');
		if($caller_number)
		{
			$caller_number = '+91'.$caller_number;
			$rs            = $this->db->query("INSERT INTO `caller_verify`(`number`)VALUES ('".$caller_number."')");
			if($this->db->affected_rows()>0)
			{
				$res = array("message"=>"number send for verification","status" =>1);
			}
			else
			{
				$res = array("message"=>"number not sent verification","status" =>0);
			}
		}
		else
		{
			$res = array("message"=>"please provide number","status" =>0);
		}
		$this->response($res, 200); // 200 being the HTTP response code
	}
	public function send_for_verification_post()
	{
		$caller_number = $this->post('callernumber');
		if($caller_number)
		{
			$caller_number = '+91'.$caller_number;
			$rs            = $this->db->query("INSERT INTO `caller_verify`(`number`)VALUES ('".$caller_number."')");
			if($this->db->affected_rows()>0)
			{
				$res = array("message"=>"number send for verification","status" =>1);
			}
			else
			{
				$res = array("message"=>"number not sent verification","status" =>0);
			}
		}
		else
		{
			$res = array("message"=>"please provide number","status" =>0);
		}
		$this->response($res, 200); // 200 being the HTTP response code
	}
	

	/* Functions used inside the function */
	public function makeagent_available($agent_number,$status)
	{
		if(!empty($agent_number) && in_array($status,array(1,0)))
		{
			$rs = $this->db->query("update agents set  `isbusy` = $status where number = '{$agent_number}' and status = 1");
			if($this->db->affected_rows())
			{
				return true; 
			}
			else
			{
				return false; 
			}
		}
		else
		{
			return false;
		}
	}

	public function check_agent_number($agent_number)
	{
		$rs = $this->db->query("SELECT name FROM agents WHERE number=$agent_number AND status=1");
		if($rs->num_rows() > 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	public function get_caller_info()
	{
		$caller_number = trim($this->get('caller_number'));
		$res           = false;
		if($caller_number)
		{
			$rs = $this->db->query("SELECT name FROM doctor WHERE  contact_number = '".$caller_number."'");
			if($rs->num_rows() > 0)
			{
				$res = array("data"  =>$rs->result_array(),"status"=>1);
			}

			$rs = $this->db->query("SELECT name FROM patient WHERE  mobile_number = '".$caller_number."'");
			if($rs->num_rows() > 0)
			{
				$res = array("data"  =>$rs->result_array(),"status"=>1);
			}
		}

		return $res;
	}

}