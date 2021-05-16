<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Alert
 *
 * @property int $id
 * @property string $departure_city
 * @property string $arrival_city
 * @property Carbon $date
 * @property string $company
 * @property int $user_id
 *
 * @property User $user
 *
 * @package App\Models
 */
class Alert extends Model
{
	protected $table = 'alerts';
	public $timestamps = false;

	protected $casts = [
		'user_id' => 'int'
	];

	protected $dates = [
		'date'
	];

	protected $fillable = [
		'departure_city',
		'arrival_city',
		'date',
		'company',
		'user_id'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	protected $with = [
		'user'
	];
}
