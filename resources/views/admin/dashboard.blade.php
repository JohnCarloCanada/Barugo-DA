<x-app>
    <x-slot:title>
        Admin | Dashboard
    </x-slot:title>

    <x-admin.sidebar type="dashboard"/>

    <section class="w-full min-h-screen p-5 overflow-y-auto">
        <x-admin.titleCard title="Dashboard" slogan="Overview about the system`s activities." />
        <ol class="grid md:grid-cols-3 max-auto grid-cols-1 mt-5 gap-4 relative">
            <a href="{{route('adminPersonalInformation.index')}}">
                <li
                class="flex items-center cursor-pointer bg-green-200 justify-around font-bold text-2xl border-2 border-slate-500 shadow-md rounded-lg h-[10rem]"
            >
                    <img class="w-[5rem]" src="{{asset('images/farmer-3.png')}}" alt="">
                    <div>
                        <p class="">Farmers</p>
                        <p class="text-3xl">{{$farmersCount}}</p>
                    </div>
                </li>
            </a>
            <li
                class="flex items-center cursor-pointer bg-green-200 justify-around font-bold text-2xl  border-2 border-slate-500 shadow-md rounded-lg h-[10rem]"
            >
                <img class="w-[5rem]" src="{{asset('images/chicken.png')}}" alt="">
                <div>
                    <p class="">Animals</p>
                    <p class="text-3xl">100</p>
                </div>
            </li>
            <a href="{{route('adminControlPanelSeed.index')}}">
                <li
                class="flex items-center cursor-pointer bg-green-200 justify-around font-bold text-2xl  border-2 border-slate-500 shadow-md rounded-lg h-[10rem]"
            >
                <img class="w-[5rem]" src="{{asset('images/seeding.png')}}" alt="">
                <div>
                    <p class="">Seeds</p>
                    <p class="text-3xl">{{$totalSeeds}}</p>
                </div>
            </li>
            </a>
            <li
                class="flex items-center cursor-pointer bg-green-200 justify-around font-bold text-2xl  border-2 border-slate-500 shadow-md rounded-lg h-[10rem]"
            >
                <img class="w-[5rem]" src="{{asset('images/syringe.png')}}" alt="">
                <div>
                    <p class="">Vaccinations</p>
                    <p class="text-3xl">{{$totalVaccinations}}</p>
                </div>
            </li>
            <a href="{{route('adminLocation.index')}}">
                <li
                    class="flex items-center cursor-pointer bg-green-200 justify-around font-bold text-2xl  border-2 border-slate-500 shadow-md rounded-lg h-[10rem]"
                >
                    <img class="w-[5rem]" src="{{asset('images/map.png')}}" alt="">
                    <div>
                        <p class="">Locations</p>
                        <p class="text-3xl">{{$locationsCount}}</p>
                    </div>
                </li>
            </a>
        </ol>
    </section>

</x-app>