<div class="my-8 relative" x-data="{group:@entangle($createNewGroup)}" >
<div class="absolute -top-5 right-0 cursor-pointer"  @click="open = false" wire:click="clearImport">
    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
</div>


    <form wire:submit.prevent="import" enctype="multipart/form-data"  x-show="!group" >


        <div class="flex flex-col justify-start  ">

            <div class="m-2  w-1/3"  >

                    <div>
                        <label for="location" class="block text-sm font-medium text-gray-700">Select Group</label>
                        <select wire:model="importGroup" id="location" name="location" class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                            <option disabled selected>please-select</option>
                            @foreach($groups as $group)
                                <option {{$selectedGroup == $group->id ? 'selected':'' }} value="{{$group->id}}">{{$group->name}}</option>
                            @endforeach
                        </select>


                    </div>




            </div>


            <div class="m-2  w-1/3">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="file_input">Select file</label>
                <input type="file" wire:model="filename"  name="filename" class="block w-full  text-sm  border rounded-l-lg">
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">Required file format is a single sheet xlsx</p>
                @error('filename') <span class="error">{{ $message }}</span> @enderror

            </div>

        <div class="m-2 pt-0.5 flex justify-between">
            <button  type="submit"  class=" max-h-[100px] px-2 py-2 my-2 text-white rounded-lg" style="background-color: #253369">Upload File</button>
            <a href="/contacts_import_template.xlsx" traget="_blank"  class="text-gray-600 font-bold underline cursor-pointer p-2 ml-2  dark:text-gray-400 ">Download contacts template</a>

        </div>


        </div>


    </form>

    <div class="py-2 flex justify-start w-1/2" x-show="group">

        <form wire:submit.prevent="submit">
            <label for="newGroupName" class="sr-only">newGroupName</label>
            <div class="flex justify-start ">
                <input wire:model="newGroupName" type="text"  name="newGroupName" id="newGroupName" class="block w-full rounded-tl-md rounded-bl-md  border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="New Group Name">

                <button type="submit" @click="group  = false" class="bg-primary-600 text-white p-2" style="background-color: #253369;">save</button>
            </div>
            @error('newGroupName')
            <div class="pt-5">
                <span class="error mt-2 bg-red-200 text-red-800 p-2 rounded shadow-xl border-red-900">{{ $message }}</span>
            </div>
            @enderror

        </form>
        <button type="button" @click="group  = false" class="bg-red-600 text-white p-2 mx-2" >cancel</button>
    </div>
<hr/>

        <section class="bg-white dark:bg-gray-900">

            <div class="py-8 px-4 mx-auto max-w-screen-xl sm:py-16 lg:px-6 max-h-[500px] overflow-y-auto">
                @if($importStatus )

                <div class="flex justify-between">
                    <span>Imported Error count: {{$failureErrorsCount}}</span>
                 @if($failureErrorsCount > 0)
                     <span>
                         The Table below displays a maximum of 500 errors.
                     </span>
                 @endif
                    <span>Imported success count: {{$this->importCount}}</span>
                </div>
                    @if($failureErrorsCount > 0 || isset($toImportErrors))
                    <table class="min-w-full divide-y divide-gray-300 max-h-[400px] overflow-y-auto">
                        <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="whitespace-nowrap py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Row</th>
                            <th scope="col" class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900">Issue</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                        @foreach($toImportErrors as $error)

                            <tr>

                                <td class="whitespace-nowrap py-2 pl-4 pr-3 text-sm text-gray-500 sm:pl-6"> {{$error['row']}}</td>
                                <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-900">
                                    @foreach($error['errors'] as $e)
                                        {{$e}} <br/>
                                    @endforeach
                                </td>

                            </tr>
                        @endforeach

                        <!-- More transactions... -->
                        </tbody>
                    </table>


                @endif

                @else

                        @if(!$importStatus and $hasRecord)
                        <button disabled type="button" class="py-2.5 px-5 me-2 text-sm font-medium text-gray-900 bg-white rounded-lg  inline-flex items-center">
                            <svg aria-hidden="true" role="status" class="inline w-4 h-4 mr-2 me-3 text-gray-200 animate-spin dark:text-gray-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                                <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="#1C64F2"/>
                            </svg>
                            Processing.
                        </button>
                            <br>
                        You may navigate away from this page at any point, once you receive an email confirming the upload was successful please return to this page or refresh the page to see the results of the upload.
                        @endif
                @endif
            </div>
        </section>


</div>
