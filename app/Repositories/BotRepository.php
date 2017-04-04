<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Models\Bot;

class BotRepository extends BaseRepository
{
	protected $model;

	public function __construct()
	{
		$this->model = new Bot;
	}

	public function save($data)
	{
		$bot = null;
		if (array_key_exists('id', $data)) {
			$bot = $this->model->find($data['id']);
		} else {
			$bot = $this->model;
		}

		if (array_key_exists('name', $data)) {
			$bot->name = $data['name'];
		}
		if (array_key_exists('backend_url', $data)) {
			$bot->backend_url = $data['backend_url'];
		}
		if (array_key_exists('access_token', $data)) {
			$bot->access_token = $data['access_token'];
		}
		if (array_key_exists('platform', $data)) {
			$bot->platform = $data['platform'];
		}

		$bot->save();

		return $bot;
	}
}