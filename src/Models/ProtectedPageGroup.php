<?php

/**
 * Created by Reliese Model.
 */

namespace Mantis\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class ProtectedPageGroup
 * 
 * @property int $id
 * @property string $title
 * @property int|null $sort_order
 * @property bool $status
 * 
 * @property Collection|ProtectedPage[] $protected_pages
 *
 * @package App\Models
 */
class ProtectedPageGroup extends MantisModel
{
	protected $table = 'protected_page_groups';
	public $timestamps = false;

	protected $casts = [
		'sort_order' => 'int',
		'status' => 'bool'
	];

	protected $fillable = [
		'title',
		'sort_order',
		'status'
	];

	protected static function boot()
	{
		parent::boot();
		static::addGlobalScope('order', function (Builder $builder) {
			$builder->orderBy('sort_order', 'asc');
		});
	}

	public function pages()
	{
		return $this->hasMany(ProtectedPage::class, 'group_id');
	}

	public function display_pages()
	{
		return $this->hasMany(ProtectedPage::class, 'group_id')->display();
	}
}
