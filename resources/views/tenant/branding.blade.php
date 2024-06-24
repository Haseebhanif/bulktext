<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Portal Branding') }}
        </h2>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto py-5 sm:px-6 lg:px-8">
            @if(strtoupper(Auth::user()->currentTeam->name) !='GLOBAL ADMIN' && Auth::user()->is_portal == true)
                <div class="py-4">
                    @livewire('tenant.branding', ['tenantId' => $tenant->id])
                    @livewire('tenant.details', ['tenant' => $tenant])
                </div>
            @endif


        </div>
    </div>
</x-app-layout>
