<?php
    
	require_once __DIR__ . '/notification.php';

	//Set the necessary parameters
    $notification      = new Notification();
    $message           = isset($_POST['message']) ? $_POST['message'] : 'Test message';
    $title             = isset($_POST['title']) ? $_POST['title'] : 'Test title';

	$notification->setTitle($message);
    $notification->setMessage($message);
    
	$firebase_api   = isset($_POST['firebase_api']) ? $_POST['firebase_api'] : 'AAAAC1ZIRdc:APA91bFC7BBc3g4Js2I9t1Ed4Z4ugoiBQCGoIHFotczgO6LV0vKyjAdY2a87QAgsVfadsY0t9l74obY6hHIT9Oycn2XsKOz_DduTGhQJPinAFb_uwMeunztQlsL65oBnLH7FBUj_9IfF'; 
	//Token to my app - No publicar
	//AAAAC1ZIRdc:APA91bFC7BBc3g4Js2I9t1Ed4Z4ugoiBQCGoIHFotczgO6LV0vKyjAdY2a87QAgsVfadsY0t9l74obY6hHIT9Oycn2XsKOz_DduTGhQJPinAFb_uwMeunztQlsL65oBnLH7FBUj_9IfF
    
    $topic = isset($_POST['topic']) ? $_POST['topic'] : 'AllUsers';
    
    $requestData = $notification->getNotificatin();    
   
    $fields = array(
        'to' => '/topics/' . $topic,
        'data' => $requestData
    );   
    
    // Set POST variables
    $url = 'https://fcm.googleapis.com/fcm/send';
    
    $headers = array(
        'Authorization: key=' . $firebase_api,
        'Content-Type: application/json'
    );
    
    // Open connection
    $ch = curl_init();
    
    // Set the url, number of POST vars, POST data
    curl_setopt($ch, CURLOPT_URL, $url);
    
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    // Disabling SSL Certificate support temporarily
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    
    // Execute post
    $result = curl_exec($ch);
    if ($result === FALSE) {
        die('Curl failed: ' . curl_error($ch));
    }
    
    // Close connection
    curl_close($ch);   

    echo $result;


?>