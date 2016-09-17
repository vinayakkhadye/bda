<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');

class hospital_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->model(array('mail_model','sendsms_model'));
	}
	
	function add_hospital($a=array())
	{
		$this->db->insert('hospital',$a);
		return $this->db->insert_id();
	}
	
	function get_hosptial_data($a=array())
	{
		if(isset($a['user_id']) && !empty($a['user_id']))
		{
			$this->db->where('user_id',$a['user_id']);
		}
		if(isset($a['id']) && !empty($a['id']))
		{
			$this->db->where('id',$a['id']);
		}
		$this->db->limit(1);
		$query = $this->db->get('hospital');
		return $query->row();
	}
	
	function update_hospital($userid,$data)
	{
		
		$this->db->where('user_id', $userid);
		$this->db->update('hospital', $data);
		#echo $this->db->last_query();exit;
		return $this->db->affected_rows();	
	}

	function get_doctor_by_hospital_id($a=array())
	{
		$res	=	 false;
		if($a['hospital_id'])
		{
			$this->db->select('doctor.speciality, doctor.name, doctor.contact_number, doctor.id, doctor.user_id, clinic.timings');
			$this->db->from('doctor');
			$this->db->join('clinic', 'clinic.doctor_id = doctor.id');
			$this->db->where('doctor.hospital_id',$a['hospital_id']);
			$query = $this->db->get();

			if($query->num_rows>0)
			{
				foreach ($query->result_array() as $key=>$row)
				{
					if(isset($a['id_as_key']))
					{
						$res[$row['id']] =  $row;	
					}
					else
					{
						$res[$key] =  $row;
					}
				}
			}
		}
		return $res;	
	}

	function add_user($a)
	{
		$this->db->insert('user',$a);
		return $this->db->insert_id();
	}		
	
	function get_user_data($user_id)
	{
		if($user_id)
		{
			$this->db->where('id',$user_id);
			$this->db->limit(1);
			$query = $this->db->get('user');
			return $query->row();
		}
		return false;	
	}
	
	function get_doctor_data($doctor_id)
	{
		if($doctor_id)
		{
			$this->db->where('id',$doctor_id);
			$this->db->limit(1);
			$query = $this->db->get('doctor');
			return $query->row();
		}
		return false;	
	}
	
	function get_clinic_data($doctor_id,$hospital_id)
	{
		if($doctor_id && $hospital_id)
		{
			$this->db->where('doctor_id',$doctor_id);
			$this->db->where('hospital_id',$hospital_id);
			$this->db->limit(1);
			$query = $this->db->get('clinic');
			return $query->row();
		}
		return false;	
	}

	
	function add_clinic($a)
	{
		$this->db->insert('clinic',$a);
		return $this->db->insert_id();
	}		
	function add_doctor($a)
	{
		$this->db->insert('doctor',$a);
		return $this->db->insert_id();
	}		

	function update_user($id,$a=array())
	{
		if($id)
		{
			$set	=	 $a;
			$this->db->where('id',$id);
			$this->db->update('user',$set);
			return $this->db->affected_rows();
		}
		return false;
	}

	function update_doctor($id,$a=array())
	{
		if($id)
		{
			$set	=	 $a;
			$this->db->where('id',$id);
			$this->db->update('doctor',$set);
			return $this->db->affected_rows();
		}
		return false;
	}
	
	function update_clinic($id,$a=array())
	{
		if($id)
		{
			$set	=	 $a;
			$this->db->where('id',$id);
			$this->db->update('clinic',$set);
			return $this->db->affected_rows();
		}
		return false;
	}
	function get_all_doctors_json($hospital_id,$a=array())
	{
		$this->db->select('doctor.id as doctor_id,doctor.user_id as user_id, doctor.name as doctor_name, clinic.id as clinic_id, doctor.name as clinic_name, clinic.duration, clinic.address, clinic.contact_number as clinic_contact_number, clinic.knowlarity_number, clinic.knowlarity_extension');
		$this->db->from('doctor');
		$this->db->join('clinic', 'clinic.doctor_id = doctor.id');
		$this->db->order_by('doctor.created_on');
		$this->db->where('doctor.hospital_id', $hospital_id);
		$this->db->where('clinic.hospital_id', $hospital_id);
		$data = $row_data	=	array();
		$i = 0;
		$query = $this->db->get();

		if(isset($a['id_as_key']))
		{
			if($query->num_rows>0)
			{
				$data	=	$query->result_array();
				foreach($data as $row)
				{
					$row_data[$row['doctor_id']]	=	$row;
				}
			}
			return $row_data;
		}
		else
		{
			return $query->result_array();
		}
	}
	function deletehospitalphoto($hospitalid,$photoid)
	{
		$photoid = $photoid - 1;
		$check = $this->get_hospital_photos($hospitalid);
		if($check !== FALSE)
		{
			$images = $check->clinic_images;
			$imagearray = explode(',', $images);
			unlink($imagearray[$photoid]); //deletes image from system
			
			$imagearray[$photoid] = '';
			$newimagearray = implode(',', $imagearray);
			$newimagearray = trim($newimagearray);
			$imagedata = array(
				'clinic_images'	=>	$newimagearray
			);

			$this->db->where('id', $hospitalid);
			$this->db->update('hospital', $imagedata);
			echo $this->db->last_query();
		}
	}
	
	function get_hospital_photos($hospitalid)
	{
		$query = $this->db->get_where('hospital', array('id' => $hospitalid));
		if($query->num_rows() > 0)
		{
			return $query->row();
		}
		else
		{
			return FALSE;
		}
	}
	
	function __toString()
	{
		return (string)$this->db->last_query();
	}
}