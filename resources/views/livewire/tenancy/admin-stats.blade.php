
<!-- Card is full width. Use in 12 col grid for best view. -->
<!-- Card code block start -->
<div class="w-full grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-4 gap-8 px-2 md:px-6 mb-6">
    <a aria-label="card 1" href="javascript:void(0)" class="bg-white dark:bg-gray-800 rounded  focus:ring-2 focus:ring-offset-2 focus:ring-indigo-700 focus:outline-none focus:bg-gray-100 hover:bg-gray-50">
        <div class="shadow px-8 py-6 flex items-center">
            <div class="p-4 bg-indigo-700 rounded">
                <img src="https://tuk-cdn.s3.amazonaws.com/can-uploader/medium_stat_cards_with_icon-svg1.svg" alt="icon"/>

            </div>

            <div class="ml-6">
                <h3 class="mb-1 leading-5 text-gray-800 dark:text-gray-100 font-bold text-2xl">{{$usedCredits}}
                </h3>
                <p
                        class="text-gray-600 dark:text-gray-400 text-sm tracking-normal font-normal leading-5">
                    Used Credits</p>
            </div>

        </div>
    </a>
    <a aria-label="card 2" href="javascript:void(0)" class="bg-white dark:bg-gray-800 rounded  focus:ring-2 focus:ring-offset-2 focus:ring-indigo-700 focus:outline-none focus:bg-gray-100 hover:bg-gray-50">
        <div class=" shadow px-8 py-6 flex items-center">
            <div class="p-4 bg-indigo-700 rounded text-white">
                <img src="https://tuk-cdn.s3.amazonaws.com/can-uploader/medium_stat_cards_with_icon-svg2.svg" alt="icon"/>

            </div>
            <div class="ml-6">
                <h3 class="mb-1 leading-5 text-gray-800 dark:text-gray-100 font-bold text-2xl">{{$messages_sent}}</h3>
                <p
                        class="text-gray-600 dark:text-gray-400 text-sm tracking-normal font-normal leading-5">
                    Sent SMS's</p>
            </div>
        </div>
    </a>
    <a aria-label="card 3" href="javascript:void(0)" class="bg-white dark:bg-gray-800 rounded  focus:ring-2 focus:ring-offset-2 focus:ring-indigo-700 focus:outline-none focus:bg-gray-100 hover:bg-gray-50">
        <div class=" shadow px-8 py-6 flex items-center">
            <div class="p-4 bg-indigo-700 rounded text-white">
                <img src="https://tuk-cdn.s3.amazonaws.com/can-uploader/medium_stat_cards_with_icon-svg3.svg" alt="icon"/>

            </div>
            <div class="ml-6">
                <h3 class="mb-1 leading-5 text-gray-800 dark:text-gray-100 font-bold text-2xl">{{$users}}</h3>
                <p
                        class="text-gray-600 dark:text-gray-400 text-sm tracking-normal font-normal leading-5">
                    users</p>
            </div>
        </div>
    </a>
    <a  aria-label="card 4" href="javascript:void(0)" class="bg-white dark:bg-gray-800 rounded  focus:ring-2 focus:ring-offset-2 focus:ring-indigo-700 focus:outline-none focus:bg-gray-100 hover:bg-gray-50">
        <div class="shadow px-8 py-6 flex items-center">
            <div class="p-4 bg-indigo-700 rounded text-white">
                <img src="https://tuk-cdn.s3.amazonaws.com/can-uploader/medium_stat_cards_with_icon-svg4.svg" alt="icon"/>

            </div>
            <div class="ml-6">
                <h3 class="mb-1 leading-5 text-gray-800 dark:text-gray-100 font-bold text-2xl">£{{number_format($total_purchases,2,'.',',')}}</h3>

                <p
                        class="text-gray-600 dark:text-gray-400 text-sm tracking-normal font-normal leading-5">
                    Purchased</p>
            </div>
        </div>
    </a>
</div>

@section('pageJs')
    <script>
        document.addEventListener("DOMContentLoaded", function(event) {
            document.getElementById('createUserButton').click();
        });
    </script>
@endsection
<!-- Card code block end -->

