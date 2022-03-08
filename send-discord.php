<?php
///////////////////////////////////////////////
//  This is a companion file that assumes    //
//  you have first gathered the data using   //
//  the main index.php file in this project  //
///////////////////////////////////////////////
// Make Sure We Have A Valid Message
if(isset($donationMessage)){
	$donationMessage = (($donationMessage != "" && $donationMessage != null) ? $donationMessage : "No Donation Message Provided");
}
if(!isset($donationMessage)){
	$donationMessage = "No Donation Message Provided";
}
// Construct Data Object To Be Sent
try{
	$data = [
        'embeds' => [[
            'title' => $donationType . " Received!",
            'description' => "Message from Sender: " . $donationMessage,
            'timestamp' => $donationTimeStamp,
            'color' => hexdec("13C3FF"),
            'author' => [
                'name' => $donationFrom,
                'url' => 'https://ko-fi.com',
                'icon_url' => "https://uploads-ssl.webflow.com/5c14e387dab576fe667689cf/61e1116779fc0a9bd5bdbcc7_Frame%206.png",
            ],
        ]],
	];
	$curl = curl_init($hook_url);
	curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
	curl_setopt($curl, CURLOPT_POST, 1);
	curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($curl, CURLOPT_HEADER, 0);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	$discord_response = curl_exec($curl);
	curl_close($curl);
}catch(Exception $exc){
	file_put_contents('error_log.txt', $exc->getMessage());
}