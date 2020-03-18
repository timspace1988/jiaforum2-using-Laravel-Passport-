<?php

namespace App\Http\Controllers\Api\V1;

//use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\NotificationResource;

class NotificationsController extends Controller
{
    //Get notifications list
    public function index(Request $request){
        $notifications = $request->user()->notifications()->paginate();

        return NotificationResource::collection($notifications);
    }
}
