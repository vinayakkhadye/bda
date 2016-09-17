<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');
set_time_limit(100000);
ini_set("memory_limit","2000M");
class Migration extends CI_Controller{
	private $data = array();
	private $log_file = ""; 
	public function __construct(){
		parent::__construct();
		$this->data['class_name'] = $this->router->fetch_class();
		$this->load->model(array('common_model','doctor_model','location_model','clinic_model','reviews_model'));
		
	}
	public function log_message($myfile,$query){
		fwrite($myfile, $query);
		#file_put_contents(DOCUMENT_ROOT."logs/" .$log_file,$query,FILE_APPEND);
		#$this->load->view('errors/page_missing.tpl.php',$this->data);
		return false;
	}
	public function mkpath($path,$perm){
		if(@mkdir($path) or file_exists($path)) return true;
		return ($this->mkpath(dirname($path),$perm) and mkdir($path,$perm));
	}

	public function doctor_import_process($data){
		#echo "<pre>";
		#print_r($data);
		#exit;
		$dayArray = array("SUN","MON","TUE","WED","THU","FRI","SAT");
		$clInsertValuesArray =array();
		$insert_id = 0;
		$status =1;
		$duration =15;
		$drInsert = $clInsert = $clInsertValues ="";$insertReviewArray = array();
		$dayMap = array(6=>12,0=>13,1=>14,2=>15,3=>16,4=>17,5=>18);
		
		$city_id = $this->post['city_id'];
		$city_name = $this->post['city_name'];
		

		$state_id = 12;
		$country_id = 1;
		
		$this->data['method_name'] = $this->router->fetch_method();
		/* data loop starts */
		foreach($data as $key=>$val){
			foreach($val as $fKey=>$fval){
				$val[$fKey] = trim($fval,'\',. ');
			}
			$val = array_map("replace_special_chars",$val);
			$clInsertArray = array_chunk(array_slice($val,17,77),11);
			$reviewsInsertArray = array_slice($val,94,140);
			$drInsertArray = array_slice($val,6,7);
			$drDetailsArray = array('Services','Specializations','Education','Experience','AwardsAndRecognitions','Membership','Registrations');
			$drDetailsArray = array_combine($drDetailsArray,$drInsertArray);

			if($key==0){
				$insertArray = array();
				$filename_path = '';
				if(!empty($val[0])){
					$filename_path = $this->doctor_image_import($city_name,$val[0]);
				}
				#-------------------------------------------------------------
				$qua_insert_array = array();
				$other_qua_array =array(); 
				$val['3'] = explode(",",$val['3']);
				if(is_array($val['3']) && sizeof($val['3'])>0){
					$val['3'] = array_map('trim',$val['3']);
					foreach($val['3'] as $quaKey=>$quaVal){
						$quaVal =strtolower(trim($quaVal));
						if(!empty($quaVal)){
							$quaNameArray = $this->common_model->getQualification(array("exact_name"=>strtolower($quaVal),'column'=>array('id')));
							if($quaNameArray[0]['id']){
								$qua_insert_array[]= $quaNameArray[0]['id'];
							}else{
								$other_qua_array[] = strtolower($quaVal);
							}
						}
					}
				}else{
					$qua_insert_array = $other_qua_array = array();
				}
				$qua_insert_array = implode(",",$qua_insert_array);
				$other_qua_array = implode(",",$other_qua_array);

				#-------------------------------------------------------------
				$speciality_insert_array = array();
				$other_speciality_array =array(); 
				$val['4'] = explode(",",$val['4']);
				if(is_array($val['4']) && sizeof($val['4'])>0){
					$val['4'] = array_map('trim',$val['4']);
					foreach($val['4'] as $specKey=>$specVal){
						$specVal =strtolower(trim($specVal));
						if(!empty($specVal)){
							$specNameArray = $this->common_model->getSpeciality(array("exact_name"=>strtolower($specVal),'column'=>array('id')));
							if($specNameArray[0]['id']){
								$speciality_insert_array[]= $specNameArray[0]['id'];
								$speciality_map_insert_id = $this->common_model->insertSpecialityCityMap(array("speciality_id"=>$specNameArray[0]['id'],'city_id'=>$city_id));
							}else{
								$other_speciality_array[] = strtolower($specVal);
							}
						}
					}
					#$val['4'] = trim($val['4'],",");
				}else{
					$speciality_insert_array = $other_speciality_array = array();
				}
				$speciality_insert_array = implode(",",$speciality_insert_array);
				$other_speciality_array = implode(",",$other_speciality_array);
				#-------------------------------------------------------------
				
				#-------------------------------------------------------------
				$speciality_insert_array = array();
				$other_speciality_array =array(); 
				$val['7'] = explode(",",$val['7']);
				if(is_array($val['7']) && sizeof($val['7'])>0){
					$val['7'] = array_map('trim',$val['7']);
					foreach($val['7'] as $specKey=>$specVal){
						$specVal =strtolower(trim($specVal));
						if(!empty($specVal)){
							$specNameArray = $this->common_model->getSpeciality(array("exact_name"=>strtolower($specVal),'column'=>array('id')));
							if($specNameArray[0]['id']){
								$speciality_insert_array[]= $specNameArray[0]['id'];
								$speciality_map_insert_id = $this->common_model->insertSpecialityCityMap(array("speciality_id"=>$specNameArray[0]['id'],'city_id'=>$city_id));
							}else{
								$other_speciality_array[] = strtolower($specVal);
							}
						}
					}
					#$val['7'] = trim($val['7'],",");
				}else{
					$speciality_insert_array = $other_speciality_array = array();
				}
				$speciality_insert_array = implode(",",$speciality_insert_array);
				$other_speciality_array = implode(",",$other_speciality_array);
				#-------------------------------------------------------------		
						
				#-------------------------------------------------------------
				/*$specialization_insert_array = array();
				$other_specialization_array =array(); 
				$val['7'] = explode(";",$val['7']);
				if(is_array($val['7']) && sizeof($val['7'])>0){
					$val['7'] = array_map('trim',$val['7']);
					foreach($val['7'] as $quaKey=>$quaVal){
						$quaVal =strtolower(trim($quaVal));
						if(!empty($quaVal)){
							$specNameArray = $this->common_model->getSpecialization(array("exact_name"=>strtolower($quaVal),'column'=>array('id')));
							if($specNameArray[0]['id']){
								$specialization_insert_array[]= $specNameArray[0]['id'];
								$specialization_map_insert_id = $this->common_model->insertSpecializationCityMap(array("specialization_id"=>$specNameArray[0]['id'],'city_id'=>$city_id));
							}else{
								$other_specialization_array[] = strtolower($quaVal);
							}
						}
					}
					#$val['7'] = trim($val['7'],",");
				}else{
					$specialization_insert_array = $other_specialization_array = array();
				}
				$specialization_insert_array = implode(",",$specialization_insert_array);
				$other_specialization_array = implode(",",$other_specialization_array);*/
				#-------------------------------------------------------------

				$insertArray = array('name'=>$val[2],'gender'=>$val[1],'summary'=>$val[5],'speciality'=>$speciality_insert_array,'other_speciality'=>$other_speciality_array,'specialization'=>$specialization_insert_array,'other_specialization'=>$other_specialization_array,'qualification'=>$qua_insert_array,'other_qualification'=>$other_qua_array,'city_id'=>$city_id,'yoe'=>$val[15],'image'=>$filename_path,'contact_number'=>$val[16],'rating'=>$val[13],'status'=>'1','created_on'=>date("Y-m-d H:i:s"));
				$doctor_exists = $this->doctor_model->getDoctor(array('column'=>array('id','name'),'name'=>$val[2],'city_id'=>$city_id,'speciality'=>$speciality_insert_array,'qualification_exact'=>$qua_insert_array));
				$this->log_message($this->log_file,"\t ----------------------------------------------------".NEW_LINE);
				if(is_array($doctor_exists)){
					$doctor_exists = current($doctor_exists);
					$doctor_insert_id = intval($doctor_exists['id']);
					if(!empty($filename_path)){
						$this->db->update('doctor', array('image'=>$filename_path), array('id'=>$doctor_insert_id));
						$this->log_message($this->log_file,"\t Image Updated:".$doctor_insert_id ." - ".$filename_path.NEW_LINE);
					}
					$this->log_message($this->log_file,"\t Doctor Exists :".$doctor_insert_id ." - ".$doctor_exists['name'].NEW_LINE);
				}else{
					$doctor_insert_id = $this->doctor_model->insertDoctor($insertArray);
					
					$this->log_message($this->log_file,"\t Doctor Inserted :".$doctor_insert_id." - ".$insertArray['name'].NEW_LINE);
					$fist_time_doctor_entry =TRUE;
					$insertArray = array();
					/* insert doctor details */
					foreach($drDetailsArray as $drKey=>$drVal){
						$drKeyArray = explode(";",$drVal);
						foreach($drKeyArray as $drArrayKey=>$drArrayVal){
							if(!empty($drArrayVal)){
								$insertArray[] = array('doctor_id'=>$doctor_insert_id,'attribute'=>$drKey,'description1'=>trim($drArrayVal));						
							}
						}
					}
					if(sizeof($insertArray)>0){
						$this->doctor_model->insertDoctorDetail($insertArray);
					}
					/* insert doctor details */
				}
				if($doctor_insert_id){
					
					$insertArray = array();
					if(is_array($clInsertArray) && sizeof($clInsertArray)>0){
						foreach($clInsertArray as $clKey=>$clVal){
							#print_r($clVal);
							$dayFilter=array();
							if(!empty($clVal[1])){
								if(!empty($clVal[4])){
									$days = array_map("trim",explode("-",trim(strtoupper($clVal[4]))));
									if(sizeof($days)>1){
										#$dayFilter = array_slice($dayArray,array_search($days[0],$dayArray),array_search($days[1],$dayArray),true);
										if($days[0]=="SAT" && $days[1]=="SUN"){
											$dayFilter = array(0=>"SUN",6=>"SAT");
										}else if($days[0]=="MON" && $days[1]=="SUN"){
											$dayFilter = $dayArray;
										}else{
											$dayFilter 	= array_slice($dayArray,array_search($days[0],$dayArray),(array_search($days[1],$dayArray)),true);
										}	

									}else if(sizeof($days)==1){
										$dayFilter[array_search($days[0],$dayArray)] = $days[0];
									}
								}

								foreach($dayFilter as $dKey=>$dVal){
									$mor_open = (!empty($clVal[5]))?date("H:i:s",strtotime(trim($clVal[5]))):'';
									$mor_close = (!empty($clVal[6]))?date("H:i:s",strtotime(trim($clVal[6]))):'';
									$ev_open = (!empty($clVal[7]))?date("H:i:s",strtotime(trim($clVal[7]))):'';
									$ev_close = (!empty($clVal[8]))?date("H:i:s",strtotime(trim($clVal[8]))):'';
									$dayFilter[$dKey] = array(array($mor_open,$mor_close),array($ev_open,$ev_close));
								}
										
								$insertArray[$clKey]['clinic'] = array('doctor_id'=>$doctor_insert_id,'name'=>$clVal[1],'location_id'=>$clVal[0],'city_id'=>$city_id,'address'=>$clVal[3],'contact_number'=>$clVal[2],'timings'=>$dayFilter,'duration'=>15,'consultation_fees'=>$clVal[9]);
								
								/*$insertArray[$clKey]['schedule'] = array('doctor_id'=>$doctor_insert_id,'timings'=>$dayFilter,'duration'=>15,
								'consultation_fees'=>$clVal[9]);*/
							}
						}
					}
				}
			}else{
				$dayFilter =array();
				
				if(is_array($clInsertArray) && sizeof($clInsertArray)>0){
					foreach($clInsertArray as $clKey=>$clVal){
						if(!empty($clVal[4])){
							$days = array_map("trim",explode("-",trim(strtoupper($clVal[4]))));
							if(sizeof($days)>1){
								if($days[0]=="SAT" && $days[1]=="SUN"){
									$dayFilter = array(0=>"SUN",6=>"SAT");
								}else if($days[0]=="MON" && $days[1]=="SUN"){
									$dayFilter = $dayArray;
								}else{
									$dayFilter 	= array_slice($dayArray,array_search($days[0],$dayArray),(array_search($days[1],$dayArray)),true);
								}	
							}else if(sizeof($days)==1){
								$dayFilter[array_search($days[0],$dayArray)] = $days[0];
							}
							foreach($dayFilter as $dKey=>$dVal){
								$mor_open = (!empty($clVal[5]))?date("H:i:s",strtotime(trim($clVal[5]))):'';
								$mor_close = (!empty($clVal[6]))?date("H:i:s",strtotime(trim($clVal[6]))):'';
								$ev_open = (!empty($clVal[7]))?date("H:i:s",strtotime(trim($clVal[7]))):'';
								$ev_close = (!empty($clVal[8]))?date("H:i:s",strtotime(trim($clVal[8]))):'';
								$insertArray[$clKey]['clinic']['timings'][$dKey] = array(array($mor_open,$mor_close),array($ev_open,$ev_close));
							}
							ksort($insertArray[$clKey]['clinic']['timings']);
							#print_r($insertArray[$clKey]['schedule']['timings']);
						}
					}
				}
			}
			
			if(isset($fist_time_doctor_entry) && $fist_time_doctor_entry==TRUE){
				if(!isset($review_thread_insert_id)){
					/* insert review details */
					$reviewThreadData = $this->reviews->getReviewsByPageId(array('page_id'=>$doctor_insert_id.DOCTOR));
					if(is_array($reviewThreadData) && sizeof($reviewThreadData)>0 ){
						$review_thread_insert_id = current($reviewThreadData);
						$review_thread_insert_id = $review_thread_insert_id['id'];
					}else{
						$review_thread_insert_id = $this->reviews->insertReviewThread(array('page_id'=>$doctor_insert_id.DOCTOR));
						
					}
				}
				foreach($reviewsInsertArray as $key => $val)
				{
					if(!empty($val)){
						$insertReviewArray[] = array('thread_id'=>$review_thread_insert_id,'comment'=>$val,'status'=>1);
					}
				}
				
			}
			/* insert review details */
		}
		/* data loop ends */
		/* $insertArray loop starts*/
		if(is_array($insertArray) && sizeof($insertArray)>0){
			foreach($insertArray as $clivKey => $clivVal ){
				if(isset($clivVal['clinic'])){
					if(isset($clivVal['clinic']['location_id']) && !empty($clivVal['clinic']['location_id'])){
						$location_exists = $this->common_model->getLocation(array('column'=>array('lc.id'),'name'=>strtolower(trim($clivVal['clinic']['location_id'],',')),'city_id'=>$city_id));
						if(is_array($location_exists) && sizeof($location_exists)>0){
							$clivVal['clinic']['location_id'] = key($location_exists);
						}else{
							$location_name = strtolower(trim($clivVal['clinic']['location_id']));
							$insLocArray = array('name'=>$location_name,'city_id'=>$city_id,'status'=>0);
							$clivVal['clinic']['location_id'] = $this->location_model->insert_location($insLocArray);
							$this->log_message($this->log_file,"\t Location Inserted :".$clivVal['clinic']['location_id']." - ".$location_name.NEW_LINE);
						}
					}else{
						$clivVal['clinic']['location_id'] = 0;
					}
					if(isset($clivVal['clinic']['doctor_id']) && !empty($clivVal['clinic']['doctor_id'])){
						$clivVal['clinic']['timings'] = json_encode($clivVal['clinic']['timings']);
						$clivVal['clinic']['name'] = (isset($clivVal['clinic']['name']))?$clivVal['clinic']['name']:'clinic';
						$clinicExists = $this->clinic_model->getClinic(array('column'=>array('id'),'exact_name'=>addslashes($clivVal['clinic']['name']),
								'city_id'=>$city_id,'doctor_id'=>$clivVal['clinic']['doctor_id'],'location_id'=>$clivVal['clinic']['location_id']));
						if($clinicExists){
							$this->log_message($this->log_file,"\t Clinic Exists :".$clivVal['clinic']['name'].NEW_LINE);
						}else{
							$clinic_insert_id = $this->clinic_model->insertClinic($clivVal['clinic']);
							
							$this->log_message($this->log_file,"\t Clinic Inserted :".$clinic_insert_id." - ".$clivVal['clinic']['name'].NEW_LINE);
							
						}
					}
				}else{
					$this->log_message($this->log_file,"\t Clinic : Not Inserted :".$clivKey ."=>". json_encode($clivVal).NEW_LINE);	
				}
			}
			$this->log_message($this->log_file,"\t ----------------------------------------------------".NEW_LINE);
			#print_r($insertArray);
		}
		/* $insertArray loop ends*/
		$insertArray = array();

		/* insert doctor reviews */
		if(isset($insertReviewArray) && is_array($insertReviewArray) &&  sizeof($insertReviewArray)>0){
			#print_r($insertReviewArray);
			$this->reviews->insertReviewBatch($insertReviewArray);
		}else{
			#$this->log_message($this->log_file,"Doctor Reviews Not Avialable ".NEW_LINE);
		}
		$insertReviewArray = array();
		/* insert doctor reviews */
		
		return false;
	}
	public function doctor_image_import($city,$image){
		$filename_path = '';
		$sourceUrl = "./uploads/doctor_images/".$city."_photos/";
		if(!empty($image)){
			$md        = date('M').date('Y')."/".strtolower(substr($image,0,1));#.rand(1,60); // getting the current month and year for folder name
			$structure = "./media/photos/".$md; // setting the folder path
			// Check if the directory with that particular name is present or not
			if(!is_dir($structure)){
				$this->mkpath($structure,0777);
			}
			// setup the image new file name
			$newfilename   = md5($image);#.rand(10,99)
			
			// Get extension of the file
			$ext = pathinfo($image, PATHINFO_EXTENSION);
			// get the full filename with full path as it needs to be entered in the db
		

			if(file_exists(DOCUMENT_ROOT.$sourceUrl.$image)){
				$filename_path = $structure."/".$newfilename.".".$ext;
				rename(DOCUMENT_ROOT.$sourceUrl.$image,DOCUMENT_ROOT.$filename_path);
				$this->log_message($this->log_file,"\t Image : moved :".$sourceUrl.$image ."=>". $filename_path.NEW_LINE);	
			}else{
				$this->log_message($this->log_file,"\t Image : no such file  :".$sourceUrl.$image ."=>". $filename_path.NEW_LINE);	
			}
		}
		return  $filename_path;
	}
	public function doctor_import(){
		if(is_array($this->post) && sizeof($this->post)>0){
			$csv_filename = html_entity_decode(str_replace(" ","_",basename($_FILES['csv_file']['name'])));
			
			$file_log = DOCUMENT_ROOT."logs/" .$csv_filename.".log";
			
			$this->log_file = fopen($file_log, "w"); 
			$this->log_message($this->log_file,"Process Stated :".date("Y-m-d H:i:s").NEW_LINE);
			
			#$this->load->library('upload', $files);
			$this->post = array_map("strtolower",$this->post);
			$files['upload_path'] = './uploads/doctor_csv/';
			$files['allowed_types'] = 'csv';
			$files['file_name'] = $csv_filename;
			$this->load->library('upload', $files);
			if ( ! $this->upload->do_upload("csv_file")){
				$error = array('error' => $this->upload->display_errors());
				print_r($error);exit;
			}else{
			$filedata = array('upload_data' => $this->upload->data());
			#echo $data['upload_data']['full_path'] = DOCUMENT_ROOT."uploads/doctor_csv/".$files['file_name'];
			
			if(($handle = fopen($filedata['upload_data']['full_path'], "r")) !== FALSE){	
				$tmpData =array();
				$columns = fgetcsv($handle);
				while(($data = fgetcsv($handle)) !== FALSE){
					if(empty($data[2])){
						$tmpData[]=$data;
					}else{
						if(sizeof($tmpData)>0){
							$this->doctor_import_process($tmpData);
							$tmpData = array();
						}
						$tmpData[]=$data;
					}
				}
				if(is_array($tmpData) && sizeof($tmpData)>0){
					$this->doctor_import_process($tmpData);
				}
			}
			}
			$this->log_message($this->log_file,"Process Ended :".date("Y-m-d H:i:s").NEW_LINE);
			
			header('Content-Type: plain/text; charset=utf-8');
			header('Content-Disposition: attachment; filename='.basename($file_log));
			readfile($file_log);
		}else{
			$this->load->model(array('common_model'));
			$this->data['city'] = $this->common_model->getCity(array('limit'=>1000,'status'=>1,'column'=>array('id','name'))); 
			$this->load->view('scripts/doctor_import.tpl.php',$this->data);
		}
	}
	
