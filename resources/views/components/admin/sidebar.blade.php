@props(['type'])

@php
    $initial = '';
    if(Auth::user()->middle_name) {
        $initial = Str::upper(Str::substr(Auth::user()->middle_name, 0, 1)) . '.';
    } else {
        $initial = '';
    }
@endphp


<section data-sidebar class="isActive">
    <img data-menu class="absolute h-8 w-8 top-2 rounded-full border-2 bg-white border-white -right-4 rotate-180 cursor-pointer rotateReverse" src="{{asset('images/arrow-right.png')}}" alt="">

    <section class="flex items-center gap-x-1">
        <img class="h-12 w-12 sizeIfHidden" src="{{asset('images/DA-Logo.png')}}" alt="Barugo DA Logo">
        <div><h3  class="text-xs text-white font-bold hide">Farmers Management Platform</h3></div>
    </section>

    <section class="flex flex-col w-full items-center justify-center gap-x-2 mt-5 hide">
        <img class="h-14 w-14 rounded-full border-2 border-green-900 "  src="{{asset('images/pexels-pixabay-220453.jpg')}}" alt="Profile Image">
        <div class="flex w-full flex-col items-center justify-center">
            <p class="text-sm text-white font-bold whitespace-nowrap">{{Auth::user()->first_name . " " . $initial . " " . Auth::user()->last_name}}</p>
            <p class="text-slate-200 text-xs">Agriculturist</p>
        </div>
    </section>

    <section class="w-full flex items-center justify-center mt-5">
        <ul class="w-full flex flex-col items-start justify-center gap-y-2">
            <li class="{{$type == 'dashboard' ? 'bg-white' : ''}} w-full text-start rounded-md py-2 px-2">
                <a aria-label="Go to dashboard" class="{{$type == 'dashboard' ? 'text-black' : 'text-white'}} text-xs font-bold flex items-center justify-start gap-x-2" href="{{route('admin.dashboard')}}">
                    <img aria-hidden="true" class="w-5 h-5 object-contain" src="{{asset('images/icons/home.png')}}" alt="">
                    <p class="hide">Dashboard</p>
                </a>
            </li>
            <li class="{{$type == 'managed farmers' ? 'bg-white' : ''}} w-full text-start rounded-md py-2 px-2">
                <a aria-label="Go to managed farmers" class="{{$type == 'managed farmers' ? 'text-black' : 'text-white'}} text-xs font-bold flex items-center justify-start gap-x-2" href="{{route('adminPersonalInformation.index')}}">
                    <img aria-hidden="true" class="w-5 h-5 object-contain" src="{{asset('images/icons/peasant.png')}}" alt="">
                    <p class="hide">Farmers</p>
                </a>
            </li>
            <li class="{{$type == 'farm locations' ? 'bg-white' : ''}} w-full text-start rounded-md py-2 px-2">
                <a aria-label="Go to farm locations" class="{{$type == 'farm locations' ? 'text-black' : 'text-white'}} text-xs font-bold flex items-center justify-start gap-x-2" href="{{route('adminLocation.index')}}">
                    <img aria-hidden="true" class="w-5 h-5 object-contain" src="{{asset('images/icons/location.png')}}" alt="">
                    <p class="hide">Locations</p>
                </a>
            </li>
            <li class="{{$type == 'seed distributions' ? 'bg-white' : ''}} w-full text-start rounded-md py-2 px-2">
                <a aria-label="Go to seed distributions" class="{{$type == 'seed distributions' ? 'text-black' : 'text-white'}} text-xs font-bold flex items-center justify-start gap-x-2" href="{{route('adminSeedDistribution.index')}}">
                    <img aria-hidden="true" class="w-5 h-5 object-contain" src="{{asset('images/seed.png')}}" alt="">
                    <p class="hide">Seed Distributions</p>
                </a>
            </li>
            <li class="{{$type == 'canine records' ? 'bg-white' : ''}} w-full text-start rounded-md py-2 px-2">
                <a aria-label="Go to vaccination records" class="{{$type == 'canine records' ? 'text-black' : 'text-white'}} text-xs font-bold flex items-center justify-start gap-x-2" href="{{route('adminDogVaccinationInformation.index')}}">
                    <img aria-hidden="true" class="w-5 h-5 object-contain" src="{{asset('images/icons/inject.png')}}" alt="">
                    <p class="hide">Vaccination Records</p>
                </a>
            </li>
            {{-- <li class="{{$type == 'livestock trackers' ? 'bg-white' : ''}} w-full text-start rounded-md py-2 px-2">
                <a aria-label="Go to livestock owner trackers" class="{{$type == 'livestock trackers' ? 'text-black' : 'text-white'}} text-xs font-bold flex items-center justify-start gap-x-2" href="{{route('adminLivestockOwnerTracker.index')}}">
                    <img aria-hidden="true" class="w-5 h-5 object-contain" src="{{asset('images/icons/people.png')}}" alt="">
                    <p class="hide">Livestock Owner Trackers</p>
                </a>
            </li> --}}
            <li class="{{$type == 'logs' ? 'bg-white' : ''}} w-full text-start rounded-md py-2 px-2">
                <a aria-label="Go to notifications" class="{{$type == 'logs' ? 'text-black' : 'text-white'}} text-xs font-bold flex items-center justify-start gap-x-2" href="{{route('activityLogs.index')}}">
                    <img aria-hidden="true" class="w-5 h-5 object-contain" src="{{asset('images/icons/log.png')}}" alt="">
                    <p class="hide">Logs</p>
                </a>
            </li>
            <li class="{{$type == 'Admin Panel' ? 'bg-white' : ''}} w-full text-start rounded-md py-2 px-2">
                <a aria-label="Go to notifications" class="{{$type == 'Admin Panel' ? 'text-black' : 'text-white'}} text-xs font-bold flex items-center justify-start gap-x-2" href="{{route('adminControlPanelSurvey.survey', ['currentRoute' => 'All'])}}">
                    <img aria-hidden="true" class="w-5 h-5 object-contain" src="{{asset('images/icons/Admin.png')}}" alt="">
                    <p class="hide">Admin Control Panel</p>
                </a>
            </li>
            <li class="{{$type == 'Profile' ? 'bg-white' : ''}} w-full text-start rounded-md py-2 px-2">
                <a aria-label="Go to settings" class="{{$type == 'Profile' ? 'text-black' : 'text-white'}} text-xs font-bold flex items-center justify-start gap-x-2" href="{{route('adminProfile.index')}}">
                    <img aria-hidden="true" class="w-5 h-5 object-contain" src="{{asset('images/icons/Profile.png')}}" alt="">
                    <p class="hide">Profile</p>
                </a>
            </li>
        </ul>
    </section>

    <x-logout-button/>

</section>