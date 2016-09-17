<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Manage Doctor | BDA</title>
<?php $this->load->view('admin/common/head'); ?>
</head>
<body>
<?php $this->load->view('admin/common/header'); ?>
<div class="container-fluid">
<div class="panel panel-default">
<div class="panel-heading">Doctor </div>
<div class="panel-body">
<form name="seach_doctors" action="/bdabdabda/manage_doctors" class="form-inline" >
<div class="form-group">
<label class="control-label">Doctor ID : </label>
<input name="id" type="text" placeholder="Doctor ID" class="form-control" value="<?=@$id?>"/>
</div>
<div class="form-group">
<label class="control-label">Doctor Name : </label>
<input name="doctor_name" type="text" placeholder="Doctor name" class="form-control" value="<?=@$doctor_name?>"/>
</div>
<div class="form-group">
<label class="control-label">Speciality : </label>
<select name="specialities" class="form-control" >
<option value="">Select Speciality </option>
<?php foreach($specialities as $row): ?>
<option value="<?=$row['id']?>" <?php if(isset($_GET['specialities']) && !empty($_GET['specialities']) && $_GET['specialities'] == $row['id']) echo 'selected'; ?> ><?=ucfirst($row['name'])?></option>
<?php endforeach; ?>
</select>
</div>
<div class="form-group">
<label class="control-label">Locality : </label>
<select name="locality" class="form-control" >
<option value="">Select Locality</option>
<?php foreach($locality as $row): ?>
<option value="<?=$row->id?>" <?php if(isset($_GET['locality']) && !empty($_GET['locality']) && $_GET['locality'] == $row->id) echo 'selected'; ?> ><?=ucfirst($row->name)?></option>
<?php endforeach; ?>
</select>      
</div>
<div class="form-group">
<label class="control-label">City : </label>
<select name="city" class="form-control" >
<option value="">Select City</option>
<?php foreach($cities as $row): ?>
<option value="<?=$row['id']?>" <?php if(isset($_GET['city']) && !empty($_GET['city']) && $_GET['city'] == $row['id']) echo 'selected'; ?> ><?=$row['name']?></option>
<?php endforeach; ?>
</select>      
</div>
<div class="form-group">
<label class="control-label">Sort By : </label>
<select name="sort_by" class="form-control" >
<option value="doc.created_on" <?php if(isset($_GET['sort_by']) && !empty($_GET['sort_by']) && $_GET['sort_by'] == 'user.created_on') echo 'selected'; ?> >Date of Registration</option>
<option value="doc.id" <?php if(isset($_GET['sort_by']) && !empty($_GET['sort_by']) && $_GET['sort_by'] == 'doc.id') echo 'selected'; ?> >Doctor ID</option>
<option value="doc.status" <?php if(isset($_GET['sort_by']) && !empty($_GET['sort_by']) && $_GET['sort_by'] == 'doc.status') echo 'selected'; ?> >Doctor Status</option>
<option value="doc.site" <?php if(isset($_GET['sort_by']) && !empty($_GET['sort_by']) && $_GET['sort_by'] == 'doc.site') echo 'selected'; ?> >Site *</option>
</select>
<select name="asc_desc" class="form-control" >
<option value="desc" <?php if(isset($_GET['asc_desc']) && !empty($_GET['asc_desc']) && $_GET['asc_desc'] == 'desc') echo 'selected'; ?> >Descending</option>
<option value="asc" <?php if(isset($_GET['asc_desc']) && !empty($_GET['asc_desc']) && $_GET['asc_desc'] == 'asc') echo 'selected'; ?> >Ascending</option>
</select>          
</div>
<div class="form-group" > 
<label class="control-label">Health Utsav : </label>
<div class="checkbox">
<input type="checkbox" name="health_utsav" value="1" <?=(isset($health_utsav) && $health_utsav == 1)?'checked':''?> />
</div>
</div>
<div class="form-group" > 
<label class="control-label">Status : </label>
<div class="radio">
<label><input type="radio" name="status" value="1" <?=(!isset($status) || (isset($status) && $status == 1 ))?'checked':''?> /> Approved</label>
</div>
<div class="radio">
<label><input type="radio" name="status" value="0" <?=(isset($status) && $status == 0)?'checked':''?> /> Pending</label>
</div>
<div class="radio">
<label><input type="radio" name="status" value="-1" <?=(isset($status) && $status == -1)?'checked':''?> /> Disapproved</label>
</div>
<div class="radio">
<label><input type="radio" name="status" value="-2" <?=(isset($status) && $status == -2)?'checked':''?> /> Deleted</label>
</div>
</div>
<div class="form-group" > 
<input name="search" type="submit" class="btn btn-primary" value="Search"/>
</div>
</form>
<form name="edit_doctors" action="/bdabdabda/manage_doctors" method="post" >
<input type="hidden" value="<?=$cur_url?>" name="url" />
<div class="table-responsive">
<table class="table table-striped table-condensed table-bordered table-responsive ">
<tr>
<th>ID</th>
<th>Name</th>
<th>Clinics</th>
<th>Speciality</th>
<th>Qualification</th>
<th>City</th>
<th>Reg. Date</th>
<th>Status</th>
<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Action&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
</tr>
<?php if($results){
foreach($results as $row){ #print_r($row);exit;?>
<tr>
<td><?php echo $row->id;?></td> 
<td><?php if(!empty($row->facebook_id)): ?>
<a href="http://www.facebook.com/<?php echo $row->facebook_id; ?>" target="_blank"><img src="<?php echo IMAGE_URL; ?>fbimg.png" style="display: inline-block; vertical-align: bottom; width: 25px;" /></a>
<?php endif; ?>
<a href="/bdabdabda/manage_doctors/viewprofile/<?php echo $row->id; ?>"><?php echo ucfirst($row->name);?></a>
&nbsp;<a href="/bdabdabda/manage_doctors/editbasicprofile/<?php echo $row->id; ?>">
<span title="view appointment" class="glyphicon glyphicon-edit"></span>
</a>
</td>
<td><?php echo $row->clinic_count;?></td>
<td><?php echo $row->spec;?></td>
<td><?php echo $row->qual;?></td>
<?php $new_id = $row->id; ?>
<td><?php echo isset($cities[$row->city_id]['name'])?$cities[$row->city_id]['name']: '<a href="/bdabdabda/manage_doctors/viewprofile/'.$new_id.'"> Add clinic</a>'; ?></td>
<td><?php echo !empty($row->created_on) ? date('d-m-Y', strtotime($row->created_on)) : '';?></td>
<td id="doc_status_text_<?php echo $row->id; ?>" <?php if(isset($row->approval_in_progress) && $row->approval_in_progress == 1 && $row->status == 0) echo 'style="color:green;"'; ?> >
<?php if($row->status == 1){echo '<span class="label label-success">Approved</span>';}else if($row->status == 0){echo '<span class="label label-info">Pending</span>';}else if($row->status==-1){echo '<span class="label label-danger">Disapproved</span>';}else if($row->status==-2){echo '<span class="label label-danger">Deleted</span>';}else if($row->status==3){echo '<span class="label label-warning">Duplicate</span> ';}?>
</td>
<td>
<?php if(!empty($row->user_id)){ ?>
<a href="/bdabdabda/manage_doctors/login_as/<?php echo $row->id; ?>" target="_blank" class="btn btn-success btn-xs MB2">Login</a>
<?php }else{ ?>
<a href="/bdabdabda/manage_doctors/register_doctor/<?php echo $row->id; ?>" target="_blank" id="<?php echo $row->id; ?>" 
class="btn btn-info btn-xs MB2">Register</a>
<?php } ?>

<a href="javascript:void(0);" id="<?php echo $row->id; ?>" data-specialityids="<?php echo $row->speciality; ?>" data-cityid="<?php echo $row->city_id; ?>" data-status="<?php echo $doctor_status[$row->status]; ?>" data-uid="<?php echo $row->user_id; ?>" class="btn btn-warning status-btn btn-xs MB2">Status</a>
</td>
</tr>
<?php }}else{?>
<tr><td colspan="9" align="center">No Doctors Found</td></tr>
<?php
} ?>
</table>
</div>
<ul class="pagination"><?php echo $this->pagination->create_links(); ?></ul>
</form>
</div>
<div class="panel-footer">
<?php $this->load->view('admin/common/footer'); ?>
</div>
</div>
</div>
<?php $this->load->view('admin/common/bottom'); ?>
<div class="modal fade" id="change-status-modal" role="dialog">
<div class="modal-dialog">
<!-- Modal content-->
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal">&times;</button>
<h4 class="modal-title">Update Status</h4>
</div>
<div class="modal-body">
<form id="change-status-form" action="/bdabdabda/manage_doctors/statuspost" method="POST">
<div class="form-group">
<select name="status" class="status-type form-control">
<option value="">Select status</option>
<option value="doctor_approve">Approve</option>
<option value="doctor_disapprove">Disapprove</option>
<option value="doctor_pending">Pending</option>
<option value="doctor_delete">Delete</option>
<option value="doctor_duplicate">Duplicate</option>
</select>
</div>
<div class="response form-group"></div>
</form>
</div>
</div>

