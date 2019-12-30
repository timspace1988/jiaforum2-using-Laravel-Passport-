<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class NotificationsController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        //Get the logged-in user's all notifications
        /**
         * ->notifications() is in notifiable trait, User has used it
           This method is defined in HasDataBaseNotifications.php:
            public function notifications()
            {
                return $this->morphMany(DatabaseNotification::class, 'notifiable')
                                    ->orderBy('created_at', 'desc');
            }
           The second param 'notifiable' is the alias we give to User, that means in notification table, notifiable_id stands for 'user_id', which is used to build morphMany relationship between users and notifications table
         */
        $notifications = Auth::user()->notifications()->paginate(20);

        //Mark all unread notifications as readed, clear the user's unread notification num "notification_cout"
        Auth::user()->markAsRead();
        return view('notifications.index', compact('notifications'));
    }
}
