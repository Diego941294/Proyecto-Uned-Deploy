<x-guest-layout>
    <body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] flex flex-col min-h-screen">

      
        <header class="w-full bg-white dark:bg-[#1a1a1a] shadow-md fixed top-0 left-0 z-0">
            <div class="max-w-6xl mx-auto px-6 flex items-center justify-between h-15">
                
               
             
                @if (Route::has('login'))
                    <nav class="flex items-center gap-4">
                        @auth
                            <a href="{{ url('/dashboard') }}"
                               class="px-4 py-2 rounded-md text-[#1b1b18] dark:text-[#EDEDEC] hover:bg-[#f0f0f0] dark:hover:bg-[#2a2a2a] transition">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}"
                               class="px-4 py-2 rounded-md text-[#1b1b18] dark:text-[#EDEDEC] hover:bg-[#f0f0f0] dark:hover:bg-[#2a2a2a] transition">
                                Iniciar sesión
                            </a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                   class="px-4 py-2 rounded-md text-[#1b1b18] dark:text-[#EDEDEC] hover:bg-[#f0f0f0] dark:hover:bg-[#2a2a2a] transition">
                                    Registrarse
                                </a>
                            @endif
                        @endauth
                    </nav>
                @endif
            </div>
        </header>

      
    </body>
</x-guest-layout>


