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


                 <livewire:campaign.overview :scheduledMessage="$id"/>
{{--                 <div class="mx-auto container bg-white dark:bg-gray-800 shadow rounded my-6">--}}

{{--                     <div class="flex flex-col md:flex-row p-3 justify-between items-start md:items-stretch w-full">--}}
{{--                         <div class="w-full md:w-1/3 flex flex-col md:flex-row items-start md:items-center">--}}
{{--                             <div class="flex items-center">--}}
{{--                                 <h2 class="text-2xl">{{$campaign->name}} recipients</h2>--}}
{{--                             </div>--}}
{{--                         </div>--}}
{{--                         <div class="w-full md:w-2/3 flex flex-col md:flex-row items-start md:items-center justify-end">--}}
{{--                             <div class="flex items-center border-gray-200 border rounded mt-3 md:mt-0">--}}
{{--                                 <div>--}}
{{--                                     <select wire:model="perPage" id="location" name="location" class="mt-1 block w-[100px] border-0 py-2 pl-3 pr-10 text-base   sm:text-sm">--}}
{{--                                         <option>25</option>--}}
{{--                                         <option> 50</option>--}}
{{--                                         <option>100</option>--}}
{{--                                     </select>--}}
{{--                                 </div>--}}
{{--                             </div>--}}
{{--                             <div class="flex flex-col w-full sm:w-1/2 md:ml-4 mt-3 md:mt-0">--}}
{{--                                 <div class="relative w-full">--}}
{{--                                     <div aria-hidden="true" class="absolute cursor-pointer text-gray-600 dark:text-gray-400 flex items-center pr-3 right-0 border-l h-full">--}}
{{--                                        <span class="ml-2 mr-1">--}}
{{--                                            <img class="dark:hidden" src="https://tuk-cdn.s3.amazonaws.com/can-uploader/advance_table_with_filters%2C_actions%2C_search%2C_sort_and_expanded_row-svg6.svg" alt="Filter">--}}
{{--                                            <img class="dark:block hidden" src="https://tuk-cdn.s3.amazonaws.com/can-uploader/advance_table_with_filters%2C_actions%2C_search%2C_sort_and_expanded_row-svg6dark.svg" alt="Filter">--}}
{{--                                        </span>--}}
{{--                                         <span class="text-sm leading-tight tracking-normal">Filter</span>--}}
{{--                                     </div>--}}
{{--                                     <div class="absolute text-gray-600 dark:text-gray-400 flex items-center pl-3 h-full">--}}
{{--                                         <img class="dark:hidden" src="https://tuk-cdn.s3.amazonaws.com/can-uploader/advance_table_with_filters%2C_actions%2C_search%2C_sort_and_expanded_row-svg7.svg" alt="search">--}}
{{--                                         <img class="dark:block hidden" src="../svgs/svg7dark.svg" alt="search">--}}
{{--                                     </div>--}}
{{--                                     <label for="search" class="hidden text-gray-800 text-sm font-bold leading-tight tracking-normal mb-2"></label>--}}
{{--                                     <input wire:model="search"  id="search" class="w-full text-gray-600 bg-transparent dark:bg-gray-800 dark:text-gray-400 focus:outline-none focus:border focus:border-indigo-700 font-normal pl-8 pr-24 h-10 flex items-center text-sm border-gray-300 dark:border-gray-200 rounded border" placeholder="Search for campaign" />--}}
{{--                                 </div>--}}
{{--                             </div>--}}
{{--                         </div>--}}
{{--                     </div>--}}
{{--                     <div class="w-full overflow-x-scroll xl:overflow-x-hidden min-h-screen">--}}

{{--                         <table class="min-w-full bg-white dark:bg-gray-800 rounded border border-gray-300" id="main-table">--}}
{{--                             <thead>--}}
{{--                             <tr class="w-full bg-gray-100 dark:bg-gray-700 border-b border-gray-300">--}}

{{--                                 <th role="columnheader"  class="whitespace-no-wrap w-32 pl-5 first-dropdown cursor-pointer" wire:click="reorder('name')">--}}
{{--                                     <div class="flex items-center justify-between relative chuss-div">--}}
{{--                                         <p class="text-gray-800 dark:text-gray-100 font-normal text-left text-xs tracking-normal leading-4">Campaign Name</p>--}}
{{--                                         <button  role="button" aria-label="option" class="cursor-pointer h-10   mr-3 text-gray-800 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-400 rounded">--}}
{{--                                             <img class="dark:hidden" src="https://tuk-cdn.s3.amazonaws.com/can-uploader/advance_table_with_filters%2C_actions%2C_search%2C_sort_and_expanded_row-svg8.svg" alt="down">--}}
{{--                                             <img class="dark:block hidden" src="https://tuk-cdn.s3.amazonaws.com/can-uploader/advance_table_with_filters%2C_actions%2C_search%2C_sort_and_expanded_row-svg8dark.svg" alt="down">--}}
{{--                                         </button>--}}

