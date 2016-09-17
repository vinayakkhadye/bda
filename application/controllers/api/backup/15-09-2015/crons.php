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

class crons extends CI_Controller
{
	private $log_file 		= ""; 
	private $doctor				=	"";
	private $blanace_sms	=	"";
	
	function __construct()
	{
		parent::__construct();
		$this->load->model(array('doctor_model','patient_model','sms_package_model'));		
	}

	public function log_message($myfile,$query)
	{
		fwrite($myfile, $query);
		return false;
	}
	
	public function is_doctor_sms_package_valid($user_id)
	{
			$this->doctor =	$this->doctor_model->get_doctor_id($user_id);
			if($this->doctor==false)
			{
				return false;
			}
			
			$sms_package_balance = $this->sms_package_model->get_user_packages($user_id);
			if($sms_package_balance==false)
			{
				#send message to doctor for buying message pack script here
				$this->log_message($this->log_file,"no sms package available with user_id : ".$user_id.NEW_LINE);
				return false;
			}
			
			$this->blanace_sms	=	$sms_package_balance->sms_balance;
			if($this->blanace_sms	==	0)
			{
				#send message to doctor for insufficient of message balance script here
				$this->log_message($this->log_file,"no sms balance available with user_id : ".$user_id.NEW_LINE);
				return false;
			}
			return true;
	}
	
