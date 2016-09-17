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
	function __construct()
	{
		parent::__construct();
		$this->load->model('sms_package_model');
	}

	/* this metho will be used to send sms by cron to pateints on birthday and general health check up*/
	public function send_reminders_sms($communication_name)
	{
			$this->load->model(array('doctor_model','patient_model'));		
			$communication_type			=	'sms';	
			$communication_run_type	=	'S';	
			if(empty($communication_name))
			{
				return false;
			}
			$communication_data = $this->sms_package_model->get_communication_for_user('',$communication_name,$communication_type,$communication_run_type,'');
			foreach($communication_data as $data)
			{
				if($data->communication_name	==	'birthday')
				{
					echo "birthday running";
					$doctor =	$this->doctor_model->get_doctor_id($data->user_id);
					$query	=	$this->db->query("SELECT p.id,p.name,p.mobile_number,p.dob 
																			FROM (`patient` AS p) 
																			LEFT JOIN `appointment` apt ON `apt`.`patient_id` = `p`.`id` 
																			LEFT JOIN `doctor_patient_map` dpm ON `p`.`id`= `dpm`.`patient_id` 
																			WHERE (apt.doctor_id='".$doctor->id."' OR dpm.doctor_id='".$doctor->id."') 
																			AND `p`.`status` =  1 and p.dob	=	'".date("Y-m-d")."'
																			GROUP BY `p`.`id`");
					
					$patient_list	=	$query->result_array();
					foreach($patient_list as $patient)
					{
						$sms_text	=	$data->communication_text;
						$sms_text	=	str_replace("{patient_name}",$patient['name'],$sms_text);
						$sms_text	=	str_replace("{doctor_name}",$doctor->name,$sms_text);
						
						$response					=	$this->sendsms_model->send_sms($patient['mobile_number'],urlencode($sms_text));				
						$response_array		=	explode('<!DOCTYPE',$response);
						$response_string	= trim(current($response_array));
						
						$this->sms_package_model->sms_log($data->user_id, $patient['id'], $data->id, $patient['mobile_number'], $data->communication_name, 
						$data->communication_type, $data->communication_run_type, $response_string);
						
						$this->sms_package_model->decrease_user_balance($data->user_id);
					}
				}
        else if($data->communication_name	==	'general_health_check_up')
        {
					$recipients_data	=	$this->sms_package_model->get_communication_recipients_for_user($data->id);
					if($recipients_data)
					{
						$doctor		=	$this->doctor_model->get_doctor_id($data->user_id);        
						$date			= date("Y-m-d",strtotime("-".$data->health_checkup_days." days"));	
						
						$query	=	$this->db->query("SELECT patient_id,patient_name,patient_gender,mobile_number FROM appointment WHERE doctor_id=".$doctor->id." AND STATUS=1 AND confirmation=1 AND date='".$date."' and patient_id in (".$recipients_data->patient_id.")");
						$patient_list	=	$query->result_array();
						foreach($patient_list as $patient)
						{
							$sms_text	=	$data->communication_text;
							
							$sms_text	=	str_replace("{patient_name}",$patient['patient_name'],$sms_text);
							$sms_text	=	str_replace("{doctor_name}",$doctor->name,$sms_text);
							
							$response					=	$this->sendsms_model->send_sms($patient['mobile_number'],urlencode($sms_text));				
							$response_array		=	explode('<!DOCTYPE',$response);
							$response_string	= trim(current($response_array));
							
							
							$this->sms_package_model->sms_log($data->user_id, $patient['patient_id'], $data->id, $patient['mobile_number'], $data->communication_name, $data->communication_type, 
							$data->communication_run_type, $response_string);
							
							$this->sms_package_model->decrease_user_balance($data->user_id);
						}
					
					}
        }
        else if($data->communication_name=='occasions' && $data->occasion_date==date("Y-m-d"))
        {
					$recipients_data	=	$this->sms_package_model->get_communication_recipients_for_user($data->id);
					if($recipients_data)
					{
						$doctor					=	$this->doctor_model->get_doctor_id($data->user_id);        
						$occasion_name	= $data->occasion_name;	
						
						$query					=	$this->db->query("SELECT id,name,mobile_number FROM patient WHERE id in (".$recipients_data->patient_id.")");
						$patient_list		=	$query->result_array();
						foreach($patient_list as $patient)
						{
							$sms_text			=	$data->communication_text;
							$sms_text			=	str_replace("{patient_name}",$patient['name'],$sms_text);
							$sms_text			=	str_replace("{doctor_name}",$doctor->name,$sms_text);

							$response					=	$this->sendsms_model->send_sms($patient['mobile_number'],urlencode($sms_text));				
							$response_array		=	explode('<!DOCTYPE',$response);
							$response_string	= trim(current($response_array));
							
							$this->sms_package_model->sms_log($data->user_id, $patient['id'], $data->id, $patient['mobile_number'], $data->communication_name, $data->communication_type,$data->communication_run_type, $response_string);
							
							$this->sms_package_model->decrease_user_balance($data->user_id);
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
		WHERE apt.date='".$date."' AND apt.status=1 AND apt.confirmation =1";
		$query	=	$this->db->query($sql);		
		$patient_list	=	$query->result_array();
		if($patient_list)
		{
			foreach($patient_list as $patient)
			{
					$sms_text			=	"Hi ".$patient['patient_name']." you appointment is scheduled today @ ".date("h:i a",strtotime($patient['time']))." with Dr. ".$patient['doctor_name']." at  ".$patient['clinic_name'].($patient['clinic_address']?", ".$patient['clinic_address']:"").($patient['clinic_contact_number']?" - ".$patient['clinic_contact_number']:"");
					$response					=	$this->sendsms_model->send_sms($patient['mobile_number'],urlencode($sms_text));				
					$response_array		=	explode('<!DOCTYPE',$response);
					$response_string	= trim(current($response_array));
					$this->sms_package_model->sms_log(NULL, $patient['patient_id'], NULL, $patient['mobile_number'], $communication_name, $communication_type,
					$communication_run_type, $response_string);
				
			}
		}
	}
}