{{--                                     </div>--}}
{{--                                 </th>--}}
{{--                                 <th role="columnheader"  class="whitespace-no-wrap w-32 first-dropdown cursor-pointer" wire:click="reorder('created_at')">--}}
{{--                                     <div class="flex items-center justify-between relative chuss-div">--}}
{{--                                         <p class="text-gray-800 dark:text-gray-100 font-normal text-left text-xs tracking-normal leading-4">Scheduled Date</p>--}}
{{--                                         <button  role="button" aria-label="option" class="cursor-pointer  mr-3 text-gray-800 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-400 rounded">--}}
{{--                                             <img class="dark:hidden" src="https://tuk-cdn.s3.amazonaws.com/can-uploader/advance_table_with_filters%2C_actions%2C_search%2C_sort_and_expanded_row-svg8.svg" alt="down">--}}
{{--                                             <img class="dark:block hidden" src="https://tuk-cdn.s3.amazonaws.com/can-uploader/advance_table_with_filters%2C_actions%2C_search%2C_sort_and_expanded_row-svg8dark.svg" alt="down">--}}
{{--                                         </button>--}}

{{--                                     </div>--}}
{{--                                 </th>--}}
{{--                                 <th role="columnheader" class="border-l border-gray-300 pl-4 whitespace-no-wrap w-32 first-dropdown cursor-pointer" >--}}
{{--                                     <div class="flex items-center justify-between relative">--}}
{{--                                         <p class="text-gray-800 dark:text-gray-100 font-normal text-left text-xs tracking-normal leading-4">Message Preview</p>--}}
{{--                                     </div>--}}
{{--                                 </th>--}}
{{--                                 <th role="columnheader" class="border-l border-gray-300 pl-4 whitespace-no-wrap w-32 first-dropdown cursor-pointer" >--}}
{{--                                     <div class="flex items-center justify-between relative">--}}
{{--                                         <p class="text-gray-800 dark:text-gray-100 font-normal text-left text-xs tracking-normal leading-4">Contacts</p>--}}
{{--                                     </div>--}}
{{--                                 </th>--}}

{{--                                 <th role="columnheader" class="border-l border-gray-300 pl-4 whitespace-no-wrap w-32 first-dropdown cursor-pointer" wire:click="reorder('status')">--}}
{{--                                     <div class="flex items-center justify-between relative">--}}
{{--                                         <p class="text-gray-800 dark:text-gray-100 font-normal text-left text-xs tracking-normal leading-4">Status</p>--}}
{{--                                         <button role="button" aria-label="option" class="cursor-pointer  mr-3 text-gray-800 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-400 rounded">--}}
{{--                                             <img class="dark:hidden" src="https://tuk-cdn.s3.amazonaws.com/can-uploader/advance_table_with_filters%2C_actions%2C_search%2C_sort_and_expanded_row-svg8.svg" alt="down">--}}
{{--                                             <img class="dark:block hidden" src="https://tuk-cdn.s3.amazonaws.com/can-uploader/advance_table_with_filters%2C_actions%2C_search%2C_sort_and_expanded_row-svg8dark.svg" alt="down">--}}
{{--                                         </button>--}}
{{--                                     </div>--}}
{{--                                 </th>--}}
{{--                                 <th role="columnheader" class="border-l border-gray-300 pl-4 whitespace-no-wrap w-32 first-dropdown cursor-pointer" >--}}
{{--                                     <div class="flex items-center justify-between relative">--}}
{{--                                         <p class="text-gray-800 dark:text-gray-100 font-normal text-left text-xs tracking-normal leading-4">Credits Used</p>--}}
{{--                                     </div>--}}
{{--                                 </th>--}}
{{--                                 <th role="columnheader" class="border-l border-gray-300 pl-4 whitespace-no-wrap w-32 first-dropdown cursor-pointer"  wire:click="reorder('updated_at')">--}}
{{--                                     <div class="flex items-center justify-between relative">--}}
{{--                                         <p class="text-gray-800 dark:text-gray-100 font-normal text-left text-xs tracking-normal leading-4">Updated on</p>--}}
{{--                                         <button role="button" aria-label="option" class="cursor-pointer  mr-3 text-gray-800 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-400 rounded">--}}
{{--                                             <img class="dark:hidden" src="https://tuk-cdn.s3.amazonaws.com/can-uploader/advance_table_with_filters%2C_actions%2C_search%2C_sort_and_expanded_row-svg8.svg" alt="down">--}}
{{--                                             <img class="dark:block hidden" src="https://tuk-cdn.s3.amazonaws.com/can-uploader/advance_table_with_filters%2C_actions%2C_search%2C_sort_and_expanded_row-svg8dark.svg" alt="down">--}}
{{--                                         </button>--}}
{{--                                     </div>--}}
{{--                                 </th>--}}

