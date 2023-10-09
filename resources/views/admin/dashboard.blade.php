<x-app>
    <x-slot:title>
        Admin | Dashboard
    </x-slot:title>

    <x-admin.sidebar type="dashboard"/>

    <section class="w-full h-full p-5 overflow-y-auto">
        <x-admin.titleCard title="Dashboard" slogan="Overview about the system`s activities." />
        <ol class="grid md:grid-cols-3 max-auto grid-cols-1 mt-5 gap-4 relative">
            <a href="{{route('admin.farmer')}}">
                <li
                class="flex items-center cursor-pointer bg-green-200 justify-around font-bold text-2xl border border-2 border-slate-500 shadow-md rounded-lg h-[10rem]"
            >
                    <img class="w-[5rem]" src="{{asset('images/farmer-3.png')}}" alt="">
                    <div>
                        <p class="">Farmers</p>
                        <p class="text-3xl">{{$count}}</p>
                    </div>
                </li>
            </a>
            <a href="{{route('personnel.index')}}">
                <li
                    class="flex items-center cursor-pointer bg-green-200 justify-around font-bold text-2xl border border-2 border-slate-500 shadow-md rounded-lg h-[10rem]"
                >
                    <img class="w-[5rem]" src="{{asset('images/personnel.png')}}" alt="">
                    <div>
                        <p class="">Personnel</p>
                        <p class="text-3xl">{{$userCount}}</p>
                    </div>
                </li>
            </a>
            <li
                class="flex items-center cursor-pointer bg-green-200 justify-around font-bold text-2xl border border-2 border-slate-500 shadow-md rounded-lg h-[10rem]"
            >
                <img class="w-[5rem]" src="{{asset('images/chicken.png')}}" alt="">
                <div>
                    <p class="">Animals</p>
                    <p class="text-3xl">100</p>
                </div>
            </li>
            <li
                class="flex items-center cursor-pointer bg-green-200 justify-around font-bold text-2xl border border-2 border-slate-500 shadow-md rounded-lg h-[10rem]"
            >
                <img class="w-[5rem]" src="{{asset('images/seeding.png')}}" alt="">
                <div>
                    <p class="">Seeds</p>
                    <p class="text-3xl">100</p>
                </div>
            </li>
            <li
                class="flex items-center cursor-pointer bg-green-200 justify-around font-bold text-2xl border border-2 border-slate-500 shadow-md rounded-lg h-[10rem]"
            >
                <img class="w-[5rem]" src="{{asset('images/syringe.png')}}" alt="">
                <div>
                    <p class="">Vaccinations</p>
                    <p class="text-3xl">100</p>
                </div>
            </li>
            <a href="{{route('admin.location')}}">
                <li
                    class="flex items-center cursor-pointer bg-green-200 justify-around font-bold text-2xl border border-2 border-slate-500 shadow-md rounded-lg h-[10rem]"
                >
                    <img class="w-[5rem]" src="{{asset('images/map.png')}}" alt="">
                    <div>
                        <p class="">Locations</p>
                        <p class="text-3xl">100</p>
                    </div>
                </li>
            </a>
        </ol>
    </section>

</x-app>