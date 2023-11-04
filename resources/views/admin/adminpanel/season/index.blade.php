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
                    <th class="w-full px-3 flex flex-col sm:flex-row gap-3 items-center justify-between relative py-2">
                        <div data-show-form class="flex items-center gap-3 cursor-pointer">
                            <img src="{{asset('images/icons/plus.png')}}" class="hover:bg-green-200 w-[25px] h-[25px] border bg-slate-100 rounded-full p-1" alt=""> <p class="whitespace-nowrap">Add New Season</p>
                        </div>
                        <div class="py-2 bg-green-700 text-white">
                            <form action="" method="GET" class="w-full">
                                @csrf
                                <input name="search" class="px-3 py-1 font-normal bg-slate-100 rounded outline-0 text-ms text-slate-800" placeholder="Search..." type="text" value="">
                            </form>
                        </div>
                    </th>
                    <th class="grid grid-cols-5 text-[12px] mt-5">
                        <div>Year</div>
                        <div>Season</div>
                        <div class="whitespace-nowrap">No. of Seeds</div>
                        <div>Status</div>
                        <div>Actions</div>
                    </th>
                </tr>
                @foreach ($seasons as $season)
                    <tr class="grid py-1 grid-cols-5 w-full odd:bg-gray-400 font-semibold text-sm">
                        <td class="text-center">{{$season->Year}}</td>
                        <td class="text-center">{{$season->Season}}</td>
                        <td class="text-center">{{$season->Quantity_of_Seeds}}</td>
                        <td class="text-center w-full flex items-center justify-center">
                            <div class="{{Str::lower($season->Status) == 'inactive' ? 'bg-red-600' : 'bg-yellow-600'}} font-bold text-white py-1 px-3 rounded-sm text-sm">{{$season->Status}}</div>
                        </td>
                        <td class="text-center flex flex-col md:flex-row items-center justify-center gap-2">
                            <div onclick="showPersonnelEditForm({{$season}})" class="{{ Str::lower($season->Status) == 'inactive' ? 'hidden' : '' }} bg-green-600 font-bold text-white py-1 px-3 rounded-sm text-xs sm:text-sm cursor-pointer">Edit</div>
                            <div data-seed-show class="{{ Str::lower($season->Status) == 'inactive' ? 'hidden' : '' }} bg-green-500 font-bold text-white py-1 px-3 rounded-sm text-xs sm:text-sm cursor-pointer">Seeds</div>
                            <div class="{{ Str::lower($season->Status) == 'inactive' ? '' : 'hidden' }} bg-green-500 font-bold text-white py-1 px-3 rounded-sm text-xs sm:text-sm cursor-pointer">View</div>
                            <form class="{{ Str::lower($season->Status) == 'inactive' ? 'hidden' : '' }}" action="{{route('adminControlPanelSeason.end', ['season' => $season])}}" method="post">
                                @csrf
                                @method('put')

                                <button type="submit" class="bg-red-600 font-bold text-white py-1 px-3 rounded-sm text-xs sm:text-sm cursor-pointer whitespace-nowrap">End</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </table>
            <div class="w-full mt-3">{{$seasons->links('pagination::tailwind')}}</div>
        </section>
    </section>

</x-app>


<div id="addSeasonForm" class="hidden" >
    <div class="h-screen w-screen bg-gray-500/50 fixed top-0 left-0 z-2 flex items-center justify-center">
        <form method="POST" action="{{route('adminControlPanelSeason.store')}}" class="p-3 w-full gap-2 text-gray-700 grid md:w-2/4 rounded shadow-md bg-white">
            @csrf
            <div class="text-[20px] font-semibold w-full flex items-center justify-between px-3 my-2">
                <p>Add New Season</p>
                <img data-show-close src="{{asset('images/close.png')}}" class="w-[16px] h-[16px] cursor-pointer" alt="close">
            </div>
            <div class="w-full px-3 flex flex-col gap-1">
                <label for="Season" class="text-[12px] font-semibold">Season</label>
                <select name="Season" id="Season" class="w-full border text-gray-700 outline-0 px-2 py-1 shadow-md bg-gray-100">
                    <option value="Wet Season">Wet Season</option>
                    <option value="Dry Season">Dry Season</option>
                </select>
            </div>
            <div class="px-3">
                <button type="submit" class="py-2 w-full mt-3 text-white hover:bg-green-500 rounded font-bold bg-green-700">
                    ADD SEED
                </button>
            </div>
        </form>
    </div> 
</div>

