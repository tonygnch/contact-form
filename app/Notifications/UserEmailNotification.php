<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class UserEmailNotification extends Notification
{
    use Queueable;

    protected $inquiry;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($inquiry)
    {
        $this->inquiry = $inquiry;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
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
                    ->greeting('Hello ' . $notifiable->name . '!')
                    ->line('An inquiry has been sent from:')
                    ->line(new HtmlString('<strong>Name:</strong> ' . $this->inquiry->name))
                    ->line(new HtmlString('<strong>Email:</strong> ' . $this->inquiry->email))
                    ->line(new HtmlString('<strong>Phone:</strong> ' . $this->inquiry->phone))
                    ->line(new HtmlString('<strong>Message:</strong> ' . $this->inquiry->message))
                    ->line('Thank you for using our application!');
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
            //
        ];
    }
}
