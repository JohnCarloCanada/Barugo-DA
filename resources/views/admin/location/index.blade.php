<x-app>
    <x-slot:title>
        Admin | Location
    </x-slot:title>

    <x-admin.sidebar type="farm locations"/>

    <section class="w-full min-h-screen p-5">
        <x-admin.titleCard title="Farmer`s Location" slogan="Their livelihood's urban location ensured access to a diverse market and numerous customers for their fresh produce." />
        <div class="w-full flex flex-col-reverse sm:flex-row items-start justify-between gap-4 sm:gap-5 overflow-hidden bg-white p-5">
            <div id="map" class="w-full sm:w-[50%] h-[400px]"></div>
            <section class="w-full flex flex-col items-start justify-center sm:w-[50%]">
                <div class="px-3 py-5 bg-green-700 text-white w-full">
                    <form action="{{route('adminLocation.index')}}" method="GET" class="w-full">
                        @csrf
                        <input name="search" class="w-[50%] px-3 py-1 font-normal bg-slate-100 rounded outline-0 text-ms text-slate-800" placeholder="Search..." type="text" value="">
                    </form>
                </div>
                <table class="w-full text-center">
                    <thead>
                        <tr>
                            <th class="">RSBSA No.</th>
                            <th class="">Last Name</th>
                            <th class="">Operation</th>
                        </tr>
                    </thead>   
                    <tbody>
                        @foreach ($farmers as $farmer)
                            <tr class="pt-10 odd:bg-slate-300">
                                <td>{{$farmer->RSBSA_No}}</td>
                                <td>{{$farmer->Surname}}</td>
                                <td class="flex items-center justify-center">
                                    @if ($currentFarmer === NULL)
                                        <a href="{{route('geoMapping.adminShowSpecificFarmerMap', ['personalInformation' => $farmer])}}">
                                            <img class="max-w-[34px] p-1 hover:bg-green-300/50 rounded-full" src="{{asset('images/icons/Not-Viewed.png')}}" alt="">
                                        </a>
                                    @elseif ($currentFarmer->RSBSA_No === $farmer->RSBSA_No)
                                        <a href="{{route('geoMapping.adminShowSpecificFarmerMap', ['personalInformation' => $farmer])}}">
                                            <img class="max-w-[34px] p-1 hover:bg-green-300/50 rounded-full" src="{{asset('images/icons/view.png')}}" alt="">
                                        </a> 
                                    @else
                                        <a href="{{route('geoMapping.adminShowSpecificFarmerMap', ['personalInformation' => $farmer])}}">
                                            <img class="max-w-[34px] p-1 hover:bg-green-300/50 rounded-full" src="{{asset('images/icons/Not-Viewed.png')}}" alt="">
                                        </a>
                                    @endif
                                </td>		
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-3 sm:mt-4 shadow-2xl w-full">{{ $farmers->links('pagination::tailwind')}}</div>
            </section>
        </div>
    </section>
</x-app>

<script>
    const locations = {{Js::From($locations)}}
    console.log(locations)

    let map = L.map('map').setView([11.3002, 124.7630], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

    locations.forEach(location => {
        var marker = L.marker([parseFloat(location.Lat), parseFloat(location.Lon)]).addTo(map);
        marker.bindPopup(`${location.Lot_No}-${location.Area_Type} Area`).openPopup();
    });
</script>