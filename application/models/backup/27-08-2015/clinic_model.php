<?php
class clinic_model extends CI_Model {
	private $data = array();
	private $SQL ="";
	
	function getClinic($a=array()){
		$res = false;
		$a = $this->filterData($a);
		$this->SQL = $where = "";
		$where .=" where 1";
		
		if(!empty($a['exact_name'])  ){
			$where .=" AND name  = '".$a['exact_name']."'";
		}

		if(!empty($a['name'])  ){
			$where .=" AND name  like '%".$a['name']."%'";
		}
		if(!empty($a['city_id'])  ){
			$where .=" AND city_id  = '".$a['city_id']."'";
		}
		if(!empty($a['doctor_id'])  ){
			$where .=" AND doctor_id  = '".$a['doctor_id']."'";
		}
		if(!empty($a['location_id'])  ){
			$where .=" AND location_id  = '".$a['location_id']."'";
		}
		
		if(!empty($a['id'])  ){
			$where .=" AND id = ".$a['id'];
		}
		$this->SQL .= "select ".$a['column']." from clinic".$where.$this->groupby.$this->orderby.$this->limit;
		$query = $this->db->query($this->SQL);
		if($query->num_rows>0){
			foreach ($query->result_array() as $row){
				if(isset($a['idaskey'])){
				$res[$row['id']] =  $row;
				}else{
				$res[] =  $row;
				}
			}
		}
		return $res;
	}
	function getClinicScheduleByDoctorId($a=array()){
		$res = false;$whereArray = array();

		$this->filterData_active($a);
		$this->db->from('clinic as `cli`');
		#$this->db->join('`schedule` as `sc`', 'cli.id = sc.`clinic_id`');
		
		if(!empty($a['doctor_id'])){
			$whereArray['cli.doctor_id'] = $a['doctor_id'];
		}
		$whereArray['cli.status'] = 1;

		$this->db->where($whereArray);
		$query = $this->db->get();

		if($query->num_rows>0){
			foreach ($query->result_array() as $row){
				$res[] =  $row;
			}
		}
		return $res;
	}
	function insertClinic($a=array()){
		$rs = $this->db->insert('clinic',$a);
		if($rs){
			return $this->db->insert_id();
		}else{
			return false;
		}
	}
	function updateClinic($a=array(),$id){
		$this->db->where('id', $id);
		$rs = $this->db->update('clinic',$a);
		if($rs){
			return $this->db->affected_rows();
		}else{
			return false;
		}
	}
	
	function insertSchedule($a=array()){
		$rs = $this->db->insert('schedule',$a);
		if($rs){
			return $this->db->insert_id();
		}else{
			return false;
		}
	}

	function get_clinic_data($clinic_id)
	{
		$this->db->select('clinic.city_id, clinic.name, clinic.contact_number, clinic.address, location.name as location,clinic.knowlarity_number,clinic.knowlarity_extension');
		$this->db->from('clinic');
		$this->db->join('location', 'clinic.location_id = location.id','left');
		$this->db->where('clinic.id', $clinic_id);
		$query = $this->db->get();
		if($query->num_rows() >= 1)
		{
			return $query->row();
		}
		else
		{
			return FALSE;
		}
	}
	function get_clinic_formatted_time($timings)
	{
		$disptimings	= array();
		if(!empty($timings))
		{
			$timings = json_decode($timings,true);
			if(is_array($timings) && sizeof($timings)>0)
			{
				$day_array = array(1=>array(),2=>array(),3=>array(),4=>array(),5=>array(),6=>array(),0=>array());
				$weekday = array("0"=>"SUN","1"=>"MON","2"=>"TUE","3"=>"WED","4"=>"THU","5"=>"FRI","6"=>"SAT");
				
				$tmp_arr	= array();
				$new_day_array = array();
				$cnt = 0;
				
				foreach($timings as $dispKey=>$dispVal)
				{
					foreach($dispVal as $inDispKey=>$inDispVal)
					{
						if(!empty($inDispVal[0]) && !empty($inDispVal[1]))
						{
							if($inDispKey == 0)
							{
								$tmp_arr['time1'][$dispKey] = date("h:iA",strtotime($inDispVal[0]))."-".date("h:iA",strtotime($inDispVal[1]));
							}
							else if($inDispKey == 1)
							{
								$tmp_arr['time2'][$dispKey] = date("h:iA",strtotime($inDispVal[0]))."-".date("h:iA",strtotime($inDispVal[1]));
							}
						}
					}
				}
				
				foreach($day_array as $dayKey => $dayVal)
				{
					if(isset($tmp_arr['time1'][$dayKey]))
					{
						$new_day_array[$cnt]['day'] = $weekday[$dayKey];
						$new_day_array[$cnt]['time1'] = $tmp_arr['time1'][$dayKey];
					}
					if(isset($tmp_arr['time2'][$dayKey])){
						$new_day_array[$cnt]['day'] = $weekday[$dayKey];
						$new_day_array[$cnt]['time2'] = $tmp_arr['time2'][$dayKey];
					}
					if(isset($new_day_array[$cnt]) && sizeof($new_day_array[$cnt]) > 0)
					{
						$cnt ++;
					}
				}
			
				if(isset($new_day_array) && is_array($new_day_array))
				{
					$short_time	= array();
					foreach($new_day_array as $time_key=>$time_val)
					{
						if(isset($time_val['time1']) && isset($time_val['time2']))
						{
							$new_key	=	 $time_val['time1'].", ".$time_val['time2'];
						}
						else if(isset($time_val['time1']))
						{
							$new_key	=	 $time_val['time1'];
						}
						else if(isset($time_val['time2']))
						{
							$new_key	=	 $time_val['time2'];
						}
						else
						{
							continue;
						}	
						$short_time[$new_key][]	=	$time_val['day'];
					}
					foreach($short_time as $day_key=>$day_val)
					{
						$disptimings[]=	array('label'=>implode(", ",$day_val),'value'=>$day_key);
					}
					#$short_time = array_flip($short_time);
					#$disptimings = $short_time;
				}
					
			}
		}
		return $disptimings;
	}
	function get_clinic_formatted_separate_time($timings)
	{
		$new_day_array	= array();
		if(!empty($timings))
		{
			$timings = json_decode($timings,true);
			if(is_array($timings) && sizeof($timings)>0)
			{
				$day_array = array(1=>array(),2=>array(),3=>array(),4=>array(),5=>array(),6=>array(),0=>array());
				$weekday = array("0"=>"SUN","1"=>"MON","2"=>"TUE","3"=>"WED","4"=>"THU","5"=>"FRI","6"=>"SAT");
				$cnt = 0;
				foreach($timings as $dispKey=>$dispVal)
				{
					foreach($dispVal as $inDispKey=>$inDispVal)
					{
						if(!empty($inDispVal[0]) && !empty($inDispVal[1]))
						{
							if($inDispKey == 0)
							{
								$tmp_arr['time1'][$dispKey] = date("h:ia",strtotime($inDispVal[0]))."-".date("h:ia",strtotime($inDispVal[1]));
							}
							else if($inDispKey == 1)
							{
								$tmp_arr['time2'][$dispKey] = date("h:ia",strtotime($inDispVal[0]))."-".date("h:ia",strtotime($inDispVal[1]));
							}
						}
					}
				}
				foreach($day_array as $dayKey => $dayVal)
				{
					if(isset($tmp_arr['time1'][$dayKey]))
					{
						$new_day_array[$cnt]['day'] = $weekday[$dayKey];
						$new_day_array[$cnt]['time1'] = $tmp_arr['time1'][$dayKey];
					}
					if(isset($tmp_arr['time2'][$dayKey]))
					{
						$new_day_array[$cnt]['day'] = $weekday[$dayKey];
						$new_day_array[$cnt]['time2'] = $tmp_arr['time2'][$dayKey];
					}
					if(isset($new_day_array[$cnt]) && sizeof($new_day_array[$cnt]) > 0)
					{
						$cnt ++;
					}
				}
			}
		}
		return $new_day_array;
	}

