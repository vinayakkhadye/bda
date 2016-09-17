<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Advertisements | BDA</title>
		<?php $this->load->view('admin/common/head'); ?>
		 
	</head>
	<body>
		<?php $this->load->view('admin/common/header'); ?> 

 <div class="container-fluid" >
<div class="panel panel-default">
<div class="panel-heading">Add A Doctor 
	<a href="/bdabdabda/advertisements/editcampaign/<?=$all_details['id']?>"  style="float: right; margin-top: -7px"><input type="button" value="Edit Campaign Details" class="add-btn btn btn-primary" /></a>
	 
				</div>
<div class="panel-body" >

				<form action="" method="POST">
					<div class="col-md-8 col-md-offset-2">
					<table class="table table-striped table-condensed table-bordered table-responsive">
						<tr>
							<td>Campaign Name</td>
							<td><?=$all_details['campaign_name']?></td>
						</tr>
						<tr>
							<td>Company Name</td>
							<td><?=@$all_details['company_name']?></td>
						</tr>
						<tr>
							<td>Division</td>
							<td><?=@$all_details['division']?></td>
						</tr>
						<tr>
							<td>Contact Name</td>
							<td><?=@$all_details['contact_name']?></td>
						</tr>
						<tr>
							<td>Contact Number</td>
							<td><?=@$all_details['contact_number']?></td>
						</tr>
						<tr>
							<td>Contact Email</td>
							<td><?=@$all_details['contact_email']?></td>
						</tr>
						<tr>
							<td>Start Date</td>
							<td><?=date('d-m-Y', strtotime(@$all_details['start_date']))?></td>
						</tr>
						<tr>
							<td>Number of Days</td>
							<td><?=@$all_details['no_of_days']?></td>
						</tr>
						<tr>
							<td>Status</td>
							<td><?php 
							if($all_details['status'] == 'A')
							echo 'Active';
							elseif($all_details['status'] == 'S')
							echo 'Suspended';
							elseif($all_details['status'] == 'D')
							echo 'Draft';
							elseif($all_details['status'] == 'C')
							echo 'Completed';
							?></td>
						</tr>
						<tr>
							<td>Brand Name</td>
							<td><?=@$all_details['brand_name']?></td>
						</tr>
						<tr>
							<td>Number of Doctors</td>
							<td><?=@$all_details['no_of_doctors']?></td>
						</tr>
						<tr>
							<td>Package</td>
							<td><?=@$all_details['package_name']?></td>
						</tr>
						<tr>
							<td>Image (Low Resolution)</td>
							<td>
							<?php if(isset($all_details['ad_img_lres']) && !empty($all_details['ad_img_lres'])): ?>
								<image src="<?=BASE_URL.'./'.$all_details['ad_img_lres']?>" width="100px" height="100px" >
							<?php endif; ?>
							</td>
						</tr>
						<tr>
							<td>Image (Medium Resolution)</td>
							<td>
							<?php if(isset($all_details['ad_img_mres']) && !empty($all_details['ad_img_mres'])): ?>
								<image src="<?=BASE_URL.'./'.$all_details['ad_img_mres']?>" width="100px" height="100px" >
							<?php endif; ?>
							</td>
						</tr>
						<tr>
							<td>Image (High Resolution)</td>
							<td>
							<?php if(isset($all_details['ad_img_hres']) && !empty($all_details['ad_img_hres'])): ?>
								<image src="<?=BASE_URL.'./'.$all_details['ad_img_hres']?>" width="100px" height="100px" >
							<?php endif; ?>
							</td>
						</tr>
						<tr>
							<td>Image (Ultra High Resolution)</td>
							<td>
							<?php if(isset($all_details['ad_img_ures']) && !empty($all_details['ad_img_ures'])): ?>
								<image src="<?=BASE_URL.'./'.$all_details['ad_img_ures']?>" width="100px" height="100px" >
							<?php endif; ?>
							</td>
						</tr>
						<tr>
							<td>Created By</td>
							<td><?=@$all_details['created_by']?></td>
						</tr>
						<tr>
							<td>Updated By</td>
							<td><?=@$all_details['updated_by']?></td>
						</tr>
						<tr>
							<td>Created On</td>
							<td><?=@date('d-m-Y h:i:s a', strtotime($all_details['created_on']))?></td>
						</tr>
						<tr>
							<td>Updated On</td>
							<td><?php 
							if(isset($all_details['updated_on']) && !empty($all_details['updated_on']))
							echo @date('d-m-Y h:i:s a', strtotime($all_details['updated_on']))
							?></td>
						</tr>
						
					</table>
				</div>
				</form>



			</div>

		<div class="panel-footer">
	<?php $this->load->view('admin/common/footer'); ?>
	</div>

		</div>
		</div>
	</body>
	<?php $this->load->view('admin/common/bottom'); ?>
	
		<script type="text/javascript">
			$(document).ready(function()
				{
					$("#left_Panel").height($("#content_area").height());
				});
		</script>
	 
</html>
