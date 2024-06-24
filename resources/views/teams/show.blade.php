<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Department Settings') }}
        </h2>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto py-5 sm:px-6 lg:px-8">
            @if(strtoupper(Auth::user()->currentTeam->name) !='GLOBAL ADMIN')
                <div class="py-4">
                    @livewire('teams.update-team-name-form', ['team' => $team])
                </div>

            @endif
                <div class="py-4">
            @livewire('teams.team-member-manager', ['team' => $team])
                </div>
            @if (Gate::check('delete', $team) && ! $team->personal_team)
                <x-jet-section-border />

                    <div class="mt-10 sm:mt-0">

                    @if(strtoupper(Auth::user()->currentTeam->name) !='GLOBAL ADMIN')

                        @livewire('teams.delete-team-form', ['team' => $team])

                        @endif
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
