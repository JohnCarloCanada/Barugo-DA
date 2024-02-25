<x-app>
    <x-slot:title>
        Admin | Admin Control Panel
    </x-slot:title>

    <x-admin.sidebar type="Admin Panel"/>

    <section class="w-full min-h-screen overflow-hidden">
        <x-admin.controlPanel>Seed Inventory Panel</x-admin.controlPanel>
        <nav class="flex justify-center sm:justify-start items-center p-3 sm:p-4 shadow-xl">
            <ul class="flex flex-col sm:flex-row items-center justify-center gap-2 sm:gap-4">
                <li><a class=" p-2 font-semibold" href="{{route('adminControlPanelSurvey.survey', ['currentRoute' => 'All'])}}">Survey Questions</a></li>
                <li><a class=" p-2 font-semibold" href="{{route('adminControlPanelSeason.season')}}">Season</a></li>
                <li><a class=" font-semibold text-green-700 p-2 shadow-md rounded bg-green-200" href="{{route('adminControlPanelSeed.index')}}">Seed Inventory</a></li>
            </ul>
        </nav>

        <section class="w-full overflow-x-auto p-4 overflow-y-hidden">
            @if ($errors->any())
            <ul class="grid grid-cols-2 sm:grid-cols-4 gap-1 mb-3">
                @foreach ($errors->all() as $error )
                    <li class="text-sm sm:text-base text-red-800 font-bold">{{$error}}</li>
                @endforeach
            </ul>
            @endif
            <table class="w-[700px] md:w-full flex flex-col shadow-2xl">
                <tr class="grid grid-cols-1 py-2 bg-green-700 text-white w-full">
                    <th class="w-full px-3 flex flex-col sm:flex-row gap-3 items-center justify-between relative py-2">
                        <div data-seed-show class="flex items-center gap-3 cursor-pointer">
                            <img src="{{asset('images/icons/plus.png')}}" class="hover:bg-green-200 w-[25px] h-[25px] border bg-slate-100 rounded-full p-1" alt=""> <p class="whitespace-nowrap">Add New Seed</p>
                        </div>
                        <div class="py-2 bg-green-700 text-white">
                            <form action="{{route('adminControlPanelSeed.index')}}" method="GET" class="w-full">
                                @csrf
                                <input name="search" class="px-3 py-1 font-normal bg-slate-100 rounded outline-0 text-ms text-slate-800" placeholder="Search Seed Variety/Name" type="text" value="{{$search}}">
                            </form>
                        </div>
                    </th>
                    <th class="grid grid-cols-8 text-[12px] mt-5">
                        <div>Seed Type</div>
                        <div>Seed Variety</div>
                        <div>Company</div>
                        <div>Description</div>
                        <div>Quantity</div>
                        <div># of Hectare</div>
                        <div>Bags/Sacks</div>
                        <div>Actions</div>
                    </th>
                </tr>
                @foreach ($seeds as $seed)
                    <tr class="grid py-1 grid-cols-8 w-full odd:bg-gray-400 font-semibold text-sm">
                        <td class="text-center">{{$seed->Seed_Type}}</td>
                        <td class="text-center">{{$seed->Seed_Variety}}</td>
                        <td class="text-center">{{$seed->Company}}</td>
                        <td class="text-left @if (!$seed->Description) text-red-600 font-semibold text-line-across @endif">{{$seed->Description ?? 'No Description'}}</td>
                        <td class="text-center">{{$seed->Quantity}}</td>
                        <td class="text-center">{{$seed->NoHectare}}</td>
                        <td class="text-center">{{$seed->NoBags}}</td>
                        <td class="text-center flex flex-col md:flex-row items-center justify-center gap-2">
                            <div onclick="showPersonnelEditForm({{$seed}})" class="bg-green-600 font-bold text-white py-1 px-3 rounded-sm text-xs sm:text-sm cursor-pointer">Edit</div>
                            <form class="" action="{{route('seedInventoryDestroy.destroy', ['seedInventory' => $seed])}}" method="post">
                                @csrf
                                @method('delete')

                                <button type="submit" class="bg-red-600 font-bold text-white py-1 px-3 rounded-sm text-xs sm:text-sm cursor-pointer whitespace-nowrap">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </table>
            <div class="w-full mt-3">{{$seeds->links('pagination::tailwind')}}</div>
        </section>
    </section>

</x-app>

{{-- SEEDS ADDING --}}

<div id="addSeedsForm" class="hidden" >
    <div class="h-screen w-screen bg-gray-500/50 fixed top-0 left-0 z-2 flex items-center justify-center">
        <form method="POST" action="{{route('seedInventoryStore.store')}}" class="p-3 w-full gap-2 text-gray-700 grid md:w-2/4 rounded shadow-md bg-white">
            @csrf
            <div class="text-[20px] font-semibold w-full flex items-center justify-between px-3 my-2">
                <p>Add New Seed</p>
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
                <label for="Description" class="text-[12px] font-semibold">Description</label>
                {{-- <input type="text" maxlength="255" name="Description" id="Description" placeholder="Enter Description..." > --}}
                <textarea name="Description" id="Description" cols="30" rows="10" placeholder="Enter Description..." maxlength="255" class="w-full border outline-0 px-2 py-1 shadow-md bg-gray-100"></textarea>
            </div>
            <div class="w-full px-3 flex flex-col gap-1">
                <label for="Quantity" class="text-[12px] font-semibold">Seed Quantity</label>
                <input type="number" name="Quantity" id="Quantity" placeholder="Enter Quantity..." step="0.01" class="w-full border outline-0 px-2 py-1 shadow-md bg-gray-100">
            </div>
            <div class="px-3">
                <button type="submit" class="py-2 w-full mt-3 text-white hover:bg-green-500 rounded font-bold bg-green-700">
                    ADD SEEDS
                </button>
            </div>
        </form>
    </div> 
