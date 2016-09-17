<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Example
 *
 * This is a test for the wildcard. Wildcard allows you to specify an authentication type rule for an entire controller. Example would be $config['auth_override_class_method']['wildcard_test_cases']['*'] = 'basic'; This sets the authentication method for the Wildcard_test_harness controller to basic.
 *
 * @package		CodeIgniter
 * @subpackage	Rest Server
 * @category	Controller
 * @author		Allen Taylor
 * @link		http://philsturgeon.co.uk/code/
*/

// This can be removed if you use __autoload() in config.php OR use Modular Extensions

/*
In order for this test to work you will need to change the auth_source option in the rest.php config file to '' and uncomment this line $config['auth_override_class_method']['wildcard_test_cases']['*'] = 'basic'; in the file as well. Once these are uncommented the tests will work.
*/
set_time_limit(100000000);
ini_set("memory_limit","20000M");

class Test extends CI_Controller
{
	public $log_file = '';
	function __construct(){
		parent::__construct();
		$this->load->library('unit_test');
		$this->load->helper('url');
	}

	//curl interface functions
	private function makeRequest($url, $cred = '', $curlopts = array()){
		$ch = curl_init($url);
		$items = array(
		    CURLOPT_URL => $url,
		    CURLOPT_USERPWD => $cred
		);
		foreach($curlopts as $opt => $value)
			$items[$opt] = $value;
		curl_setopt_array($ch, $items);
		ob_start();
		$response = curl_exec($ch);
		$contents = ob_get_contents();
		ob_end_clean();
		$info = curl_getinfo($ch);

		$errno = curl_errno($ch);
		$error = curl_error($ch);
		curl_close($ch);
		return array('response' => $response, 'contents' => $contents, 'errno' => $errno, 'error' => $error, 'info' => $info);//return 
	}

