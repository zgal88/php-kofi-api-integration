<?php

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//  The following "function" was created using publically available information about the Ko-Fi API endpoint, which can be viewed  //
//  here: https://help.ko-fi.com/hc/en-us/articles/360004162298-Does-Ko-fi-Have-an-API-or-Webhook-                                 //
//                                                                                                                                 //
//  Created By: ZGal88                                                                                                             //
//  September 12th, 2021                                                                                                           //
//  Listed under the MIT License                                                                                                   //
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// First check if a 'data' object was even sent
if(isset($_POST['data'])){
	try{
		// Grabs The payload, and decodes it.
		$data = $_POST['data'];
		$array = json_decode($data, true);
		// Assign variables from data array values.
		$messageID = $array['message_id'];
		$kofiTransactionID = $array['kofi_transaction_id'];
		$donationTimeStamp = $array['timestamp'];
		// Possible Types Include Donation, Subscription, Commision, and Shop Order.
		$donationType = $array['type'];
		$donationFrom = $array['from_name'];
		$donationMessage = $array['message'];
		$donationAmount = $array['amount'];
		$donationCurrency = $array['currency'];
		$donationURL = $array['url'];
		$donationIsSubscription = $array['is_subscription_payment'];
		$donationIsFirstSubPayment = $array['is_first_subscription_payment'];
		////////////////////////////////////////////////////////////////////////////
		//                             Do Stuff Here                              //
		////////////////////////////////////////////////////////////////////////////
		
		// Send the 200 Ok Header and end function
		header($_SERVER["SERVER_PROTOCOL"]." 200 Ok");
		die;
	}catch(Exception $exc){
		// Some shizz happened, so let's log it for you
		$message = "\r\nException: " . $exc;
		// Check if there was a JSON decoding problem, and add to log if so.
		if(json_last_error()){ $message .= "\r\nJSON Decode Error Message: " . json_last_error_msg();
		// Open logs fille, append, and close.
		$errorLog = fopen('error_log.txt', 'a');
		fwrite($errorLog, $messagge);
		fclose($errorLog);
		// Now let's dump what was collected from the data object, for troubleshooting, just in case.
		$objectDumpFile = fopen(time() . '-data_dump.txt', 'a');
		fwrite($objectDumpFile, $data);
		fclose($objectDumpFile);
		// Send error code header so Ko-Fi knows the data wasn't recieved/processed properly.
		header($_SERVER["SERVER_PROTOCOL"]." 500 Internal Server Error");
		die;
	}
}
?>