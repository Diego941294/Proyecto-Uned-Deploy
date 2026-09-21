<?php

namespace App\Http\Controllers;

use Google\Client;

class GmailController extends Controller
{
    public function redirectToGoogle()
    {
        $client = new Client();

        $client->setClientId(env('GOOGLE_CLIENT_ID'));
        $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
        $client->setRedirectUri(env('GOOGLE_REDIRECT_URI'));

        $client->addScope('https://www.googleapis.com/auth/gmail.send');

        $client->setAccessType('offline');
        $client->setPrompt('consent');

        return redirect()->away($client->createAuthUrl());
    }

    public function handleGoogleCallback()
    {
        if (!request()->has('code')) {
            return redirect('/login')
                ->with('error', 'Google no devolvió el código de autorización.');
        }

        $client = new Client();

        $client->setClientId(env('GOOGLE_CLIENT_ID'));
        $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
        $client->setRedirectUri(env('GOOGLE_REDIRECT_URI'));

        $token = $client->fetchAccessTokenWithAuthCode(
            request('code')
        );

        if (isset($token['error'])) {
            return response()->json($token, 400);
        }

        $refreshToken = $token['refresh_token'] ?? null;

        if (!$refreshToken) {
            return response(
                'Google no devolvió un refresh token. Revoca el acceso de la aplicación y vuelve a autorizar.',
                400
            );
        }

        return response(
            'Autorización correcta. Ya se obtuvo el refresh token. No cierres esta configuración todavía.',
            200
        );
    }
}