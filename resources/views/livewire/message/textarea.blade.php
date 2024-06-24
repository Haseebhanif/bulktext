<div>
<form wire:submit.prevent="saveTemplate">
    <div class="sm:grid grid-cols-12 md:grid-cols-6 sm:items-center align-middle py-2">

        <div class="col-span-8 md:col-span-4  rounded-md shadow-sm ">
            <input required  type="text" wire:model.debounce.250ms="name" name="templateName" id="templateName"  class="block  w-1/2 rounded-none rounded border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Template name">
            @if($errors->has('name'))
                <span>{{ $errors->first('name') }}</span>
            @endif
        </div>



        <button class="col-span-4 md:col-span-2   bg-primary-600  px-3 py-2 text-white transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-dbfb1 hover:bg-dbfb1 " >
          <span class="text-center">
               Save Template
          </span>
        </button>

    </div>
    <input wire:model="messageHTML" type="hidden"/>
<textarea
    wire:model.debounce.200ms="message"
          wire:keydown.enter="addBreak" class="w-full min-h-[300px]" required>
</textarea>
    @if($errors->has('message'))
        <span>{{ $errors->first('message') }}</span>
    @endif

    <div class="flex justify-between py-2">
        <span>  Characters: {{$length}} </span>
        <div class="flex justify-between py-2 gap-1">


        </div>

    </div>

    <div class="sm:hidden">
        <label for="tabs" class="sr-only">Select a tab</label>
        <!-- Use an "onChange" listener to redirect the user to the selected tab URL. -->
        <select id="tabs" name="tabs" class="block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
            <option>Global Variables</option>
            <option>Template Variables</option>
        </select>
    </div>
    <div class="hidden sm:block">
        <div class="border-b border-gray-200 bg-white" x-data="{system:true,static:false}">
            <nav class="-mb-px flex space-x-2 text-center mx-auto" aria-label="Tabs" >
                <!-- Current: "border-indigo-500 text-indigo-600", Default: "border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-200" -->
                <a @click="system = true , static = false" href="#/"  class="text-gray-900 rounded-l-lg group relative min-w-0 flex-1 overflow-hidden bg-white py-4 px-4 text-center text-sm font-medium hover:bg-gray-50 focus:z-10" aria-current="page">
                    <span>  Global Variables</span>

                    <span x-show="system"  aria-hidden="true" class="bg-dbfb2 absolute inset-x-0 bottom-0 h-0.5"></span>

                </a>

{{--                <a @click="system = false , static = true" href="#/" class="text-gray-900 rounded-l-lg group relative min-w-0 flex-1 overflow-hidden bg-white py-4 px-4 text-center text-sm font-medium hover:bg-gray-50 focus:z-10" aria-current="page">--}}
{{--                    <span> Template Variables <span class="inline-flex items-center rounded-full border border-transparent bg-dbfb1 text-white px-1 mx-3">{{count($variables)}}</span>--}}
{{--                    </span>--}}

{{--                    <span x-show="static"  aria-hidden="true" class="bg-dbfb2  absolute inset-x-0 bottom-0 h-0.5"></span>--}}
{{--                </a>--}}


            </nav>

            <div x-show="system" class="col-span-1 p-4">
                @foreach($contactVariables as $k=> $var)
                    @php $k; @endphp
                    <div class="space-y-6 sm:space-y-5 max-h-[200px] overflow-y-auto">
                        <div class="sm:grid sm:grid-cols-4 sm:items-center sm:gap-2 sm:border-t sm:border-gray-200 sm:pt-5 items-center align-middle py-5">

                            <label for="{{$k}}contact" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">{{$var['info']}}</label>
                            <div class="mt-1 sm:col-span-1 sm:mt-0">
                                <div class="flex max-w-lg rounded-md shadow-sm">
                                    <input readonly type="text" wire:model="contactVariables.{{$k}}.placeholder" name="{{$k}}contact" id="{{$k}}contact" autocomplete="{{$k}}contact" class="block w-full min-w-0 flex-1 rounded-none rounded border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                </div>
                            </div>
                        </div>

                    </div>


                @endforeach
            </div>

{{--            <div x-show="static" class="col-span-1  p-4 ">--}}
{{--                <div class="flex justify-between py-2 gap-1">--}}
{{--                    <h3> Template Variables </h3>--}}
{{--                    <button wire:click="addVariable" class="bg-dbfb2 px-3 py-2 bg-dbfb2 text-white transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-dbfb1 hover:bg-dbfb1 " >Add Variable</button>--}}


{{--                </div>--}}
{{--            @foreach($variables as $key=> $var)--}}
{{--                    @php $key; @endphp--}}
{{--                    <div class="space-y-6 sm:space-y-5 max-h-[200px] overflow-y-auto">--}}
{{--                        <div class="sm:grid sm:grid-cols-4 sm:items-center sm:gap-2 sm:border-t sm:border-gray-200 sm:pt-5 items-center align-middle py-5">--}}

{{--                            <label for="{{$key}}" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2"> {{$key+1}}</label>--}}
{{--                            <div class="mt-1 sm:col-span-1 sm:mt-0">--}}
{{--                                <div class="flex max-w-lg rounded-md shadow-sm">--}}
{{--                                    <input type="text" wire:model="variables.{{$key}}.placeholder" name="varname{{$key}}" id="varname{{$key}}" autocomplete="varname{{$key}}" class="block w-full min-w-0 flex-1 rounded-none rounded border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="mt-1 sm:col-span-1 sm:mt-0">--}}
{{--                                <div class="flex max-w-lg rounded-md shadow-sm">--}}
{{--                                    <input type="text" wire:model="variables.{{$key}}.value" name="varvalue{{$key}}" id="varvalue{{$key}}" autocomplete="varvalue{{$key}}" class="block w-full min-w-0 flex-1 rounded-none rounded border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                    </div>--}}


{{--                @endforeach--}}
{{--            </div>--}}

        </div>
    </div>
</form>
</div>
