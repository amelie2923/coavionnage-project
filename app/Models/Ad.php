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
 * @property int $type_ad_id
 * @property int $type_search_id
 * @property Carbon $date
 * @property string $departure
 * @property string $arrival
 * @property int $number
 * @property string $description
 * @property string $company
 * @property string $flight_number
 * @property Carbon $timestamp
 * 
 * @property User $user
 * @property TypeAd $type_ad
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
		'type_ad_id' => 'int',
		'type_search_id' => 'int',
		'number' => 'int'
	];

	protected $dates = [
		'date',
		'timestamp'
	];

	protected $fillable = [
		'user_id',
		'type_ad_id',
		'type_search_id',
		'date',
		'departure',
		'arrival',
		'number',
		'description',
		'company',
		'flight_number',
		'timestamp'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function type_ad()
	{
		return $this->belongsTo(TypeAd::class);
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
