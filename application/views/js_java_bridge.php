<!DOCTYPE html>
<html>
 <head>
<script language="javascript">
	function diplayJavaMsg(msg){
		alert(msg);
	}
	<?php if($_GET['type']=="Success")
	{ ?>
	function callSuccessjavaFn(){
		var msg = "Calling from Java Script";
		var package_id = <?=intval($_GET['package_id'])?>; 
		JsHandler.jsSuccessCall(msg,package_id);
	}
	callSuccessjavaFn();
	<?php }?>

	<?php if($_GET['type']=="Aborted")
	{ ?>

	function callAbortedjavaFn(){
		var msg = "Calling from Java Script";
		var package_id = <?=intval($_GET['package_id'])?>; 
		JsHandler.jsAbortedCall(msg,package_id);
	}
	callAbortedjavaFn();
	<?php }?>

	<?php if($_GET['type']=="Failure")
	{ ?>
	
	function callFailurejavaFn(){
		var msg = "Calling from Java Script";
		var package_id = <?=intval($_GET['package_id'])?>;  
		JsHandler.jsFailureCall(msg,package_id);
	}
	callFailurejavaFn();
	<?php } ?>

	<?php if($_GET['type']=="Illegal")
	{ ?>

	function callIllegaljavaFn(){
		var msg = "Calling from Java Script";
		var package_id = <?=intval($_GET['package_id'])?>;  
		JsHandler.jsIllegalCall(msg,package_id);
	}
	callIllegaljavaFn();
	<?php }?>

</script>
 </head>
</html>