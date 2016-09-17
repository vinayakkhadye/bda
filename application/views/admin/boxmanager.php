<!DOCTYPE html>
<html lang="en">
<head>
  <title>Featured Content | BDA</title>
	<?php $this->load->view('admin/common/head'); ?>
</head>
<body>
<?php $this->load->view('admin/common/header'); ?>
<div class="container-fluid">
<div class="panel panel-default">
<div class="panel-heading"><?=$display_name?></div>
<div class="panel-body">
<div class="row">
<div class="col-sm-3"></div>
<div class="col-sm-5">
<form name="health_utsav_add" method="POST" data-toggle="validator" enctype="multipart/form-data">
	<div class="form-group">
    <label class="control-label">Name : </label>
    <input name="name" type="text" class="form-control" value="" required/>
  </div>
  <div class="form-group">
    <label class="control-label">City Name :   <code>Use 7 for Pune, 1 for Mumbai</code></label>
    <input name="city_id" id="add_city_id" type="text" class="form-control" placeholder="Name .. " required>
  </div>
  <div class="form-group">
    <label class="control-label">Status : </label>
    <select name="status" class="form-control" required>
      <option value="1">Enabled</option>
      <option value="0">Disabled</option>
    </select>
  </div>
  <div class="form-group">
    <label class="control-label">Sort Order : </label>
    <input name="sort" type="number" class="form-control" value=""/>
  </div>
  <div class="form-group">
    <label class="control-label">Category : </label>
    <select name="category_id" class="form-control" required>
      <option value="1">One Banner</option>
      <option value="2">Two Banners</option>
    </select>
  </div>
  <div class="form-group">
    <label class="control-label">Banner One : </label>
  </div>
  <div class="form-group">
	  <input name="url[]" 	type="text" class="form-control" value="" placeholder="url" required/>
  </div>
  <div class="form-group">
	  <input name="image[]"  type="file" required/>
  </div>
  <div class="form-group">
  	<input name="title[]" type="text" class="form-control" value="" placeholder="title" required/>
  </div>
  <div class="form-group">
    <label class="control-label">Banner Two : </label>
  </div>
	<div class="form-group">
	  <input name="url[]" 	type="text" class="form-control" value="" placeholder="url"/>
  </div>
  <div class="form-group">
	  <input name="image[]"  type="file" />
  </div>
  <div class="form-group">
  	<input name="title[]" type="text" class="form-control" value="" placeholder="title"/>
  </div>
  
  <div class="form-group">
   <input type="submit" name="submit" value="Add Entry" class="btn btn-primary" />
   </div>
</form>
</div>
</div>

<hr />
<form class="form-inline" method="GET" action="">
  <div class="form-group">
    <label class="control-label">City Name : </label>
    <input name="city_id" id="search_city_id" type="text" value="<?=@$_GET['city_id']?>" class="form-control"/>
  </div>
  <div class="form-group">
    <label class="control-label">Status : </label>
    <select name="status" class="form-control" >
      <option value="1" <?=(isset($_GET['status']) && $_GET['status']==1)?'selected':''?> >Enabled</option>
      <option value="0" <?=(isset($_GET['status']) && $_GET['status']==0)?'selected':''?>>Disabled</option>
      <option value="-1" <?=(isset($_GET['status']) && $_GET['status']==-1)?'selected':''?>>Deleted</option>
    </select>
  </div>
  <div class="form-group">
    <label class="control-label">Category : </label>
    <select name="category_id" class="form-control" >
      <option value="" >Select Cateogry</option>
      <option value="1" <?=(isset($_GET['category_id']) && $_GET['category_id']==1)?'selected':''?> >One Banner</option>
      <option value="2" <?=(isset($_GET['category_id']) && $_GET['category_id']==2)?'selected':''?>>Two Banners</option>
    </select>
  </div>
  <div class="form-group">
    <label class="control-label">Sort Order : </label>
    <input name="sort" type="text" class="form-control" value=""/>
  </div>
  <div class="form-group">
  <input name="submit" type="submit" value="Search" class="btn btn-primary"/>
  </div>
</form>
<hr />
<form name="edit_records" id="edit_records" method="post" class="" >
		<div class="form-group">
    <div class="btn-group PB5">
      <button type="submit" name="submit" value="Enable" class="btn btn-primary">Enable</button>
      <button type="submit" name="submit" value="Disable"class="btn btn-primary">Disable</button>
      <button type="submit" name="submit" value="Delete"class="btn btn-primary">Delete</button>
    </div>
    <div class="table-responsive">
    <table class="table table-striped table-condensed table-bordered" >
    <tr>
    <th><span class="glyphicon glyphicon-check" aria-hidden="true"></span></th>
    <th>Name</th>
    <th>City</th>
    <th>Status</th>
    <th>Category</th>
    <th>Sort Order</th>
    </tr>
    <?php
    if(is_array($allrecords) && sizeof($allrecords) > 0){
    foreach($allrecords as $row){
    ?>
    <tr>
    <td><input type="checkbox" name="record_id[<?php echo $row['id']; ?>]"></td>
    <td><?php echo $row['name']; ?></td>
    <td><?php echo $row['city_id']; ?></td>
    <td>
      <?php if($row['status'] == '1'): ?>Enabled<?php elseif($row['status'] == '0'): ?>Disabled<?php else: ?>Deleted<?php endif; ?>
    </td>
    <td>
      <?php if($row['category_id'] == '1'): ?>One Banner<?php elseif($row['category_id'] == '2'): ?>Two Banner<?php else: ?>No Banner<?php endif; ?>
    </td>

    <td><?php echo @$row['sort']; ?></td>
    </tr>
    <?php } ?>
    <?php }else { ?>
    <tr>
    <td colspan="6" style="text-align: center;"> No Records found </td>
    </tr>
    <?php } ?>
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
<script type="text/javascript">
$(document).ready(function()
{
});
</script>
<!--PAGE SPECIFIC SCRIPT-->
</body>
</html>
