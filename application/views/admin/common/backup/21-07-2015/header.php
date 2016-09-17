<nav class="navbar-inverse" role="navigation">
   <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" 
         data-target="#navbar-collapse">
         <span class="sr-only">Book Dr Appointment</span>
         <span class="icon-bar"></span>
         <span class="icon-bar"></span>
         <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Book<span class="text-success">Dr</span>Appointment</a>
   </div>
   <div class="collapse navbar-collapse" id="navbar-collapse">
      <ul class="nav navbar-nav">
        <?php if($perms[ADMIN_APPOINTMENTS]['view']==1){ ?>
        <li class="dropdown <?=(isset($current_tab) && $current_tab == 'appointments')?'active':''; ?>" >
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Appointments<span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="/bdabdabda/appointments">All Appointment</a></li>
          <li><a href="/bdabdabda/appointments/addappointment">Add appointment</a></li>
          <li><a href="/bdabdabda/appointments/pending_appointment">Pending appointments</a></li>
          <li><a href="/bdabdabda/appointments/inprocess_appointment">In-Process appointments</a></li>
        </ul>
        </li>
        <?php } ?>

        <?php if($perms[ADMIN_DOCTORS]['view']==1){ ?>
        <li class="dropdown <?=(isset($current_tab) && $current_tab == 'doctor')?'active':''; ?>" >
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Doctors<span class="caret"></span></a>
        <ul class="dropdown-menu">
	        <li><a href="/bdabdabda/manage_doctors">Manage Doctors</a></li>
          <li><a href="/bdabdabda/manage_doctors/add_new_doctor ">Add Doctors</a></li>
	        <li><a href="/bdabdabda/manage_doctors/search_duplicates">Search Duplicate</a></li>
        </ul>
        </li>
        <?php } ?>
        
        <?php if($perms[ADMIN_REVIEWS]['view']==1){ ?>
        <li class="dropdown <?=(isset($current_tab) && $current_tab == 'reviews')?'active':''; ?>" >
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Reviews<span class="caret"></span></a>
        <ul class="dropdown-menu">
	        <li><a href="/bdabdabda/reviews" >Manage Review</a></li>
	        <li><a href="/bdabdabda/reviews/add_reviews" >Add a Review</a></li>
        </ul>
        </li>
        <?php } ?>
        
        <?php if($perms[ADMIN_PACKAGES]['view']==1){ ?>
        <li <?=(isset($current_tab) && $current_tab == 'packages')?'active':''; ?>>
        	<a href="/bdabdabda/packages">Packages</a>
        </li>
        <?php } ?>
        
        <?php if($perms[ADMIN_TRANSACTIONS]['view']==1){ ?>
        <li <?=(isset($current_tab) && $current_tab == 'transactions')?'active':''; ?>>
        	<a href="/bdabdabda/transactions">Transactions</a>
        </li>
        <?php } ?>
        
        <?php if($perms[ADMIN_MASTERS]['view']==1){ ?>
        <li class="dropdown <?=(isset($current_tab) && $current_tab == 'masters')?'active':''; ?>" >
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Masters<span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="/bdabdabda/masters/qualification">Qualification</a></li>
          <li><a href="/bdabdabda/masters/speciality">Speciality</a></li>
          <li><a href="/bdabdabda/masters/country">Country</a></li>
          <li><a href="/bdabdabda/masters/states">States</a></li>
          <li><a href="/bdabdabda/masters/city">City</a></li>
          <li><a href="/bdabdabda/masters/services">Services</a></li>
          <li><a href="/bdabdabda/masters/location">Location</a></li>
          <li><a href="/bdabdabda/masters/council">Registration Council</a></li>
          <li><a href="/bdabdabda/masters/memberships">Memberships</a></li>
          <li><a href="/bdabdabda/masters/college">Colleges</a></li>
          <li><a href="/bdabdabda/masters/packages">Packages</a></li>
        </ul>
        </li>
        <?php } ?>
        
        <?php if($perms[ADMIN_IMPORT]['view']==1){ ?>
        <li class="dropdown <?=(isset($current_tab) && $current_tab == 'import')?'active':''; ?>" >
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Import<span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="/bdabdabda/import/doctor_data">Import Doctors</a></li>
          <!--<li><a href="/bdabdabda/import/location_data">Import Locations</a></li>-->
        </ul>
        </li>
        <?php } ?>
        
        <?php if($perms[ADMIN_SETTINGS]['view']==1){ ?>
        <li class="dropdown <?=(isset($current_tab) && $current_tab == 'setting')?'active':''; ?>" >
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Settings<span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="/bdabdabda/setting/appointment_report">Appointment Report</a></li>
        </ul>
        </li>
        <?php } ?>
        
        <?php if($perms[ADMIN_ADVERTISE]['view']==1){ ?>
        <li <?=(isset($current_tab) && $current_tab == 'advertisements')?'active':''; ?>>
        	<a href="/bdabdabda/advertisements">Advertise</a>
        </li>
        <?php } ?>
        
        <?php if($perms[ADMIN_KNOWLARITY]['view']==1){ ?>
				<li class="dropdown <?=(isset($current_tab) && $current_tab == 'knowlarity')?'active':''; ?>" >
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Knowlarity<span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="/bdabdabda/knowlarity/update_value">Working hr</a></li>
          <li><a href="/bdabdabda/knowlarity/call_record">Call Record</a></li>
          <li><a href="/bdabdabda/knowlarity/caller_info">Caller Info</a></li>
          <li><a href="/bdabdabda/knowlarity/agents">Agents</a></li>
        </ul>
        </li>
        <?php } ?>

        <?php if($perms[ADMIN_USER]['view']==1){ ?>
        <li <?=(isset($current_tab) && $current_tab == 'user')?'active':''; ?>>
          <a href="/bdabdabda/user">User</a>
        </li>
        <?php } ?>




      </ul>
       <ul class="nav navbar-nav navbar-right">
				<li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php echo $this->session->userdata('admin_name'); ?> <span class="glyphicon glyphicon-user"></span></a>
          <ul class="dropdown-menu">
	          <?php if($perms[ADMIN_USER]['view']==1){ ?>
						<li><a href="/bdabdabda/manage_adminusers">Manage Users</a></li>
            <?php } ?>
            <li><a href="/bdabdabda/logout">Log Out</a></li>
          </ul>
        </li>
      </ul>
   </div>
</nav>