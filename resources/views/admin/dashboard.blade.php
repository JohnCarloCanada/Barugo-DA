<x-app>
    <x-slot:title>
        Admin | Dashboard
    </x-slot:title>

    <x-admin.sidebar type="dashboard"/>

    <section class="grid w-full h-full p-5">
        <div class=" my-3">
            <h2 class="font-bold text-2xl">Dashboard</h2>
            <p class="text-sm">Overview about the system`s activities.</p>
        </div>
        <ol class="grid md:grid-cols-4 max-auto grid-cols-1 mt-5 gap-4 relative">
            <li
                class="flex items-center cursor-pointer bg-green-200 justify-around font-bold text-2xl border border-2 border-slate-500 shadow-md rounded-lg h-[10rem]"
            >
                <img class="w-[5rem]" src="{{asset('images/farmer-3.png')}}" alt="">
                <div>
                    <p class="">Farmers</p>
                    <p class="text-3xl">{{$count}}</p>
                </div>
            </li>
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
        </ol>
    </section>

</x-app>