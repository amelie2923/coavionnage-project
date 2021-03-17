<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Ad
 *
 * @property int $id
 * @property string $animal_name
 * @property int $user_id
 * @property int $type_search_id
 * @property Carbon $date
 * @property string $departure_city
 * @property string $arrival_city
 * @property string $description
 * @property string $company
 * @property string|null $image
 * @property Carbon $created_at
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
		'type_search_id' => 'int'
	];

	protected $dates = [
		'date',
		'created_at'
	];

	protected $fillable = [
		'animal_name',
		'user_id',
		'type_search_id',
		'date',
		'departure_city',
		'arrival_city',
		'description',
		'company',
		'image',
		'created_at'
	];

	protected $with = [
		'user'
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
