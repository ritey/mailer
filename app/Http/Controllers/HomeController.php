<?php

namespace App\Http\Controllers;

use Request;
use Response;

class HomeController extends Controller {

	public function index()
	{
		return view('welcome');
	}

}