<?php

namespace App\Http\Controllers\Telegram;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Telegram\TelegramBotService;

class TelegramBotController extends Controller
{
	protected $telegram_service;

	public function __construct(TelegramBotService $telegram_service){
		$this->telegram_service = $telegram_service;
	}

	public function webhook(Request $request){
		$update_id = $request->get('update_id');
		$message = $request->get('message');

		if ($this->telegram_service->isCommand($message)) {
			$decoded = $this->telegram_service->decodeCommand($message['text']);

			if ($decoded == 'start') {
				$text_response = "hello, I'm  jeromy's test bot";
			} else {
				$text_response = "I dont understand you";
			}

			return $this->telegram_service->sendMessage($message['chat']['id'], $text_response);
		}
	}
}

