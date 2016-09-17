<div class="container cf">
<div class="footer4_Top"><!--footer4_Top Start-->
  <h2>Popular Searches</h2>
</div>
<?php if(isset($city_top_speciality) && is_array($city_top_speciality) && sizeof($city_top_speciality)>0){ 
	foreach($city_top_speciality as $city_key=>$city_val){?>
<div class="footerCol_New"><!--footerCol_New Start-->
  <h3><?php echo ucwords($city_key)?></h3>
  <div class="colContent_New"><!--colContent_New Start-->
    <ul>
    <?php foreach($city_val as $top_spKey=>$top_spVal){ ?>  
		  <li><a href="<?=BASE_URL.url_string($city_key)."/".$top_spVal['url_name']?>"><?=$top_spVal['display_name']?></a></li>
    <?php }?>
    </ul>
  </div><!--colContent_New End-->
</div>
<?php }} ?>
</div>