<?php

namespace App\Http\Controllers;

use Request;
use Response;
use Mailer\Requests\SitesRequest;
use Mailer\Models\Sites;
use Mailer\Library\Settings;

class SitesController extends Controller {

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct(Sites $sites, Settings $settings)
	{
		$this->sites = $sites;
		$this->settings = $settings;
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

		$settings = [
			'MAILGUN_FROM_ADDRESS',
			'MAILGUN_FROM_NAME',
			'MAILGUN_REPLY_TO',
			'MAILGUN_SECRET',
			'MAILGUN_PUBLIC',
			'MAILGUN_DOMAIN',
			'MAILGUN_FORCE_FROM_ADDRESS',
			'MAILGUN_CATCH_ALL',
			'MAILGUN_TEST_MODE',
		];

		foreach($settings as $setting) {
			$data = [
				'site_id' 		=> $return->id,
				'name'			=> $setting,
				'value' 		=> '',
				'serialized' 	=> 0,
				'class' 		=> 'config',
			];
			$this->settings->create($data);
		}

		return redirect()->route('sites.index');
	}

	public function update(SitesRequest $request, $site_id)
	{
		$data = $request->only(['name','enabled']);
		$return = $this->sites->where('id',$site_id)->update($data);
		return redirect()->route('sites.index');
	}

	public function delete($site_id)
	{
		if ($site_id) {
			$this->sites->where('id',$site_id)->delete();
			$settings = [
				'column' => 'site_id',
				'target' => $site_id,
			];
			$this->settings->delete($settings);
		}
		return redirect()->route('sites.index');
	}
}