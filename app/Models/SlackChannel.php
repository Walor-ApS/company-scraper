<?php

namespace App\Models;

use App\Notifications\SlackNotification;
use Illuminate\Support\Facades\Notification;

class SlackChannel
{
    public static function SlackNotify($message) {
        Notification::route('slack', env('SLACK_WEBHOOK'))->notify(new SlackNotification($message));
    }
}
