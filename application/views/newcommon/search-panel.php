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
      <div id="tabs-1" class="<?=(isset($query['speciality']) && $query['speciality']!='doctor' && $query['speciality']!='clinic') ? 'show' :'hide' ?>">
        <input class="search-speaciality" type="text" id="speciality" value="<?=(isset($query['speciality'])) ? $query['speciality'] :'' ?>" />
        <input class="search-location" type="text" id="location" value="<?=(isset($query['location'])) ? $query['location'] :'' ?>" />
        <input type="submit">
      </div>
      <div id="tabs-2" class="<?=(isset($query['doctor'])) ? 'show' :'hide' ?>">
        <input class="search-name" type="text" id="doctor_name" value="<?=(isset($query['doctor']) && isset($query['query'])) ? $query['query'] :'' ?>" />
        <input type="submit">
      </div>
      <div id="tabs-3" class="<?=(isset($query['clinic'])) ? 'show' :'hide' ?>">
        <input class="search-name" type="text" id="clinic_name" value="<?=(isset($query['clinic']) && isset($query['query'])) ? $query['query'] :'' ?>" />
        <input type="submit">
      </div>
    </div>
  </div>
</div>        
</div>
</div>