<?php

namespace App\Http\Controllers;

use Request;
use Response;
use Mailer\Models\Tags;

class TagsController extends Controller {

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct(Tags $tags)
	{
		$this->tags = $tags;
	}

	public function index()
	{
		$vars = [
			'legend' => 'Tags',
			'tags' => $this->tags->orderBy('created_at','DESC')->paginate(),
		];
		return view('tags',compact('vars'));
	}
}