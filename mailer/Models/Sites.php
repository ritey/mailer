<?php

namespace Mailer\Models;

use Illuminate\Database\Eloquent\Model;

class Sites extends Model
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
	protected $table = 'sites';

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
		'enabled',
		'created_at',
		'updated_at',
		'name',
	];

	public function settings()
    {
        return $this->hasMany('Mailer\Models\Settings','id','site_id');
    }

    public function emails()
    {
        return $this->belongsToMany('Mailer\Models\Emails','emails_sites','site_id','email_id');
    }
}