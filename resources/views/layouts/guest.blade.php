<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased bg-[#F5F4F2]">
        
        <div class="min-h-screen flex flex-col justify-center items-center pt-6 sm:pt-0 p-6">
            
            <div class="mb-8">
                <a href="/">
                    <div class="flex items-center justify-center gap-2">
                         <div class="w-8 h-8 bg-black rounded text-white flex items-center justify-center font-bold">L</div>
                         <span class="font-bold text-xl tracking-tight">iebArt</span>
                    </div>
                </a>
            </div>

            <div class="w-full sm:max-w-[480px] bg-white shadow-sm rounded-[20px] px-8 py-10 sm:px-10 sm:py-12">
                {{ $slot }}
            </div>

        </div>
    </body>
</html>