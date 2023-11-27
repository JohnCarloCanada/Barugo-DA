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
                class="dashboard-cards-style"
            >
                    <img class="w-[5rem]" src="{{asset('images/icons/peasant.png')}}" alt="">
                    <div class="flex flex-col items-center">
                        <p class="">Farmers</p>
                        <p class="text-3xl">{{$farmersCount}}</p>
                    </div>
                </li>
            </a>
            <li
                class="dashboard-cards-style"
            >
                <img class="w-[5rem]" src="{{asset('images/icons/Animals-Icon.png')}}" alt="">
                <div class="flex flex-col items-center">
                    <p class="">Animals</p>
                    <p class="text-3xl">{{$totalAnimals}}</p>
                </div>
            </li>
            <a href="{{route('adminControlPanelSeed.index')}}">
                <li
                class="dashboard-cards-style"
            >
                <img class="w-[5rem]" src="{{asset('images/icons/Seed-Icon.png')}}" alt="">
                <div class="flex flex-col items-center">
                    <p class="">Seeds</p>
                    <p class="text-3xl">{{$totalSeeds}}</p>
                </div>
            </li>
            </a>
            <li
                class="dashboard-cards-style"
            >
                <img class="w-[5rem]" src="{{asset('images/icons/inject.png')}}" alt="">
                <div class="flex flex-col items-center">
                    <p class="">Vaccinations</p>
                    <p class="text-3xl">{{$totalVaccinations}}</p>
                </div>
            </li>
            <a href="{{route('adminLocation.index')}}">
                <li
                    class="dashboard-cards-style"
                >
                    <img class="w-[5rem]" src="{{asset('images/icons/location.png')}}" alt="">
                    <div class="flex flex-col items-center">
                        <p class="">Locations</p>
                        <p class="text-3xl">{{$locationsCount}}</p>
                    </div>
                </li>
            </a>
        </ol>
    </section>

</x-app>