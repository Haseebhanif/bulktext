<x-jet-form-section key="smtp" submit="{{$saveTo}}">
    <x-slot name="title">
        {{ __('Email Settings') }}
    </x-slot>

    <x-slot name="description">
       Send emails though your own SMTP server
    </x-slot>

    <x-slot name="form">


        <!-- Name -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="name" value="{{ __('Sender Name') }}" />
            <x-jet-input id="name"  type="text" class="mt-1 block w-full" wire:model.defer="name" />
            <x-jet-input-error for="name" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="smtp" value="{{ __('Server Address') }}" />
            <x-jet-input id="smtp"  type="text" class="mt-1 block w-full" wire:model.defer="smtp" />
            <x-jet-input-error for="smtp" class="mt-2" />
        </div>

        <!-- Email -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="email" value="Sender Email" />
            <x-jet-input id="email" type="email" class="mt-1 block w-full" wire:model.defer="email" />
            <x-jet-input-error for="email" class="mt-2" />

        </div>
        <!-- user name -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="username" value="{{ __('SMTP Username') }}" />
            <x-jet-input id="username"  type="text" class="mt-1 block w-full" wire:model.defer="username" autocomplete="nope"/>
            <x-jet-input-error for="username" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="password" value="{{ __('SMTP password') }}" />
            <x-jet-input id="password"  type="password" class="mt-1 block w-full" wire:model.defer="password" autocomplete="nope" />
            <x-jet-input-error for="password" class="mt-2" />
        </div>


        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="port" value="Port" />
            <x-jet-input id="port" type="text" class="mt-1 block w-full" wire:model.defer="port" />
            <x-jet-input-error for="port" class="mt-2" />

        </div>
        <!-- vat -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="encryption" value="Encryption" />
            <x-jet-input id="encryption"  type="text" class="mt-1 block w-full" wire:model.defer="encryption" />
            <x-jet-input-error for="encryption" class="mt-2" />
        </div>

    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3" on="saved">
            {{ __('Saved.') }}
        </x-jet-action-message>

        <x-jet-button wire:loading.attr="disabled" wire:target="photo">
            {{ __('Save') }}
        </x-jet-button>
    </x-slot>


</x-jet-form-section>

