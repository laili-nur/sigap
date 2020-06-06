<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jagolibrary {

     function sendNotifToId($message, $id, $data) {
	    $API_ACCESS_KEY = "AAAAynUFPBA:APA91bE6RmWSRL4AblfZhilkkwAhofDE7paQKDGenK__xRRDSeEDAggJyUvCyyEUxFnPB01DDII-n0II0VZ6fVkqkcdTRyoEWWmMgevYhgwiygalwTER331AtbyKyyXVXYZHIEZYLzc3";

	    $url = 'https://fcm.googleapis.com/fcm/send';

	    $fields = array (
	            'registration_ids' => array (
	                    $id
	            ),
	            'data' => $data,                
	            'priority' => 'high',
	            'notification' => $message,
	    );
	    $fields = json_encode ( $fields );

	    $headers = array (
	            'Authorization: key=' . $API_ACCESS_KEY,
	            'Content-Type: application/json'
	    );
	    $ch = curl_init ();
	    curl_setopt ( $ch, CURLOPT_URL, $url );
	    curl_setopt ( $ch, CURLOPT_POST, true );
	    curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
	    curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
	    curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );
	    $result = curl_exec ( $ch );
	    curl_close ( $ch );
	    return $result;
	}
	
	function sendNotifTopics($message, $topics, $data) {
	    $API_ACCESS_KEY = "AAAAynUFPBA:APA91bE6RmWSRL4AblfZhilkkwAhofDE7paQKDGenK__xRRDSeEDAggJyUvCyyEUxFnPB01DDII-n0II0VZ6fVkqkcdTRyoEWWmMgevYhgwiygalwTER331AtbyKyyXVXYZHIEZYLzc3";

	    $url = 'https://fcm.googleapis.com/fcm/send';

	    $fields = array (
	            'to' => '/topics/'.$topics,
	            'data' => $data,                
	            'priority' => 'high',
	            'notification' => $message,
	    );
	    $fields = json_encode ( $fields );

	    $headers = array (
	            'Authorization: key=' . $API_ACCESS_KEY,
	            'Content-Type: application/json'
	    );
	    $ch = curl_init ();
	    curl_setopt ( $ch, CURLOPT_URL, $url );
	    curl_setopt ( $ch, CURLOPT_POST, true );
	    curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
	    curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
	    curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );
	    $result = curl_exec ( $ch );
	    curl_close ( $ch );
	    return $result;
	}
}