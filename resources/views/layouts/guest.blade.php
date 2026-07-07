<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Kniploket Tiko</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-white font-sans text-[#10213D] antialiased">
        <main class="grid min-h-screen lg:grid-cols-[1fr_520px]">
            <section class="hidden items-center justify-center border-r border-gray-300 bg-white px-10 lg:flex">
                <div class="max-w-xl text-center">
                    <img src="{{ asset('images/kniploket-tiko-logo.png') }}" alt="Kniploket Tiko" class="mx-auto w-full max-w-md">
                </div>
            </section>

            <section class="flex min-h-screen items-center justify-center px-6 py-10">
                <div class="w-full max-w-sm">
                    <div class="mb-8 text-center lg:hidden">
                        <img src="{{ asset('images/kniploket-tiko-logo.png') }}" alt="Kniploket Tiko" class="mx-auto h-32 w-32 object-contain">
                    </div>

                    {{ $slot }}
                </div>
            </section>
        </main>
    </body>
</html>
