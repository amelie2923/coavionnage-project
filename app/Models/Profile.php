<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Profile
 *
 * @property int $id
 * @property int $user_id
 * @property string $address
 * @property string $mail
 * @property string $phone
 *
 * @property User $user
 *
 * @package App\Models
 */
class Profile extends Model
{
	protected $table = 'profiles';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id' => 'int',
		'user_id' => 'int'
	];

	protected $fillable = [
		'user_id',
		'address',
		'mail',
		'phone'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
