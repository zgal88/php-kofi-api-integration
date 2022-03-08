<?php
///////////////////////////////////////////////
//  This is a companion file that assumes    //
//  you have first gathered the data using   //
//  the main index.php file in this project  //
///////////////////////////////////////////////
$donation_types['Donation', 'Subscription', 'Commission', 'Shop Order'];
// Make Sure We Have A Valid Message
$donation_message = "";
if(isset($donationmessage)) $donation_message = (($donationMessage != "" && $donationMessage != null) ? $donationMessage : "No Donation Message Provided"
if(!isset($donationmessage)) $donation_message = "No Donation Message Provided";
// Construct Data Object To Be Sent
$data = json_encode([
	"embeds" => [
		// Grab The Donation Type And Display
		"title" : $donation_types[array_search($donationType, $donation_types)] . " Recieved!",
		// Set The Color To Ko-Fi Blue
		"color" => hexdec("13C3FF"),
		// Set Author, Using Default Image From Ko-Fi Website
		"author" => [
			"name" => $donationFrom,
			"url" => "https://uploads-ssl.webflow.com/5c14e387dab576fe667689cf/61e1116779fc0a9bd5bdbcc7_Frame%206.png"
		],
		// Set Description, With Their Message
		"description" => $donation_message,
		// Set Timestamp
		"timestamp" => $donationTimeStamp,
	]
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
$curl = curl_init($hook_url);
curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_POSTFIELDS, $json_data);
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($curl, CURLOPT_HEADER, 0);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
$discord_response = curl_exec($curl);
curl_close($curl);