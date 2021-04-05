<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class User
 *
 * @property int $id
 * @property string $email
 * @property string $password
 * @property string $name
 * @property int|null $role_id
 * @property string $confirm
 * @property string|null $remember_token
 * @property string|null $picture
 *
 * @property Role|null $role
 * @property Collection|Ad[] $ads
 * @property Collection|Alert[] $alerts
 * @property Collection|Favorite[] $favorites
 * @property Collection|PlaneTicket[] $planetickets
 *
 * @package App\Models
 */
class User extends Authenticatable
{

	use Notifiable;

	protected $table = 'users';
	public $timestamps = false;

	protected $casts = [
		'role_id' => 'int'
	];

	protected $hidden = [
		'password',
		// 'api_token'
	];

	protected $fillable = [
		'email',
		'password',
		'name',
		'provider',
		'provider_id',
		'api_token',
		'picture',
		'role_id',
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
		return $this->belongsTo(User::class);
	}

		public function planetickets()
	{
		return $this->hasMany(PlaneTicket::class);
	}

	public function sendPasswordResetNotification($token)
	{
    $this->notify(new \App\Notifications\MailResetPasswordNotification($token));
	}

	public function profile()
	{
    return $this->hasOne(Profile::class);
	}
}
