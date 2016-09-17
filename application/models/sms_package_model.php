<?php
if(!defined('BASEPATH')) exit('No direct access allowed');

class sms_package_model extends CI_Model
{	
	public function __construct()
	{
		parent::__construct();
	}

	function get_sms_packages()
	{
		
		$this->db->select('sp.id,sp.name,sp.image,sp.no_of_sms,spr.price');
		$this->db->from('sms_packages sp');
		$this->db->join('sms_package_rates spr', 'sp.id=spr.sms_package_id');

		$this->db->where('sp.status', '1');
		$this->db->where('spr.status', '1');

		$query = $this->db->get();		
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		return FALSE;
	}
	
	function get_package_details($packageid)
	{
		if($packageid)
		{
			$this->db->select('sp.name,sp.no_of_sms,spr.price');
			$this->db->from('sms_packages sp');
			$this->db->join('sms_package_rates spr', 'sp.id=spr.sms_package_id');
			$this->db->where('sp.status', '1');
			$this->db->where('spr.status', '1');
			$this->db->where('sp.id', $packageid);
	
			$query = $this->db->get();		
			if($query->num_rows() > 0)
			{
				return $query->row();
			}
		}
		return FALSE;
	}
	function insert_user_balance($userid, $no_of_sms)
	{
		if($userid)
		{
			$a	=	array('user_id'=>$userid,'sms_balance'=>$no_of_sms,'total_sms'=>$no_of_sms,'created_on'=>date("Y-m-d H:i:s"));
			$insert_query = $this->db->insert_string('user_sms_balance',$a) . ' ON DUPLICATE KEY UPDATE sms_balance=sms_balance+'.$no_of_sms.', total_sms=total_sms+'.$no_of_sms;
			$rs           = $this->db->query($insert_query);
			if($rs)
			{
				return $this->db->insert_id();
			}
		}
		return false;
	}
	function decrease_user_balance($userid)
	{
		if($userid)
		{
			$this->db->where('user_id', $userid);
			$this->db->set('sms_balance', 'sms_balance-1', FALSE);
			$rs	=	$this->db->update('user_sms_balance');
			
			if($this->db->affected_rows() > 0)
			{
				return true;
			}
		}
		return false;
	}
	function get_user_packages($userid)
	{
		if($userid)
		{
			$this->db->select('id,total_sms,sms_balance');
			$this->db->from('user_sms_balance');
			$this->db->where('user_id', $userid);
			$query = $this->db->get();		

			if($query->num_rows() > 0)
			{
				return $query->row();
			}
		}
		return false;
	}
	
	function get_communication()
	{
		$this->db->select('id,name,sms,email,recipients,run_type');
		$this->db->from('communication_master');
		$query = $this->db->get();		
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		return false;
	}

	function get_festival_list($name='')
	{
		$this->db->select('name,date');
		$this->db->from('festival_list');
		if($name)
		{
			$this->db->where('name', $name);
		}
		$query = $this->db->get();		
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		return false;
	}
	
