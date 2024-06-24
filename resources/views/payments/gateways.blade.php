<x-app-layout>

    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Credits & Payments') }}
            </h2>
        </div>

    </x-slot>

    <main>


                <livewire:payments.stripe-gateway/>





    </main>

</x-app-layout>
