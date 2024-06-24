<div>
    <x-slot name="header">
        <div class="flex w-full pl-3 sm:pl-6 pr-3 py-0 items-center justify-between  rounded-t">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight ">
                        {{ __('Groups') }}
                    </h2>
            <button id="updateUserButton"  onclick="openNav()"  class="ml-0 sm:ml-6 bg-dbfb2 transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-dbfb1 hover:bg-dbfb1 rounded text-white px-5 h-8 flex items-center text-sm" >Create Contact</button>


        </div>


    </x-slot>


    <div class="grid {{$this->classes}}">
        {{--        Groups List        --}}
        <div class="col-span-1 min-h-screen">
            <div class="w-full bg-white p-4">
                <label for="website-admin" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Find Group</label>
                <div class="flex items-stretch">
                    <input wire:model="search"  type="text" id="website-admin" class="rounded-none  bg-gray-50 border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 px-2.5 mr-2  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">

                    <button id="updateUserButton"  class="ml-0 sm:ml-1 bg-dbfb2 transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-dbfb1 hover:bg-dbfb1 rounded text-white px-2 h-10 flex items-center text-sm h-full" data-modal-toggle="defaultModal">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        Group</button>

                </div>
            </div>





            <nav class="h-full overflow-y-auto max-h-screen bg-white" aria-label="Directory">


                @foreach($groups as $key=>$groupContent)


                    <div class="relative">
                        <div class="sticky top-0 z-10 border-t border-b border-gray-200 bg-gray-50 px-6 py-1 text-sm font-medium text-gray-500">
                            <h3>{{$key}}</h3>
                        </div>
                        <ul role="list" class="relative z-0 divide-y divide-gray-200">
                            @foreach($groupContent as $group)
                                @php
                                 $count =   $group->contacts()->count();
                                @endphp


                                <li class="{{$activeGroupId == $group->id ? 'bg-blue-50': 'bg-white'}}">

                                    <div class="relative items-center space-x-3 px-6 py-5 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-500 hover:bg-gray-50">

                                        <div class="flex justify-between">
                                            <div class="min-w-0 flex-1">
                                                <div wire:click="$emit('groupClick',{{$group->id}})" class="focus:outline-none">
                                                    <!-- Extend touch target to entire panel -->
                                                    <span class="absolute inset-0" aria-hidden="true"></span>
                                                    <p class="text-sm font-medium text-gray-900">{{$group->name}}</p>
                                                    <div class="flex lg:flex  justify-between items-center align-middle">
                                                        <span class="text-sm text-gray-500">Contacts: {{$count}} </span>




                                                    </div>


                                                </div>

                                            </div>
                                            <button class="p-2 border rounded h-full"  wire:click="deleteGroup('{{$group->id}}')"  style="z-index: 99999">
                                                <svg class="w-4 text-red-600 " fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"></path>
                                                </svg>
                                            </button>
                                        </div>



                                    </div>
                                </li>

                            @endforeach
                        </ul>
                    </div>

                @endforeach

            </nav>
        </div>
        @if(!$this->notable)

            <div class="mx-auto col-span-5 container px-3">
                <livewire:contact.contacts :header="false"  :groupSelected="$this->groupsContent"/>
            </div>



        @endif
    </div>



    <!-- Main modal -->
    <div wire:ignore id="defaultModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 p-4 w-full md:inset-0 h-modal md:h-full">
        <div class="relative w-full max-w-2xl h-full md:h-auto">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->

                <!-- Modal body -->
                <div class="p-6 space-y-6">
                    <div class="flex justify-between items-start p-2 rounded-t dark:border-gray-600">
                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="defaultModal">
                            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                       <div class="mx-auto col-span-5 w-full sm:max-w-4xl mb-10">
                            @if (session()->has('message'))
                                <div class="bg-indigo-600 max-w-screen-xl">
                                    <div class="mx-auto max-w-7xl py-3 px-3 sm:px-6 lg:px-8">
                                        <div class="flex flex-wrap items-center justify-between">
                                            <div class="flex w-0 flex-1 items-center">
                                                         <span class="flex rounded-lg bg-indigo-800 p-2">
                                                          <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.34 15.84c-.688-.06-1.386-.09-2.09-.09H7.5a4.5 4.5 0 110-9h.75c.704 0 1.402-.03 2.09-.09m0 9.18c.253.962.584 1.892.985 2.783.247.55.06 1.21-.463 1.511l-.657.38c-.551.318-1.26.117-1.527-.461a20.845 20.845 0 01-1.44-4.282m3.102.069a18.03 18.03 0 01-.59-4.59c0-1.586.205-3.124.59-4.59m0 9.18a23.848 23.848 0 018.835 2.535M10.34 6.66a23.847 23.847 0 008.835-2.535m0 0A23.74 23.74 0 0018.795 3m.38 1.125a23.91 23.91 0 011.014 5.395m-1.014 8.855c-.118.38-.245.754-.38 1.125m.38-1.125a23.91 23.91 0 001.014-5.395m0-3.46c.495.413.811 1.035.811 1.73 0 .695-.316 1.317-.811 1.73m0-3.46a24.347 24.347 0 010 3.46" />
                                                          </svg>
                                                        </span>
                                                <p class="ml-3 truncate font-medium text-white">
                                                    <span class="md:hidden"> {{ session('message') }}</span>
                                                    <span class="hidden md:inline"> {{ session('message') }}</span>
                                                </p>
                                            </div>
                                            <div class="order-3 mt-2 w-full flex-shrink-0 sm:order-2 sm:mt-0 sm:w-auto">
                                                <a href="#" class="flex items-center justify-center rounded-md border border-transparent bg-white px-4 py-2 text-sm font-medium text-indigo-600 shadow-sm hover:bg-indigo-50">Learn more</a>
                                            </div>
                                            <div class="order-2 flex-shrink-0 sm:order-3 sm:ml-3">
                                                <button type="button" class="-mr-1 flex rounded-md p-2 hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-white sm:-mr-2">
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
                                <div>
                                    <div>
                                    </div>
                                    <div class="text-center">
                                        <svg  class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"></path></svg>
                                        <h2 class="mt-2 text-lg font-medium text-gray-900">Select or create a group</h2>
                                        <p class="mt-1 text-sm text-gray-500">Groups of contacts are used for sending targeted messages.</p>
                                    </div>
                                    <form class="mt-6 sm:flex sm:items-center" wire:submit.prevent="saveNewGroup">
                                        <label for="newgroup" class="sr-only">New Group Name</label>
                                        <div class="relative rounded-md shadow-sm sm:min-w-0 sm:flex-1">
                                            <input wire:model="newGroupName" type="text" name="newgroup" id="newgroup" class="block w-full rounded-md border-gray-300 pr-32 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="New Group Name">
                                        </div>
                                        <div class="mt-3 sm:mt-0 sm:ml-4 sm:flex-shrink-0">
                                            <button data-modal-toggle="defaultModal"  type="submit" class="block w-full rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-center text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Save Group</button>
                                        </div>
                                    </form>
                                    @error('newGroupName') <span class="error">{{ $message }}</span> @enderror
                                </div>
                            </div>


                </div>
                <!-- Modal footer -->

            </div>
        </div>
    </div>
</div>


