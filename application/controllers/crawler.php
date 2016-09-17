<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
set_time_limit(100000);
ini_set("memory_limit","2000M");
class Crawler extends CI_Controller {
	private $data = array();
	private $log_file = ""; 
	public function __construct(){
		parent::__construct();
		$this->data['class_name'] = $this->router->fetch_class();
		$this->load->model(array('clinic_model'));
		
	}
	public function practo_clinic(){
		$city_id = $this->input->get('city_id');
		$city_name = $this->input->get('city_name');
		$rs = $this->db->query("SELECT REPLACE(LOWER(cli.name),\" \",\"-\") as `clinic_name`,
		REPLACE(LOWER(lc.name),\" \",\"-\") as `clinic_location`,cli.address,cli.longitude,cli.latitude 
		FROM clinic AS cli INNER JOIN location lc ON cli.location_id=lc.id 	 WHERE 1 AND cli.city_id = '".$city_id."' LIMIT 1");
		
		$data = $rs->result_array();
		if(is_array($data)){
			foreach($data as $key=>$val){
				$file_url = "https://www.practo.com/".$city_name."/clinic/".$val['clinic_name']."-".$val['clinic_location'];
				$file_data = file_get_contents($file_url);
				print_r($file_data);
			}
		}
		
		
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/errors.php */