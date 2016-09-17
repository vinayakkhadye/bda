<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Info extends CI_Controller {
	private $data = array();

	public function index()
	{	
		//print_r(geoip_record_by_name('php.net'));
		echo phpinfo();
		return false;
	}
}
/* End of file welcome.php */
/* Location: ./application/controllers/home.php */
