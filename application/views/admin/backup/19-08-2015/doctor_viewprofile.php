<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>View Doctor Profile  | BDA</title>
		<?php $this->load->view('admin/common/head'); ?>
	</head>
	<body>
		<?php $this->load->view('admin/common/header'); ?>
		<div class="container-fluid">
		<div class="panel panel-default">
		<div class="panel-heading">
    Doctor Basic Profile Details 
    <div class="FR">
    <a class="btn btn-primary" href="/bdabdabda/manage_doctors/editbasicprofile/<?=$all_details['doctor_id']?>">Edit Basic Details</a>&nbsp;&nbsp;
    <a class="send-sms-btn btn btn-primary" href="javascript:void(0);">Send Profile link as SMS</a></div>
    <div class="CL"></div>
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
				<img src="/<?=($all_details['userimage'])?$all_details['userimage']:$all_details['doc_image']?>" />
			</div>
			</div>

		</div>


		<div class="panel-heading">Clinics
			<a class="btn btn-primary FR" href="/bdabdabda/manage_doctors/addclinic/<?=$all_details['doctor_id']?>" >Add Clinic</a>
      <div class="CL"></div>
	    </div>
	    <div class="panel-body">	
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
							<a href="/bdabdabda/manage_doctors/editclinic/<?=$key['id']?>/<?=$all_details['doctor_id']?>">
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
			<?php if(!empty($all_details['packages'])): ?>
      <div class="panel-heading">Packages<div class="CL"></div></div>
      <div class="panel-body">	
      <table class="table table-striped table-bordered table-hover">
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
      
      </div>
      <?php endif; ?>
			<?php if(($all_details['check_sor_eligible'] == 1)){ ?>
        <div class="panel-heading">Doctor Additional Details
        <a class="btn btn-primary FR" href="/bdabdabda/manage_doctors/editdetailedprofile/<?=$all_details['doctor_id']?>" >Edit Extra Details</a>
        <div class="CL"></div>
        </div>
        <div class="panel-body">
        <?php if(is_array($doctor_extra_details) && sizeof($doctor_extra_details)>0){ ?>
        <table class="table table-striped table-bordered table-hover">
				<?php foreach($doctor_extra_details as $ex_key=>$ex_val){?>
					<tr>
	          <td><strong><?=$ex_val['attribute']?></strong></td>
						<td><?=$ex_val['description1']?></td>
            <td><?=$ex_val['description2']?></td>
            <td><?=$ex_val['description3']?></td>
            <td><?=$ex_val['from_year']?></td>
            <td><?=$ex_val['to_year']?></td>
					</tr>
        <?php }?>                
        <tr>
          <td><strong>Summary</strong></td>
          <td colspan="5"><?=@$all_details['summary']?></td>
        </tr>
        </table>
        <?php }?>
				<?php if(isset($patient_reviews) && !empty($patient_reviews) && sizeof($patient_reviews) > 0): ?>
				<h3>Patient Reviews :</h3>
				<table class="table table-striped table-bordered table-hover">
					<?php foreach($patient_reviews as $row): ?>
					<tr>
						<td class="review-name-td"><?=ucfirst($row->patient_name) ?></td>
						<td><?=ucfirst($row->patient_number) ?></td>
						<td>
							<?php if($row->reviewed == 1): ?>Review Done<?php else: ?>
							<input type="button" value="Add Review" class="add-review-btn" id="<?=$row->id?>" />
							<?php endif; ?>
						</td>
					</tr>
					<?php endforeach; ?>
				</table>
				<?php endif; ?>
        
        </div>
	    <?php }?>
			
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
        </div>
        <div class="modal-footer">
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