<div id="editSeasonForm" class="hidden">
    <div class="h-screen w-screen bg-gray-500/50 fixed top-0 left-0 z-2 flex items-center justify-center">
        <form method="POST" id="editSeasonFormInputValue" action="{{route('adminControlPanelSeason.edit')}}" class="p-3 w-full gap-2 text-gray-700 grid md:w-2/4 rounded shadow-md bg-white">
            @csrf
            @method('put')
            <div class="text-[20px] font-semibold w-full flex items-center justify-between px-3 my-2">
                <p>UPDATE PERSONNEL</p>
                <img onclick="showPersonnelEditForm()" src="{{asset('images/close.png')}}" class="w-[16px] h-[16px] cursor-pointer" alt="close">
            </div>
            <input type="text" name="id" id="" class="hidden">
            <div class="w-full px-3 flex flex-col gap-1">
                <label for="Season" class="text-[12px] font-semibold">Season</label>
                <select name="Season" id="Season" class="w-full border text-gray-700 outline-0 px-2 py-1 shadow-md bg-gray-100">
                    <option value="Wet Season">Wet Season</option>
                    <option value="Dry Season">Dry Season</option>
                </select>
            </div>
            <div class="px-3">
                <button type="submit" class="py-2 w-full mt-3 text-white hover:bg-green-500 rounded font-bold bg-green-700">
                    Edit Season
                </button>
            </div>
        </form>
    </div>
</div>

{{-- SEEDS ADDING --}}

<div id="addSeedsForm" class="hidden" >
    <div class="h-screen w-screen bg-gray-500/50 fixed top-0 left-0 z-2 flex items-center justify-center">
        <form method="POST" action="{{route('seedInventoryStore.store')}}" class="p-3 w-full gap-2 text-gray-700 grid md:w-2/4 rounded shadow-md bg-white">
            @csrf
            <div class="text-[20px] font-semibold w-full flex items-center justify-between px-3 my-2">
                <p>Add New Season</p>
                <img data-seed-close src="{{asset('images/close.png')}}" class="w-[16px] h-[16px] cursor-pointer" alt="close">
            </div>
            <div class="w-full px-3 flex flex-col gap-1">
                <label for="Seed_Type" class="text-[12px] font-semibold">Type</label>
                <select name="Seed_Type" id="Seed_Type" class="w-full border text-gray-700 outline-0 px-2 py-1 shadow-md bg-gray-100">
                    <option value="Hybrid Rice">Hybrid</option>
                    <option value="Inbred Rice">Inbred</option>
                    <option value="Vegetable">Vegetable</option>
                </select>
            </div>
            <div class="w-full px-3 flex flex-col gap-1">
                <label for="Seed_Variety" class="text-[12px] font-semibold">Seed</label>
                <input type="text" name="Seed_Variety" id="Seed_Variety" placeholder="Enter Seed..." class="w-full border outline-0 px-2 py-1 shadow-md bg-gray-100">
            </div>
            <div class="w-full px-3 flex flex-col gap-1">
                <label for="Company" class="text-[12px] font-semibold">Company</label>
                <input type="text" name="Company" id="Company" placeholder="Enter Company..." class="w-full border outline-0 px-2 py-1 shadow-md bg-gray-100">
            </div>
            <div class="w-full px-3 flex flex-col gap-1">
                <label for="Quantity" class="text-[12px] font-semibold">Seed Quantity</label>
                <input type="number" name="Quantity" id="Quantity" placeholder="Enter Quantity..." class="w-full border outline-0 px-2 py-1 shadow-md bg-gray-100">
            </div>
            <div class="px-3">
                <button type="submit" class="py-2 w-full mt-3 text-white hover:bg-green-500 rounded font-bold bg-green-700">
                    ADD SEED
                </button>
            </div>
        </form>
    </div> 
</div>


<script>
    const addSeasonForm = document.getElementById('addSeasonForm');
    const editSeasonForm = document.getElementById('editSeasonForm');

    const btnShowClose = document.querySelector('[data-show-close]');
    const btnShowForm = document.querySelector('[data-show-form]');

    const addSeedsForm = document.getElementById('addSeedsForm');

    const btnSeedClose = document.querySelector('[data-seed-close]');
    const btnSeedShow = document.querySelector('[data-seed-show]');


    const form = document.getElementById('editSeasonFormInputValue');

    btnShowForm.addEventListener('click', () => {
        addSeasonForm.classList.toggle('hidden');
    });

    btnShowClose.addEventListener('click', () => {
        addSeasonForm.classList.add('hidden');
    });

    btnSeedShow.addEventListener('click', () => {
        addSeedsForm.classList.toggle('hidden');
    });

    btnSeedClose.addEventListener('click', () => {
        addSeedsForm.classList.add('hidden');
    });


    const showPersonnelEditForm=(season)=>{
        if(editSeasonForm) {
            if(editSeasonForm.classList == 'hidden') { 
                editSeasonForm.classList.remove("hidden")
                if (form && season) {
                    console.log(form.attributes.action);
                    form.id.value = season.id;
                    form.Season.value = season.Season;
                }
            }
            else editSeasonForm.classList.add("hidden")
        }
    }
</script>