	function get_template_by_communication($communication_id, $communication_type,$occasion_name='')
	{
		if($communication_id && $communication_type)
		{
			$this->db->select('id,text,occasion_name');
			$this->db->from('communication_template');
			$this->db->where('communication_id', $communication_id);
			$this->db->where('type', $communication_type);
			if($occasion_name)
			{
				$this->db->where('occasion_name', $occasion_name);
			}

			$query = $this->db->get();		
			if($query->num_rows() > 0)
			{
				return $query->result();
			}
		}
		return false;
	}
	function check_communication_for_user_exists($communication_name,$communication_type,$user_id,$occasion_date=NULL,$occasion_name=NULL,$communication_run_type=NULL)
	{
		if($communication_name && $communication_type && $user_id)
		{
			$this->db->select('id');
			$this->db->from('communication_transaction');
			$this->db->where('communication_name', $communication_name);
			$this->db->where('communication_type', $communication_type);
			if($communication_run_type=="O")
			{
				$this->db->where('status', 1);
			}

			$this->db->where('user_id', $user_id);
			
			if($occasion_date)
			{
				$this->db->where('occasion_date', $occasion_date);
			}
			if($occasion_name)
			{
				$this->db->where('occasion_name', $occasion_name);
			}

			$query = $this->db->get();		
			if($query->num_rows() > 0)
			{
				return $query->row();
			}
		}
		return false;
	}
	function get_communication_for_user($user_id='',$communication_name='',$communication_type='',$communication_run_type='',$communication_recipients='',$occasion_name='',$health_checkup_days='')
	{
		$this->db->select('id,user_id,communication_name,communication_type,communication_text,communication_run_type,communication_recipients,health_checkup_days,occasion_name,occasion_date');

		$search_array['status']	=	1;
		if(!empty($user_id))
		{
			$search_array['user_id']	=	$user_id;
		}
		if(!empty($communication_name))
		{
			$search_array['communication_name']	=	$communication_name;
		}
		if(!empty($communication_type))
		{
			$search_array['communication_type']	=	$communication_type;
		}			
		if(!empty($communication_run_type))
		{
			$search_array['communication_run_type']	=	$communication_run_type;
		}			
		if(!empty($communication_recipients))
		{
			$search_array['communication_recipients']	=	$communication_recipients;
		}			
		if(!empty($occasion_name))
		{
			$search_array['occasion_name']	=	$occasion_name;
		}			
		
		if(isset($search_array) && sizeof($search_array)>0)
		{
			$query = $this->db->get_where('communication_transaction', $search_array);
			if($query->num_rows() > 0)
			{
				return $query->result();
			}
		}

	return false;
	}	
	
	function delete_communication_for_user($communication_name,$communication_type,$user_id,$health_checkup_days,$occasion_name)
	{
		if($communication_name && $communication_type && $user_id)
		{
			$this->db->where('communication_name', $communication_name);
			$this->db->where('communication_type', $communication_type);
			$this->db->where('user_id', $user_id);
			$this->db->where('status', 1);
			
			$this->db->where('health_checkup_days', $health_checkup_days);
			$this->db->where('occasion_name', $occasion_name);
			
			$data = array(
				'status'=>	-1
			);
			$this->db->update('communication_transaction', $data);
			if($this->db->affected_rows() > 0)
			{
				return $this->db->affected_rows();
			}
		}
		return false;
	}
	function active_communication_for_user($communication_trans_id,$communication_text,$communication_recipients,$health_checkup_days,$occasion_name,$occasion_date)
	{
		if($communication_trans_id)
		{
			$this->db->where('id', $communication_trans_id);
			$data = array(
				'communication_text'				=>	$communication_text,
				'communication_recipients'	=>	$communication_recipients,
				'health_checkup_days'				=>	$health_checkup_days,
				'occasion_name'							=>	$occasion_name,
				'occasion_date'							=>	$occasion_date,
				'status'										=>	1
			);
			$this->db->update('communication_transaction', $data);
			if($this->db->affected_rows() > 0)
			{
				return $this->db->affected_rows();
			}
		}
		return false;
	}

	function add_communication_for_user($communication_name,$communication_type,$user_id,$communication_text,$communication_run_type,$status,$communication_recipients,$health_checkup_days=NULL,$occasion_name=NULL,$occasion_date=NULL)
	{
		if($communication_name && $communication_type && $user_id && $communication_text && $communication_run_type && $status && $communication_recipients)
		{
			$data = array(
				'user_id'										=>	$user_id,
				'communication_name'				=>	$communication_name,
				'communication_type'				=>	$communication_type,
				'communication_text'				=>	$communication_text,
				'communication_run_type'		=>	$communication_run_type,
				'status'          					=>	$status,
				'communication_recipients'	=>	$communication_recipients,
				'health_checkup_days'				=>	$health_checkup_days,
				'occasion_name'							=>	$occasion_name,
				'occasion_date'							=>	$occasion_date
				
			);
	
			$this->db->insert('communication_transaction', $data);
			#echo $this->db->last_query();
			return $this->db->insert_id();
				
		}
		return false;
	}
	
