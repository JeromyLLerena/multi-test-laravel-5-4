<?php

namespace App\Services\Threads;

use Thread;

class CurlMessengerSenderActionThread extends Thread
{
	public function __construct($access_token, $user_id, $sender_action)
	{
		$this->access_token = $access_token;
		$this->user_id = $user_id;
		$this->sender_action = $sender_action;
	}

	public function run()
	{
		//API Url
		$url = 'https://graph.facebook.com/v2.6/me/messages?access_token='.$this->access_token;


		//Initiate cURL.
		$ch = curl_init($url);

		//The JSON data.
		$jsonData = json_encode([
			'recipient' => [
				'id' => $this->user_id
			],
			'sender_action' => $this->sender_action
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