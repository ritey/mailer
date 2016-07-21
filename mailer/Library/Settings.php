<?php

namespace Mailer\Library;

use Mailer\Models\Settings as SettingsModel;

class Settings {

	public function __construct(SettingsModel $settings)
	{
		$this->settings = $settings;
	}

	public function all()
	{
		$settings = $this->settings->all();
		return $this->build($settings);
	}

	public function create($data) {
		$this->settings->create($data);
	}

	public function update($setting_id, $data) {
		$this->settings->where('id',$setting_id)->update($data);
	}

	public function get($setting_id)
	{
		$settings = $this->settings->where('id',$setting_id)->get();
		return $this->build($settings);
	}

	public function getNew()
	{
		return [
			'setting_id' 	=> '',
			'site_name' 	=> '',
			'class' 		=> '',
			'name'			=> '',
			'serialized'	=> '',
			'site_id'		=> '',
			'value'			=> '',
		];
	}

	private function build($settings = [])
	{
		$all = [];

		foreach($settings as $item) {
			$all[] = [
				'setting_id' 	=> $item->id,
				'site_name' 	=> $item->site()->first()->name,
				'class' 		=> $item->class,
				'name' 			=> $item->name,
				'serialized'	=> $item->serialized,
				'site_id' 		=> ($item->site()->first()->id != '') ? $item->site()->first()->id : '',
				'value'			=> ($item->serialized == 1) ? unserialize($item->value) : $item->value,
			];
		}

		return $all;
	}

}