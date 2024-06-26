<x-app-layout>


        @if (session()->has('message'))
        <div x-data="{banner:true}">
            <div class="relative bg-green-600" x-cloak x-show="banner">
                <div class="mx-auto max-w-7xl py-3 px-3 sm:px-6 lg:px-8">
                    <div class="pr-16 sm:px-16 sm:text-center">
                        <p class="font-medium text-white">
                            <span class="md:hidden">{{ session('message') }}</span>
                            <span class="hidden md:inline">{{ session('message') }}</span>
                        </p>
                    </div>
                    <div class="absolute inset-y-0 right-0 flex items-start pt-1 pr-1 sm:items-start sm:pt-1 sm:pr-2">
                        <button @click="banner = false" type="button" class="flex rounded-md p-2 hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-white">
                            <span class="sr-only">Dismiss</span>
                            <!-- Heroicon name: outline/x-mark -->
                            <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

        </div>

        @endif

             <main>

        <livewire:campaign.campaign-table/>


             </main>

    @push('js')

        @endpush

</x-app-layout>
