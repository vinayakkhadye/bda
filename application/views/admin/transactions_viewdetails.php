<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>View Transactions | BDA</title>
<?php $this->load->view('admin/common/head'); ?>
</head>
<body>
<?php $this->load->view('admin/common/header'); ?>
<div class="container-fluid">
<div class="panel panel-default">
<div class="panel-heading">View Transaction</div>
<div class="panel-body">
<div class="col-md-4 col-md-offset-4">
<table class="table table-striped table-condensed table-bordered table-responsive">
						<tr>
							<td>Order ID</td>
							<td><?=@$order_details['order_id']?></td>
						</tr>
						<tr>
							<td>User's Name</td>
							<td><?=@$order_details['usersname']?></td>
						</tr>
						<tr>
							<td>Package Name</td>
							<td><?=@$order_details['package_name']?></td>
						</tr>
						<tr>
							<td>Tracking ID</td>
							<td><?=@$order_details['tracking_id']?></td>
						</tr>
						<tr>
							<td>Bank Reference No.</td>
							<td><?=@$order_details['bank_ref_no']?></td>
						</tr>
						<tr>
							<td>Order Status</td>
							<td><?=@$order_details['order_status']?></td>
						</tr>
						<tr>
							<td>Failure Message</td>
							<td><?=@$order_details['failure_message']?></td>
						</tr>
						<tr>
							<td>Payment Mode</td>
							<td><?=@$order_details['payment_mode']?></td>
						</tr>
						<tr>
							<td>Card Name</td>
							<td><?=@$order_details['card_name']?></td>
						</tr>
						<tr>
							<td>Status Message</td>
							<td><?=@$order_details['status_message']?></td>
						</tr>
						<tr>
							<td>Currency</td>
							<td><?=@$order_details['currency']?></td>
						</tr>
						<tr>
							<td>Amount</td>
							<td><?=@$order_details['amount']?></td>
						</tr>
						<tr>
							<td>Transaction start time</td>
							<td><?=@date('d-m-Y h:ia', strtotime(@$order_details['transaction_started_on']))?></td>
						</tr>
						<tr>
							<td>Transaction end time</td>
							<td>
								<?php if(isset($order_details['transaction_ended_on']) && !empty($order_details['transaction_ended_on'])) echo @date('d-m-Y h:ia', strtotime(@$order_details['transaction_ended_on']))?>
							</td>
						</tr>
						<tr>
							<td>Billing Name</td>
							<td><?=@$order_details['billing_name']?></td>
						</tr>
						<tr>
							<td>Billing Address</td>
							<td><?=@$order_details['billing_address']?></td>
						</tr>
						<tr>
							<td>Billing City</td>
							<td><?=@$order_details['billing_city']?></td>
						</tr>
						<tr>
							<td>Billing State</td>
							<td><?=@$order_details['billing_state']?></td>
						</tr>
						<tr>
							<td>Billing Zip Code</td>
							<td><?=@$order_details['billing_zip']?></td>
						</tr>
						<tr>
							<td>Billing Country</td>
							<td><?=@$order_details['billing_country']?></td>
						</tr>
						<tr>
							<td>Billing Tel Number</td>
							<td><?=@$order_details['billing_tel']?></td>
						</tr>
						<tr>
							<td>Billing Email</td>
							<td><?=@$order_details['billing_email']?></td>
						</tr>
						<tr>
							<td>Delivery Name</td>
							<td><?=@$order_details['delivery_name']?></td>
						</tr>
						<tr>
							<td>Delivery Address</td>
							<td><?=@$order_details['delivery_address']?></td>
						</tr>
						<tr>
							<td>Delivery City</td>
							<td><?=@$order_details['delivery_city']?></td>
						</tr>
						<tr>
							<td>Delivery State</td>
							<td><?=@$order_details['delivery_state']?></td>
						</tr>
						<tr>
							<td>Delivery Zip Code</td>
							<td><?=@$order_details['delivery_zip']?></td>
						</tr>
						<tr>
							<td>Delivery Country</td>
							<td><?=@$order_details['delivery_country']?></td>
						</tr>
						<tr>
							<td>Delivery Tel Number</td>
							<td><?=@$order_details['delivery_tel']?></td>
						</tr>
					</table>
</div>
</div>
<div class="panel-footer">
<?php $this->load->view('admin/common/footer'); ?>
</div>
<?php $this->load->view('admin/common/bottom'); ?>
</body>	
</html>