	function get_communication_recipients_for_user($communication_id,$patient_id=0)
	{
		if($communication_id)
		{
			$this->db->select('id,communication_transaction_id');
			$this->db->from('communication_transaction_recipients');
			#$data['communication_transaction_id'] = $communication_id;
			$this->db->where_in('communication_transaction_id',$communication_id);
			if($patient_id)
			{
				#$data['patient_id'] = $patient_id;
				$this->db->where('patient_id',$patient_id);
			}
			$query	=	$this->db->get();
			if($query->num_rows() > 0)
			{
				return $query->result();
			}
		}
		return false;
	}	

	function add_communication_recipients_for_user($communication_id,$patient_id)
	{
		if($communication_id && $patient_id)
		{
			$data = array(
				'communication_transaction_id'	=>	$communication_id,
				'patient_id'										=>	$patient_id
			);
	
			$this->db->insert('communication_transaction_recipients', $data);
			#echo $this->db->last_query();
			return $this->db->insert_id();
		}
		return false;
	}
	
	function delete_communication_recipients_for_user($communication_id,$patient_id)
	{
		if($communication_id && $patient_id)
		{
			$data = array(
				'communication_transaction_id'	=>	$communication_id,
				'patient_id'										=>	$patient_id
			);
	
			$this->db->delete('communication_transaction_recipients', $data);
			#echo $this->db->last_query();
			return $this->db->affected_rows();
		}
		return false;
	}	
	function sms_log($user_id=NULL, $patient_id, $communication_id=NULL, $mobile_number, $communication_name, $communication_type, $communication_run_type, $sms_response)
	{
		if($patient_id && $mobile_number && $communication_name && $communication_type && $communication_run_type && $sms_response)
		{
			$data = array
			(
				'user_id'												=>	$user_id,
				'patient_id'										=>	$patient_id,
				'communication_transaction_id'	=>	$communication_id,
				'mobile_number'									=>	$mobile_number,
				'communication_name'						=>	$communication_name,
				'communication_type'						=>	$communication_type,
				'communication_run_type'				=>	$communication_run_type,
				'sms_response'									=>	$sms_response,
				'sent_date'											=>	date("Y-m-d H:i:s"),
			);
	
			$this->db->insert('sms_logs', $data);
			return $this->db->insert_id();
		}
		return false;
	}
	function get_doctor_reminder($doctor_id)
	{
		if($doctor_id)
		{
			$this->db->select('rdp.id,rdp.name,rdap.doctor_id');
			$this->db->from('reminder_doctor_appointment rdp');
			$this->db->join('reminder_doctor_appt_map rdap', 'rdp.id=rdap.reminder_doc_appt_id and rdap.doctor_id='.$doctor_id,'left');

			$query = $this->db->get();		
			if($query->num_rows() > 0)
			{
				return $query->result();
			}
		}
		return false;
	}
	function add_doctor_reminder($doctor_reminder_id, $doctor_id)
	{
		if($doctor_reminder_id && $doctor_id)
		{
			$a	=	array('doctor_id'=>$doctor_id,'reminder_doc_appt_id'=>$doctor_reminder_id);
			$insert_query = $this->db->insert_string('reminder_doctor_appt_map',$a);
			$insert_query = str_replace('INSERT INTO','INSERT IGNORE INTO',$insert_query);
			
			$rs           = $this->db->query($insert_query);
			if($rs)
			{
				return $this->db->insert_id();
			}
		}
		return false;
	}
	function delete_doctor_reminder($doctor_reminder_id, $doctor_id)
	{
		if($doctor_reminder_id && $doctor_id)
		{
			$a	=	array('doctor_id'=>$doctor_id,'reminder_doc_appt_id'=>$doctor_reminder_id);
			$this->db->delete('reminder_doctor_appt_map', $a);
			return $this->db->affected_rows();
		}
		return false;
	}	

	
	
	function __toString()
	{
		return (string)$this->db->last_query();
	}
}