	public function city_import_process($data)
	{
		if(is_array($data) && sizeof($data)>0 )
		{
			if(!empty($data['state_id']))
			{
				$insert_query = $this->db->insert_string('city',$data);
				$insert_query = str_replace('INSERT INTO','INSERT IGNORE INTO',$insert_query);
				$rs           = $this->db->query($insert_query);
				if($this->db->insert_id())
				{
				
				}
				else
				{
					$this->log_message($this->log_file,"\t City Not Inserted: ".$data['name'].NEW_LINE);	
				}
					
			}
			else
			{
				$this->log_message($this->log_file,"\t City : ".$data['name'] ." not found =>".NEW_LINE);	
			}
		}
		
	}
	public function city_import()
	{
		
		if(sizeof($_FILES)>0)
		{
			$csv_filename = html_entity_decode(str_replace(" ","_",basename($_FILES['csv_file']['name'])));
			$file_log = DOCUMENT_ROOT."logs/" .$csv_filename.".log";
			$this->log_file = fopen($file_log, "w"); 
			$this->log_message($this->log_file,"Process Stated :".date("Y-m-d H:i:s").NEW_LINE);
			
			$files['upload_path'] = './uploads/city_csv/';
			$files['allowed_types'] = 'csv';
			$files['file_name'] = $csv_filename;
			$this->load->library('upload', $files);
			if ( ! $this->upload->do_upload("csv_file"))
			{
				$error = array('error' => $this->upload->display_errors());
				print_r($error);exit;
			}
			else
			{
				$rs_state	=	$this->db->get_where('states', array());
				$rs_state	=	$rs_state->result_array();
				foreach($rs_state as $st_key=>$st_val)
				{
						$state[trim($st_val['name'])] = $st_val['id'];
				}
				
				
				$filedata = array('upload_data' => $this->upload->data());
				if(($handle = fopen($filedata['upload_data']['full_path'], "r")) !== FALSE)
				{	
					while(($data = fgetcsv($handle)) !== FALSE)
					{
						if(isset($state[strtoupper($data[1])]))
						{
							$insert	=	array('name'=>ucwords(trim($data[0])),'state_id'=>$state[strtoupper(trim($data[1]))]);
							$this->city_import_process($insert);
						}
						else
						{
							$this->log_message($this->log_file,"\t Sttate : ".$data[1] ." not found =>".NEW_LINE);	
						}
					}
				}
			}
			$this->log_message($this->log_file,"Process Ended :".date("Y-m-d H:i:s").NEW_LINE);
			header('Content-Type: plain/text; charset=utf-8');
			header('Content-Disposition: attachment; filename='.basename($file_log));
			readfile($file_log);
		}
		else
		{
			$this->load->view('scripts/city_import.tpl.php',$this->data);
		
		}
	
	}

