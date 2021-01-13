<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Ad
 *
 * @property int $id
 * @property int $user_id
 * @property int $type_search_id
 * @property Carbon $date
 * @property string $departure_city
 * @property string $arrival_city
 * @property int $number_animals
 * @property string $description
 * @property string $company
 * @property string|null $image
 * @property Carbon $timestamp
 *
 * @property User $user
 * @property TypeSearch $type_search
 * @property Collection|Favorite[] $favorites
 *
 * @package App\Models
 */
class Ad extends Model
{
	protected $table = 'ads';
	public $timestamps = false;

	protected $casts = [
		'user_id' => 'int',
		'type_search_id' => 'int',
		'number_animals' => 'int'
	];

	protected $dates = [
		'date',
		'timestamp'
	];

	protected $fillable = [
		'user_id',
		'type_search_id',
		'date',
		'departure_city',
		'arrival_city',
		'number_animals',
		'description',
		'company',
		'image',
		'timestamp'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function type_search()
	{
		return $this->belongsTo(TypeSearch::class);
	}

	public function favorites()
	{
		return $this->hasMany(Favorite::class);
	}
}
