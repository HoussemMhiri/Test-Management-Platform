<?php

namespace App\Http\Controllers\tests;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $notifications = $user->notifications;
        return response()->json([
            'data' => $notifications
        ], 200);
    }

    public function markAsRead(DatabaseNotification $notification)
    {
        if ($notification->notifiable_id === auth()->id() && $notification->unread()) {
            $notification->markAsRead();
            return response()->json([
                'read' => 'Notification marked as read.'
            ], 200);
        } else {
            return response()->json([
                'read' => 'Notification already read.'
            ], 200);
        }
    }
}
