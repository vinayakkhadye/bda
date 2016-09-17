<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?php $this->load->view('admin/common/head'); ?>
		<!-- <link type="text/css" rel="stylesheet" href="<?php echo CSS_URL; ?>admin/doctor.css"/> -->
		
		 
	</head>
	<body>
		<?php $this->load->view('admin/common/header'); ?>
		<?php //$this->load->view('admin/common/left_menu'); ?>
		<div class="container-fluid">
		<div class="panel panel-default">
		<div class="panel-heading">Doctor Extra Profile Details</div>

		<div class="panel-body"> 
				<form action="/bdabdabda/manage_doctors/post_doctor_extra_details/<?=$all_details['doctor_id']?>" method="POST">
					<table class="table table-striped table-condensed table-bordered table-responsive" >
						<tr>
							<td>Services offered</td>
							<td class="right-col">
								<div class="InputsWrapper" id="services">
								<?php if((is_array($doctor_extra_details) && sizeof($doctor_extra_details) > 0)):
									foreach($doctor_extra_details as $row): 
									if(isset($row['attribute']) && $row['attribute'] == 'Services'):
								?>
									<div>
										<?php
											echo '<div><input type="text" name="services[]" value="'.ucfirst($row['description1']).'" /><a href="javascript:void(0);" class="removeclass" id="services">Remove</a><br/></div>';
										?>
									</div>
								<?php endif; ?>
								<?php endforeach; ?>
								<?php endif; ?>
								</div>
								
								<div class="AddMoreFileId floatleft">
									<a href="javascript:void(0);" class="AddMoreFileBox" id="services">Add More</a><br><br>
								</div>
								<div class="AddMoreFileId">
									<a href="javascript:void(0);" class="AddMoreFileBox" id="services_other">Add Other</a><br><br>
								</div>
								<div id="lineBreak clearboth"></div>
							</td>
						</tr>
						<!--<tr>
							<td>Specializations</td>
							<td class="right-col">
								<div class="InputsWrapper" id="specializations">
								<?php if((is_array($doctor_extra_details) && sizeof($doctor_extra_details) > 0)):
									if(isset($row['attribute']) && $row['attribute'] == 'Specializations'):
									foreach($doctor_extra_details as $row): 
								?>
									<div>
										<?php
											echo '<div><input type="text" name="specializations[]" value="'.ucfirst($row['description1']).'" /><a href="javascript:void(0);" class="removeclass" id="specializations">Remove</a><br/></div>';
										?>
									</div>
								<?php endforeach; ?>
								<?php endif; ?>
								<?php endif; ?>
								</div>
								
								<div class="AddMoreFileId floatleft">
									<a href="javascript:void(0);" class="AddMoreFileBox" id="specializations">Add More</a><br><br>
								</div>
								<div class="AddMoreFileId">
									<a href="javascript:void(0);" class="AddMoreFileBox" id="specializations_other">Add Other</a><br><br>
								</div>
								<div id="lineBreak clearboth"></div>
							</td>
						</tr>-->
						<tr>
							<td>Education</td>
							<td class="right-col">
								<div class="InputsWrapper" id="education">
								<?php if((is_array($doctor_extra_details) && sizeof($doctor_extra_details) > 0)):
								foreach($doctor_extra_details as $row): 
									if(isset($row['attribute']) && $row['attribute'] == 'Education'):
								?>
									<div>
										<?php
											echo '<div>
											<input type="text" name="education_qualification[]" value="'.ucfirst($row['description1']).'" style="width: 120px;" />
											<input type="text" name="education_college[]" value="'.ucfirst($row['description2']).'" style="width: 120px;" />
											<input type="text" name="education_from_year[]" value="'.ucfirst($row['from_year']).'" style="width: 120px;" />
											<a href="javascript:void(0);" class="removeclass" id="education">Remove</a>
											<br/></div>';
										?>
									</div>
								<?php endif; ?>
								<?php endforeach; ?>
								<?php endif; ?>
								</div>
								
								<div class="AddMoreFileId floatleft">
									<a href="javascript:void(0);" class="AddMoreFileBox" id="education">Add More</a><br><br>
								</div>
								<div class="AddMoreFileId">
									<a href="javascript:void(0);" class="AddMoreFileBox" id="education_other">Add Other</a><br><br>
								</div>
								<div id="lineBreak clearboth"></div>
							</td>
						</tr>
						<tr>
							<td>Experience</td>
							<td class="right-col">
								<div class="InputsWrapper" id="experience">
								<?php if((is_array($doctor_extra_details) && sizeof($doctor_extra_details) > 0)):
								foreach($doctor_extra_details as $row): 
									if(isset($row['attribute']) && $row['attribute'] == 'Experience'):
								?>
									<div>
										<?php
											echo '<div>
											<input type="text" name="experience_from_year[]" value="'.ucfirst($row['from_year']).'" style="width: 50px;" /> to 
											<input type="text" name="experience_to_year[]" value="'.ucfirst($row['to_year']).'" style="width: 50px;" />
											<input type="text" name="experience_role[]" value="'.ucfirst($row['description1']).'" style="width: 120px;" />
											<input type="text" name="experience_hospital[]" value="'.ucfirst($row['description2']).'" style="width: 120px;" /> at 
											<input type="text" name="experience_city[]" value="'.ucfirst($row['description3']).'" style="width: 50px;" />
											<a href="javascript:void(0);" class="removeclass" id="experience">Remove</a>
											<br/></div>';
										?>
									</div>
								<?php endif; ?>
								<?php endforeach; ?>
								<?php endif; ?>
								</div>
								
								<div class="AddMoreFileId floatleft">
									<a href="javascript:void(0);" class="AddMoreFileBox" id="experience">Add More</a><br><br>
								</div>
								<div class="AddMoreFileId">
									<a href="javascript:void(0);" class="AddMoreFileBox" id="experience_other">Add Other</a><br><br>
								</div>
								<div id="lineBreak clearboth"></div>
							</td>
						</tr>
						<tr>
							<td>Awards & Recognitions</td>
							<td class="right-col">
								<div class="InputsWrapper" id="awards">
								<?php if((is_array($doctor_extra_details) && sizeof($doctor_extra_details) > 0)):
								foreach($doctor_extra_details as $row): 
									if(isset($row['attribute']) && $row['attribute'] == 'AwardsAndRecognitions'):
								?>
									<div>
										<?php
											echo '<div>
											<input type="text" name="awardsandrecognitions_award[]" value="'.ucfirst($row['description1']).'" style="width: 280px;" />
											<input type="text" name="awardsandrecognitions_from_year[]" value="'.ucfirst($row['from_year']).'" style="width: 80px;" />
											<a href="javascript:void(0);" class="removeclass" id="awards">Remove</a>
											<br/></div>';
										?>
									</div>
								<?php endif; ?>
								<?php endforeach; ?>
								<?php endif; ?>
								</div>
								
								<div class="AddMoreFileId floatleft">
									<a href="javascript:void(0);" class="AddMoreFileBox" id="awards">Add More</a><br><br>
								</div>
								<div class="AddMoreFileId">
									<a href="javascript:void(0);" class="AddMoreFileBox" id="awards_other">Add Other</a><br><br>
								</div>
								<div id="lineBreak clearboth"></div>
							</td>
						</tr>
						<tr>
							<td>Membership</td>
							<td class="right-col">
								<div class="InputsWrapper" id="membership">
								<?php if((is_array($doctor_extra_details) && sizeof($doctor_extra_details) > 0)):
								foreach($doctor_extra_details as $row): 
									if(isset($row['attribute']) && $row['attribute'] == 'Membership'):
								?>
									<div>
										<?php
											echo '<div>
											<input type="text" name="membership[]" value="'.ucfirst($row['description1']).'" style="width: 380px;" />
											<a href="javascript:void(0);" class="removeclass" id="membership">Remove</a>
											<br/></div>';
										?>
									</div>
								<?php endif; ?>
								<?php endforeach; ?>
								<?php endif; ?>
								</div>
								
								<div class="AddMoreFileId floatleft">
									<a href="javascript:void(0);" class="AddMoreFileBox" id="membership">Add More</a><br><br>
								</div>
								<div class="AddMoreFileId">
									<a href="javascript:void(0);" class="AddMoreFileBox" id="membership_other">Add Other</a><br><br>
								</div>
								<div id="lineBreak clearboth"></div>
							</td>
						</tr>
						<tr>
							<td>Registrations</td>
							<td class="right-col">
								<div class="InputsWrapper" id="registrations">
								<?php if((is_array($doctor_extra_details) && sizeof($doctor_extra_details) > 0)):
								foreach($doctor_extra_details as $row): 
									if(isset($row['attribute']) && $row['attribute'] == 'Registrations'):
								?>
									<div>
										<?php
											echo '<div>
											<input type="text" name="registrations_no[]" value="'.ucfirst($row['description1']).'" style="width: 150px;" />
											<input type="text" name="registrations_council[]" value="'.ucfirst($row['description2']).'" style="width: 150px;" />
											<input type="text" name="registrations_year[]" value="'.ucfirst($row['from_year']).'" style="width: 150px;" />
											<a href="javascript:void(0);" class="removeclass" id="registrations">Remove</a>
											<br/></div>';
										?>
									</div>
								<?php endif; ?>
								<?php endforeach; ?>
								<?php endif; ?>
								</div>
								
								<div class="AddMoreFileId floatleft">
									<a href="javascript:void(0);" class="AddMoreFileBox" id="registrations">Add More</a><br><br>
								</div>
								<div class="AddMoreFileId">
									<a href="javascript:void(0);" class="AddMoreFileBox" id="registrations_other">Add Other</a><br><br>
								</div>
								<div id="lineBreak clearboth"></div>
							</td>
						</tr>
						<tr>
							<td>Additional Qualifications</td>
							<td class="right-col">
								<div class="InputsWrapper" id="qualifications">
								<?php if((is_array($doctor_extra_details) && sizeof($doctor_extra_details) > 0)):
								foreach($doctor_extra_details as $row): 
									if(isset($row['attribute']) && $row['attribute'] == 'Qualifications'):
								?>
									<div>
										<?php
											echo '<div>
											<input type="text" name="qualifications[]" value="'.ucfirst($row['description1']).'" />
											<a href="javascript:void(0);" class="removeclass" id="qualifications">Remove</a>
											<br/></div>';
										?>
									</div>
								<?php endif; ?>
								<?php endforeach; ?>
								<?php endif; ?>
								</div>
								
								<div class="AddMoreFileId">
									<a href="javascript:void(0);" class="AddMoreFileBox" id="qualifications_other">Add Other</a><br><br>
								</div>
								<div id="lineBreak clearboth"></div>
							</td>
						</tr>
						<tr>
							<td>Papers published</td>
							<td class="right-col">
								<div class="InputsWrapper" id="paperspublished">
								<?php if((is_array($doctor_extra_details) && sizeof($doctor_extra_details) > 0)):
								foreach($doctor_extra_details as $row): 
									if(isset($row['attribute']) && $row['attribute'] == 'PapersPublished'):
								?>
									<div>
										<?php
											echo '<div>
											<input type="text" name="paperspublished[]" value="'.ucfirst($row['description1']).'" />
											<a href="javascript:void(0);" class="removeclass" id="paperspublished">Remove</a>
											<br/></div>';
										?>
									</div>
								<?php endif; ?>
								<?php endforeach; ?>
								<?php endif; ?>
								</div>
								
								<div class="AddMoreFileId">
									<a href="javascript:void(0);" class="AddMoreFileBox" id="paperspublished_other">Add Other</a><br><br>
								</div>
								<div id="lineBreak clearboth"></div>
							</td>
						</tr>
						
						<tr>
							<td>Short Brief about Practice</td>
							<td><input type="text" name="doctor_summary" value="<?=@$all_details['summary']?>" /></td>
						</tr>
						
						<tr>
							<td>Patient Reviews</td>
							<td class="right-col">
								<div class="InputsWrapper" id="patient">
								<?php //print_r($patient_numbers);
									if((is_array($patient_numbers) && sizeof($patient_numbers) > 0)):
									foreach($patient_numbers as $row): 
								?>
									<div>
										<?php
											echo '<div>
											<input type="text" name="patient_name[]" value="'.$row['patient_name'].'" style="width: 130px;" />
											<input type="text" name="patient_number[]" value="'.$row['patient_number'].'" maxlength="10" style="width: 130px;" />
											<a href="javascript:void(0);" class="removeclass" id="patient">Remove</a>
											<br/></div>';
										?>
									</div>
								<?php endforeach; ?>
								<?php endif; ?>
								</div>
								
								<div class="AddMoreFileId">
									<a href="javascript:void(0);" class="AddMoreFileBox" id="patient_other">Add Other</a><br><br>
								</div>
								<div id="lineBreak clearboth"></div>
							</td>
						</tr>
						
						<tr>
							<td colspan="2" style="text-align: center;">
								<input type="submit" name="submit" value="Save Changes" id="submit" style="width: 120px; height: 30px;" />
							</td>
						</tr>
					</table>
				</form>
				
				<div class="clearboth"></div>
				
			</div>


		<div class="panel-footer">
