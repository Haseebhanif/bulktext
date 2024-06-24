<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="apple-touch-icon" sizes="180x180" href="/favicon/{{$domain}}/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/favicon/{{$domain}}/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/favicon/{{$domain}}/favicon-16x16.png">
        <link rel="manifest" href="/site.webmanifest">

        <title>{{$branding->tenant_name}}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Scripts -->
        {{--        @vite(['resources/css/app.css', 'resources/js/app.js'])--}}


         <script src="{{asset('build/assets/app.75d812f2.js')}}" defer></script>

        @vite(['resources/css/app.css'])
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

    <div>
        <livewire:navigation-menu key="nav"/>
    </div>

{{--          @livewire('navigation-menu')--}}


        <div class="flex overflow-y-auto pt-16 bg-gray-50 dark:bg-gray-900">

            <aside  class="flex hidden md:block fixed top-0 left-0 z-20 flex-col flex-shrink-0 pt-16 w-18 h-full bg-dbfb2 duration-75 lg:flex transition-width" aria-label="Sidebar">
                <div class="flex relative flex-col flex-1 pt-0 min-h-0 bg-black border-r border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                    <div class="flex overflow-y-auto flex-col flex-1 pt-5 pb-4">
                        <div class="flex-1 px-2 space-y-1 bg-black divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                            <ul class="pb-2 space-y-2">

                                <li class="mt-4" >
                                    <a   href="{{$isTLD ? route($prefix.'.dashboard',['domain' =>$domain]) :   route('dashboard',['domain' =>$domain])}}" class="tooltip flex flex-col items-center p-2 text-base font-normal text-gray-900 rounded-lg hover:bg-gray-100 group dark:text-gray-200 dark:hover:bg-gray-700">
                                        <svg class="w-6 h-6 text-white transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path><path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path></svg>
                                        <span class="mx-auto text-xs text-white group-hover:text-gray-900"  >Dashboard</span>
                                    </a>

                                </li>




{{--                                <li>--}}

{{--                                    <a   href="{{route('contacts',['domain' =>$domain])}}" class="flex flex-col items-center p-2 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700" aria-controls="dropdown-users" >--}}
{{--                                        <svg class="flex-shrink-0 w-6 h-6 text-white transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path></svg>--}}
{{--                                        <span class="mx-auto text-xs text-white group-hover:text-gray-900">Contacts</span>--}}
{{--                                     </a>--}}
{{--                                </li>--}}
                                <li>
                                    <a href="{{$isTLD ? route($prefix.'.groups',['domain' =>$domain]) : route('groups',['domain' =>$domain])}}" type="button" class="flex flex-col items-center p-2 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700" aria-controls="dropdown-users" >
{{--                                    <svg class="flex-shrink-0 w-6 h-6 text-white transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"></path></svg>--}}
{{--                                   --}}
                                     <svg class="flex-shrink-0 w-6 h-6 text-white transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path></svg>

                                        <span class="mx-auto text-xs text-white group-hover:text-gray-900">Contacts </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{$isTLD ? route($prefix.'.message.templates',['domain' =>$domain]) : route('message.templates',['domain' =>$domain])}}" type="button" class="flex flex-col items-center p-2 w-full text-base font-normal  rounded-lg transition duration-75 group hover:bg-gray-100 text-white hover:text-gray-600 dark:text-gray-200 dark:hover:bg-gray-700" aria-controls="dropdown-pages">

                                        <svg class="w-6 h-6 text-white transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white"  fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                                        <span class="mx-auto text-xs text-white group-hover:text-gray-900">Templates</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{$isTLD ? route($prefix.'.message',['domain' =>$domain]) : route('message',['domain' =>$domain])}}"  class="flex flex-col items-center p-2 text-base font-normal text-gray-900 rounded-lg hover:bg-gray-100 group dark:text-gray-200 dark:hover:bg-gray-700 ">
                                        <svg class="w-6 h-6 text-white transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" /></svg>
                                        <span class="mx-auto text-xs text-white group-hover:text-gray-900">SMS</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{$isTLD ? route($prefix.'.campaigns',['domain' =>$domain]) : route('campaigns',['domain' =>$domain])}}"  class="flex flex-col items-center p-2 text-base font-normal text-gray-900 rounded-lg hover:bg-gray-100 group dark:text-gray-200 dark:hover:bg-gray-700 ">
                                        <svg class="flex-shrink-0 w-6 h-6 text-white transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                                        <span class="mx-auto text-xs text-white group-hover:text-gray-900">Campaigns</span>
                                    </a>
                                </li>
                            </ul>
                            @if(Auth::user()->is_portal)
                                <ul class="pb-2 pt-2 space-y-2">
                                    <li>
                                        <a href="{{$isTLD ? route($prefix.'.manage.companies',['domain' =>$domain]) : route('manage.companies',['domain' =>$domain])}}"  class="flex flex-col items-center p-2 text-base font-normal text-gray-900 rounded-lg hover:bg-gray-100 group dark:text-gray-200 dark:hover:bg-gray-700 ">
                                            <svg class="flex-shrink-0 w-6 h-6 text-white transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <span class="mx-auto text-xs text-white group-hover:text-gray-900">Management</span>
                                        </a>
                                    </li>
                                </ul>

                                @endif
                        </div>
                    </div>
                    <div class="hidden absolute bottom-0 left-0 justify-center p-4 space-x-4 w-full lg:flex" sidebar-bottom-menu>
                        @if(Auth::user()->is_global)
                            <div class="pt-2 space-y-2">
                        <a href="{{route('portal.management',['domain' =>$domain])}}" data-tooltip-target="tooltip-settings" class="inline-flex justify-center p-2 text-white rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-white">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"></path></svg>

                        <div id="tooltip-settings" role="tooltip" class="inline-block absolute invisible z-10 py-2 px-3 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm opacity-0 transition-opacity duration-300 tooltip dark:bg-gray-700">
                            Global Admin
                            <div class="tooltip-arrow" data-popper-arrow></div>
                        </div>
                        </a>
                            </div>
                        @endif
                    </div>
                </div>
            </aside>

        </div>

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
          <p class="mt-10 text-sm text-center text-gray-500">&copy; {{\Carbon\Carbon::now()->format('Y')}} <span class="capitalize">{{$branding->company_name ?? $branding->tenant_name}}</span>. All rights reserved.</p>


            @if($branding->address1)
                <p class="my-1 text-sm text-center text-gray-500"> <span class="">Contact: {{$branding->support_email ?? ''}} Contact No: {{$branding->company_phone ?? ''}} Address: {{$branding->address1}}</span></p>
            @endif

          @stack('js')


          <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
          <x-livewire-alert::scripts />

          @livewireScripts
          @livewireChartsScripts

          <script src="https://unpkg.com/flowbite@1.5.3/dist/flowbite.js"></script>
          <script src="https://unpkg.com/flowbite@1.5.4/dist/datepicker.js"></script>
    </body>
</html>
