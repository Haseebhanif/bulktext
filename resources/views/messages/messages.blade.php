<x-app-layout>



    <main>
        <div class="max-w-9xl mx-auto pt-0.5 p-6 pt-0.5 max-h-full overflow-y-auto">


            <div class="grid grid-cols-5 gap-6  mx-auto">

                <div class="col-span-4 pt-0" >
                    @if(\Route::currentRouteName() == 'message.show' || \Route::currentRouteName() == 'message.clone')
                    <livewire:message.send-message.message-steps
                            :completeMessageInfo="$data"
                            :message="$data['message']"
                            :selectedGroup="$data['group_id']"
                            :reopen="$edit"
                            :contactVariables="$data['vars']['global']"
                            :variables="$data['vars']['template']"
                    />
                    @elseif($isTLD == 1 and  \Route::currentRouteName() == $prefix.'.message.show' || \Route::currentRouteName() == $prefix.'.message.clone')
                        <livewire:message.send-message.message-steps
                            :completeMessageInfo="$data"
                            :message="$data['message']"
                            :selectedGroup="$data['group_id']"
                            :reopen="$edit"
                            :contactVariables="$data['vars']['global']"
                            :variables="$data['vars']['template']"
                        />
                        @else

                        <livewire:message.send-message.message-steps/>
                    @endif

                </div>



                <figure class="mx-auto max-w-full w-64 h-auto ">
                    <livewire:mobile-message-preview/>

                </figure>
            </div>


        </div>
    </main>

</x-app-layout>
