<?php

namespace Mailer\Models;

use Illuminate\Database\Eloquent\Model;

class Emails extends Model
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
	protected $table = 'emails';

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
		'email',
	];

	public function sites()
    {
		return $this->belongsToMany('Mailer\Models\Sites','emails_sites','email_id','site_id');
    }

    public function tags()
    {
		return $this->belongsToMany('Mailer\Models\Tags','emails_tags','email_id','tag_id');
    }

}