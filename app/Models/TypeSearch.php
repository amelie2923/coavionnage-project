<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TypeSearch
 * 
 * @property int $id
 * @property string $name
 * 
 * @property Collection|Ad[] $ads
 *
 * @package App\Models
 */
class TypeSearch extends Model
{
	protected $table = 'type_search';
	public $timestamps = false;

	protected $fillable = [
		'name'
	];

	public function ads()
	{
		return $this->hasMany(Ad::class);
	}
}
