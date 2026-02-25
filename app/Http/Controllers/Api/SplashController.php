<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SplashMessage;

class SplashController extends Controller
{
    public function random()
    {
        $message = SplashMessage::where('active', true)
            ->inRandomOrder()
            ->first();

        return response()->json([
            'message' => $message ? $message->message : 'Loading...'
        ]);
    }
}
