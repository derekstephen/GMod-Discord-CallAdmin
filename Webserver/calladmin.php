<?php

//=======================================================================================================
// You can Modify
// Create new webhook in your Discord channel settings and copy&paste URL
//=======================================================================================================

$webhookurl = "YOUR_DISCORD_WEBHOOK";

$secret = "YOUR_SECRET_TOKEN";

$timestamp = date("c", strtotime("now"));

$staff_role = "YOUR_DISCORD_STAFF_ROLE_ID"; // Example: <@&1234567890>

//=======================================================================================================
// Do not modify
//========================================================================================================

$server_role = $_POST["server_role"] ?: "";

if ($server_role != "")  {
	$server_role = "<@&".$server_role.">";
}

$color = hexdec( "ff0000" );

if ($_POST["admins_online"] == "true") {
	$color = hexdec( "ff9911" );
}

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
    "content" => $staff_role." ".$server_role." \n\nQuick Join: ".$server_ip,

    // Text-to-speech
    "tts" => false,

    // Embeds Array
    "embeds" => [
        [
            // Embed Title
            "title" => "Someone needs help on the Server!!!",

            // Embed Type
            "type" => "rich",

            // Embed Description
            "description" => "Oh no! You better put down your joos box! ".$staff_role,

            // Timestamp of embed must be formatted as ISO8601
            "timestamp" => $timestamp,

            // Embed left border color in HEX
            "color" => $color,

            // Footer
            "footer" => [
                "text" => $_POST["server"] ?: "",
                "icon_url" => "https://swagaloo.com/joos.jpg"
            ],

            // Additional Fields array
            "fields" => [
                [
                    "name" => "Calling Player",
                    "value" => ($_POST["calling_name"] ?: "Caller Unknown")."\n".($_POST["calling_id"] ?: "Caller ID Unknown"),
                    "inline" => false
                ],
                [
                    "name" => "Reported Player",
                    "value" => ($_POST["report_name"] ?: "Reported Player Unknown")."\n".($_POST["report_id"] ?: "Reported Player ID Unkwown"),
                    "inline" => false
                ],
				[
                    "name" => "Reason",
                    "value" => $_POST["reason"] ?: "Reason Unknown.",
                    "inline" => true
                ],
				[
                    "name" => "Map",
                    "value" => $_POST["map"] ?: "Map Unknown.",
                    "inline" => true
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
