<?php
if(!defined('BASEPATH')) exit('No direct access allowed');

class adminuser_model extends CI_Model
{	
	public function __construct()
	{
		parent::__construct();
	}

	function check_admin_login($username, $password)
	{
		$this->db->where('username', $username);
		$this->db->where('password', md5($password));
		$this->db->where('status', 1);
		$this->db->from('admin_user');
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			return $query->row();
		}
		else
		{
			return FALSE;
		}
	}
	
	function login_admin($details,$permissions)
	{
		$this->session->set_userdata('admin_id', $details->id);
		$this->session->set_userdata('admin_name', $details->name);
		$this->session->set_userdata('admin_user_type', $details->user_type);
		
		//Set user permissionss
		$allowed_perms	=	 array();
		$home_function	=	"";
		foreach($permissions as $per_key=>$per_val)
		{
				$allowed_perms[$per_val->id]=array('view'=>$per_val->view,'add'=>$per_val->add,'edit'=>$per_val->edit,'delete'=>$per_val->delete,'search'=>$per_val->search,'loginas'=>$per_val->loginas);
				if(empty($home_function) && $per_val->view==1)
				{
					$home_function	=	$this->get_url_from_function($per_val->id);
					$this->session->set_userdata('admin_home_url', $home_function);		
				}
		}

		$this->session->set_userdata('allowed_perms', $allowed_perms);
		#$this->session->set_userdata('allow_view', $details->allow_view);
		#$this->session->set_userdata('allow_add', $details->allow_add);
		#$this->session->set_userdata('allow_edit', $details->allow_edit);
		#$this->session->set_userdata('allow_delete', $details->allow_delete);
		#$this->session->set_userdata('allow_loginas', $details->allow_loginas);
		return $home_function;
	}
	function get_url_from_function($function)
	{
		switch($function)
		{
			case ADMIN_APPOINTMENTS:
						$url	=	"/bdabdabda/appointments/pending_appointment";
						break;
			case ADMIN_DOCTORS:
						$url	=	"/bdabdabda/manage_doctors";
						break;
			case ADMIN_REVIEWS:
						$url	=	"/bdabdabda/reviews";
						break;
			case ADMIN_PACKAGES:
						$url	=	"/bdabdabda/packages";
						break;
			case ADMIN_TRANSACTIONS:
						$url	=	"/bdabdabda/transactions";
						break;
			case ADMIN_MASTERS:
						$url	=	"/bdabdabda/masters/qualification";
						break;
			case ADMIN_IMPORT:
						$url	=	"/bdabdabda/import/doctor_data";
						break;
			case ADMIN_SETTINGS:
						$url	=	"/bdabdabda/setting/appointment_report";
						break;
			case ADMIN_ADVERTISE:
						$url	=	"/bdabdabda/advertisements";
						break;
			case ADMIN_KNOWLARITY:
						$url	=	"/bdabdabda/knowlarity/update_value";
						break;
			case ADMIN_USER:
						$url	=	"/bdabdabda/manage_adminusers";
						break;
			default:		
						$url	=	"/bdabdabda/appointments/pending_appointment";
						break;	
		}
		return $url;
	}
	function check_permission($admin_user_id,$function_id)
	{
		if($function_id && $admin_user_id)
		{
			$this->db->select('auf.id,auf.function_name,`view`,`add`,`edit`,`delete`,`loginas`,`search`');
			$this->db->from('admin_user_functions auf');
			$this->db->join('`admin_user_permissions` aup','auf.id=aup.admin_function_id AND admin_user_id='.$admin_user_id,'left');
			if($admin_user_id==1)
			{
				$this->db->where('auf.id', ADMIN_All_FUNCTIONS);
			}
			else
			{
				$this->db->where('auf.id', $function_id);
			}
			$query = $this->db->get();
			if($query->num_rows() > 0)
			{
				return $query->row();
			}
		}
		return FALSE;	
	}

	function get_permissions($admin_user_id)
	{
		if($admin_user_id)
		{
			$this->db->select('auf.id,auf.function_name,`view`,`add`,`edit`,`delete`,`loginas`,`search`');
			$this->db->from('admin_user_functions auf');
			$this->db->join('`admin_user_permissions` aup','auf.id=aup.admin_function_id AND admin_user_id='.$admin_user_id,'left');
			if($admin_user_id!=1)
			{
				$this->db->where('auf.id !=', ADMIN_All_FUNCTIONS);
			}

			$query = $this->db->get();
			if($query->num_rows() > 0)
			{
				return $query->result();
			}
		}
		return FALSE;	
	}
	function add_permissions($admin_user_id,$admin_function_id,$a=array())
	{
			$insert_permission_array	=	 array();
			$rs	=	false;
			$insert_main_array	=	array('admin_user_id'=>$admin_user_id,'admin_function_id'=>$admin_function_id);
			if(isset($a['view']))
			{
				$insert_permission_array['view']	=	$a['view'];
			}

			if(isset($a['add']))
			{
				$insert_permission_array['add']	=	$a['add'];
			}

			if(isset($a['edit']))
			{
				$insert_permission_array['edit']	=	$a['edit'];
			}

			if(isset($a['delete']))
			{
				$insert_permission_array['delete']	=	$a['delete'];
			}

			if(isset($a['loginas']))
			{
				$insert_permission_array['loginas']	=	$a['loginas'];
			}

			if(isset($a['search']))
			{
				$insert_permission_array['search']	=	$a['search'];
			}
			
			$insert_array	= array_merge($insert_main_array,$insert_permission_array);
			$insert_query = $this->db->insert_string('admin_user_permissions',$insert_array);
			if(sizeof($insert_permission_array)>0)
			{
				$insert_query	.= ' ON DUPLICATE KEY UPDATE ';
				foreach($insert_permission_array as $ins_key=>$ins_val)
				{
					$insert_query	.= "`".$ins_key."`='".$ins_val."',";
				}
				$insert_query	=	trim($insert_query,",");
			}
			$rs  = $this->db->query($insert_query);
			if($rs)
			{
				return $this->db->insert_id();
			}
			return false;	
	}
	function get_total_records_count($search = array())
	{
		if(isset($search['status']) && strlen($search['status']) > 0)
		{
			$this->db->where('status', $search['status']);
		}
		if(isset($search['record_name']) && !empty($search['record_name']))
		{
			$this->db->like('name', $search['record_name'], 'both');
		}
		$this->db->from('admin_user');
		return $this->db->count_all_results();
	}
	
	function get_adminusers_list($limit, $start, $search = array())
	{
		if(isset($search['status']) && strlen($search['status']) > 0)
		{
			$this->db->where('status', $search['status']);
		}
		if(isset($search['record_name']) && !empty($search['record_name']))
		{
			$this->db->like('name', $search['record_name'], 'both');
		}
		if(isset($search['record_username']) && !empty($search['record_username']))
		{
			$this->db->like('username', $search['record_username'], 'both');
		}
		
		$this->db->from('admin_user');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		//echo $this->db->last_query();
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return FALSE;	
		}
	}

	function update_status($status, $ids)
	{
		if(is_array($ids))
		{
			$this->db->where_in('id', $ids); //$ids should be an array
			$update = array('status'=> $status);
			$this->db->update('admin_user', $update);
		}
		return false;
	}
	
	function update_permission_byid($userid, $permissiontype, $status)
	{
		$data = array(
			$permissiontype => $status
		);
		$this->db->where('id', $userid);
		$this->db->update('admin_user', $data);
		echo $this->db->last_query();
	}
	
	function add_new_adminuser($postdata)
	{
		$data = array(
			'username'		=>	$postdata['username'],
			'password'		=>	md5($postdata['password']),
			'status'		=>	$postdata['status'],
			'user_type'		=>	'2',
			'created_on'=>	date('Y-m-d h:i:s')
			);
			
		$allow = array_keys($postdata['allow']);
		foreach($allow as $value)
		{
			$data[$value] = 1;
		}
		
		if(isset($postdata['name']) && !empty($postdata['name']))
		{
			$data['name'] = $postdata['name'];
		}
		if(isset($postdata['email']) && !empty($postdata['email']))
		{
			$data['email'] = $postdata['email'];
		}
		if(isset($postdata['mob']) && !empty($postdata['mob']))
		{
			$data['mob'] = $postdata['mob'];
		}
		
		$this->db->insert('admin_user', $data);
		//echo $this->db->last_query();
	}
	
	function edit_adminuser($postdata, $userid)
	{
		$data = array(
			'username'     =>	$postdata['username'],
			'status'       =>	$postdata['status'],
			'user_type'    =>	'2',
			'updated_on'   =>	date('Y-m-d h:i:s')
		);

		if(isset($postdata['name']) && !empty($postdata['name']))
		{
			$data['name'] = $postdata['name'];
		}
		if(isset($postdata['email']) && !empty($postdata['email']))
		{
			$data['email'] = $postdata['email'];
		}
		if(isset($postdata['mob']) && !empty($postdata['mob']))
		{
			$data['mob'] = $postdata['mob'];
		}
		if(isset($postdata['password']) && !empty($postdata['password']))
		{
			$data['password'] = md5($postdata['password']);
		}
		
		$this->db->where('id', $userid);
		$this->db->update('admin_user', $data);
		//echo $this->db->last_query();
	}
	
	function get_user_details($userid)
	{
		$this->db->from('admin_user');
		$this->db->where('id', $userid);
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			return $rs = $query->row();
		}
		else
		{
			return FALSE;
		}
	}
	
}