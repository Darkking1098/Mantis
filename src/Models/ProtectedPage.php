<?php

/**
 * Created by Reliese Model.
 */

namespace Mantis\Models;

/**
 * Class ProtectedPage
 * 
 * @property int $id
 * @property int $group_id
 * @property string $uri
 * @property string $title
 * @property string $inner_permits
 * @property string $panel
 * @property bool $visible
 * @property bool $permission_required
 * @property bool $status
 * 
 * @property ProtectedPageGroup $protected_page_group
 *
 * @package App\Models
 */
class ProtectedPage extends MantisModel
{
	protected $table = 'protected_pages';
	public $timestamps = false;

	protected $casts = [
		'group_id' => 'int',
		'inner_permits' => 'array',
		'visible' => 'bool',
		'permission_required' => 'bool',
		'status' => 'bool'
	];

	protected $fillable = [
		'group_id',
		'uri',
		'title',
		'inner_permits',
		'panel',
		'visible',
		'permission_required',
		'status'
	];

	public function setUriAttribute($value)
	{
		$this->attributes['uri'] = strtolower($value);
	}

	public function page_group()
	{
		return $this->belongsTo(ProtectedPageGroup::class, 'group_id');
	}

	public function scopeDisplay($query)
	{
		return $query->where('status', 1)->where('visible', 1);
	}
}
