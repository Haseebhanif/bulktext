<div x-data="{step:@entangle('currentStep')}">

    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                @if($completeMessageInfo['id'])
                    {{ __('Editing Campaign:') }}   {{$completeMessageInfo['name']}}
                    @else
                {{ __('Create Campaign') }}
                    @endif
            </h2>
        </div>

    </x-slot>

    <div class=" px-3">
        <div class="lg:max-w-[1440px] md:max-w-[874px] max-w-[375px] mx-auto bg-white px-6 shadow-md rounded">
            <form wire:submit.prevent="sendMessage"class="p-8">

                <div class="grid gap-4 mb-4 lg:grid-cols-2 sm:mb-6">
                    <div class="space-y-4">
                        <div class="">
                            <label for="senders" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select a sender</label>
                            <select wire:model="completeMessageInfo.sender" @if(count($this->senders) == 0) disabled @endif required id="senders" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="0" selected></option>
                                @foreach($this->senders as $sender)
                                    <option value="{{$sender['id']}}">{{$sender['sender']}} (int:{{$sender['sender_id']}})</option>
                                @endforeach
                            </select>
                            @if(count($this->senders) == 0) <span class="text-red-500 text-xs">
                                A Sender ID is yet to be approved, Please contact via {{$branding->support_email ?? ''}}.</span> @endif
                        </div>

                        <div class="">
                            <label for="groups" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Contact Groups</label>
                            <select required wire:model="selectedGroup" wire:change="groupSelected" id="groups" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="0"  selected></option>
                                @foreach($this->groups as $group)
                                    <option value="{{$group->id}}">{{$group->name}} ({{$group->contacts_count}}) </option>
                                @endforeach

                            </select>
                        </div>

                        <div class=" border p-4 my-3">
                            <label for="mins" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Schedule Date & Time</label>

                            <div class="relative">
                                <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                    <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
                                </div>
                                <input id="dateSelector" wire:model="completeMessageInfo.date"   value=""  datepicker-format="dd-mm-yyyy"  datepicker type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select date">
                            </div>
                            <div class="flex justify-start">
                                <div class="lg:pt-12 md:pt-10 pt-5 pr-3 w-1/2">
                                    <label for="hours" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Hours</label>
                                    <select wire:model="completeMessageInfo.hour"   id="hours" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        @foreach($this->hours as $hour)
                                            <option value="{{$hour}}">{{$hour}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="lg:pt-12 md:pt-10 pt-5 w-1/2">
                                    <label for="mins" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Minutes</label>
                                    <select wire:model="completeMessageInfo.min"  id="mins" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        @foreach($this->mins as $min)
                                            <option value="{{$min}}">{{$min}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class=" border p-4 my-3 flex justify-between">

                            <div class="flex items-center pl-4 rounded border border-gray-200 dark:border-gray-700 w-full">
                                <input wire:click="optOutUpdate(true)" {{$completeMessageInfo['optOut'] ? 'checked':''}}  id="bordered-radio-1" type="radio" value="" name="bordered-radio" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="bordered-radio-1" class="py-4 ml-2 w-full text-sm font-medium text-gray-900 dark:text-gray-300">Include Opt-out</label>
                            </div>
                            <div class="flex items-center pl-4 rounded border border-gray-200 dark:border-gray-700 w-full">
                                <input wire:click="optOutUpdate(false)" {{!$completeMessageInfo['optOut'] ? 'checked':''}}  id="bordered-radio-2" type="radio" value="" name="bordered-radio" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="bordered-radio-2" class="py-4 ml-2 w-full text-sm font-medium text-gray-900 dark:text-gray-300">Remove Opt-out</label>
                            </div>

                        </div>

                    </div>

                    <div>
                        <div class="mb-5">
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white ">Campaign Name</label>
                            <div class="mt-1">
                                <input required wire:model="completeMessageInfo.name" type="text" name="name" id="name" class="block w-full rounded-md border-gray-300 bg-gray-50 p-2.5 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="campaign name">
                            </div>
                        </div>

                        <div class="flex justify-between">
                            <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Message  </label> <span class="text-sm font-medium text-gray-900 dark:text-white">  Characters: {{$count}} / {{$maxLength}} </span>

                        </div>
                        <div class="mb-4 w-full">
                            <input wire:model="messageHTML" type="hidden"/>

                            <textarea wire:model="message"
                                      wire:keydown.enter="addBreak"
                                      class="w-full min-h-[300px]" required></textarea>
                            @if($completeMessageInfo['optOut'])
                                <input type="text" wire:model="optOutmessage" class="w-full "></input>
                            @endif
                        </div>

                        <div class="flex justify-between py-2">
                            @if( $completeMessageInfo['editAllow'])
                                @if(count($completeMessageInfo['contacts']) > 0 )
                                    @if($totalCredits > Auth::user()->currentTeam->credits->amount )
                                        <div class="col-span-5  text-red-500  ">
                                            Not enough credits to send these messages
                                        </div>

                                        <button  type="submit" class="col-span-1  px-3 py-2 text-white transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-dbfb1 hover:bg-dbfb1 " style="background-color: #253369;">Save Draft Schedule</button>
                                    @else
                                        <div class="col-span-5"></div>

                                        <button type="submit" class="col-span-1  px-3 py-2 text-white transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-dbfb1 hover:bg-dbfb1 " style="background-color: #253369;">Schedule Message</button>

                                    @endif
                                @else
                                    <div class="col-span-6  text-red-500  ">
                                        No Contacts in group selected
                                    </div>
                                    <button disabled  type="submit" class="col-span-1  px-3 py-2 text-white transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-dbfb1 hover:bg-dbfb1 " style="background-color: #56669c;">Schedule Message</button>

                                @endif
                            @else
                                <div class="col-span-5  text-red-500  ">
                                    This campaign has expired!
                                </div>
                                    <button   type="submit" class="col-span-1  px-3 py-2 text-white transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-dbfb1 hover:bg-dbfb1 " style="background-color: #253369;">Reschedule Message</button>
                            @endif
                        </div>
                    </div>

                </div>
            </form>


            <div class="lg:flex justify-between md:block block">


            </div>

            <div class="py-5 border-t border-gray-200 dark:border-gray-700">

                <div class=" px-8"  x-data="{ activeTab:  0 }">
                    <div class="sm:hidden">
                        <label for="tabs" class="sr-only">Select a tab</label>
                        <!-- Use an "onChange" listener to redirect the user to the selected tab URL. -->
                        <select id="tabs" name="tabs" class="block w-full rounded-md border-gray-300 focus:border-primary-600 focus:ring-primary-600">
                            <option>Contacts</option>

                            <option>Template Defaults</option>

                            <option>Personalised Values</option>

                            <option>Contact Specifics</option>

                        </select>
                    </div>
                    <div class="hidden sm:block">
                        <div class="border-b border-gray-200 flex justify-between items-center">
                            <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                                <!-- Current: "border-primary-600 text-indigo-600", Default: "border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300" -->
                                <a href="#/"
                                   @click="activeTab = 0"
                                   :class="{ 'active text-primary-600 border-primary-600 border-primary-600': activeTab === 0 }"
                                   class="hover:text-gray-700 hover:border-gray-300 group inline-flex items-center py-4 px-1 border-b-2 font-medium text-sm">

                                    <svg :class="{ 'text-primary-600': activeTab === 0 }" class=" group-hover:text-gray-500 -ml-0.5 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path d="M10 8a3 3 0 100-6 3 3 0 000 6zM3.465 14.493a1.23 1.23 0 00.41 1.412A9.957 9.957 0 0010 18c2.31 0 4.438-.784 6.131-2.1.43-.333.604-.903.408-1.41a7.002 7.002 0 00-13.074.003z" />
                                    </svg>
                                    <span>Contacts
                                       <span class="bg-gray-100 text-gray-900  ml-3 py-0.5 px-2.5 rounded-full text-xs font-medium md:inline-block">{{$total ?? 0}}</span>

                                    </span>
                                </a>
                                <a href="#/"
                                   @click="activeTab = 3"
                                   :class="{ 'active text-primary-600 border-primary-600 ': activeTab === 3 }"
                                   class=" hover:text-gray-700 hover:border-gray-300 group inline-flex items-center py-4 px-1 border-b-2 font-medium text-sm">
                                    <!-- Heroicon name: mini/building-office -->
                                    <svg :class="{ 'text-primary-600': activeTab === 1 }" class=" group-hover:text-gray-500 -ml-0.5 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M4 16.5v-13h-.25a.75.75 0 010-1.5h12.5a.75.75 0 010 1.5H16v13h.25a.75.75 0 010 1.5h-3.5a.75.75 0 01-.75-.75v-2.5a.75.75 0 00-.75-.75h-2.5a.75.75 0 00-.75.75v2.5a.75.75 0 01-.75.75h-3.5a.75.75 0 010-1.5H4zm3-11a.5.5 0 01.5-.5h1a.5.5 0 01.5.5v1a.5.5 0 01-.5.5h-1a.5.5 0 01-.5-.5v-1zM7.5 9a.5.5 0 00-.5.5v1a.5.5 0 00.5.5h1a.5.5 0 00.5-.5v-1a.5.5 0 00-.5-.5h-1zM11 5.5a.5.5 0 01.5-.5h1a.5.5 0 01.5.5v1a.5.5 0 01-.5.5h-1a.5.5 0 01-.5-.5v-1zm.5 3.5a.5.5 0 00-.5.5v1a.5.5 0 00.5.5h1a.5.5 0 00.5-.5v-1a.5.5 0 00-.5-.5h-1z" clip-rule="evenodd" />
                                    </svg>
                                    <span>Templates</span>
                                </a>


                                <a href="#/"
                                   @click="activeTab = 1"
                                   :class="{ 'active text-primary-600 border-primary-600 ': activeTab === 1 }"
                                   class=" hover:text-gray-700 hover:border-gray-300 group inline-flex items-center py-4 px-1 border-b-2 font-medium text-sm">
                                    <!-- Heroicon name: mini/building-office -->
                                    <svg :class="{ 'text-primary-600': activeTab === 1 }" class=" group-hover:text-gray-500 -ml-0.5 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M4 16.5v-13h-.25a.75.75 0 010-1.5h12.5a.75.75 0 010 1.5H16v13h.25a.75.75 0 010 1.5h-3.5a.75.75 0 01-.75-.75v-2.5a.75.75 0 00-.75-.75h-2.5a.75.75 0 00-.75.75v2.5a.75.75 0 01-.75.75h-3.5a.75.75 0 010-1.5H4zm3-11a.5.5 0 01.5-.5h1a.5.5 0 01.5.5v1a.5.5 0 01-.5.5h-1a.5.5 0 01-.5-.5v-1zM7.5 9a.5.5 0 00-.5.5v1a.5.5 0 00.5.5h1a.5.5 0 00.5-.5v-1a.5.5 0 00-.5-.5h-1zM11 5.5a.5.5 0 01.5-.5h1a.5.5 0 01.5.5v1a.5.5 0 01-.5.5h-1a.5.5 0 01-.5-.5v-1zm.5 3.5a.5.5 0 00-.5.5v1a.5.5 0 00.5.5h1a.5.5 0 00.5-.5v-1a.5.5 0 00-.5-.5h-1z" clip-rule="evenodd" />
                                    </svg>
                                    <span>Personalised Values</span>
                                </a>


                            </nav>
                            @if($completeMessageInfo['id'])

                            <button wire:click="removeCampaign" class="bg-dbfb1 text-white px-3 py-1 h-10">Delete Campaign</button>
                       @endif
                        </div>
                    </div>

                    <div class="tab-panel" :class="{ 'active': activeTab === 0 }" x-show.transition.in.opacity.duration.600="activeTab === 0">
                        <div class="px-4 py-3 sm:px-6 lg:px-8">
                            <div class="sm:flex sm:items-center justify-between">
                                <div class="sm:flex-auto">
                                    <h1 class="text-xl font-semibold text-gray-900">Contacts </h1>
                                    <p class="mt-2 text-sm text-gray-700">These contacts will be scheduled to receive your sms.
                                    @if($contacts)
                                        <span class="text-red-500">All opted out contacts have been removed.</span>
                                    @endif
                                    </p>
                                </div>
                                <div class="flex flex-col px-2">
                                    <div class="font-bold ">
                                        <span >Total credits:</span>{{$totalCredits}}</div>
                                    @foreach($this->contactFeedback as $key=>$value)
                                        <div>
                                            <span>There are {{count($value)}} contacts using {{$key}} credits.</span>
                                        </div>
                                    @endforeach
                                </div>

                            </div>
                            <div class="mt-8 flex flex-col">
                                <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                    <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                                        <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">

                                            <table class="min-w-full divide-y divide-gray-300">
                                                <thead class="bg-gray-50">
                                                <tr>
                                                    <th scope="col" class="whitespace-nowrap py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Number</th>
                                                    <th scope="col" class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900 text-center">Credit</th>
                                                    <th scope="col" class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900 text-center">Characters used</th>
                                                </tr>
                                                </thead>
                                                <tbody class="divide-y divide-gray-200 bg-white">


                                                @foreach($contacts as $contact)
                                                    <tr>
                                                        <td class="whitespace-nowrap py-2 pl-4 pr-3 text-sm text-gray-500 sm:pl-6">{{$contact->country_code}}{{$contact->number}}</td>
                                                        <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-900 text-center">{{$contact->credits}}</td>
                                                        <td class="whitespace-nowrap px-2 py-2 text-sm text-gray-900 text-center">{{$contact->characters}}</td>

                                                    </tr>
                                                @endforeach

                                                <!-- More transactions... -->
                                                </tbody>
                                            </table>




                                        </div>
                                        <div class="py-4">{{$contacts ? $contacts->links() : ''}}</div>

                                        <div class="py-4">
                                            @if(count($contacts) > 0)
{{--                                                {{ $contacts->links() }}--}}
                                            @endif
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-panel" :class="{ 'active': activeTab === 3 }" x-show.transition.in.opacity.duration.600="activeTab === 3">
                       <livewire:message.templates.template-list/>
                    </div>
                    <div class="tab-panel" :class="{ 'active': activeTab === 1 }" x-show.transition.in.opacity.duration.600="activeTab === 1">
                        <div class="border-b border-gray-200 bg-white py-3" x-data="{system:true,static:false}">

                            <nav class="-mb-px flex space-x-2 text-center mx-auto" aria-label="Tabs" >
                                <!-- Current: "border-indigo-500 text-indigo-600", Default: "border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-200" -->
                                <a @click="system = true , static = false" href="#/"  class="text-gray-900 rounded-l-lg group relative min-w-0 flex-1 overflow-hidden bg-white py-4 px-4 text-center text-sm font-medium hover:bg-gray-50 focus:z-10" aria-current="page">
                                    <span>  Global Variables</span>

                                    <span x-show="system"  aria-hidden="true" class="bg-dbfb2 absolute inset-x-0 bottom-0 h-0.5"></span>

                                </a>

{{--                                <a @click="system = false , static = true" href="#/" class="text-gray-900 rounded-l-lg group relative min-w-0 flex-1 overflow-hidden bg-white py-4 px-4 text-center text-sm font-medium hover:bg-gray-50 focus:z-10" aria-current="page">--}}
{{--                    <span> Template Variables <span class="inline-flex items-center rounded-full border border-transparent bg-dbfb1 text-white px-1 mx-3">{{count($variables)}}</span>--}}
{{--                    </span>--}}

{{--                                    <span x-show="static"  aria-hidden="true" class="bg-dbfb2  absolute inset-x-0 bottom-0 h-0.5"></span>--}}
{{--                                </a>--}}
{{--                            --}}
                            </nav>

                    {{--                 Contact Sperific Vars           --}}
                            <div x-show="system" class="col-span-1 p-4">

                                @foreach($contactVariables as $k=> $var)
                                    @php $k; @endphp
                                    <div class="space-y-6 sm:space-y-5 max-h-[200px] overflow-y-auto">
                                        <div class="sm:grid sm:grid-cols-4 sm:items-center sm:gap-2 sm:border-t sm:border-gray-200 sm:pt-5 items-center align-middle py-5">

                                            <label for="{{$k}}contact" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">{{$var['info']}}</label>
                                            <div class="mt-1 sm:col-span-1 sm:mt-0">
                                                <div class="flex max-w-lg rounded-md shadow-sm">
                                                    <input readonly type="text" wire:model.debounce.500ms="contactVariables.{{$k}}.placeholder" name="{{$k}}contact" id="{{$k}}contact" autocomplete="{{$k}}contact" class="block w-full min-w-0 flex-1 rounded-none rounded border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                                </div>
                                            </div>
                                        </div>

                                    </div>


                                @endforeach
                            </div>

{{--                            <div x-show="static" class="col-span-1  p-4 ">--}}
{{--                                <div class="flex justify-between py-2 gap-1">--}}
{{--                                    <h3> Template Variables </h3>--}}
{{--                                    <button wire:click="addVariable" class="bg-dbfb2 px-3 py-2 bg-dbfb2 text-white transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-dbfb1 hover:bg-dbfb1 " >Add Variable</button>--}}


{{--                                </div>--}}
{{--                                @foreach($variables as $key=> $var)--}}
{{--                                    @php $key; @endphp--}}
{{--                                    <div class="space-y-6 sm:space-y-5 max-h-[200px] overflow-y-auto">--}}
{{--                                        <div class="sm:grid sm:grid-cols-4 sm:items-center sm:gap-2 sm:border-t sm:border-gray-200 sm:pt-5 items-center align-middle py-5">--}}

{{--                                            <label for="{{$key}}" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2"> {{$key+1}}</label>--}}
{{--                                            <div class="mt-1 sm:col-span-1 sm:mt-0">--}}
{{--                                                <div class="flex max-w-lg rounded-md shadow-sm">--}}
{{--                                                    <input type="text" wire:model.debounce.1500ms="variables.{{$key}}.placeholder" name="varname{{$key}}" id="varname{{$key}}" autocomplete="varname{{$key}}" class="block w-full min-w-0 flex-1 rounded-none rounded border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                            <div class="mt-1 sm:col-span-1 sm:mt-0">--}}
{{--                                                <div class="flex max-w-lg rounded-md shadow-sm">--}}
{{--                                                    <input type="text" wire:model.debounce.1500ms="variables.{{$key}}.value" name="varvalue{{$key}}" id="varvalue{{$key}}" autocomplete="varvalue{{$key}}" class="block w-full min-w-0 flex-1 rounded-none rounded border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}

{{--                                    </div>--}}


{{--                                @endforeach--}}
{{--                            </div>--}}

                        </div>
                    </div>
                 </div>



            </div>
        </div>
    </div>



<script>

    const datepickerEl = document.getElementById('dateSelector');


    datepickerEl.addEventListener('changeDate', function(e) {
        console.log('start', e.detail.date);
        console.log('start', e.detail);
        Livewire.emit('dateChange',e.detail.date);
    });

    window.addEventListener("load", (event) => {


        Livewire.emit('characters');
    });
</script>


</div>
