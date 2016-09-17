<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php $this->load->view('login/common/head'); ?>
</head>
<body data-spy="scroll" data-target=".bs-docs-sidebar" >
<?php $this->load->view('login/common/doctor_header'); ?>
<div class="container">
<div class="row marketing">
<div class="span4">
 <div id="card-downloads" class="card">
    <div class="card-heading image">
       <img src="assets/img/logo.png" width="46" height="46" alt=""/>
       <div class="card-heading-header">
          <h3>DOWNLOAD</h3>
          <span>Latest version is 1.0.5</span>
       </div>
    </div>
    <div class="card-actions">
       <a class="btn btn-block btn-large btn-primary" href="assets/bootplus.zip">Download Dr. App</a>
        
    </div>
 </div>
 <div id="card-media" class="card">
    <div class="card-media">
       <div class="card-media-container" href="#">
          <i class="icon-desktop"></i>
          <i class="icon-tablet"></i>
          <i class="icon-mobile-phone"></i>
       </div>
    </div>
    <div class="card-body">
       <h2>Made for everyone.</h2>
       <p>Bootplus was made to not only look and behave great in the latest desktop browsers (as well as IE7!), but in tablet and smartphone browsers via <a href="./scaffolding.html#responsive">responsive CSS</a> as well.</p>
    </div>
 </div>
</div>
<div class="span4">
 <div class="card">
    <h3 class="card-heading simple">Examples</h3>
    <div class="card-body">
       <p>Bootplus provides the same basic templates form Bootstrap, adapted with the new "plus" style.</p>
    </div>
    <div class="card-actions">
       <a class="btn btn-success" href="getting-started.html#examples">
          See the examples
          <i class="icon-circle-arrow-right"></i>
       </a>
    </div>
 </div>
 <div id="card-features" class="card">
    <div class="card-media-container" href="#">
       <i class="icon-html5"></i>
       <i class="icon-css3"></i>
       <i class="icon-wrench"></i>
    </div>
    <div class="card-body">
       <h2>Packed with features.</h2>
       <p>A 12-column responsive <a href="./scaffolding.html#gridSystem">grid</a>, dozens of components, <a href="./javascript.html">JavaScript plugins</a>, typography, form controls, and even a <a href="./customize.html">web-based Customizer</a> to make Bootplus your own.</p>
    </div>
 </div>
 <div class="card">
    <div class="card-media">
       <a class="card-media-container" href="#">
          <img src="assets/img/bs-docs-twitter-github.png" alt="twitter-github"/>
       </a>
    </div>
    <div class="card-body">
       <h2>Built with Bootstrap.</h2>
       <p>Bootplus is built on top of <a href="http://twitter.github.io/bootstrap/">Twitter Bootstrap</a> as a customization that reproduce the most recent Google+ style.</p>
       <p>Bootplus utilizes <a href="http://lesscss.org">LESS CSS</a>, is compiled via <a href="http://nodejs.org">Node</a>, and is managed through <a href="http://github.com">GitHub</a> to help nerds do awesome stuff on the web.</p>
    </div>
 </div>
</div>
<div class="span4">
 <div class="card hovercard pull-right">
    <img src="<?php echo IMAGE_URL; ?>bda_logo.jpg" alt=""/>
    <div class="avatar">
       <!-- <img src="<?php if(!empty($userdetails->image)) { echo "/".$userdetails->image; } ?>" alt="" /> -->
       <img src="<?php echo IMAGE_URL; ?>bda_logo.jpg" alt="" />
    </div>
    <div class="info">
       <div class="title">
          <a target="_blank" href="/profile/doctor/<?php echo @$doctorid; ?>"  > <?php echo $name; ?> </a>
       </div> 
       <div class="desc">DM - ENDOCRINOLOGY</div>
       <div class="desc">Diabetologist</div> 
    </div>
    <div class="bottom">
       <a target="_blank" href="/profile/doctor/<?php echo @$doctorid; ?>" class="btn btn-block">
          <!-- <i class="icon-twitter"></i> -->
          View Live profile
       </a> 
    </div>
 </div>
</div>
</div>
</div>
<?php $this->load->view('login/common/footer'); ?>
<?php $this->load->view('login/common/bottom'); ?>
</body>
</html>
