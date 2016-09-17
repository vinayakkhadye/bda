<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>View Duplicates | BDA</title>
<?php $this->load->view('admin/common/head'); ?>
</head>
<body>
<?php $this->load->view('admin/common/header'); ?>
<div class="container-fluid">
<div class="panel panel-default">
<div class="panel-heading">Duplicates</div>
<div class="panel-body">
<form action="" method="POST">
<table class="table table-striped table-condensed table-bordered table-responsive">
<tr>
<th>Doctor ID</th>
<th>Duplicate with Doctor ID</th>
<th>Doctor Name</th>
<th>Status</th>
<th>Action</th>
</tr>
<?php if(isset($duplicates) && !empty($duplicates) && sizeof($duplicates) > 0): ?>
<?php $a = ''; foreach($duplicates as $row): ?>
<tr>
<td><a href="/bdabdabda/manage_doctors/viewprofile/<?php echo $row['id']; ?>" target="_blank"><?php echo $row['id']; ?></a></td>
<td><a href="/bdabdabda/manage_doctors/viewprofile/<?php echo $row['duplicate']; ?>" target="_blank"><?php echo $row['duplicate']; ?></a></td>
<td><a href="/bdabdabda/manage_doctors/viewprofile/<?php echo $row['id']; ?>" target="_blank"><?php echo $row['name']; ?></a></td>
<td>
<?php 
switch($row['status'])
{
case "1":
echo "Approved";
break;
case "0":
echo "Pending";
break;
case "-1":
echo "Disapproved";
break;
case "-2":
echo "Deleted";
break;
}
?>
</td>
<td><a href="/bdabdabda/manage_doctors/remove_duplicate/<?php echo $row['duplicate']; ?>"><input type="button" value="Remove as Duplicate" /></a></td>
</tr>
<?php endforeach; ?>
<?php else: ?>
<tr>
<td colspan="4"> No Similar Doctor found</td>
</tr>
<?php endif; ?>
</table>
</td>
</div>
<div class="panel-footer">
<?php $this->load->view('admin/common/footer'); ?>
</div>
</div>
</div>

</body>
<?php $this->load->view('admin/common/bottom'); ?>
<!-- PAGE SPECIFIC JS-->
<!-- PAGE SPECIFIC JS-->
</html>
