<div >
    {{--        Tempalate List        --}}
    <div>
        <div class="sm:hidden">
            <label for="tabs" class="sr-only">Select a tab</label>
            <!-- Use an "onChange" listener to redirect the user to the selected tab URL. -->
            <select id="tabs" name="tabs" class="block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                <option>System Templates</option>
                <option>User Templates</option>
            </select>
        </div>
        <div class="hidden sm:block">
            <div class="border-b border-gray-200 bg-white pb-3" x-data="{system:false,user:true}">
                <nav class="-mb-px flex space-x-2 text-center mx-auto" aria-label="Tabs" >
                    <!-- Current: "border-indigo-500 text-indigo-600", Default: "border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-200" -->

                    <a @click="system = true , user = false" href="#/"  class="text-gray-900 rounded-l-lg group relative min-w-0 flex-1 overflow-hidden bg-white py-4 px-4 text-center text-sm font-medium hover:bg-gray-50 focus:z-10" aria-current="page">
                        <span> System Templates</span>

                        <span x-show="system"  aria-hidden="true" class="bg-dbfb2 absolute inset-x-0 bottom-0 h-0.5"></span>

                    </a>

                    <a @click="user = true , system = false" href="#/" class="text-gray-900 rounded-l-lg group relative min-w-0 flex-1 overflow-hidden bg-white py-4 px-4 text-center text-sm font-medium hover:bg-gray-50 focus:z-10" aria-current="page">
                        <span>User  Templates</span>

                        <span x-show="user"  aria-hidden="true" class="bg-dbfb2  absolute inset-x-0 bottom-0 h-0.5"></span>
                    </a>



{{--                    <a @click="system = true , user = false" href="#/" :class="system ?  'bg-white text-gray-900' :'bg-white text-base' " class="w-1/2 pl-4  text-center mx-auto border-transparent hover:border-gray-200 flex py-4 px-1 border-b-2 font-medium text-sm">--}}
{{--                        System Templates--}}
{{--                        <span class=""  :class="system ?  'bg-indigo-500 absolute inset-x-0 bottom-0 h-0.5' :'' "></span>--}}
{{--                        <span x-show="system"  aria-hidden="true" class="bg-indigo-500 absolute inset-x-0 bottom-0 h-0.5"></span>--}}

{{--                    </a>--}}

{{--                    <a  @click="system = false , user = true" href="#/"  :class="user ?  'bg-white text-gray-900' :'bg-gray-300 text-white' " class="w-1/2 pl-4  text-center mx-auto border-transparent hover:border-gray-200 flex py-4 px-1 border-b-2 font-medium text-sm">--}}
{{--                        User  Templates--}}
{{--                        <span class="bg-indigo-500 absolute inset-x-0 bottom-0 h-0.5 "></span>--}}
{{--                        <span x-show="user"  aria-hidden="true" class="bg-indigo-500 absolute inset-x-0 bottom-0 h-0.5"></span>--}}

{{--                    </a>--}}



                </nav>

                <div x-show="system" class="col-span-1 min-h-screen">
                    <div class="w-full bg-white p-4">
                        <label for="website-admin" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Search System Templates</label>
                        <div class="flex">
                            <input wire:model="search"  type="text" id="website-admin" class="rounded-none  bg-gray-50 border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search templates">

                        </div>
                    </div>
                    <nav class="h-full overflow-y-auto max-h-screen bg-white" aria-label="Directory">
                        <div class=" min-h-[900px] p-5">
                            <div class="mx-auto max-w-full">
                                <ul role="list" class="mt-6 divide-y divide-gray-200 border-t border-b border-gray-200">
                                    @foreach($templates as $key=>$template)
                                        <li class="cursor-pointer">
                                            <div class="group relative flex items-start space-x-3 py-4">
                                                <div class="flex-shrink-0">
                                  <span class="inline-flex items-center justify-center h-10 w-10 rounded-lg bg-pink-500">
                                    <!-- Heroicon name: outline/megaphone -->
                                    <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                    <path strokelinecap="round" strokelinejoin="round" strokewidth="{2}" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path> </svg>
                                  </span>
                                                </div>
                                                <div class="min-w-0 flex-1">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        <a href="#/"  wire:click="addTemplate('template','{{$key}}')">
                                                            <span class="absolute inset-0" aria-hidden="true"></span>
                                                            <span class="uppercase"> {{$key}}</span>
                                                        </a>
                                                    </div>

                                                </div>
                                                <div class="flex-shrink-0 self-center">
                                                    <!-- Heroicon name: mini/chevron-right -->
                                                    <svg class="h-5 w-5 text-gray-400 group-hover:text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                        <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                                                    </svg>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                                <div class="mt-6 flex">

                                </div>
                            </div>

                        </div>
                    </nav>

                </div>

                <div x-show="user" class="col-span-1 min-h-screen">
                    <div class="w-full bg-white p-4">
                        <label for="website-admin" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Search User Templates</label>
                        <div class="flex">
                            <input wire:model="search"  type="text" id="website-admin" class="rounded-none  bg-gray-50 border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search templates">
                        </div>
                    </div>
                    <nav class="h-full overflow-y-auto max-h-screen bg-white" aria-label="Directory">
                        <div class=" min-h-[900px] p-5">
                            <div class="mx-auto max-w-lg">
                                <ul role="list" class="mt-6 divide-y divide-gray-200 border-t border-b border-gray-200">
                                    @foreach($companyTemplates as $key=>$template)
                                        <li class="">
                                            <div class="group relative flex items-start space-x-3 py-4">
                                                <div class="flex-shrink-0">
                                  <span class="inline-flex items-center justify-center h-10 w-10 rounded-lg bg-pink-500">
                                    <!-- Heroicon name: outline/megaphone -->
                                    <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                    <path strokelinecap="round" strokelinejoin="round" strokewidth="{2}" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path> </svg>
                                  </span>
                                                </div>
                                                <div class="min-w-0 flex-1">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        <a href="#/" wire:click="addTemplate('company','{{$key}}')">
                                                            <span class="absolute inset-0" aria-hidden="true"></span>
                                                            <span class="uppercase"> {{$template->name}}</span>
                                                        </a>
                                                    </div>
                                                    <div class="flex sm:flex-col  md:justify-between">
                                                        <span class="text-sm">Characters {{$template->characters}}</span>
                                                        <span class="text-sm">Messages {{$template->message_count}}</span>
                                                    </div>
                                                </div>
                                                <div class="flex-shrink-0 self-center">
                                                    <!-- Heroicon name: mini/chevron-right -->
                                                    <svg class="h-5 w-5 text-gray-400 group-hover:text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                        <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                                                    </svg>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>

                            </div>

                        </div>
                    </nav>

                </div>

            </div>
        </div>
    </div>



</div>
