<x-app>
    <x-slot:title>
        Admin | Location
    </x-slot:title>

    <x-admin.sidebar type="farm locations"/>

    <section class="grid w-full h-full p-5">
        <div class=" my-3">
            <h2 class="font-bold text-2xl">Farmer`s Location</h2>
            <p class="text-sm md:w-1/2 w-full">Their livelihood's urban location ensured access to a diverse market and numerous customers for their fresh produce.</p>
        </div>
        <div class="flex flex-col w-full h-full">
            <table class="flex flex-col w-full shadow-md border border-2 rounded">
                <tr class="grid grid-cols-1 py-2 bg-green-500 text-white w-full">
                    <th class="w-full px-3 bg-green-500 relative flex md:justify-end justify-center items-center py-2">
                        <input class="md:w-1/2 px-3 py-1 bg-slate-100 rounded outline-0 text-ms text-slate-800 w-[90%]" placeholder="Search..." type="text">
                    </th>
                    <th class="grid grid-cols-6">
                        <div>Ownership</div>
                        <div>Location</div>
                        <div>Hectare</div>
                        <div>Revenue</div>
                        <div>Rent</div>
                        <div>Operation</div>
                    </th>
                </tr>
                @foreach ([1,2,3,4] as $item)
                    
                <tr class="grid py-1 odd:bg-slate-200 grid-cols-6 w-full">
                    <td>lorem</td>
                    <td>lorem</td>
                    <td>lorem</td>
                    <td>lorem</td>
                    <td>lorem</td>
                    <td class="grid grid-cols-3 gap-2">
                        <a href="{{route('admin.map')}}"><img class="w-8 p-1 hover:bg-green-300/50 rounded-full" src="{{asset('images/icons/view.png')}}" alt=""></a>
                        <div><img class="w-8 p-1 hover:bg-green-300/50 rounded-full" src="{{asset('images/icons/update.png')}}" alt=""></div>
                        <div><img class="w-8 p-1 hover:bg-green-300/50 rounded-full" src="{{asset('images/icons/delete.png')}}" alt=""></div>
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
    </section>
</x-app>