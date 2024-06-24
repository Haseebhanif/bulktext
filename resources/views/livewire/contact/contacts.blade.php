<div x-data="{group:false,open:false, edit: @entangle('edit')}">

    @if($header)
    <x-slot name="header">

        <div class="flex w-full pl-3 sm:pl-6 pr-3 py-0 items-center justify-between  rounded-t">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('All Contacts') }}
            </h2>
            <button id="updateUserButton"  onclick="openNav()"  class="ml-0 sm:ml-6 bg-dbfb2 transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-dbfb1 hover:bg-dbfb1 rounded text-white px-5 h-8 flex items-center text-sm" >Create Contact</button>
        </div>
    </x-slot>
    @endif

    <div class="container mx-auto my-3">

        <div x-show="open" class="bg-white p-4" x-cloak>

            <livewire:contact.import-form  :selectedGroup="$moveGroupSelected" :key="12"/>

        </div>

        <dl class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-3">
            <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
                <dt class="truncate text-sm font-medium text-gray-500">Total Contacts</dt>
                <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">{{$contacts->total()}}</dd>
                <span class="text-sm">All contacts including opt outs</span>
            </div>

            <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
                <dt class="truncate text-sm font-medium text-gray-500">Contact Optouts</dt>
                <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">{{$optouts}}</dd>
                <span class="text-sm">All opted out contacts</span>
            </div>


        </dl>


    </div>



    <div class="mx-auto container bg-white dark:bg-gray-800 shadow rounded my-6">

        <div class="flex flex-col md:flex-row p-3 justify-between items-start md:items-stretch w-full">
            <div class="w-full md:w-1/3 flex flex-col md:flex-row items-start md:items-center">
                <div class="flex items-center">
                    <button data-tooltip-target="tooltip-delete" type="button"  wire:click="removeContacts" class="focus:ring-2 focus:ring-offset-2 focus:ring-indigo-700 p-2 border-gray-200 text-gray-600 dark:text-gray-400 border rounded focus:outline-none focus:border-gray-800 focus:shadow-outline-gray" aria-label="Delete table" role="button">
                        <svg class="w-5 text-gray-500 " fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"></path>
                        </svg>
                    </button>
                    <div id="tooltip-delete" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                        Delete Selected Contacts
                        <div class="tooltip-arrow" data-popper-arrow></div>
                    </div>

                    <button data-tooltip-target="tooltip-group" type="button"  @click="group = true" class=" mx-1 focus:ring-2 focus:ring-offset-2 focus:ring-indigo-700 text-gray-600 p-2  border-gray-200 dark:text-gray-400 border rounded focus:outline-none focus:border-gray-800 focus:shadow-outline-gray" aria-label="upload Table" role="button">
                        <svg class="text-white h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><!--! Font Awesome Pro 6.2.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                            <path d="M184 88C184 118.9 158.9 144 128 144C97.07 144 72 118.9 72 88C72 57.07 97.07 32 128 32C158.9 32 184 57.07 184 88zM128 48C105.9 48 88 65.91 88 88C88 110.1 105.9 128 128 128C150.1 128 168 110.1 168 88C168 65.91 150.1 48 128 48zM568 88C568 118.9 542.9 144 512 144C481.1 144 456 118.9 456 88C456 57.07 481.1 32 512 32C542.9 32 568 57.07 568 88zM512 48C489.9 48 472 65.91 472 88C472 110.1 489.9 128 512 128C534.1 128 552 110.1 552 88C552 65.91 534.1 48 512 48zM64 256C68.42 256 72 259.6 72 264V432C72 440.8 79.16 448 88 448H168C176.8 448 184 440.8 184 432V383.6C188.7 390.8 194.1 397.4 200 403.6V432C200 449.7 185.7 464 168 464H88C70.33 464 56 449.7 56 432V381.1C22.6 362.4 0 326.6 0 285.5C0 225 49.04 176 109.5 176H146.5C169.8 176 191.4 183.3 209.1 195.7C205 199.3 201.1 203.1 197.5 207.1C182.8 197.6 165.3 192 146.5 192H109.5C57.88 192 16 233.9 16 285.5C16 317.3 31.81 345.3 56 362.3V264C56 259.6 59.58 256 64 256V256zM440 432V403.6C445.9 397.4 451.3 390.8 456 383.6V432C456 440.8 463.2 448 472 448H552C560.8 448 568 440.8 568 432V263.1C568 259.6 571.6 255.1 576 255.1C580.4 255.1 584 259.6 584 263.1V362.2C608.2 345.3 624 317.3 624 285.5C624 233.9 582.1 191.1 530.5 191.1H493.5C474.7 191.1 457.2 197.6 442.5 207.1C438.9 203.1 434.1 199.3 430.9 195.7C448.6 183.3 470.2 175.1 493.5 175.1H530.5C590.1 175.1 640 225 640 285.5C640 326.6 617.4 362.4 584 381.1V432C584 449.7 569.7 464 552 464H472C454.3 464 440 449.7 440 432V432zM384 96C384 131.3 355.3 160 320 160C284.7 160 256 131.3 256 96C256 60.65 284.7 32 320 32C355.3 32 384 60.65 384 96zM320 48C293.5 48 272 69.49 272 96C272 122.5 293.5 144 320 144C346.5 144 368 122.5 368 96C368 69.49 346.5 48 320 48zM192 301.5C192 241 241 192 301.5 192H338.5C398.1 192 448 241 448 301.5C448 342.6 425.4 378.4 392 397.1V448C392 465.7 377.7 480 360 480H280C262.3 480 248 465.7 248 448V397.1C214.6 378.4 192 342.6 192 301.5H192zM256 272C260.4 272 264 275.6 264 280V448C264 456.8 271.2 464 280 464H360C368.8 464 376 456.8 376 448V280C376 275.6 379.6 272 384 272C388.4 272 392 275.6 392 280V378.2C416.2 361.3 432 333.3 432 301.5C432 249.9 390.1 208 338.5 208H301.5C249.9 208 207.1 249.9 207.1 301.5C207.1 333.3 223.8 361.3 247.1 378.2V280C247.1 275.6 251.6 272 255.1 272H256z"/></svg>
                    </button>
                    <div id="tooltip-group" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                        Add Selected Contacts to group
                        <div class="tooltip-arrow" data-popper-arrow></div>
                    </div>

                    <button data-tooltip-target="tooltip-custom" type="button"  id="dropdownCheckboxButton" data-dropdown-toggle="dropdownDefaultCheckbox" class="focus:ring-2 focus:ring-offset-2 focus:ring-indigo-700 text-gray-600 p-2  border-gray-200 dark:text-gray-400 border rounded focus:outline-none focus:border-gray-800 focus:shadow-outline-gray"  type="button">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </button>

                    <div id="tooltip-custom" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                        Show/Hide Columns
                        <div class="tooltip-arrow" data-popper-arrow></div>
                    </div>

                    <button data-tooltip-target="tooltip-upload" type="button"  @click="open = !open" type="button"   class="focus:ring-2 focus:ring-offset-2 focus:ring-indigo-700 text-gray-600 p-2 ml-2 border-gray-200 dark:text-gray-400 border rounded focus:outline-none focus:border-gray-800 focus:shadow-outline-gray" aria-label="upload Table" role="button">
                        <svg class="h-5 rotate-180" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"></path>
                        </svg>
                    </button>

                    <div id="tooltip-upload" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                        Upload Contacts
                        <div class="tooltip-arrow" data-popper-arrow></div>
                    </div>


                    <button data-tooltip-target="tooltip-download" id="download" type="button"  wire:click="export"   class="focus:ring-2 focus:ring-offset-2 focus:ring-indigo-700 text-gray-600 p-2 ml-2 border-gray-200 dark:text-gray-400 border rounded focus:outline-none focus:border-gray-800 focus:shadow-outline-gray" aria-label="Download Table" role="button">
                        <svg  class="h-5"  fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"></path>
                        </svg>
                    </button>

                    <div id="tooltip-download" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                        Download Contacts
                        <div class="tooltip-arrow" data-popper-arrow></div>
                    </div>

                    <button data-tooltip-target="tooltip-all-contacts" type="button"  wire:click="$set('groupSelected',null)" class="focus:ring-2 focus:ring-offset-2 mx-1 focus:ring-indigo-700 p-2 border-gray-200 text-gray-600 dark:text-gray-400 border rounded focus:outline-none focus:border-gray-800 focus:shadow-outline-gray" aria-label="Delete table" role="button">
                        <svg  class="h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 010 3.75H5.625a1.875 1.875 0 010-3.75z"></path>
                        </svg>
                    </button>

                    <div id="tooltip-all-contacts" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                        All Contacts
                        <div class="tooltip-arrow" data-popper-arrow></div>
                    </div>


                    <!-- Dropdown menu -->
                    <div wire:ignore id="dropdownDefaultCheckbox" class="hidden z-10 w-48 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600">
                        <ul class="p-3 space-y-3 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownCheckboxButton">

                            <div class="block px-4 py-2 text-xs text-gray-400">
                                Custom Columns
                            </div>
                            @foreach($custom_cols as $cols=>$value)

                            <li>
                                <div class="flex items-center">
                                    <input wire:model="customSelected"  wire:click="updateCustomView('{{$cols}}')" id="checkbox-item-{{$cols}}" type="checkbox" value="{{$cols}}" class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                    <label for="checkbox-item-{{$cols}}" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{$cols}}</label>
                                </div>
                            </li>
                            @endforeach

                        </ul>
                    </div>


                </div>
            </div>
            <div class="w-full md:w-2/3 flex flex-col md:flex-row items-start md:items-center justify-end">


                <div class="flex items-center border-gray-200 border rounded mt-3 md:mt-0">
                    <div>
                        <select wire:model="perPage" id="location" name="location" class="mt-1 block w-[100px] border-0 py-2 pl-3 pr-10 text-base   sm:text-sm">
                            <option>25</option>
                            <option> 50</option>
                            <option>100</option>
                        </select>
                    </div>
                </div>

                <div class="flex flex-col w-full sm:w-1/2 md:ml-4 mt-3 md:mt-0">
                    <div class="relative w-full">

                        <div class="absolute text-gray-600 dark:text-gray-400 flex items-center pl-3 h-full">
                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
  <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
