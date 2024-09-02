<?php

namespace App\Notifications;

use App\Events\TestUpdatedEvent;
use App\Models\TestSession;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TestSessionUpdate extends Notification implements ShouldQueue, ShouldBroadcast
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */

    public $testSession;
    public $test;
    public function __construct(TestSession $testSession)
    {
        $this->testSession = $testSession;
        $this->test = $this->testSession->test;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        if ($notifiable instanceof \App\Models\User) {
            return ['database'];
        }

        return ['mail', 'broadcast'];
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
            ->subject('Upcoming Test Notification')
            ->greeting($this->testSession->test->title . ' Test Notification')
            ->line('Your test session for "' . $this->testSession->test->title . '" will begin in 30 minutes.')
            ->action('View Test Session', url('http://127.0.0.1:8000/testsSession'))
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
            'test' => $this->test->title,
            'avatar' => $this->test->thumbnail,
            'message' => "Your test session will begin in 30 minutes."
        ];
    }

    public function toBroadcast($notifiable)
    {

        return event(new TestUpdatedEvent([
            'id' => $this->id,
            'test' => $this->test->title,
            'avatar' => $this->test->thumbnail,
            'message' => "Your test session will begin in 30 minutes."
        ]));
    }
}
