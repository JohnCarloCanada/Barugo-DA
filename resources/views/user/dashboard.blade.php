<x-app>
    <x-slot:title>
        barugo | User Dashboard
    </x-slot:title>

    <x-sidebar type="dashboard"/>
    
    <section class="w-full min-h-screen p-5">
        <h1 class="sr-only">Barugo Information Management System</h1>
        <section class="mb-4">
            <p class="font-semibold text-xl text-black">Hello <span>{{Auth::user()->name}}</span>!</p>
            <p class="text-xs font-bold text-black mt-1">Welcome back and keep up the good work!</p>
        </section>

        <section class="w-full flex flex-col sm:flex-row items-start justify-between gap-x-3 gap-y-3 sm:gap-y-0">
            <section class="w-full flex flex-col items-center justify-center gap-3">
                <section class="w-full">
                    <h2 class="text-black text-xl font-bold mb-3">Overview</h2>
                    <div class="flex items-center justify-between flex-col sm:flex-row gap-y-5 sm:gap-y-0 sm:gap-x-10">
                        <div class="w-full py-5 px-10 flex items-center justify-center gap-x-14 rounded-2xl shadow-[0px_0px_2px_black]">
                            <img class="w-14 h-14" src="{{asset('images/farmer.png')}}" alt="">
                            <div class="text-end">
                                <p class="text-2xl sm:text-3xl text-black font-bold">{{$count}}</p>
                                <p class="text-xs font-bold text-black" >Total Farmers</p>
                            </div> 
                        </div>
    
                        <div class="w-full py-5 px-10 flex items-center justify-center gap-x-14 rounded-2xl shadow-[0px_0px_2px_black]">
                            <img class="w-14 h-14" src="{{asset('images/garden.png')}}" alt="">
                            <div class="text-end">
                                <p class="text-2xl sm:text-3xl text-black font-bold">140</p>
                                <p class="text-xs font-bold text-black" >Total Hectares</p>
                            </div>
                        </div>
                    </div>
                </section>

                <section data-dbar-container class="w-[95%] max-w-[600px] h-[50vh] relative m-[0_auto]">
                    <h2 class="text-black text-xl font-bold mb-3">Livestock</h2>
                    <canvas class="block rounded-2xl shadow-[0px_0px_2px_black]" id="dbar-chart"></canvas>
                </section>  
            </section>
    
            <section class="w-full flex flex-col items-center justify-center gap-3 mt-10 sm:mt-0">
                <section data-horiddbar-container class="w-[95%] max-w-[600px] h-[50vh] relative m-[0_auto]">
                    <h2 class="text-black text-xl font-bold mb-3">Machinery</h2>
                    <canvas class="block rounded-2xl shadow-[0px_0px_2px_black]" id="hori-dbar-chart"></canvas>
                </section>

                <div class="mt-12 w-full h-[200px]">
                    <h2 class="m-[3rem,0] font-[700]">Recently Added</h2>

                    <section class="flex w-full h-[200px] overflow-y-scroll flex-col gap-[0.5rem] p-[1rem]">
                        @foreach ($latestEntries as $latestEntrie )
                            <div class="flex items-center justify-around p-[0.5rem] shadow-[0_0_4px_black] rounded-[12px] w-full">
                                <p class="font-[700] text-[1.1rem]">{{$latestEntrie->First_Name}}</p>
                                <p class="font-[700] text-[1.1rem]">{{$latestEntrie->Address}}</p>
                            </div>
                        @endforeach
                    </section>
                </div>

            </section>
        </section>
    </section>
    
    <script>
        const livestocks = {{Js::From($livestocks)}};
        const dbarCTX = document.getElementById("dbar-chart").getContext('2d');
        const horidbarCTX = document.getElementById("hori-dbar-chart").getContext('2d');

        const maleLivestock = livestocks.filter(livestock => livestock.Sex_LS === "Male");
        const femaleLivestock = livestocks.filter(livestock => livestock.Sex_LS === "Female");


       
        const dbarChart = new Chart(dbarCTX, {
            type: 'bar',
            data: {
                labels: ["Carabao", "Cattle", "Goat", "Sheep", "Swine"],
                datasets: [
                    {
                        label: "Male",
                        data: 
                        [
                            maleLivestock.filter(LS => LS.LSAnimals === "Carabao").length, 
                            maleLivestock.filter(LS => LS.LSAnimals === "Cattle").length, 
                            maleLivestock.filter(LS => LS.LSAnimals === "Goat").length, 
                            maleLivestock.filter(LS => LS.LSAnimals === "Sheep").length, 
                            maleLivestock.filter(LS => LS.LSAnimals === "Swine").length,
                        ],
                        backgroundColor : "rgba(3,149,255,255)",
                        borderwidth: 1
                    },
                    {
                        label: "Female",
                        data:
                        [
                            femaleLivestock.filter(LS => LS.LSAnimals === "Carabao").length, 
                            femaleLivestock.filter(LS => LS.LSAnimals === "Cattle").length, 
                            femaleLivestock.filter(LS => LS.LSAnimals === "Goat").length, 
                            femaleLivestock.filter(LS => LS.LSAnimals === "Sheep").length, 
                            femaleLivestock.filter(LS => LS.LSAnimals === "Swine").length,
                        ],
                        backgroundColor : "rgba(255,44,94,255)",
                        borderwidth: 1
                    },
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false, // Disable aspect ratio
            }
        })

        const horidChart = new Chart(horidbarCTX, {
            type: 'bar',
            data: {
                labels: ["Hand Tractor", "Palay Threaser", "Rice Mill", "Wheel Tractor", "Combine Harvester"],
                datasets: [
                    {
                        axis: 'y',
                        label: "# of owners",
                        data: [4, 5, 6, 8, 9],
                        fill: false,
                        borderwidth: 1,
                    }
                ],
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false, // Disable aspect ratio
            }
        })

        function setCanvasSize() {
            let dBarContainer = document.querySelector('[data-dbar-container]');
            let dBarCanvas = document.querySelector('#dbar-chart');

            let horiDbarContainer = document.querySelector('[data-horiddbar-container]');
            let horiDbarCanvas = document.querySelector('#hori-dbar-chart');

            // Set canvas dimensions based on container dimensions
            dBarCanvas.width = dBarContainer.clientWidth;
            dBarCanvas.height = dBarContainer.clientHeight;

            horiDbarCanvas.width = horiDbarContainer.clientWidth;
            horiDbarCanvas.height = horiDbarContainer.clientHeight;

            // Redraw the chart after resizing
            dbarChart.update();
            horidChart.update();

        }

        setCanvasSize();

        window.addEventListener("resize", setCanvasSize);
    </script>
</x-app>