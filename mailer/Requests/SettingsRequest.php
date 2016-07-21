<?php

namespace Mailer\Requests;

use App\Http\Requests\Request;

class SettingsRequest extends Request {

	/**
	 * Determine if the user is authorised to make this request.
	 *
	 * @return boolean
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		$rules = [
			'name' 	=> 'required|max:128',
			'value'	=> 'required',
			'site_id' => 'required',
			'class' => 'required',
		];

		return $rules;
	}

	/**
	 * Override the default error messages.
	 *
	 * @return array
	 */
	public function messages()
	{
		return [];
	}
}