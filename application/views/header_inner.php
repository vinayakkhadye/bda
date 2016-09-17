<!-- Go to www.addthis.com/dashboard to customize your tools -->


<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-539a90525dd19d71"></script>
<div class="inner_header">
	<div class="header_inn_wrap">
    	<div style="width:100%; float:left;">
        	<div class="need_help"><img src="<?php echo $config[host_path];?>/images/need_help.png" /></div>
        	<div class="heJoinNow">
            
		 <?php if(isset($_SESSION['dashboard_id']) || !empty($_SESSION['dashboard_id'])){
			 $user_type = get_data("table_user","user_id='".$_SESSION['dashboard_id']."'","","user_type","","");
			 if($user_type[0]['user_type']==2){
			 $name = get_data("doctor","us_id='".$_SESSION['dashboard_id']."'","","doc_id,us_id,DrName");
			 $name = $name[0]['DrName'];
			 }
			 else if($user_type[0]['user_type']==1)
			 {
			$name = get_data("table_user as tu LEFT JOIN patient as p ON p.assoc_usr_id=tu.user_id","tu.user_id='".$_SESSION['dashboard_id']."'","","p.first_name","","");	
			$name = $name[0]['first_name'] ;
			}
			  ?>
         		<div class="logIn_box" style="color:#fff">
                	 	<a id="logIn" >Welcome <?php echo $name;?></a>
                    <div class="logIn_show">
                    	<a href="<?php echo $config[host_path];?>/admin/index.php">Profile</a>
                      	<a href="logout.php">Logout</a>
                    </div>
                </div>
         <?php }else{ ?>
            	<!--<div class="logIn_box">
                	<a id="logIn" href="#">Join Now > Login</a>
                    <div class="logIn_show">
                    	<a href="login.php#tologin">Doctor</a>
                        <a href="patient_login.php#tologin">Patient</a>
                        <a href="other_login.php#tologin">Other</a>
                    </div>
                </div>-->
                <link rel="icon" href="http://bookdrappointment.com/bdaicon.ico" type="image/x-icon">
                <link rel="icon" href="/favicon.ico" type="image/x-icon">
		<?php } ?>
        

            </div>
            <div class="menu_list">
            	<div class="loc_icon" onclick="show_location('location_dd_div')" id="location_div"> Select City</div>
            <div class="loc_wrapp" id="location_dd_div" style="display:none;">
                 	<?php 
					$city_data = get_data("city","active_city=1","imp_city ASC","*","","");;
					for($z=0;$z<count($city_data);$z++){
					?>
                    <div class="loc_<?php echo $city_data[$z]['city_id'];?>" id="loc_<?php echo $city_data[$z]['city_id'];?>">
            			<div style="cursor:pointer;" class="loc_main" id="<?php echo $city_data[$z]['city_id'];?>" onclick="set_location(this.id,'<?php echo $city_data[$z]['city_name'];?>')"><?php echo $city_data[$z]['city_name'];?></div>
           		 </div> 
                 <?php } ?>             
        	</div>
            </div>
        </div>
        
        <div class="logo_inn"><a href="index.php"><img  title = "Book Doctor Appointment Instantly" alt = "Book Doctor Appointment for Free" src="<?php echo $config[host_path];?>/images/logo.jpg"></a></div>
        <div class="menu_panel">
        	<a href="index.php" style="width: 87px;">
            	<img src="<?php echo $config[host_path];?>/images/home_icon.png">
                <span>Home</span>
                <p>Find Best Doctors</p>
            </a>
            <a href="patient.php" style="width: 91px;">
            	<img src="<?php echo $config[host_path];?>/images/Patient.png">
                <span>Patient</span>
                <p>Unlimited Benefits</p>
            </a>
            <a href="marketing.php" style="width: 120px;">
            	<img src="<?php echo $config[host_path];?>/images/doctor.png">
                <span>Doctor</span>
                <p>Digitalize Your Practice</p>
            </a><a href="contact_us.php" style="width: 87px;">
            	<img src="<?php echo $config[host_path];?>/images/contact.png">
                <span>Contact Us</span>
                <p>Get Connected</p>
            </a>
        </div>
        <div id="map-canvas"></div>
    </div>
</div>
<script>
function show_location(div_id)
{
 $("#"+div_id).toggle();
 	
}
function set_location(loc_id,loc_name)
{
$("#location_div").html(loc_name)
$("#location_dd_div").hide()

$("#header_loc").val(loc_id)

}


</script>




