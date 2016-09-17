<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Duplicate Doctors | BDA</title>
<?php $this->load->view('admin/common/head'); ?>
</head>
<body>
<?php $this->load->view('admin/common/header'); ?>
<div class="container-fluid">
<div class="panel panel-default">
<div class="panel-heading">Search Duplicates<a href="/bdabdabda/manage_doctors/search_duplicates_list" class="btn btn-primary FR" target="_blank">View Duplicates</a>
<div class="CL"></div>
</div>
<div class="panel-body">
  <div class="display-table">
    <form method="GET" class="form-inline">
	    <div class="form-group">
      <label class="control-label">Doctors Name: </label>
      <input type="text" name="name" placeholder="Doctor's Name" value="<?php echo @$_GET['name']; ?>" class="form-control" />
      </div>
      <div class="form-group">
      <label class="control-label">Percentage: </label>
      <input type="number" min="1" max="100" name="perct" placeholder="Percentage (1-100)%" value="<?php echo @$_GET['perct']; ?>" class="form-control" />
      </div>
      <div class="form-group">
      <input type="submit" value="Search" class="btn btn-primary" />
      </div>
    </form>
    <form method="POST">
    <table class="table table-striped table-condensed table-bordered table-responsive">
      <tr>
        <th>Doctor ID</th>
        <th>Doctor Name</th>
        <th>Status</th>
        <th>Similarity</th>
        <th>Action</th>
      </tr>
      <?php if(isset($similar_docs) && !empty($similar_docs) && sizeof($similar_docs) > 0): ?>
      
      <?php foreach($similar_docs as $row): ?>
      <tr>
        <td><?php echo $row['id']; ?></td>
        <td><a href="/bdabdabda/manage_doctors/viewprofile/<?php echo $row['id']; ?>" target="_blank"><?php echo $row['name']; ?></a></td>
        <td><?php 
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
          ?></td>
        <td><?php echo $row['percent'].'%'; ?></td>
        <td><input type="checkbox" id="<?php echo $row['id']; ?>" name="similardocids[]" value="<?php echo $row['id']; ?>" /></td>
      </tr>
      <?php endforeach; ?>
      <tr>
        <td colspan="4">&nbsp;</td>
        <td><input type="submit" name="chkbox" value="Mark as Duplicate" class="btn btn-primary" /></td>
      </tr>
      <?php else: ?>
      <tr>
        <td colspan="5">No Similar Doctor found</td>
      </tr>
      <?php endif; ?>
    </table>
    </form>

  </div>
</div>
<div class="panel-footer">
<?php $this->load->view('admin/common/footer'); ?>
</div>
</div>
</div>
</div>
<?php $this->load->view('admin/common/bottom'); ?>
<div class="outer-bpopup" id="change-status-modal">
<div class="inner-bpopup" style="text-align: center;"></div>
</div>
<!-- PAGE SPECIFIC JS-->
<!-- PAGE SPECIFIC JS-->

</body>
</html>
