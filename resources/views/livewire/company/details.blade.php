<x-jet-form-section key="contact" submit="{{$saveTo}}">
    <x-slot name="title">
        {{ __('Company Information') }}
    </x-slot>

    <x-slot name="description">
      This information will show on invoices.
    </x-slot>

    <x-slot name="form">


    <!-- Name -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="name" value="{{ __('Company Name') }}" />
            <x-jet-input id="name"  type="text" class="mt-1 block w-full" wire:model.defer="tenant.company_name" />
            <x-jet-input-error for="name" class="mt-2" />
        </div>

        <!-- Email -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="email" value="Invoice Email" />
            <x-jet-input id="email" type="email" class="mt-1 block w-full" wire:model.defer="tenant.company_email" />
            <x-jet-input-error for="email" class="mt-2" />

       </div>
        <!-- Email -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="support_email" value="Support Email" />
            <x-jet-input id="support_email" type="email" class="mt-1 block w-full" wire:model.defer="tenant.support_email" />
            <x-jet-input-error for="email" class="mt-2" />

        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="name" value="{{ __('Contact Number') }}" />
            <x-jet-input id="name"  type="text" class="mt-1 block w-full" wire:model.defer="tenant.company_phone" />
            <x-jet-input-error for="name" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="address" value="Address" />
            <textarea id="address" class="mt-1 block w-full" wire:model.defer="tenant.address1" ></textarea>
            <x-jet-input-error for="email" class="mt-2" />

        </div>
        <!-- vat -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="name" value="{{ __('VAT Number') }}" />
            <x-jet-input id="name"  type="text" class="mt-1 block w-full" wire:model.defer="tenant.company_vat" />
            <x-jet-input-error for="name" class="mt-2" />
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
