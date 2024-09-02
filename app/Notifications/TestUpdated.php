<?php

namespace App\Notifications;

use App\Enums\EnumHelpers;
use App\Events\TestUpdatedEvent;
use App\Models\TestInvitation;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TestUpdated extends Notification implements ShouldBroadcast
{
    use Queueable;
    use EnumHelpers;
    public $testInvitation;
    public $test;

    public function __construct(TestInvitation $testInvitation)
    {
        $this->testInvitation = $testInvitation;
        $this->test = $testInvitation->testSession->test;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database', 'broadcast'];
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
            ->subject('Test Invitation update')
            ->from(env('MAIL_FROM_ADDRESS') ?? 'TestForge@gmail.com', env('MAIL_FROM_NAME'))
            ->greeting($this->test->title . ' Test invitation')
            ->line($notifiable->username . ' has ' . $this->testInvitation->status->label() . ' your invitation')
            ->line('Thank you for using our platform');
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
            'username' => $notifiable->username,
            'email' => $notifiable->email,
            'avatar' => $notifiable->avatar,
            'test' => $this->test->title,
            'status' => $this->testInvitation->status->label()
        ];
    }

    public function toBroadcast($notifiable)
    {

        return event(new TestUpdatedEvent([
            'id' => $this->id,
            'username' => $notifiable->username,
            'email' => $notifiable->email,
            'avatar' => $notifiable->avatar,
            'test' => $this->test->title,
            'status' => $this->testInvitation->status->label()
        ]));
    }
}
