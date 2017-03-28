<?php

namespace App\Http\Controllers\Bot;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class BotController extends Controller
{
	public function webhook(Request $request)
	{
		$access_token = "EAAWC3BMa6koBAAbw5C2eYEruaBwToiZBv0ZB7AWQBCPeclfHBXjwhm8c3s78ZBmOTkpnbS3ofGlZBCLLHQFloAK55DFvHipmksxZBsrSEOHe7GZCEBDJsXJZBcHGd7dhDZCw53ZCH8EPgNrkuZCPuQ1otJil01z4BKjC3yqMlOuoZAoHAZDZD";
		$verify_token = "fb_time_bot";
		$hub_verify_token = null;

		if($request->get('hub_challenge')) {
		    $challenge = $request->get('hub_challenge');
		    $hub_verify_token = $request->get('hub_verify_token');
		}

		if ($hub_verify_token === $verify_token) {
		    echo $challenge;
		    die;
		}
		ini_set('user_agent','Mozilla/4.0 (compatible; MSIE 6.0)');
		$input = json_decode(file_get_contents('php://input'), true);

		$sender = $input['entry'][0]['messaging'][0]['sender']['id'];
		$message = $input['entry'][0]['messaging'][0]['message']['text'];

		$result = file_get_contents("https://graph.facebook.com/v2.6/" . $sender . "?access_token=" . $access_token);
		/**
		 * Some Basic rules to validate incoming messages
		 */
		if(preg_match('[time|current time|now|hora|fecha]', strtolower($message))) {
		 
		    // Make request to Time API
		    //ini_set('user_agent','Mozilla/4.0 (compatible; MSIE 6.0)');
		    //$result = file_get_contents("http://www.timeapi.org/utc/now?format=%25a%20%25b%20%25d%20%25I:%25M:%25S%20%25Y");
		    //if($result != '') {
		    //    $message_to_reply = $result;
		    //}
		    //$message_to_reply = Carbon::now()->toDateTimeString();
		    $dt = Carbon::now();
		    $dt->timezone = 'America/Lima';
		    $hours = $dt->hour < 13 ? $dt->hour : $dt->hour - 12;
		    $minutes = $dt->minute;
		    exec('env MAGICK_THREAD_LIMIT=1');
		    $pwd = exec('pwd');
		    $message_to_reply = 'Hola '. json_decode($result)->first_name. ', son las ' . $hours . ' y ' . $minutes;
		    $command = 'echo "' . $message_to_reply . '" | ' . 'text2wave -o ' . $pwd .'/audios/hour_to_' . $sender  . '.mp3' . ' -eval "(voice_el_diphone)"';

		    exec($command);
		    //sleep(1);

		    $message_body = [
				'attachment' => [
					'type' => 'audio',
					'payload' => [
						'url' => url('audios/hour_to_' . $sender . '.mp3')
					]
				]
		    ];
		} elseif(preg_match('[hola|hello|hi|holas]', strtolower($message))) {
			//curl_setopt($ch, CURLOPT_GET, 1);
			//$result = curl_exec($ch);
			//curl_close($ch);
			$message_to_reply = "Hola " . json_decode($result)->first_name . ", soy FootBot, un robot creado por Jeromy. Él está desarrollando en mí la capacidad de conocer los diferentes partidos de fútbol y notificárselos a los hinchas!!!";
		    $message_body = [
		    	'text' => $message_to_reply
		    ];
		} elseif(preg_match('[video]', strtolower($message))){
			$message_body = [
				'attachment' => [
					'type' => 'video',
					'payload' => [
					/*
						'url' => url('videos/SampleVideo_360x240_2mb.mp4'),
						'is_reusable' => true
						*/
						'attachment_id' => 1435921046481265
					]
				]
			];
		} else {
		    $message_to_reply = 'Huh! what do you mean?';
		    $message_body = [
		    	'text' => $message_to_reply
		    ];
		}
		//print $message_to_reply;
		//print $message_to_reply;

		//API Url
		$url = 'https://graph.facebook.com/v2.6/me/messages?access_token='.$access_token;


		//Initiate cURL.
		$ch = curl_init($url);

		//The JSON data.
		$jsonData = json_encode([
			'recipient' => [
				'id' => $sender
			],
			'message' => $message_body
		]);

		//Encode the array into JSON.
		$jsonDataEncoded = $jsonData;

		//Tell cURL that we want to send a POST request.
		curl_setopt($ch, CURLOPT_POST, 1);

		//Attach our encoded JSON string to the POST fields.
		curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);

		//Set the content type to application/json
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		//curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));

		//Execute the request
		if(!empty($input['entry'][0]['messaging'][0]['message'])){
		    $result = curl_exec($ch);
		}
		curl_close($ch);
	}
}
