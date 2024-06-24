<div>
    <div class="p-1.5 bg-gray-800  rounded-3xl shadow-[0_2.75rem_5.5rem_-3.5rem_rgb(45_55_75_/_20%),_0_2rem_4rem_-2rem_rgb(45_55_75_/_30%),_inset_0_-0.1875rem_0.3125rem_0_rgb(45_55_75_/_20%)] dark:bg-gray-600 dark:shadow-[0_2.75rem_5.5rem_-3.5rem_rgb(0_0_0_/_20%),_0_2rem_4rem_-2rem_rgb(0_0_0_/_30%),_inset_0_-0.1875rem_0.3125rem_0_rgb(0_0_0_/_20%)]">
<div class="bg-gray-300 rounded-t-3xl min-h-[30px] text-center font-bold">
   <span class="pt-2">  {{$sender}}</span>
</div>
        <div class="p-4 bg-white min-h-[500px] max-h-[500px]  overflow-y-auto hyphens-auto">


            @foreach($this->messages as $sms)
                <div class="p-2 bg-blue-300 max-w-xs shadow-xl rounded-xl  rounded-br-none mb-2 preview">
                    <div class="hyphens-auto box" lang="en" style="
                    white-space:pre-wrap;">{!!$sms!!}</div>
                </div>
            @endforeach

        </div>

        <div class="flex justify-center text-white">
            <h2 class="font-light text-sm"> est credits:</h2>
            <span class="text-sm">{{$messageCost}}</span>
        </div>

    </div>
    <span class="font-light text-sm"> Message rate of {{$rate}} per message, credit usage may vary when variables are used</span>
</div>

