<?php
if(!defined('BASEPATH')) exit('Diect script access not allowed');

class adminsetting_model extends CI_Model
{
	public function __cinstruct()
	{
		parent:: __cinstruct();
	} 

	function report($data)
	{
		// SELECT COUNT(*) FROM appointment JOIN city ON appointment.city_id = city.id
		// JOIN doctor ON appointment.doctor_id = doctor.id
		// WHERE
		// doctor.speciality = "1" AND
		// city.name = "Mumbai" AND
		// DATE BETWEEN "2015-05-01" AND "2015-06-22" AND
		// appointment.status = 1;
		$this->db->select('`appointment`.`date`, `city`.`name`,`doctor`.`speciality`,`appointment`.`status`,`appointment`.`from_app`, count(*) as total_appointment');
		$this->db->from('appointment');

		 // $whereArray="";
		if(!empty($data['city'])){
		  if ($data['city'] != 'all'){ $whereArray['city.name'] = $data['city']; }
		}
		if(!empty($data['speciality']))
		{	
			if ($data['speciality'] != 'all'){ $whereArray['doctor.speciality'] = $data['speciality']; }
		}
	 if($data['status'] != 'both'){$whereArray['appointment.status'] = $data['status'];}

		if($data['from'] != 'all'){$whereArray['appointment.from_app'] = $data['from'];}

		$this->db->join('doctor','doctor.id = appointment.doctor_id');
		$this->db->join('city','city.id = appointment.city_id');		
		
		if(!empty($data['date_from']) && !empty($data['date_to']) )
		{
			$this->db->where("appointment.date between  '". $data['date_from'] ."'  and  '". $data['date_to']."'");
		}
		if(!empty($whereArray))
		{
		$this->db->where($whereArray);
		}

		$group_by_array = $data['group_by'];

		if(!empty($group_by_array))
		{
			
				$this->db->group_by($group_by_array); 

		 	
		}

		$query= $this->db->get();
		 // echo $this->db->last_query();
		 // echo $data['city'];
		 // echo $data['speciality'];
		 // echo $data['status'];
		 // echo $data['from'];
		if($query->num_rows() > 0)	
		{
			$rs= $query->result();
			return $rs;
		}
		else
		{
			return false;

		}

	}

	function city_list()
	{
		$this->db->select('*');
		$this->db->from('city'); 
		$this->db->where_in('status', array(1 ,2 ));
		$query= $this->db->get();
		if($query->num_rows() > 0)
		{
			$rs= $query->result();
			return $rs;
		}
		else
		{
			return false;
		} 
	}

	function speciality_list()
	{
		$this->db->select('*');
		$this->db->from('speciality');
		$this->db->where_in('status',array(1,2));
		$query= $this->db->get();
		if($query->num_rows() > 0)
		{
			$rs= $query->result();
			return $rs;
		}
		else
		{
			return false;

		}


	}

	function get_speciality_name(){

		$this->db->select('id, name');
		$this->db->from('speciality'); 
		$query = $this->db->get();
		if($query->num_rows()>0)
		{
			$rs= $query->result_array();
			return $rs;
		}
		else
		{
			return false;
		}


	}
	function __toString()
	{
		return (string)$this->db->last_query();
	}


} 