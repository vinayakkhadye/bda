<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
########## Google Settings.. Client ID, Client Secret from https://cloud.google.com/console #############
$return_gmail_url = "";
if(isset($_GET['return_url']))
{
	$return_gmail_url = "?return_url=1" ;
	$_SESSION['redirect_url'] = 1;
}
//var_dump($return_gmail_url);

$google_client_id 		= '388482236272-3fseji7im1vtpt4ongpu37rp9avpl9di.apps.googleusercontent.com';
$google_client_secret 	= '01gwTR_-SqaJTsofdnCCSgxd';
$google_redirect_url 	= 'http://bookdrappointment.com/googlelogin/patient_login.php'; //path to your script
$google_developer_key 	= 'AIzaSyByRnqzoB7Va2C6PU8XmYQJmOJhBw7a_qI';

//var_dump($_SERVER);


//var_dump($return_gmail_url);
include_once($_SERVER['DOCUMENT_ROOT'].'/includes/config.inc.php');

include_once($_SERVER['DOCUMENT_ROOT'].'/includes/functions.php');

include_once($_SERVER['DOCUMENT_ROOT'].'/includes/sql.class.php');

include_once($_SERVER['DOCUMENT_ROOT'].'/includes/update.class.php');

//include google api files
require_once 'src/Google_Client.php';
require_once 'src/contrib/Google_Oauth2Service.php';

//start session
@session_start();

$gClient = new Google_Client();
$gClient->setApplicationName('Login to bookdrappointment.com');
$gClient->setClientId($google_client_id);
$gClient->setClientSecret($google_client_secret);
$gClient->setRedirectUri($google_redirect_url);
$gClient->setDeveloperKey($google_developer_key);

$google_oauthV2 = new Google_Oauth2Service($gClient);

//If user wish to log out, we just unset Session variable
$google_redirect_url1 	= 'http://bookdrappointment.com/googlelogin/patient_login.php'.$return_gmail_url;
//var_dump($google_redirect_url1);

if (isset($_REQUEST['reset'])) 
{
  unset($_SESSION['token']);
  $gClient->revokeToken();
  header('Location: ' . mysql_real_escape_string($google_redirect_url.$return_gmail_url)); //redirect user back to page
}

//If code is empty, redirect user to google authentication page for code.
//Code is required to aquire Access Token from google
//Once we have access token, assign token to session variable
//and we can redirect user back to page and login.
if (isset($_GET['code'])) 
{ 

	$gClient->authenticate($_GET['code']);
	
	$_SESSION['token'] = $gClient->getAccessToken();
	
	header('Location: ' . mysql_real_escape_string($google_redirect_url.$return_gmail_url));
	return;
}


if (isset($_SESSION['token'])) 
{ 
	$gClient->setAccessToken($_SESSION['token']);
}


if ($gClient->getAccessToken()) 
{
	  //For logged in user, get details from google using access token
	  $user 				= $google_oauthV2->userinfo->get();
	  $user_id 				= $user['id'];
	  $user_name 			= mysql_real_escape_string($user['name']);
	  $email 				= mysql_real_escape_string($user['email']);
	  $profile_url 			= mysql_real_escape_string($user['link']);
	  $profile_image_url 	= mysql_real_escape_string($user['picture']);
	  $personMarkup 		= "$email<div><img src='$profile_image_url?sz=50'></div>";
	  $_SESSION['token'] 	= $gClient->getAccessToken();
	  //var_dump($user);
	  //exit;
}
else 
{
	//For Guest user, get google login url
	$authUrl = $gClient->createAuthUrl();
}

//HTML page start


if(isset($authUrl)) //user is not logged in, show login button
{
	echo '<a class="login" href="'.$authUrl.'&'.$return_gmail_url.'"><img src="images/signin_google.png" /></a>';
} 
else // user logged in 
{
   /* connect to database using mysqli */
	
	
	//compare user id in our database
	//$qry = mysql_query("SELECT COUNT(google_id) as usercount FROM google_users WHERE google_id=$user_id"); 
	//$user_exist = mysql_num_rows($qry);
	
	$user_exist = get_data("table_user","email_id='".$email."'","","*");
	//var_dump($user_exist);
	if(!empty($user_exist))
	{
		$_SESSION['dashboard_id'] = $user_exist[0]['user_id'];
		if($_SESSION['redirect_url']==1)
		 {
			 if($user_exist[0]['is_verified']==0)
			{ 
			
			?>
				<meta http-equiv="refresh" content="0;url=<?php echo $config[http_path];?>admin/index.php?return_url=1">		
			<?php }else
			{ ?>
				<meta http-equiv="refresh" content="0;url=<?php echo  $_SESSION['return_url'];?>">
			<?php }
		 }else
		 {
			?>
    		<meta http-equiv="refresh" content="0;url=<?php echo $config[http_path];?>admin/index.php">
    		<?php 	 
		}
	}else{ 
		
		 $query = mysql_query("INSERT INTO `table_user` (email_id,password,status,user_type) VALUES ('".$email."','',1,1)");
			$user_id = mysql_insert_id();
			$profile_pic = $profile_image_url."?sz=100";
			mysql_query("INSERT INTO patient (assoc_usr_id,profile,status,email,first_name) VALUES ('".$user_id."','".$profile_pic."',1,'".$email."','".$user_name."')");
			//echo "INSERT INTO patient (assoc_usr_id,profile,status,email,first_name) VALUES ('".$user_id."','".$profile_pic."',1,'".$email."','".$user_name."')";
			//exit;
			$result = get_data("table_user","email_id='".$email."'","","*");
			$_SESSION['dashboard_id'] = $result[0]['user_id'];
			
		if($_SESSION['redirect_url']==1)
		 {
			 if($result[0]['is_verified']==0)
			{ 
			
			?>
				<meta http-equiv="refresh" content="0;url=<?php echo $config[http_path];?>admin/index.php?return_url=1">		
			<?php }else
			{ ?>
				<meta http-equiv="refresh" content="0;url=<?php echo  $_SESSION['return_url'];?>">
			<?php }
		 }else
		 {
			?>
    		<meta http-equiv="refresh" content="0;url=<?php echo $config[http_path];?>admin/index.php">
    		<?php 	 
		}
	}


	
	//echo '<br /><a href="'.$profile_url.'" target="_blank"><img src="'.$profile_image_url.'?sz=100" /></a>';
	//echo '<br /><a class="logout" href="?reset=1">Logout</a>';
	
	//list all user details
	//echo '<pre>'; 
	//print_r($user);
	//echo '</pre>';	
}
 
?>

