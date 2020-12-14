<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Favorite
 * 
 * @property int $id
 * @property int $user_id
 * @property int $ad_id
 * 
 * @property Ad $ad
 * @property User $user
 *
 * @package App\Models
 */
class Favorite extends Model
{
	protected $table = 'favorites';
	public $timestamps = false;

	protected $casts = [
		'user_id' => 'int',
		'ad_id' => 'int'
	];

	protected $fillable = [
		'user_id',
		'ad_id'
	];

	public function ad()
	{
		return $this->belongsTo(Ad::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
