<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
        <link rel="manifest" href="/site.webmanifest">
        <title>@yield('title')</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Scripts -->
{{--        @vite(['resources/css/app.css', 'resources/js/app.js'])--}}
{{--        <link rel="stylesheet" href="{{asset('build/assets/app.d13f56e3.css')}}" />--}}
{{--        <script src="{{asset('build/assets/app.75d812f2.js')}}" defer></script>--}}
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link rel="stylesheet" href="https://unpkg.com/flowbite@1.5.3/dist/flowbite.min.css" />
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/pikaday/css/pikaday.css">

        <!-- Styles -->
        @livewireStyles
        @stack('css')

        <script>

            if (localStorage.getItem('color-theme') === 'dark' || (('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark')
            }
        </script>
    </head>

    <body class="font-sans antialiased bg-gray-50 dark:bg-gray-800" >



            <div id="main-content" class="overflow-y-auto relative w-full h-full bg-gray-50    dark:bg-gray-900">
                <main class="items-center sm:ml-0 md:ml-24 lg:ml-24">


        <div class="min-h-screen bg-gray-100">


            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-9xl mx-auto py-6 px-4 sm:px-6 lg:px-8 mt-5">
                        {{ $header }}
                    </div>
                </header>
            @endif
            <x-jet-banner />
            <!-- Page Content -->

                {{ $slot }}

        </div>
        @stack('modals')
                </main>
            </div>
          <p class="my-10 text-sm text-center text-gray-500">&copy; 2022-2023 <a href="#" class="hover:underline capitalize">{{$branding->tenant_name}}</a>. All rights reserved.</p>


          @stack('js')


          <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
          <x-livewire-alert::scripts />

          @livewireScripts
          @livewireChartsScripts

          <script src="https://unpkg.com/flowbite@1.5.3/dist/flowbite.js"></script>
          <script src="https://unpkg.com/flowbite@1.5.4/dist/datepicker.js"></script>
    </body>
</html>
