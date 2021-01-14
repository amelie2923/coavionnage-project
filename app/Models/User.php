<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Models\LinkedSocialAccount;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

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
 *
 * @package App\Models
 */
class User extends Authenticatable
{

	use HasApiTokens, Notifiable;

	protected $table = 'users';
	public $timestamps = false;

	protected $casts = [
		'role_id' => 'int'
	];

	protected $hidden = [
		'password',
		'remember_token'
	];

	protected $fillable = [
		'email',
		'password',
		'name',
		'role_id',
		'confirm',
		'remember_token',
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

	public function linkedSocialAccounts()
  {
    return $this->hasMany(LinkedSocialAccount::class);
  }
}
