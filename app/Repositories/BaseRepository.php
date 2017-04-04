<?php

namespace App\Repositories;

class BaseRepository
{
	protected $model;

	public function all()
	{
		return $this->model->all();
	}

	public function find($id)
	{
		return $this->model->find($id);
	}
}