<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Messaging
 * 
 * @property int $id
 * @property int $subject
 * @property int $message
 * @property string $status
 * @property Carbon $timestamp
 * @property int $sender_id
 * @property int $recipient_id
 * 
 * @property User $user
 *
 * @package App\Models
 */
class Messaging extends Model
{
	protected $table = 'messaging';
	public $timestamps = false;

	protected $casts = [
		'subject' => 'int',
		'message' => 'int',
		'sender_id' => 'int',
		'recipient_id' => 'int'
	];

	protected $dates = [
		'timestamp'
	];

	protected $fillable = [
		'subject',
		'message',
		'status',
		'timestamp',
		'sender_id',
		'recipient_id'
	];

	public function user()
	{
		return $this->belongsTo(User::class, 'sender_id');
	}
}
