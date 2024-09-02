<?php

namespace App\Jobs;

use App\Models\TestInvitation;
use App\Models\TestSession;
use App\Notifications\TestSessionUpdate;
use App\Notifications\TestUpdated;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class NotifyUpcomingTestSessionsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */

    public function handle()
    {
        Log::info('NotifyUpcomingTestSessionsJob handle method started.');
        try {
            $now = Carbon::now();
            $startTime = $now->addMinutes(30);
            $testSessions = TestSession::whereRaw('DATE_FORMAT(start_at, "%Y-%m-%d %H:%i:00") = ?', [$startTime->format('Y-m-d H:i:00')])
                ->get();

            foreach ($testSessions as $session) {
                $acceptedInvitations = TestInvitation::where('test_session_id', $session->id)
                    ->where('status', 'ACCEPTED')
                    ->get();

                foreach ($acceptedInvitations as $invitation) {
                    $emails = is_array($invitation->email) ? $invitation->email : explode(',', $invitation->email);

                    foreach ($emails as $email) {
                        $email = trim($email);
                        if ($email) {
                            Notification::route('mail', $email)->notify(new TestSessionUpdate($session));
                        }
                    }

                    $user = $invitation->testSession->test->creator;
                    Log::info('Creator ' . $user->username);
                    $user->notify(new TestSessionUpdate($session));
                }
            }
            Log::info('done');
        } catch (\Throwable $e) {
            Log::error('Error in NotifyUpcomingTestSessionsJob: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
        }
    }
}
