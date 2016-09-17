<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * CodeIgniter Model Class
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/libraries/config.html
 */
class CI_Model {

	/**
	 * Constructor
	 *
	 * @access public
	 */
	 protected $limit ="";
	 protected $groupby ="";
	 protected $orderby ="";
	 protected $having ="";
	 protected $join ="";
	 public $row_count = 0;
	function __construct()
	{
		log_message('debug', "Model Class Initialized");
		$this->limit = $this->groupby  =$this->orderby =$this->having = $this->join  = "";
		$this->row_count =0;
	}

	/**
	 * __get
	 *
	 * Allows models to access CI's loaded classes using the same
	 * syntax as controllers.
	 *
	 * @param	string
	 * @access private
	 */
	function __get($key)
	{
		$CI =& get_instance();
		return $CI->$key;
	}
	function filterData($a=array()){
		$this->limit = $this->groupby  =$this->orderby =$this->having = $this->join  = "";
		if(isset($a['column']) && is_array($a['column']) && sizeof($a['column'])>0){
			$a['column'] = ''.implode(',',$a['column']).'';
		}else{
			$a['column'] = '*';
		}
		if(isset($a['limit']) && isset($a['offset']))
		{
			$this->limit = " LIMIT ".$a['offset'].", ".$a['limit'];
		}else if(isset($a['limit']))
		{
			$this->limit = " LIMIT ".$a['limit'];
		}
		if(isset($a['groupby'])){
			if(is_array($a['groupby'])){
				foreach($a['groupby'] as $key=>$val){
					$this->groupby .= $val;
				}
			}else{
				$this->groupby = $a['groupby'];
			}
			$this->groupby = " GROUP BY ".$a['groupby'];
		}
		if(isset($a['orderby'])){
			if(is_array($a['orderby'])){
				foreach($a['orderby'] as $key=>$val){
					$this->orderby .= $val;
				}
			}else{
				$this->orderby = $a['orderby'];
			}
			$this->orderby = " ORDER BY ".$a['orderby'];
		}
		if(isset($a['having'])){
			$this->having = " HAVING ".$val;
		}
		return $a;
	}
	
	function filterData_active($a=array()){
		$this->limit = $this->groupby  =$this->orderby =$this->having = $this->join  = "";
		if(isset($a['column']) && is_array($a['column']) && sizeof($a['column'])>0){
			$a['column'] = ''.implode(',',$a['column']).'';
			$this->db->select($a['column']);
		}
		if(isset($a['limit']) && isset($a['offset'])){
			$this->db->limit($a['limit'], $a['offset']);
		}else if(isset($a['limit'])){
			$this->db->limit($a['limit']);
		}
		
		if(isset($a['groupby'])){
			if(is_array($a['groupby'])){
				$this->db->group_by($a['groupby']); 
			}else{
				$this->db->group_by($a['groupby']); 
				
			}
		}
		if(isset($a['orderby'])){
			if(is_array($a['orderby'])){
				$a['orderby'] = implode(',',$a['orderby']);
				$this->db->order_by($a['orderby']); 
			}else{
				$this->db->order_by($a['orderby']); 
			}
		}
		if(isset($a['having'])){
			if(is_array($a['having'])){
				$this->db->having($a['having']); 
			}else{
				$this->db->having($a['having']); 
				
			}
		}
	}
}
// END Model Class

/* End of file Model.php */
/* Location: ./system/core/Model.php */