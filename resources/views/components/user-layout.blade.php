<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title> {{ config('app.name', 'Laravel') }}</title>
        <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/x-icon"/>
        <link rel="stylesheet" href="{{ asset('fonts/material-icons.css') }}" />
        <link rel="stylesheet" href="{{ asset('fonts/octicons.css') }}" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            [x-cloak] { display: none !important; }
        </style>
    </head>
    <body class="h-full font-sans antialiased bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-200 min-h-screen flex flex-col justify-between container-fluid mx-auto">
        <div
            x-data="{
                        showMobileSidebar: false,
                        sidebarCollapsed: false,
                        collapseSidebar() {
                            this.sidebarCollapsed = true
                            localStorage.sidebarState = 'hide';
                        },
                        uncollapseSidebar() {
                            this.sidebarCollapsed = false
                            localStorage.sidebarState = 'show';
                        },
                        notification_show: false,
                        notification_success: false,
                        notification_content: '-',
                        openNotification(content, success = true) {
                            this.notification_content = content
                            this.notification_success = success
                            this.notification_show = true
                            setTimeout(() => {
                                this.closeNotification()
                            }, 5000)
                        },
                        closeNotification() {
                            this.notification_show = false
                        },
                        toggleDarkMode() {
                            document.documentElement.classList.toggle('dark');
                            localStorage.dark = !JSON.parse(localStorage.dark);
                        },
                        initMode(defaultMode = 'dark') {
                            if (localStorage.getItem('dark')) {
                                if(localStorage.dark === 'true') {
                                    document.documentElement.classList.add('dark');
                                    localStorage.dark = true;
                                    return;
                                }
                                document.documentElement.classList.remove('dark');
                                localStorage.dark = false;
                                return;
                            }
                            localStorage.dark = defaultMode === 'dark';
                            if(defaultMode !== 'dark') {
                                document.documentElement.classList.remove('dark');
                            }
                        },
                        initSidebar(defaultState = 'show') {
                            if (localStorage.getItem('sidebarState')) {
                                if(localStorage.sidebarState === 'show') {
                                    this.uncollapseSidebar();
                                    return;
                                }
                                this.collapseSidebar();
                                return;
                            }
                            localStorage.sidebarState = 'show';
                            if(defaultState !== 'show') {
                                this.collapseSidebar();
                            }
                        },
                        initSetup(defaultMode = 'dark', defaultState = 'show') {
                            this.initMode(defaultMode);
                            this.initSidebar(defaultState);
                        }
                    }"
            x-init="initSetup()"
            @keydown.shift.left.document="collapseSidebar()"
            @keydown.shift.right.document="uncollapseSidebar()"
            x-on:collapse-sidebar="collapseSidebar()"
            x-on:uncollapse-sidebar="uncollapseSidebar()"
            x-on:open-notification="openNotification($event.detail.content)"
            x-on:close-notification="closeNotification()"
            x-on:toggle-dark-mode="toggleDarkMode()"
            >
            @auth
                <x-user.mobile-sidebar></x-user.mobile-sidebar>
                <x-user.desktop-sidebar></x-user.desktop-sidebar>
            @endauth
            <div
                class="w-full flex flex-col flex-1"
                @auth
                    x-bind:class="sidebarCollapsed ? 'md:pl-20' : 'md:pl-64'"
                @else
                    :class="'md:pl-0'"
                @endauth
                >
                @auth
                    <x-user.top-bar></x-user.top-bar>
                @endauth
                <main>
                    <div>
                        @auth
                            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                                {{ $header }}
                            </div>
                        @endauth
                        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                            {{ $slot }}
                        </div>
                    </div>
                </main>
            </div>
            <x-notifications></x-notifications>
            @if (session('flash-notification'))
                <div
                    x-cloak
                    x-init="$dispatch('open-notification', {content: '{{ session('flash-notification') }}' } )">
                </div>
            @endif
            <div class="absolute top-0 right-24 z-10">
                <x-theme-switcher helper_icons="true"></x-theme-switcher>
            </div>
        </div>
        <x-footer></x-footer>
    </body>
</html>
