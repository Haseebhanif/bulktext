<x-unteamed-layout>
    <main>
        <div class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <!--
              Background backdrop, show/hide based on modal state.

              Entering: "ease-out duration-300"
                From: "opacity-0"
                To: "opacity-100"
              Leaving: "ease-in duration-200"
                From: "opacity-100"
                To: "opacity-0"
            -->
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

            <div class="fixed inset-0 z-10 w-screen ">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <div class="relative transform  rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6">
                      <form method="post" action="{{$isTLD ?  route($prefix.'.update.choice',['domain'=>$domain])  : route('update.choice',['domain'=>$domain])}}">
                          @csrf


                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                </svg>
                            </div>

                            @if(count($teams) > 0)

                                <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                                    <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">{{\Illuminate\Support\Facades\Auth::user()->name}} Please select </h3>
                                    <div class="mt-2">
                                        <p class="text-sm text-gray-500">The company you where assigned to is no longer active.</p>
                                    </div>
                                    <label for="team" class="block text-sm font-medium leading-6 text-gray-900">Departments </label>
                                    <select id="team" name="team" class="mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                        <option disabled > -- please select -- </option>
                                    @foreach($teams as $team)

                                            <option value="{{$team->id}}">{{$team->name}}</option>

                                        @endforeach
                                    </select>

                                </div>

                                @else

                                <div class="mt-3 md:mt-0 text-center sm:ml-4 sm:mt-0 sm:text-left">
                                    <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">Deactivate account</h3>
                                    <div class="mt-2 md:mt-0">
                                        <p class="text-sm text-gray-500 mb-3">{{\Illuminate\Support\Facades\Auth::user()->name}}  The company you where assigned to is no longer active.</p>
                                                    <x-jet-danger-button onclick="window.livewire.emit('deleteAccountConfirm')">
                                                        {{ __('Delete Account') }}
                                                    </x-jet-danger-button>
                                    </div>

                                </div>

                            @endif


                        </div>
                          @if(count($teams) > 0)
                                <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse justify-between">
                                    <button type="submit" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">Select</button>
                                </div>
                          @endif
                      </form>

                        <form method="post" action="{{route('logout')}}">
                            @csrf
                            <button  class="inline-flex w-full justify-center rounded-md  px-3 py-2 text-sm font-semibold text-gray-700 border shadow-sm hover:text-black sm:ml-3 sm:w-auto" type="submit">Logout</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
        @livewire('delete-none-active-user')
    </main>
</x-unteamed-layout>
