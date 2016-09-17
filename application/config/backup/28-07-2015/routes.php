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
#$route['('.$rGstr.')/search'] = 'home/search/$1';

#$route['('.$rGstr.')/search/(:any)'] = 'home/search/$1/$2';

#$route['('.$rGstr.')/(:any)/(:any)/(:any)'] = 'home/index/$1/$2/$3/$4';
#$route['('.$rGstr.')/(:any)/(:any)'] = 'home/index/$1/$2/$3';
$route['('.$rGstr.')/(:any)'] = 'home/index/$1/$2';
$route['('.$rGstr.')'] = 'home/index/$1';
$route['('.$rGstr.')'] = 'home/index/$1';
 
$route['('.$rGstr.')/doctor/(:any)/(:any)'] = "home/index/$1/doctor/$2/$3";
$route['('.$rGstr.')/doctor/(:any)'] = "home/index/$1/doctor/$2";

$route['('.$rGstr.')/clinic/(:any)/(:any)'] = "home/index/$1/clinic/$2/$3";
$route['('.$rGstr.')/clinic/(:any)'] = "home/index/$1/clinic/$2";
#$route['('.$rGstr.')/speciality/(:any)'] = "home/speciality/$1/$2";
#$route['('.$rGstr.')/clinic/(:any)'] = "home/clinic/$1/$2";

#$route['(:any)/speciality'] = "home/index/$1";

#$route['(:any)/index.html'] = "home/index/$1";

$route['about-us.html'] = "staticpages/about_us";
$route['about_us'] = "staticpages/about_us";
$route['about-us'] = "staticpages/about_us";

$route['add-ons.html'] = "staticpages/add_on";
$route['add_ons'] = "staticpages/add_on";
$route['add-ons'] = "staticpages/add_on";

$route['contact-us.html'] = "staticpages/contact_us";
$route['contact_us'] = "staticpages/contact_us";
$route['contact-us'] = "staticpages/contact_us";

$route['patient.html'] = "staticpages/patient";
$route['patient'] = "staticpages/patient";

$route['marketing.html'] = "staticpages/marketing";
$route['doctor_practice_management'] = "staticpages/marketing";
$route['doctor-practice-management'] = "staticpages/marketing";

$route['doctor-faq.html'] = "staticpages/doctor_faq";
$route['doctor_faq'] = "staticpages/doctor_faq";
$route['doctor-faq'] = "staticpages/doctor_faq";

$route['patient-faq.html'] = "staticpages/patient_faq";
$route['patient_faq'] = "staticpages/patient_faq";
$route['patient-faq'] = "staticpages/patient_faq";

$route['js_java_bridge.html'] = "staticpages/js_java_bridge";

$route['terms-conditions.html'] = "staticpages/terms_and_conditions";
$route['terms_conditions'] = "staticpages/terms_and_conditions";
$route['terms-conditions'] = "staticpages/terms_and_conditions";

$route['privacy-policy.html'] = "staticpages/privacy_policy";
$route['policy'] = "staticpages/privacy_policy";
$route['privacy-policy'] = "staticpages/privacy_policy";

$route['bookappointment'] = "bookappointment/index";

$route['profile/(:any)/(:num).html'] = "profile/doctor/$2";

$route['forgor_password_mail.html'] = "staticpages/forgor_password_mail";

$route['bdabdabda/appointments/(:num)'] = "bdabdabda/appointments";

$route['migration/doctor_app_promotion.png'] = "migration/doctor_app_promotion";

$route['sitemap/(:any).xml'] = "sitemap/sitemap_xml/$1";

/* End of file routes.php */
/* Location: ./application/config/routes.php */