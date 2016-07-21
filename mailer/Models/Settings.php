<?php

namespace Mailer\Models;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{

	/**
	* The database connection used with the model.
	*
	* @var 	string
	*/
	protected $connection = 'mysql';

	/**
	* The table associated with the model.
	*
	* @var 	string
	*/
	protected $table = 'settings';

	/**
	* The attributes that should be hidden from arrays.
	*
	* @var 	array
	*/
	protected $hidden = ['id'];

	/**
	* The default attributes.
	*
	* @var 	array
	*/
	protected $attributes = [];

	/**
	* Carbon converted dates.
	*
	* @var 	array
	*/
	protected $dates = [];

	/**
	* Disable eloquent timestamps.
	*
	* @var 	boolean
	*/
	public $timestamps = true;

	/**
	* The attributes that are mass assignable.
	*
	* @var 	array
	*/
	protected $fillable = [
		'site_id',
		'class',
		'name',
		'value',
		'serialized',
	];

	public function site()
    {
        return $this->belongsTo('Mailer\Models\Sites','site_id','id');
    }

}