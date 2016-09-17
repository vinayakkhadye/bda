 <nav class="navbar-inverse MB15">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="<?=BASE_URL?>doctor/scheduler">Book <span class="grren">Dr</span> Appointment</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
              <li class="<?=(isset($current_tab)&& $current_tab=='details')?'active':'';  ?>">
                <a href="<?=BASE_URL?>patient/details">Profile</a>
              </li>
          </ul>
          <ul class="nav navbar-nav">
              <li class="<?=(isset($current_tab)&& $current_tab=='appointments')?'active':'';  ?>">
                <a href="<?=BASE_URL?>patient/appointments">Appointments</a>
              </li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?=$name?> <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="/logout">Log out </a></li>
                <li><a href="/patient/changepassword">Change Password</a></li>
              </ul>
            </li>          
            
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>