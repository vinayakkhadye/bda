<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>View Doctor Profile  | BDA</title>
		<?php $this->load->view('admin/common/head'); ?>
	</head>
	<body>
		<?php $this->load->view('admin/common/header'); ?>
		<?php //$this->load->view('admin/common/left_menu'); ?>
		<div class="container-fluid">
		<div class="panel panel-default">
		<div class="panel-heading">Doctor Basic Profile Details
			<a href="/bdabdabda/manage_doctors/editbasicprofile/<?=$all_details['doctor_id']?>"><button class="btn btn-primary FR" style="margin-top: -7px">Edit Basic Details</button></a>
			<a href="javascript:void(0);" class="send-sms-btn"><button class="btn btn-primary FR" style="margin-top: -7px"> Send Profile link as SMS</button></a>
		
		</div>
		<div class="panel-body">
			<div class="row">
				<div class="col-lg-8">
				<table class="table table-striped table-bordered table-hover">
					<tr>
						<td>Name</td>
						<td><?=@$all_details['name']?></td>
					</tr>
					<tr>
						<td>Email ID</td>
						<td><?=@$all_details['email_id']?></td>
					</tr>
					<tr>
						<td>Mobile Number</td>
						<td><?=(!empty($all_details['user_contact_number'])? $all_details['user_contact_number']: $all_details['doc_contact_number'])?></td>
					</tr>
					<tr>
						<td>Date of Birth</td>
						<td><?php
						if(isset($all_details['dob']) && !empty($all_details['dob']))
						echo @date('d-m-Y', strtotime($all_details['dob']))?></td>
					</tr>
					<tr>
						<td>Gender</td>
						<td><?=@$all_details['gender']?></td>
					</tr>
					<tr>
						<td>Speciality</td>
						<td>
						<?php
							if(isset($all_details['speciality_name']) && !empty($all_details['speciality_name']))
							{
								foreach($all_details['speciality_name'] as $sname) 
								{
									echo ucfirst($sname).'<br/>';
								}
							}
						?>
						</td>
					</tr>
					<tr>
						<td>Other Speciality</td>
						<td>
						<?php
						$other_spec = explode(',', $all_details['other_speciality']);
						foreach($other_spec as $name) 
						{
							echo ucfirst($name).'<br/>';
						}
						?>
						</td>
					</tr>
					<tr>
						<td>Degree</td>
						<td>
						<?php
							if(isset($all_details['qualification_name']) && !empty($all_details['qualification_name']) && sizeof($all_details['qualification_name']) > 0)
							foreach($all_details['qualification_name'] as $qname) 
							{
								echo ucfirst($qname).'<br/>';
							}
						?>
						</td>
					</tr>
					<tr>
						<td>Other Degree</td>
						<td>
						<?php
						$other_qual = explode(',', $all_details['other_qualification']);
						foreach($other_qual as $name) 
						{
							echo ucfirst($name).'<br/>';
						}
						?>
						</td>
					</tr>
					<tr>
						<td>Years of Experience</td>
						<td><?=@$all_details['yoe']?></td>
					</tr>
					<tr>
						<td>Registration No</td>
						<td><?=@$all_details['reg_no']?></td>
					</tr>
					<tr>
						<td>State Medical Council</td>
						<td><?=@$all_details['council_name']?></td>
					</tr>
					<?php if(isset($all_details['fbid'])): ?>
					<tr>
						<td><img src="<?=IMAGE_URL?>facebook.png" style="width: 30px; vertical-align:middle" /> Facebook Profile</td>
						<td><a href="https://www.facebook.com/<?=$all_details['fbid']?>" target="_blank"><?=$all_details['name']?></a></td>
					</tr>
					<?php endif; ?>
				</table>
			</div>
			<div class="col-lg-4">
				
				<div style="float: left; position: relative; width: auto; left: 5%; margin-top: 3%; padding: 6px; border: 3px solid rgb(170, 170, 170);">
					<img src="/<?=($all_details['userimage'])?$all_details['userimage']:$all_details['doc_image']?>" />
				</div>
			</div>
			</div>

		</div>


		<div class="panel-heading">Clinics
			<a href="/bdabdabda/manage_doctors/addclinic/<?=$all_details['doctor_id']?>" ><button class="btn btn-primary FR" style="margin-top: -7px">Add Clinic</button>	</a>
	    </div>
	    <div class="panel-body">	
			<div class="row">	
				 <table class="table table-striped table-bordered table-hover">
					<tr>
						<th>Clinic Name</th>
						<th>Clinic City</th>
						<th>Clinic Number</th>
						<th>Action</th>
					</tr>
					<?php if(sizeof($all_details['clinics']) >0): ?>
					<?php foreach($all_details['clinics'] as $key ): ?>
					<tr>
						<td><?=$key['name']?></td>
						<td><?=$key['city']?></td>
						<td><?=$key['contact_number']?></td>
						<td>
							<a href="/bdabdabda/manage_doctors/editclinic/<?=$key['id']?>/<?=$all_details['doctor_id']?>" target="_blank" >
                <span class="glyphicon glyphicon-edit" title="Edit Clinic"></span>
							</a>
							<a id="<?=$key['id']?>" href="javascript:void(0);" class="delete-clinic-img" >
                <span class="glyphicon glyphicon-trash" title="Delete Clinic"></span>
							</a>
						</td>
					</tr>
					<?php endforeach; ?>
					<?php endif; ?>
				</table>
			</div>	
			<div style="clear: both;"></div>

				<?php //print_r($all_details['packages']); ?>
				<?php if(!empty($all_details['packages'])): ?>
					<h2>Packages</h2>
					<table border="1" cellpadding="0" cellspacing="0" class="basic-profile-details-table">
						<tr>
							<th>Package Name</th>
							<th>Start Date</th>
							<th>End Date</th>
						</tr>
						<?php foreach($all_details['packages'] as $key ): ?>
						<tr 
						<?php 
							if((strtotime(date('Y-m-d', strtotime($key['end_date'])))) < (strtotime(date('Y-m-d')))) 
							echo 'style="background-color: #FFBCB7;"'; 
						?>
						>
							<td><?=$key['package_name']?></td>
							<td><?=date('d-m-Y', strtotime($key['start_date']));?></td>
							<td><?=date('d-m-Y', strtotime($key['end_date']));?></td>
						</tr>
						<?php endforeach; ?>
					</table>
				<?php endif; ?>
				
				<?php //var_dump($all_details['check_sor_eligible']); ?>
				<?php if(($all_details['check_sor_eligible'] == 1)): ?>
				<?php //print_r($doctor_extra_details); ?>

				</div>
				<div class="panel-heading">Doctor Additional Details
				<a href="/bdabdabda/manage_doctors/editdetailedprofile/<?=$all_details['doctor_id']?>" ><button class="btn btn-primary FR" style="margin-top: -7px">Edit Extra Details</button>	</a>
	    		</div> 
	    		<div class="panel-body">
				<?php 
				$attr_services = 0;
				if((is_array($doctor_extra_details) && sizeof($doctor_extra_details) > 0)):
				foreach($doctor_extra_details as $row) 
				{
					if($row['attribute'] == 'Services')
					$attr_services = 1;
				}
					if($attr_services == 1)
					{
				?>
					<h3>Services offered :</h3>
				<?php }; ?>
				<table border="1" cellpadding="0" cellspacing="0" class="basic-profile-details-table">
					<?php foreach($doctor_extra_details as $row) 
					{
						if($row['attribute'] == 'Services')
						{
					?>
					<tr>
						<td><?=ucfirst($row['description1'])?></td>
					</tr>
					<?php }}; ?>
				</table>
				<?php endif; ?>
				
				<?php 
				$attr_services = 0;
				if((is_array($doctor_extra_details) && sizeof($doctor_extra_details) > 0)):
				foreach($doctor_extra_details as $row) 
				{
					if($row['attribute'] == 'Specializations')
					$attr_services = 1;
				}
					if($attr_services == 1)
					{
				?>
					<h3>Specializations :</h3>
				<?php }; ?>
				<table border="1" cellpadding="0" cellspacing="0" class="basic-profile-details-table">
					<?php foreach($doctor_extra_details as $row)
					{
						if($row['attribute'] == 'Specializations')
						{
					?>
					<tr>
						<td><?=ucfirst($row['description1'])?></td>
					</tr>
					<?php }}; ?>
				</table>
				<?php endif; ?>
				
				<?php 
				$attr_services = 0;
				if((is_array($doctor_extra_details) && sizeof($doctor_extra_details) > 0)):
				foreach($doctor_extra_details as $row) 
				{
					if($row['attribute'] == 'Education')
					$attr_services = 1;
				}
					if($attr_services == 1)
					{
				?>
					<h3>Education :</h3>
				<?php }; ?>
				<table border="1" cellpadding="0" cellspacing="0" class="basic-profile-details-table">
					<?php foreach($doctor_extra_details as $row) 
					{
						if($row['attribute'] == 'Education')
						{
					?>
					<tr>
						<td><?=ucfirst($row['description1'])?></td>
						<td><?=ucfirst($row['description2'])?></td>
						<td><?=ucfirst($row['from_year'])?></td>
					</tr>
					<?php }}; ?>
				</table>
				<?php endif; ?>
				
				<?php 
				$attr_services = 0;
				if((is_array($doctor_extra_details) && sizeof($doctor_extra_details) > 0)):
				foreach($doctor_extra_details as $row) 
				{
					if($row['attribute'] == 'Experience')
					$attr_services = 1;
				}
					if($attr_services == 1)
					{
				?>
					<h3>Experience :</h3>
				<?php }; ?>
				<table border="1" cellpadding="0" cellspacing="0" class="basic-profile-details-table">
					<?php foreach($doctor_extra_details as $row) 
					{
						if($row['attribute'] == 'Experience')
						{
					?>
					<tr>
						<td><?=ucfirst($row['description1'])?></td>
						<td><?=ucfirst($row['description2'])?></td>
						<td><?=ucfirst($row['description3'])?></td>
						<td><?=ucfirst($row['from_year'])?></td>
						<td><?=ucfirst($row['to_year'])?></td>
					</tr>
					<?php }}; ?>
				</table>
				<?php endif; ?>
				
				<?php 
				$attr_services = 0;
				if((is_array($doctor_extra_details) && sizeof($doctor_extra_details) > 0)):
				foreach($doctor_extra_details as $row) 
				{
					if($row['attribute'] == 'AwardsAndRecognitions')
					$attr_services = 1;
				}
					if($attr_services == 1)
					{
				?>
					<h3>Awards & Recognitions :</h3>
				<?php }; ?>
				<table border="1" cellpadding="0" cellspacing="0" class="basic-profile-details-table">
					<?php foreach($doctor_extra_details as $row) 
					{
						if($row['attribute'] == 'AwardsAndRecognitions')
						{
					?>
					<tr>
						<td><?=ucfirst($row['description1'])?></td>
						<td><?=ucfirst($row['from_year'])?></td>
					</tr>
					<?php }}; ?>
				</table>
				<?php endif; ?>
				
				<?php 
				$attr_services = 0;
				if((is_array($doctor_extra_details) && sizeof($doctor_extra_details) > 0)):
				foreach($doctor_extra_details as $row) 
				{
					if($row['attribute'] == 'Membership')
					$attr_services = 1;
				}
					if($attr_services == 1)
					{
				?>
					<h3>Membership :</h3>
				<?php }; ?>
				<table border="1" cellpadding="0" cellspacing="0" class="basic-profile-details-table">
					<?php foreach($doctor_extra_details as $row) 
					{
						if($row['attribute'] == 'Membership')
						{
					?>
					<tr>
						<td>Membership</td>
						<td><?=ucfirst($row['description1'])?></td>
					</tr>
					<?php }}; ?>
				</table>
				<?php endif; ?>
				
				<?php 
				$attr_services = 0;
				if((is_array($doctor_extra_details) && sizeof($doctor_extra_details) > 0)):
				foreach($doctor_extra_details as $row) 
				{
					if($row['attribute'] == 'Registrations')
					$attr_services = 1;
				}
					if($attr_services == 1)
					{
				?>
					<h3>Registrations :</h3>
				<?php }; ?>
				<table border="1" cellpadding="0" cellspacing="0" class="basic-profile-details-table">
					<?php foreach($doctor_extra_details as $row) 
					{
						if($row['attribute'] == 'Registrations')
						{
					?>
					<tr>
						<td><?php echo 'Reg No: '. ucfirst($row['description1'])?></td>
						<td><?php echo 'Council: '. ucfirst($row['description2'])?></td>
						<td><?php echo ucfirst($row['from_year'])?></td>
					</tr>
					<?php }}; ?>
				</table>
				<?php endif; ?>
				
				<?php 
				$attr_services = 0;
				if((is_array($doctor_extra_details) && sizeof($doctor_extra_details) > 0)):
				foreach($doctor_extra_details as $row) 
				{
					if($row['attribute'] == 'Qualifications')
					$attr_services = 1;
				}
					if($attr_services == 1)
					{
				?>
					<h3>Qualifications :</h3>
				<?php }; ?>
				<table border="1" cellpadding="0" cellspacing="0" class="basic-profile-details-table">
					<?php foreach($doctor_extra_details as $row) 
					{
						if($row['attribute'] == 'Qualifications')
						{
					?>
					<tr>
						<td><?=ucfirst($row['description1'])?></td>
					</tr>
					<?php }}; ?>
				</table>
				<?php endif; ?>
				
				<?php 
				$attr_services = 0;
				if((is_array($doctor_extra_details) && sizeof($doctor_extra_details) > 0)):
				foreach($doctor_extra_details as $row) 
				{
					if($row['attribute'] == 'PapersPublished')
					$attr_services = 1;
				}
					if($attr_services == 1)
					{
				?>
					<h3>Papers Published :</h3>
				<?php }; ?>
				<table border="1" cellpadding="0" cellspacing="0" class="basic-profile-details-table">
					<?php foreach($doctor_extra_details as $row) 
					{
						if($row['attribute'] == 'PapersPublished')
						{
					?>
					<tr>
						<td><?=ucfirst($row['description1'])?></td>
					</tr>
					<?php }}; ?>
				</table>
				<?php endif; ?>
				
				<?php if(isset($patient_reviews) && !empty($patient_reviews) && sizeof($patient_reviews) > 0): ?>
				<h3>Patient Reviews :</h3>
				<table border="1" cellpadding="0" cellspacing="0" class="basic-profile-details-table">
					<?php foreach($patient_reviews as $row): ?>
					<tr>
						<td class="review-name-td"><?=ucfirst($row->patient_name) ?></td>
						<td><?=ucfirst($row->patient_number) ?></td>
						<td>
							<?php if($row->reviewed == 1): ?>
							Review Done
							<?php else: ?>
							<input type="button" value="Add Review" class="add-review-btn" id="<?=$row->id?>" />
							<?php endif; ?>
						</td>
					</tr>
					<?php endforeach; ?>
				</table>
				<?php endif; ?>
				
				<?php if(isset($all_details['summary']) && !empty($all_details['summary'])): ?>
				<table border="1" cellpadding="0" cellspacing="0" class="basic-profile-details-table">
					<tr>
						<td>Short Brief about Practice</td>
						<td><?=@$all_details['summary']?></td>
					</tr>
				</table>
				<?php endif; ?>
				
				<?php endif;?>
		</div>
			
		<div class="panel-footer">
		<?php $this->load->view('admin/common/footer'); ?>
		</div>
	</div>
	</div>
	<?php $this->load->view('admin/common/bottom'); ?>
 

	<div class="modal fade" id="reviewpopup-modal" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add a Review</h4>
        </div>
        <div class="modal-body">
          <form method="POST" action="" class="commentform">
          <input type="hidden" id="review-id" name="rid" value="" />
          <div class="form-group">
            <label class="control-label">Name</label>
            <input type="text" name="rname" class="validate[required,custom[onlyLetterSp]] form-control" id="rname" />
          </div>
          <div class="form-group">
            <label class="control-label">Email</label>
            <input type="text" name="remail" class="validate[required,custom[email]] form-control" id="remail" />
          </div>
          <div class="form-group">
            <label class="control-label">Comment</label>
            <input type="text" name="rcomment" class="validate[required] form-control" id="rcomment" />
          </div>
          <div class="form-group">
            <label class="control-label">Rating</label>
            <select id="rrating" name="rrating" class="form-control">
            <option value="1">Very Happy</option>
            <option value="2">Happy</option>
            <option value="3">Average</option>
            </select>
          </div>
          <div class="form-group">
	          <input type="submit" name="submit" value="Submit Review" class="submit-review-btn btn btn-primary" />
          </div>
          <div class="form-group">
	          <span class="review-message-span"></span>
          </div>
          </form>
          
        </div>
      </div>
      
    </div>
  </div>
  
	<div class="modal fade" id="smspopup-modal" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Send SMS</h4>
        </div>
        <div class="modal-body">
          <textarea class="form-control" id="sms-value" cols="50" rows="8">Link for your profile
          http://www.bookdrappointment.com/profile/<?php echo str_replace(' ','-',strtolower($all_details['name'])).'/'.$all_details['doctor_id'].'.html'; ?></textarea>
          <center><input type="button" value="Send SMS" class="send-sms-submit btn btn-primary" /></center>
          <span id="message-popup"></span>
        </div>
      </div>
      
    </div>
  </div>
	
	
	
	<script type="text/javascript">
		$(document).ready(function()
		{
			//$(".commentform").validationEngine();
			
			$('.add-review-btn').click(function()
			{
				$('#review-id').val(this.id);
				$('#rname').val($('.review-name-td').html());
				$("#reviewpopup-modal").modal({backdrop: true});
			});
			
			
			$('.send-sms-btn').click(function()
			{
				$("#smspopup-modal").modal({backdrop: true});
			});
			
			$('.send-sms-submit').click(function()
			{
				$('#message-popup').html('Sending SMS.. Please wait...');
				var sms = $('#sms-value').val();
				$.ajax(
				{
					url: '/bdabdabda/manage_doctors/sendsms/<?=(!empty($all_details['user_contact_number'])? $all_details['user_contact_number']: $all_details['doc_contact_number'])?>',
					method: 'POST',
					data: 
					{
						message : sms
					},
					success:function(resp)
					{
						$('#message-popup').html('');
						$('#smspopup-modal').modal('hide');
						alert('SMS sent');
						//alert(resp);
					}
				});	
			});
			
			<?php 
			$message = $this->session->flashdata('errormessage');
			if(isset($message) && !empty($message))
			echo "alert('{$message}');";
			?>
			
			$(".delete-clinic-img").click(function()
			{
				var a = confirm('Are you sure you want to delte this clinic?');
				if(a == true)
				{
					var clinicid = this.id;
					//alert(clinicid);
					$.ajax(
					{
						url: '/bdabdabda/manage_doctors/delete_clinic/'+clinicid,
						type: 'post',
						data:
						{
							clinicid : clinicid
						},
						success:function(resp)
						{
							if(resp == '0')
							{
								alert('Unable to delete clinic');
							}
							else
							{
								alert('Clinic deleted successfully');
								window.location.reload();
							}
						}
					});
				}
			});
		});
	</script>
	</body>	
</html>
