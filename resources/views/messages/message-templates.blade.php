<x-app-layout>
    @push('css')
        <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    @endpush
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Template Messages') }}
            </h2>
        </div>

    </x-slot>

             <main>
                <div class="max-w-9xl mx-auto pt-0.5 p-6 pt-0.5 max-h-full overflow-y-auto container">


                <div class="grid grid-cols-3  md:grid-cols-12 lg:grid-cols-12 gap-6  mx-auto">

                    <div class="pt-0 col-span-3 md:col-span-2">
                        <livewire:message.templates.template-list/>
                    </div>


                    <div class="col-span-6 md:col-span-6">
                        <livewire:message.textarea/>
{{--                        <livewire:quill-editor/>--}}
                    </div>

                    <figure class="mx-auto max-w-full w-64 h-auto  col-span-3 md:col-span-3">
                        <livewire:mobile-message-preview/>

                    </figure>
                </div>


                </div>
             </main>

    @push('js')
        <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    @endpush
</x-app-layout>
