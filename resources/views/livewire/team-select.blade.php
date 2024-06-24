<!-- Teams Dropdown -->
@if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
    <div class="ml-3 relative">
        <x-jet-dropdown align="right" width="60">
            <x-slot name="trigger">
                              <span class="inline-flex rounded-md">
                                  <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:bg-gray-50 hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition">

                                      {!!  strip_tags(Auth::user()->currentTeam->name)!!}

                                      <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                          <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                                      </svg>
                                  </button>
                              </span>
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

                                 @if(Auth::user()->id ==  Auth::user()->currentTeam->company->creator_id)
                                        @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                                            <x-jet-dropdown-link href="{{ route('company.details',$domain) }}">
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

