<?php

namespace App\Services;

use Google\Client;
use Google\Service\Gmail;
use Google\Service\Gmail\Message;

class GmailService
{
    protected Client $client;
    protected Gmail $gmail;

    public function __construct()
    {
        $this->client = new Client();

        $this->client->setClientId(env('GOOGLE_CLIENT_ID'));
        $this->client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));

        $token = $this->client->fetchAccessTokenWithRefreshToken(
            env('GOOGLE_REFRESH_TOKEN')
        );

        if (isset($token['error'])) {
            throw new \Exception(
                'Error al renovar token de Google: ' .
                ($token['error_description'] ?? $token['error'])
            );
        }

        $this->client->setAccessToken($token);

        $this->gmail = new Gmail($this->client);
    }

    public function send(
        string $to,
        string $subject,
        string $html
    ): void {

        $from = env(
            'MAIL_FROM_ADDRESS',
            'sistemaguanapollo@gmail.com'
        );

        $boundary = 'boundary_' . md5(uniqid());

        $logoPath = public_path(
            'images/guana-pollo-logo.png'
        );

        // Encabezados principales
        $rawMessage =
            "From: GUANA POLLO <{$from}>\r\n" .
            "To: {$to}\r\n" .
            "Subject: =?UTF-8?B?" .
            base64_encode($subject) .
            "?=\r\n" .
            "MIME-Version: 1.0\r\n" .
            "Content-Type: multipart/related; boundary=\"{$boundary}\"\r\n\r\n";

        // HTML del correo
        $rawMessage .=
            "--{$boundary}\r\n" .
            "Content-Type: text/html; charset=UTF-8\r\n" .
            "Content-Transfer-Encoding: 8bit\r\n\r\n" .
            $html .
            "\r\n\r\n";

        // Logo incrustado
        if (file_exists($logoPath)) {

            $logo = base64_encode(
                file_get_contents($logoPath)
            );

            $rawMessage .=
                "--{$boundary}\r\n" .
                "Content-Type: image/png; name=\"guana-pollo-logo.png\"\r\n" .
                "Content-Transfer-Encoding: base64\r\n" .
                "Content-ID: <guana-pollo-logo>\r\n" .
                "Content-Disposition: inline; filename=\"guana-pollo-logo.png\"\r\n\r\n" .
                chunk_split($logo, 76, "\r\n") .
                "\r\n";
        }

        // Cerrar MIME
        $rawMessage .=
            "--{$boundary}--\r\n";

        // Gmail API requiere base64 URL-safe
        $encodedMessage = rtrim(
            strtr(
                base64_encode($rawMessage),
                '+/',
                '-_'
            ),
            '='
        );

        $message = new Message();
        $message->setRaw($encodedMessage);

        $this->gmail->users_messages->send(
            'me',
            $message
        );
    }
}