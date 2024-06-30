<?php

/**
 * Created by Reliese Model.
 */

namespace Mantis\Models;

use Carbon\Carbon;

/**
 * Class Employee
 *
 * @property int $id
 * @property string $name
 * @property string $username
 * @property string $gender
 * @property string|null $profile_image
 * @property string|null $banner_image
 * @property string|null $about
 * @property string|null $email
 * @property string|null $contact
 * @property string|null $address
 * @property int $salary
 * @property string $password
 * @property bool $status
 * @property Carbon $joined_at
 *
 * @package App\Models
 */
class Employee extends MantisModel
{
	protected $table = 'employees';
	public $timestamps = false;

	protected $casts = [
        'role_id' => 'int',
		'profile_image' => 'array',
		'banner_image' => 'array',
		'email' => 'array',
		'contact' => 'array',
		'address' => 'array',
        'salary' => 'int',
		'status' => 'bool',
		'joined_at' => 'datetime'
	];

	protected $hidden = [
		'password'
	];

	protected $fillable = [
        'role_id',
		'name',
		'username',
		'gender',
		'profile_image',
		'banner_image',
		'about',
		'email',
		'contact',
		'address',
		'salary',
		'password',
		'status',
		'joined_at'
	];

	public function setUsernameAttribute($value)
	{
		$this->attributes['username'] = strtolower($value);
	}

	public function role()
	{
		return $this->belongsTo(Role::class);
	}
}
