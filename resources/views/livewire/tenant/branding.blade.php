<div>
    <div class="py-4">
        <div class="md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1 flex justify-between">
                <div class="px-4 sm:px-0">
                    <h3 class="text-lg font-medium text-gray-900">Portal Branding</h3>

                    <p class="mt-1 text-sm text-gray-600">
                        Brand application backgrounds,logo,login & register page images.
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
                                <label class="block font-medium text-sm text-gray-700 sr-only">
                                    Logo
                                </label>

                                <div class="flex items-center justify-between mt-2">
                                    @if($this->tenant->logo)
                                    <img class=" h-12 " src="/{{ $this->tenant->logo }}" alt="">
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



    <div class="py-4">
        <div class="md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1 flex justify-between">
                <div class="px-4 sm:px-0">
                    <h3 class="text-lg font-medium text-gray-900">Registration & Login Screen</h3>

                    <p class="mt-1 text-sm text-gray-600">
                       Changes application registration & login background colour.
                    </p>
                </div>

                <div class="px-4 sm:px-0">

                </div>
            </div>

            <div class="mt-5 md:mt-0 md:col-span-2">
                <form wire:submit.prevent="saveColor">
                    <div class="px-4 py-5 bg-white sm:p-6 shadow sm:rounded-tl-md sm:rounded-tr-md">
                        <div class="grid grid-cols-6 gap-6">
                            <!-- Team Owner Information -->
                            <div class="col-span-6">
                                <label class="block font-medium text-sm text-gray-700">
                                    Background Colour
                                </label>

                                <div class="flex items-center justify-between mt-2">
                                    <div>
                                        <div>
                                            <input type="color" id="body" wire:model.defer="color" class="h-16 w-16" name="body" value="#f6b73c">
                                        </div>
                                        @error('color') <span class="error">{{ $message }}</span> @enderror

                                    </div>
                                    <button class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition" type="submit">Save</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>





    <div class="py-4">
        <div class="md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1 flex justify-between">
                <div class="px-4 sm:px-0">
                    <h3 class="text-lg font-medium text-gray-900">Registration & Login Screen Text </h3>

                    <p class="mt-1 text-sm text-gray-600">
                        Changes application registration & login Header and intro text.
                    </p>
                </div>

                <div class="px-4 sm:px-0">

                </div>
            </div>

            <div class="mt-5 md:mt-0 md:col-span-2">
                <form wire:submit.prevent="saveText">
                    <div class="px-4 py-5 bg-white sm:p-6 shadow sm:rounded-tl-md sm:rounded-tr-md">
                        <div class="grid grid-cols-6 gap-6">
                            <!-- Team Owner Information -->
                            <div class="col-span-6">
                                <label class="block font-medium text-sm text-gray-700">
                                    Header
                                </label>

                                <div class="flex items-center justify-between mt-2">
                                    <input type="text"  id="header" wire:model.defer="header" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">


                                </div>

                                @error('header') <span class="error">{{ $message }}</span> @enderror

                                    </div>
                            <div class="col-span-6">
                                <label class="block font-medium text-sm text-gray-700">
                                    Body Text
                                </label>

                                <div class="flex items-center justify-between mt-2">
                                    <textarea  id="body" wire:model.defer="body"class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    </textarea>
                                        </div>

                                @error('header') <span class="error">{{ $message }}</span> @enderror

                            </div>


                            <div class="col-span-6">
                                <label class="block font-medium text-sm text-gray-700">
                                    Text colour
                                </label>

                                <div class="flex items-center justify-between mt-2">
                                     <div>
                                <div>
                                    <input type="color" id="textColor" wire:model.defer="textColor" class="h-16 w-16" name="headerColor" value="#f6b73c">
                                </div>
                                @error('textColor') <span class="error">{{ $message }}</span> @enderror

                            </div>
                                </div>
                            </div>
                                </div>
                        <div class="flex items-center justify-between mt-2">
                            <div></div>
                         <button class="inline-flex items-center  px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition" type="submit">Save</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
    <div class="hidden sm:block">
        <div class="py-8">
            <div class="border-t border-gray-200"></div>
        </div>
    </div>
    <div class="py-4">
        <div class="md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1 flex justify-between">
                <div class="px-4 sm:px-0">
                    <h3 class="text-lg font-medium text-gray-900">API Access</h3>

                    <p class="mt-1 text-sm text-gray-600">
                        Display access to generate API Tokens from the user profile menu.
                    </p>
                </div>

                <div class="px-4 sm:px-0">

                </div>
            </div>

            <div class="mt-5 md:mt-0 md:col-span-2">
                <form wire:submit.prevent="saveApiAccess">
                    <div class="px-4 py-5 bg-white sm:p-6 shadow sm:rounded-tl-md sm:rounded-tr-md">
                        <div class="grid grid-cols-6 gap-6">
                            <!-- Team Owner Information -->
                            <div class="col-span-6">
                                <div class="flex items-center justify-between mt-2">
                                    <div class="flex flex-row items-center justify-content-start space-x-2 ">

                                        <div class="mx-4">
                                            <label>Show</label>
                                            <input type="radio" wire:model="apiAccess" class="h-16 w-16" name="api" value="true">
                                        </div>
                                        <div class="mx-4">
                                            <label>Hide</label>
                                            <input type="radio" wire:model="apiAccess" class="h-16 w-16" name="api" value="false">
                                        </div>

                                        @error('apiAccess') <span class="error">{{ $message }}</span> @enderror

                                    </div>
                                    <button class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition" type="submit">Save</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="py-4">

        <livewire:company.email-settings/>

    </div>

</div>
