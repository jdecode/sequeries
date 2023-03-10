<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title> {{ config('app.name', 'Laravel') }}</title>
        <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/x-icon"/>
        <link rel="stylesheet" href="{{ asset('fonts/material-icons.css') }}" />
        <link rel="stylesheet" href="{{ asset('fonts/octicons.css') }}" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            [x-cloak] { display: none !important; }
        </style>
    </head>
    <body class="antialiased text-gray-900 dark:text-gray-100 bg-gray-100 dark:bg-gray-900 min-h-screen flex flex-col justify-between">
        <div class="absolute top-0 right-0">
            <x-theme-switcher></x-theme-switcher>
        </div>
        <div
            class="
                m-12 p-12
                text-3xl text-center
                flex flex-col items-center
            ">
            <span>
                <x-application-logo></x-application-logo>
            </span>
            <span>{{ config('app.name') }}</span>
            <div class="mt-8 text-base">
                <div>
                    <a href="{{route('auth.github.login')}}" class="">
                        <span class="text-black bg-white p-3 m-2 rounded-lg font-bold flex items-center justify-between">
                            <i class="octicon-mark-github-16 pt-1 px-1 text-xl"></i>
                            <span class="pl-1">
                                Login with GitHub
                            </span>
                        </span>
                    </a>
                </div>
            </div>
        </div>
    <x-footer></x-footer>
    </body>
</html>
