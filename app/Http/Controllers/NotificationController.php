<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\NewOrderNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class NotificationController extends Controller
{
    function send()
    {
        $admin = User::find(1);
        $admin->notify(new NewOrderNotification('Ali','Jacket',150));

        // If there was more than one admin
        // $admins = User::where('type','admin')->get();
        // Notification::send($admins, new NewOrderNotification());

        return "Notification Send";
    }
}