	/*
	These two test cases will test if the authentication is working for the wildcard method. The curl requests may not work if you do not have an .htaccess file with mod rewrite in the same directory as your index.php file. If you don't have that file you can add it or change the url below to the one that includes index.php.
	*/
	function index(){
		/*$test = $this->makeRequest('http://192.168.1.135/api/user/login', '',
		array(CURLOPT_POST=>TRUE,CURLOPT_POSTFIELDS=>"type=normal&user_name=drpaivikas@gmail.com&password=9890035437"));
		print_r($test);*/
		/*$test = $this->makeRequest('http://192.168.1.135/api/password/change', '',
		array(CURLOPT_POST=>TRUE,CURLOPT_POSTFIELDS=>"user_id=36&newpass=9890035437"));
		print_r($test);*/
		/*$test = $this->makeRequest(base_url() . 'api/location/city', '',
		array(CURLOPT_POST=>TRUE,CURLOPT_POSTFIELDS=>"state_id=12"));
		print_r($test);*/
				/*$test = $this->makeRequest(base_url() . 'api/location/state', '',
		array(CURLOPT_POST=>TRUE));
		print_r($test);*/
		/*$test = $this->makeRequest(base_url() . 'api/masters/speciality', '',
		array(CURLOPT_POST=>TRUE));
		print_r($test);*/

		/*$test = $this->makeRequest(base_url() . 'api/masters/qualification', '',
		array(CURLOPT_POST=>TRUE));
		print_r($test);*/
		/*$test = $this->makeRequest(base_url() . 'api/verification/mobile', '',
		array(CURLOPT_POST=>TRUE,CURLOPT_POSTFIELDS=>"mobile_number=7715856018"));
		print_r($test);*/
		#var_dump($_POST['input_box']);exit;

		/*$base64_image = $_POST['input_box'];
		#echo '<img src="data:image/jpeg;base64,'.$base64_image.'" />';exit;
		#echo $base64_image;exit;
		$image_name = "vinayak.jpg";
		#echo base_url() . 'api/user/imageupload';exit;
		$headers = array('Content-Type: text/plain');
		$test = $this->makeRequest(
			base_url() . 'api/user/imageupload', '',
			array(
				CURLOPT_POST=>TRUE,
				CURLOPT_POSTFIELDS=>"base64_image=$base64_image&image_name=$image_name",
				CURLOPT_HEADER=>1,
				CURLOPT_HTTPHEADER=>$headers)
			);
		print_r($test);*/
		/*$a =array("name"=>"newuser1","email"=>"new4@user.com","pass"=>"123456","mob"=>"45445443549","gender"=>"m","dob"=>"1988-09-24","usertype"=>"2","image_path"=>"./media/photos/Dec2014/v/1f07f7c5e034683c4f6093180a1607cc.jpg","speciality[0]"=>"1","degree[0]"=>"1","regno"=>"","speciality[1]"=>"2","degree[1]"=>"2","council"=>"","city_id"=>"1","google_id"=>"103240572165896195014","google_image"=>"https://lh6.googleusercontent.com/-ZwQ5C3QLY38/AAAAAAAAAAI/AAAAAAAAAUI/Ss3ElzRNLQE/s120-c/photo.jpg");
		#print_r($a);exit;
		$test = $this->makeRequest('http://192.168.1.135/api/user/signup', '',
		array(CURLOPT_POST=>TRUE,CURLOPT_POSTFIELDS=> http_build_query($a)));
		print_r($test);*/

		/*$test = $this->makeRequest('http://192.168.1.135/api/user/login', '',
		array(CURLOPT_POST=>TRUE,CURLOPT_POSTFIELDS=>"type=google&google_id=103240572165896195014"));
		print_r($test);*/
		$test = $this->makeRequest('http://192.168.1.135/api/doctor/updateclinicphoto', '',
		array(CURLOPT_POST=>TRUE,CURLOPT_POSTFIELDS=>"clinic_id=2&image[0]=csdcdsac.jpg&image[1]=csdcdsac.jpg&image[2]=csdcdsac.jpg&image[3]=csdcdsac.jpg&image[4]=csdcdsac.jpg&image[5]=csdcdsac.jpg"));
		print_r($test);

		/*$test = $this->makeRequest('http://192.168.1.135/api/doctor/profile', '',
		array(CURLOPT_POST=>TRUE,CURLOPT_POSTFIELDS=>"user_id=39&user_type=2"));
		print_r($test);*/
		/*$test = $this->makeRequest('http://192.168.1.135/api/doctor/profile', '',
		array(CURLOPT_POST=>TRUE,CURLOPT_POSTFIELDS=>"user_id=39&user_type=2&doctor_id=16023&package_id=20"));
		print_r($test);*/
		/* $test = $this->makeRequest('http://192.168.1.135/api/doctor/getclinic', '',
		array(CURLOPT_POST=>TRUE,CURLOPT_POSTFIELDS=>"clinic_id=6"));
		print_r($test);*/		

		/*$test = $this->makeRequest(base_url() . 'api/review/list', '',
		array(CURLOPT_POST=>TRUE,CURLOPT_POSTFIELDS=>"doctor_id=12943"));
		print_r($test);*/
		/*$test = $this->makeRequest('http://192.168.1.135/api/password/forgot', '',
		array(CURLOPT_POST=>TRUE,CURLOPT_POSTFIELDS=>""));
		print_r($test);*/
		
	}
	function curl_image_upload(){
		if (isset($_POST['btnUpload']))
		{
			
			echo $url = "http://180.179.171.243/api/user/imageuploadmulti"; // e.g. http://localhost/myuploader/upload.php // request URL
			
			$filename1 = $_FILES['file']['name'][0];
			$filename2 = $_FILES['file']['name'][1];
			$filename3 = $_FILES['file']['name'][2];
			$filename4 = $_FILES['file']['name'][3];
			$filename5 = $_FILES['file']['name'][4];
			
			$filedata1 = $_FILES['file']['tmp_name'][0];
			$filedata2 = $_FILES['file']['tmp_name'][1];
			$filedata3 = $_FILES['file']['tmp_name'][2];
			$filedata4 = $_FILES['file']['tmp_name'][3];
			$filedata5 = $_FILES['file']['tmp_name'][4];

			$filesize1 = $_FILES['file']['size'][0];
			$filesize2 = $_FILES['file']['size'][1];
			$filesize3 = $_FILES['file']['size'][2];
			$filesize4 = $_FILES['file']['size'][3];
			$filesize5 = $_FILES['file']['size'][4];

			$post = array("filedata1" =>"@$filedata1","filedata2" =>"@$filedata2","filedata3" =>"@$filedata3","filedata4" =>"@$filedata4","filedata5" =>"@$filedata5","filename1" =>$filename1,"filename2" =>$filename2,"filename2" =>$filename2,"filename3" =>$filename3,"filename4" =>$filename4,"filename5" =>$filename5);
			
			if ($filedata1 != '')
			{
			
				$headers = array("Content-Type:multipart/form-data"); // cURL headers for file uploading
				$postfields = $post;
				$ch = curl_init();
				$options = array(
					CURLOPT_URL => $url,
					CURLOPT_HEADER => false,
					CURLOPT_POST => 1,
					CURLOPT_HTTPHEADER => $headers,
					CURLOPT_POSTFIELDS => $postfields,
					CURLOPT_INFILESIZE => $filesize1,
					CURLOPT_RETURNTRANSFER => false
				); // cURL options
				curl_setopt_array($ch, $options);
				$rs = curl_exec($ch);
				var_dump($rs);
				if(!curl_errno($ch))
				{
					$info = curl_getinfo($ch);
					if ($info['http_code'] == 200)
						$errmsg = "File uploaded successfully";
				}
				else
				{
					$errmsg = curl_error($ch);
				}
				print_r($rs);
				curl_close($ch);
			}
			else
			{
				$errmsg = "Please select the file";
			}
		}	
	
	}
	function image_upload(){
		$this->load->view('scripts/curl_image_upload');
	}
	function city_latlong()
	{
		$time	=	 date("Y-m-d-H-i-s");
		$this->log_file = fopen(DOCUMENT_ROOT."logs/city_latlng.log", "a+"); 
		$this->log_message($this->log_file,"Process Stated :".date("Y-m-d H:i:s").NEW_LINE);
		
		$this->log_message($this->log_file,"\t ---------------------------".NEW_LINE);
		$selCity = "SELECT city.id as 'city_id', city.name as 'city_name',states.name as 'state_name' FROM city INNER JOIN states ON city.state_id = states.id where city.latitude is null and city.status=1";
		
		$rs = $this->db->query($selCity);
		$data = $rs->result_array();
		if(is_array($data))
		{
			foreach($data as $key=>$val)
			{
				$address = 	$val['state_name'].", ".$val['city_name'];
				$api = 'https://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($address).'&key=AIzaSyDF3nnAcLnskfZDjz--B9po2O7Jf5C3TzI';
				$test = $this->makeRequest($api, '');
				$test = json_decode($test['contents'],true); 
				if(isset($test['results'][0]['geometry']['location']))
				{
					$lat_long = $test['results'][0]['geometry']['location'];
					$this->log_message($this->log_file,"\t City : ".$val['city_name']." latitude : ".$lat_long['lat'].", longitude : ".$lat_long['lng'].NEW_LINE);

					$updateCity = "update city set latitude='".$lat_long['lat']."', longitude='".$lat_long['lng']."' where id=".$val['city_id'];
					$rs = $this->db->query($updateCity);
					if($rs)
					{
						$this->log_message($this->log_file,"\t affected_rows : ".$this->db->affected_rows().", Query : ".$updateCity.NEW_LINE);
					}
					else
					{
						$this->log_message($this->log_file,"\t Problem in query : ".$updateCity.NEW_LINE);	
					}
				}
				else
				{
					$this->log_message($this->log_file,"\t No Such Location : ".$val['city_id']." => ".$val['city_name'].NEW_LINE);
				}
			$this->log_message($this->log_file,"\t ---------------------------".NEW_LINE);			
			sleep(1);
			}
		}
		$this->log_message($this->log_file,"Process Ended :".date("Y-m-d H:i:s").NEW_LINE);		

	}

