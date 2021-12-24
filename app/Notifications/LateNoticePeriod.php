<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LateNoticePeriod extends Notification
{
    use Queueable;

    public $subject = 'Late Notice Period';
    public $message = 'You are late for the notice period ';

    /**
     * Create a new notification instance.
     *
     * @param $lateDays
     */
    public function __construct($lateDays)
    {
        $this->message .= $lateDays . ' Days';
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'mail'];
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
            'redirectURL' => '/dashboard/notifications/',
            'message' => $this->message,
            'date' => Carbon::today()->format('Y-m-d'),
        ];
    }
}
