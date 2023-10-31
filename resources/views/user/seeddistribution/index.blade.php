<x-app>
    <x-slot:title>
        Barugo | Seed Distribution
    </x-slot:title>

    <x-admin.sidebar type="seed distributions"/>

    <section class="w-full min-h-screen bg-green-700 p-5 overflow-y-auto">
        <section class="flex flex-col my-2 items-center justify-center gap-y-6">
            <h2 class="text-2xl sm:text-4xl mx-2 font-bold text-white">Seed Distribution</h2>
            <div class="w-full flex items-center justify-center">
                <div class="py-2 bg-green-700 text-white">
                    <form action="{{route('userSeedDistribution.index')}}" method="GET" class="w-full">
                        @csrf
                        <input name="search" class="w-full px-3 py-1 font-normal bg-slate-100 rounded outline-0 text-ms text-slate-800" placeholder="Search RSBSA_No" type="text" value="{{$search}}">
                    </form>
                </div>
            </div>
        </section>
        <section class="w-[100%,900px] h-[500px] mx-auto overflow-x-auto bg-white rounded-lg">
            <table class="w-full mt-5 text-center">
                <thead>
                    <tr class="text-xs sm:text-base px-4">
                        <th class="">RSBSA No.</th>
                        <th class="">Surname</th>
                        <th class="">Rice Ha</th>
                        <th class="">Corn Ha</th>
                        <th class="">HDCVP Ha</th>
                        <th class="">Claim Status</th>
                        <th class="">Operation</th>
                    </tr>
                </thead>
        
                <tbody>
                    @foreach ($farmers as $farmer)
                        <tr class="pt-10 odd:bg-slate-200 text-sm sm:text-base">
                            <td>{{$farmer->RSBSA_No}}</td>
                            <td>{{$farmer->Surname}}</td>
                            <td>{{$farmer->area->where('Area_Type', 'Rice')->sum('Hectares')}}</td>
                            <td>{{$farmer->area->where('Area_Type', 'Corn')->sum('Hectares')}}</td>
                            <td>{{$farmer->area->where('Area_Type', 'HDCVP')->sum('Hectares')}}</td>
                            <td>
                                <div class="{{$farmer->is_claimed ? 'bg-yellow-600' : 'bg-red-600'}} text-white font-bold text-xs px-2 sm:px-3 py-1 rounded-sm">{{$farmer->is_claimed ? 'Claimed' : 'Not-Claimed'}}</div>
                            </td>
                            <td class="flex items-center justify-center cursor-pointer">
                                <div onclick="showClaimSeedForm({{$farmer}})" class="{{$farmer->RSBSA_No && !$farmer->is_claimed && $farmer->area->count() ? '' : 'hidden'}} bg-green-600 text-white font-bold text-base px-2 sm:px-3 py-1 rounded-sm" type="submit">
                                    Claim
                                </div>
                            </td>		
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="w-full mt-3">{{$farmers->links('pagination::tailwind')}}</div>
        </section>
    </section>
</x-app>


<div id="claimSeedForm" class="hidden">
    <div class="h-screen w-screen bg-gray-500/50 fixed top-0 left-0 z-2 flex items-center justify-center">
        <form method="POST" id="claimSeedFormInputValue" action="{{route('userSeedDistribution.claim')}}" class="p-3 w-full gap-2 text-gray-700 grid md:w-2/4 rounded shadow-md bg-white">
            @csrf
            @method('put')

            <div class="text-[20px] font-semibold w-full flex items-center justify-between px-3 my-2">
                <p>CLAIM SEEDS</p>
                <img onclick="showClaimSeedForm()" src="{{asset('images/close.png')}}" class="w-[16px] h-[16px] cursor-pointer" alt="close">
            </div>
            <input type="text" name="id" id="" class="hidden">
            <div class="w-full px-3 flex flex-col gap-1">
                <label for="Seed_Variety" class="text-[12px] font-semibold">Seed</label>
                <select name="Seed_Variety" id="Seed_Variety" class="w-full border text-gray-700 outline-0 px-2 py-1 shadow-md bg-gray-100">
                    @foreach ($options as $option)
                        <option value="{{$option->Seed_Variety}}">{{$option->Seed_Variety}}</option>
                    @endforeach
                </select>
            </div>
            <div class="w-full px-3 flex flex-col gap-1">
                <label for="Quantity" class="text-[12px] font-semibold">Seed Quantity</label>
                <input type="number" name="Quantity" id="Quantity" placeholder="Enter Quantity of Seeds" class="w-full border outline-0 px-2 py-1 shadow-md bg-gray-100">
            </div>
            <div class="px-3">
                <button type="submit" class="py-2 w-full mt-3 text-white hover:bg-green-500 rounded font-bold bg-green-700">
                    Claim Seeds
                </button>
            </div>
        </form>
    </div>
</div>


<script>
    const claimSeedForm = document.getElementById('claimSeedForm');
    const form = document.getElementById('claimSeedFormInputValue');

    const showClaimSeedForm = (farmer) => {
        if(claimSeedForm) {
            if(claimSeedForm.classList == 'hidden') { 
                claimSeedForm.classList.remove("hidden")
                if (form && farmer) {
                    form.id.value = farmer.RSBSA_No;
                }
            }
            else {
                claimSeedForm.classList.add("hidden")
            }
        }
    }
</script>