<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Example
 *
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array.
 *
 * @package		CodeIgniter
 * @subpackage	Rest Server
 * @category	Controller
 * @author		Phil Sturgeon
 * @link		http://philsturgeon.co.uk/code/
*/

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH.'/libraries/REST_Controller.php';

class Doctor extends REST_Controller
{
	function __construct()
    {
        parent::__construct();
		$this->load->model(array('doctor_model','common_model'));

    }
	function receipt_post(){
		$user_id = $this->post('user_id');
		$transaction = $this->transaction_model->last_transaction($user_id);
		if($transaction){
			$rs = array("transaction_data"=>$transaction,"message"=>"last transaction","status"=>1);
		}else{
			$rs = array("message"=>"no transactions","status"=>0);
		}
		$this->response(array("response"=>$rs), 200); // 200 being the HTTP response code
		
	}
    
}