	function location_latlong()
	{
		$city_id = $this->input->get('city_id');
		$city_name = $this->input->get('city_name');
		$this->log_file = fopen(DOCUMENT_ROOT."logs/location_latlng_".$city_name.".log", "a+"); 
		$this->log_message($this->log_file,"Process Stated :".date("Y-m-d H:i:s").NEW_LINE);
		
		$this->log_message($this->log_file,"\t ---------------------------".NEW_LINE);
		$selLocation = "select id,name from location where city_id=$city_id and latitude is null";
		#$selLocation = "select id,name from location where city_id=$city_id and id in(250,171)";
		
		
		$rs = $this->db->query($selLocation);
		$data = $rs->result_array();
		if(is_array($data))
		{
			foreach($data as $key=>$val)
			{
				$address = 	$val['name'].", ".ucfirst($city_name);
				
				#echo $api = 'https://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($address).'&key=AIzaSyDF3nnAcLnskfZDjz--B9po2O7Jf5C3TzI';
				$api = 'https://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($address).'&key=AIzaSyB698S0CezJf_eC49SoJHFxZt9EznNBZoM';
				
				$test = $this->makeRequest($api, '');
				$test = json_decode($test['contents'],true); 
				
				if(isset($test['results'][0]['geometry']['location']))
				{
					$lat_long = $test['results'][0]['geometry']['location'];
					$this->log_message($this->log_file,"\t Location : ".$val['name']." latitude : ".$lat_long['lat'].", longitude : ".$lat_long['lng'].NEW_LINE);
					$updateLocation = "update location set latitude='".$lat_long['lat']."', longitude='".$lat_long['lng']."' where id=".$val['id'];
					$rs = $this->db->query($updateLocation);

					if($rs)
					{
						$this->log_message($this->log_file,"\t affected_rows : ".$this->db->affected_rows().", Query : ".$updateLocation.NEW_LINE);
					}else
					{
						$this->log_message($this->log_file,"\t Problem in query : ".$updateLocation.NEW_LINE);	
					}
				}else
				{
					$this->log_message($this->log_file,"\t No Such Location : ".$val['id']." => ".$val['name'].NEW_LINE);
				}
			$this->log_message($this->log_file,"\t ---------------------------".NEW_LINE);			
			sleep(1);
			}
		}
		$this->log_message($this->log_file,"Process Ended :".date("Y-m-d H:i:s").NEW_LINE);		

	}
	public function practo_clinic(){
		$city_id = $this->input->get('city_id');
		$city_name = $this->input->get('city_name');
		$limit = $this->input->get('limit');
		$offset = $this->input->get('offset');
		$this->log_file = fopen(DOCUMENT_ROOT."logs/practo_clinic_".$city_name."_".$limit."_".$offset.".log", "w"); 
		$this->log_message($this->log_file,"Process Stated :".date("Y-m-d H:i:s").NEW_LINE);
		$this->log_message($this->log_file,"\t Offset :".$offset.", Limit : ".$limit.", City Name : ".$city_name.NEW_LINE);
		$this->log_message($this->log_file,"\t ---------------------------".NEW_LINE);
		$select = "SELECT cli.id as `clinic_id`, cli.name as `clinic_name`,cli.address ,lc.name as `clinic_location`,lc.id as `clinic_location_id`
		FROM clinic AS cli 
		INNER JOIN location lc ON cli.location_id=lc.id 
		WHERE cli.city_id = '".$city_id."' 
		Group By lc.name,cli.name 
		order by cli.name asc
		limit $offset,$limit";
		$rs = $this->db->query($select);
		
		$data = $rs->result_array();
		if(is_array($data)){
			foreach($data as $key=>$val){
				$clinic_name  = $val['clinic_name'];
				$val['clinic_name'] =  preg_replace('/\&/', '', $val['clinic_name']);
				$val['clinic_name'] =  preg_replace('/\-/', '', $val['clinic_name']);
				$val['clinic_name'] =  preg_replace('/\,/', '', $val['clinic_name']);
				$val['clinic_name'] =  preg_replace('/\//', '', $val['clinic_name']);

				$val['clinic_name'] =  preg_replace('/\s+/', '-', $val['clinic_name']);
				$val['clinic_name'] =  preg_replace('/\.-/', ' ', $val['clinic_name']);
				$val['clinic_name'] =  preg_replace('/\./', '-', $val['clinic_name']);
				$val['clinic_name'] =  preg_replace('/\(/', '-', $val['clinic_name']);
				$val['clinic_name'] =  preg_replace('/\)/', '-', $val['clinic_name']);
				$val['clinic_name'] =  preg_replace('/\'/', '-', $val['clinic_name']);
				$val['clinic_name'] =  preg_replace('/\s+/', '-', $val['clinic_name']);
				
				$clinic_name_url = strtolower($val['clinic_name'])."-".str_replace(" ","-",strtolower($val['clinic_location']));
				$file_url = "https://www.practo.com/".$city_name."/clinic/".$clinic_name_url;
				$this->log_message($this->log_file,"\t ".$key." => ".$val['clinic_id'].". Url : ".$file_url.NEW_LINE);
				$ua = 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US) AppleWebKit/525.13 (KHTML, like Gecko) Chrome/0.A.B.C Safari/525.13';
				$test = $this->makeRequest(
											$file_url, '',
											array(CURLOPT_RETURNTRANSFER=>true,
												CURLOPT_SSL_VERIFYPEER=>false,
												CURLOPT_HEADER=>true,
												CURLOPT_USERAGENT=>$ua,
												CURLOPT_AUTOREFERER =>true,
												CURLOPT_FOLLOWLOCATION =>true,
												CURLOPT_FOLLOWLOCATION=>true,
												CURLOPT_MAXREDIRS=>20
											)
										);
			
				if(!empty($test['error'])){
					$this->log_message($this->log_file,"\t Error No : ".$test['errno'].NEW_LINE);
					$this->log_message($this->log_file,"\t Error : ".$test['error'].NEW_LINE);
					$this->log_message($this->log_file,"\t Info : ".json_encode($test['info']).NEW_LINE);
				}
				$html = $test['response'];
				#print_r($html);

				$regexp = '/Page not Found \| Practo.com/';
				preg_match($regexp,$html,$page_not_found);
				#print_r($page_not_found);exit;
				if(is_array($page_not_found) && sizeof($page_not_found)>0){
					$this->log_message($this->log_file,"\t Page Not Found ".NEW_LINE);
				}		
				
				$regexp='/href=\"\/\/maps.google.com\/maps\?f=d\&daddr=(.*?)\(/';
				preg_match($regexp,$html,$long_lat);		
				#print_r($long_lat);

				$regexp='/\<div class=\"practice-address\">(.*?)\<\/div\>/';
				preg_match($regexp,$html,$address);
				#print_r($address);
				#print_r(array($test['error'],$test['info'],$long_lat));

				if(is_array($long_lat) && sizeof($long_lat)>1){
					$long_lat = explode(",",$long_lat[1]);
					if($long_lat[0] && $long_lat[1]){
						if(is_array($address) && sizeof($address)>1){		
							$address = $address[1];
							if($address==$val['address']){
								$address = '';
							}
						}else{
							$address = '';
						}
						
						$sqlUpdate = "UPDATE clinic 
						SET latitude='".trim($long_lat[0])."', 
						longitude='".trim($long_lat[1])."', 
						practo_address='".trim($address)."' 
						WHERE `name` = '".$clinic_name."' AND location_id ='".$val['clinic_location_id']."' and city_id='".$city_id."'";

						$rs = $this->db->query($sqlUpdate);
						$this->log_message($this->log_file,"\t update : affected_rows : ".$this->db->affected_rows().", location_id => ".$val['clinic_location_id'].", latitude => ".trim($long_lat[0]).", longitude => ".trim($long_lat[1]).", address => ".$address.NEW_LINE);
						$this->log_message($this->log_file,"\t ---------------------------".NEW_LINE);
					}
				}
				sleep(1);	
			}
		}
		$this->log_message($this->log_file,"Process Ended :".date("Y-m-d H:i:s").NEW_LINE);
		
	}
	public function log_message($myfile,$query){
		fwrite($myfile, $query);
		return false;
	}

	
}
?>