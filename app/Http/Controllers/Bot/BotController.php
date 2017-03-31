<?php

namespace App\Http\Controllers\Bot;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Services\Threads\CurlMessengerSenderActionThread;

class BotController extends Controller
{
	protected $access_token = "EAAWC3BMa6koBAAbw5C2eYEruaBwToiZBv0ZB7AWQBCPeclfHBXjwhm8c3s78ZBmOTkpnbS3ofGlZBCLLHQFloAK55DFvHipmksxZBsrSEOHe7GZCEBDJsXJZBcHGd7dhDZCw53ZCH8EPgNrkuZCPuQ1otJil01z4BKjC3yqMlOuoZAoHAZDZD";
	protected $verify_token = "fb_time_bot";

	public function webhook(Request $request)
	{
		$hub_verify_token = null;
		if($request->get('hub_challenge')) {
		    $challenge = $request->get('hub_challenge');
		    $hub_verify_token = $request->get('hub_verify_token');
		}

		if ($hub_verify_token === $this->verify_token) {
		    echo $challenge;
		    die;
		}
		ini_set('user_agent','Mozilla/4.0 (compatible; MSIE 6.0)');
		$input = json_decode(file_get_contents('php://input'), true);
		$messaging = $input['entry'][0]['messaging'][0];

		$sender = $messaging['sender']['id'];
		$message = array_key_exists('message', $messaging) ? $messaging['message']['text'] : null;
		$postback_payload = array_key_exists('postback', $messaging) ? $messaging['postback']['payload'] : null;

		$result = file_get_contents("https://graph.facebook.com/v2.6/" . $sender . "?access_token=" . $this->access_token);

		if($postback_payload) {
			$message_to_reply = 'You have selected - ' . $postback_payload;
			$message_body = [
				'text' => $message_to_reply
			];
		}
		elseif ($message) {
			if (array_key_exists('quick_reply', $messaging['message'])) {
				$message_to_reply = 'You have a quick select: ' . $messaging['message']['quick_reply']['payload'];
				$message_body = [
					'text' => $message_to_reply
				];
			} else {
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
				    $this->markSeen($sender);
				    //$this->typingOn($sender);
				    //$thread_typing_on = new CurlMessengerSenderActionThread($this->access_token, $sender, 'typing_on');
				    //$thread_typing_on->start();

				    $dt = Carbon::now();
				    $dt->timezone = 'America/Lima';
				    $hours = $dt->hour < 13 ? $dt->hour : $dt->hour - 12;
				    $minutes = $dt->minute;
				    exec('env MAGICK_THREAD_LIMIT=1');
				    $pwd = exec('pwd');
				    $message_to_reply = 'Hola '. json_decode($result)->first_name. json_decode($result)->last_name . ', son las ' . $hours . ' y ' . $minutes;
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
				} elseif(preg_match('[button]', strtolower($message))) {
					$message_body = [
						'attachment' => [
							'type' => 'template',
							'payload' => [
								'template_type' => 'button',
								'text' => 'que deseas?',
								'buttons' => [
									[
										'type' => 'web_url',
										'url' => 'http://www.facebook.com',
										'title' => 'fb'
									],
									[
										'type' => 'postback',
										'title' => 'elegir item 1',
										'payload' => 'item-1'
									],
									[
										'type' => 'postback',
										'title' => 'elegir item 2',
										'payload' => 'item-2'
									]
								]
							]
						]
					];
				} elseif(preg_match('[slide]', strtolower($message))){
					$message_body = [
						'attachment' => [
							'type' => 'template',
							'payload' => [
								'template_type' => 'generic',
								'elements' => [
									[
									  "title"=>"Peter !!!",
									  "image_url"=> asset('images/peter.jpg'),
									  "subtitle"=>" Lorem ipsum dolor",
									  "default_action"=> [
									    "type"=> "web_url",
									    "url"=> "https://www.google.com",
									    //"messenger_extensions"=> true,
									    "webview_height_ratio"=> "tall",
									    //"fallback_url"=> "http://www.google.com"
									  ],
									  "buttons"=>[
									    [
									      "type"=>"web_url",
									      "url"=>"https://facebook.com",
									      "title"=>"View Website"
									    ],
									    [
									      "type"=>"postback",
									      "title"=>"Get it",
									      "payload"=>"PETER"
									    ]
									  ]
									],
									[
									  "title"=>"Pensando",
									  "image_url"=> asset('images/pensando.jpg'),
									  "subtitle"=>" Lorem ipsum pensando",
									  "default_action"=> [
									    "type"=> "web_url",
									    "url"=> "https://www.google.com",
									    //"messenger_extensions"=> true,
									    "webview_height_ratio"=> "tall",
									    //"fallback_url"=> "http://www.google.com"
									  ],
									  "buttons"=>[
									    [
									      "type"=>"web_url",
									      "url"=>"https://facebook.com",
									      "title"=>"View Website"
									    ],
									    [
									      "type"=>"postback",
									      "title"=>"Get it",
									      "payload"=>"PENSANDO"
									    ]
									  ]
									],
									[
									  "title"=>"Boludo !!!",
									  "image_url"=> asset('images/boludo.png'),
									  "subtitle"=>" Lorem ipsum boludo",
									  "default_action"=> [
									    "type"=> "web_url",
									    "url"=> "https://www.google.com",
									    //"messenger_extensions"=> true,
									    "webview_height_ratio"=> "tall",
									    //"fallback_url"=> "http://www.google.com"
									  ],
									  "buttons"=>[
									    [
									      "type"=>"web_url",
									      "url"=>"https://facebook.com",
									      "title"=>"View Website"
									    ],
									    [
									      "type"=>"postback",
									      "title"=>"Start Chatting",
									      "payload"=>"BOLUDO"
									    ]
									  ]
									]
								]
							]
						]
					];
				} elseif(preg_match('[list]', strtolower($message))){
					$message_body = [
						'attachment' => [
							'type' => 'template',
							'payload' => [
								'template_type' => 'list',
								'top_element_style' => 'compact',
								'elements' => [
									[
									  "title"=>"Peter !!!",
									  "image_url"=> asset('images/peter.jpg'),
									  "subtitle"=>" Lorem ipsum dolor",
									  "default_action"=> [
									    "type"=> "web_url",
									    "url"=> "https://www.google.com",
									    //"messenger_extensions"=> true,
									    "webview_height_ratio"=> "tall",
									    //"fallback_url"=> "http://www.google.com"
									  ],
									  "buttons"=>[
									    [
									      "type"=>"postback",
									      "title"=>"Get it",
									      "payload"=>"PETER"
									    ]
									  ]
									],
									[
									  "title"=>"Pensando",
									  "image_url"=> asset('images/pensando.jpg'),
									  "subtitle"=>" Lorem ipsum pensando",
									  "default_action"=> [
									    "type"=> "web_url",
									    "url"=> "https://www.google.com",
									    //"messenger_extensions"=> true,
									    "webview_height_ratio"=> "tall",
									    //"fallback_url"=> "http://www.google.com"
									  ],
									  "buttons"=>[
									    [
									      "type"=>"postback",
									      "title"=>"Get it",
									      "payload"=>"PENSANDO"
									    ]
									  ]
									],
									[
									  "title"=>"Boludo !!!",
									  "image_url"=> asset('images/boludo.png'),
									  "subtitle"=>" Lorem ipsum boludo",
									  "default_action"=> [
									    "type"=> "web_url",
									    "url"=> "https://www.google.com",
									    //"messenger_extensions"=> true,
									    "webview_height_ratio"=> "tall",
									    //"fallback_url"=> "http://www.google.com"
									  ],
									  "buttons"=>[
									    [
									      "type"=>"postback",
									      "title"=>"Start Chatting",
									      "payload"=>"BOLUDO"
									    ]
									  ]
									]
								]
							]
						]
					];
				} elseif(preg_match('[simple]', strtolower($message))){
					$message_body = [
						'text' => 'Pick a color:',
						'quick_replies' => [
							[
								'content_type' => 'text',
								'title' => 'Peter',
								'payload' => 'Simple item Peter',
								'image_url' => asset('images/peter.jpg')
							],
							[
								'content_type' => 'text',
								'title' => 'Boludo',
								'payload' => 'Simple item Boludo',
								'image_url' => asset('images/boludo.png')
							]
						]
					];
				} else {
					$message_to_reply = 'Huh! what do you mean?';
					$message_body = [
						'text' => $message_to_reply
					];
				}
			}
		}

		//API Url
		$url = 'https://graph.facebook.com/v2.6/me/messages?access_token='.$this->access_token;


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
		//if(!empty($input['entry'][0]['messaging'][0]['message'])){
		    $result = curl_exec($ch);
		//}
		curl_close($ch);
	}

	public function typingOn($user_id) {
		//API Url
		$url = 'https://graph.facebook.com/v2.6/me/messages?access_token='.$this->access_token;


		//Initiate cURL.
		$ch = curl_init($url);

		//The JSON data.
		$jsonData = json_encode([
			'recipient' => [
				'id' => $user_id
			],
			'sender_action' => 'typing_on'
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

		curl_exec($ch);
		curl_close($ch);
	}

	public function typingOff($user_id) {

	}

	public function markSeen($user_id) {
		//API Url
		$url = 'https://graph.facebook.com/v2.6/me/messages?access_token='.$this->access_token;


		//Initiate cURL.
		$ch = curl_init($url);

		//The JSON data.
		$jsonData = json_encode([
			'recipient' => [
				'id' => $user_id
			],
			'sender_action' => 'mark_seen'
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

		curl_exec($ch);
		curl_close($ch);
	}
}
