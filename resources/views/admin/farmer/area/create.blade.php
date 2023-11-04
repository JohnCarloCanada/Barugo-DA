<x-app>
    <x-slot:title>
        Add New Area
    </x-slot:title>

    <x-sidebar type="managed farmers"/>   

    <section class="w-full min-h-screen p-10">
        <section class="w-[100%,900px] p-3 my-0 mx-auto bg-white flex flex-col items-center justify-center ">
            <h2 class="text-black font-bold text-3xl sm:text-4xl">Add New Area</h2>
            @if ($errors->any())
            <ul class="grid grid-cols-2 sm:grid-cols-4 gap-1 mb-3">
                @foreach ($errors->all() as $error )
                    <li class="text-sm sm:text-base text-red-800 font-bold">{{$error}}</li>
                @endforeach
            </ul>
            @endif
            <section class="w-full mt-10 overflow-y-auto">
                <form class="w-full overflow-y-auto" action="{{route('adminAreaInformation.store', ['personalInformation' => $personalInformation])}}" method="post">
                    @csrf

                    @if ($errors->any())
                    <ul class="grid grid-cols-2 sm:grid-cols-4 gap-1 mb-3">
                        @foreach ($errors->all() as $error )
                            <li class="text-sm sm:text-base text-red-800 font-bold">{{$error}}</li>
                        @endforeach
                    </ul>
                    @endif
                    <h3 class="bg-[#679f69] px-3 py-1 font-bold text-white">Area</h3>

                    <div class="w-full flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 my-2">
                        <label class="sr-only" for="Lot_No">Lot No: </label>
                        <input class="bg-[#e8e8e8] w-full px-3 py-1" type="text" name="Lot_No" id="Lot_No" placeholder="Lot No">
                        <label class="sr-only" for="Hectares">Hectares: </label>
                        <input class="bg-[#e8e8e8] w-full px-3 py-1" step="0.01" type="number" name="Hectares" id="Hectares" placeholder="Hectares">
                        <label class="sr-only" for="Address">Address: </label>
                        <input class="bg-[#e8e8e8] w-[min(100%,300px)] px-3 py-1" type="text" name="Address" id="Address" placeholder="Address">
                        <label class="sr-only" for="Owner_Address">Owner Address: </label>
                        <input class="bg-[#e8e8e8] w-full px-3 py-1" type="text" name="Owner_Address" id="Owner_Address" placeholder="Owner Address">
                    </div>

                    <div class="w-full flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 my-2">
                        <div class="w-full flex flex-col sm:flex-row items-start sm:items-center justify-start gap-2 bg-[#e8e8e8] px-3 py-1">
                            <p class="font-semibold text-base text-gray-400 mr-3">Area</p>
                            <div class="flex items-center justify-center gap-1 mr-3">
                                <input class="w-full" type="radio" name="Area_Type" id="Rice" value="Rice">
                                <label class="text-gray-400" for="Rice">Rice</label>
                            </div>
                            <div class="flex items-center justify-center gap-1 mr-3">
                                <input type="radio" name="Area_Type" id="Corn" value="Corn">
                                <label class="text-gray-400" for="Corn">Corn</label>
                            </div>
                            <div class="flex items-center justify-center gap-1 mr-3">
                                <input type="radio" name="Area_Type" id="HDCVP" value="HDCVP">
                                <label data-HDCVP class="text-gray-400" for="HDCVP">HDCVP</label>
                            </div>
                        </div>
                        <label class="sr-only" for="Commodity_planted">Commodity Planted: </label>
                        <input data-commodity disabled class="bg-[#e8e8e8] w-[50%] px-3 py-1" type="text" name="Commodity_planted" id="Commodity_planted" placeholder="Commodity Planted">
                    </div>

                    <div class="w-full flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 my-2">
                        <div class="w-full flex flex-col sm:flex-row items-start sm:items-center justify-start gap-2 bg-[#e8e8e8] px-3 py-1">
                            <p class="font-semibold text-base text-gray-400 mr-3">Ownership Type</p>
                            <div class="flex items-center justify-center gap-1 mr-3">
                                <input class="w-full" type="radio" name="Ownership_Type" id="Owner" value="Owner">
                                <label class="text-gray-400" for="Owner">Owner</label>
                            </div>
                            <div class="flex items-center justify-center gap-1 mr-3">
                                <input type="radio" name="Ownership_Type" id="Tenant" value="Tenant">
                                <label class="text-gray-400" for="Tenant">Tenant</label>
                            </div>
                        </div>
                        <label class="sr-only" for="Tenant_Name">Tenant Name: </label>
                        <input data-tenant disabled class="bg-[#e8e8e8] w-[50%] px-3 py-1" type="text" name="Tenant_Name" id="Tenant_Name" placeholder="Tenant Name">
                    </div>

                    <div class="w-full flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 my-2">
                        <div class="w-full flex flex-col sm:flex-row items-start sm:items-center justify-start gap-2 bg-[#e8e8e8] px-3 py-1">
                            <p class="font-semibold text-base text-gray-400 mr-3">Farm Type</p>
                            <div class="flex items-center justify-center gap-1 mr-3">
                                <input class="w-full" type="radio" name="Farm_Type" id="Irrigated" value="Irrigated">
                                <label class="text-gray-400" for="Irrigated">Irrigated</label>
                            </div>
                            <div class="flex items-center justify-center gap-1 mr-3">
                                <input type="radio" name="Farm_Type" id="Rainfed" value="Rainfed">
                                <label class="text-gray-400" for="Rainfed">Rainfed</label>
                            </div>
                        </div>
                        <div class="hidden">
                            <label class="sr-only" for="Lat">Latitude: </label>
                            <input class="bg-[#e8e8e8] w-full px-3 py-1" type="text" name="Lat" id="Lat" placeholder="Latitude">
                            <label class="sr-only" for="Lon">Longitude: </label>
                            <input class="bg-[#e8e8e8] w-full px-3 py-1" type="text" name="Lon" id="Lon" placeholder="Longitude">
                        </div>
                    </div>
                    <div class="">
                        <p class="py-1 font-semibold text-green-700 bg-green-200 my-1 w-fit px-2 py-1 rounded">Select the location</p>
                        <div id="map" class="w-full rounded h-[400px]"></div>
                    </div>

                    <div class="w-full flex flex-col sm:flex-row items-start sm:items-center justify-end gap-3 my-4">
                        <input class="bg-[#679f69] p-2 text-white font-bold rounded hover:bg-green-400 cursor-pointer" type="submit" value="Add Area">
                    </div>
                </form>
            </section>
        </section>
    </section>
