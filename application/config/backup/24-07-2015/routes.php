<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/
$route['default_controller'] = "home";
$route['404_override'] = 'errors/page_missing';

/* connecting to city table to get currently available cities */
require_once( BASEPATH .'database/DB'. EXT );

$db =& DB();

$query = $db->query( 'select name from city where status in (1,2)' );

$result = $query->result();
foreach( $result as $row )
{
    $city_route_array[]= str_replace(" ","-",strtolower($row->name));
}

$regionArray = $city_route_array;
/* connecting to city table to get currently available cities */

$rGstr = implode('|',$regionArray);
$route['('.$rGstr.')/health-utsav'] = "health_utsav/index/$1";
$route['(:any)/profile/(:any)'] = "profile/doctor/$1/$2";
$route['('.$rGstr.')/(:any)'] = 'home/index/$1/$2';
$route['('.$rGstr.')'] = 'home/index/$1';
$route['('.$rGstr.')'] = 'home/index/$1';
 
$route['('.$rGstr.')/doctor/(:any)/(:any)'] = "home/index/$1/doctor/$2/$3";
$route['('.$rGstr.')/doctor/(:any)'] = "home/index/$1/doctor/$2";

$route['('.$rGstr.')/clinic/(:any)/(:any)'] = "home/index/$1/clinic/$2/$3";
$route['('.$rGstr.')/clinic/(:any)'] = "home/index/$1/clinic/$2";


$route['about-us'] = "staticpages/about_us";

$route['add-ons'] = "staticpages/add_on";

$route['contact-us'] = "staticpages/contact_us";

$route['patient'] = "staticpages/patient";

$route['doctor-practice-management'] = "staticpages/marketing";

$route['doctor-faq'] = "staticpages/doctor_faq";

$route['patient-faq'] = "staticpages/patient_faq";

$route['js_java_bridge.html'] = "staticpages/js_java_bridge";

$route['terms-conditions'] = "staticpages/terms_and_conditions";

$route['privacy-policy'] = "staticpages/privacy_policy";

$route['bookappointment'] = "bookappointment/index";

$route['profile/(:any)/(:num).html'] = "profile/doctor/$2";

$route['forgor_password_mail.html'] = "staticpages/forgor_password_mail";

$route['bdabdabda/appointments/(:num)'] = "bdabdabda/appointments";

$route['migration/doctor_app_promotion.png'] = "migration/doctor_app_promotion";

$route['sitemap.xml'] = "sitemap/urls/";
$route['sitemap/(:any).xml'] = "sitemap/sitemap_xml/$1";
$route['sitemap-profile/(:any).xml'] = "sitemap/sitemap_profile_xml/$1";
$route['sitemap/website.xml'] = "sitemap/website_links";


/* End of file routes.php */
/* Location: ./application/config/routes.php */