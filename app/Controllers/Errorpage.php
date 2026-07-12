<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Errorpage extends BaseController
{
	public function index()
	{
		return view('errors/custom_404');
	}
}