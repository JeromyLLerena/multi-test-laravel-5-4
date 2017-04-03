<?php

namespace App\Services\Telegram;

use App\Services\CurlService;

class TelegramBotService
{
	protected $curl_service;
	public function __construct(CurlService $curl_service)
	{
		$this->curl_service = $curl_service;
	}

	public function isCommand($message_object)
	{
		$entities = array_key_exists('entities', $message_object) ? $message_object['entities'] : [];
		foreach ($entities as $entity) {
			if ($entity['type'] == config('constants.telegram.type_bot_command'))
				return true;
		}
		return false;
	}

	public function decodeCommand($command)
	{
		return str_replace('/', '', $command);
	}

	public function sendMessage($chat_id, $text, $optional_parameters = [])
	{
		$full_url = config('constants.telegram.api_url') . 'bot' . env('TELEGRAM_BOT_API_TOKEN') . '/sendMessage';
		$data = [
			'chat_id' => $chat_id,
			'text' => $text,
		];

		$this->curl_service->performAction($full_url, 'post', $data);
	}
}
