<div>
    <nav x-data="{ open: false }"  class="fixed z-50 w-full bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
        <div class="py-3 px-3 lg:px-5 lg:pl-3">
            <div class="flex justify-between items-center">
                <div class="flex justify-start items-center">
                    <button id="toggleSidebar" aria-expanded="false" aria-controls="sidebar"
                            class="hidden p-2 mr-3 text-gray-600 rounded cursor-pointer lg:inline hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-700">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                  d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                                  clip-rule="evenodd"/>
                        </svg>
                    </button>
                    <button id="toggleSidebarMobile" aria-expanded="false" aria-controls="sidebar"
                            class="p-2 mr-2 text-gray-600 rounded cursor-pointer lg:hidden hover:text-gray-900 hover:bg-gray-100 focus:bg-gray-100 dark:focus:bg-gray-700 focus:ring-2 focus:ring-gray-100 dark:focus:ring-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                        <svg id="toggleSidebarMobileHamburger" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                             xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                  d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                                  clip-rule="evenodd"/>
                        </svg>
                        <svg id="toggleSidebarMobileClose" class="hidden w-6 h-6" fill="currentColor"
                             viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                  d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                  clip-rule="evenodd"/>
                        </svg>
                    </button>
                    <!-- Logo -->

                    @if(request()->segment(1) =='manage')
                        <span class="text-xl font-bold mx-2">Portal Admin</span>

                    @elseif(request()->segment(1) =='tenant')
                        <span class="text-xl font-bold mx-2">Tenants Admin</span>
                    @else
                        @if(!Auth::user()->currentTeam->company->tenantParent)
                            <span class="text-xl font-bold mx-2 capitalize">
                             {{  Auth::user()->currentTeam->company->company_name }} : {{Auth::user()->currentTeam->name}}
                            </span>
                        @endif

    {{--                    <a href="{{ route('dashboard',['domain' => $domain]) }}">--}}
                         <a href="#">
                            <x-jet-application-mark class="block h-9 w-auto mx-4" />
                        </a>
                    @endif

                    </div>


                <div class="flex items-center">

                    @if(request()->segment(1) !=='manage')
                        <div>
                            <livewire:credits key="credits"/>
                        </div>
                    @endif



                    <button type="button" data-dropdown-toggle="apps-dropdown"
                            class="p-2 text-gray-500 rounded-lg hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-700">
                        <span class="sr-only">View notifications</span>

                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>

                        </svg>
                    </button>


                    <div class="hidden overflow-hidden z-20 z-50 my-4 max-w-sm text-base list-none bg-white rounded divide-y divide-gray-100 shadow-lg dark:bg-gray-700 dark:divide-gray-600"
                         id="apps-dropdown">
                        <div class="block py-2 px-4 text-base font-medium text-center text-gray-700 bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            Management Tools
                        </div>
                        <div class="grid grid-cols-3 gap-4 p-4">
    {{--                        <a href="{{route('contacts',['domain' => $domain])}}"--}}
    {{--                           class="block p-4 text-center rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600">--}}
    {{--                            <svg class="mx-auto mb-1 w-7 h-7 text-gray-500 dark:text-gray-400" fill="currentColor"--}}
    {{--                                 viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">--}}
    {{--                                <path--}}
    {{--                                        d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z">--}}
    {{--                                </path>--}}
    {{--                            </svg>--}}
    {{--                            <div class="text-sm font-medium text-gray-900 dark:text-white">Contacts</div>--}}
    {{--                        </a>--}}

                            <a href="{{$isTLD ? route($prefix.'.groups',['domain' => $domain]) :route('groups',['domain' => $domain])}}"
                               class="block p-4 text-center rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600">
                                <svg class="mx-auto mb-1 w-7 h-7 text-gray-500 dark:text-gray-400" fill="currentColor"
                                     viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z">
                                    </path>
                                </svg>
                                <div class="text-sm font-medium text-gray-900 dark:text-white">Contacts</div>
                            </a>

                            <a href="{{$isTLD ? route($prefix.'.message.templates',['domain' => $domain]) :route('message.templates',['domain' => $domain])}}"
                               class="block p-4 text-center rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600">
                                <svg class="mx-auto mb-1 w-7 h-7 text-gray-500 dark:text-gray-400" fill="currentColor"
                                     viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                                </svg>
                                <div class="text-sm font-medium text-gray-900 dark:text-white">Templates</div>
                            </a>

                            <a href="{{$isTLD ? route($prefix.'.message',[$domain]) :route('message',['domain' => $domain])}}"
                               class="block p-4 text-center rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600">
                                <svg class="mx-auto mb-1 w-7 h-7 text-gray-500 dark:text-gray-400" fill="currentColor"
                                     viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path strokelinecap="round" strokelinejoin="round" strokewidth="{2}" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                                </svg>
                                <div class="text-sm font-medium text-gray-900 dark:text-white">SMS</div>
                            </a>

                            <a href="{{$isTLD ? route($prefix.'.campaigns',['domain' => $domain]) :route('campaigns',['domain' => $domain])}}"
                               class="block p-4 text-center rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600">
                                <svg class="mx-auto mb-1 w-7 h-7 text-gray-500 dark:text-gray-400" fill="currentColor"
                                     viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>  </svg>
                                <div class="text-sm font-medium text-gray-900 dark:text-white">Campaigns</div>
                            </a>
                            <a href="{{$isTLD ? route($prefix.'.credits',['domain' => $domain]) :route('credits',['domain' => $domain])}}"
                               class="block p-4 text-center rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600">

                                <svg class="mx-auto mb-1 w-7 h-7 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 9a2 2 0 10-4 0v5a2 2 0 01-2 2h6m-6-4h4m8 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <div class="text-sm font-medium text-gray-900 dark:text-white">Credits</div>
                            </a>
                            <a href="{{$isTLD ? route($prefix.'.invoices',['domain' => $domain]) :route('invoices',session('domain'))}}"
                               class="block p-4 text-center rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600">
                                <svg class="mx-auto mb-1 w-7 h-7 text-gray-500 dark:text-gray-400" fill="currentColor"
                                     viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                          d="M5 2a2 2 0 00-2 2v14l3.5-2 3.5 2 3.5-2 3.5 2V4a2 2 0 00-2-2H5zm2.5 3a1.5 1.5 0 100 3 1.5 1.5 0 000-3zm6.207.293a1 1 0 00-1.414 0l-6 6a1 1 0 101.414 1.414l6-6a1 1 0 000-1.414zM12.5 10a1.5 1.5 0 100 3 1.5 1.5 0 000-3z"
                                          clip-rule="evenodd"/>
                                </svg>
                                <div class="text-sm font-medium text-gray-900 dark:text-white">Invoicing</div>
                            </a>

                            <a href="{{route('profile.show')}}"
                               class="block p-4 text-center rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600">
                                <svg class="mx-auto mb-1 w-7 h-7 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                <div class="text-sm font-medium text-gray-900 dark:text-white">Profile</div>
                            </a>


                        </div>
                    </div>



                    <div class="flex justify-between h-16">


                        <div class="hidden sm:flex sm:items-center sm:ml-6">
                            @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                                <div class="ml-3 relative">
                                    <x-jet-dropdown align="right" width="60">
                                        <x-slot name="trigger">
                                  <div class="inline-flex rounded-md">
                                      <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:bg-gray-50 hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition">

                                          {{Auth::user()->currentTeam->name}}

                                          <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                              <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                                          </svg>
                                      </button>

                                  </div>
                                        </x-slot>

                                        <x-slot name="content">
                                            <div class="w-60">
                                                <!-- Team Management -->
                                                <div class="block px-4 py-2 text-xs text-gray-400">
                                                    {{ __('Manage Department') }}
                                                </div>

                                                <!-- Team Settings -->
                                                <x-jet-dropdown-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}">
                                                    {{ __('Department Settings') }}
                                                </x-jet-dropdown-link>

                                                @if(strtoupper(Auth::user()->currentTeam->name) !='GLOBAL ADMIN')
                                                    @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                                                        <x-jet-dropdown-link href="{{ route('teams.create') }}">
                                                            {{ __('Create New Department') }}
                                                        </x-jet-dropdown-link>
                                                    @endcan

                                                    @if(isset(Auth::user()->currentTeam->company) and Auth::user()->id ==  Auth::user()->currentTeam->company->creator_id)
                                                        @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                                                            <x-jet-dropdown-link href="{{$isTLD ? route($prefix.'.company.details',$domain) : route('company.details',$domain) }}">
                                                                {{ __('Company Details') }}
                                                            </x-jet-dropdown-link>
                                                        @endcan
                                                    @endif


                                                    {{--                        @can('create', Laravel\Jetstream\Jetstream::newTeamModel())--}}
                                                    {{--                            <x-jet-dropdown-link href="{{ route('teams.create') }}">--}}
                                                    {{--                                {{ __('Company Credits') }}--}}
                                                    {{--                            </x-jet-dropdown-link>--}}
                                                    {{--                        @endcan--}}
                                                @endif

                                                <div class="border-t border-gray-100"></div>

                                                <!-- Team Switcher -->
                                                <div class="block px-4 py-2 text-xs text-gray-400">
                                                    {{ __('Switch Department') }}
                                                </div>

                                                @foreach (Auth::user()->allTeams() as $team)
                                                    <x-jet-switchable-team :team="$team" />
                                                @endforeach
                                            </div>
                                        </x-slot>
                                    </x-jet-dropdown>
                                </div>
                            @endif

                            @if(is_impersonating())

                                <a href="{{$isTLD ? route($prefix.'.portal.company.manage.leave',[$domain]) :route('portal.company.manage.leave',[$domain])}}" class="bg-dbfb2 text-white p-2 rounded">Back to portal</a>
                            @else

                            <!-- Settings Dropdown -->

                                <div class="ml-3 relative">
                                    <x-jet-dropdown align="right" width="48">
                                        <x-slot name="trigger">
                                            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                                <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                                    <img class="h-8 w-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                                </button>
                                            @else
                                                <span class="inline-flex rounded-md">
                                                      <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition">
                                                          {{ Auth::user()->name }}

                                                          <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                              <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                          </svg>
                                                      </button>
                                                  </span>
                                            @endif
                                        </x-slot>

                                        <x-slot name="content">
                                            <!-- Account Management -->
                                            <div class="block px-4 py-2 text-xs text-gray-400">
                                                {{ __('Manage Account') }}
                                            </div>

                                            <x-jet-dropdown-link href="{{ route('profile.show') }}">
                                                {{ __('Profile') }}
                                            </x-jet-dropdown-link>

                                            <x-jet-dropdown-link target="_blank" href="https://scribehow.com/page/Bulk_Text_Service__Self_Help_Guide__1CZqgWdHRhuTOC5jn47NCA">
                                                {{ __('Help') }}
                                            </x-jet-dropdown-link>

                                            @if (Laravel\Jetstream\Jetstream::hasApiFeatures() && $branding->API_access)
                                                <x-jet-dropdown-link href="{{ route('api-tokens.index') }}">
                                                    {{ __('API Tokens') }}
                                                </x-jet-dropdown-link>
                                            @endif

                                            <div class="border-t border-gray-100"></div>

                                            <!-- Authentication -->
                                            <form method="POST" action="{{ route('logout') }}" x-data>
                                                @csrf

                                                <x-jet-dropdown-link href="{{ route('logout') }}"
                                                                     @click.prevent="$root.submit();">
                                                    {{ __('Log Out') }}
                                                </x-jet-dropdown-link>
                                            </form>
                                        </x-slot>
                                    </x-jet-dropdown>
                                </div>

                            @endif

                      </div>

                      <!-- Hamburger -->
                      <div class="-mr-2 flex items-center sm:hidden">
                          <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition">
                              <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                  <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                  <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                              </svg>
                          </button>
                      </div>

                  </div>

              </div>
          </div>
      </div>
    </nav>
</div>