</div>
</div>
<!-- PAGE SPECIFIC JS-->
<script type="text/javascript">
var checked	=	 0;
var did	=	0;
var uid	=	0;
var status	=	0;
var doctor_status = '';
var doctor_specialityids = '';
var doctor_cityid = '';
$(document).ready(function(){

function get_checklist(did,uid,status,speciality_id,city_id){
if(status=='')
{
status	=	'doctor_pending';
$(".status-type").val(status);
}
$(".response").html('<div class="loading">loading ..</div>');
$.ajax({
url:'/bdabdabda/manage_doctors/get_checklist/'+did,
data: {'category':status,'uid':uid,'speciality_id':speciality_id,'city_id':city_id},
type: 'POST',
async: false,
success: function(resp)
{
$('.response').html(resp);
if($('.resp-checkbox:checked').length == $('.resp-checkbox').length)
{
checked = 1;
}
else
{
checked = 0;
}

$(".resp-checkbox").on('change click' ,function()
{
if(($('.resp-checkbox:checked').length == $('.resp-checkbox').length))
{
checked = 1;
}
else
{
checked = 0;
}
});

$(".save-form-btn").click(function()
{
	$('.resp-textarea').prop('required', false);
	$.ajax(
	{
		data	: $("#change-status-form").serialize(),
		url: '/bdabdabda/manage_doctors/doctor_status_approve_save_changes',
		type: 'POST',
		async: false,
		success: function(res)
		{
			$('.response').html('<div class="status-update">Status update saved</div>');
			$("#change-status-modal").modal('hide');
		}
	}
	);
});

$(".submit-form-btn").click(function(){
	if((checked == 1) && ($('.resp-checkbox:checked').length > 0))
	{
	
	$('.resp-textarea').prop('required', false);
	$.ajax(
	{
		data	: $("#change-status-form").serialize(),
		url: '/bdabdabda/manage_doctors/statuspost',
		type: 'POST',
		async: false,
		success: function(res)
		{
			obj	=	JSON.parse(res);
			$("#"+obj.doctor_id).attr("data-status",obj.category);
			$("#doc_status_text_"+obj.doctor_id).html('<span class="label '+obj.category_display_label+'">'+obj.category_display+'</span>');
			$('.response').html('<div class="status-update">Status update saved</div>');
			$("#change-status-modal").modal('hide');
		}
	}
	);											
	}
	else if((checked == 1) && ($('.resp-checkbox:checked').length == 0))
	{
	
	$('.resp-textarea').prop('required', true);
	$.ajax(
	{
		data	: $("#change-status-form").serialize(),
		url: '/bdabdabda/manage_doctors/statuspost',
		type: 'POST',
		async: false,
		success: function(res)
		{
			obj	=	JSON.parse(res);
			$("#"+obj.doctor_id).attr("data-status",obj.category);
			$("#doc_status_text_"+obj.doctor_id).html('<span class="label '+obj.category_display_label+'">'+obj.category_display+'</span>');
			$('.response').html('<div class="status-update">Status update saved</div>');
			$("#change-status-modal").modal('hide');
		}
	}
	);																						
	}
	else if(checked == 0 && $(".resp-textarea").val() != '')
	{
	$.ajax(
	{
		data: $("#change-status-form").serialize(),
		type: 'POST',
		async: false,
		url: '/bdabdabda/manage_doctors/statuspost',
		success: function(res)
		{
			obj	=	JSON.parse(res);
			$("#"+obj.doctor_id).attr("data-status",obj.category);
			$("#doc_status_text_"+obj.doctor_id).html('<span class="label '+obj.category_display_label+'">'+obj.category_display+'</span>');
			$('.response').html('<div class="status-update">Status update saved</div>');
			$("#change-status-modal").modal('hide');
		}
	}
	);																						
	}
	else
	{
	alert('Please tick all the checkboxes or enter a note');
	return false;
	}
});			
}
});

}

$(".status-type").on('change', function(){
did = this.id;
uid = $(this).attr("data-uid");
status = $('.status-type').val();
doctor_specialityids = $(this).attr("doctor_specialityids");
doctor_cityid = $(this).attr("doctor_cityid");
get_checklist(did,uid,status,doctor_specialityids,doctor_cityid);
});

$('.status-btn').click(function(){
did = this.id;
uid = $(this).attr("data-uid");
doctor_status	=	$(this).attr("data-status");
status = $(".status-type").val(doctor_status);
doctor_specialityids	=	$(this).attr("data-specialityids");
doctor_cityid	=	$(this).attr("data-cityid");

$(".status-type").attr('id', did);
$(".status-type").attr('data-uid', uid);
$(".status-type").attr('doctor_specialityids', doctor_specialityids);
$(".status-type").attr('doctor_cityid', doctor_cityid);

$(".response").html('<div class="loading">loading ..</div>');
$("#change-status-modal").modal({backdrop: true});
get_checklist(did,uid,doctor_status,doctor_specialityids,doctor_cityid);
});

$("#chackAll").change(function(){
if(this.checked)
{
$('.rowcheck').prop('checked', true);
}else
{
$('.rowcheck').prop('checked', false);
}
});

});
</script>
<!-- PAGE SPECIFIC JS-->
</html>