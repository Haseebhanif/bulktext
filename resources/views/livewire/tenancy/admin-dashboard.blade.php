<div class="px-4 sm:px-6 lg:px-8" x-data="{newTenant:@entangle('modal'),tenantUsers:@entangle('modalUser'),reports:@entangle('reports')}">
    <div class="sm:flex sm:items-center">
        <div class="sm:flex-auto">
            <h1 class="text-xl font-semibold text-gray-900">Tenancy Management</h1>
            <p class="mt-2 text-sm text-gray-700"> A list of all the tenancies used.</p>
        </div>
        <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
            <button id="createUserButton" wire:click="newTenant"  class="inline-flex items-center justify-center rounded-md border border-transparent bg-dbfb2 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto">New Tenant</button>
        </div>
    </div>

    <div class="mt-8 flex flex-col">

        <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">

            <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                <div class="my-6 flex justify-between">
                    <button wire:click="$set('reports', true)"  class="inline-flex items-center justify-center rounded-md border border-transparent bg-dbfb1 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto">Exports</button>

                    <div class="w-full   md:w-2/3 flex flex-col md:flex-row items-start md:items-center justify-end">
                        <div class="flex items-center border-gray-200 border rounded bg-white mt-3 md:mt-0">
                            <div>
                                <select wire:model="perPage" id="location" name="location" class="mt-1 block w-[100px] border-0 py-2 pl-3 pr-10 text-base   sm:text-sm">
                                    <option> 10</option>
                                    <option >25</option>
                                    <option> 50</option>
                                    <option>100</option>
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="flex flex-col w-full sm:w-1/2 md:ml-4 mt-3 md:mt-0 bg-white">
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
                            <input wire:model="search"  id="search" class="w-full text-gray-600 bg-transparent dark:bg-gray-800 dark:text-gray-400 focus:outline-none focus:border focus:border-indigo-700 font-normal pl-8 pr-24 h-10 flex items-center text-sm border-gray-300 dark:border-gray-200 rounded border" placeholder="Search " />
                        </div>
                    </div>
                </div>

                <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">

                <table class="min-w-full divide-y divide-gray-300">
        <thead class="bg-gray-50">
        <tr>
            <th  scope="col" class="whitespace-nowrap py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Logo</th>
            <th wire:click="order('tenant_name')" scope="col" class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900">Tenant</th>
            <th wire:click="order('min_credit_rate')" scope="col" class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900">Credit Rate</th>
            <th  scope="col" class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900">Created</th>


            <th scope="col" class="relative whitespace-nowrap py-3.5 pl-3 pr-4 sm:pr-6">
                <span class="sr-only">Edit</span>
            </th>
        </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 bg-white">
        @foreach($tenants as $tenant)
            <tr class="{{$tenant->status == 'pending' ? 'bg-yellow-200':''}} {{$tenant->status == 'suspended' ? 'bg-red-100':''}}">
                <td class="whitespace-nowrap py-2 pl-4 pr-3 text-sm text-gray-500 sm:pl-6">

                    @if($tenant->logo)
                     <img src="/{{$tenant->logo ?? 'noimage.jpg'}}" class="block h-9 w-auto mx-4">
                    @else
                        NO LOGO
                    @endif
                </td>
                <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-900 flex flex-col">
                   <span>
                       {{$tenant->tenant_name}}
                   </span>
                    <span>
                        {{'https://'.$tenant->domain.'.'.env('DOMAIN')}}</span>
                </td>

                <td class="whitespace-nowrap px-2 py-2 text-sm text-gray-500">{{$tenant->min_credit_rate}}</td>
                <td class="whitespace-nowrap px-2 py-2 text-sm text-gray-500">{{$tenant->created_at->format('d-m-Y H:i')}}</td>
                <td class="relative whitespace-nowrap py-2 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                    <a href="#" class="text-indigo-600 mr-3 hover:text-indigo-900" wire:click="edit('{{$tenant->id}}')">Edit</a>
                    <a href="#" class="text-indigo-600 hover:text-indigo-900" wire:click="users('{{$tenant->id}}')">Users</a>
                </td>
            </tr>
        @endforeach
        <!-- More transactions... -->
        </tbody>
    </table>