</x-app>

<script>
    const LatInput = document.getElementById("Lat")
    const LonInput = document.getElementById("Lon")
    const areaTypeBtn = document.querySelectorAll('input[name="Area_Type"]');
    const commodityInput = document.querySelector('[data-commodity]');

    const ownerShipTypeBtn = document.querySelectorAll('input[name="Ownership_Type"]');
    const tenantInput = document.querySelector('[data-tenant]');
    
    areaTypeBtn.forEach(btn => {
        btn.addEventListener('change', () => {
            if(btn.value === 'HDCVP') {
                commodityInput.disabled = false;
            } else {
                commodityInput.disabled = true;
            }
        })
    });

    ownerShipTypeBtn.forEach(btn => {
        btn.addEventListener('change', () => {
            if(btn.value === 'Tenant') {
                tenantInput.disabled = false;
            } else {
                tenantInput.disabled = true;
            }
        })
    })

    let map = L.map('map').setView([11.3002, 124.7630], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);


    map.on('click', function(event) {
        const latlng = event.latlng;
        addOrUpdateMarker(latlng.lat,latlng.lng)
    });



    const addOrUpdateMarker=(lat, lng)=> {
        LatInput.value = lat
        LonInput.value = lng
        console.log(LonInput.value,LatInput.value)
        map.eachLayer(function (layer) {
            if (layer instanceof L.Marker) {
                map.removeLayer(layer);
            }
        });

        const marker = L.marker([parseFloat(lat), parseFloat(lng)]).addTo(map);
        
        marker.bindPopup('Selected location').openPopup();
    }

</script>