<?php

namespace App\Http\Controllers;

use Request;
use Response;
use Mailer\Requests\SettingsRequest;
use Mailer\Library\Settings;
use Mailer\Models\Sites;

class SettingsController extends Controller {

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct(Settings $settings, Sites $sites)
	{
		$this->settings = $settings;
		$this->sites = $sites;
	}

	/**
	 * Add a new setting
	 *
	 * @return json
	 */
	public function add()
	{
		$vars = [
			'setting' 	=> $this->settings->getNew(),
			'sites'		=> $this->sites->all(),
			'legend' 	=> 'Add a setting',
			'action' 	=> route('settings.add'),
		];
		return view('settings_form',compact('vars'));
	}

	/**
	 * Edit a setting
	 *
	 * @return json
	 */
	public function edit($setting_id)
	{
		$setting = $this->settings->get($setting_id);
		$vars = [
			'setting' 	=> $setting['all'][0],
			'sites'		=> $this->sites->all(),
			'legend' 	=> 'Edit a setting',
			'action' 	=> route('settings.update', ['id' => $setting_id]),
		];
		return view('settings_form',compact('vars'));
	}

	public function index()
	{
		$vars = [
			'settings' => $this->settings->all(),
		];

		return view('settings',compact('vars'));
	}

	/**
	 * Add a new setting
	 *
	 * @return json
	 */
	public function create(SettingsRequest $request)
	{
		$data = $request->only(['site_id','name','value','serialized','class']);
		if ($data['serialized']) {
			$data['value'] = serialize($data['value']);
		} else {
			$data['serialized'] = 0;
		}
		$return = $this->settings->create($data);
		return redirect()->route('settings.index');
	}

	public function update(SettingsRequest $request, $setting_id)
	{
		$data = $request->only(['site_id','name','value','serialized','class']);
		if ($data['serialized']) {
			$data['value'] = serialize($data['value']);
		} else {
			$data['serialized'] = 0;
		}
		$return = $this->settings->update($setting_id,$data);
		return redirect()->route('settings.index');
	}
}