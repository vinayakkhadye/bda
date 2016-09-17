<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Advertisements | BDA</title>
		<?php $this->load->view('admin/common/head'); ?> 
	</head>
	<body>
		<?php $this->load->view('admin/common/header'); ?>
		<?php //$this->load->view('admin/common/left_menu'); ?>
		<div class="container-fluid" >
<div class="panel panel-default">
<div class="panel-heading">Edit A Campaign</div>
<div class="panel-body" >
				<form method="POST" id="add-form-admin" enctype="multipart/form-data" data-toggle="validator">
					<div class="col-md-8 col-md-offset-2">
					<table class="table table-striped table-condensed table-bordered table-responsive">
						<tr>
							<td>Campaign Name</td>
							<td><input type="text" value="<?=@$all_details['campaign_name']?>" class="form-control validate[required]" name="campaign_name" value="" required /></td>
						</tr>
						<tr>
							<td>Company Name</td>
							<td><input type="text" value="<?=@$all_details['company_name']?>" class="form-control validate[required,custom[onlyLetterSp]]" name="company_name" value="" required/></td>
						</tr>
						<tr>
							<td>Division</td>
							<td><input type="text" value="<?=@$all_details['division']?>" name="division" class="form-control " value="" required/></td>
						</tr>
						<tr>
							<td>Contact Name</td>
							<td><input type="text" value="<?=@$all_details['contact_name']?>" class="form-control validate[custom[onlyLetterSp]]" name="contact_name" value="" required/></td>
						</tr>
						<tr>
							<td>Contact Number</td>
							<td><input type="text" value="<?=@$all_details['contact_number']?>" class="form-control validate[custom[integer],maxSize[15]]" name="contact_number" value="" required /></td>
						</tr>
						<tr>
							<td>Contact Email</td>
							<td><input type="email" value="<?=@$all_details['contact_email']?>" class="form-control validate[custom[email]]" name="contact_email" value="" required/></td>
						</tr>
						<tr>
							<td>Start Date</td>
							<td><input type="text" value="<?=date('d-m-Y', strtotime(@$all_details['start_date']))?>" class="form-control validate[required]" id="scheduled_date" readonly="readonly" name="start_date" value="" required/></td>
						</tr>
						<tr>
							<td>Number of Days</td>
							<td><input type="text" value="<?=@$all_details['no_of_days']?>" name="no_of_days" class="form-control validate[required,custom[integer],maxSize[4]]" value="" required/></td>
						</tr>
						<tr>
							<td>Status</td>
							<td>
								<select name="status" class="form-control" required >
									<option value="D" <?php if(isset($all_details['status']) && !empty($all_details['status']) && $all_details['status'] == 'D') echo 'selected="selected"'; ?>>Draft</option>
									<option value="A" <?php if(isset($all_details['status']) && !empty($all_details['status']) && $all_details['status'] == 'A') echo 'selected="selected"'; ?>>Active</option>
									<option value="S" <?php if(isset($all_details['status']) && !empty($all_details['status']) && $all_details['status'] == 'S') echo 'selected="selected"'; ?>>Suspended</option>
									<option value="C" <?php if(isset($all_details['status']) && !empty($all_details['status']) && $all_details['status'] == 'C') echo 'selected="selected"'; ?>>Completed</option>
								</select>
							</td>
						</tr>
						<tr>
							<td>Brand Name</td>
							<td><input type="text" value="<?=@$all_details['brand_name']?>" name="brand_name" value=""  class="form-control" required /></td>
						</tr>
						<tr>
							<td>Number of Doctors</td>
							<td><input type="text" value="<?=@$all_details['no_of_doctors']?>" class="form-control validate[custom[integer],maxSize[4]]" name="no_of_doctors" value="" required/></td>
						</tr>
						<tr>
							<td>Package</td>
							<td>
								<select name="package_id" class="form-control" required>
									<?php foreach($packages as $row): ?>
										<option value="<?=$row->id; ?>" <?php if(isset($all_details['package_id']) && !empty($all_details['package_id']) && $all_details['package_id'] == $row->id) echo 'selected="selected"'; ?>><?=$row->name; ?></option>
									<?php endforeach; ?>
								</select>
							</td>
						</tr>
						<tr>
							<td>Ad Image (low resolution)</td>
							<td>
								<?php if(isset($all_details['ad_img_lres']) && !empty($all_details['ad_img_lres'])): ?>
									<image src="<?=BASE_URL.'./'.$all_details['ad_img_lres']?>"   height="100px" width="100px" > &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									 <button class="btn btn-default" > <a href="javascript:void(0);" id="/bdabdabda/advertisements/delete_img?imgtype=ad_img_lres&campaignid=<?php echo $all_details['id']; ?>" class="  <?php echo $all_details['ad_img_lres'] ?>" onclick="confirmation(this);" >Delete Image</a></button>  
								<?php endif; ?>
								<input type="file" name="ad_img_lres" value=""  class="form-control "/>
								
							</td>
						</tr>
						<tr>
							<td>Ad Image (medium resolution)</td>
							<td>
								<?php if(isset($all_details['ad_img_mres']) && !empty($all_details['ad_img_mres'])): ?>
									<image src="<?=BASE_URL.'./'.$all_details['ad_img_mres']?>" target="_blank" height="100px" width="100px" >  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<button class="btn btn-default" > <a href="javascript:void(0);" id="/bdabdabda/advertisements/delete_img?imgtype=ad_img_mres&campaignid=<?php echo $all_details['id']; ?>" class="<?php echo $all_details['ad_img_mres'] ?>" onclick="confirmation(this);" >Delete Image</a></button>
								<?php endif; ?>
								<input type="file" name="ad_img_mres" value=""  class="form-control "/>
								
							</td>
						</tr>
						<tr>
							<td>Ad Image (high resolution)</td>
							<td>
								<?php if(isset($all_details['ad_img_hres']) && !empty($all_details['ad_img_hres'])): ?>
									<image src="<?=BASE_URL.'./'.$all_details['ad_img_hres']?>" target="_blank" height="100px" width="100px" >  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<button class="btn btn-default" > <a href="javascript:void(0);" id="/bdabdabda/advertisements/delete_img?imgtype=ad_img_hres&campaignid=<?php echo $all_details['id']; ?>" class="<?php echo $all_details['ad_img_hres'] ?>" onclick="confirmation(this);" >Delete Image</a></button>
								<?php endif; ?>
								<input type="file" name="ad_img_hres" value=""  class="form-control"/>
								
							</td>
						</tr>
						<tr>
							<td>Ad Image (ultra high resolution)</td>
							<td>
								<?php if(isset($all_details['ad_img_ures']) && !empty($all_details['ad_img_ures'])): ?>
									<image src="<?=BASE_URL.'./'.$all_details['ad_img_ures']?>" target="_blank" height="100px" width="100px" >  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<button class="btn btn-default" > <a href="javascript:void(0);" id="/bdabdabda/advertisements/delete_img?imgtype=ad_img_ures&campaignid=<?php echo $all_details['id']; ?>" class="<?php echo $all_details['ad_img_ures'] ?>" onclick="confirmation(this);" >Delete Image</a></button>
								<?php endif; ?>
								<input type="file" name="ad_img_ures" value="" class="form-control "/>
								
							</td>
						</tr>
						
						<tr>
							<td colspan="2" style="text-align: center;">
								<input type="hidden" name="campaign_id"class="form-control " value="<?php echo @$all_details['id']; ?>"  required/>
								<input type="submit" name="submit" value="Update Campaign" class="btn btn-primary"/>
							</td>
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
					
					$("#add-form-admin").validationEngine({promptPosition : "centerRight"});
					
					$("#scheduled_date").datepicker(
					{
						dateFormat: "dd-mm-yy",
						changeMonth: true,
						changeYear: true,
						yearRange: "2015:2020"
					});
				});
					
				function confirmation(a)
				{
					var c = confirm('Are you sure you want to delete this image?');
					if(c == true)
					{
						window.top.location = a.id+'&imgname='+a.className;
						return true;
					}
					else
					{
						return false;
					}
				}
		</script>
	 
</html>
