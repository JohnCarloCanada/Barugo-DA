<x-app>
    <x-slot:title>
        Managed Farmers
    </x-slot:title>

    <x-sidebar type="managed farmers"/>   

    <section class="w-full min-h-screen p-5">
        <section class="flex flex-col items-start justify-center gap-y-6">
            <h2 class="text-2xl sm:text-4xl font-bold text-black">Managed Farmers</h2>
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-y-3 sm:gap-y-0 justify-center gap-x-3">
                <a aria-label="Go to add farmers" class="py-1 px-4 bg-[#679f69] rounded-xl flex items-center justify-between gap-x-4" href="{{route('managed.create')}}">
                    <img aria-hidden="true" class="w-5 h-5 object-contain" src="{{asset('images/icons/plus.png')}}" alt="">
                    <p class="text-white font-bold text-base">Add New Farmers</p>
                </a>
                <ul class="py-1 px-4 bg-[#679f69] rounded-xl flex items-center justify-between gap-x-4">
                    <p class="text-white font-bold text-base">Sort</p>
                    <img aria-hidden="true" class="w-5 h-5 object-contain" src="{{asset('images/icons/down-arrow.png')}}" alt="">
                </ul>
            </div>
        </section>
    </section>
</x-app>