	/* this metho will be used to send sms by cron to pateints on birthday and general health check up*/
	public function send_reminders_sms($communication_name)
	{
			$communication_type			=	'sms';	
			$communication_run_type	=	'S';	
			$communication_recipients	=	'A';
			if(empty($communication_name))
			{
				return false;
			}
			$communication_data = $this->sms_package_model->get_communication_for_user('',$communication_name,$communication_type,$communication_run_type,$communication_recipients);
			if(is_array($communication_data) && sizeof($communication_data)>0)
			{
				foreach($communication_data as $data)
				{
					if($data->communication_name	==	'birthday')
					{
						if(empty($this->log_file))
						{
							$this->log_file = fopen(DOCUMENT_ROOT."logs/birthday_cron.log", "a+"); 						
						}
						
						if($this->is_doctor_sms_package_valid($data->user_id))
						{
							$doctor				=	$this->doctor;
							$blanace_sms	=	$this->blanace_sms;
							$query	=	$this->db->query("SELECT p.id,p.name,p.mobile_number,p.dob 
																					FROM (`patient` AS p) 
																					LEFT JOIN `appointment` apt ON `apt`.`patient_id` = `p`.`id` 
																					LEFT JOIN `doctor_patient_map` dpm ON `p`.`id`= `dpm`.`patient_id` 
																					WHERE (apt.doctor_id='".$doctor->id."' OR dpm.doctor_id='".$doctor->id."') 
																					AND `p`.`status` =  1 and p.dob	=	'".date("Y-m-d")."'
																					GROUP BY `p`.`id`");
																					
							$patient_list	=	$query->result_array();
							if(is_array($patient_list) && sizeof($patient_list)>0)
							{
								$patient_list_count	=	count($patient_list);
								if($blanace_sms	>=	$patient_list_count)
								{
									foreach($patient_list as $patient)
									{
										$sms_text	=	$data->communication_text;
										$sms_text	=	str_replace("{patient_name}",$patient['name'],$sms_text);
										$sms_text	=	str_replace("{doctor_name}",$doctor->name,$sms_text);
										
										$response					=	$this->sendsms_model->send_sms($patient['mobile_number'],urlencode($sms_text));				
										#$response_array		=	explode('<!DOCTYPE',$response);
										#$response_string	= trim(current($response_array));
										
										$this->sms_package_model->sms_log($data->user_id, $patient['id'], $data->id, $patient['mobile_number'], $data->communication_name, 
										$data->communication_type, $data->communication_run_type, $response);
										
										$this->sms_package_model->decrease_user_balance($data->user_id);
									}
								}
								else
								{
									#send message to doctor for insufficient of message balance script here
									$this->log_message($this->log_file,"sms balance less than patient list count with user_id : ".$data->user_id.NEW_LINE);
								}
							}
							else
							{
								#$this->log_message($this->log_file,"no patients available with user_id : ".$data->user_id.NEW_LINE);
							}
						}
					}
					else if($data->communication_name	==	'general_health_check_up')
					{
						if(empty($this->log_file))
						{
							$this->log_file = fopen(DOCUMENT_ROOT."logs/general_health_check_up_cron.log", "a+"); 						
						}

						if($this->is_doctor_sms_package_valid($data->user_id))
						{
							$doctor				=	$this->doctor;
							$blanace_sms	=	$this->blanace_sms;
							$date			= date("Y-m-d",strtotime("-".$data->health_checkup_days." days"));	

							$query	=	$this->db->query("SELECT patient_id,patient_name,patient_gender,mobile_number FROM appointment 
							WHERE doctor_id=".$doctor->id." AND STATUS=1 AND confirmation=1 AND date='".$date."'");
							# and patient_id in (".$recipients_data->patient_id.")
							$patient_list	=	$query->result_array();
							
							if(is_array($patient_list) && sizeof($patient_list)>0)
							{
								$patient_list_count	=	count($patient_list);
								if($blanace_sms	>=	$patient_list_count)
								{
									foreach($patient_list as $patient)
									{
										$sms_text	=	$data->communication_text;
										
										$sms_text	=	str_replace("{patient_name}",$patient['patient_name'],$sms_text);
										$sms_text	=	str_replace("{doctor_name}",$doctor->name,$sms_text);
										
										$response					=	$this->sendsms_model->send_sms($patient['mobile_number'],urlencode($sms_text));				
										#$response_array		=	explode('<!DOCTYPE',$response);
										#$response_string	= trim(current($response_array));
										
										$this->sms_package_model->sms_log($data->user_id, $patient['patient_id'], $data->id, $patient['mobile_number'], $data->communication_name, $data->communication_type, $data->communication_run_type, $response);
										
										$this->sms_package_model->decrease_user_balance($data->user_id);
									}
								}
								else
								{
									#send message to doctor for insufficient of message balance script here
									$this->log_message($this->log_file,"sms balance less than patient list count with user_id : ".$data->user_id.NEW_LINE);
								}
							}
							else
							{
								#$this->log_message($this->log_file,"no patients available with user_id : ".$data->user_id.NEW_LINE);
							}
							
						}
					}
					else if($data->communication_name=='occasions' && $data->occasion_date==date("Y-m-d"))
					{
						if(empty($this->log_file))
						{
							$this->log_file = fopen(DOCUMENT_ROOT."logs/occasions.log", "a+"); 						
						}

						if($this->is_doctor_sms_package_valid($data->user_id))
						{
							$doctor				=	$this->doctor;
							$blanace_sms	=	$this->blanace_sms;
							$occasion_name	= $data->occasion_name;	

							$query	=	$this->db->query("SELECT p.id,p.name,p.mobile_number
																					FROM (`patient` AS p) 
																					LEFT JOIN `appointment` apt ON `apt`.`patient_id` = `p`.`id` 
																					LEFT JOIN `doctor_patient_map` dpm ON `p`.`id`= `dpm`.`patient_id` 
																					WHERE (apt.doctor_id='".$doctor->id."' OR dpm.doctor_id='".$doctor->id."') 
																					AND `p`.`status` =  1 GROUP BY `p`.`id`");

							$patient_list		=	$query->result_array();
							if(is_array($patient_list) && sizeof($patient_list)>0)
							{
								$patient_list_count	=	count($patient_list);
								if($blanace_sms	>=	$patient_list_count)
								{
									foreach($patient_list as $patient)
									{
										$sms_text			=	$data->communication_text;
										$sms_text			=	str_replace("{patient_name}",$patient['name'],$sms_text);
										$sms_text			=	str_replace("{doctor_name}",$doctor->name,$sms_text);
			
										$response					=	$this->sendsms_model->send_sms($patient['mobile_number'],urlencode($sms_text));				
										#$response_array		=	explode('<!DOCTYPE',$response);
										#$response_string	= trim(current($response_array));
										
										$this->sms_package_model->sms_log($data->user_id, $patient['id'], $data->id, $patient['mobile_number'], $data->communication_name, 
										$data->communication_type,$data->communication_run_type, $response);
										
										$this->sms_package_model->decrease_user_balance($data->user_id);
									}
									$this->sms_package_model->delete_communication_for_user($communication_name, $communication_type, $data->user_id,NULL,NULL);
								}
								else
								{
									#send message to doctor for insufficient of message balance script here
									$this->log_message($this->log_file,"sms balance less than patient list count with user_id : ".$data->user_id.NEW_LINE);
								}
							}
							else
							{
								#$this->log_message($this->log_file,"no patients available with user_id : ".$data->user_id." for occasion : ". $occasion_name . NEW_LINE);
							}
						}
					}
				}
			}
	}

	public function send_appointment_reminder_sms()
	{
		$date	= date("Y-m-d");	
		$communication_name	=	"appointment_reminder";
		$communication_type	=	"sms";
		$communication_run_type	=	"S";
		$sql	=	"SELECT patient_id,patient_name,patient_name,patient_gender,mobile_number,doc.name AS 'doctor_name',cli.name AS 'clinic_name',
		cli.address AS 'clinic_address',cli.contact_number AS 'clinic_contact_number',reason_for_visit,time,consultation_type 
		FROM appointment apt 
		INNER JOIN doctor doc ON apt.doctor_id=doc.id 
		INNER JOIN clinic cli ON apt.clinic_id=cli.id 
		WHERE apt.date = '".$date."' AND apt.status=1 AND apt.confirmation =1 order by apt.scheduled_time asc";
		$query	=	$this->db->query($sql);		
		$patient_list	=	$query->result_array();
		if($patient_list)
		{
			foreach($patient_list as $patient)
			{
					$sms_text			=	"Hi ".$patient['patient_name']." your appointment is scheduled today @ ".date("h:i a",strtotime($patient['time']))." with Dr. ".$patient['doctor_name']." at  ".$patient['clinic_name'].($patient['clinic_address']?", ".$patient['clinic_address']:"").($patient['clinic_contact_number']?" - ".$patient['clinic_contact_number']:"");
					$response					=	$this->sendsms_model->send_sms($patient['mobile_number'],urlencode($sms_text));				
					#$response_array		=	explode('<!DOCTYPE',$response);
					#$response_string	= trim(current($response_array));
					$this->sms_package_model->sms_log(NULL, $patient['patient_id'], NULL, $patient['mobile_number'], $communication_name, $communication_type,
					$communication_run_type, $response);
			}
		}
	}
	
	public function xml_to_json($string)
	{
		$fileContents = str_replace(array("\n", "\r", "\t"), '', $string);
		$fileContents = trim(str_replace('"', "'", $fileContents));
		$simpleXml = simplexml_load_string($fileContents);
		$json = json_encode($simpleXml);
		return $json;
	}
	
	function send_raw_sms_log()
	{
		$file	=	DOCUMENT_ROOT."logs/sms_file.lock";
		$file_exists	=	file_exists($file);
		if($file_exists	==	false)
		{
			$file_create = fopen($file, "w");
			if($file_create)
			{
				try
				{ 
					$sql	=	"SELECT id,message,mobile_number FROM raw_sms_log WHERE `status`=0";
					$query	=	$this->db->query($sql);		
					$raw_sms_list	=	$query->result_array();
					if($raw_sms_list)
					{
						foreach($raw_sms_list as $key=>$sms)
						{
							if(!empty($sms['mobile_number']) && !empty($sms['message']))
							{
								$url = "http://103.231.41.212/sendsms.jsp?user=sachinmishra&password=sachin12&mobiles=".$sms['mobile_number']."&sms=".$sms['message'];
								$curl= curl_init();
								curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
								curl_setopt($curl, CURLOPT_HEADER, false);
								curl_setopt($curl, CURLOPT_URL, $url);
								$response = curl_exec($curl);
								curl_close($curl);
								
								$response_string	=	$this->xml_to_json($response);
							}
							else
							{
								$response_string	=	json_encode(array("error"=>array("error-description"=>"no message or mobile_number avaialble")));
							}
							$update_sql	=	"update `raw_sms_log` set `response` = '".$response_string."', `status`	=	1,processed_on='".date("Y-m-d H:i:s")."' where id=".$sms['id'];
							$rs  = $this->db->query($update_sql);
						}
						fclose($file_create);
						unlink($file);
					}
					else
					{
						fclose($file_create);
						unlink($file);
					}
				}
				catch (Exception $e)
				{
					fclose($file_create);
					unlink($file);
				}
			}
		}
	}
	
	function change_workhr_status($status)
	{
		$sql	=	"update cdr_working_hour set is_working_hour=".$status;
		$rs  = $this->db->query($sql);
	}

	/* Email For feedback from confirmd appointment */
	function send_feedback_mail()
	{
		$start =  date("Y-m-d 00:00:00", strtotime("yesterday"));
		$end	 =  date("Y-m-d 23:59:59", strtotime("yesterday"));

		$sql = "SELECT appointment.doctor_id,appointment.patient_name,appointment.patient_email,doctor.name
FROM appointment JOIN doctor ON appointment.`doctor_id`=`doctor`.`id`
WHERE appointment.`status` = 1 AND appointment.`confirmation` = 1 AND appointment.`scheduled_time` BETWEEN '".$start."' AND '".$end."'";


		$query = $this->db->query($sql);
		$list = $query->result_array();
		if($list)
		{
			foreach ($list as $val) 
			{
				if(!empty($val["patient_email"]))
				{
					$mail_arr = array(
						'doctor_id'	=>	$val['doctor_id'],
						'doctor_name'	=>	$val['name'],
					);
					$mail_res = $this->mail_model->patient_appointment_feedback($val["patient_email"],$val["patient_name"],$mail_arr);
				}
			}
		}
	}
	
	function remove_speciality_city_mapping()
	{
		$file_log = DOCUMENT_ROOT."logs/remove_speciality_city_mapping.log";
		$this->log_file = fopen($file_log, "a+"); 

		$sql = "SELECT id,name FROM speciality where status in(1,2)";
		$query = $this->db->query($sql);
		$speciality_list = $query->result_array();
		if($speciality_list)
		{
			foreach ($speciality_list as $val) 
			{
				$sql = 'SELECT A.id,A.speciality_id,A.city_id FROM 
				(SELECT id,speciality_id,city_id FROM speciality_city_map WHERE speciality_id='.$val['id'].' and status=1)A 
				LEFT JOIN (SELECT COUNT(doctor.speciality) AS speciality_count ,clinic.city_id ,'.$val['id'].' AS speciality_id 
				FROM doctor JOIN clinic ON doctor.id=clinic.doctor_id 
				WHERE clinic.status=1 AND doctor.`status`=1  AND FIND_IN_SET("'.$val['id'].'",doctor.speciality) 
				GROUP BY  clinic.city_id)B  ON A.city_id=B.city_id 
				WHERE B.speciality_id IS NULL';
				$query = $this->db->query($sql);
				$speciality_count = $query->result_array();
				
				if($speciality_count)
				{
					foreach ($speciality_count as $val)
					{
						$sql = "update speciality_city_map set status=-1 where id=".$val['id']." and city_id=".$val['city_id']. " and speciality_id=".$val['speciality_id'];
						$this->log_message($this->log_file,$sql.NEW_LINE);
						$query = $this->db->query($sql);
					}
				}
			}
		}
	}
}