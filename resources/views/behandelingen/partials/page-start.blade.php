<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-[#f8f4ea] bg-no-repeat font-sans antialiased" style="background-image: url('{{ asset('images/behandelingen-background.svg') }}'); background-position: center top; background-size: 100% 100%;">
        <div class="flex min-h-screen w-full flex-col overflow-hidden bg-transparent">
            @include('behandelingen.partials.header')