	function get_clinic_time_bydate($timings,$date)
	{
		$new_day_array	= array();
		if(!empty($timings))
		{
			$cur_day	= strtoupper(date("w",strtotime($date)));

			$timings = json_decode($timings,true);
			if(is_array($timings) && sizeof($timings)>0)
			{
				$day_array = array(1=>array(),2=>array(),3=>array(),4=>array(),5=>array(),6=>array(),0=>array());
				$weekday = array("0"=>"SUN","1"=>"MON","2"=>"TUE","3"=>"WED","4"=>"THU","5"=>"FRI","6"=>"SAT");
				$cnt = 0;
				foreach($timings as $dispKey=>$dispVal)
				{
					if($dispKey==$cur_day)
					{
						foreach($dispVal as $inDispKey=>$inDispVal)
						{
							if(!empty($inDispVal[0]) && !empty($inDispVal[1]))
							{
								if($inDispKey == 0)
								{
									$tmp_arr['time1'][$dispKey] = date("h:ia",strtotime($inDispVal[0]))."-".date("h:ia",strtotime($inDispVal[1]));
								}
								else if($inDispKey == 1)
								{
									$tmp_arr['time2'][$dispKey] = date("h:ia",strtotime($inDispVal[0]))."-".date("h:ia",strtotime($inDispVal[1]));
								}
							}
						}
					}
				}
				foreach($day_array as $dayKey => $dayVal)
				{
					if(isset($tmp_arr['time1'][$dayKey]))
					{
						$new_day_array[$cnt]['day'] = $weekday[$dayKey];
						$new_day_array[$cnt]['time1'] = $tmp_arr['time1'][$dayKey];
					}
					if(isset($tmp_arr['time2'][$dayKey]))
					{
						$new_day_array[$cnt]['day'] = $weekday[$dayKey];
						$new_day_array[$cnt]['time2'] = $tmp_arr['time2'][$dayKey];
					}
					if(isset($new_day_array[$cnt]) && sizeof($new_day_array[$cnt]) > 0)
					{
						$cnt ++;
					}
				}
			}
		}
		return $new_day_array;
	}
	
	function get_clinic_half_time_format($timings)
	{
		
		$timings = json_decode($timings,true);

		if(is_array($timings) && sizeof($timings) > 0)
		{
			
			foreach($timings as $tKey=>$tVal)
			{
				if(is_array($tVal) && sizeof($tVal) > 0)
				{
					foreach($tVal as $tinKey=>$tinVal)
					{
						if($tinKey == 0)
						{
							$tmpName = "firsthalf";
						}
						else if($tinKey == 1)
						{
							$tmpName = "secondhalf";
						}
						else if($tinKey == 2)
						{
							$tmpName = "thirdhalf";
						}
						else if($tinKey == 4)
						{
							$tmpName = "fourthhalf";
						}
						
						$clinic[$tKey][$tmpName][0]		=	(!empty($tinVal[0]))?date("h:i a",strtotime($tinVal[0])):"";
						
						$clinic[$tKey][$tmpName][1]			=	(!empty($tinVal[1]))?date("h:i a",strtotime($tinVal[1])):"";
					}
				}
			}
		}
		if(isset($clinic)){
			return (object)$clinic;
		}
		return $clinic;
	}

	
	function __toString(){
		#return (string)$this->SQL;
		return (string)end($this->db->queries);
	}
}
?>