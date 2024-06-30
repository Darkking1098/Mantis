<?php

/**
 * Created by Reliese Model.
 */

namespace Mantis\Models;

/**
 * Class Role
 * 
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $permissions
 *
 * @package App\Models
 */
class Role extends MantisModel
{
	protected $table = 'roles';
	public $timestamps = false;

	protected $casts = [
		'permissions' => 'array'
	];

	protected $fillable = [
		'title',
		'description',
		'permissions'
	];

	public function employees()
	{
		return $this->hasMany(Employee::class);
	}
}
