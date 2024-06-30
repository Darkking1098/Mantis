<?php

/**
 * Created by Reliese Model.
 */

namespace Mantis\Models;

/**
 * Class WebUri
 * 
 * @property int $id
 * @property string $uri
 * @property string $state
 * @property bool $status
 * @property bool $track
 *
 * @package App\Models
 */
class WebUri extends MantisModel
{
	protected $table = 'web_uris';
	public $timestamps = false;

	protected $casts = [
		'status' => 'bool',
		'track' => 'bool'
	];

	protected $fillable = [
		'uri',
		'state',
		'status',
		'track'
	];

	public function setUriAttribute($value)
	{
		$this->attributes['uri'] = strtolower($value);
	}
}
