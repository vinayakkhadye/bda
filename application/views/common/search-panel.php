<div id="search-page-search-panel">
<div class="container cf">
<div class="two-third margin-bottom-0">
  <div id="tabs">
    <ul class="cf">
      <li>
        <a href="#tabs-1" title=""><span class="mobile-view-hide">Search by Speciality</span><span class="mobile-view-show">Speciality</span></a>
      </li>
      <li>
        <a href="#tabs-2" title=""><span class="mobile-view-hide">Search by Name</span><span class="mobile-view-show">Doctor</span></a>
      </li>
      <li>
        <a href="#tabs-3" title=""><span class="mobile-view-hide">Search by Clinic / Hospital Name</span><span class="mobile-view-show">Clinic</span></a>
      </li>
    </ul>
    <div id="tabs_container">
      <?php
      $spc ="";
      $doc="";
      $cli ="";
      if(isset($query['speciality']))
      {
      $spc = "true";
      $doc="false";
      $cli ="false";

      }
      else if(isset($query['doctor']))
      {
      $spc = "false";
      $doc="true";
      $cli ="false";

      }
      else if (isset($query['clinic'])) 
      {
      $spc = "false";
      $doc="false";
      $cli ="true";

        }

        

      ?>
      <!-- <div id="tabs-1" class="<?=(isset($query['speciality']) && $query['speciality']!='doctor' && $query['speciality']!='clinic') ? 'show' :'hide' ?> "> -->
      <div id="tabs-1" class="<?=$spc=="true" ? 'show' :'hide' ?> ">

        <!-- <input class="search-speaciality" type="text" id="speciality" value="<?=(isset($query['speciality'])) ? $query['speciality'] :'' ?>" url-data="<?=isset($url_speciality)?$url_speciality:''?>" /> -->
        <input class="search-speaciality" name="speciality" type="text" id="speciality" value="<?=(isset($query['speciality'])) ? $query['speciality'] :'' ?>" url-data="<?=isset($url_speciality)?$url_speciality:''?>" placeholder="Dentist, Pediatrician, Gynaecologist etc." />
        <input type="text" name="speciality" id="speciality-x" disabled="disabled" style="color: #CCC; position: absolute; background: transparent; z-index: 1; display: none; "/>

        <!-- <input class="search-location" type="text" id="location" value="<?=(isset($query['location'])) ? $query['location'] :'' ?>" url-data="<?=isset($url_location)?$url_location:''?>" /> -->
        <input class="search-location" name="location" type="text" id="location" value="<?=(isset($query['location'])) ? $query['location'] :'' ?>" url-data="<?=isset($url_location)?$url_location:''?>" placeholder="in Location" />
        <input type="text" name="location" id="location-x" disabled="disabled" style="color: #CCC; position: absolute; background: transparent; z-index: 1; display: none;"/>
          
        <input type="submit">
        <img src="<?=IMAGE_URL?>free-text.jpg" alt="Ohh yes It's Free"> 
      </div>
      <!-- <div id="tabs-2" class="<?=(isset($query['doctor'])) ? 'show' :'hide' ?>"> -->
      <div id="tabs-2" class="<?=$doc=="true" ? 'show' :'hide' ?>">
        <input class="search-name" type="text" id="doctor_name" value="<?=(isset($query['doctor']) && isset($query['query'])) ? $query['query'] :'' ?>" />
        
        <input type="submit">
        <img src="<?=IMAGE_URL?>free-text.jpg" alt="Ohh yes It's Free"> 
      </div>
      <div id="tabs-3" class="<?=$cli=="true" ? 'show' :'hide' ?>">
        <input class="search-name" type="text" id="clinic_name" value="<?=(isset($query['clinic']) && isset($query['query'])) ? $query['query'] :'' ?>" />
        <input type="submit">
        <img src="<?=IMAGE_URL?>free-text.jpg" alt="Ohh yes It's Free"> 
      </div>
    </div>
  </div>
</div>        
</div>
</div>