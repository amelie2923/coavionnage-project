<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TypeAd
 *
 * @property int $id
 * @property int $name
 *
 * @property Collection|Ad[] $ads
 *
 * @package App\Models
 */
class TypeAd extends Model
{
	protected $table = 'type_ad';
	public $timestamps = false;

	protected $casts = [
		'name' => 'int'
	];

	protected $fillable = [
		'name'
	];

	public function ads()
	{
		return $this->hasMany(Ad::class);
	}
}
