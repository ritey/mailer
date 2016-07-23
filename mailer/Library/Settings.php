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
		$settings = $this->settings->paginate();
		return $this->build($settings);
	}

	public function create($data) {
		$this->settings->create($data);
	}

	public function delete($data) {
		$this->settings->where($data['column'],$data['target'])->delete();
	}

	public function update($setting_id, $data) {
		$this->settings->where('id',$setting_id)->update($data);
	}

	public function get($setting_id)
	{
		$settings = $this->settings->where('id',$setting_id)->get();
		return $this->build($settings);
	}

	public function getBySiteId($site_id)
	{
		$settings = $this->settings->where('site_id',$site_id)->get();
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
		$links = '';

		if (method_exists($settings, 'links')) {
			$links = $settings->links();
		}

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

		return ['all' => $all, 'paginate' => $links];
	}

}