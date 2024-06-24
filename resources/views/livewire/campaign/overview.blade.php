<div x-data="{group:false,open:false}">

    @if($header)
        <x-slot name="header">

            <div class="flex w-full pl-3 sm:pl-6 pr-3 py-0 items-center justify-between  rounded-t">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Campaign: {{ $campaign->name }}
                </h2>
                <div class="text-black font-bold">
                    Status:
                    @switch($campaign->status)
                        @case ('pending')
                            {{'Scheduled'}}
                            @break
                        @case ('draft')
                            {{'Draft'}}
                            @break
                        @case ('complete')
                            {{'Sent'}}
                            @break
                        @default
                            {{$campaign->status}}
                            @break
                    @endswitch
                </div>
            </div>
        </x-slot>
    @endif

    <div class="container mx-auto my-3">



        <dl class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-3">

            <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
                <dt class="truncate text-sm font-medium text-gray-500">Pending</dt>
                <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">{{$pending}}</dd>
                <span class="text-sm">Scheduled to send</span>
            </div>

            <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
                <dt class="truncate text-sm font-medium text-gray-500">Sent</dt>
                <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">{{$sent}}</dd>
                <span class="text-sm">Send to contacts</span>
            </div>



{{--            <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">--}}
{{--                <dt class="truncate text-sm font-medium text-gray-500">Delivered</dt>--}}
{{--                <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">{{$delivered}}</dd>--}}
{{--                <span class="text-sm">Delivered to contacts</span>--}}
{{--            </div>--}}


        </dl>


    </div>



    <div class="mx-auto container bg-white dark:bg-gray-800 shadow rounded my-6">



            <div class="mx-auto container bg-white dark:bg-gray-800 shadow rounded my-6">

                <div class="flex flex-col md:flex-row p-3 justify-between items-start md:items-stretch w-full">
                    <div class="w-full md:w-1/3 flex flex-col md:flex-row items-start md:items-center">
                        <div class="flex items-center">
                            <button data-tooltip-target="tooltip-delete" type="button"  wire:click="exportDate" class="focus:ring-2 focus:ring-offset-2 focus:ring-indigo-700 p-2 border-gray-200 text-gray-600 dark:text-gray-400 border rounded focus:outline-none focus:border-gray-800 focus:shadow-outline-gray" aria-label="Delete table" role="button">
                                <svg fill="none" stroke="currentColor" class="w-5" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 7.5h-.75A2.25 2.25 0 004.5 9.75v7.5a2.25 2.25 0 002.25 2.25h7.5a2.25 2.25 0 002.25-2.25v-7.5a2.25 2.25 0 00-2.25-2.25h-.75m-6 3.75l3 3m0 0l3-3m-3 3V1.5m6 9h.75a2.25 2.25 0 012.25 2.25v7.5a2.25 2.25 0 01-2.25 2.25h-7.5a2.25 2.25 0 01-2.25-2.25v-.75"></path>
                                </svg>
                            </button>
                            <div id="tooltip-delete" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                Export Information
                                <div class="tooltip-arrow" data-popper-arrow></div>
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
                                <div aria-hidden="true" class="absolute cursor-pointer text-gray-600 dark:text-gray-400 flex items-center pr-3 right-0 border-l h-full">
                                        <span class="ml-2 mr-1">
                                            <img class="dark:hidden" src="https://tuk-cdn.s3.amazonaws.com/can-uploader/advance_table_with_filters%2C_actions%2C_search%2C_sort_and_expanded_row-svg6.svg" alt="Filter">
                                            <img class="dark:block hidden" src="https://tuk-cdn.s3.amazonaws.com/can-uploader/advance_table_with_filters%2C_actions%2C_search%2C_sort_and_expanded_row-svg6dark.svg" alt="Filter">
                                        </span>
                                    <span class="text-sm leading-tight tracking-normal">Filter</span>
                                </div>
                                <div class="absolute text-gray-600 dark:text-gray-400 flex items-center pl-3 h-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                                    </svg>
                                </div>
                                <label for="search" class="hidden text-gray-800 text-sm font-bold leading-tight tracking-normal mb-2"></label>
                                <input wire:model="search"  id="search" class="w-full text-gray-600 bg-transparent dark:bg-gray-800 dark:text-gray-400 focus:outline-none focus:border focus:border-indigo-700 font-normal pl-8 pr-24 h-10 flex items-center text-sm border-gray-300 dark:border-gray-200 rounded border" placeholder="Search for campaign" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="w-full overflow-x-scroll xl:overflow-x-hidden min-h-screen">

                    <table class="min-w-full bg-white dark:bg-gray-800 rounded border border-gray-300" id="main-table">
                        <thead>
                        <tr class="w-full bg-gray-100 dark:bg-gray-700 border-b border-gray-300">

                            <th role="columnheader"  class="whitespace-no-wrap w-32 pl-5 first-dropdown cursor-pointer" >
                                <div class="flex items-center justify-between relative h-10">
                                    <p class="text-gray-800  dark:text-gray-100 font-normal text-left text-xs tracking-normal leading-4">Message ref</p>

                                </div>
                            </th>
                            <th role="columnheader"  class="whitespace-no-wrap w-32 first-dropdown cursor-pointer" >
                                <div class="flex items-center justify-between relative">
                                    <p class="text-gray-800 dark:text-gray-100 font-normal text-left text-xs tracking-normal leading-4">Scheduled Date</p>
                                </div>
                            </th>
                            <th role="columnheader" class="border-l border-gray-300 pl-4 whitespace-no-wrap w-32 first-dropdown cursor-pointer" >
                                <div class="flex items-center justify-between relative">
                                    <p class="text-gray-800 dark:text-gray-100 font-normal text-left text-xs tracking-normal leading-4">Message Preview</p>
                                </div>
                            </th>
                            <th role="columnheader" class="border-l border-gray-300 pl-4 whitespace-no-wrap w-32 first-dropdown cursor-pointer" >
                                <div class="flex items-center justify-between relative">
                                    <p class="text-gray-800 dark:text-gray-100 font-normal text-left text-xs tracking-normal leading-4">Contacts</p>
                                </div>
                            </th>

                            <th role="columnheader" class="border-l border-gray-300 pl-4 whitespace-no-wrap w-32 first-dropdown cursor-pointer" >
                                <div class="flex items-center justify-between relative">
                                    <p class="text-gray-800 dark:text-gray-100 font-normal text-left text-xs tracking-normal leading-4">Status</p>
                                </div>
                            </th>
                            <th role="columnheader" class="border-l border-gray-300 pl-4 whitespace-no-wrap w-32 first-dropdown cursor-pointer" >
                                <div class="flex items-center justify-between relative">
                                    <p class="text-gray-800 dark:text-gray-100 font-normal text-left text-xs tracking-normal leading-4">Credits Used</p>
                                </div>
                            </th>


                        </tr>
                        </thead>
                        <tbody>
                        @foreach($contacts as $message)


                            <tr class="border-b border-gray-300">

                                <td class="whitespace-no-wrap w-32 pl-5">
                                    <p class="text-gray-800 dark:text-gray-100 font-normal text-left text-xs tracking-normal leading-4">{{ucfirst($message->SMS_UID ?? '-')}}</p>
                                </td>

                                <td class="whitespace-no-wrap w-32">
                                    <p class="text-gray-800 dark:text-gray-100 font-normal text-left text-xs tracking-normal leading-4">{{Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$campaign->send_date.''.$campaign->send_time)->format('d/m/y H:i')}}</p>
                                </td>
                                <td class="pl-4 whitespace-no-wrap  max-w-16">
                                    <p class="text-gray-800 dark:text-gray-100 font-normal text-left word text-xs tracking-normal leading-4 break-words ">
                                        <button data-popover-target="popover-default{{$message->id}}" type="button" class="text-primary-600   focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">View Message</button>
                                    <div data-popover id="popover-default{{$message->id}}" role="tooltip" class="inline-block absolute invisible z-10 w-64 text-sm font-light text-gray-500 bg-white rounded-lg border border-gray-200 shadow-sm opacity-0 transition-opacity duration-300 dark:text-gray-400 dark:border-gray-600 dark:bg-gray-800">
                                        <div class="py-2 px-3 bg-gray-100 rounded-t-lg border-b border-gray-200 dark:border-gray-600 dark:bg-gray-700">
                                            <h3 class="font-semibold text-gray-900 dark:text-white">Message Sent</h3>
                                        </div>
                                        <div class="py-2 px-3">
                                            <p> {{$message->message_sent}}</p>
                                        </div>
                                        <div data-popper-arrow></div>
                                    </div>
                                    </p>
                                </td>
                                <td class="pl-4 whitespace-no-wrap w-32">
                                    <p class="text-gray-800 dark:text-gray-100 font-normal text-left text-xs tracking-normal leading-4">{{$message->country_code}}{{$message->number}}</p>
                                </td>
                                <td class="pl-4 whitespace-no-wrap w-32">
                                    <div class=" h-6 w-20 rounded-md flex items-center justify-center">
                                            <span class="text-gray-800 dark:text-gray-100 font-normal text-left text-xs tracking-normal leading-4">
                                                {{$message->RESULT_DESC ?? 'Scheduled'}}
                                            </span>
                                    </div>
                                </td>
                                <td class="pl-4 whitespace-no-wrap w-32">
                                    <p class="text-gray-800 dark:text-gray-100 font-normal text-left text-xs tracking-normal leading-4">{{$message->credits_used }} </p>
                                </td>

                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>


            </div>


        </div>
    </div>


    <div class="mx-auto container pt-8 items-center">

        {{$contacts->links()}}

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

