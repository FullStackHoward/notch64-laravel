<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\StreamSchedule;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Carbon;

class TwitchController extends Controller
{
    /**
     * Fetch an app access token from Twitch.
     */
    private function getAccessToken(): ?string
    {
        $response = Http::post('https://id.twitch.tv/oauth2/token', [
            'client_id'     => env('TWITCH_CLIENT_ID'),
            'client_secret' => env('TWITCH_CLIENT_SECRET'),
            'grant_type'    => 'client_credentials',
        ]);

        if ($response->successful()) {
            return $response->json('access_token');
        }

        return null;
    }

    /**
     * Check whether itsnotch64 is currently live on Twitch.
     */
    public function liveStatus()
    {
        $token = $this->getAccessToken();

        if (!$token) {
            return response()->json([
                'is_live'      => false,
                'title'        => null,
                'viewer_count' => null,
            ]);
        }

        $response = Http::withHeaders([
            'Client-ID'     => env('TWITCH_CLIENT_ID'),
            'Authorization' => 'Bearer ' . $token,
        ])->get('https://api.twitch.tv/helix/streams', [
            'user_login' => 'itsnotch64',
        ]);

        if ($response->successful()) {
            $data = $response->json('data');

            if (!empty($data)) {
                $stream = $data[0];
                return response()->json([
                    'is_live'      => true,
                    'title'        => $stream['title'],
                    'viewer_count' => $stream['viewer_count'],
                ]);
            }
        }

        return response()->json([
            'is_live'      => false,
            'title'        => null,
            'viewer_count' => null,
        ]);
    }

    /**
     * Return upcoming active stream schedules.
     */
    public function schedule()
    {
        $schedules = StreamSchedule::where('active', true)
            ->where('scheduled_at', '>=', Carbon::now())
            ->orderBy('scheduled_at', 'asc')
            ->get()
            ->map(function ($item) {
                return [
                    'id'               => $item->id,
                    'title'            => $item->title,
                    'description'      => $item->description,
                    'scheduled_at'     => $item->scheduled_at->format('l, F j, Y \a\t g:i A'),
                    'duration_minutes' => $item->duration_minutes,
                ];
            });

        return response()->json($schedules);
    }
}
