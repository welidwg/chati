<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\notification;

class NotificationController extends Controller
{
    //
    public function SendNotif($title, $from, $to, $subject)
    {
        $notif = new notification;
        $notif->title = $title;
        $notif->from = $from;
        $notif->to = $to;
        $notif->subject = $subject;
        $notif->save();
    }
}
