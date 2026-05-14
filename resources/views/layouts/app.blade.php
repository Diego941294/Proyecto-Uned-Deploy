<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Guana Pollo - Sistema Preoperacional</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="gp-body">
    <div class="gp-app-shell">

        @include('layouts.navigation')

        <main class="gp-main">
            @isset($header)
                <section class="gp-page-header">
                    {{ $header }}
                </section>
            @endisset

            <section class="gp-content">
                {{ $slot }}
            </section>
        </main>

    </div>
</body>
</html>