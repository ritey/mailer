<?php

namespace App\Http\Controllers;

use Request;
use Response;
use Mailer\Models\Log;

class LogController extends Controller {

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct(Log $logs)
	{
		$this->logs = $logs;
	}

	public function index()
	{
		$vars = [
			'legend' => 'Logs',
			'logs' => $this->logs->orderBy('created_at','DESC')->paginate(),
		];
		return view('logs',compact('vars'));
	}

	public function clear()
	{
		$this->logs->truncate();
		return redirect()->route('logs.index');
	}
}