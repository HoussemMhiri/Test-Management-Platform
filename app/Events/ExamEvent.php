<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class ExamEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $examId;
    public $answeredQuestionsCount;
    public $totalTimeSpent;
    public $totalTimeRemaining;
    public $userTestAttemptId;
    public $status;
    public $nombreOfQuestion;
    public $userEmail;
    public $totalPoints;

    public function __construct($examId, $answeredQuestionsCount, $totalTimeSpent, $totalTimeRemaining, $userTestAttemptId, $status, $nombreOfQuestion, $userEmail, $totalPoints)
    {
        $this->examId = $examId;
        $this->answeredQuestionsCount = $answeredQuestionsCount;
        $this->totalTimeSpent = $totalTimeSpent;
        $this->totalTimeRemaining = $totalTimeRemaining;
        $this->userTestAttemptId = $userTestAttemptId;
        $this->status = $status;
        $this->userEmail = $userEmail;
        $this->nombreOfQuestion = $nombreOfQuestion;
        $this->totalPoints = $totalPoints;
    }

    // public function broadcastOn()
    // {
    //     return new Channel('exam.' . $this->examId);
    // }
    public function broadcastOn()
    {
        return new Channel('exam');
    }

    public function broadcastAs()
    {
        return 'exam.event';
    }
}
