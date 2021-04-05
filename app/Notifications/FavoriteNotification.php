<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class FavoriteNotification extends Notification
{
    use Queueable;

    public $user;
    public $favorite;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user, $favorite)
    {
        $this->user = $user;
        $this->favorite = $favorite;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'user_name' => $this->user->name,
            'ad_id' => $this->favorite->ad_id,
            'user_id' => $this->favorite->user_id,
        ];
    }
}