	public function masters_import_process($table,$data)
	{
		if(is_array($data) && sizeof($data)>0 )
		{
				$insert_query = $this->db->insert_string($table,$data);
				$insert_query = str_replace('INSERT INTO','INSERT IGNORE INTO',$insert_query);
				$rs           = $this->db->query($insert_query);
				if($this->db->insert_id())
				{
				
				}
				else
				{
					$this->log_message($this->log_file,"\t ".$table." Not Inserted: ".$data['name'].NEW_LINE);	
				}
					
		}
		
	}
	public function masters_import()
	{
		if(sizeof($_FILES)>0)
		{
		
			$csv_filename = html_entity_decode(str_replace(" ","_",basename($_FILES['csv_file']['name'])));
			$file_log = DOCUMENT_ROOT."logs/" .$csv_filename.".log";
			$this->log_file = fopen($file_log, "w"); 
			$this->log_message($this->log_file,"Process Stated :".date("Y-m-d H:i:s").NEW_LINE);
			
			$files['upload_path'] = './uploads/masters_csv/';
			$files['allowed_types'] = 'csv';
			$files['file_name'] = $csv_filename;
			$this->load->library('upload', $files);
			if ( ! $this->upload->do_upload("csv_file"))
			{
				$error = array('error' => $this->upload->display_errors());
				print_r($error);exit;
			}
			else
			{
				if(isset($_POST['table']) && !empty($_POST['table']))
				{
					$this->log_message($this->log_file,"Processed Log File On Server Csv Name :".$files['upload_path'].$files['file_name'].NEW_LINE);
					$table	=	$_POST['table'];
					$filedata = array('upload_data' => $this->upload->data());
					if(($handle = fopen($filedata['upload_data']['full_path'], "r")) !== FALSE)
					{	
						while(($data = fgetcsv($handle)) !== FALSE)
						{
								$insert	=	array('name'=>ucwords(trim($data[0])));
								$this->masters_import_process($table,$insert);
						}
					}
				}
			}
			$this->log_message($this->log_file,"Process Ended :".date("Y-m-d H:i:s").NEW_LINE);
			header('Content-Type: plain/text; charset=utf-8');
			header('Content-Disposition: attachment; filename='.basename($file_log));
			readfile($file_log);
				
		}
		else
		{
			$this->load->view('scripts/masters_import.tpl.php',$this->data);
		
		}
	
	}

