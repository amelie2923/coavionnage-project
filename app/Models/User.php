<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class User
 *
 * @property int $id
 * @property string $email
 * @property string $password
 * @property string $name
 * @property int $role_id
 * @property string $confirm
 * @property string $picture
 *
 * @property Role $role
 * @property Collection|Ad[] $ads
 * @property Collection|Alert[] $alerts
 * @property Collection|Favorite[] $favorites
 * @property Collection|Messaging[] $messagings
 *
 * @package App\Models
 */
class User extends Model
{
	protected $table = 'users';
	public $timestamps = false;

	protected $casts = [
		'role_id' => 'int'
	];

	protected $hidden = [
		'password',
		'confirm',
	];

	protected $fillable = [
		'email',
		'password',
		'name',
		'role_id',
		'confirm',
		'picture'
	];

	public function role()
	{
		return $this->belongsTo(Role::class);
	}

	public function ads()
	{
		return $this->hasMany(Ad::class);
	}

	public function alerts()
	{
		return $this->hasMany(Alert::class);
	}

	public function favorites()
	{
		return $this->hasMany(Favorite::class);
	}

	public function messagings()
	{
		return $this->hasMany(Messaging::class, 'sender_id');
	}
}
