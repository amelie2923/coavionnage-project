<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Alert
 *
 * @property int $id
 * @property string $arrival
 * @property string $departure
 * @property Carbon $date
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
		'arrival',
		'departure',
		'date',
		'user_id'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
