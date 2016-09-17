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

class scripts extends CI_Controller
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
	
	public function format_clinic_numbers()
	{
		$sql		=	 "SELECT clinic.id,clinic.name,clinic.contact_number FROM clinic  JOIN doctor ON clinic.doctor_id = doctor.id WHERE clinic.contact_number IS NOT NULL  AND clinic.contact_number<>'' AND clinic.status = 1 AND doctor.status = 1 and clinic.city_id!=7 and clinic.is_number_verified=1 and clinic.contact_number=clinic.contact_number_bck";
		$query	=	$this->db->query($sql);
		$list		=	$query->result_array();
		foreach($list as $key=>$val)
		{
			$contact_number_array	=	 array();
			$contact_number_string	=	 "";
			$update_number	=	TRUE;
			$contact_number	=	$val['contact_number'];
			$contact_number	=	 explode(",",str_replace(" ","",str_replace("/",",",str_replace("-","",$contact_number))));
			foreach($contact_number as $in=>$num)
			{
				$contact_number_array[$in]	=	"91".substr($num,-10);
				if(strlen($contact_number_array[$in])!=12)
				{
					unset($contact_number_array[$in]);
				}
			}
			if(sizeof($contact_number_array)>0)
			{
				$contact_number_string	=	 implode(',',$contact_number_array);
				echo $sql	=	 "update clinic set contact_number	=	'".$contact_number_string."' where id=".$val['id'].";";
				echo "<br/><br/>";
				$query	=	$this->db->query($sql);
								
			}
			else
			{
				echo ($key+1)." Not Updated : ".$val['contact_number']." ".$val['id']." ".$val['name']; 			
				echo "<br/><br/>";
			}			
		}
	}
	
	public function update_knowlarity_numbers()
	{
		$sql		=	 "SELECT clinic.id,clinic.knowlarity_number, clinic.knowlarity_extension FROM clinic  JOIN doctor ON clinic.doctor_id = doctor.id WHERE clinic.contact_number IS NOT NULL  AND clinic.contact_number<>'' AND clinic.status = 1 AND doctor.status = 1 and clinic.city_id!=7 and clinic.is_number_verified=1";
		$query	=	$this->db->query($sql);
		$list		=	$query->result_array();
		$extension	=	6656;
		foreach($list as $key=>$val)
		{
				#echo ($key+1).": "; 			
				echo $sql		=	 "update clinic set  knowlarity_number='+918286065646', knowlarity_extension='".$extension."' where id=".$val['id'].";";
				$extension++;
				echo "<br /><br />";
				$query	=	$this->db->query($sql);
			
		}
	}
}