{{--                             </tr>--}}
{{--                             </thead>--}}
{{--                             <tbody>--}}
{{--                             @foreach($contacts as $message)--}}


{{--                                 <tr class="border-b border-gray-300">--}}

{{--                                     <td class="whitespace-no-wrap w-32 pl-5">--}}
{{--                                         <p class="text-gray-800 dark:text-gray-100 font-normal text-left text-xs tracking-normal leading-4">{{ucfirst($message->SMS_UID ?? 'AWAITING')}}</p>--}}
{{--                                     </td>--}}

{{--                                     <td class="whitespace-no-wrap w-32">--}}
{{--                                         <p class="text-gray-800 dark:text-gray-100 font-normal text-left text-xs tracking-normal leading-4">{{Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$campaign->send_date.''.$campaign->send_time)->format('d/m/y H:i')}}</p>--}}
{{--                                     </td>--}}
{{--                                     <td class="pl-4 whitespace-no-wrap  max-w-16">--}}
{{--                                         <p class="text-gray-800 dark:text-gray-100 font-normal text-left word text-xs tracking-normal leading-4 break-words ">--}}
{{--                                             <button data-popover-target="popover-default{{$message->id}}" type="button" class="text-primary-600   focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">View Message</button>--}}
{{--                                         <div data-popover id="popover-default{{$message->id}}" role="tooltip" class="inline-block absolute invisible z-10 w-64 text-sm font-light text-gray-500 bg-white rounded-lg border border-gray-200 shadow-sm opacity-0 transition-opacity duration-300 dark:text-gray-400 dark:border-gray-600 dark:bg-gray-800">--}}
{{--                                             <div class="py-2 px-3 bg-gray-100 rounded-t-lg border-b border-gray-200 dark:border-gray-600 dark:bg-gray-700">--}}
{{--                                                 <h3 class="font-semibold text-gray-900 dark:text-white">Message Sent</h3>--}}
{{--                                             </div>--}}
{{--                                             <div class="py-2 px-3">--}}
{{--                                                 <p> {{$message->message_sent}}</p>--}}
{{--                                             </div>--}}
{{--                                             <div data-popper-arrow></div>--}}
{{--                                         </div>--}}
{{--                                         </p>--}}
{{--                                     </td>--}}
{{--                                     <td class="pl-4 whitespace-no-wrap w-32">--}}
{{--                                         <p class="text-gray-800 dark:text-gray-100 font-normal text-left text-xs tracking-normal leading-4">{{$message->country_code}}{{$message->number}}</p>--}}
{{--                                     </td>--}}
{{--                                     <td class="pl-4 whitespace-no-wrap w-32">--}}
{{--                                         <div class=" h-6 w-20 rounded-md flex items-center justify-center">--}}
{{--                                            <span class="text-gray-800 dark:text-gray-100 font-normal text-left text-xs tracking-normal leading-4">--}}
{{--                                                {{$message->RESULT_DESC ?? 'AWAITING'}}--}}
{{--                                            </span>--}}
{{--                                         </div>--}}
{{--                                     </td>--}}
{{--                                     <td class="pl-4 whitespace-no-wrap w-32">--}}
{{--                                         <p class="text-gray-800 dark:text-gray-100 font-normal text-left text-xs tracking-normal leading-4">dd{{$message->sms_qty }} </p>--}}
{{--                                     </td>--}}
{{--                                     <td class="pl-4 whitespace-no-wrap w-32">--}}
{{--                                         <p class="text-gray-800 dark:text-gray-100 font-normal text-left text-xs tracking-normal leading-4">{{$message->updated_at}}</p>--}}
{{--                                     </td>--}}
{{--                                 </tr>--}}
{{--                             @endforeach--}}
{{--                             </tbody>--}}
{{--                         </table>--}}
{{--                     </div>--}}


{{--                 </div>--}}

{{--                 <div class="mx-auto container dark:bg-gray-800  m2-3">--}}
{{--                     <div class="mt-4 mx-auto ">--}}
{{--                         {{$contacts->links()}}--}}
{{--                     </div>--}}
{{--                 </div>--}}




             </main>

    @push('js')

        @endpush

</x-app-layout>
