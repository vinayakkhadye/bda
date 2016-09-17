<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');

class transaction_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	function initiate_transaction($userid, $packageid, $amount,$package_type=1)
	{
		$data2 = array(
			'user_id'               =>	$userid,
			'package_id'            =>	$packageid,
			'amount'                =>	$amount,
			'transaction_started_on'=>	date('Y-m-d H:i:s'),
			'package_type'					=>	$package_type
		);
		$this->db->insert('transactions', $data2);
		$orderid = $this->db->insert_id();

		$data3   = array(
			'order_id'=>	$orderid
		);
		$this->db->insert('transactions_extradetails', $data3);
		return $orderid;
	}

	function post_transaction($response)
	{
		//print_r($response);
		$data = array(
			'package_id'          =>	!empty($response->merchant_param2) ? $response->merchant_param2 : NULL,
			'tracking_id'         =>	!empty($response->tracking_id) ? $response->tracking_id : NULL,
			'bank_ref_no'         =>	!empty($response->bank_ref_no) ? $response->bank_ref_no : NULL,
			'order_status'        =>	!empty($response->order_status) ? $response->order_status : NULL,
			'failure_message'     =>	!empty($response->failure_message) ? $response->failure_message : NULL,
			'payment_mode'        =>	!empty($response->payment_mode) ? $response->payment_mode : NULL,
			'card_name'           =>	!empty($response->card_name) ? $response->card_name : NULL,
			'status_code'         =>	!empty($response->status_code) ? $response->status_code : NULL,
			'status_message'      =>	!empty($response->status_message) ? $response->status_message : NULL,
			'amount'              =>	!empty($response->amount) ? $response->amount : NULL,
			'transaction_ended_on'=>	date('Y-m-d H:i:s')
		);
		$this->db->where('user_id', $response->merchant_param1);
		$this->db->where('order_id', $response->order_id);
		$this->db->update('transactions', $data);
		//echo $this->db->last_query();

		$data2 = array(
			'billing_name'    =>	!empty($response->billing_name) ? $response->billing_name : NULL,
			'billing_address' =>	!empty($response->billing_address) ? $response->billing_address : NULL,
			'billing_city'    =>	!empty($response->billing_city) ? $response->billing_city : NULL,
			'billing_state'   =>	!empty($response->billing_state) ? $response->billing_state : NULL,
			'billing_zip'     =>	!empty($response->billing_zip) ? $response->billing_zip : NULL,
			'billing_country' =>	!empty($response->billing_country) ? $response->billing_country : NULL,
			'billing_tel'     =>	!empty($response->billing_tel) ? $response->billing_tel : NULL,
			'billing_email'   =>	!empty($response->billing_email) ? $response->billing_email : NULL,
			'delivery_name'   =>	!empty($response->delivery_name) ? $response->delivery_name : NULL,
			'delivery_address'=>	!empty($response->delivery_address) ? $response->delivery_address : NULL,
			'delivery_city'   =>	!empty($response->delivery_city) ? $response->delivery_city : NULL,
			'delivery_state'  =>	!empty($response->delivery_state) ? $response->delivery_state : NULL,
			'delivery_zip'    =>	!empty($response->delivery_zip) ? $response->delivery_zip : NULL,
			'delivery_country'=>	!empty($response->delivery_country) ? $response->delivery_country : NULL,
			'delivery_tel'    =>	!empty($response->delivery_tel) ? $response->delivery_tel : NULL
		);
		$this->db->where('order_id', $response->order_id);
		$this->db->update('transactions_extradetails', $data2);
		
		//print_r($data);
		//echo '<br><br>';
		//print_r($data2);
	}

	function last_transaction($user_id){
		$this->db->order_by('id','desc');
		$this->db->limit(1);
		$this->db->where('user_id', $user_id);
		$query = $this->db->get('transactions');
	}
}