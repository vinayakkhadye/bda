<div class="top-bar">
	<div class="container cf">
		<div id="mobile-nav"></div>
		<ul class="one-half margin-bottom-0 need-help-contact">
			<li>
				<a href="#">Need help Booking?</a>
			</li>
			<li>
				<span class="call-img"></span>
			</li>
			<li>
				(022) 49426426
			</li>
		</ul>
		<div class="user-login-panel">
			<div class="float-right">
				<div tabindex="0" class="select-city-panel">
					<span class="select-city">
						Select City
					</span>
					<ul class="select-city-content">
						<li><a onclick="alert('click 1')">Mumbai</a></li>
						<li><a onclick="alert('click 2')">Pune</a></li>
						<li><a onclick="alert('click 3')">more Cities</a></li>
					</ul>
				</div>
				<?php $logincheck = $this->session->userdata('id'); ?>
				<?php if(!empty($logincheck)): ?>
				<div tabindex="0" class="user-name-panel">
					<span class="user-image">
						<img src="<?php echo IMAGE_URL; ?>user_image.jpg">
					</span>
					<span class="user-name">
						<?php echo $doctor['doctor_name']; ?>
					</span>
					<ul class="user-name-content">
						<li><a onclick="alert('click 1')" class="user-profile-icon">Profile</a></li>
						<li><a onclick="alert('click 2')" class="user-logout-icon">logout</a></li>
					</ul>
				</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>