</svg>

                        </div>
                        <label for="search" class="hidden text-gray-800 text-sm font-bold leading-tight tracking-normal mb-2"></label>
                        <input wire:model="search"  id="search" class="w-full text-gray-600 bg-transparent dark:bg-gray-800 dark:text-gray-400 focus:outline-none focus:border focus:border-indigo-700 font-normal pl-8 xl:pr-24 h-10 flex items-center text-sm border-gray-300 dark:border-gray-200 rounded border" placeholder="Search contacts" />

                    </div>
                </div>
                <div class="flex items-center  md:mt-0 mx-5">
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input wire:model="optedOutFilter"  type="checkbox"  class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                        <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">Optouts</span>
                    </label>
                </div>
            </div>
        </div>
        <div class="w-full overflow-x-scroll xl:overflow-x-hidden min-h-[60vh]">

            <table class="min-w-full bg-white dark:bg-gray-800 rounded border border-gray-300" id="main-table">
                <thead>
                <tr class="w-full bg-gray-100 dark:bg-gray-700 border-b border-gray-300">
                    <th role="columnheader" class="pl-3 w-24 py-3">
                        <div class="flex items-center">
                            <input {{$this->all ? 'checked':'' }}  placeholder="check box" type="checkbox" class="cursor-pointer relative w-5 h-5 border rounded border-gray-400 bg-white" wire:click="selectAll"  />
                            <div class="opacity-0 cursor-defaut ml-4 text-gray-800 dark:text-gray-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-up" width="16" height="16" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" />
                                    <polyline points="6 15 12 9 18 15" />
                                </svg>
                            </div>
                        </div>
                    </th>

                    <th role="columnheader" class="border-l border-gray-300 pl-4 whitespace-no-wrap w-32 first-dropdown cursor-pointer" wire:click="reorder('number')">
                        <div class="flex items-center justify-between relative">
                            <p class="text-gray-800 dark:text-gray-100 font-normal text-left text-xs tracking-normal leading-4">Number</p>
                            <button role="button" aria-label="option" class="cursor-pointer  mr-3 text-gray-800 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-400 rounded">
                              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 dark:hidden">
         <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
   </svg>
                            </button>

                        </div>
                    </th>

                    <th role="columnheader" class="border-l border-gray-300 pl-4 whitespace-no-wrap w-32 first-dropdown cursor-pointer" wire:click="reorder('active')">
                        <div class="flex items-center justify-between relative">
                            <p class="text-gray-800 dark:text-gray-100 font-normal text-left text-xs tracking-normal leading-4">Status</p>
                            <button role="button" aria-label="option" class="cursor-pointer  mr-3 text-gray-800 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-400 rounded">
                              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 dark:hidden">
         <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
   </svg>
                            </button>
                        </div>
                    </th>
                    <th role="columnheader" class="border-l border-gray-300 pl-4 whitespace-no-wrap w-32 first-dropdown cursor-pointer" >
                        <div class="flex items-center justify-between relative">
                            <p class="text-gray-800 dark:text-gray-100 font-normal text-left text-xs tracking-normal leading-4">Opt-out Reason</p>
                            <button role="button" aria-label="option" class="cursor-pointer  mr-3 text-gray-800 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-400 rounded">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 dark:hidden">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                </svg>
                            </button>
                        </div>
                    </th>

                    <th role="columnheader" class="border-l border-gray-300 pl-4 whitespace-no-wrap w-32 first-dropdown cursor-pointer" wire:click="reorder('created_at')">
                        <div class="flex items-center justify-between relative">
                            <p class="text-gray-800 dark:text-gray-100 font-normal text-left text-xs tracking-normal leading-4">Created on</p>
                            <button role="button" aria-label="option" class="cursor-pointer  mr-3 text-gray-800 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-400 rounded">
                              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 dark:hidden">
                                 <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                           </svg>
                            </button>
                        </div>
                    </th>


                    @foreach($custom_cols as $key=>$value)


                        @if(count($customSelected) > 0 && in_array($key,$customSelected))
                        <th role="columnheader" class="border-l border-gray-300 pl-4 pr-12 whitespace-no-wrap w-32">
                            <p class="text-gray-800 dark:text-gray-100 font-normal text-left text-xs tracking-normal leading-4">{{str_replace('custom_','',$key)}}</p>
                        </th>
                        @endif
{{--                        @foreach($cols as $col)--}}

