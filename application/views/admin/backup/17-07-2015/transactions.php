<!DOCTYPE html>
<html lang="en">
<head>
  <title>Transactions | BDA</title>
	<?php $this->load->view('admin/common/head'); ?>
</head>
<body>
<?php $this->load->view('admin/common/header'); ?>
<div class="container-fluid">
<div class="panel panel-default">
<div class="panel-heading">Transactions</div>
<div class="panel-body">
<form class="form-inline" method="GET" action="">
  <div class="form-group">
    <label class="control-label">Users Name : </label>
    <input name="doctor_name" type="text" placeholder="User's Name" value="<?=@$doctor_name?>" class="form-control" />
  </div>
  <div class="form-group">
    <label class="control-label">Package Type : </label>
    <select name="package_type" class="form-control" >
      <option value="">Select Type</option>
      <option value="1" <?=(isset($package_type) && $package_type	==	1)?'selected':''?>>Doctor Package</option>
      <option value="2" <?=(isset($package_type) && $package_type == 2)?'selected':''?>>Sms Package</option>
    </select>
  </div>
  <div class="form-group">
    <label class="control-label">Order Status : </label>
    <select name="order_status" class="form-control" >
      <option value="">Select Status</option>
      <option value="1" <?=(isset($order_status) && $order_status	==	1)?'selected':''?>>Success</option>
      <option value="0" <?=(isset($order_status) && $order_status == 0)?'selected':''?>>Failure</option>
      <option value="-1" <?=(isset($order_status) && $order_status == -1)?'selected':''?>>Aborted</option>
    </select>
  </div>
  <div class="form-group">
  <input type="submit" value="Search" name="search" class="btn btn-primary" >
  </div>
</form>
<hr />
<form>
	<div class="form-group">
    <table class="table table-striped table-condensed table-bordered table-responsive">
      <tr>
      <th><span class="glyphicon glyphicon-check" aria-hidden="true"></span></th>
      <th>Order ID</th>
      <th>Doctor Name</th>
      <th>Package Name</th>
      <th>Order Status</th>
      <th>Payment Mode</th>
      <th>Card/Bank Name</th>
      <th>Amount</th>
      <th>Transaction start time</th>
      <th>Transaction end time</th>
      </tr>
      <?php
      if(@$results){
			foreach($results as $row){?>
      <tr>
        <td>
          <input type="checkbox" class="rowcheck" name="transactions_id[<?php echo @$row->order_id; ?>]" id="id_<?php echo @$row->order_id; ?>" />
        </td>
        <td>
          <a href="/bdabdabda/transactions/viewdetails/<?php echo $row->order_id; ?>"><?php echo @$row->order_id; ?></a>
        </td>
        <td><?php echo ucfirst($row->doctor_name); ?></td>
        <td>
          <?php
          if($row->package_id == 10){
            echo 'Smart Listing';
          }
          else
          if($row->package_id == 20)
          {
            echo 'Smart Online Reputation';
          }
          else
          if($row->package_id == 30)
          {
            echo 'Smart Appointment';
          }
          else
          if($row->package_id == 50)
          {
            echo 'Smart Clinic';
          }
          else
          if($row->package_id == 60)
          {
            echo 'Smart Clinic Plus';
          }
          else
          if($row->package_id == 40)
          {
            echo 'Smart Receptionist';
          }
          else
          if($row->package_id == 100)
          {
            echo 'Free Trial';
          }
          else
          if($row->package_id == 1)
          {
            echo ' - ';
          }
          ?>
        </td>
        <td><?php echo ucfirst($row->order_status); ?></td>
        <td><?php echo $row->payment_mode;?></td>
        <td><?php echo $row->card_name;?></td>
        <td><?php echo $row->amount; ?></td>
        <td><?php echo date('d-m-Y h:i:s a', strtotime($row->transaction_started_on)); ?></td>
        <td><?php echo $row->transaction_ended_on; ?></td>
      </tr>
      <?php }}else{?>
      <tr>
      <td colspan="9">No Transactions Found</td>
      </tr>
      <?php
      } ?>
		</table>
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
<!--PAGE SPECIFIC SCRIPT-->
</body>
</html>
