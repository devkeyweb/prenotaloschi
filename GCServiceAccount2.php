<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require __DIR__ . '/vendor/autoload.php';

$client = new Google_Client();

$scopes = [ Google_Service_Calendar::CALENDAR, Google_Service_Calendar::CALENDAR_READONLY ];
$client->addScope($scopes);

$client->setAuthConfig('traslochiloschi-1579269914905-815060bd2fb4.json');
$service = new Google_Service_Calendar($client);

$calendarList = $service->calendarList->listCalendarList();

while(true) {

  foreach ($calendarList->getItems() as $calendarListEntry) {
  	echo "<pre>";
  	print_r($calendarListEntry);
  	echo "</pre>";
    echo $calendarListEntry->getSummary();
    echo "<br/>------------------------------<br/><br/>";

    // get events 
    $events = $service->events->listEvents($calendarListEntry->id);

    foreach ($events->getItems() as $event) {
        echo "- " . $event->getSummary() . "<br/>";
        echo "| " . $event->getStart()->getDateTime() . "<br/><br/>";
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