</div>
        <div class="my-3">
            {{$tenants->links()}}
        </div>
            </div>
        </div>
    </div>




    @if($tenant)
    <div x-cloak x-show="newTenant" class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-50 "></div>
        <div class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pt-5 pb-4 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6">

                        <!-- Modal body -->
                        <form wire:submit.prevent="submit">
                            <div class="grid gap-4 mb-4 sm:grid-cols-2">


                                <div>
                                    <label for="tenant_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tenant Name</label>
                                    <input wire:model="tenant.tenant_name" type="text" name="tenant_name" id="tenant_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="John" required="">
                                    @error('tenant.tenant_name') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label for="domain" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Domain</label>
                                    <input wire:model="tenant.domain" onkeyup="forceLower(this);"   autocapitalize="none" type="text" name="domain" id="domain" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="John" required="">
                                    @error('tenant.domain') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label for="Company" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Company Name</label>
                                    <input wire:model="tenant.company_name" type="text" name="Company" id="domain" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="John" required="">
                                    @error('tenant.company_name') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label for="rate" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Rate</label>
                                    <input wire:model="tenant.min_credit_rate" type=""  name="rate" id="rate" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="0.00" required="">
                                    @error('tenant.min_credit_rate') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label for="location" class="block text-sm font-medium text-gray-700">Status</label>
                                    <select wire:model="tenant.status" id="location" name="location" class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                                        <option {{$tenant->status == 'active' ? 'selected':''}} >active</option>
                                        <option {{$tenant->status == 'pending' ? 'selected':''}} >pending</option>
                                        <option {{$tenant->status == 'suspended' ? 'selected':''}} >suspended</option>
                                    </select>
                                </div>

                            </div>
                            <div class="flex items-center space-x-4">
                                <button type="button"  wire:click="discard()"  class="w-full inline-flex justify-center  bg-red-600 text-white items-center cursor-pointer  hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-primary-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                                    Discard
                                </button>
                                <button  class="w-full text-white inline-flex items-center justify-center bg-dbfb2 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                                    <svg class="-ml-1 w-5 h-5 sm:mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                                    Save
                                </button>

                            </div>
                        </form>

                </div>
            </div>
        </div>
    </div>
