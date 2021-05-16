<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AlertNotification extends Notification
{
    use Queueable;

    protected $planeticket;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($planeticket)
    {
        $this->planeticket = $planeticket;
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
            'departure_city' => $this->planeticket->departure_city,
            'arrival_city' => $this->planeticket->arrival_city,
            'date' => $this->planeticket->date,
            'company' => $this->planeticket->company,
            'user_id' => $this->planeticket->user_id,
        ];
    }
}
