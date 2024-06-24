<div class="" >
    <div class="flex justify-start p-2" x-data="{ open: false }">
        <label for="default-toggle" class="inline-flex relative items-center cursor-pointer">
            <input @click="open = ! open" type="checkbox" value="" id="default-toggle" class="sr-only peer">
            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
            <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">Custom Fields</span>
        </label>

            <div x-cloak role="list" class="mx-4 grid grid-cols-1 gap-5 sm:grid-cols-2 sm:gap-6 lg:grid-cols-4 rounded" x-show="open" x-transition>
                  <button id="varTitle" class=" px-2 py-1 bg-dbfb2 text-white mx-1 text-sm"  data-id="$title$" value="$title$">
                      Hello 👋
                  </button>


            </div>

    </div>



    <div class="mt-2 bg-white " >
        <div  class="h-96 cursor-default" style="min-height: 200px"

              x-data
              x-ref="quillEditor"
              x-init="
        quill = new Quill($refs.quillEditor, {
        theme: 'snow',
        modules: {toolbar: ['link']
        }});
          quill.on('text-change', function () {
          $dispatch('quill-input', quill.root.innerHTML);
        });

        const varTitle = document.getElementById('varTitle');
        varTitle.addEventListener('click', myFunction(quill,varTitle));

"
              x-on:quill-input.debounce.1300ms="@this.set('message', $event.detail)"
        >
            <div class="h-20">
                {!!  $message !!}
            </div>


        </div>
    </div>
    <div class="flex justify-between py-2">
        <span>  Characters: {{$length}} </span>
        <button class="bg-dbfb2 px-3 py-2 bg-dbfb2 text-white transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-dbfb1 hover:bg-dbfb1 " >Save Template</button>


    </div>




    @push('js')
        <script>
            function myFunction(quill,varSelectId) {
                 console.log(varSelectId);
                let range = quill.getSelection();
                console.log(range);
                quill.updateContents(range.length === 0 ?? 1,
                    [
                    { insert: varSelectId.value}
                ]);
                alert('sad');
            }
        </script>
        @endpush
</div>
