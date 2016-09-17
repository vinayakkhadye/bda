<!DOCTYPE html>
<html lang="en">
<head>
  <title>Reviews Master | BDA</title>
	<?php $this->load->view('admin/common/head'); ?>
</head>
<body>
<?php $this->load->view('admin/common/header'); ?>
<div class="container-fluid">
<div class="panel panel-default">
<div class="panel-heading">Reviews<!--<a class="btn btn-primary FR" href="/bdabdabda/reviews/add_reviews">Add a Review</a><div class="CL"></div>--></div>
<div class="panel-body">
<form class="form-inline" method="GET" action="">
  <div class="form-group">
    <label class="control-label">Doctor ID : </label>
    <input type="text" value="<?=@$doctor_id?>" placeholder="Doctors's ID" name="doctor_id" class="form-control">
  </div>
  <div class="form-group">
    <label class="control-label">Doctor Name : </label>
    <input type="text" value="<?=@$doctor_name?>" placeholder="Doctors Name" name="doctor_name" class="form-control">
  </div>
  <div class="form-group">
    <label class="control-label">Clinic Name : </label>
    <input type="text" value="<?=@$clinic_name?>" placeholder="Doctors Name" name="clinic_name" class="form-control">
  </div>
  <div class="form-group">
    <label class="control-label">User Name : </label>
    <input type="text" value="<?=@$user_name?>" placeholder="Users Name" name="user_name" class="form-control">
  </div>
  <div class="form-group">
    <label class="control-label">User Email : </label>
    <input type="text" value="<?=@$user_email?>" placeholder="Users Email" name="user_email" class="form-control">
  </div>
  <div class="form-group">
    <label class="control-label">User Comment : </label>
    <input type="text" value="<?=@$user_comment?>" placeholder="User Comment" name="user_comment" class="form-control">
  </div>
  <div class="form-group">
    <label class="control-label">User Rating : </label>
		<select  class="form-control" name="user_rating">
      <option value="">Select Status</option>
      <option value="1" <?=(isset($user_rating) && $user_rating == 1)?'selected="selected"':''?>>Very Happy</option>
      <option value="2" <?=(isset($user_rating) && $user_rating == 2)?'selected="selected"':''?>>Happy</option>
      <option value="3" <?=(isset($user_rating) && $user_rating==3)?'selected="selected"':''?>>Average</option>
    </select>    
  </div>
  <!--<div class="form-group">
    <label class="control-label">City : </label>
		<select  class="form-control" name="city_id">
      <option value="">Select City</option>
			<?php #foreach($city_list as $c_key=>$c_val){ ?>
      <option value="<? #$c_val->id ?>" <? #(isset($city_id) && $city_id == $c_val->id)?'selected="selected"':''?>><? #$c_val->name?></option>
      <?php #}?>
    </select>    
  </div>!-->

  
  <div class="form-group">
    <label class="control-label">Status : </label>
		<select  class="form-control" name="status">
      <option value="">Select Status</option>
      <option value="1" <?=(isset($status) && $status == 1)?'selected="selected"':''?>>Approved</option>
      <option value="0" <?=(isset($status) && $status == 0)?'selected="selected"':''?>>Pending</option>
      <option value="-1" <?=(isset($status) && $status==-1)?'selected="selected"':''?>>Disapproved</option>
    </select>
  </div>
  <div class="form-group">
  <input type="submit" value="Search" name="search" class="btn btn-primary">
  </div>
</form>
<hr />
<form name="edit_records" id="edit_records" method="post" class="" >
		<div class="form-group">
    <div class="btn-group PB5">
      <button type="submit" name="approve" value="Approve" class="btn btn-primary">Approve</button>
      <button type="submit" name="disapprove" value="Disapprove"class="btn btn-primary">Disapprove</button>
      <button type="submit" name="pending" value="Pending"class="btn btn-primary">Pending</button>
    </div>
    <div class="table-responsive">
    <table border="0" align="center" cellpadding="0" cellspacing="0" class="table table-striped table-bordered table-hover">
							<tr>
								<th><input type="checkbox" id="chackAll"></th>
								<th>Doctor Name</th>
								<!--<th>Speciality</th>-->
								<!--<th>City</th>-->
								<th>Users Name</th>
								<th>Message</th>
								<th>Rating</th>
								<th>Status</th>
								<th>Added on</th>
							</tr>
							<?php
							if($results)
							{
								foreach($results as $row)
								{
									?>
									<?php //print_r($row); ?>
									<tr>
										<td>
											<input type="checkbox" class="rowcheck" name="reviews_id[<?php echo $row->id; ?>]" id="reviews_id_<?php echo $row->id; ?>" />
										</td>
										<td><a href="<?=BASE_URL?>profile/<?=url_string(trim($row->doctor_name))?>/<?=$row->doctor_id?>.html">
										<?php echo ucfirst($row->doctor_name); ?></a></td>
										<!--<td><?php #echo ucfirst($row->speciality); ?></td>-->
										<!--<td><?php #echo ucfirst($row->city_name); ?></td>-->
										<td><?php echo ucfirst($row->name); ?></td>
										<td><?php echo $row->comment; ?></td>
										<td>
											<?php
											if($row->rating == 1)
											{
												echo 'Very Happy';
											}
											else
											if($row->rating == 2)
											{
												echo 'Happy';
											}
											else
											if($row->rating== 3)
											{
												echo 'Average';
											}
											?>
										</td>
										<td>
											<?php
											if($row->status == 1)
											{
												echo '<span class="label label-success">Approved</span>';
											}
											else
											if($row->status == 0)
											{
												echo '<span class="label label-info">Pending</span>';
											}
											else
											if($row->status==-1)
											{
												echo '<span class="label label-danger">Disapproved</span>';
											}
											?>
										</td>
										<td><?php echo date('d-m-Y h:i:s a', strtotime($row->added_on)); ?></td>
									</tr>
									<?php
								}
							}
							else
							{
								?>
								<tr>
									<td colspan="9" align="center">
										No Reviews Found
									</td>
								</tr>
								<?php
							} ?>
						</table>
     </div>
	    <ul class="pagination"><?php echo $this->pagination->create_links(); ?></ul>
    </div>
</form>
</div>
<div class="panel-footer">
<?php $this->load->view('admin/common/footer'); ?>
</div>
</div>
</div>
<?php $this->load->view('admin/common/bottom'); ?>
<!--PAGE SPECIFIC SCRIPT-->
<script>
		$(document).ready(function()
			{
				$("#chackAll").change(function()
					{
						if(this.checked)
						{
							$('.rowcheck').prop('checked', true);
						}else
						{
							$('.rowcheck').prop('checked', false);
						}
					});
				$("#date").datepicker(
					{
						dateFormat: "dd-mm-yy",
						defaultDate: "-25y",
						changeMonth: true,
						changeYear: true,
						yearRange: "1900:2014"
					});
				$("#left_Panel").height($("#content_area").height());
			});
	</script>
<!--PAGE SPECIFIC SCRIPT-->
</body>
</html>
