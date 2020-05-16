<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Reply;

use JPush\PushPayload;
use App\Notifications\Channels\JPushChannel;

/**
 * When a Notification class implements ShoulQueue,
   Laravel will detect it and automatically put the 'sending notification' job into queue
 */
class TopicReplied extends Notification implements ShouldQueue
{
    use Queueable;

    public $reply;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Reply $reply)
    {
        $this->reply = $reply;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        //return ['mail'];
        return ['database', 'mail', JPushChannel::class];
    }

    public function toDatabase($notifiable){
        $topic = $this->reply->topic;
        $link = $topic->link(['#reply' . $this->reply->id]);

        //The data array will be converted to JSON format and saved into data column of notifications table
        return [
            'reply_id' => $this->reply->id,
            'reply_content' => $this->reply->content,
            'user_id' => $this->reply->user->id,
            'user_name' => $this->reply->user->name,
            'user_avatar' => $this->reply->user->avatar,
            'topic_link' => $link,
            'topic_id' => $topic->id,
            'topic_title' => $topic->title,
        ];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url = $this->reply->topic->link(['#reply' . $this->reply->id]);
        $title = $this->reply->topic->title;
        return (new MailMessage)
                    ->line('Your topic "' . $title . '" has new reply.')
                    ->action('View reply', $url)
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

    //Use JPush to push the notification to the user of mobile app
    public function toPush($notifiable, PushPayload $payload): PushPayload{

        return $payload->setPlatform('all')
                       ->addRegistrationId($notifiable->registration_id)
                       //registration_id is a new attribute we add to user model
                       //JPush will use this attribute to find the user's client (iphone or other phone)
                       //Then push the notification alert (even when your app is not running in backgroud)
                       ->setNotificationAlert(strip_tags($this->reply->content));
    }

}
