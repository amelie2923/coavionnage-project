<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PlaneTicket
 *
 * @property int $id
 * @property int $user_id
 * @property Carbon $date
 * @property string $departure_city
 * @property string $arrival_city
 * @property string|null $description
 * @property string $company
 * @property Carbon $timestamp
 *
 * @property User $user
 *
 * @package App\Models
 */
class PlaneTicket extends Model
{
	protected $table = 'plane_tickets';
	public $timestamps = false;

	protected $casts = [
		'user_id' => 'int'
	];

	protected $dates = [
		'date',
		'created_at'
	];

	protected $fillable = [
		'user_id',
		'date',
		'departure_city',
		'arrival_city',
		'description',
		'company',
		'created_at'
	];

	protected $with = [
		'user'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