@endif


    @if($tenant)
        <div x-cloak x-show="tenantUsers" class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-50" wire:click="$set('modalUser',false)"></div>
            <div class="fixed inset-0 z-10 overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pt-5 pb-4 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-4xl sm:p-6">

                        <!-- Modal body -->
                        <div>
                            <div class="grid gap-4 mb-4 sm:grid-cols-1">
                                <div class="px-4 sm:px-6 lg:px-8">

                                    <div class="mt-8 flow-root">
                                        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                                                <div class="relative">
                                                    <!-- Selected row actions, only show when rows are selected. -->
                                                    <!-- <div class="absolute top-0 left-14 flex h-12 items-center space-x-3 bg-white sm:left-12"> -->
                                                    <!--   <button type="button" class="inline-flex items-center rounded bg-white px-2 py-1 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 disabled:cursor-not-allowed disabled:opacity-30 disabled:hover:bg-white">Bulk edit</button> -->
                                                    <!--   <button type="button" class="inline-flex items-center rounded bg-white px-2 py-1 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 disabled:cursor-not-allowed disabled:opacity-30 disabled:hover:bg-white">Delete all</button> -->
                                                    <!-- </div> -->

                                                    <table class="min-w-full table-fixed divide-y divide-gray-300">
                                                        <thead>
                                                        <tr>
                                                            <th scope="col" class="min-w-[12rem] py-3.5 pr-3 text-left text-sm font-semibold text-gray-900">Name</th>
                                                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Email</th>
                                                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Portal Admin</th>
                                                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Global Admin</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody class="divide-y divide-gray-200 bg-white">

                                                        @foreach($tenantUsers as $key=>$user)


                                                            <!-- Selected: "bg-gray-50" -->
                                                            <tr >

                                                                <td class="whitespace-nowrap py-4 pr-3 text-sm font-medium text-gray-900">{{$user['name']}}</td>
                                                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"> {{$user['email']}}</td>

                                                                <td class="whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-3">
                                                                    <label class="relative inline-flex items-center mb-5 cursor-pointer">
                                                                        <input {{$user['is_portal'] ? 'checked':null}} type="checkbox" type="checkbox" wire:change="submitUsers('{{$key}}-portal')" value="" class="sr-only peer">
                                                                        <div class="w-9 h-5 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                                                                    </label>

                                                                </td>
                                                                <td class="relative px-7 sm:w-12 sm:px-6">
                                                                    <label class="relative inline-flex items-center mb-5 cursor-pointer" >
                                                                        <input {{$user['is_global'] ? 'checked':null}} type="checkbox" wire:change="submitUsers('{{$key}}-global')" value="" class="sr-only peer">
                                                                        <div class="w-9 h-5 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                                                                    </label>

                                                                </td>

                                                            </tr>


                                                        @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </div>

                            <div class="flex items-center space-x-4">
                                <button type="button"  wire:click="discard()"  class="w-full inline-flex justify-center  bg-red-600 text-white items-center cursor-pointer  hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-primary-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                                    Discard
                                </button>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    @endif

    <div x-cloak x-show="reports" class="relative z-50" aria-labelledby="slide-over-title" role="dialog" aria-modal="true">
        <!-- Background backdrop, show/hide based on slide-over state. -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-50 "></div>


        <div class="fixed inset-0 overflow-hidden">
            <div class="absolute inset-0 overflow-hidden">
                <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10 sm:pl-16">
                    <div class="pointer-events-auto w-screen max-w-md">
                        <form class="flex h-full flex-col divide-y divide-gray-200 bg-white shadow-xl">
                            <div class="h-0 flex-1 overflow-y-auto">
                                <div class="bg-indigo-700 py-6 px-4 sm:px-6">
                                    <div class="flex items-center justify-between">
                                        <h2 class="text-lg font-medium text-white" id="slide-over-title">Report Exports</h2>
                                        <div class="ml-3 flex h-7 items-center">
                                            <button wire:click="$set('reports', false)" type="button" class="rounded-md bg-indigo-700 text-indigo-200 hover:text-white focus:outline-none focus:ring-2 focus:ring-white">
                                                <span class="sr-only">Close panel</span>
                                                <!-- Heroicon name: outline/x-mark -->
                                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="mt-1">
                                        <p class="text-sm text-indigo-300">Select a date range and select the required report</p>
                                    </div>
                                </div>
                                <div class="flex flex-1 flex-col justify-between">
                                    <div class="divide-y divide-gray-200 px-4 sm:px-6">
                                        <div class="space-y-6 pt-6 pb-5">

                                            <div>
                                                <div class="mt-1 border-2 rounded-xl p-2 border-gray-700">
                                                <livewire:partials.date-range/>
                                                </div>
                                            </div>



                                            <div>   <h2 class="text-lg font-medium text-black" id="slide-over-title pb-5 mb-5">Exports Downloads</h2>
                                                <div class="mt-6 flow-root h-full overflow-y-auto">
                                                    <div class="relative">
                                                     <ul role="list" class="-my-5 divide-y divide-gray-200 ">

                                                        <li class="py-4">
                                                            <div class="flex items-center space-x-4">

                                                                <div class="min-w-0 flex-1">
                                                                    <p class="truncate text-sm font-medium text-gray-900">SMS Sent</p>
                                                                    <p class="truncate text-sm text-gray-500">All SMS From selected date range</p>
                                                                </div>
                                                                @if($to)
                                                                    <div>
                                                                        <a wire:click="exportDate('SMS_SENT')" class="inline-flex items-center rounded-full border border-gray-300 bg-white px-2.5 py-0.5 text-sm font-medium leading-5 text-gray-700 shadow-sm hover:bg-gray-50">Download</a>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </li>

                                                        <li class="py-4">
                                                             <div class="flex items-center space-x-4">

                                                                 <div class="min-w-0 flex-1">
                                                                     <p class="truncate text-sm font-medium text-gray-900">All Credits Purchases</p>
                                                                     <p class="truncate text-sm text-gray-500">Credits Purchased & customer details</p>
                                                                 </div>
                                                                 <div>
                                                                     @if($to)
                                                                         <div>
                                                                             <a wire:click="exportDate('CREDITS')" class="inline-flex items-center rounded-full border border-gray-300 bg-white px-2.5 py-0.5 text-sm font-medium leading-5 text-gray-700 shadow-sm hover:bg-gray-50">Download</a>
                                                                         </div>
                                                                     @endif
                                                                 </div>
                                                             </div>
                                                         </li>

                                                    </ul>
                                                    </div>

                                                </div>
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
    </div>
    <script>
        function forceLower(strInput)
        {
            strInput.value=strInput.value.toLowerCase();
        }
    </script>
</div>
