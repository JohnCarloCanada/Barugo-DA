<x-app>
    <x-slot:title>
        Add New Area
    </x-slot:title>

    <x-sidebar type="managed farmers"/>   

    <section class="w-full min-h-screen p-10">
        <section class="w-[100%,900px] my-0 mx-auto bg-white flex flex-col items-center justify-center ">
            <h2 class="text-black font-bold text-3xl sm:text-4xl">Add New Area</h2>
            @if ($errors->any())
            <ul class="grid grid-cols-2 sm:grid-cols-4 gap-1 mb-3">
                @foreach ($errors->all() as $error )
                    <li class="text-sm sm:text-base text-red-800 font-bold">{{$error}}</li>
                @endforeach
            </ul>
            @endif
            <section class="w-full mt-10 overflow-y-auto">
                <form class="w-full overflow-y-auto" action="{{route('areaInformation.store', ['personalInformation' => $personalInformation])}}" method="post">
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
                        <input class="bg-[#e8e8e8] w-full px-3 py-1" type="number" name="Hectares" id="Hectares" placeholder="Hectares">
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
                        <label class="sr-only" for="Lat">Latitude: </label>
                        <input class="bg-[#e8e8e8] w-full px-3 py-1" type="text" name="Lat" id="Lat" placeholder="Latitude">
                        <label class="sr-only" for="Lon">Longitude: </label>
                        <input class="bg-[#e8e8e8] w-full px-3 py-1" type="text" name="Lon" id="Lon" placeholder="Longitude">
                    </div>

                    <div class="w-full flex flex-col sm:flex-row items-start sm:items-center justify-end gap-3 my-2">
                        <input class="bg-[#679f69] py-1 px-2 text-white font-bold cursor-pointer" type="submit" value="Add Area">
                    </div>
                </form>
            </section>
        </section>
    </section>
</x-app>

<script>
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
</script>