	function sendmail()
	{
		$this->load->library('mandrill');
		$file_log = DOCUMENT_ROOT."logs/docto_app_promotion_email.log";
		$this->log_file = fopen($file_log, "a"); 
		$subject = (isset($_GET['subject']))?$_GET['subject']:"Be a part of 75,000+ India's Best Doctors Online";
		$from_email = (isset($_GET['from_email']))?$_GET['from_email']:'support@bookdrappointment.com';
		$from_name = (isset($_GET['from_name']))?$_GET['from_name']:'BookDrAppointment';
		$mail_file = (isset($_GET['mail_file']))?$_GET['mail_file']:'doctor_app_promotion_mail';

		$mandrill = new Mandrill($this->config->item('mandrill_api_key'));
		if(isset($_GET['html']))
		{
			$html     = $this->load->view('mailers/'.$mail_file,array(),true);
			echo $html;exit;
		}

		$handle = fopen(DOCUMENT_ROOT.'uploads/doctor_csv/doctor_app_promotion_email_list.csv', "r");
		
		$this->log_message($this->log_file,"Process Stated :".date("Y-m-d H:i:s").NEW_LINE);
		$i	=	1;
		while(($data = fgetcsv($handle)) !== FALSE)
		{
			
			$html	=	$this->load->view('mailers/'.$mail_file,array('email_id'=>$data[0]),true);

			$to_email = $data[0];
			$to_name = $data[0];
			$message = array(
				'html'      => $html,
				'subject'   => $subject,
				'from_email'=> $from_email,
				'from_name' => $from_name,
				'to'                 => array(
					array(
						'email'=> $to_email,
						'name' => $to_name,
						'type' => 'to'
					)
				)
			);
			$async = false;
			
			if (filter_var($data[0], FILTER_VALIDATE_EMAIL)) {
				$result = $mandrill->messages->send($message, $async);
				if($result)
				{	
					$this->log_message($this->log_file,"\t ".$i.". email : ".$result[0]['email'].", status : ".$result[0]['status'].", _id : ".$result[0]['_id'].", reject_reason : ".$result[0]['reject_reason'].', time : '.date('H:i a').NEW_LINE);	
					sleep(5);
				}
				else
				{
					$this->log_message($this->log_file,"\t ".$i.". email : ".$data[0].',reason : not send '.json_encode($result).' time : '.date('H:i a').NEW_LINE);	
				}
			}
			else
			{
					$this->log_message($this->log_file,"\t ".$i.". email : ".$data[0].',reason : not proper email id '.json_encode($result).' time : '.date('H:i a').NEW_LINE);	
			}

		$i++;
		}
		$this->log_message($this->log_file,"Process Ended :".date("Y-m-d H:i:s").NEW_LINE);
		#header('Content-Type: plain/text; charset=utf-8');
		#header('Content-Disposition: attachment; filename='.basename($file_log));
		#readfile($file_log);
	}

	function doctor_app_promotion()
	{
		header("Content-Type: image/png");
		$file_log = DOCUMENT_ROOT."logs/doctor_app_promotion_mail_read.log";
		$this->log_file = fopen($file_log, "a+"); 
		$this->log_message($this->log_file,"email : ".$_GET['email_id']." date : ".date("Y-m-d H:i:s").NEW_LINE);	
		$im = imagecreatetruecolor(1, 1);
		$text_color = imagecolorallocate($im, 233, 14, 91);
		imagestring($im, 0, 0, 0,  '.', $text_color);		
		// Output the image
		imagepng($im);
		// Free up memory
		imagedestroy($im);
	}

	function doctorwebmail()
	{
		$this->load->view('mailers/doctor_app_promotion_mail',array('email_id'=>$_GET['email_id']));
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/errors.php */