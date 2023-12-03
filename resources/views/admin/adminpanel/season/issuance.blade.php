<x-app>
    <x-slot:title>
        Admin | Admin Control Panel
    </x-slot:title>

    <x-admin.sidebar type="Admin Panel"/>

    <section class="w-full min-h-screen overflow-hidden">
        <x-admin.controlPanel>Season Control Panel</x-admin.controlPanel>
        <nav class="flex justify-start items-center p-3 sm:p-4 shadow-xl">
            <ul class="flex flex-col sm:flex-row items-center justify-center gap-2 sm:gap-4">
                <li><a class=" p-2 font-semibold" href="{{route('adminControlPanelSurvey.survey', ['currentRoute' => 'All'])}}">Survey Questions</a></li>
                <li><a class=" font-semibold text-green-700 p-2 shadow-md rounded bg-green-200" href="{{route('adminControlPanelSeason.season')}}">Season</a></li>
                <li><a class=" p-2 font-semibold" href="{{route('adminControlPanelSeed.index')}}">Seed Inventory</a></li>
            </ul>
        </nav>

        <section class="w-full overflow-x-auto p-4 overflow-y-hidden">
            <table class="w-[700px] sm:w-full flex flex-col shadow-2xl">
                <tr class="grid grid-cols-1 py-2 bg-green-700 text-white w-full">
                    <th class="w-full px-3 flex flex-col sm:flex-row gap-2 items-center justify-between py-2">
                        <h2 class="text-2xl sm:text-3xl">Seed Issuance History - {{$season . ' ' . $year . ' : ' . $status}}</h2>
                        <a href="{{route('adminSeedIssuanceDownload', ['season' => $Season])}}" class="bg-slate-100 hover:bg-slate-200 text-sm border text-slate-500 py-2 p-2 rounded flex items-center gap-3 cursor-pointer whitespace-nowrap">
                            <img src="{{asset('images/icons/export.png')}}" class="w-[15px] h-[15px]" alt=""> Download Excel
                        </a>
                    </th>
                    <th class="grid grid-cols-7 text-[12px] mt-5">
                        <div>Season</div>
                        <div>Year</div>
                        <div>Name</div>
                        <div>Seed Name</div>
                        <div>Quantity</div>
                        <div>Lot No</div>
                        <div>Address</div>
                    </th>
                </tr>
                @foreach ($issuance_history as $issuance)
                    <tr class="grid py-1 grid-cols-7 w-full odd:bg-gray-400 font-semibold text-sm">
                        <td class="text-center">{{$issuance->season->Season}}</td>
                        <td class="text-center">{{$issuance->season->Year}}</td>
                        @php
                            $name = '';
                            $initial = '';
                            if($issuance->area->Tenant_Name == 'None') {
                                if($issuance->area->personalinformation->Middle_Name) {
                                    $initial = Str::upper(Str::substr($issuance->area->personalinformation->Middle_Name, 0, 1)) . '.';
                                    $name = $issuance->area->personalinformation->First_Name . " " . $initial . " " . $issuance->area->personalinformation->Last_Name;
                                } else {
                                    $name = $issuance->area->personalinformation->First_Name . " " . $issuance->area->personalinformation->Surname;
                                }
                            } else {
                                $name = $issuance->area->Tenant_Name;
                            }
                        @endphp
                        <td class="text-center">{{$name}}</td>
                        <td class="text-center">{{$issuance->Seed_Variety}}</td>
                        <td class="text-center">{{$issuance->Quantity}}</td>
                        <td class="text-center">{{$issuance->area->Lot_No}}</td>
                        <td class="text-center">{{$issuance->area->Owner_Address}}</td>
                    </tr>
                @endforeach
            </table>
            <div class="w-full mt-3">{{$issuance_history->links('pagination::tailwind')}}</div>
        </section>

        <section data-dbar-container class="w-full flex items-center justify-center flex-col mb-11 p-4">
            <h2 class="text-black text-xl font-bold mb-3">Seeds Claimed Per Brgy.</h2>
            <canvas class="block rounded-md shadow-[rgba(0,_0,_0,_0.25)_0px_54px_55px,_rgba(0,_0,_0,_0.12)_0px_-12px_30px,_rgba(0,_0,_0,_0.12)_0px_4px_6px,_rgba(0,_0,_0,_0.17)_0px_12px_13px,_rgba(0,_0,_0,_0.09)_0px_-3px_5px]" id="dbar-chart"></canvas>
        </section>  
    </section>
</x-app>


<script>
    const seedClaimedPerBrgy = {{Js::From($barangay_names)}};
    const dbarCTX = document.getElementById("dbar-chart").getContext('2d');

    /* The code is creating an array called `spreadBrgyName` and populating it with the values of the
    `Brgy_Name` property from each item in the `seedClaimedPerBrgy` array. */
    let spreadBrgyName = [];
    seedClaimedPerBrgy.forEach(item => {
        spreadBrgyName = [...spreadBrgyName, item.Brgy_Name];
    })
    const removedDuplicatesOfBrgy = [...new Set([...spreadBrgyName])]
    const brgyCounts = {};

    // Count the occurrences of each Brgy
    seedClaimedPerBrgy.forEach(item => {
        brgyCounts[item.Brgy_Name] = (brgyCounts[item.Brgy_Name] || 0) + 1;
    })
    const brgyCountsArray = Object.entries(brgyCounts).map(([Brgy_Name, count]) => ({Brgy_Name, count}));
    let brgyNameCount = [];
    brgyCountsArray.forEach(item => {
        brgyNameCount = [...brgyNameCount, item.count];
    })


    const dbarChart = new Chart(dbarCTX, {
            type: 'bar',
            data: {
                labels: [...removedDuplicatesOfBrgy],
                datasets: [
                    {
                        label: "Seeds Claimed Per Brgy",
                        data: [...brgyNameCount],
                        backgroundColor : "rgba(3,149,255,255)",
                        borderwidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true, // Disable aspect ratio
            }
        })


        function setCanvasSize() {
            let dBarContainer = document.querySelector('[data-dbar-container]');
            let dBarCanvas = document.querySelector('#dbar-chart');

            // Set canvas dimensions based on container dimensions
            dBarCanvas.width = dBarContainer.clientWidth;
            dBarCanvas.height = dBarContainer.clientHeight;

            // Redraw the chart after resizing
            dbarChart.update();
        }

        setCanvasSize();

        window.addEventListener("resize", setCanvasSize);

</script>

