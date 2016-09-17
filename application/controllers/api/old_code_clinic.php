				/* This code is used to display json encoded timings  into textual format*/
				$clinic['disptimings'] = $clinic['timings'];

				foreach($clinic['disptimings'] as $dispKey=>$dispVal){
					foreach($dispVal as $inDispKey=>$inDispVal){
						if(!empty($inDispVal[0]) && !empty($inDispVal[1]) ){
							if($inDispKey==0){
									$half_arr["fh"][date("h:ia",strtotime($inDispVal[0]))."-".date("h:ia",strtotime($inDispVal[1]))][$dispKey] = $dispKey; 
							}else if($inDispKey==1){
								$half_arr["sh"][date("h:ia",strtotime($inDispVal[0]))."-".date("h:ia",strtotime($inDispVal[1]))][$dispKey] = $dispKey; 
							}
						}	
					}
				}

				$new_tmp_arr = array();
				$tmpday =array();
				foreach($half_arr as $halfKey=>$halfVal){
					foreach($halfVal as $tmpKey=>$tmpVal){
						$tmp = false;
						foreach($tmpVal as $dayKey=>$dayVal){
							if(isset($tmpVal[$dayKey+1]) && ($tmpVal[$dayKey+1]-$tmpVal[$dayKey])==1 ){
								$tmpday[] = $dayVal; 		
								$tmp = true;
							}else{
								$tmpday[] = $dayVal; 		
								$new_tmp_arr[$halfKey][$tmpKey][] = $tmpday;		
								$tmp = false;
								$tmpday =array();
							}
	
						}
					}
				}

				$cnt =0;
				foreach($new_tmp_arr as $halftnKey=>$halftnVal){
					foreach($halftnVal as $tnKey=>$tnVal){
						foreach($tnVal as $intnKey=>$intnVal){
							
							if(sizeof($intnVal)==1){
								$first_key = current($intnVal);
								$new1_tmp_arr[$halftnKey][$cnt]['day'] = $weekday[$first_key];
								$new1_tmp_arr[$halftnKey][$cnt]['time'] = $tnKey;
							}else{
								$first_key = current($intnVal);
								$last_key = end($intnVal);
								$new1_tmp_arr[$halftnKey][$cnt]['day']=$weekday[$first_key]."-".$weekday[$last_key];
								$new1_tmp_arr[$halftnKey][$cnt]['time']=$tnKey;
							}
							$cnt++;
						}
						
					}
					$cnt =0;
					
				}

				$clinic['disptimings'] = $new1_tmp_arr;
				/* This code is used to display json encoded timings  into textual format*/
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
								/* This code is used to display json encoded timings  into textual format*/
				$clinic['disptimings'] = $clinic['timings'];

				foreach($clinic['disptimings'] as $dispKey=>$dispVal){
					foreach($dispVal as $inDispKey=>$inDispVal){
						if(!empty($inDispVal[0]) && !empty($inDispVal[1]) ){
							if($inDispKey==0){
									$tmp_arr[date("h:ia",strtotime($inDispVal[0]))."-".date("h:ia",strtotime($inDispVal[1]))][$dispKey] = $dispKey; 
							}else if($inDispKey==1){
									$tmp_arr[date("h:ia",strtotime($inDispVal[0]))."-".date("h:ia",strtotime($inDispVal[1]))][$dispKey] = $dispKey; 
							}
						}	
					}
				}
				#print_r($tmp_arr);exit;
				$new_tmp_arr = array();
				$tmpday =array();
				
					foreach($tmp_arr as $tmpKey=>$tmpVal){
						$tmp = false;
						foreach($tmpVal as $dayKey=>$dayVal){
							if(isset($tmpVal[$dayKey+1]) && ($tmpVal[$dayKey+1]-$tmpVal[$dayKey])==1 ){
								$tmpday[] = $dayVal; 		
								$tmp = true;
							}else{
								$tmpday[] = $dayVal; 		
								$new_tmp_arr[$tmpKey][] = $tmpday;		
								$tmp = false;
								$tmpday =array();
							}
	
						}
					}
				
				#print_r($new_tmp_arr);exit;
				$cnt =0;
				$wday_arr = array();
				foreach($new_tmp_arr as $tnKey=>$tnVal){
						foreach($tnVal as $intnKey=>$intnVal){
							
							if(sizeof($intnVal)==1){
								$first_key = current($intnVal);
								if(in_array($first_key,$wday_arr)){
									$new1_tmp_arr[$cnt-1]['time2'] = $tnKey;	
								}else{
									$new1_tmp_arr[$cnt]['day'] = $weekday[$first_key];
									$new1_tmp_arr[$cnt]['time1'] = $tnKey;	
									$cnt++;
								}
								$wday_arr[] = $first_key;
							}else{

								$first_key = current($intnVal);
								$last_key = end($intnVal);
								
								#$new1_tmp_arr[$cnt]['day']=$weekday[$first_key]."-".$weekday[$last_key];
								#$new1_tmp_arr[$cnt]['time1']=$tnKey;

								if(in_array($first_key,$wday_arr)){
									$new1_tmp_arr[$cnt-1]['time2'] = $tnKey;	
								}else{
									$new1_tmp_arr[$cnt]['day']=$weekday[$first_key]."-".$weekday[$last_key];
									$new1_tmp_arr[$cnt]['time1']=$tnKey;
									$cnt++;
								}
								$wday_arr[] = $first_key;
							}
							
						}
					
				}

				$clinic['disptimings'] = $new1_tmp_arr;
				/* This code is used to display json encoded timings  into textual format*/
				