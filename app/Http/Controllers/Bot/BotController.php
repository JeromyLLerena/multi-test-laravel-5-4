<?php

namespace App\Http\Controllers\Bot;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Repositories\BotRepository;

class BotController extends Controller
{
	public function __construct(BotRepository $bot_repository)
	{
		$this->bot_repository = $bot_repository;
	}

	public function index()
	{
		$bots = $this->bot_repository->all();

		return view('admin.bots.index')->with(['bots' => $bots]);
	}

	public function showCreate()
	{
		return view('admin.bots.create');
	}

	public function create(Request $request)
	{
		$data = $request->all();

		$this->bot_repository->save($data);

		return redirect()->route('bots.index');
	}

	public function showEdit($id)
	{
		$bot = $this->bot_repository->find($id);

		return view('admin.bots.edit')->with(['bot' => $bot]);
	}

	public function edit(Request$request, $id)
	{

	}
}
