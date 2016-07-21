<?php

namespace App\Http\Controllers;

use Request;
use Response;
use Mailer\Requests\SitesRequest;
use Mailer\Models\Sites;

class SitesController extends Controller {

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct(Sites $sites)
	{
		$this->sites = $sites;
	}

	/**
	 * Add a new site
	 *
	 * @return json
	 */
	public function add()
	{
		$vars = [
			'site' 		=> $this->sites->newInstance(),
			'sites'		=> $this->sites->all(),
			'legend' 	=> 'Add a site',
			'action' 	=> route('sites.add'),
		];
		return view('sites_form',compact('vars'));
	}

	/**
	 * Edit a setting
	 *
	 * @return json
	 */
	public function edit($site_id)
	{
		$site = $this->sites->where('id',$site_id)->first();
		$vars = [
			'site' 		=> $site,
			'legend' 	=> 'Edit a site',
			'action' 	=> route('sites.update', ['id' => $site_id]),
		];
		return view('sites_form',compact('vars'));
	}

	/**
	 * Site home
	 *
	 * @return json
	 */
	public function home($site_id)
	{
		$site = $this->sites->where('id',$site_id)->first();
		$vars = [
			'site' 		=> $site,
			'legend' 	=> $site->name,
			'site_id' 	=> $site_id,
		];
		return view('sites_home',compact('vars'));
	}

	public function index()
	{
		$vars = [
			'sites' => $this->sites->all(),
		];

		return view('sites',compact('vars'));
	}

	/**
	 * Add a new setting
	 *
	 * @return json
	 */
	public function create(SitesRequest $request)
	{
		$data = $request->only(['name','enabled']);
		$return = $this->sites->create($data);
		return redirect()->route('sites.index');
	}

	public function update(SitesRequest $request, $site_id)
	{
		$data = $request->only(['name','enabled']);
		$return = $this->sites->where('id',$site_id)->update($data);
		return redirect()->route('sites.index');
	}
}