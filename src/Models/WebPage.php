<?php

/**
 * Created by Reliese Model.
 */

namespace Mantis\Models;

/**
 * Class WebPage
 * 
 * @property int $id
 * @property string $slug
 * @property string|null $title
 * @property string|null $description
 * @property string|null $keyword
 * @property string|null $other_meta
 * @property int $load_count
 * @property int $status
 *
 * @package App\Models
 */
class WebPage extends MantisModel
{
	protected $table = 'web_pages';
	public $timestamps = false;

	protected $casts = [
		'load_count' => 'int',
		'status' => 'bool'
	];

	protected $fillable = [
		'slug',
		'title',
		'description',
		'keyword',
		'other_meta',
		'load_count',
		'status'
	];

	public function setSlugAttribute($value)
	{
		$this->attributes['slug'] = strtolower($value);
	}

	public function toArray()
	{
		$this['url'] = url($this->slug);
		return parent::toArray();
	}
}
