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
* @author		Anmol Mourya
* @link		http://philsturgeon.co.uk/code/
*/

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
set_time_limit(100000);
ini_set("memory_limit","2000M");

class insert_patient_from_mapping extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
	}
	public function log_message($myfile,$query)
	{
		fwrite($myfile, $query);
		return false;
	}
	
	function index()
	{
		$this->db->trans_start();

		$file_log = DOCUMENT_ROOT."logs/insert_patient_from_mapping.log";
		$this->log_file = fopen($file_log, "a+"); 
		
		$sql		=	"SELECT patient_id,COUNT(doctor_id) cnt,group_concat(doctor_id) doctor_id  FROM doctor_patient_map GROUP BY patient_id order by patient_id limit 50000";#HAVING cnt=1 LIMIT 1
		$query	=	$this->db->query($sql);
		$rs			=	$query->result_array();
		$this->log_message($this->log_file,"--------------------START---------------------".NEW_LINE);
		foreach($rs as $key=>$val)
		{
			if($val['cnt']	==	1)
			{
				$this->db->where('id',$val['patient_id']);
				$this->db->update('patient',array('doctor_id'=>$val['doctor_id']));
				if($this->db->affected_rows())
				{
					$this->log_message($this->log_file,"Single Patient Update ID : ".$val['patient_id'] .", Doctor ID : ".$val['doctor_id'].NEW_LINE);
				}
				else
				{
					$this->log_message($this->log_file,"Single Patient Not Update ID : ".$val['patient_id'] .", Doctor ID : ".$val['doctor_id'].NEW_LINE);
				}
				$this->log_message($this->log_file,$this->db->last_query().NEW_LINE);
				$this->log_message($this->log_file,"------".$key."-----".NEW_LINE);	
			}
			else if($val['cnt']	>	1)
			{
				$doctor_id_arr	=	explode(",",$val['doctor_id']);
				if(is_array($doctor_id_arr) && sizeof($doctor_id_arr)>0)
				{
					$this->db->where('id',$val['patient_id']);
					$select_query		=	$this->db->get('patient');
					$patient_rs			=	$select_query->row_array();
					$old_patient_id	=	$patient_rs['id'];
					if($old_patient_id)
					{
						unset($patient_rs['id'],$patient_rs['created_on'],$patient_rs['updated_on']);
						$this->log_message($this->log_file,"Old Patient ID : ".$old_patient_id.NEW_LINE);
						foreach($doctor_id_arr as $dcotor_val_id)
						{
							$patient_rs['doctor_id']	=	$dcotor_val_id;
							$insert_patient	=	$patient_rs;
							$this->db->insert('patient',$insert_patient);
							$new_patient_id	=	$this->db->insert_id();	
							if($new_patient_id)
							{
								$this->log_message($this->log_file,"New Patient Insert ID : ".$new_patient_id .", Doctor ID : ".$dcotor_val_id.NEW_LINE);
								$this->log_message($this->log_file,$this->db->last_query().NEW_LINE);
								$this->db->where('patient_id',$old_patient_id);
								$this->db->where('doctor_id',$dcotor_val_id);
								$this->db->update('appointment',array('patient_id'=>$new_patient_id));
								if($this->db->affected_rows())
								{
									$this->log_message($this->log_file,$this->db->last_query().NEW_LINE);
									$this->log_message($this->log_file,"Appointment Patient Update Old Patient ID : ".$old_patient_id .", New Patient ID : ".$new_patient_id.", Doctor ID : ".$dcotor_val_id.NEW_LINE);
								}
							}
						}
					}
				}
			$this->log_message($this->log_file,"------".$key."-----".NEW_LINE);	
			}
		}
		
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE)
		{
			$message	=	array("message"=>"Failed Transaction Status last error:". $this->db->_error_message(),"status"=>0);
		}
		else
		{
			$message	=	array("message"=>"Transaction Successful","status"=>1);
		}		
		$this->log_message($this->log_file,json_encode($message).NEW_LINE);
	}
}