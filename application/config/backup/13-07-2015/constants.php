<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');

/* MY Application Constants */
define("BASE_URL",'https://www.bookdrappointment.com/'); /* constants.php loads before config.php that's why BASE_URL declared here and constant used in config.php*/
define("MAIN_URL",'https://www.bookdrappointment.com/'); 
define("MSTATIC_URL",MAIN_URL."static/");

define("STATIC_URL",BASE_URL."static/");
define("CSS_URL",STATIC_URL."css/");
define("IMAGE_URL",STATIC_URL."images/");
define("EMAIL_IMAGE_URL",MSTATIC_URL."images/mailers/images/");
define("MEDIA_URL",STATIC_URL."media/");
define("UPLOADS_URL",BASE_URL."uploads/");

define("JS_URL",STATIC_URL."js/");
define("VIEW_PATH",APPPATH."views/");
define("NEW_LINE","\n");


define("IN_ACTIVE",0);
define("ACTIVE",1);
define("FEATURED",2);
define("DELETED",-1);
define("LIMIT",10);
define("MAIL_ID","mktg@bookdrappointment.com");
define("APPOINTMENT_DURATION","30 mins"); # value in minutes
define("PATIENT",1);
define("DOCTOR",2);
define("CLINIC",3);

define("ADMIN_All_FUNCTIONS",1);
define("ADMIN_APPOINTMENTS",2);
define("ADMIN_DOCTORS",3);
define("ADMIN_REVIEWS",4);
define("ADMIN_PACKAGES",5);
define("ADMIN_TRANSACTIONS",6);
define("ADMIN_MASTERS",7);
define("ADMIN_IMPORT",8);
define("ADMIN_SETTINGS",9);
define("ADMIN_ADVERTISE",10);
define("ADMIN_KNOWLARITY",11);
define("ADMIN_USER",12);



/* End of file constants.php */
/* Location: ./application/config/constants.php */