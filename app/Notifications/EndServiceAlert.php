<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EndServiceAlert extends Notification
{
    use Queueable;

    public $request_id;
    public $subject = 'End Service Alert';
    public $message = 'Your working service will be ended at ';

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($lastWorkingDate)
    {
        $this->message .= $lastWorkingDate;
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
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject($this->subject)
            ->line($this->message)
            ->action('Visit Oprnize', url('/'))
            ->line('Oprnize Team!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'redirectURL' => "/dashboard/notifications",
            'message' => $this->message,
            'date' => Carbon::today()->format('Y-m-d'),
        ];
    }
}
