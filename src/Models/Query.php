<?php

/**
 * Created by Reliese Model.
 */

namespace Mantis\Models;

use Carbon\Carbon;

/**
 * Class Query
 * 
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string|null $subject
 * @property string $message
 * @property Carbon $raised_at
 *
 * @package App\Models
 */
class Query extends MantisModel
{
	protected $table = 'queries';
	public $timestamps = false;

	protected $casts = [
		'raised_at' => 'datetime'
	];

	protected $fillable = [
		'name',
		'email',
		'subject',
		'message',
		'raised_at'
	];
}
