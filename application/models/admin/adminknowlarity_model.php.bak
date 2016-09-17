<?php

if(!defined('BASEPATH')) exit('Direct script access not allowed');

class adminknowlarity_model extends CI_Model
{
	public function __constrcut()
	{
		parent:: __constrcut();
	}

	function update_status($status)
	{
		
			$this->db->where('id','1');
			$update=array('is_working_hour'=>$status);
			$this->db->update('cdr_working_hour',$update);
		
		return false;

	}

	function current_status()
	{
				

		$this->db->select('is_working_hour'); 

   	 	$this->db->from('cdr_working_hour');

    	$this->db->where('id', 1 );

    	$query = $this->db->get();
    	if ($query->num_rows() > 0) {
            $rs = $query->row_array();
            
            //print_r($rs);
            return $rs;
        } else {
            return FALSE;
        }
     	
     	
	}

	function view_data($limit,$offset)
	{				
		
		 $this->db->select('cdr_details.*'); 
   	 	$this->db->from('cdr_details');
   	 	$this->db->order_by('id','desc');
   	 	$this->db->limit($limit,$offset);
			
    	$query = $this->db->get();
    	if ($query->num_rows() > 0) {
            $rs = $query->result();
        } 
        return $rs; 
     	
	}

	function view_data_count()
	{				
		
		 // $this->db->select('cdr_details.*'); 
   	 	$this->db->from('cdr_details');

   	 	// $this->db->limit($limit,$offset);
    	$count = $this->db->count_all_results();
    	 
        return $count; 
     	
	}


	function max_id_call_record()
	{
			$this->db->select_max('id'); 
			$query = $this->db->get('cdr_details');
			
			 //$query = $this->db->get();
			if ($query->num_rows() > 0) {
					return   $query->row();
			 } 
			 else
			 {

					return  FALSE;
			 }
				//$rs = $query->result();
		 // return   $query->row();
			// return   $rs;
		}

	public function new_row_call_record($max_call_record)
	{
		$this->db->select('cdr_details.*'); 
		$this->db->from('cdr_details');
		$this->db->where('id >', $max_call_record);
		
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$rs = $query->result();
			return $rs;
		}else{
			return FALSE;
		} 
	}

	function caller_info_details($limit,$offset)
	{	
		 $this->db->select('cdr_caller_info.*'); 
   	 	$this->db->from('cdr_caller_info'); 
   	 	 $this->db->limit($limit,$offset);
			 $this->db->order_by('id','desc');
    	$query = $this->db->get();
    	if ($query->num_rows() > 0) {
            $rs = $query->result();
        } 
        return $rs; 
   	}

   	function caller_info_details_count()
	{	
		 // $this->db->select('cdr_caller_info.*'); 
   	 	$this->db->from('cdr_caller_info'); 
   	 	 $count = $this->db->count_all_results();
    	// $query = $this->db->get();
    	// if ($query->num_rows() > 0) {
     //        $rs = $query->result();
     //    } 
        return $count; 
   	}

	function add_agent($name,$number)
	{
		if($name && $number)
		{
			$insert['name']	=	$name;
			$insert['number']	=	$number;
			$insert['status']	=	1;
			$insert['isbusy']	=	0;
			$this->db->insert('agents',$insert);
			if($this->db->affected_rows()>0)
			{
				return $this->db->insert_id();
			}
		}
		return false;
	}

	function edit_agent($id,$name='',$number='',$busy=0,$status=0)
	{
		if($id)
		{
			if($name)
			{
				$update['name']	=	$name;
			}
			if($number)
			{
				$update['number']	=	$number;
			}
			if(is_numeric($busy) && strlen($busy)>0)
			{
				$update['isbusy']	=	$busy;
			}
			if(is_numeric($status) && strlen($status)>0)
			{
				$update['status']	=	$status;
			}
			if(isset($update) && is_array($update) && sizeof($update)>0)
			{
				$this->db->update('agents',$update,array('id'=>$id));
			}
			
			if($this->db->affected_rows()>0)
			{
				return true;
			}
		}
		return false;
	}

	function agents($limit,$offset,$id=0)
	{	
		 $this->db->select('agents.*'); 
   	 	$this->db->from('agents'); 
			if($id)
			{
				$this->db->where('id',$id); 
			}
   	 	 $this->db->limit($limit,$offset);
			 $this->db->order_by('status','desc');
    	$query = $this->db->get();
    	if ($query->num_rows() > 0) {
            $rs = $query->result();
        } 
        return $rs; 
   	}

 	function agents_count()
	{	
		$this->db->from('agents'); 
		$count = $this->db->count_all_results();
		return $count; 
   	}

   	function max_id_caller_info()
	{
			$this->db->select_max('id'); 
			$query = $this->db->get('cdr_caller_info');
			
			 //$query = $this->db->get();
			if ($query->num_rows() > 0) {
					return   $query->row();
			 } 
			 else
			 {

					return  FALSE;
			 }
				//$rs = $query->result();
		 // return   $query->row();
			// return   $rs;
		}

	public function new_row_caller_info($max_caller_info)
	{
		$this->db->select('cdr_caller_info.*'); 
		$this->db->from('cdr_caller_info');
		$this->db->where('id >', $max_caller_info);

		
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$rs = $query->result();
			return $rs;
		}else{
			return FALSE;
		} 
	}
 function __toString()
 	{
		return $this->db->last_query();
	}  


}