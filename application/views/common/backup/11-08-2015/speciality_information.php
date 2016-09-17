<?php if(isset($speciality_info) && is_array($speciality_info) && sizeof($speciality_info)>0 
&& (!empty($speciality_info[1]['description']) || !empty($speciality_info[2]['description']) || !empty($speciality_info[3]['description']) )){ ?>
<div id="footer2">
<div class="container cf">
<div class="footer4_Top">

<?php if(!empty($speciality_info[1]['description'])){ ?>
<p><?php echo $speciality_info[1]['description']?></p>
<?php } ?>

<?php if(!empty($speciality_info[2]['description'])){ ?>
<span>Health tip</span>
<p><?php echo $speciality_info[2]['description']?></p>
<?php } ?>

<?php if(!empty($speciality_info[3]['description'])){ ?>
<span>Did You Know?</span>
<p><?php echo $speciality_info[3]['description']?></p>
<?php } ?>

</div>
</div>
</div>
<?php } ?>