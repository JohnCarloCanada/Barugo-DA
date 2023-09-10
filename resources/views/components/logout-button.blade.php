<form class="mt-10 w-full" action="{{ route('logout')}}" method="post">
    @csrf
    <button class="w-full bg-white text-black font-bold py-2 rounded-sm cursor-pointer flex items-center justify-center gap-x-1 logout" type="submit">
        <img class="w-5 h-5" src="{{asset('images/icons/logout.png')}}" alt="">
        <p class="hide">Logout</p>
    </button>
</form>