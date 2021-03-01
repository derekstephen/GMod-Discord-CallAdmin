<?php

//=======================================================================================================
// You can Modify
// Create new webhook in your Discord channel settings and copy&paste URL
//=======================================================================================================

$webhookurl = "YOUR_DISCORD_WEBHOOK";

$secret = "YOUR_SECRET_TOKEN";

//=======================================================================================================
// Do not modify
//========================================================================================================

$timestamp = date("c", strtotime("now"));

$server_ip = $_POST["server_ip"] ?: "";

if ($server_ip != "") {
	$server_ip = "steam://connect/".$server_ip;
}

//=======================================================================================================
// You can Modify
// Compose message. You can use Markdown
// Message Formatting -- https://discordapp.com/developers/docs/reference#message-formatting
//========================================================================================================


$json_data = json_encode([
    // Message
    "content" => "An admin is claiming reports on this server.",
	
    // Text-to-speech
    "tts" => false,

    // Embeds Array
    "embeds" => [
        [
            // Embed Title
            "title" => ($_POST["server"] ?: "Unknown Server")." ".$server_ip,

            // Embed Type
            "type" => "rich",

            // Timestamp of embed must be formatted as ISO8601
            "timestamp" => $timestamp,

            // Embed left border color in HEX
            "color" => hexdec( "22ff22" ),

            // Footer
            "footer" => [
                "text" => "Looks like you can keep drinking your joos box.",
                "icon_url" => "https://swagaloo.com/joos.jpg"
            ],

            // Additional Fields array
            "fields" => [
                [
                    "name" => "Admin",
                    "value" => $_POST["admin_name"] ?: "Admin Unknown",
                    "inline" => false
                ]
            ]
        ]
    ]

], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );

if($_POST["token"] == $secret){
	$ch = curl_init( $webhookurl );
	curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
	curl_setopt( $ch, CURLOPT_POST, 1);
	curl_setopt( $ch, CURLOPT_POSTFIELDS, $json_data);
	curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt( $ch, CURLOPT_HEADER, 0);
	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);

	$response = curl_exec( $ch );
	// If you need to debug, or find out why you can't send message uncomment line below, and execute script.
	// echo $response;

	curl_close( $ch );
}
