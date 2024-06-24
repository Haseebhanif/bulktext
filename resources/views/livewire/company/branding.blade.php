<div>
    <div class="py-4">
        <div class="md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1 flex justify-between">
                <div class="px-4 sm:px-0">
                    <h3 class="text-lg font-medium text-gray-900">Company Branding</h3>

                    <p class="mt-1 text-sm text-gray-600">
                        Brand application backgrounds , logo , login & register page images.
                    </p>
                </div>

                <div class="px-4 sm:px-0">

                </div>
            </div>

            <div class="mt-5 md:mt-0 md:col-span-2">
                <form wire:submit.prevent="save">
                    <div class="px-4 py-5 bg-white sm:p-6 shadow sm:rounded-tl-md sm:rounded-tr-md">
                        <div class="grid grid-cols-6 gap-6">
                            <!-- Team Owner Information -->
                            <div class="col-span-6 " wire:click="$set('type','logo')">
                                <label class="block font-medium text-sm text-gray-700">
                                    Logo
                                </label>

                                <div class="flex items-center justify-between mt-2">
                                    @if ($image)
                                        <img class=" h-12 "  src="{{ $image->temporaryUrl() }}" alt="temp">
                                        @else
                                        <img class=" h-12 " src="/{{ $this->company->logo ?? 'nologo.jpg'}}" alt="img">
                                    @endif


                                    <div>
                                        <input type="file" wire:model="image" placeholder="Change Image" value="Change Image">

                                        @error('image') <span class="error">{{ $message }}</span> @enderror


                                        <button class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition" type="submit">Save Logo</button>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
