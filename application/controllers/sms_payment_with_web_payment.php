<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');

class sms_payment extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('doctor_model','user_model','transaction_model','common_model','sms_package_model','sendsms_model','mail_model'));
		include('Crypto.php');
		error_reporting(0);
	}

	function package($packageid = NULL)
	{

		/* user login check code begins */
		$session_userid   = $this->session->userdata('id');
		$session_usertype = $this->session->userdata('usertype');
		if(empty($session_userid)){
			redirect('/login', 'refresh');
			exit();
		}
		/* user login check code ends */

		if($packageid == NULL){
			redirect('/sms_payment/');
			exit();
		}
		else
		{
			$userid	= $this->session->userdata('id');

			$doc_details = $this->doctor_model->getDoctorById(array('user_id'=>$userid));
			$doc_details = current($doc_details);
			$doctor_city = $this->common_model->getCity(array('id'=>$doc_details['city_id'],'column'=>array('name','state_id')));
			$doctor_city = current($doctor_city);
			$doctor_state = $this->common_model->getState(array('id'=>$doctor_city['state_id'],'column'=>array('name')));
			$doctor_state = current($doctor_state);

			// Get package details
			$new_package_details = $this->sms_package_model->get_package_details($packageid);

			// Get user details
			$userdetails         = $this->user_model->get_all_userdetails($userid);
			
			if($new_package_details !== FALSE){
				// Initaite a transaction
				$package_type	=	2; # for sms packages
				$orderid = $this->transaction_model->initiate_transaction($userid, $packageid,$new_package_details->price,$package_type); // get order id
				#$this->sms_package_model->insert_user_balance($userid, $new_package_details->price); # remove it after this file is  live.
				$_POST['merchant_id'] = '40672';
				$_POST['order_id'] = $orderid;
				$_POST['amount'] = $new_package_details->price;
				$_POST['currency'] = 'INR';
				$_POST['redirect_url'] = 'https://www.bookdrappointment.com/sms_payment/paymentstatus';
				$_POST['cancel_url'] = 'https://www.bookdrappointment.com/sms_payment/paymentstatus';
				$_POST['language'] = 'EN';
				
				$_POST['billing_name'] = $userdetails->name;
				$_POST['billing_email'] = $userdetails->email_id;
				
				$_POST['billing_address'] = $doc_details['address'];
				$_POST['billing_zip'] = $doc_details['pincode'];
				
				$_POST['billing_city'] = $doctor_city['name'];
				$_POST['billing_state'] = $doctor_state['name'];
				
				$_POST['billing_country'] = "India";
				$_POST['billing_tel'] = $doc_details['contact_number'];
	
				$_POST['merchant_param1'] = $userid;
				$_POST['merchant_param2'] = $packageid;
				$_POST['merchant_param3'] = "userid : {$userid} brought package : {$packageid} package";
				$_POST['merchant_param4'] = $new_package_details->no_of_sms;
	
				$merchant_data = '';
				$working_key   = 'A66F48F857E7C70900DBD2F22DF0BFF3';//Shared by CCAVENUES
				$access_code   = 'AVGA01BG95BH46AGHB';//Shared by CCAVENUES
	
				foreach($_POST as $key => $value){
					$merchant_data .= $key.'='.$value.'&';
				}
				$encrypted_data = encrypt($merchant_data,$working_key); // Method for encrypting the data.
	
				$data['access_code'] = $access_code;
				$data['encrypted_data'] = $encrypted_data;
	
				$this->load->view('paymentprocess', isset($data) ? $data : NULL);
			}
		}
	}

	function paymentstatus()
	{
		/* user login check code begins */
		$session_userid   = $this->session->userdata('id');
		$session_usertype = $this->session->userdata('usertype');
		if(empty($session_userid)){
			redirect('/login', 'refresh');
			exit();
		}
		/* user login check code ends */


		$workingKey   = 'A66F48F857E7C70900DBD2F22DF0BFF3';		//Working Key should be provided here.
		$encResponse  = $_POST["encResp"];			//This is the response sent by the CCAvenue Server
		$rcvdString   = decrypt($encResponse,$workingKey);		//Crypto Decryption used as per the specified working key.
		$order_status = "";
		$decryptValues= explode('&', $rcvdString);
		$dataSize     = sizeof($decryptValues);

		// Get response in an array
		for($i = 0; $i < $dataSize; $i++){
			$information = explode('=',$decryptValues[$i]);
			//echo ' '.$information[0].' = '.$information[1].' < br > ';
			$response->$information[0] = $information[1];
		}
		#print_r($response);
		// Get order status
		for($i = 0; $i < $dataSize; $i++){
			$information = explode('=',$decryptValues[$i]);
			if($i == 3)
			$order_status = $information[1];
		}

		if($order_status === "Success"){
			//echo " < br > Success";
			$userid    = $response->merchant_param1;
			$packageid = $response->merchant_param2;
			$this->transaction_model->post_transaction($response);
			$this->sms_package_model->insert_user_balance($userid, $response->merchant_param4);
			redirect('/sms_payment/success');
		}
		else
		if($order_status === "Aborted"){
			//echo " < br > Aborted";
			$this->transaction_model->post_transaction($response);
			$this->session->set_flashdata('packageid', $response->merchant_param2);
			redirect('/sms_payment/failure');
		}
		else
		if($order_status === "Failure"){
			//echo " < br > Failure";
			$this->transaction_model->post_transaction($response);
			$this->session->set_flashdata('packageid', $response->merchant_param2);
			redirect('/sms_payment/failure');
		}
		else
		{
			echo "<br>Security Error. Illegal access detected";
		}
	}

	function app_api_package($packageid = NULL)
	{
		$userid    = $_GET['user_id'];

		/* user login check code begins */
		$session_userid   = $_GET['user_id'];
		$session_usertype = $_GET['usertype'];
		if(empty($session_userid)){
			redirect('/login', 'refresh');
			exit();
		}
		/* user login check code ends */

		if($packageid == NULL)
		{
			redirect('/sms_payment/');
			exit();
		}
		else
		{
		#$userid           = $this->session->userdata('id');

		$doc_details = $this->doctor_model->getDoctorById(array('user_id'=>$userid));

		$doc_details = current($doc_details);

		$doctor_city = $this->common_model->getCity(array('id'=>$doc_details['city_id'],'column'=>array('name','state_id')));
		
		$doctor_city = current($doctor_city);
		$doctor_state = $this->common_model->getState(array('id'=>$doctor_city['state_id'],'column'=>array('name')));
		$doctor_state = current($doctor_state);
		// Get package details
		$new_package_details = $this->sms_package_model->get_package_details($packageid);
		
		
		// Get user details
		$userdetails         = $this->user_model->get_all_userdetails($userid);
		
		if($new_package_details !== FALSE){
			
			// Initaite a transaction
			$package_type	=	2; # for sms packages
			$orderid = $this->transaction_model->initiate_transaction($userid, $packageid,$new_package_details->price,$package_type); // get order id
			$_POST['merchant_id'] = '40672';
			$_POST['order_id'] = $orderid;
			$_POST['amount'] = $new_package_details->price;
			$_POST['currency'] = 'INR';
			$_POST['redirect_url'] = 'https://www.bookdrappointment.com/sms_payment/app_api_paymentstatus';
			$_POST['cancel_url'] = 'https://www.bookdrappointment.com/sms_payment/app_api_paymentstatus';
			$_POST['language'] = 'EN';
			
			$_POST['billing_name'] = $userdetails->name;
			$_POST['billing_email'] = $userdetails->email_id;
			
			$_POST['billing_address'] = $doc_details['address'];
			$_POST['billing_zip'] = $doc_details['pincode'];
			
			$_POST['billing_city'] = $doctor_city['name'];
			$_POST['billing_state'] = $doctor_state['name'];
			
			$_POST['billing_country'] = "India";
			$_POST['billing_tel'] = $doc_details['contact_number'];

			$_POST['merchant_param1'] = $userid;
			$_POST['merchant_param2'] = $packageid;
			$_POST['merchant_param3'] = "userid : {$userid} brought package : {$packageid} package";
			$_POST['merchant_param4'] = $new_package_details->no_of_sms;

			$merchant_data = '';
			$working_key   = 'A66F48F857E7C70900DBD2F22DF0BFF3';//Shared by CCAVENUES
			$access_code   = 'AVGA01BG95BH46AGHB';//Shared by CCAVENUES
			foreach($_POST as $key => $value){
				$merchant_data .= $key.'='.$value.'&';
			}
			$encrypted_data = encrypt($merchant_data,$working_key); // Method for encrypting the data.

			$data['access_code'] = $access_code;
			$data['encrypted_data'] = $encrypted_data;

			$this->load->view('paymentprocess', isset($data) ? $data : NULL);
		}
			
		}
	}

	function app_api_paymentstatus()
	{

		$workingKey   = 'A66F48F857E7C70900DBD2F22DF0BFF3';		//Working Key should be provided here.
		$encResponse  = $_POST["encResp"];			//This is the response sent by the CCAvenue Server
		$rcvdString   = decrypt($encResponse,$workingKey);		//Crypto Decryption used as per the specified working key.
		$order_status = "";
		$decryptValues= explode('&', $rcvdString);
		$dataSize     = sizeof($decryptValues);

		// Get response in an array
		for($i = 0; $i < $dataSize; $i++){
			$information = explode('=',$decryptValues[$i]);
			//echo ' '.$information[0].' = '.$information[1].' < br > ';
			$response->$information[0] = $information[1];
		}
		#print_r($response);
		// Get order status
		for($i = 0; $i < $dataSize; $i++){
			$information = explode('=',$decryptValues[$i]);
			if($i == 3)
			$order_status = $information[1];
		}

		if($order_status === "Success"){
			//echo " < br > Success";
			$userid    = $response->merchant_param1;
			$packageid = $response->merchant_param2;
			$this->transaction_model->post_transaction($response);
			$this->sms_package_model->insert_user_balance($userid, $response->merchant_param4);
			redirect('/js_java_bridge.html?type=Success&package_id='.$packageid);
			exit;
		}
		else
		if($order_status === "Aborted"){
			//echo " < br > Aborted";
			$this->transaction_model->post_transaction($response);
			redirect('/js_java_bridge.html?type=Aborted&package_id='.$packageid);
			exit;

		}
		else
		if($order_status === "Failure"){
			//echo " < br > Failure";
			$this->transaction_model->post_transaction($response);
			redirect('/js_java_bridge.html?type=Failure&package_id='.$packageid);
			exit;
		}
		else
		{
			echo "<br>Security Error. Illegal access detected";
			redirect('/js_java_bridge.html?type=Illegal&package_id='.$packageid);
			exit;
		}
	}
}