<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');

class Payment extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('doctor_model','user_model','transaction_model','common_model'));

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
			redirect('/doctor/packages');
			exit();
		}
		else
		{
			$userid           = $this->session->userdata('id');

			$package_exist    = $this->doctor_model->check_packageid_exist($packageid);
			$package_eligible = $this->doctor_model->check_doctor_package_eligibility($userid, $packageid);
			//			var_dump($package_exist);
			//			var_dump($package_eligible);
			//			echo ' < br><br > ';
			//			exit;
			if($package_exist === TRUE && $package_eligible === TRUE){

				$doc_details = $this->doctor_model->getDoctorById(array('user_id'=>$userid));

				$doc_details = current($doc_details);
				$doctor_city = $this->common_model->getCity(array('id'=>$doc_details['city_id'],'column'=>array('name','state_id')));

				$doctor_city = current($doctor_city);
				$doctor_state = $this->common_model->getState(array('id'=>$doctor_city['state_id'],'column'=>array('name')));
				$doctor_state = current($doctor_state);
				// Get package details
				$new_package_details = $this->doctor_model->get_package_details($packageid);
				// Get user details
				$userdetails         = $this->user_model->get_all_userdetails($userid);

				if($new_package_details !== FALSE){
					// Initaite a transaction
					$orderid = $this->transaction_model->initiate_transaction($userid, $packageid,$new_package_details->price); // get order id

					$_POST['merchant_id'] = '40672';
					$_POST['order_id'] = $orderid;
					$_POST['amount'] = $new_package_details->price;
					$_POST['currency'] = 'INR';
					$_POST['redirect_url'] = 'http://bookdrappointment.com/payment/paymentstatus';
					$_POST['cancel_url'] = 'http://bookdrappointment.com/payment/paymentstatus';
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
			else
			{
				$this->session->set_flashdata('package_message', '1');
				redirect('/doctor/packages');
				exit();
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

		$this->load->model('sendsms_model','mail_model');

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
		print_r($response);
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
			$this->doctor_model->insert_package($userid, $response->merchant_param2, $response->amount, $response->order_id);
			
			//Auto approve doctor
			$status    = 1;
			$ids       = array($userid);
			$this->doctor_model->update_doctor_status($status,$ids);

			$d         = $this->user_model->get_all_userdetails($userid);
			$g         = $this->doctor_model->get_package_details($packageid);
			$this->sendsms_model->doctor_upgrade_package_sms($d->contact_number, $g->name, $d->email_id);
			
			// send sms and mail if package is smart appointment
			if($response->merchant_param2==30) #smart appointment
			{
				$this->sendsms_model->smart_appointment($d->contact_number, $g->name, $d->email_id);
				$this->mail_model->smart_appointment($d->email_id,$g->name);
			}
			// send mail if package is smart appointment

			// send mail if package is smart receptionist
			if($response->merchant_param2==40) #smart receptionist
			{
				$this->sendsms_model->smart_receptionist($d->contact_number, $g->name, $d->email_id);
				$this->mail_model->smart_receptionist($d->email_id,$g->name);
			}
			// send mail if package is smart receptionis

			$pack_name = $this->doctor_model->get_package_details($response->merchant_param2);
			$this->session->set_flashdata('transid', $response->tracking_id);
			$this->session->set_flashdata('paymentstatus', $response->order_status);
			$this->session->set_flashdata('pack_type', $pack_name->name);
			$this->session->set_flashdata('pay_type', $response->payment_mode);
			$this->session->set_flashdata('amount', $response->amount);
			$this->session->set_flashdata('trans_date', date('d-m-Y'));
			$this->session->set_flashdata('trans_time', date('h:iA'));

			redirect('/doctor/paymentsuccess');
		}
		else
		if($order_status === "Aborted"){
			//echo " < br > Aborted";
			$this->transaction_model->post_transaction($response);
			$this->session->set_flashdata('packageid', $response->merchant_param2);
			redirect('/doctor/paymentfailure');
		}
		else
		if($order_status === "Failure"){
			//echo " < br > Failure";
			$this->transaction_model->post_transaction($response);
			$this->session->set_flashdata('packageid', $response->merchant_param2);
			redirect('/doctor/paymentfailure');
		}
		else
		{
			echo "<br>Security Error. Illegal access detected";
		}
	}

	function success()
	{
		/* user login check code begins */
		$session_userid   = $this->session->userdata('id');
		$session_usertype = $this->session->userdata('usertype');
		if(empty($session_userid)){
			redirect('/login', 'refresh');
			exit();
		}
		/* user login check code ends */

		$userid = $this->session->userdata('id');
		$data['name'] = $this->session->userdata('name');
		$data['userdetails'] = $this->user_model->get_all_userdetails($userid);
		$data['doctor_data'] = $this->doctor_model->get_doctor_data($userid);

		if(!empty($data['doctor_data'])){
			$doctorid = $data['doctor_data']->id;
			$data['doctorid'] = $doctorid;
			$data['clinic_present'] = $this->doctor_model->check_clinic_present($doctorid);
			$data['clinics'] = $this->doctor_model->get_all_clinics($doctorid);
			//print_r($data['clinics']);
		}
		else
		{
			$doctorid = NULL;
			$data['doctorid'] = $doctorid;
			$data['clinic_present'] = NULL;
		}

		$this->load->view('transaction_success', isset($data) ? $data : NULL);
	}

	function failure()
	{
		/* user login check code begins */
		$session_userid   = $this->session->userdata('id');
		$session_usertype = $this->session->userdata('usertype');
		if(empty($session_userid)){
			redirect('/login', 'refresh');
			exit();
		}
		/* user login check code ends */

		$userid = $this->session->userdata('id');
		$data['name'] = $this->session->userdata('name');
		$data['userdetails'] = $this->user_model->get_all_userdetails($userid);
		$data['doctor_data'] = $this->doctor_model->get_doctor_data($userid);

		if(!empty($data['doctor_data'])){
			$doctorid = $data['doctor_data']->id;
			$data['doctorid'] = $doctorid;
			$data['clinic_present'] = $this->doctor_model->check_clinic_present($doctorid);
			$data['clinics'] = $this->doctor_model->get_all_clinics($doctorid);
			//print_r($data['clinics']);
		}
		else
		{
			$doctorid = NULL;
			$data['doctorid'] = $doctorid;
			$data['clinic_present'] = NULL;
		}

		$this->load->view('transaction_failure', isset($data) ? $data : NULL);
	}

	function app_api_package($packageid = NULL)
	{
		
		/*sleep(3);
		redirect('/js_java_bridge.html');
		exit;*/
		/* user login check code begins */
		$session_userid   = $_GET['user_id'];
		$session_usertype = $_GET['usertype'];
		if(empty($session_userid)){
			echo "1";
			exit();
		}
		/* user login check code ends */

		if($packageid == NULL){
			echo "2";
			exit();
		}
		else
		{
			$userid           = $session_userid;

			$package_exist    = $this->doctor_model->check_packageid_exist($packageid);
			$package_eligible = $this->doctor_model->check_doctor_package_eligibility($userid, $packageid);

			if($package_exist === TRUE && $package_eligible === TRUE){
				
				$doc_details = $this->doctor_model->getDoctorById(array('user_id'=>$userid));
				$doc_details = current($doc_details);
				$doctor_city = $this->common_model->getCity(array('id'=>$doc_details['city_id'],'column'=>array('name','state_id')));
				$doctor_city = current($doctor_city);
				$doctor_state = $this->common_model->getState(array('id'=>$doctor_city['state_id'],'column'=>array('name')));
				$doctor_state = current($doctor_state);
				// Get package details
				$new_package_details = $this->doctor_model->get_package_details($packageid);
				// Get user details
				$userdetails         = $this->user_model->get_all_userdetails($userid);

				if($new_package_details !== FALSE){
					// Initaite a transaction
					$orderid = $this->transaction_model->initiate_transaction($userid, $packageid,$new_package_details->price); // get order id

					$_POST['merchant_id'] = '40672';
					$_POST['order_id'] = $orderid;
					$_POST['amount'] = $new_package_details->price;
					$_POST['currency'] = 'INR';

					$_POST['redirect_url'] = 'http://bookdrappointment.com/payment/app_api_paymentstatus';
					$_POST['cancel_url'] = 'http://bookdrappointment.com/payment/app_api_paymentstatus';

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
			else
			{
				echo "3";
				exit();
			}
		}
	}

	function app_api_paymentstatus()
	{

		$this->load->model('sendsms_model','mail_model');

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
			$this->doctor_model->insert_package($userid, $response->merchant_param2, $response->amount, $response->order_id);

			//Auto approve doctor
			$status    = 1;
			$ids       = array($userid);
			$this->doctor_model->update_doctor_status($status,$ids);

			$d         = $this->user_model->get_all_userdetails($userid);
			$g         = $this->doctor_model->get_package_details($packageid);
			#$this->sendsms_model->doctor_upgrade_package_sms($d->contact_number, $g->name, $d->email_id);

			// send sms and mail if package is smart appointment
			if($response->merchant_param2==30) #smart appointment
			{
				$this->sendsms_model->smart_appointment($d->contact_number, $g->name, $d->email_id);
				$this->mail_model->smart_appointment($d->email_id,$g->name);
			}
			// send mail if package is smart appointment

			// send mail if package is smart receptionist
			if($response->merchant_param2==40) #smart receptionist
			{
				$this->sendsms_model->smart_receptionist($d->contact_number, $g->name, $d->email_id);
				$this->mail_model->smart_receptionist($d->email_id,$g->name);
			}
			// send mail if package is smart receptionis
			

			#$pack_name = $this->doctor_model->get_package_details($response->merchant_param2);
			/*$this->session->set_flashdata('transid', $response->tracking_id);
			$this->session->set_flashdata('paymentstatus', $response->order_status);
			$this->session->set_flashdata('pack_type', $pack_name->name);
			$this->session->set_flashdata('pay_type', $response->payment_mode);
			$this->session->set_flashdata('amount', $response->amount);
			$this->session->set_flashdata('trans_date', date('d-m-Y'));
			$this->session->set_flashdata('trans_time', date('h:iA'));*/
		redirect('/js_java_bridge.html?type=Success&package_id='.$packageid);
		exit;

		}
		else
		if($order_status === "Aborted"){
			$packageid = $response->merchant_param2;
			//echo " < br > Aborted";
			$this->transaction_model->post_transaction($response);
			#$this->session->set_flashdata('packageid', $response->merchant_param2);
			#redirect(' / doctor / paymentfailure');
		redirect('/js_java_bridge.html?type=Aborted&package_id='.$packageid);
		exit;

		}
		else
		if($order_status === "Failure"){
			$packageid = $response->merchant_param2;
			//echo " < br > Failure";
			$this->transaction_model->post_transaction($response);
			#$this->session->set_flashdata('packageid', $response->merchant_param2);
			#redirect(' / doctor / paymentfailure');
		redirect('/js_java_bridge.html?type=Failure&package_id='.$packageid);
		exit;

		}
		else
		{
			$packageid = $response->merchant_param2;
			redirect('/js_java_bridge.html?type=Illegal&package_id='.$packageid);
			exit;
	
			#echo "<br>Security Error. Illegal access detected";
		}
	}

	function direct($amount=5000)
	{
		$_POST['merchant_id'] = '40672';
		$_POST['order_id'] = '121';
		$_POST['amount'] = $amount;
		$_POST['currency'] = 'INR';
		$_POST['redirect_url'] = 'http://bookdrappointment.com/payment/direct_payment';
		$_POST['cancel_url'] = 'http://bookdrappointment.com/payment/direct_payment';
		$_POST['language'] = 'EN';
//		$_POST['billing_name'] = $userdetails->name;
//		$_POST['billing_email'] = $userdetails->email_id;
//		$_POST['merchant_param1'] = $userid;
//		$_POST['merchant_param2'] = $packageid;

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