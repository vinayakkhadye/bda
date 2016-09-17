<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');

class favourite_doctor_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	function add($doctor_id,$patient_id)
	{
		$rs	=	false;
		if($doctor_id && $patient_id)
		{
			$a	=	 array('doctor_id'=>$doctor_id, 'patient_id'=>$patient_id );
			$rs = $this->db->insert('patient_favourite_doctor',$a);
			if($rs)
			{
				return $this->db->insert_id();
			}
		}
		return $rs; 
	}

	function delete($doctor_favourite_id,$doctor_id=NULL,$patient_id=NULL)
	{
		$rs	=	false;
		$where	=	 array();
		if(intval($doctor_favourite_id))
		{
			$where['id']	=	$doctor_favourite_id;
		}
		if(intval($doctor_id))
		{
			$where['doctor_id']	=	$doctor_id;
		}
		if(intval($patient_id))
		{
			$where['patient_id']	=	$patient_id;
		}

		if(sizeof($where)>0)
		{
			$rs = $this->db->delete('patient_favourite_doctor',$where);
			return $this->db->affected_rows();
		}
		
		return $rs; 
	}
	
	function get_list($patient_id,$a)
	{
		$rs	=	false;
		if($patient_id)
		{
			$this->filterData_active($a);
			$this->db->select('doctor.image,doctor.name,doctor.gender,doctor.speciality,patient_favourite_doctor.*');
			$this->db->from('patient_favourite_doctor');
			$this->db->join('doctor','doctor.id=patient_favourite_doctor.doctor_id');
			
			$this->db->where('patient_id', $patient_id);
			$query = $this->db->get();

			if($query->num_rows>0)
			{
				$this->row_count = $this->get_list_count($patient_id);
				$data	=	$query->result_array();
				foreach($data as $key=>$val)
				{
					$spe_query	=	$this->db->query("select group_concat(name  separator ', ') name from speciality where id in(".$val['speciality'].")");
					$spe_data	=	$spe_query->row_array();
					$data[$key]['speciality']	=	ucwords($spe_data['name']);
					$data[$key]['name']	=	"Dr. ".ucwords($val['name']);

					if(empty($val['image']))
					{
						if(strtolower($val['gender']) == "m")
						{
							$data[$key]['image']	= "./static/images/default_doctor.png";;
						}
						else if(strtolower($val['gender']) == "f")
						{
							$data[$key]['image'] = "./static/images/female_doctor.jpg";
						}
						else
						{
							$data[$key]['image']	= "./static/images/default_404.jpg";
						}
					}
				}
				return $data;
			}
		}
		return $rs; 
	}

	function get_list_count($patient_id)
	{
		$rs	=	false;
		if($patient_id)
		{
			$this->db->select('doctor.image,doctor.name,doctor.speciality,patient_favourite_doctor.patient_id,patient_favourite_doctor.doctor_id');
			$this->db->from('patient_favourite_doctor');
			$this->db->join('doctor','doctor.id=patient_favourite_doctor.doctor_id');
			
			$this->db->where('patient_id', $patient_id);
			return $this->db->count_all_results();
		}
		return $rs; 
	}
	
	function get_favourite_doctors($patient_id)
	{
		if($patient_id)
		{
			$this->db->select('id,doctor_id');
			$this->db->where('patient_id', $patient_id);
			$this->db->from('patient_favourite_doctor');
			$query = $this->db->get();
			if($query->num_rows>0)
			{
				foreach($query->result_array() as $key=>$val)
				{
					$data[$val['doctor_id']] 	=	$val['id'];
				}
				return $data;
			}
		}
		return false;
	}
	function __toString()
	{
		return (string)$this->db->last_query();
	}
	
}