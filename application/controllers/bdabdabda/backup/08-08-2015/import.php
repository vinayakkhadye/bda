<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');
set_time_limit(1000);
class import extends CI_Controller{
	private $data = array();
	private $log_file = ""; 
	private $current_tab = '';

	public function __construct()
	{
		parent::__construct();
		$this->data['class_name'] = $this->router->fetch_class();
		$this->load->model(array('common_model','doctor_model','location_model','clinic_model','reviews_model'));
		$this->perms		=	$this->session->userdata('allowed_perms'); 
		$admin_home_url	=	$this->session->userdata('admin_home_url');
		if($this->perms[ADMIN_IMPORT]['view']	==	0)
		{
			redirect($admin_home_url);
			exit();
		}
	}
	public function log_message($myfile,$query)
	{
		fwrite($myfile, $query);
		return false;
	}
	public function mkpath($path,$perm)
	{
		if(@mkdir($path) or file_exists($path)) return true;
		return ($this->mkpath(dirname($path),$perm) and mkdir($path,$perm));
	}
	public function doctor_import_process($data)
	{
		$dayArray = array("SUN","MON","TUE","WED","THU","FRI","SAT");
		$clInsertValuesArray =array();
		$insert_id = 0;
		$status =1;
		$duration =15;
		$drInsert = $clInsert = $clInsertValues ="";
		$dayMap = array(6=>12,0=>13,1=>14,2=>15,3=>16,4=>17,5=>18);
		
		$city_id = $this->post['city_id'];
		$city_name = $this->post['city_name'];
		
		$this->data['method_name'] = $this->router->fetch_method();
		/* data loop starts */
		foreach($data as $key=>$val)
		{
			foreach($val as $fKey=>$fval)
			{
				$val[$fKey] = trim($fval,'\',. ');
			}
			$val = array_map("replace_special_chars",$val);
			$clInsertArray = array_chunk(array_slice($val,18,84),12);
			$drInsertArray = array_slice($val,6,7);
			$drDetailsArray = array('Services','Specializations','Education','Experience','AwardsAndRecognitions','Membership','Registrations');
			$drDetailsArray = array_combine($drDetailsArray,$drInsertArray);

			if($key==0)
			{
				$insertArray = array();
				$filename_path = '';
				if(!empty($val[0]))
				{
					$filename_path = $this->doctor_image_import($city_name,$val[0]);
				}
				
				#-------------------------------------------------------------
				$qua_insert_array = array();
				$other_qua_array =array(); 
				$val['3'] = explode(",",$val['3']);
				if(is_array($val['3']) && sizeof($val['3'])>0)
				{
					$val['3'] = array_map('trim',$val['3']);
					foreach($val['3'] as $quaKey=>$quaVal)
					{
						$quaVal =strtolower(trim($quaVal));
						if(!empty($quaVal))
						{
							$quaNameArray = $this->common_model->getQualification(array("exact_name"=>strtolower(addslashes($quaVal)),'column'=>array('id')));
							if($quaNameArray[0]['id'])
							{
								$qua_insert_array[]= $quaNameArray[0]['id'];
							}
							else
							{
								$other_qua_array[] = strtolower($quaVal);
							}
						}
					}
				}
				else
				{
					$qua_insert_array = $other_qua_array = array();
				}
				$qua_insert_array = implode(",",array_unique($qua_insert_array));
				$other_qua_array = implode(",",array_unique($other_qua_array));


				#-------------------------------------------------------------
				$speciality_insert_array = array();
				$other_speciality_array =array(); 
				
				$val['4'] = explode(",",$val['4']);
				if(is_array($val['4']) && sizeof($val['4'])>0)
				{
					$val['4'] = array_map('trim',$val['4']);
					foreach($val['4'] as $specKey=>$specVal)
					{
						$specVal =strtolower(trim($specVal));
						if(!empty($specVal))
						{
							$specNameArray = $this->common_model->getSpeciality(array("exact_name"=>strtolower(addslashes($specVal)),'column'=>array('id')));
							if($specNameArray[0]['id'])
							{
								$speciality_insert_array[]= $specNameArray[0]['id'];
								$speciality_map_insert_id = $this->common_model->insertSpecialityCityMap(array("speciality_id"=>$specNameArray[0]['id'],'city_id'=>$city_id));
							}else
							{
								$other_speciality_array[] = strtolower($specVal);
							}
						}
					}
				}
				
				if(is_array($speciality_insert_array) && sizeof($speciality_insert_array)>0)
				{
					$speciality_insert_array = implode(",", array_unique($speciality_insert_array));
				}
				else
				{
						$speciality_insert_array = "";
				}
				if(is_array($other_speciality_array) && sizeof($other_speciality_array)>0)
				{
					$other_speciality_array = implode(",",array_unique($other_speciality_array));
				}
				else
				{
					$other_speciality_array = "";
				}
				#-------------------------------------------------------------		
				$doctor_name	=	str_replace("dr","",str_replace("dr .","",str_replace("dr.","", strtolower($val[2]))));
				$doctor_name	=	ucwords(trim($doctor_name," ."));
				
				$insertArray	=	array('name'=>$doctor_name,'gender'=>$val[1],'summary'=>$val[5],'speciality'=>$speciality_insert_array,
				'other_speciality'=>$other_speciality_array,'qualification'=>$qua_insert_array,'other_qualification'=>$other_qua_array,'yoe'=>$val[15],
				'image'=>$filename_path,'contact_number'=>$val[16],'is_ver_reg'=>$val[17],'status'=>'1','created_on'=>date("Y-m-d H:i:s"));#,'city_id'=>$city_id

				#$doctor_exists = $this->doctor_model->getDoctor(array('column'=>array('id','name'),'name'=>$doctor_name,'status'=>1));
				#'speciality'=>$speciality_insert_array,'qualification_exact'=>$qua_insert_array,
				$doctor_exists_sql	=	'SELECT doc.id,doc.name FROM doctor doc JOIN clinic cli ON  doc.id=cli.doctor_id WHERE doc.name =\''.$doctor_name.'\' AND doc.status=1 AND cli.city_id='.$city_id;
				$doctor_exists_query	=	$this->db->query($doctor_exists_sql);
				
				$this->log_message($this->log_file,"\t ----------------------------------------------------".NEW_LINE);
				if($doctor_exists_query->num_rows>0)
				{

					$doctor_exists	=	$doctor_exists_query->row_array();

					$doctor_insert_id = intval($doctor_exists['id']);
					
					$this->log_message($this->log_file,"\t Doctor Exists :".$doctor_insert_id ." - ".$doctor_exists['name'].NEW_LINE);
					
					$update_array	=	array('gender'=>$val[1],'summary'=>$val[5],'speciality'=>$speciality_insert_array,
					'other_speciality'=>$other_speciality_array,'qualification'=>$qua_insert_array,'other_qualification'=>$other_qua_array,
					'yoe'=>$val[15],'image'=>$filename_path,'contact_number'=>$val[16],'is_ver_reg'=>$val[17],'status'=>'1');

					if(!empty($filename_path))
					{
							$update_array['image']	=	$filename_path;
					}
					$this->db->update('doctor',	$update_array, array('id'=>$doctor_insert_id));
					
					$this->log_message($this->log_file,"\t Doctor Updated:".$doctor_insert_id ." - ".$filename_path.NEW_LINE);
					
					
					
					
				}else
				{
					$this->log_message($this->log_file,"\t Doctor For Insertion :".$insertArray['name'].NEW_LINE);
					/*
					$doctor_insert_id = $this->doctor_model->insertDoctor($insertArray);
					$this->log_message($this->log_file,"\t Doctor Inserted :".$doctor_insert_id." - ".$insertArray['name'].NEW_LINE);
					$fist_time_doctor_entry =TRUE;
					$insertArray = array();
					 #insert doctor details 
					foreach($drDetailsArray as $drKey=>$drVal)
					{
						$drKeyArray = explode(";",$drVal);
						foreach($drKeyArray as $drArrayKey=>$drArrayVal)
						{
							if(!empty($drArrayVal))
							{
								$insertArray[] = array('doctor_id'=>$doctor_insert_id,'attribute'=>$drKey,'description1'=>trim($drArrayVal));						
							}
						}
					}
					if(sizeof($insertArray)>0)
					{
						$this->doctor_model->insertDoctorDetail($insertArray);
					}
					 #insert doctor details 
				*/}
				if($doctor_insert_id)
				{
					$insertArray = array();
					if(is_array($clInsertArray) && sizeof($clInsertArray)>0)
					{
						foreach($clInsertArray as $clKey=>$clVal)
						{
							$dayFilter=array();
							if(!empty($clVal[1]))
							{
								if(!empty($clVal[4]))
								{
									$days = array_map("trim",explode("-",trim(strtoupper($clVal[4]))));
									if(sizeof($days)>1)
									{
										if($days[0]=="SAT" && $days[1]=="SUN")
										{
											$dayFilter = array(0=>"SUN",6=>"SAT");
										}else if($days[0]=="MON" && $days[1]=="SUN")
										{
											$dayFilter = $dayArray;
										}else
										{
											$dayFilter 	= array_slice($dayArray,array_search($days[0],$dayArray),(array_search($days[1],$dayArray)),true);
										}	

									}else if(sizeof($days)==1)
									{
										$dayFilter[array_search($days[0],$dayArray)] = $days[0];
									}
								}

								foreach($dayFilter as $dKey=>$dVal)
								{
									$dayFilter[$dKey]= array();
									$mor_open = (!empty($clVal[5]))?date("H:i:s",strtotime(trim($clVal[5]))):'';
									$mor_close = (!empty($clVal[6]))?date("H:i:s",strtotime(trim($clVal[6]))):'';
									$ev_open = (!empty($clVal[7]))?date("H:i:s",strtotime(trim($clVal[7]))):'';
									$ev_close = (!empty($clVal[8]))?date("H:i:s",strtotime(trim($clVal[8]))):'';
									#$dayFilter[$dKey] = array(array($mor_open,$mor_close),array($ev_open,$ev_close));
									if(!empty($mor_open) && !empty($mor_close))
									{
										$dayFilter[$dKey][0] = $mor_open;
										$dayFilter[$dKey][1] = $mor_close;
									}
									else
									{
										$dayFilter[$dKey][0] = "";
										$dayFilter[$dKey][1] = "";
									}
									if(!empty($ev_open) && !empty($ev_close))
									{
										$dayFilter[$dKey][2] = $ev_open;
										$dayFilter[$dKey][3] = $ev_close;
									}
									else
									{
										$dayFilter[$dKey][2] = "";
										$dayFilter[$dKey][3] = "";
									}
									
									if((!empty($mor_open) && !empty($ev_close)) && (empty($mor_close) && empty($ev_open)))
									{
										$dayFilter[$dKey][0] = $mor_open;
										$dayFilter[$dKey][1] = $ev_close;
									}
									if((empty($mor_open) && empty($ev_close)) && (!empty($mor_close) && !empty($ev_open)))
									{
										$dayFilter[$dKey][0] = $mor_close;
										$dayFilter[$dKey][1] = $ev_open;
									}
									if(isset($dayFilter[$dKey]) && is_array($dayFilter[$dKey]) && sizeof($dayFilter[$dKey])>0)
									{
										$dayFilter[$dKey] = array_chunk($dayFilter[$dKey],2);
									}
								
								}
								$consult_fees	=	intval($clVal[9]);
								if($consult_fees>=100 && $consult_fees<=300)
								{
									$consult_fees	=	1;
								}else if($consult_fees>=301 && $consult_fees<=500)
								{
									$consult_fees	=	2;
								}else if($consult_fees>=501 && $consult_fees<=750)
								{
									$consult_fees	=	3;
								}else if($consult_fees>=751 && $consult_fees<=1000)
								{
									$consult_fees	=	4;
								}else if($consult_fees>=1001)
								{
									$consult_fees	=	5;
								}else
								{
									$consult_fees	=	intval($clVal[9]);
								}
								
								$insertArray[$clKey]['clinic'] = array('doctor_id'=>$doctor_insert_id,'name'=>$clVal[1],'location_id'=>$clVal[0],'city_id'=>$city_id,'address'=>$clVal[3],'contact_number'=>$clVal[2],'timings'=>$dayFilter,'duration'=>15,'consultation_fees'=>$consult_fees);
								if($clVal[11]==1)
								{
									$insertArray[$clKey]['clinic']['is_number_verified']	=	$clVal[11];
									$insertArray[$clKey]['clinic']['contact_number']	=	$clVal[2];
								}
								else if($clVal[11]==0)
								{
									if($val[17]==1)
									{
										$insertArray[$clKey]['clinic']['is_number_verified']	=	1;
										$insertArray[$clKey]['clinic']['contact_number']	=	$val[16];
									}
								}
								
							}
						}
					}
				}
			}else
			{
				$dayFilter =array();
				
				if(is_array($clInsertArray) && sizeof($clInsertArray)>0)
				{
					foreach($clInsertArray as $clKey=>$clVal)
					{
						if(!empty($clVal[4]))
						{
							$days = array_map("trim",explode("-",trim(strtoupper($clVal[4]))));
							if(sizeof($days)>1)
							{
								if($days[0]=="SAT" && $days[1]=="SUN")
								{
									$dayFilter = array(0=>"SUN",6=>"SAT");
								}else if($days[0]=="MON" && $days[1]=="SUN")
								{
									$dayFilter = $dayArray;
								}else
								{
									$dayFilter 	= array_slice($dayArray,array_search($days[0],$dayArray),(array_search($days[1],$dayArray)),true);
								}	
							}else if(sizeof($days)==1)
							{
								$dayFilter[array_search($days[0],$dayArray)] = $days[0];
							}
							foreach($dayFilter as $dKey=>$dVal)
							{
								$insertArray[$clKey]['clinic']['timings'][$dKey]=array();
								$mor_open = (!empty($clVal[5]))?date("H:i:s",strtotime(trim($clVal[5]))):'';
								$mor_close = (!empty($clVal[6]))?date("H:i:s",strtotime(trim($clVal[6]))):'';
								$ev_open = (!empty($clVal[7]))?date("H:i:s",strtotime(trim($clVal[7]))):'';
								$ev_close = (!empty($clVal[8]))?date("H:i:s",strtotime(trim($clVal[8]))):'';
								
								if(!empty($mor_open) && !empty($mor_close))
								{
									$insertArray[$clKey]['clinic']['timings'][$dKey][0] = $mor_open;
									$insertArray[$clKey]['clinic']['timings'][$dKey][1] = $mor_close;
								}
								else
								{
									$insertArray[$clKey]['clinic']['timings'][$dKey][0] = "";
									$insertArray[$clKey]['clinic']['timings'][$dKey][1] = "";
								}
								
								if(!empty($ev_open) && !empty($ev_close))
								{
									$insertArray[$clKey]['clinic']['timings'][$dKey][2] = $ev_open;
									$insertArray[$clKey]['clinic']['timings'][$dKey][3] = $ev_close;
								}
								else
								{
									$insertArray[$clKey]['clinic']['timings'][$dKey][2] = "";
									$insertArray[$clKey]['clinic']['timings'][$dKey][3] = "";
								}
								
								if((!empty($mor_open) && !empty($ev_close)) && (empty($mor_close) && empty($ev_open)))
								{
									$insertArray[$clKey]['clinic']['timings'][$dKey][0] = $mor_open;
									$insertArray[$clKey]['clinic']['timings'][$dKey][1] = $ev_close;
								}

								if((empty($mor_open) && empty($ev_close)) && (!empty($mor_close) && !empty($ev_open)))
								{
									$insertArray[$clKey]['clinic']['timings'][$dKey][0] = $mor_close;
									$insertArray[$clKey]['clinic']['timings'][$dKey][1] = $ev_open;
								}
								if(isset($insertArray[$clKey]['clinic']['timings'][$dKey]) && is_array($insertArray[$clKey]['clinic']['timings'][$dKey]) && sizeof($insertArray[$clKey]['clinic']['timings'][$dKey])>0)
								{
									$insertArray[$clKey]['clinic']['timings'][$dKey] = array_chunk($insertArray[$clKey]['clinic']['timings'][$dKey],2);
								}
								
								#$insertArray[$clKey]['clinic']['timings'][$dKey] = array(array($mor_open,$mor_close),array($ev_open,$ev_close));
							}
							ksort($insertArray[$clKey]['clinic']['timings']);
							
						}
					}
				}
			}
		}
		/* data loop ends */
		/* $insertArray loop starts*/

		if(is_array($insertArray) && sizeof($insertArray)>0)
		{
			foreach($insertArray as $clivKey => $clivVal )
			{
				if(isset($clivVal['clinic']))
				{
					if(isset($clivVal['clinic']['location_id']) && !empty($clivVal['clinic']['location_id']))
					{
						$location_exists = $this->common_model->getLocation(array('column'=>array('lc.id'),'name'=>strtolower(trim($clivVal['clinic']['location_id'],',')),'city_id'=>$city_id));
						if(is_array($location_exists) && sizeof($location_exists)>0)
						{
							$clivVal['clinic']['location_id'] = key($location_exists);
						}
						else
						{
							$location_name = strtolower(trim($clivVal['clinic']['location_id']));
							$clivVal['clinic']['location_id'] = 0;
							$clivVal['clinic']['other_location'] = $location_name;
							# clinic insertion code is on for new cities
								#$insLocArray = array('name'=>$location_name,'city_id'=>$city_id,'status'=>0);
								#$clivVal['clinic']['location_id'] = $this->location_model->insert_location($insLocArray);
								#if($this->db->affected_rows()>0)
								#{
									#$this->log_message($this->log_file,"\t New Clinic Location Inserted : ".$location_name." ".$clivVal['clinic']['location_id'].NEW_LINE);	
								#}
							# clinic insertion code is on for new cities
							
							$this->log_message($this->log_file,"\t Other Location Inserted : ".$location_name.NEW_LINE);
						}
					}
					else
					{
						$clivVal['clinic']['location_id'] = 0;
					}

					if(isset($clivVal['clinic']['doctor_id']) && !empty($clivVal['clinic']['doctor_id']))
					{
						$clivVal['clinic']['timings'] = json_encode($clivVal['clinic']['timings']);
						$clivVal['clinic']['name'] = (isset($clivVal['clinic']['name']))?$clivVal['clinic']['name']:'clinic';
						$clinicExists = $this->clinic_model->getClinic(array('column'=>array('id'),'exact_name'=>addslashes($clivVal['clinic']['name']),
								'city_id'=>$city_id,'doctor_id'=>$clivVal['clinic']['doctor_id'],'location_id'=>$clivVal['clinic']['location_id']));
						if($clinicExists)
						{

							$this->log_message($this->log_file,"\t Clinic Exists :".$clivVal['clinic']['name'].NEW_LINE);
							$clinic_affected_rows = $this->clinic_model->updateClinic($clivVal['clinic'],$clinicExists[0]['id']);
							if($clinic_affected_rows)
							{
								$this->log_message($this->log_file,"\t Clinic Updates :".$clivVal['clinic']['name'].NEW_LINE);
							}
						}
						else
						{
							/*$rs_lat_long	=	$this->db->query("SELECT `latitude`,`longitude` FROM clinic_old WHERE NAME ='".addslashes($clivVal['clinic']['name'])."' 
							AND location_id='".$clivVal['clinic']['location_id']."' AND city_id='".$city_id."' and `latitude` is not null");
								

							if ($rs_lat_long->num_rows() > 0)
							{
								$lat_long = $rs_lat_long->row_array(); 
								$clivVal['clinic']['latitude'] = $lat_long['latitude'];
								$clivVal['clinic']['longitude'] = $lat_long['longitude'];
								$this->log_message($this->log_file,"\t Clinic lat_long :".$lat_long['latitude']." - ".$lat_long['longitude'].NEW_LINE);
							}*/
							$clinic_insert_id = $this->clinic_model->insertClinic($clivVal['clinic']);
							if($clinic_insert_id)
							{
								$this->log_message($this->log_file,"\t Clinic Inserted :".$clinic_insert_id." - ".$clivVal['clinic']['name'].NEW_LINE);
							}
							else
							{
								$this->log_message($this->log_file,"\t Clinic Not Inserted : ".$clivVal['clinic']['name'].", Error : ".$this->db->_error_message().NEW_LINE);
							}
						}
					}
				}else
				{
					$this->log_message($this->log_file,"\t Clinic : Not Inserted :".$clivKey ."=>". json_encode($clivVal).NEW_LINE);	
				}
			}
			$this->log_message($this->log_file,"\t ----------------------------------------------------".NEW_LINE);
		}
		/* $insertArray loop ends*/
		$insertArray = array();
		
		return false;
	}
	public function doctor_image_upload()
	{
		$file_log = DOCUMENT_ROOT."logs/" .date("YmdHis")."_photo.log";
		$this->log_file = fopen($file_log, "w"); 
		$this->log_message($this->log_file,"Process Stated :".date("Y-m-d H:i:s").NEW_LINE);		
		if(sizeof($_FILES)>0)
		{
			$this->load->library('upload');
			$files = $_FILES;
			$cpt = count($_FILES['photos']['name']);
			for($i=0; $i<$cpt; $i++)
			{
				$_FILES['photos']['name']= $files['photos']['name'][$i];
				$_FILES['photos']['type']= $files['photos']['type'][$i];
				$_FILES['photos']['tmp_name']= $files['photos']['tmp_name'][$i];
				$_FILES['photos']['error']= $files['photos']['error'][$i];
				$_FILES['photos']['size']= $files['photos']['size'][$i];    
				
				$config = array();
				$config['upload_path'] = './uploads/doctor_images/';
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$config['max_size']      = '0';
				$config['overwrite']     = TRUE;
				
				$this->upload->initialize($config);
				if ( ! $this->upload->do_upload('photos'))
				{
					$error = array('error' => $this->upload->display_errors());
					$this->log_message($this->log_file,"\t {$i}) Error :".$this->upload->display_errors().NEW_LINE);		
				}
				else
				{
					$upload_data = $this->upload->data();
					$this->log_message($this->log_file,"\t {$i}) File Uploaded Path :".$upload_data['full_path'].NEW_LINE);		
				}
			}			 
			$this->log_message($this->log_file,"Process Ended :".date("Y-m-d H:i:s").NEW_LINE);
			
			header('Content-Type: plain/text; charset=utf-8');
			header('Content-Disposition: attachment; filename='.basename($file_log));
			readfile($file_log);
		}
	}
	public function doctor_image_import($city,$image)
	{
		$filename_path = '';
		$sourceUrl = "./uploads/doctor_images/";
		if(!empty($image))
		{
			$md        = date('M').date('Y')."/".strtolower(substr($image,0,1));// getting the current month and year for folder name
			$structure = "./media/photos/".$md; // setting the folder path
			// Check if the directory with that particular name is present or not
			if(!is_dir($structure))
			{
				$this->mkpath($structure,0777);
			}
			// setup the image new file name
			$newfilename   = md5($image);#.rand(10,99)
			
			// Get extension of the file
			$ext = pathinfo($image, PATHINFO_EXTENSION);
			// get the full filename with full path as it needs to be entered in the db
		
			$filename_path = $structure."/".$newfilename.".".$ext;
			if(file_exists(DOCUMENT_ROOT.$sourceUrl.$image))
			{
				rename(DOCUMENT_ROOT.$sourceUrl.$image,DOCUMENT_ROOT.$filename_path);
				$this->log_message($this->log_file,"\t Image : moved :".$sourceUrl.$image ."=>". $filename_path.NEW_LINE);	
			}
			else
			{
				if(file_exists(DOCUMENT_ROOT.$filename_path))
				{
					$filename_path	=	'';
					$this->log_message($this->log_file,"\t Image : File Already Present  :". $filename_path.NEW_LINE);	
				}
				else
				{
					$filename_path	=	'';
					$this->log_message($this->log_file,"\t Image : no such file  :".$sourceUrl.$image ."=>". $filename_path.NEW_LINE);	
				}
			}
		}
		return  $filename_path;
	}
	public function doctor_data()
	{
		$this->data['current_tab'] = "doctor_data";
		if(is_array($this->post) && sizeof($this->post)>0)
		{

			$csv_filename = html_entity_decode(str_replace(" ","_",basename($_FILES['csv_file']['name'])));
			$file_log = DOCUMENT_ROOT."logs/" .$csv_filename.".log";
			$this->log_file = fopen($file_log, "w"); 
			$this->log_message($this->log_file,"Process Stated :".date("Y-m-d H:i:s").NEW_LINE);
			
			$this->post = array_map("strtolower",$this->post);
			$files['upload_path'] = './uploads/doctor_csv/';
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
				$filedata = array('upload_data' => $this->upload->data());
				if(($handle = fopen($filedata['upload_data']['full_path'], "r")) !== FALSE)
				{	
					$tmpData =array();
					$columns = fgetcsv($handle);
					$doctor_column_check	=	TRUE;
					$clinic_column_check	=	TRUE;

					#Doctor Column Validation
					$doctor_column_array	=	array('Dr Photograph','Gender','Dr Name','Degree','Speciality','Brief about Dr','Services','Specializations','Education','Experience',
					'Awards and Recognitions','Memberships','Registrations','Star Rating','Languages','Years of Experience','Doctor Mobile Number','Comment');#18
					$doctor_sheet_array	= array_slice($columns,0,18);
					$doctor_validated_array	=	array_diff($doctor_column_array,$doctor_sheet_array);
					if($doctor_column_array!==$doctor_sheet_array)
					{
						$doctor_column_check	=	FALSE;
						$this->log_message($this->log_file,"Doctor Colmuns are not in order or incorrect column names, Refer CSV Sheet Provided error in columns:".NEW_LINE);

					}
					if(is_array($doctor_validated_array) && sizeof($doctor_validated_array)>0)
					{
						$this->log_message($this->log_file,"Please provide valid doctor column details Refer CSV Sheet Provided:".implode(",",$doctor_validated_array).NEW_LINE);
					}
					#Doctor Column Validation
					
					#Clinic Column Validation
					$clinic_column_array	=	array('Locality #','Clinic Name #','Clinic # Phone Number','Clinic Add #','Working Days','Morning Opening Time','Morning Closing Time',
					'Evening Opening Time','Evening Closing Time','Consultation Fee','Status','Comment');#12
					$clinic_sheet_array	= array_slice($columns,18);
					if(is_array($clinic_sheet_array) && sizeof($clinic_sheet_array)	>	0)
					{
						$clinic_sheet_chunk_array =	array_chunk($clinic_sheet_array,12);
						if(is_array($clinic_sheet_chunk_array) && sizeof($clinic_sheet_chunk_array)>0)
						{
							$newValue	=	1;
							foreach($clinic_sheet_chunk_array as $clniic_values)
							{
								$info = array_map(function($clinic_column_array) use ($newValue){ 
										return str_replace('#', $newValue, $clinic_column_array);
								}, $clinic_column_array);									
								if($info!==$clniic_values)
								{
									$clinic_column_check	=	FALSE;
									$this->log_message($this->log_file,"clniic {$newValue} Colmuns are not in order or incorrect column names, Current Column Order Is ". implode(",",$clniic_values).NEW_LINE);
								}
								$clinic_validated_array[]	=	array_diff($info,$clniic_values);
								$newValue++;
							}
							if(is_array($clinic_validated_array) && sizeof($clinic_validated_array)>0)
							{
								foreach($clinic_validated_array as $clniic_valid_val)
								{
									if(is_array($clniic_valid_val) && sizeof($clniic_valid_val)>0)
									{
										$this->log_message($this->log_file,"Error in clniic column details Refer CSV Sheet Provided : ".implode(",",$clniic_valid_val).NEW_LINE);
									}
								}
								
							}
						}
						else
						{
							$clinic_column_check	=	FALSE;
							$this->log_message($this->log_file,"clnic details are provided but not in proper format, Refer CSV Sheet Provided :".NEW_LINE);
						
						}
						
					}
					else
					{
						$clinic_column_check	=	FALSE;
						$this->log_message($this->log_file,"Please provide atleast 1 clinic details Refer CSV Sheet Provided :".NEW_LINE);
					}
					#Clinic Column Validation	

					if($clinic_column_check && $doctor_column_check)
					{
						while(($data = fgetcsv($handle)) !== FALSE)
						{
							if(empty($data[2]))
							{
								$tmpData[]=$data;
							}else
							{
								if(sizeof($tmpData)>0)
								{
									$this->doctor_import_process($tmpData);
									$tmpData = array();
								}
								$tmpData[]=$data;
							}
						}
						if(is_array($tmpData) && sizeof($tmpData)>0)
						{
							$this->doctor_import_process($tmpData);
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
			$this->load->model(array('common_model'));
			$this->data['city'] = $this->common_model->getCity(array('status'=>1,'column'=>array('id','name'))); 
			$this->data['perms']	=	$this->perms;
			$this->load->view('admin/doctor_import',$this->data);
		}
	}
	public function download_file()
	{
		$file_name =	DOCUMENT_ROOT.$_GET['file_name'];
		if(file_exists($file_name))
		{
			$path_parts = pathinfo($file_name);

			// headers to send your file
			header('Content-Type: text/csv; charset=utf-8');
			header("Content-Length: " . filesize($file_name));
			header('Content-Disposition: attachment; filename="' . $path_parts['basename']. '"');

			// upload the file to the user and quit
			readfile($file_name);
			exit;		
		}
		else
		{
			header('Content-Type: plain/text; charset=utf-8');
			header('Content-Disposition: attachment; filename=not_exists.txt');
			echo "file ".$_GET['file_name']." does not exists ";
			exit;		
		}
	}
	public function location_data()
	{
		$this->data['current_tab'] = "location_data";
		if(is_array($this->post) && sizeof($this->post)>0)
		{
			$city_id = $this->post['city_id'];

			$csv_filename = html_entity_decode(str_replace(" ","_",basename($_FILES['csv_file']['name'])));
			$file_log = DOCUMENT_ROOT."logs/" .$csv_filename.".log";
			$this->log_file = fopen($file_log, "w"); 
			$this->log_message($this->log_file,"Process Stated :".date("Y-m-d H:i:s").NEW_LINE);
			
			$this->post = array_map("strtolower",$this->post);
			$files['upload_path'] = './uploads/doctor_csv/';
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
				$filedata = array('upload_data' => $this->upload->data());
				if(($handle = fopen($filedata['upload_data']['full_path'], "r")) !== FALSE)
				{	
					$columns = fgetcsv($handle);
					$k=1;
					while(($data = fgetcsv($handle)) !== FALSE)
					{
							if(!empty($data[0]) && !empty($data[1]) )
							{
								$insLocArray = array('name'=>$data[0],'url_name'=>$data[1],'city_id'=>$city_id,'created_on'=>date("Y-m-d H:i:s"),'status'=>1);
								$insert_id	=	 $this->location_model->insert_location($insLocArray);
								if($insert_id)
								{
									$this->log_message($this->log_file,"\t Location Inserted : ".$data[0]." ". $insert_id.NEW_LINE);	
								}
								else
								{
									$this->log_message($this->log_file,"\t Location Already Exists/ Not Inserted : ".$k." ".$data[0].NEW_LINE);	
								}
							}
							else
							{
									$this->log_message($this->log_file,"\t Location Name and Url name Reuered : ".$k." ".$data[0]." ". $data[1].NEW_LINE);	
							}
					$k++;
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
			$this->load->model(array('common_model'));
			$this->data['city'] = $this->common_model->getCity(array('status'=>1,'column'=>array('id','name'))); 
			$this->data['perms']	=	$this->perms;
			$this->load->view('admin/location_import',$this->data);
		}
	}
	public function doctor_withid_import_process($data)
	{
		$doctor_id			=	intval($data[0]);
		$clinic_id			=	intval($data[1]);
		$doctor_exists_query	=	$this->db->query("select id from doctor where id=".$doctor_id." and status=1");
		
		if(!empty($doctor_id) && !empty($clinic_id) && $doctor_exists_query->num_rows>0)
		{
			$city_name				=	 'pune';
			$latitude				=	$data[13];
			$longitude				=	$data[14];
			$address				=	$data[17];
			$consultation_fees		=	$data[16];
			$contact_number			=	$data[11];
			
			$doctor_contact_number	=	$data[9];
			$year_of_experience		=	$data[8];
			$doctor_summary			=	$data[7];
	
			$filename_path 	= $this->doctor_image_import($city_name,$data[2]);
			$doctor_update_array	=	$clinic_update_array	=	array();
			
			if(!empty($filename_path))
			{
					$doctor_update_array['image']	=	$filename_path;
			}
			/*if(!empty($doctor_contact_number))
			{
					$doctor_update_array['contact_number']	=	$doctor_contact_number;
			}
			if(!empty($year_of_experience))
			{
					$doctor_update_array['yoe']	=	$year_of_experience;
			}
			if(!empty($doctor_summary))
			{
					$doctor_update_array['summary']	=	$doctor_summary;
			}*/
		
			if(!empty($latitude))
			{
				$clinic_update_array['latitude']	=	$latitude;
				$clinic_update_array['longitude']	=	$longitude;
			}
			/*if(!empty($address))
			{
				$clinic_update_array['address']	=	$address;
			}
			if(!empty($consultation_fees))
			{
				$clinic_update_array['consultation_fees']	=	$consultation_fees;
			}
			if(!empty($contact_number))
			{
				$clinic_update_array['contact_number']	=	$contact_number;
			}*/

			if(sizeof($doctor_update_array)>0)
			{
				$this->db->update('doctor',	$doctor_update_array, array('id'=>$doctor_id,'status'=>1));
				if($this->db->affected_rows()	>	0)
				{
					$this->log_message($this->log_file,"\t Doctor Updated : ".$doctor_id ." - ".$data['4']." - ".$this->db->last_query().NEW_LINE);
				}
				else if(!empty($filename_path))
				{
					$this->log_message($this->log_file,"\t Why Doctor Not Updated : ".$doctor_id ." - ".$data['4']." - ".$this->db->last_query().NEW_LINE);
				}
			}
			
			if(sizeof($clinic_update_array)>0)
			{
				$this->db->update('clinic',	$clinic_update_array, array('id'=>$clinic_id,'status'=>1));
				if($this->db->affected_rows()	>	0)
				{
					$this->log_message($this->log_file,"\t Clinic Updated : ".$clinic_id ." - ".$this->db->last_query().NEW_LINE);
				}
			}
		$this->log_message($this->log_file,"\t ------------".NEW_LINE);
		}
	}
	public function doctor_withids()
	{
		$this->data['current_tab'] = "doctor_data";
		if(isset($_FILES['csv_file'])&& is_array($_FILES['csv_file'])  &&  sizeof($_FILES['csv_file'])>0)
		{
			
			$csv_filename = html_entity_decode(str_replace(" ","_",basename($_FILES['csv_file']['name'])));
			$file_log = DOCUMENT_ROOT."logs/" .$csv_filename.".log";
			$this->log_file = fopen($file_log, "w"); 
			$this->log_message($this->log_file,"Process Stated :".date("Y-m-d H:i:s").NEW_LINE);
			
			if($this->post)
			{
				$this->post = array_map("strtolower",$this->post);
			}
			$files['upload_path'] = './uploads/doctor_csv/';
			$files['allowed_types'] = 'csv';
			$files['file_name'] = $csv_filename;
			$this->load->library('upload', $files);
			if ( ! $this->upload->do_upload("csv_file"))
			{
				$error = array('error' => $this->upload->display_errors());
				echo $error['error'];exit;
			}
			else
			{
				$filedata = array('upload_data' => $this->upload->data());
				if(($handle = fopen($filedata['upload_data']['full_path'], "r")) !== FALSE)
				{	
					$tmpData =array();
					$columns = fgetcsv($handle);
					$doctor_column_check	=	TRUE;
					$clinic_column_check	=	TRUE;

					#Doctor Column Validation
					$doctor_column_array	=	array('doctor_id','clinic_id','Dr Photograph','Gender','Dr Name','Degree','Speciality','Brief about Dr','Years of Experience','Doctor Mobile Number','is_doctor_verified_registered','clinic_number','clinic_is_number_verified','clinic_latitude'
,'clinic_longitude','clinic_timings','clinic_consultation_fees','clinic_address','clinic_location','clinic_pincode');
					
					
					$doctor_sheet_array	= $columns;
					#print_r($doctor_column_array);print_r($doctor_sheet_array);exit;
					$doctor_validated_array	=	array_diff($doctor_column_array,$doctor_sheet_array);
					if($doctor_column_array!==$doctor_sheet_array)
					{
						$doctor_column_check	=	FALSE;
						$this->log_message($this->log_file,"Doctor Colmuns are not in order or incorrect column names, Refer CSV Sheet Provided error in columns:".NEW_LINE);

					}
					if(is_array($doctor_validated_array) && sizeof($doctor_validated_array)>0)
					{
						$this->log_message($this->log_file,"Please provide valid doctor column details Refer CSV Sheet Provided:".implode(",",$doctor_validated_array).NEW_LINE);
					}
					#Doctor Column Validation
					

					if($doctor_column_check)
					{
						while(($data = fgetcsv($handle)) !== FALSE)
						{
								$this->doctor_withid_import_process($data);							
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
			$this->data['perms']	=	$this->perms;
			$this->load->view('admin/doctor_import',$this->data);
		}
	
	}
}