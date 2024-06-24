<div  class="text-sm leading-4 font-medium text-gray-500 mx-3">
    <a href="{{$isTLD ? route($prefix.'.credits',['domain' => $domain]) :route('credits',['domain' => $domain])}}">
        <span> Credits: <i class="fa-regular fa-coin-front mx-1"></i></span>
        <span class="mx-1" >{{$balance}} </span>
    </a>
</div>