<?php $this->load->view('admin/common/footer'); ?>
</div>
</div>
</div>
<?php $this->load->view('admin/common/bottom'); ?>
 
		<script type="text/javascript">
			$(document).ready(function()
				{
					$("#left_Panel").height($("#content_area").height());
					
					$.fn.addelement = function(element)
					{
						//console.log(this);
						var id = this.attr('id');
						if(id == 'services_other')
						{
							$(".InputsWrapper#services").last().append('<div><input type="text" name="services[]" value="" /><a href="javascript:void(0);" class="removeclass" id="services">Remove</a><br/></div>');
						}
						else if(id == 'services')
						{
							$(".InputsWrapper#services").last().append("<div><select name=\"services[]\" ><option value=\"\">Select Service</option><?php foreach($services as $key=>$val) { ?> <option value=\"<?=mysql_real_escape_string($val['name'])?>\"><?=mysql_real_escape_string($val['name'])?></option><?php }; ?></select><a href=\"javascript:void(0);\" class=\"removeclass\" id=\"services\">Remove</a><br/></div>");
						}
						else if(id == 'specializations_other')
						{
							$(".InputsWrapper#specializations").last().append('<div><input type="text" name="specializations[]" value="" /><a href="javascript:void(0);" class="removeclass" id="specializations">Remove</a><br/></div>');
						}
						else if(id == 'specializations')
						{
							$(".InputsWrapper#specializations").last().append("<div><select name=\"specializations[]\" ><option value=\"\">Select specializations</option><?php foreach($specializations as $key=>$val) { ?> <option value=\"<?=mysql_real_escape_string($val['name'])?>\"><?=mysql_real_escape_string($val['name'])?></option><?php }; ?></select><a href=\"javascript:void(0);\" class=\"removeclass\" id=\"specializations\">Remove</a><br/></div>");
						}
						else if(id == 'education')
						{
							$(".InputsWrapper#education").last().append("<div><select name=\"education_qualification[]\"  style=\"width: 125px;\" ><option value=\"\">Degree</option><?php foreach($qualification as $key=>$val){ ?><option value=\"<?=mysql_real_escape_string($val['name'])?>\"><?=mysql_real_escape_string($val['name'])?></option><?php } ?></select>&nbsp;<select name=\"education_college[]\"  style=\"width: 125px;\"><option value=\"\">College Name</option><?php foreach($college as $key=>$val){ ?><option value=\"<?=mysql_real_escape_string($val['name'])?>\"><?=mysql_real_escape_string($val['name'])?></option><?php } ?></select>&nbsp;<select name=\"education_from_year[]\" style=\"width: 125px;\" ><option value=\"\">Year</option><?php foreach($from_year as $val){?><option value=\"<?=$val?>\"><?=$val?></option><?php } ?></select><a href=\"javascript:void(0);\" class=\"removeclass\" id=\"education\">Remove</a><br/></div>");
						}
						else if(id == 'education_other')
						{
							$(".InputsWrapper#education").last().append("<div><input type=\"text\" style=\"width: 120px;\" value=\"\" name=\"education_qualification[]\"><input type=\"text\" style=\"width: 120px;\" value=\"\" name=\"education_college[]\"><input type=\"text\" style=\"width: 120px;\" value=\"\" name=\"education_from_year[]\"><a id=\"education\" class=\"removeclass\" href=\"javascript:void(0);\">Remove</a><br></div>");
						}
						else if(id == 'experience')
						{
							$(".InputsWrapper#experience").last().append($("#experience_more_to_copy").html());
						}
						else if(id == 'experience_other')
						{
							$(".InputsWrapper#experience").last().append("<div><input type=\"text\" style=\"width: 50px;\" value=\"\" name=\"experience_from_year[]\"> to <input type=\"text\" style=\"width: 50px;\" value=\"\" name=\"experience_to_year[]\"><input type=\"text\" style=\"width: 120px;\" value=\"\" name=\"experience_role[]\"><input type=\"text\" style=\"width: 120px;\" value=\"\" name=\"experience_hospital[]\"> at <input type=\"text\" style=\"width: 50px;\" value=\"\" name=\"experience_city[]\"><a id=\"experience\" class=\"removeclass\" href=\"javascript:void(0);\">Remove</a><br></div>");
						}
						else if(id == 'awards')
						{
							$(".InputsWrapper#awards").last().append($("#awards_more_to_copy").html());
						}
						else if(id == 'awards_other')
						{
							$(".InputsWrapper#awards").last().append($("#awards_other_more_to_copy").html());
						}
						else if(id == 'membership')
						{
							$(".InputsWrapper#membership").last().append($("#membership_more_to_copy").html());
						}
						else if(id == 'membership_other')
						{
							$(".InputsWrapper#membership").last().append($("#membership_other_more_to_copy").html());
						}
						else if(id == 'registrations')
						{
							$(".InputsWrapper#registrations").last().append($("#registrations_more_to_copy").html());
						}
						else if(id == 'registrations_other')
						{
							$(".InputsWrapper#registrations").last().append($("#registrations_other_more_to_copy").html());
						}
						else if(id == 'qualifications_other')
						{
							$(".InputsWrapper#qualifications").last().append($("#qualifications_other_more_to_copy").html());
						}
						else if(id == 'paperspublished_other')
						{
							$(".InputsWrapper#paperspublished").last().append($("#paperspublished_other_more_to_copy").html());
						}
						 
						else if(id == 'patient_other')
						{
							$(".InputsWrapper#patient").last().append($("#patient_other_more_to_copy").html());
						}
						
						
						
						
						
						
						
						
						
						
						
						// Attaching the click event on newly created removeclass element
						$(".removeclass").click(function()
						{
							$(this).removeelement(this.id);
						});
						$("#left_Panel").height($("#content_area").height());
					};
					
					$.fn.removeelement = function(element)
					{
						this.parent('div').remove();
					};
					
					$(".AddMoreFileBox").click(function()
					{
						$(this).addelement();
					});
					
					$(".removeclass").on("click",function()
					{
						$(this).removeelement(this.id);
					});
				});
		</script>
		
		<div style="display: none;">
		
			<div id="experience_more_to_copy">
				<div class="clearboth">
					<select name="experience_from_year[]"  style="width:55px;">
						<option value="">
							Year
						</option>
						<?php
						foreach($from_year as $val)
						{
							?>
							<option value="<?=$val?>">
								<?=$val?>
							</option>
							<?php
						} ?>
					</select>
					to
					<select name="experience_to_year[]"  style="width:55px;">
						<option value="">
							Year
						</option>
						<?php
						foreach($to_year as $val){
							?>
							<option value="<?=$val?>">
								<?=$val?>
							</option>
							<?php
						} ?>
					</select>
					<input name="experience_role[]" type="text" class="date" placeholder="Role" style="width:125px;" />
					<input name="experience_hospital[]" type="text" class="date" placeholder="Hospital / Clinic" style="width:120px;" />
					at
					<select name="experience_city[]" style="width:60px;">
						<option value="">
							City
						</option>
						<?php
						foreach($city as $key=>$val){
							?>
							<option value="<?=mysql_real_escape_string($val['name'])?>">
								<?=mysql_real_escape_string($val['name'])?>
							</option>
							<?php
						} ?>
					</select>
					<a href="javascript:void(0);" class="removeclass" id="experience">
						Remove
					</a><br/>
				</div>
			</div>
			
			<div id="awards_more_to_copy">
				<div>
					<input name="awardsandrecognitions_award[]" value="" type="text" style="width: 280px;" />
					&nbsp;
					<select name="awardsandrecognitions_from_year[]" style="width:78px;">
						<option value="">
							Year
						</option>
						<?php
						foreach($from_year as $val)
						{
							?>
							<option value="<?=mysql_real_escape_string($val)?>">
								<?=mysql_real_escape_string($val)?>
							</option>
							<?php
						} ?>
					</select>
					<a href="javascript:void(0);" class="removeclass" id="awards">
						Remove
					</a><br/>
				</div>
			</div>
			
			<div id="awards_other_more_to_copy">
				<div>
					<input type="text" style="width: 280px;" value="" name="awardsandrecognitions_award[]">
					<input type="text" style="width: 80px;" value="" name="awardsandrecognitions_from_year[]">
					<a id="awards" class="removeclass" href="javascript:void(0);">Remove</a><br>
				</div>
			</div>
			
			<div id="membership_more_to_copy">
				<div>
					<select name="membership[]" style="width: 380px;">
						<option value="">
							Select membership
						</option>
						<?php
						foreach($membership as $key=>$val)
						{
							?>
							<option value="<?=mysql_real_escape_string($val['name'])?>">
								<?=mysql_real_escape_string($val['name'])?>
							</option>
							<?php
						} ?>
					</select>
					<a href="javascript:void(0);" class="removeclass" id="membership">Remove</a><br/>
				</div>
			</div>
			
			<div id="membership_other_more_to_copy">
				<div>
					<input type="text" name="membership[]" value="" style="width: 380px;" />
						<a href="javascript:void(0);" class="removeclass" id="membership">Remove</a>
					<br/>
				</div>
			</div>
			
			<div id="registrations_more_to_copy">
				<div>
					<input name="registrations_no[]" type="text" placeholder="Reg No" style="width:150px;" />
					<select name="registrations_council[]" style="width:156px;">
						<option value="">
							Registration Council
						</option>
						<?php
						foreach($council as $key=>$val)
						{
							?>
							<option value="<?=$val['name']?>">
								<?=$val['name']?>
							</option>
							<?php
						} ?>
					</select>
					<select name="registrations_year[]" style="width: 156px;">
						<option value="">
							Year
						</option>
						<?php
						foreach($from_year as $val)
						{
							?>
							<option value="<?=$val?>">
								<?=$val?>
							</option>
							<?php
						} ?>
					</select>
					<a href="javascript:void(0);" class="removeclass" id="registrations">Remove</a><br/>
				</div>
			</div>
			
			<div id="registrations_other_more_to_copy">
				<div>
					<input type="text" style="width: 150px;" value="" name="registrations_no[]">
					<input type="text" style="width: 150px;" value="" name="registrations_council[]">
					<input type="text" style="width: 150px;" value="" name="registrations_year[]">
					<a id="registrations" class="removeclass" href="javascript:void(0);">Remove</a>
					<br>
				</div>
			</div>
			
			<div id="qualifications_other_more_to_copy">
				<div>
					<input type="text" value="" name="qualifications[]">
					<a id="qualifications" class="removeclass" href="javascript:void(0);">Remove</a>
					<br>
				</div>
			</div>
			
			<div id="paperspublished_other_more_to_copy">
				<div>
					<input type="text" value="" name="paperspublished[]">
					<a id="paperspublished" class="removeclass" href="javascript:void(0);">Remove</a>
					<br>
				</div>
			</div>
			
			<div id="patient_other_more_to_copy">
				<div>
					<input type="text" name="patient_name[]" value="<?=$val['patient_name']?>" style="width: 130px;" />
					<input type="text" name="patient_number[]" value="<?=$val['patient_number']?>" maxlength="10" style="width: 130px;;" />
					<a href="javascript:void(0);" class="removeclass" id="patient">Remove</a>
					<br/>
				</div>
			</div>
			
		</div>
		
	</body>	
</html>
