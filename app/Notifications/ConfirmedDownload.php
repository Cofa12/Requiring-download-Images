<?php

namespace App\Notifications;

use App\Models\Image;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ConfirmedDownload extends Notification
{
    use Queueable;

    public $image;
    public $demander;
    /**
     * Create a new notification instance.
     */
    public function __construct($image,$demander)
    {
        $this->image = Image::findOrFail($image);
        $this->demander = User::findOrFail($demander);
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)->view(
            'emails.DownloadImage',['image'=>$this->image,'demander'=>$this->demander]
        );

    }
    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }

//    public function routeNotificationForMail(Notification $notification): array|string
//    {
//        // Return email address only...
//        return $this->demander->email;
//
//    }
}
