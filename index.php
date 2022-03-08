<?php
/////////////////////////////////////////////////////////////////////////////////////////////////////////
//  The following "function" was created using publically available                                    //
//  information about the Ko-Fi API endpoint, which can be viewed                                      //
//  here: https://help.ko-fi.com/hc/en-us/articles/360004162298-Does-Ko-fi-Have-an-API-or-Webhook-     //
//                                                                                                     //
//  Created By: ZGal88                                                                                 //
//  September 12th, 2021                                                                               //
//  Listed under the MIT License                                                                       //
/////////////////////////////////////////////////////////////////////////////////////////////////////////
try{
	// IMPORTANT : Verification Token is used to ensure messages sent to your API are actually from Ko-Fi
	// You can get your verification token on the same page you enabled your webhook on, under 'Advanced'
	// Link: https://ko-fi.com/manage/webhooks
	// If You Do Not Change This To Your Token This Plugin Will Not Work!
	$verification_token = "12345678-abcd-1234-abcd-123456789123";
	// send_discord_webhook : set to 'true' if you want to enable the Discord webhook sender.
	// Assumes send-discord.php is in the same folder as this file.
	// 
	// hook_url : Required if sending - change this to your own webhook address. Will fail
	// if you do not change it.
	$send_discord_webhook = true;
	$hook_url = "https://discord.com/api/webhooks/123456789123456789/ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567887654321";
	// First check if a 'data' object was even sent
	if(isset($_POST['data'])){
		try{
			// Grabs The payload, and decodes it.
			$data = $_POST['data'];
			$array = json_decode($data, true);
			// First Check If Verification Token Matches
			if($array['verification_token'] == $verification_token){
				// Verification Matched
				// We can proceed with collecting and processing data 
				// This is the internal Ko-Fi message ID
				$messageID = (($array['message_id'] != "") ? $array['message_id'] : "None");
				// Internal Ko-Fi transaction ID
				$kofiTransactionID = (($array['kofi_transaction_id'] != "") ? $array['kofi_transaction_id'] : "None");
				// When the donation was sent
				$donationTimeStamp = (($array['timestamp'] != "") ? $array['timestamp'] : "None");
				// The donation type - Possible Types Include Donation, Subscription, Commission, and Shop Order.
				$donationType = (($array['type'] != "") ? $array['type'] : "None");
				// Display name for who ssent the donation; not necessarily their Ko-Fi username.
				$donationFrom = (($array['from_name'] != "") ? $array['from_name'] : "None");
				// The email address of the sender
				$donationEmail = (($array['email'] != "") ? $array['email'] : "None");
				// If they left a message, it's here.
				$donationMessage = (($array['message'] != "") ? $array['message'] : "None");
				// The numerical value of the donation amount
				$donationAmount = (($array['amount'] != "") ? $array['amount'] : "None");
				// The donation currency
				$donationCurrency = (($array['currency'] != "") ? $array['currency'] : "None");
				// URL of donaiton
				$donationURL = (($array['url'] != "") ? $array['url'] : "None");
				// Is the donation a subscription?
				$donationIsSubscription = (($array['is_subscription_payment'] != "") ? $array['is_subscription_payment'] : "None");
				// Is iot the first payment in the subscription?
				$donationIsFirstSubPayment = (($array['is_first_subscription_payment'] != "") ? $array['is_first_subscription_payment'] : "None");
				
				////////////////////////////////////////////////////////////////////////////
				//                                                                        //
				//                  Do Stuff Here With The Gathered Data                  //
				//                                                                        //
				////////////////////////////////////////////////////////////////////////////
				
				// Send Discord Webhook, If Enabled
				if($send_discord_webhook == true) require('send-discord.php');
				// Send the 200 Ok Header and end function
				header($_SERVER["SERVER_PROTOCOL"]." 200 Ok");
			}
			if($array['verification_token'] != $verification_token){
				// Do Something Here If You Want To Log The Mismatched Verifications
				// This might be good information to log, if you want to keep track
				// of possible fraudulent attempts on your site.
			}
		}catch(Exception $exc){
			// Some shizz happened, so let's log it for you
			$message = "\r\nException: " . $exc->getMessage();
			// Check if there was a JSON decoding problem, and add to log if so.
			if(json_last_error()) $message .= "\r\nJSON Decode Error Message: " . json_last_error_msg();
			// Open logs fille, append, and close.
			$errorLog = fopen('error_log.txt', 'a');
			fwrite($errorLog, $message);
			fclose($errorLog);
			// Now let's dump what was collected from the data object, for troubleshooting, just in case.
			$objectDumpFile = fopen(time() . '-data_dump.txt', 'a');
			fwrite($objectDumpFile, $data);
			fclose($objectDumpFile);
			// Send error code header so Ko-Fi knows the data wasn't recieved/processed properly.
			header($_SERVER["SERVER_PROTOCOL"]." 500 Internal Server Error");
		}
	}
	// Gracefully close out everything, and tell the function to exit.
	die;
}catch(Exception $exc){
	// Just on the offchance something got messed up prior to collecting data
	// Logs it here to error.txt log
	file_put_contents('error.txt', $exc->getMessage());
}
?>