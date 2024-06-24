<div x-data="{group:false}">
    <x-slot name="header">

        <div class="flex w-full pl-3 sm:pl-6 pr-3 py-0 items-center justify-between  rounded-t">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Department Campaigns') }}
            </h2>
            <a href="{{$isTLD ? route($prefix.'.message',['domain' => $domain]) : route('message',['domain' =>$domain])}}" class="ml-0 sm:ml-6 bg-dbfb2 transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-dbfb1 hover:bg-dbfb1 rounded text-white px-5 h-8 flex items-center text-sm">Create New</a>
        </div>
    </x-slot>

    <div class="mx-auto container bg-white dark:bg-gray-800 shadow rounded my-6">

        <div class="flex flex-col md:flex-row p-3 justify-between items-start md:items-stretch w-full">
            <div class="w-full md:w-1/3 flex flex-col md:flex-row items-start md:items-center">
                <div class="flex items-center">
                    <h2 class="text-2xl">All Campaigns</h2>
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
                        <input wire:model="search"  id="search" class="w-full text-gray-600 bg-transparent dark:bg-gray-800 dark:text-gray-400 focus:outline-none focus:border focus:border-indigo-700 font-normal pl-8 pr-24 h-10 flex items-center text-sm border-gray-300 dark:border-gray-200 rounded border" placeholder="Search for campaign" />
                    </div>
                </div>
            </div>
        </div>
        <div class="w-full overflow-x-scroll xl:overflow-x-hidden min-h-screen">

            <table class="min-w-full bg-white dark:bg-gray-800 rounded border border-gray-300" id="main-table">
                <thead>
                <tr class="w-full bg-gray-100 dark:bg-gray-700 border-b border-gray-300">

                    <th role="columnheader"  class="whitespace-no-wrap w-32 pl-5 first-dropdown cursor-pointer" wire:click="reorder('name')">
                        <div class="flex items-center justify-between relative chuss-div">
                            <p class="text-gray-800 dark:text-gray-100 font-normal text-left text-xs tracking-normal leading-4">Campaign Name</p>
                            <button  role="button" aria-label="option" class="cursor-pointer h-10   mr-3 text-gray-800 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-400 rounded">
                              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 dark:hidden">
         <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
   </svg>
                            </button>

                        </div>
                    </th>
                    <th role="columnheader"  class="whitespace-no-wrap w-32 first-dropdown cursor-pointer" wire:click="reorder('created_at')">
                        <div class="flex items-center justify-between relative chuss-div">
                            <p class="text-gray-800 dark:text-gray-100 font-normal text-left text-xs tracking-normal leading-4">Scheduled Date</p>
                            <button  role="button" aria-label="option" class="cursor-pointer  mr-3 text-gray-800 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-400 rounded">
                              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 dark:hidden">
         <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
   </svg>
                            </button>

                        </div>
                    </th>
                    <th role="columnheader"  class="whitespace-no-wrap w-32 first-dropdown cursor-pointer" wire:click="reorder('sender_id')">
                        <div class="flex items-center justify-between relative chuss-div">
                            <p class="text-gray-800 dark:text-gray-100 font-normal text-left text-xs tracking-normal leading-4">Sender</p>
                            <button  role="button" aria-label="option" class="cursor-pointer  mr-3 text-gray-800 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-400 rounded">
                              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 dark:hidden">
         <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
   </svg>
                            </button>

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

                    <th role="columnheader" class="border-l border-gray-300 pl-4 whitespace-no-wrap w-48 first-dropdown cursor-pointer" wire:click="reorder('status')">
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
                            <p class="text-gray-800 dark:text-gray-100 font-normal text-left text-xs tracking-normal leading-4">Delivered To</p>
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
                    <th role="columnheader" class="border-l border-gray-300 pl-4 whitespace-no-wrap w-32 first-dropdown cursor-pointer"  wire:click="reorder('updated_at')">
                        <div class="flex items-center justify-between relative">
                            <p class="text-gray-800 dark:text-gray-100 font-normal text-left text-xs tracking-normal leading-4">Updated on</p>
                            <button role="button" aria-label="option" class="cursor-pointer  mr-3 text-gray-800 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-400 rounded">
                              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 dark:hidden">
         <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
   </svg>
                            </button>
                        </div>
                    </th>
                    <th role="columnheader" class="border-l border-gray-300 pl-4 pr-12 whitespace-no-wrap w-32">
                        <p class="text-gray-800 dark:text-gray-100 font-normal text-left text-xs tracking-normal leading-4">Actions</p>
                    </th>
                </tr>
                </thead>
                <tbody x-data="{details:false,rowId:@entangle($rowShow)}">
                @foreach($campaigns as $campaign)
                    <tr class="border-b border-gray-300">

                        <td class="whitespace-no-wrap w-32 pl-5">
                            <p class="text-gray-800 dark:text-gray-100 font-normal text-left text-xs tracking-normal leading-4">{{ucfirst($campaign->name)}}</p>
                        </td>
                        <td class="whitespace-no-wrap w-32">
                            <p class="text-gray-800 dark:text-gray-100 font-normal text-left text-xs tracking-normal leading-4">{{Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$campaign->send_date.''.$campaign->send_time)->format('d/m/y H:i')}}</p>
                        </td>
                        <td class="whitespace-no-wrap w-32">
                            <p class="text-gray-800 dark:text-gray-100 font-normal text-left text-xs tracking-normal leading-4">{{$campaign->sender_id}}</p>
                        </td>
                        <td class="pl-4 whitespace-no-wrap  max-w-16">
                            <p class="text-gray-800 dark:text-gray-100 font-normal text-left word text-xs tracking-normal leading-4 break-words ">
                                <button data-popover-target="popover-default{{$campaign->id}}" type="button" class="text-primary-600   focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">View Message</button>
                            <div data-popover id="popover-default{{$campaign->id}}" role="tooltip" class="inline-block absolute invisible z-10 w-64 text-sm font-light text-gray-500 bg-white rounded-lg border border-gray-200 shadow-sm opacity-0 transition-opacity duration-300 dark:text-gray-400 dark:border-gray-600 dark:bg-gray-800">
                                <div class="py-2 px-3 bg-gray-100 rounded-t-lg border-b border-gray-200 dark:border-gray-600 dark:bg-gray-700">
                                    <h3 class="font-semibold text-gray-900 dark:text-white">Message Sent</h3>
                                </div>
                                <div class="py-2 px-3">
                                    <p> {{$campaign->message}}</p>
                                </div>
                                <div data-popper-arrow></div>
                            </div>
                            </p>
                        </td>
                        <td class="pl-4 whitespace-no-wrap w-32">
                            <p class="text-gray-800 dark:text-gray-100 font-normal text-left text-xs tracking-normal leading-4">{{$campaign->total_contacts}}</p>
                        </td>
                        <td class="pl-4 whitespace-no-wrap w-32">
                            <div class=" h-6 w-48 rounded-md flex items-center justify-center">
                            <span>

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
                                    @case ('importing')
                                        {{'Scheduling in progress'}}
                                        @break

                                    @default
                                    {{$campaign->status}}
                                        @break
                                @endswitch


                            </span>
                            </div>
                        </td>
                        <td class="pl-4 whitespace-no-wrap w-32">
                            <p class="text-gray-800 dark:text-gray-100 font-normal text-left text-xs tracking-normal leading-4">{{$campaign->contactsDeliveredTo()->count() .'/'.$campaign->total_contacts}} </p>
                        </td>
                        <td class="pl-4 whitespace-no-wrap w-32">
                            <p class="text-gray-800 dark:text-gray-100 font-normal text-left text-xs tracking-normal leading-4">{{$campaign->created_at->format('d/m/Y')}}</p>
                        </td>
                        <td class="pl-4 whitespace-no-wrap w-32">
                            <p class="text-gray-800 dark:text-gray-100 font-normal text-left text-xs tracking-normal leading-4">{{$campaign->updated_at->format('d/m/Y')}}</p>
                        </td>
                        <td class="pl-4 flex items-center align-middle pr-4 whitespace-no-wrap w-32 flex justify-between ">


