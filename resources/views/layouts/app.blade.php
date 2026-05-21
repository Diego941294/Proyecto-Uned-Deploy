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

            @if(session('success') || session('error'))
            <div class="gp-modal-alert" id="gpModalAlert">
                <div class="gp-modal-box">
                    <div class="gp-modal-icon">
                        {{ session('success') ? '✓' : '!' }}
                    </div>

                    <h3>
                        {{ session('success') ? 'Acción realizada' : 'Aviso del sistema' }}
                    </h3>

                    <p>
                        {{ session('success') ?? session('error') }}
                    </p>

                    <button type="button"
                        onclick="document.getElementById('gpModalAlert').style.display='none'">
                        Aceptar
                    </button>
                </div>
            </div>
            @endif

            <section class="gp-content">
                {{ $slot }}
            </section>

        </main>

    </div>
</body>

</html>