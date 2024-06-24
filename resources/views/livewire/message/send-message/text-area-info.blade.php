<div>
<form wire:submit.prevent="sendMessage">
    <div class="sm:grid grid-cols-6 sm:items-center align-middle py-0">


    </div>

<textarea wire:model="message" class="w-full min-h-[300px]" required>

</textarea>
    <div class="flex justify-between py-2">
        <span>  Characters: {{$count}} </span>
        <div class="flex justify-between py-2 gap-1">


        </div>
        @if($totalCredits > Auth::user()->currentTeam->credits->amount )
            <div class="col-span-5  text-red-500  ">
                Not enough credits to send these messages
            </div>

            <button  type="submit" class="col-span-1  px-3 py-2 text-white transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-dbfb1 hover:bg-dbfb1 " style="background-color: #253369;">Save Draft Schedule</button>
        @else
            <div class="col-span-5   ">
            </div>
            <button type="submit" class="col-span-1  px-3 py-2 text-white transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-dbfb1 hover:bg-dbfb1 " style="background-color: #253369;">Schedule Message</button>

        @endif

    </div>
</form>
    <section class="bg-white dark:bg-gray-900">
        <div class="p-8 ">
             <div class="mx-auto max-w-screen-xl">
                <div id="accordion-flush" data-accordion="collapse" data-active-classes="bg-white dark:bg-gray-900 text-gray-900 dark:text-white" data-inactive-classes="text-gray-500 dark:text-gray-400">
                    <h2 id="accordion-flush-heading-1">
                        <button type="button" class="flex justify-between items-center py-5 w-full font-medium text-left text-gray-900 bg-white border-b border-gray-200 dark:border-gray-700 dark:bg-gray-900 dark:text-white" data-accordion-target="#accordion-flush-body-1" aria-expanded="true" aria-controls="accordion-flush-body-1">
                            <span>Selected Contacts List</span>
                            <div>

                                <svg data-accordion-icon="" class="w-6 h-6 rotate-180 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>

                            </div>
                        </button>
                    </h2>
                    <div id="accordion-flush-body-1" class="" aria-labelledby="accordion-flush-heading-1">
                        <div class="py-5 border-b border-gray-200 dark:border-gray-700">

                            <div class="px-4 sm:px-6 lg:px-8">
                                <div class="sm:flex sm:items-center justify-between">
                                    <div class="sm:flex-auto">
                                        <h1 class="text-xl font-semibold text-gray-900">Contacts </h1>
                                        <p class="mt-2 text-sm text-gray-700">These contacts will be scheduled to receive your sms.</p>
                                    </div>
                                    <div>
                                        <span>  <span class="mx-2">Total credits:</span>{{$totalCredits}}</span>
                                    </div>

                                </div>
                                <div class="mt-8 flex flex-col">
                                    <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                        <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                                            <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                                                <table class="min-w-full divide-y divide-gray-300">
                                                    <thead class="bg-gray-50">
                                                    <tr>
                                                        <th scope="col" class="whitespace-nowrap py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Name</th>
                                                        <th scope="col" class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900">credit</th>
                                                        <th scope="col" class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900">characters used</th>
                                                        <th scope="col" class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900">preview message</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody class="divide-y divide-gray-200 bg-white">
                                                    @foreach($contacts as $contact)
                                                    <tr>
                                                        <td class="whitespace-nowrap py-2 pl-4 pr-3 text-sm text-gray-500 sm:pl-6">{{$contact->title}} {{$contact->firstname}} {{$contact->lastname}}</td>
                                                        <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-900">{{$contact->credits}}</td>
                                                        <td class="whitespace-nowrap px-2 py-2 text-sm text-gray-900">{{$contact->characters}}</td>
                                                        <td class="whitespace-nowrap px-2 py-2 text-sm text-gray-500">preview</td>
                                                    </tr>
                                                    @endforeach

                                                    <!-- More transactions... -->
                                                    </tbody>
                                                </table>


                                            </div>
                                            <div class="py-4">
                                                @if(count($contacts) > 0)
                                                    {{ $contacts->links() }}
                                                @endif
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>


                    <h2 id="accordion-flush-heading-2">
                        <button type="button" class="flex justify-between items-center py-5 w-full font-medium text-left text-gray-500 border-b border-gray-200 dark:border-gray-700 dark:text-gray-400" data-accordion-target="#accordion-flush-body-2" aria-expanded="false" aria-controls="accordion-flush-body-2">
                            <span>Message Customizations</span>
                            <svg data-accordion-icon="" class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                        </button>
                    </h2>
                    <div id="accordion-flush-body-2" class="hidden" aria-labelledby="accordion-flush-heading-2">
                        <div class="py-5 border-b border-gray-200 dark:border-gray-700">
                            <div class="sm:hidden">
                                <label for="tabs" class="sr-only">Select a tab</label>
                                <!-- Use an "onChange" listener to redirect the user to the selected tab URL. -->
                                <select id="tabs" name="tabs" class="block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                                    <option>System Templates</option>
                                    <option>User Templates</option>
                                </select>
                            </div>
                            <div class="hidden sm:block">
                                <div class="border-b border-gray-200 bg-white" x-data="{system:false,static:true}">
                                    <nav class="-mb-px flex space-x-2 text-center mx-auto" aria-label="Tabs" >
                                        <!-- Current: "border-indigo-500 text-indigo-600", Default: "border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-200" -->
                                        <a @click="system = true , static = false"  :class="system ? 'bg-dbfb2 text-white' :'bg-white text-gray-900' " class="w-1/2 pl-4  text-center mx-auto border-transparent hover:border-gray-200 whitespace-nowrap flex py-4 px-1 border-b-2 font-medium text-sm">
                                            Global Variables</a>

                                        <a  @click="system = false , static = true"  :class="static ?  'bg-dbfb2 text-white' :'bg-white text-gray-900' " class="w-1/2 pl-4  text-center mx-auto border-transparent hover:border-gray-200 whitespace-nowrap flex py-4 px-1 border-b-2 font-medium text-sm">
                                            Template Variables <span class="inline-flex items-center rounded-full border border-transparent bg-dbfb1 text-white px-1 mx-3">{{count($variables)}}</span></a>
                                    </nav>

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

                                    <div x-show="static" class="col-span-1  p-4 ">
                                        <div class="flex justify-between py-2 gap-1">
                                            <h3> Template Variables </h3>
                                            <button wire:click="addVariable" class="bg-dbfb2 px-3 py-2 bg-dbfb2 text-white transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-dbfb1 hover:bg-dbfb1 " >Add Variable</button>


                                        </div>
                                        @foreach($variables as $key=> $var)
                                            @php $key; @endphp
                                            <div class="space-y-6 sm:space-y-5 max-h-[200px] overflow-y-auto">
                                                <div class="sm:grid sm:grid-cols-4 sm:items-center sm:gap-2 sm:border-t sm:border-gray-200 sm:pt-5 items-center align-middle py-5">

                                                    <label for="{{$key}}" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2"> {{$key+1}}</label>
                                                    <div class="mt-1 sm:col-span-1 sm:mt-0">
                                                        <div class="flex max-w-lg rounded-md shadow-sm">
                                                            <input type="text" wire:model.debounce.1500ms="variables.{{$key}}.placeholder" name="varname{{$key}}" id="varname{{$key}}" autocomplete="varname{{$key}}" class="block w-full min-w-0 flex-1 rounded-none rounded border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                                        </div>
                                                    </div>
                                                    <div class="mt-1 sm:col-span-1 sm:mt-0">
                                                        <div class="flex max-w-lg rounded-md shadow-sm">
                                                            <input type="text" wire:model.debounce.1500ms="variables.{{$key}}.value" name="varvalue{{$key}}" id="varvalue{{$key}}" autocomplete="varvalue{{$key}}" class="block w-full min-w-0 flex-1 rounded-none rounded border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>


                                        @endforeach
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                 </div>
            </div>
        </div>
    </section>

</div>