{{--                            <a href="{{route('message.show',['domain' => session('domain'),$campaign->slug])}}" class="mt-2">--}}
{{--                                <svg fill="none" stroke="currentColor" class="w-5" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">--}}
{{--                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"></path>--}}
{{--                                </svg>--}}
{{--                            </a>--}}

                            @if($campaign->status !="importing")
                            <div>


                            <a data-tooltip-target="tooltip-results"   href="{{$isTLD ? route($prefix.'.campaigns.show',$campaign->id) : route('campaigns.show',['domain' => session('domain'),'id'=>$campaign->id])}}" class="mx-3 mt-2">
                                <svg fill="none" stroke="currentColor" stroke-width="1.5"  class="w-5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 010 3.75H5.625a1.875 1.875 0 010-3.75z"></path>
                                </svg>
                            </a>
                            <div id="tooltip-results" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                Results of this campaign
                                <div class="tooltip-arrow" data-popper-arrow></div>
                            </div>
                            </div>
                            <div>


                            <a data-tooltip-target="tooltip-clone"   href="{{$isTLD ? route($prefix.'.message.clone',['domain' => session('domain'),$campaign->slug]) : route('message.clone',['domain' => session('domain'),$campaign->slug])}}" class="mt-2">
                                <svg fill="none" stroke="currentColor" stroke-width="1.5" class="w-5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 01-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 011.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 00-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 01-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 00-3.375-3.375h-1.5a1.125 1.125 0 01-1.125-1.125v-1.5a3.375 3.375 0 00-3.375-3.375H9.75"></path>
                                </svg>
                            </a>
                            <div id="tooltip-clone" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                Copy this campaign
                                <div class="tooltip-arrow" data-popper-arrow></div>
                            </div>
                        </div>
                            <div>
                            <a data-tooltip-target="tooltip-delete"   wire:click="removeCampaign('{{$campaign->id}}')" class="mt-2 cursor-pointer">

                                <svg aria-hidden="true" fill="none" stroke="currentColor" class="w-5"  stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                            </a>

                            <div id="tooltip-delete" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                Delete this campaign
                                <div class="tooltip-arrow" data-popper-arrow></div>
                            </div>
                            </div>

                           @endif

                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>


    <div class="mx-auto container pt-8 flex justify-end sm:justify-end items-center">

        {{$campaigns->links()}}

    </div>
</div>