{{--                            @if(array_search($col->custom_name,$customSelected))--}}
{{--                                <th role="columnheader" class="border-l border-gray-300 pl-4 pr-12 whitespace-no-wrap w-32">--}}
{{--                                    <p class="text-gray-800 dark:text-gray-100 font-normal text-left text-xs tracking-normal leading-4">{{str_replace('custom_','',$col->custom_name)}}</p>--}}
{{--                                </th>--}}
{{--                                @endif--}}
{{--                        @endforeach--}}
                    @endforeach
                    <th role="columnheader" class="border-l border-gray-300 pl-4 pr-12 whitespace-no-wrap w-32">
                        <p class="text-gray-800 dark:text-gray-100 font-normal text-left text-xs tracking-normal leading-4">Groups in</p>
                    </th>
                    <th role="columnheader" class="border-l border-gray-300 pl-4 pr-12 whitespace-no-wrap w-32">
                        <p class="text-gray-800 dark:text-gray-100 font-normal text-left text-xs tracking-normal leading-4">Actions</p>
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($contacts as $contact)
                <div x-data="{rowId: false  }">
                    <tr class="border-b border-gray-300" >
                        <td class="pl-3 w-24 py-3">
                            <div class="flex items-center">
                                <input  placeholder="checkbox" value="{{$contact->id}}" type="checkbox" class="cursor-pointer relative w-5 h-5 border rounded border-gray-400 bg-white checkrow" wire:model="selected" />

                            </div>
                        </td>
                        <td class="pl-4 whitespace-no-wrap w-32">
                            <p class="text-gray-800 dark:text-gray-100 font-normal text-left text-xs tracking-normal leading-4">{{$contact->country_code}} {{$contact->number}}</p>
                        </td>
                        <td class="pl-4 whitespace-no-wrap w-32">
                            <div class="{{$contact->active == true ? 'bg-blue-100' : 'bg-red-100'}} h-6 w-20 rounded-md flex items-center justify-center">
                                <span class="text-xs {{$contact->active == true ? 'text-blue-700 ' : 'text-red-700 '}} font-normal">{{$contact->active == true ? 'Active':'Opted out'}}</span>
                            </div>
                        </td>
                        <td class="pl-4 whitespace-no-wrap w-32">
                            <p class="text-gray-800 dark:text-gray-100 font-normal text-left text-xs tracking-normal leading-4">{{$contact->optout_reason}}</p>
                        </td>

                        <td class="pl-4 whitespace-no-wrap w-32">
                            <p class="text-gray-800 dark:text-gray-100 font-normal text-left text-xs tracking-normal leading-4">{{$contact->created_at->format('d/m/Y')}}</p>
                        </td>
                        {{--            selected cols with data        --}}
                        @foreach($custom_cols as $key=>$cols)



                            @if(count($customSelected) > 0 && in_array($key,$customSelected))
                                <td class="pl-4 whitespace-no-wrap w-32">
                                    @foreach($cols as $col)
                                        @if($col->contactable_id == $contact->id )
                                            @if($col->custom_value)
                                                <p class="text-gray-800 dark:text-gray-100 font-normal text-left text-xs tracking-normal leading-4">{{$col->custom_value ?? ''}}</p>

                                            @endif
                                        @endif
                                    @endforeach
                                </td>
                            @endif

                        @endforeach
                        <td class="pl-4 whitespace-no-wrap w-32">
{{--                            <p class="text-gray-800 dark:text-gray-100 font-normal text-left text-xs tracking-normal leading-4">{{$contact->groups->count()}}</p>--}}

                            @foreach($contact['groups'] as $g)
                                <span class="inline-flex items-center rounded-full bg-indigo-100 py-0.5 pl-2 pr-0.5 text-xs font-medium text-indigo-700">
                                   {{$g->name}}
                              <button wire:click="confirmRemoval('{{$g->id}}','{{$contact->id}}')" type="button" class="ml-0.5 inline-flex h-4 w-4 flex-shrink-0 items-center justify-center rounded-full text-indigo-400 hover:bg-indigo-200 hover:text-indigo-500 focus:bg-indigo-500 focus:text-white focus:outline-none">
                                <svg class="h-2 w-2" stroke="currentColor" fill="none" viewBox="0 0 8 8">
                                  <path stroke-linecap="round" stroke-width="1.5" d="M1 1l6 6m0-6L1 7" />
                                </svg>
                              </button>
                            </span>

                            @endforeach
                        </td>




                        <td class="pl-4 pr-4 whitespace-no-wrap w-32 flex justify-start items-center space-x-1">

                            <button
                                wire:click="editContact({{$contact->id}})"
                               onclick="openNav()"
                               class="mt-2 cursor-pointer">
                                <svg fill="none" stroke="currentColor" class="w-5" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"></path>
                                </svg>
                            </button>

                            <a wire:click="removeSingleContact('{{$contact->id}}')" class=" mt-2  cursor-pointer " >
                                <svg class="w-5 text-red-600 " fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"></path>
                                </svg>
                            </a>
                        </td>
                    {{--     Dropdown data      --}}


                    </tr>
                </div>

                @endforeach
                </tbody>
            </table>
        </div>
    </div>


    <div class="mx-auto container py-3 ">

        {{$contacts->links()}}

    </div>



    {{--  Move to group  --}}
        <div x-show="group" x-cloak  class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true">

        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

        <div class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pt-5 pb-4 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-primary-600 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" >
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 7.5h-.75A2.25 2.25 0 004.5 9.75v7.5a2.25 2.25 0 002.25 2.25h7.5a2.25 2.25 0 002.25-2.25v-7.5a2.25 2.25 0 00-2.25-2.25h-.75m-6 3.75l3 3m0 0l3-3m-3 3V1.5m6 9h.75a2.25 2.25 0 012.25 2.25v7.5a2.25 2.25 0 01-2.25 2.25h-7.5a2.25 2.25 0 01-2.25-2.25v-.75" />
                            </svg>

                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title">Group {{count($this->selected)}} Contacts </h3>
                            @error('selected')
                            <div class="pt-5">
                                <span class="error mt-2 bg-red-200 text-red-800 p-2 rounded shadow-xl border-red-900">{{ $message }}</span>
                            </div>
                            @enderror
                            <div class="mt-2" x-data="{show : false}">
                                <div class="flex items-center justify-center py-8 px-0 w-full">
                                    <div class="relative  w-96 bg-white">
                                        @if(!$createNewGroup)
                                            <h1 tabindex="0" class="focus:outline-none dark:text-gray-100 text-gray-800 font-bold text-lg">Add to Group</h1>

                                            <div>
                                                <div class="relative mt-1">
                                                    <div>
                                                        <label for="location" class="block text-sm font-medium text-gray-700"></label>
                                                        <select wire:model="moveGroupSelected" id="location" name="location" class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                                                            <option value="0">Please select</option>
                                                            @foreach($groups as $group)
                                                                <option value="{{$group->id}}">{{$group->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        <div class="pt-3 pb-5">
                                            @if(!$createNewGroup)
                                                <a href="#" wire:click="createNewGroup" class="">
                                                    <p tabindex="0" class="focus:outline-none  text-xs font-semibold text-indigo-700 uppercase">Create New Group and Add</p>
                                                </a>
                                            @endif

                                            @if($createNewGroup)
                                                <div class="py-2 ">
                                                    <form wire:submit.prevent="submitNewGroup">
                                                        <label for="nameGroup" class="sr-only">newGroupName</label>
                                                        <div class="flex">
                                                            <input wire:model="nameGroup" type="text" id="nameGroup" class="block w-full rounded-tl-md rounded-bl-md  border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="new group name">

                                                            <button type="submit" class="bg-primary-600 text-white p-2" style="background-color: #253369;">save</button>
                                                        </div>
                                                        @error('nameGroup')
                                                        <div class="pt-5">
                                                            <span class="error mt-2 bg-red-200 text-red-800 p-2 rounded shadow-xl border-red-900">{{ $message }}</span>


                                                        </div>
                                                        @enderror
                                                    </form>
                                                </div>

                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                        <button @click="group = !group" type="button" class="inline-flex w-full justify-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm">Cancel</button>
                        @if(!$createNewGroup)
                            <button @click="group = !group" wire:click="moveGroupSubmit()"   type="button" class="{{count($this->selected) > 0 ? '': 'hidden'}} mt-3 inline-flex w-full justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-base font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:mt-0 sm:w-auto sm:text-sm">Assign</button>
                        @endif
                        <button type="button" class="{{count($this->selected) > 0 ? 'hidden ': ''}} mt-3 inline-flex w-full justify-center rounded-md border border-gray-300 bg-gray-50 px-4 py-2 text-base font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:mt-0 sm:w-auto sm:text-sm " disabled >Add To Group</button>

                    </div>
                </div>
            </div>
        </div>
    </div>


        <!-- drawer component -->
        <div wire:ignore id="mySidenav" class="sidenav z-50 shadow-xl">

            <div class="flex justify-between items-center px-4 border-b">
                <h3 class="pt-1">Contact</h3>
                <a  wire:click="clearContact" class="closebtn cursor-pointer" onclick="closeNav()">&times;</a>
            </div>


            <form wire:submit.prevent="contactUpdate" >


                <div class="space-y-4 p-4">

                    {{--                <div>--}}
                    {{--                    <label for="text" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">First Name</label>--}}
                    {{--                    <input wire:model.debounce.500ms="contact.firstname" type="text" name="fname" id="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="" placeholder="" required="">--}}
                    {{--                </div>--}}
                    {{--                <div>--}}
                    {{--                    <label for="lname" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Last Name</label>--}}
                    {{--                    <input wire:model.debounce.500ms="contact.lastname" type="text" name="lname" id="lname" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="" placeholder="" required="">--}}
                    {{--                </div>--}}

                    <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">Country </label>
                    <select wire:model.debounce.500ms="contact.country_code" id="countries" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option selected>Choose a country</option>

                        <option value="44">UK</option>
                    </select>

                    <div>
                        <label for="Number" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Contact Number</label>
                        <input wire:model.debounce.500ms="contact.number"
                               type="number" name="Number" id="Number"
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                               value=""
                               placeholder=""
                               x-bind:disabled="edit"



                        >
                    </div>



                    {{--                    @foreach($this->contact['custom'] as $key=> $custom)--}}
                    {{--                   --}}
                    {{--                    <label for="{{$custom['custom_name']}}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{$custom['custom_name']}}</label>--}}
                    {{--                            <input wire:model.debounce.500ms="contact.{{$custom['custom_name']}}" type="text" name="{{$custom['custom_name']}}" id="{{$custom['custom_name']}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="{{$custom['custom_value']}}" placeholder="" >--}}
                    {{--                    @endforeach--}}
                    <div class="space-y-4 p-4">
                        <div class="flex justify-start">

                            @foreach($inTheseGroups as $g)
                              <div>

                                  <span class="inline-flex items-center rounded-full bg-indigo-100 py-0.5 pl-2 pr-0.5 text-xs font-medium text-indigo-700">
                             {{$g['name']}}
                              <button wire:click="removeFromGroup('{{$g['id']}}')" type="button" class="ml-0.5 inline-flex h-4 w-4 flex-shrink-0 items-center justify-center rounded-full text-indigo-400 hover:bg-indigo-200 hover:text-indigo-500 focus:bg-indigo-500 focus:text-white focus:outline-none">
                                <svg class="h-2 w-2" stroke="currentColor" fill="none" viewBox="0 0 8 8">
                                  <path stroke-linecap="round" stroke-width="1.5" d="M1 1l6 6m0-6L1 7" />
                                </svg>
                              </button>
                            </span>
                              </div>

                            @endforeach
                        </div>

                </div>


                    <label for="default-toggle" class="inline-flex relative items-center cursor-pointer">
                        <input wire:model="contact.active" type="checkbox" id="default-toggle" class="sr-only peer">

                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                        <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">Opt in status</span>

                    </label>






                    <div>
                        <label for="reason" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Opt out reason</label>
                        <p class="break-words" >

                            <textarea class="h-48 px-3 py-2 bg-gray-50 rounded-xl border-transparent outline-0 focus:outline-0" wire:model="contact.optout_reason"  disabled>

                            </textarea>

                        </p>

                    </div>




                </div>

                <div class="bottom-0 left-0 flex justify-center w-full pb-4 mt-4 space-x-4 sm:absolute sm:px-4 sm:mt-0">
                    <button  onclick="closeNav()"   type="submit" class="w-full justify-center text-white   focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800" style="background-color:#253369 ">
                        Save
                    </button>


                </div>
            </form>

        </div>


<script>



    /* Set the width of the side navigation to 250px */
    function openNav() {

        document.getElementById("mySidenav").style.width = "300px";
        document.getElementById("backdrop").style.display = "block";

    }



    /* Set the width of the side navigation to 0 */
    function closeNav() {
        document.getElementById("mySidenav").style.width = "0";
        document.getElementById("backdrop").style.display = "none";

    }
</script>

        <div wire:ignore id="backdrop" class="bg-gray-900 bg-opacity-50 dark:bg-opacity-80 fixed inset-0 z-30" style="display: none"></div>
</div>

