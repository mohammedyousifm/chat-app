<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\User;

class SendMessageNotificationNotification extends Notification
{
    use Queueable;


    public $message;
    public $sender_id;
    /**
     * Create a new notification instance.
     */
    public function __construct($newMessage, $sender_id)
    {
        $this->message = $newMessage;
        $this->sender_id = $sender_id;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }



    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $sender = User::find($this->sender_id);
        $senderName = $sender ? $sender->name : 'Unknown User';
        return [
            'sender_id' => $this->sender_id,
            'message' =>  $senderName . ': ' . $this->message->message,
        ];
    }
}
