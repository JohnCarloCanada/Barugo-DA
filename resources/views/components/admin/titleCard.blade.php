@props(['title', 'slogan'])

<div class="px-3">
    <div class="my-3">
        <div class="flex item-center gap-2">
            <img src="{{asset('images/DA-Logo.png')}}" class="w-[35px] h-[35px]  border-2 border-green-500 rounded-full shadow-md" alt="">
            <h2 class="font-bold text-2xl">{{$title}}</h2>
        </div>                    
        <p class="text-xl sm:text-2xl mt-3">{{$slogan}}</p>
    </div>
</div>