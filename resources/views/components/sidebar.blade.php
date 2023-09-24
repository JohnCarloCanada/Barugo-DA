@props(['type'])


<section data-sidebar class="isActive">
    <img data-menu class="absolute h-8 w-8 top-2 rounded-full border-2 bg-white border-white -right-4 rotate-180 cursor-pointer rotateReverse" src="{{asset('images/arrow-right.png')}}" alt="">

    <section class="flex items-center gap-x-1">
        <img class="h-12 w-12 sizeIfHidden" src="{{asset('images/DA-Logo.png')}}" alt="Barugo DA Logo">
        <div><h3  class="text-xs text-white font-bold hide">Farmers Management Platform</h3></div>
    </section>

    <section class="flex items-center justify-center gap-x-2 mt-5 hide">
        <img class="h-14 w-14 rounded-full border border-2 border-green-900 "  src="{{asset('images/pexels-pixabay-220453.jpg')}}" alt="Profile Image">
        <div class="flex flex-col items-start justify-center">
            <p class="text-sm text-white font-bold">{{Auth::user()->name}}</p>
            <p class="text-[#a6bba7] text-xs">Agriculturist</p>
        </div>
    </section>

    <section class="w-full flex items-center justify-center mt-5">
        <ul class="w-full flex flex-col items-start justify-center gap-y-2">
            <li class="{{$type == 'dashboard' ? 'bg-white' : ''}} w-full text-start rounded-md py-2 px-2">
                <a aria-label="Go to dashboard" class="{{$type == 'dashboard' ? 'text-black' : 'text-white'}} text-xs font-bold flex items-center justify-start gap-x-2" href="{{route('user.dashboard')}}">
                    <img aria-hidden="true" class="w-5 h-5" src="{{asset('images/icons/home.png')}}" alt="">
                    <p class="hide">Dashboard</p>
                </a>
            </li>
            <li class="{{$type == 'managed farmers' ? 'bg-white' : ''}} w-full text-start rounded-md py-2 px-2">
                <a aria-label="Go to managed farmers" class="{{$type == 'managed farmers' ? 'text-black' : 'text-white'}} text-xs font-bold flex items-center justify-start gap-x-2" href="{{route('personalInformation.index')}}">
                    <img aria-hidden="true" class="w-5 h-5" src="{{asset('images/icons/people.png')}}" alt="">
                    <p class="hide">Managed Farmers</p>
                </a>
            </li>
            <li class="{{$type == 'farm locations' ? 'bg-white' : ''}} w-full text-start rounded-md py-2 px-2">
                <a aria-label="Go to farm locations" class="{{$type == 'farm locations' ? 'text-black' : 'text-white'}} text-xs font-bold flex items-center justify-start gap-x-2" href="">
                    <img aria-hidden="true" class="w-5 h-5" src="{{asset('images/icons/location.png')}}" alt="">
                    <p class="hide">Farm Locations</p>
                </a>
            </li>
            <li class="{{$type == 'seed distributions' ? 'bg-white' : ''}} w-full text-start rounded-md py-2 px-2">
                <a aria-label="Go to seed distributions" class="{{$type == 'seed distributions' ? 'text-black' : 'text-white'}} text-xs font-bold flex items-center justify-start gap-x-2" href="">
                    <img aria-hidden="true" class="w-5 h-5" src="{{asset('images/seed.png')}}" alt="">
                    <p class="hide">Seed Distributions</p>
                </a>
            </li>
            <li class="{{$type == 'canine records' ? 'bg-white' : ''}} w-full text-start rounded-md py-2 px-2">
                <a aria-label="Go to vaccination records" class="{{$type == 'canine records' ? 'text-black' : 'text-white'}} text-xs font-bold flex items-center justify-start gap-x-2" href="">
                    <img aria-hidden="true" class="w-5 h-5" src="{{asset('images/icons/inject.png')}}" alt="">
                    <p class="hide">Canine Vaccination Records</p>
                </a>
            </li>
            <li class="{{$type == 'livestock trackers' ? 'bg-white' : ''}} w-full text-start rounded-md py-2 px-2">
                <a aria-label="Go to livestock owner trackers" class="{{$type == 'livestock trackers' ? 'text-black' : 'text-white'}} text-xs font-bold flex items-center justify-start gap-x-2" href="">
                    <img aria-hidden="true" class="w-5 h-5" src="{{asset('images/icons/people.png')}}" alt="">
                    <p class="hide">Livestock Owner Trackers</p>
                </a>
            </li>
            <li class="{{$type == 'notifications' ? 'bg-white' : ''}} w-full text-start rounded-md py-2 px-2">
                <a aria-label="Go to notifications" class="{{$type == 'notifications' ? 'text-black' : 'text-white'}} text-xs font-bold flex items-center justify-start gap-x-2" href="">
                    <img aria-hidden="true" class="w-5 h-5" src="{{asset('images/icons/notification.png')}}" alt="">
                    <p class="hide">Notifications</p>
                </a>
            </li>
            <li class="{{$type == 'settings' ? 'bg-white' : ''}} w-full text-start rounded-md py-2 px-2">
                <a aria-label="Go to settings" class="{{$type == 'settings' ? 'text-black' : 'text-white'}} text-xs font-bold flex items-center justify-start gap-x-2" href="">
                    <img aria-hidden="true" class="w-5 h-5" src="{{asset('images/icons/setting.png')}}" alt="">
                    <p class="hide">Settings</p>
                </a>
            </li>
        </ul>
    </section>

    <x-logout-button/>

</section>