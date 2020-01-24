<?php

 require_once 'Google/autoload.php';
   session_start();	 	
/************************************************	
 The following 3 values an befound in the setting	
 for the application you created on Google 	 	
 Developers console.	 	 Developers console.
 The Key file should be placed in a location	 
 that is not accessable from the web. outside of 
 web root.	 
 	 	 
 In order to access your GA account you must	
 Add the Email address as a user at the 	
 ACCOUNT Level in the GA admin. 	 	
 ************************************************/
$client_id = '[your client]';
	$Email_address = '[your service account email]';	 
	$key_file_location = '[Your key]';	 	
	
	$client = new Google_Client();	 	
	$client->setApplicationName("Client_Library_Examples");
	$key = file_get_contents($key_file_location);	 

// separate additional scopes with a comma	 
$scopes ="https://www.googleapis.com/auth/calendar.readonly"; 	
$cred = new Google_Auth_AssertionCredentials(	 
	$Email_address,	 	 
	array($scopes),	 	
	$key	 	 
	);	 	
$client->setAssertionCredentials($cred);
if($client->getAuth()->isAccessTokenExpired()) {	 	
	$client->getAuth()->refreshTokenWithAssertion($cred);	 	
}	 	
$service = new Google_Service_Calendar($client);    

?>

<html><body>

<?php
$calendarList  = $service->calendarList->listCalendarList();

while(true) {
	foreach ($calendarList->getItems() as $calendarListEntry) {

			echo $calendarListEntry->getSummary()."<br>\n";


			// get events 
			$events = $service->events->listEvents($calendarListEntry->id);


			foreach ($events->getItems() as $event) {
			    echo "-----".$event->getSummary()."<br>";
			}
		}
		$pageToken = $calendarList->getNextPageToken();
		if ($pageToken) {
			$optParams = array('pageToken' => $pageToken);
			$calendarList = $service->calendarList->listCalendarList($optParams);
		} else {
			break;
		}
	}
    
?>
Tutorial for this script can be found: <a href="http://www.daimto.com/google-calendar-api-with-php-service-account/">Google Calendar ServiceAccount PHP</a><br>
Working Version of this script can be found here: <a href="http://www.daimto.com/Tutorials/PHP/GCServiceAccount.php">Google Calendar Service Account PHP</a><br>
Source code for this script can be found here: <a href="http://www.daimto.com/Tutorials/PHP/GCServiceAccount.php.txt">Google CalendarService Account PHP</a>







