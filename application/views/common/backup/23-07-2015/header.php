<div class="top-bar">
  <div class="container cf">
    <div id="mobile-nav"></div>
    <ul class="one-half margin-bottom-0 need-help-contact">
      <li>
        <a href="javascript:;">Need help Booking?</a>
      </li>
      <li>
        <span class="call-img"></span>
      </li>
      <li>
        (022) 49 426 426
      </li>    
    </ul>
    <div class="user-login-panel">
      <div class="float-right">
      <div tabindex="0" class="select-city-panel">
        <span class="select-city"><?=((isset($cityName) && !empty($cityName))? ucwords(reverse_url_string($cityName)):'Select City')?></span>
        <ul class="select-city-content">
        <span id="main_cities">
        <?php 
				foreach($city as $cKey=>$cVal)
        {?>          
        <li><a href="<?=BASE_URL.strtolower($cVal['url_name'])?>" ><?php echo ucwords($cVal['name']); ?></a></li>
        <?php }?>
        </span>
        <?php if(isset($other_city) && is_array($other_city) && sizeof($other_city)){?>
        <span id="show_link" >
        <li><a style="color:#67aef9">More Cities</a></li>
        </span>
        <span id="more_cities">
        <?php foreach($other_city as $cKey=>$cVal)
        {?>          
        <li><a href="<?=BASE_URL.strtolower($cVal['url_name'])?>"><?=$cVal['name']?></a></li>
        <?php }?>
        </span>
        <?php }?>
        </ul>
      </div>
      <?php if(isset($header['userData']) && is_array($header['userData']) && sizeof($header['userData'])>0 ){?>
      <div tabindex="0" class="user-name-panel">
        <span class="user-image">
        	<img src="<?php echo $header['userData']['image']; ?>">
        </span>
        <span class="user-name">
        	<?php echo ucwords($header['userData']['name']); ?>
        </span>
        <ul class="user-name-content">
          <li><a href="<?=BASE_URL ?>/login" class="user-profile-icon">Profile</a></li>
          <li><a href="<?=BASE_URL ?>logout" class="user-logout-icon">Logout</a></li>
        </ul>
      </div>      
      <?php }?>  
        
        
        
      </div>
    </div>
  </div>
</div>
<div class="logo-panel">
  <div class="container cf">
    <div class="one-half margin-bottom-0">
        <a href="<?php echo BASE_URL; ?>">
          <span class="logo"></span>
        </a>
    </div>
    <div class="one-half last margin-bottom-0 mobile-view-hide">
        <div class="float-right">
            <ul class="nav" id="menu">
                <a href="<?php echo BASE_URL; ?>">
                    <li>
                        <span class="nav-image nav-home-image"></span>
                        <span class="nav-title">Home</span>
                        <span class="nav-tagline">Find Best Doctors</span>
                    </li>
                </a>    
                <a href="<?php echo BASE_URL."patient"; ?>">
                    <li>
                        <span class="nav-image nav-patient-image"></span>
                        <span class="nav-title">Patient</span>
                        <span class="nav-tagline">Unlimited Benefits</span>
                    </li>
                </a>
                <a href="<?php echo BASE_URL."doctor-practice-management"; ?>">
                    <li>
                        <span class="nav-image nav-doctor-image"></span>
                        <span class="nav-title">Doctor</span>
                        <span class="nav-tagline">Login</span>
                    </li>
                </a>
            </ul>
        </div>
    </div>
  </div>
</div>
