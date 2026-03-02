<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SpotifyWebAPI\Session;
use SpotifyWebAPI\SpotifyWebAPI;

class SpotifyController extends Controller
{
    private function getSession()
    {
        return new Session(
            config('notch64.spotify.client_id'),
            config('notch64.spotify.client_secret'),
            config('notch64.spotify.redirect_uri')
        );
    }

    // Step 1: Send the user to Spotify to log in
    public function auth()
    {
        $session = $this->getSession();

        $options = [
            'scope' => [
                'user-top-read',
            ],
        ];

        header('Location: ' . $session->getAuthorizeUrl($options));
        die();
    }

    // Step 2: Spotify sends the user back here after they approve
    public function callback(Request $request)
    {
        $session = $this->getSession();

        // Exchange the code Spotify gave us for an access token
        $session->requestAccessToken($request->get('code'));

        $accessToken = $session->getAccessToken();
        $refreshToken = $session->getRefreshToken();

        // Store both tokens in the database config
        \DB::table('spotify_tokens')->updateOrInsert(
            ['id' => 1],
            [
                'access_token'  => $accessToken,
                'refresh_token' => $refreshToken,
                'updated_at'    => now(),
                'created_at'    => now(),
            ]
        );

        return redirect('/')->with('message', 'Spotify connected successfully!');
    }
}
