<div x-data="{group:false,sidebar:@entangle('companyInfo'), modalOpen: @entangle('modalOpen') }"
         @keydown.escape.window="modalOpen = false"
         class="relative w-auto h-auto">
    <x-slot name="header">

        <div class="flex w-full pl-3 sm:pl-6 pr-3 py-0 items-center justify-between  rounded-t">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('All Companies') }}
            </h2>

            <a class="px-2 py-1 bg-dbfb2 text-white rounded" href="{{$isTLD ?route($prefix.'.portal.branding',['domain'=>session('domain')]) : route('portal.branding',['domain'=>session('domain')])}}">
                     Portal Settings
            </a>
        </div>
    </x-slot>
    <div class="container mx-auto my-3">
        <dl class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-3">
            <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
                <dt class="truncate text-sm font-medium text-gray-500">Total Companies</dt>
                <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">{{$companies->total()}}</dd>

            </div>

{{--            <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">--}}
{{--                <dt class="truncate text-sm font-medium text-gray-500">Last 30 days</dt>--}}
{{--                <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">0%</dd>--}}
{{--                <span class="text-sm">Compared to the previous 30 days</span>--}}
{{--            </div>--}}

{{--            <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">--}}
{{--                <dt class="truncate text-sm font-medium text-gray-500">Total Sent</dt>--}}
{{--                <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">0</dd>--}}
{{--                <span class="text-sm">7 day period</span>--}}
{{--            </div>--}}
        </dl>
    </div>



    <div class="mx-auto container bg-white dark:bg-gray-800 shadow rounded my-6">

        <div class="flex flex-col md:flex-row p-3 justify-between items-start md:items-stretch w-full">
            <div class="w-full md:w-1/3 flex flex-col md:flex-row items-start md:items-center">

            </div>
            <div class="w-full  flex flex-col md:flex-row items-start md:items-center justify-end">
                <div class="flex items-center border-gray-200 border rounded mt-3 md:mt-0">
                    <div>
                        <select wire:model="perPage" id="location" name="location" class="mt-1 block w-[100px] border-0 py-2 pl-3 pr-10 text-base   sm:text-sm">
                            <option>5</option>
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
                        <input wire:model="search"  id="search" class="w-full text-gray-600 bg-transparent dark:bg-gray-800 dark:text-gray-400 focus:outline-none focus:border focus:border-indigo-700 font-normal pl-8 pr-24 h-10 flex items-center text-sm border-gray-300 dark:border-gray-200 rounded border" placeholder="Search by customer" />
                    </div>

                </div>
            </div>
        </div>
        <div class="w-full overflow-x-scroll xl:overflow-x-hidden min-h-[50vh]">

            <table class="min-w-full bg-white dark:bg-gray-800 rounded border border-gray-300" id="main-table">
                <thead>
                <tr class="w-full bg-gray-100 dark:bg-gray-700 border-b border-gray-300">
                    <th role="columnheader" class="pl-3 w-24 py-3">
                        <div class="flex items-center">
                           <div class="opacity-0 cursor-defaut ml-4 text-gray-800 dark:text-gray-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-up" width="16" height="16" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" />
                                    <polyline points="6 15 12 9 18 15" />
                                </svg>
                            </div>
                        </div>
                    </th>
                    <th role="columnheader"  class="whitespace-no-wrap w-32 first-dropdown cursor-pointer" wire:click="reorder('company_name')">
                        <div class="flex items-center justify-between relative chuss-div">
                            <p class="text-gray-800 dark:text-gray-100 font-normal text-left text-xs tracking-normal leading-4">Company</p>
                            <button  role="button" aria-label="option" class="cursor-pointer  mr-3 text-gray-800 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-400 rounded">
                              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 dark:hidden">
         <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
   </svg>
                            </button>

                        </div>
                    </th>
                    <th role="columnheader" class="border-l border-gray-300 pl-4 whitespace-no-wrap w-32 " >
                        <div class="flex items-center justify-between relative">
                            <p class="text-gray-800 dark:text-gray-100 font-normal text-left text-xs tracking-normal leading-4">Total Departments</p>
                        </div>
                    </th>
                    <th role="columnheader" class="border-l border-gray-300 pl-4 whitespace-no-wrap w-32 " >
                        <div class="flex items-center justify-between relative">
                            <p class="text-gray-800 dark:text-gray-100 font-normal text-left text-xs tracking-normal leading-4">Total Company Credits</p>
                        </div>
                    </th>

{{--                    <th role="columnheader" class="border-l border-gray-300 pl-4 whitespace-no-wrap w-32 first-dropdown cursor-pointer" wire:click="reorder('status')">--}}
{{--                        <div class="flex items-center justify-between relative">--}}
{{--                            <p class="text-gray-800 dark:text-gray-100 font-normal text-left text-xs tracking-normal leading-4">Status</p>--}}
{{--                            <button role="button" aria-label="option" class="cursor-pointer  mr-3 text-gray-800 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-400 rounded">--}}
{{--                                <img class="dark:hidden" src="https://tuk-cdn.s3.amazonaws.com/can-uploader/advance_table_with_filters%2C_actions%2C_search%2C_sort_and_expanded_row-svg8.svg" alt="down">--}}
{{--                                <img class="dark:block hidden" src="https://tuk-cdn.s3.amazonaws.com/can-uploader/advance_table_with_filters%2C_actions%2C_search%2C_sort_and_expanded_row-svg8dark.svg" alt="down">--}}
{{--                            </button>--}}
{{--                        </div>--}}
{{--                    </th>--}}
                    <th role="columnheader" class="border-l border-gray-300 pl-4 whitespace-no-wrap w-32 first-dropdown cursor-pointer" wire:click="reorder('message_rate')">
                        <div class="flex items-center justify-between relative">
                            <p class="text-gray-800 dark:text-gray-100 font-normal text-left text-xs tracking-normal leading-4 ">Credit Rate</p>
                            <button role="button" aria-label="option" class="cursor-pointer  mr-3 text-gray-800 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-400 rounded">
                              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 dark:hidden">
         <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
   </svg>
                            </button>
                        </div>
                    </th>
                    <th role="columnheader" class="border-l border-gray-300 pl-4 whitespace-no-wrap w-32 ">
                        <div class="flex items-center justify-between relative">
                            <p class="text-gray-800 dark:text-gray-100 font-normal text-left text-xs tracking-normal leading-4" wire:click="reorder('name')">Contact Name</p>
                            <button role="button" aria-label="option" class="cursor-pointer  mr-3 text-gray-800 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-400 rounded">
                              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 dark:hidden">
         <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
   </svg>
                            </button>
                        </div>
                    </th>
                    <th role="columnheader" class="border-l border-gray-300 pl-4 whitespace-no-wrap w-32 first-dropdown cursor-pointer" wire:click="reorder('email')">
                        <div class="flex items-center justify-between relative">
                            <p class="text-gray-800 dark:text-gray-100 font-normal text-left text-xs tracking-normal leading-4">Email</p>
                            <button role="button" aria-label="option" class="cursor-pointer  mr-3 text-gray-800 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-400 rounded">
                              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 dark:hidden">
         <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
   </svg>
                            </button>
                        </div>
                    </th>
                    <th role="columnheader" class="border-l border-gray-300 pl-4 whitespace-no-wrap w-32 first-dropdown cursor-pointer"  wire:click="reorder('updated_at')">
                        <div class="flex items-center justify-between relative">
                            <p class="text-gray-800 dark:text-gray-100 font-normal text-left text-xs tracking-normal leading-4">Created</p>
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
                @foreach($companies as $company)

                    <tr class="border-b border-gray-300" >
                        <td class="pl-3 w-24 py-3">
                            <div class="flex items-center">
                               <button @click="details = !details"  wire:click="activate({{$company['id']}})"  class="focus:outline-none focus:ring-2 focus:ring-gray-400 cursor-pointer text-gray-800 dark:text-gray-100 ml-2 lg:ml-4 mr-2 sm:mr-0 border border-transparent rounded focus:outline-none" aria-label="Toggle Details" role="button">
                              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
  <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
</svg>
 </button>
                            </div>
                        </td>
                        <td class="whitespace-no-wrap w-32">
                            <p class="text-gray-800 dark:text-gray-100 font-normal text-left text-xs tracking-normal leading-4">{{$company->company_name}} </p>
                        </td>
                        <td class="pl-4 whitespace-no-wrap w-32">
                            <p class="text-gray-800 dark:text-gray-100 font-normal text-center text-xs tracking-normal leading-4">{{$company->companyTeams()->count()}}</p>
                        </td>
                        <td class="pl-4 whitespace-no-wrap w-32">
                            <p class="text-gray-800 dark:text-gray-100 font-normal text-left text-xs tracking-normal leading-4">

                             {{$company->companyLevelCredits->sum('amount')}}
                            </p>
                        </td>
{{--                        <td class="pl-4 whitespace-no-wrap w-32 ">--}}
{{--                            <div class="{{$company->status == 'active' ? 'bg-blue-100' : 'bg-red-100'}} h-6 w-20 rounded-md flex items-center justify-center text-center">--}}
{{--                                <span class="text-xs {{$company->status == 'active' ? 'text-blue-700 ' : 'text-red-700 '}} font-normal text-center">{{$company->status == 'active' ? 'Active':$company->status}}</span>--}}
{{--                            </div>--}}
{{--                        </td>--}}

                        <td class="pl-4 whitespace-no-wrap w-32 ">
                            <p class="text-gray-800 dark:text-gray-100 font-normal text-left text-xs tracking-normal leading-4">
                                {{$company->credit_rate}}
                            </p>
                        </td>


                        <td class="pl-4 whitespace-no-wrap w-32">
                            <p class="text-gray-800 dark:text-gray-100 font-normal text-left text-xs tracking-normal leading-4">{{$company->companyCreator->name}}</p>
                        </td>

                        <td class="pl-4 whitespace-no-wrap w-32">
                            <p class="text-gray-800 dark:text-gray-100 font-normal text-left text-xs tracking-normal leading-4">{{$company->companyCreator->email}}</p>
                        </td>

                        <td class="pl-4 whitespace-no-wrap w-32">
                            <p class="text-gray-800 dark:text-gray-100 font-normal text-left text-xs tracking-normal leading-4">{{$company->created_at->format('d/m/Y')}}</p>
                        </td>

                        <td class="pl-4 pr-4 whitespace-no-wrap w-52">

                            <div class="relative text-center flex flex-row justify-between gap-4" x-data="{open:false}">

                                <a href="
                                {{$isTLD ? route($prefix.'.portal.company.manage',[$company->creator_id]) : route('portal.company.manage',[$domain,$company->creator_id])}}"
                                   class=" hidden lg:block  text-sm border w-2/3 p-1 bg-dbfb2 text-white rounded-lg ">
                                    Manage Company
                                </a>


                                    <button  wire:click="selectedDeleteId('{{$company->id}}')"  type="button" class=" hidden lg:block  text-sm border bg-red-500 p-1 text-white rounded-lg ">
                                        <svg class="text-white w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" >
                                            <path  stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                        </svg>
                                    </button>



                                <a href=" {{$isTLD ?route($prefix.'.portal.company.manage',[$company->creator_id]) :  route('portal.company.manage',[$domain,$company->creator_id])}}"
                                   class=" lg:hidden mt-2 text-sm  p-2  text-center ">
                                    <svg class="w-4 h-4 text-dbfb2 " fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.343 3.94c.09-.542.56-.94 1.11-.94h1.093c.55 0 1.02.398 1.11.94l.149.894c.07.424.384.764.78.93.398.164.855.142 1.205-.108l.737-.527a1.125 1.125 0 011.45.12l.773.774c.39.389.44 1.002.12 1.45l-.527.737c-.25.35-.272.806-.107 1.204.165.397.505.71.93.78l.893.15c.543.09.94.56.94 1.109v1.094c0 .55-.397 1.02-.94 1.11l-.893.149c-.425.07-.765.383-.93.78-.165.398-.143.854.107 1.204l.527.738c.32.447.269 1.06-.12 1.45l-.774.773a1.125 1.125 0 01-1.449.12l-.738-.527c-.35-.25-.806-.272-1.203-.107-.397.165-.71.505-.781.929l-.149.894c-.09.542-.56.94-1.11.94h-1.094c-.55 0-1.019-.398-1.11-.94l-.148-.894c-.071-.424-.384-.764-.781-.93-.398-.164-.854-.142-1.204.108l-.738.527c-.447.32-1.06.269-1.45-.12l-.773-.774a1.125 1.125 0 01-.12-1.45l.527-.737c.25-.35.273-.806.108-1.204-.165-.397-.505-.71-.93-.78l-.894-.15c-.542-.09-.94-.56-.94-1.109v-1.094c0-.55.398-1.02.94-1.11l.894-.149c.424-.07.765-.383.93-.78.165-.398.143-.854-.107-1.204l-.527-.738a1.125 1.125 0 01.12-1.45l.773-.773a1.125 1.125 0 011.45-.12l.737.527c.35.25.807.272 1.204.107.397-.165.71-.505.78-.929l.15-.894z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </a>


                            </div>
                        </td>
                    </tr>


                    <tr class="detail-row"  style="{{$this->rowShow == $company->id ? '':'display:none;'}}">
                        <td colspan="9">
                            <div class="flex items-stretch w-full border-b border-gray-300 dark:border-gray-200">

                                <div class="w-full bg-white border-l border-gray-300 dark:bg-gray-800">
                                    <h4 class="pl-10 w-full text-sm text-gray-800 dark:text-gray-100 py-3 bg-gray-100 dark:bg-gray-700">{{$company->fullName}}</h4>

                                    <div class="bg-white dark:bg-gray-800 px-8 py-6">
                                        <div class="flex items-start">
                                            <div class="w-1/4">
                                                <p class="text-gray-600 dark:text-gray-400 font-normal text-xs">Main Contact</p>
                                                <h5 class="text-gray-800 dark:text-gray-100 font-normal text-xs">{{$company->companyCreator->name}}</h5>
                                            </div>
{{--                                            <div class="w-1/4">--}}
{{--                                                <p class="text-gray-600 dark:text-gray-400 font-normal text-xs">Status</p>--}}
{{--                                                <div class="{{$company->status == 'active' ? 'bg-blue-100' : 'bg-red-100'}} h-6 w-20 rounded-md flex items-center justify-center text-center">--}}
{{--                                                    <span class="text-xs {{$company->status == 'active' ? 'text-blue-700 ' : 'text-red-700 '}} font-normal text-center">{{$company->status == 'active' ? 'Active':$company->status}}</span>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
                                            <div class="w-1/4">
                                                <p class="text-gray-600 dark:text-gray-400 font-normal text-xs">Created</p>
                                                <h5 class="text-gray-800 dark:text-gray-100 font-normal text-xs">{{$company->created_at->format('d/m/Y H:i')}}</h5>
                                            </div>
                                            <div class="w-1/4">
                                                <div class="text-center">
                                                    <a wire:click="companySelect({{$company->id}})"class="mt-2 text-sm border p-2 bg-dbfb2 text-white rounded-lg cursor-pointer" data-drawer-target="drawer-form" data-drawer-show="drawer-form" aria-controls="drawer-form">
                                                        Edit Sender & Rate
                                                    </a>
                                                </div>


                                            </div>
                                        </div>

                                        <hr class="my-6 border-t border-gray-300 w-full" />
                                        <div class="flex justify-between">
                                            <h5 class="text-gray-600 dark:text-gray-400 text-xs mb-2 font-bold">Departments</h5>
                                            <h5 class="text-gray-600 dark:text-gray-400 text-xs mb-2 font-bold">Company Allocated Credits : {{$company->companyLevelCredits->sum('amount')}}</h5>
                                        </div>

                                        <div>
                                            <div class="mt-8 flex flex-col">
                                                <div class="-my-2 -mx-4 overflow-x-auto ">
                                                    <div class="inline-block min-w-full py-2 align-middle md:px-1 lg:px-1">
                                                        <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                                                            <table class="min-w-full divide-y divide-gray-300">
                                                                <thead class="bg-gray-50">
                                                                <tr>
                                                                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Dept Name</th>
                                                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Users</th>
                                                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Credits Available</th>
                                                                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                                                        <span class="sr-only">Access</span>
                                                                    </th>
                                                                </tr>
                                                                </thead>
                                                                <tbody class="divide-y divide-gray-200 bg-white">
                                                                @foreach($company->companyTeams as $team)
                                                                <tr>
                                                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">{{$team->name}}  </td>
                                                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{$team->allUsers()->count()}}</td>
                                                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{$team->credits->amount}}</td>
                                                                    <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
{{--                                                                        @if(Auth::user()->belongsToTeam($team))--}}

{{--                                                                            <a wire:click="viewTeamRemove({{$team->id}})" href="#/" class="text-indigo-600 hover:text-indigo-900">Remove Shortcut<span class="sr-only"></span></a>--}}
{{--                                                                            @else--}}
{{--                                                                          --}}
{{--                                                                        @endif--}}
{{--                                                                            <a href="{{route('portal.company.manage',[$domain,$team->owner])}}" class="text-indigo-600 hover:text-indigo-900">Access<span class="sr-only"></span></a>--}}

                                                                    </td>
                                                                </tr>
                                                                @endforeach

                                                                <!-- More people... -->
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <hr class="my-6 border-t border-gray-300 w-full" />
{{--                                        <h5 class="text-gray-600 dark:text-gray-400 text-xs mb-2 font-bold">Contact Notes</h5>--}}
                                        {{--                                        <p class="text-gray-800 dark:text-gray-100 font-normal text-xs w-3/5 leading-6">But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system, and expound the actual teachings of the great explorer of the truth, the master-builder of human happiness. No one rejects, dislikes, or avoids pleasure itself, because it is pleasure, but because those who do not know how to pursue pleasure rationally encounter consequences that are extremely painful</p>--}}
                                        {{--                                        <h5 class="text-indigo-700 text-xs mb-2 mt-12 font-bold">Recommended Action</h5>--}}
                                        {{--                                        <p class="text-gray-800 dark:text-gray-100 font-normal text-xs w-3/5 leading-6">But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system, and expound the actual teachings of the great explorer of the truth, the master-builder of human happiness. No one rejects, dislikes, or avoids pleasure itself, because it is pleasure, but because those who do not know how to pursue pleasure rationally encounter consequences that are extremely painful</p>--}}
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>


    <div class="mx-auto container pt-8 flex justify-end sm:justify-end items-center">

        {{$companies->links()}}

    </div>


    <!-- drawer component -->
    <div x-show="sidebar" id="drawer-form" class="fixed z-50 h-screen p-4 overflow-y-auto bg-white w-80 dark:bg-gray-800 transition-transform left-0 top-0 -translate-x-full" tabindex="-1" aria-labelledby="drawer-form-label" aria-hidden="true" style="z-index: 999">
        <h5 id="drawer-label" class="inline-flex items-center mb-6 text-base font-semibold text-gray-500 uppercase dark:text-gray-400"><svg class="w-5 h-5 mr-2" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>Company Management</h5>

        <button wire:click="$set('companyInfo', false)" type="button" data-drawer-dismiss="drawer-form" aria-controls="drawer-form" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 absolute top-2.5 right-2.5 inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
            <span class="sr-only">Close menu</span>
        </button>

        <form wire:submit.prevent="rateUpdate" class="mb-6">

            <div class="mb-4">
                <label for="guests" class="mb-2 text-sm font-medium text-gray-900  dark:text-gray-300">Credit Min Rate <input readonly  wire:model="minRate" class="text-sm border-transparent focus:border-transparent focus:ring-0"/></label>
                <div class="relative">
                    <input wire:model="rate" id="guests" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0.00" required="">
                    <button type="submit" class="absolute inline-flex items-center px-3 py-1 text-sm font-medium text-white bg-blue-700 rounded-lg right-2 bottom-2 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Update
                    </button>
                </div>
            </div>
        </form>






        <form wire:submit.prevent="addSender" class="mb-6">

            <div class="mb-4">
                <label for="sender" class="mb-2 text-sm font-medium text-gray-900  dark:text-gray-300">Sender</label>
                <div class="relative">
                    <input wire:model="sender"  id="sender" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Sender Name" required="">
                    <button type="submit" class="absolute inline-flex items-center px-3 py-1 text-sm font-medium text-white bg-blue-700 rounded-lg right-2 bottom-2 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                       Add
                    </button>
                </div>
            </div>

        </form>


        @foreach($senders as $sender)
        @php
         $datework = \Carbon\Carbon::createFromDate($sender['created_at']);
         $now = \Carbon\Carbon::now();
          $testdate = $datework->diffInDays($now);
         @endphp

            <span class="inline-flex items-center rounded-full {{$testdate >=  1 ? 'bg-indigo-100 text-indigo-700':'bg-red-400 text-white' }} py-0.5 pl-2.5 pr-1 text-sm font-medium  m-2">
             {{$sender['sender_name']}}
              <button wire:click="removeSender('{{$sender['id']}}')" type="button" class="ml-0.5 inline-flex h-4 w-4 flex-shrink-0 items-center justify-center rounded-full text-indigo-400 hover:bg-indigo-200 hover:text-indigo-500 focus:bg-indigo-500 focus:text-white focus:outline-none">
                <span class="sr-only">remove tag {{$sender['sender_name']}}  </span>
                <svg class="h-2 w-2" stroke="currentColor" fill="none" viewBox="0 0 8 8">
                  <path stroke-linecap="round" stroke-width="1.5" d="M1 1l6 6m0-6L1 7" />
                </svg>
              </button>
            </span>
        @endforeach

        <div class="border-t min-w-full"></div>
            <h4 class="text-lg font-medium text-gray-900  dark:text-gray-300">Stripe Payment Details:</h4>

            <form wire:submit.prevent="stripeUpdate" class="mb-6">


                <div class="mb-4">
                    <label for="pk" class="mb-2 text-sm font-medium text-gray-900  dark:text-gray-300">Stripe Publishable Key</label>
                    <div class="relative">
                        <input wire:model="stripe.pk"  id="pk" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Sender Name" required="">
                    </div>
                </div>
                <div class="mb-4">
                    <label for="sk" class="mb-2 text-sm font-medium text-gray-900  dark:text-gray-300">Stripe Secret Key</label>
                    <div class="relative">
                        <input wire:model="stripe.sk"  id="sk" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Sender Name" required="">
                    </div>
                </div>

                <div class="mb-4">
                    <a href="https://stripe.com/docs/keys?locale=en-GB" target="_blank" class="underline">Information on stripe keys here</a>
                </div>

                <button type="submit" class="inline-flex items-center justify-center rounded-md border border-transparent bg-blue-700 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto">Save</button>
            </form>

    </div>



            <div x-show="modalOpen" class="fixed top-0 left-0 z-[99] flex items-center justify-center w-screen h-screen" x-cloak>
                <div x-show="modalOpen"
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="ease-in duration-300"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     @click="modalOpen=false"
                     class="absolute inset-0 w-full h-full bg-black bg-opacity-40"></div>
                <div x-show="modalOpen"
                     x-trap.inert.noscroll="modalOpen"
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     class="relative w-full py-6 bg-white px-7 sm:max-w-lg sm:rounded-lg">
                    <div class="flex items-center justify-between pb-2">
                        <h3 class="text-lg font-semibold">Confirm deletion of business.</h3>
                        <button wire:click="$set('modalOpen',false)" class="absolute top-0 right-0 flex items-center justify-center w-8 h-8 mt-5 mr-5 text-gray-600 rounded-full hover:text-gray-800 hover:bg-gray-50">
                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                        </button>
                    </div>
                    <div class="relative w-auto">

                        <form wire:submit.prevent="submitDelete" class="mb-6">


                            <div class="mb-4">
                                <label for="deleteName" class="block text-sm font-medium leading-6 text-gray-900">Please confirm the business name (case-sensitive)</label>
                                <div class="relative mt-2 rounded-md shadow-sm">

                                    <input wire:model.lazy="deleteName" name="deleteName" id="deleteName" class="block w-full rounded-md border-0 py-1.5 pl-5 pr-10 text-red-900 ring-1 ring-inset ring-red-300 placeholder:text-red-300 focus:ring-2 focus:ring-inset focus:ring-red-500 sm:text-sm sm:leading-6" placeholder="Business name" aria-invalid="true" aria-describedby="email-error">
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                        <svg class="h-5 w-5 text-red-500" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                                        </svg>
                                    </div>

                                </div>
                                <p class="mt-2 text-xs text-red-600" id="email-error">Warning users accessing this business will no longer have access.</p>
                                @error('deleteName') <span class="error">{{ $message }}</span> @enderror
                            </div>

                            <button type="submit" class="bg-red-700 text-white  text-sm  px-2 py-1   rounded-lg" >DELETE</button>
                         </form>
                    </div>
                </div>
            </div>



</div>