</div>

{{-- SEEDS Edit --}}
<div id="editSeedsForm" class="hidden" >
    <div class="h-screen w-screen bg-gray-500/50 fixed top-0 left-0 z-2 flex items-center justify-center">
        <form method="POST" id="editSeedFormInputValue" action="{{route('seedInventoryUpdate.update')}}" class="p-3 w-full h-[350px] overflow-y-scroll gap-2 text-gray-700 grid md:w-2/4 rounded shadow-md bg-white">
            @csrf
            @method('put')
            <div class="text-[20px] font-semibold w-full flex items-center justify-between px-3 my-2">
                <p>Edit Seed</p>
                <img data-edit-close src="{{asset('images/close.png')}}" class="w-[16px] h-[16px] cursor-pointer" alt="close">
            </div>
            <div class="w-full px-3 flex flex-col gap-1">
                <label for="Seed_Type" class="text-[12px] font-semibold">Type</label>
                <select name="Seed_Type" id="Seed_Type" class="w-full border text-gray-700 outline-0 px-2 py-1 shadow-md bg-gray-100">
                    <option value="Hybrid Rice">Hybrid</option>
                    <option value="Inbred Rice">Inbred</option>
                    <option value="Vegetable">Vegetable</option>
                </select>
            </div>
            <input type="text" name="id" id="" class="hidden">
            <div class="w-full px-3 flex flex-col gap-1">
                <label for="Seed_Variety" class="text-[12px] font-semibold">Seed</label>
                <input type="text" name="Seed_Variety" id="Seed_Variety" placeholder="Enter Seed..." class="w-full border outline-0 px-2 py-1 shadow-md bg-gray-100">
            </div>
            <div class="w-full px-3 flex flex-col gap-1">
                <label for="Company" class="text-[12px] font-semibold">Company</label>
                <input type="text" name="Company" id="Company" placeholder="Enter Company..." class="w-full border outline-0 px-2 py-1 shadow-md bg-gray-100">
            </div>
            <div class="w-full px-3 flex flex-col gap-1">
                <label for="Description" class="text-[12px] font-semibold">Description</label>
                {{-- <input type="text" maxlength="255" name="Description" id="Description" placeholder="Enter Description..." > --}}
                <textarea name="Description" id="Description" cols="30" rows="10" placeholder="Enter Description..." maxlength="255" class="w-full border outline-0 px-2 py-1 shadow-md bg-gray-100"></textarea>
            </div>
            <div class="w-full px-3 flex flex-col gap-1">
                <label for="Quantity" class="text-[12px] font-semibold">Seed Quantity</label>
                <input type="number" name="Quantity" id="Quantity" placeholder="Enter Quantity..." step="0.01" class="w-full border outline-0 px-2 py-1 shadow-md bg-gray-100">
            </div>
            <div class="w-full px-3 flex flex-col gap-1">
                <label for="NoHectare" class="text-[12px] font-semibold">NoHectare</label>
                <input type="number" name="NoHectare" id="NoHectare" placeholder="Enter NoHectare..." step="0.01" class="w-full border outline-0 px-2 py-1 shadow-md bg-gray-100">
            </div>
            <div class="w-full px-3 flex flex-col gap-1">
                <label for="Sacks" class="text-[12px] font-semibold">Sacks</label>
                <input type="number" name="Sacks" id="Sacks" placeholder="Enter Sacks..." step="0.01" class="w-full border outline-0 px-2 py-1 shadow-md bg-gray-100">
            </div>
            <div class="px-3">
                <button type="submit" class="py-2 w-full mt-3 text-white hover:bg-green-500 rounded font-bold bg-green-700">
                    UPDATE SEEDS
                </button>
            </div>
        </form>
    </div> 
</div>

<script>
    const addSeedsForm = document.getElementById('addSeedsForm');
    const editSeedsForm = document.getElementById('editSeedsForm');

    const btnSeedClose = document.querySelector('[data-seed-close]');
    const btnSeedShow = document.querySelector('[data-seed-show]');

    const btnSeedEditClose = document.querySelector('[data-edit-close]');

    const form = document.getElementById('editSeedFormInputValue');


    btnSeedShow.addEventListener('click', () => {
        addSeedsForm.classList.toggle('hidden');
    });

    btnSeedClose.addEventListener('click', () => {
        addSeedsForm.classList.add('hidden');
    });

    btnSeedEditClose.addEventListener('click', () => {
        editSeedsForm.classList.toggle('hidden');
    });


    const showPersonnelEditForm=(seed)=>{
        if(editSeedsForm) {
            if(editSeedsForm.classList == 'hidden') { 
                editSeedsForm.classList.remove("hidden")
                if (form && seed) {
                    console.log(form.attributes.action);
                    form.id.value = seed.id;
                    form.Seed_Type.value = seed.Seed_Type;
                    form.Seed_Variety.value = seed.Seed_Variety;
                    form.Company.value = seed.Company;
                    form.Description.value = seed.Description;
                    form.Quantity.value = seed.Quantity;
                }
            }
            else editSeedsForm.classList.add("hidden")
        }
    }
</script>
