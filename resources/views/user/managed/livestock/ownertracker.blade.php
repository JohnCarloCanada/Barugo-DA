<x-app>
    <x-slot:title>
        Employee | Livestock Tracker Owner
    </x-slot:title>

    <x-sidebar type="livestock trackers"/>

    <section class="w-full min-h-screen bg-green-700 p-5 overflow-y-auto">
        <section class="flex flex-col my-2 items-center justify-center gap-y-6">
            <h2 class="text-2xl sm:text-4xl mx-2 font-bold text-white">Livestock Owner Tracker</h2>
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-y-3 sm:gap-y-0 justify-center gap-x-3">
                <div class="py-2 bg-green-700 text-white w-full">
                    <form action="{{route('userLivestockOwnerTracker.index')}}" method="GET" class="w-full">
                        @csrf
                        <input name="search" class="w-full px-3 py-1 font-normal bg-slate-100 rounded outline-0 text-ms text-slate-800" placeholder="Search Livestock Name" type="text" value="{{$search}}">
                    </form>
                </div>
            </div>
        </section>
        <section class="w-[min(100%,1300px)] h-[500px] overflow-x-auto mx-auto bg-white rounded-lg">
            <table class="w-[max(100%,1100px)] mt-5 text-center">
                <thead>
                    <tr class="text-xs sm:text-base px-4">
                        <th>RSBSA No.</th>
                        <th>Name</th>
                        <th>Livestock Name</th>
                        <th>Livestock Sex</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($farmers as $farmer)
                        <tr class="pt-10 odd:bg-slate-200 text-sm sm:text-base">
                            @php
                                $initial = '';
                                if($farmer->personalinformation->Middle_Name) {
                                    $initial = Str::upper(Str::substr($farmer->personalinformation->Middle_Name, 0, 1)) . '.';
                                } else {
                                    $initial = '';
                                }
                            @endphp
                            <td>{{$farmer->personalinformation->RSBSA_No ?? 'None'}}</td>
                            <td>{{$farmer->personalinformation->First_Name . " " . $initial . " " . $farmer->personalinformation->Surname}}</td>
                            <td>{{$farmer->Livestock_Name}}</td>
                            <td>{{$farmer->Sex_LS}}</td>
                            <td>
                                <div onclick="showChangedFormModal({{$farmer}})" class="bg-green-600 font-bold text-white py-1 px-3 rounded-sm text-xs sm:text-sm cursor-pointer">Change Owner</div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </section>
        <div class="w-full mt-3 bg-white rounded-xl px-2 font-bold">{{$farmers->links('pagination::tailwind')}}</div>
    </section>
</x-app>


<div id="showChangedForm" class="hidden">
    <div class="h-screen w-screen bg-gray-500/50 fixed top-0 left-0 z-2 flex items-center justify-center">
        <form method="POST" id="showChangedFormInputValue" action="{{route('userLivestockOwnerTracker.changedOwner')}}" class="p-3 w-full gap-2 text-gray-700 grid md:w-2/4 rounded shadow-md bg-white">
            @csrf
            @method('put')
            
            <div class="text-[20px] font-semibold w-full flex items-center justify-between px-3 my-2">
                <p>CHANGE OWNER</p>
                <img onclick="showChangedFormModal()" src="{{asset('images/close.png')}}" class="w-[16px] h-[16px] cursor-pointer" alt="close">
            </div>
            <input type="text" name="id" id="" class="hidden">
            <div class="w-full px-3 flex flex-col gap-1">
                <label for="personal_information_id" class="text-[12px] font-semibold">Owner</label>
                <select name="personal_information_id" id="personal_information_id" class="w-full border text-gray-700 outline-0 px-2 py-1 shadow-md bg-gray-100">
                    @foreach($Farmers as $farmer)
                    @php
                        $initial = '';
                        if($farmer->Middle_Name) {
                            $initial = Str::upper(Str::substr($farmer->Middle_Name, 0, 1)) . '.';
                        } else {
                            $initial = '';
                        }

                        $fullname = $farmer->First_Name . " " . $initial . " " . $farmer->Surname
                    @endphp
                        <option value="{{$farmer->id}}">{{$farmer->RSBSA_No . ' - ' . $fullname}}</option>
                    @endforeach
                </select>
            </div>
            <div class="w-full px-3 flex flex-col gap-1 mt-3">
                <label for="Mode_Of_Changing" class="text-[12px] font-semibold mr-1">Mode of Changing:</label>
                <div>
                    <div class="whitespace-nowrap">
                        <input required type="radio" name="Mode_Of_Changing" id="Mass" value="Mass">
                        <label class="text-gray-400" for="Mass">Mass</label>
                    </div>
                    <div class="whitespace-nowrap">
                        <input required type="radio" name="Mode_Of_Changing" id="Individual" value="Individual">
                        <label class="text-gray-400" for="Individual">Individual</label>
                    </div>
                </div>
            </div>
            <div class="px-3">
                <button type="submit" class="py-2 w-full mt-3 text-white hover:bg-green-500 rounded font-bold bg-green-700">
                    Change Owner
                </button>
            </div>
        </form>
    </div>
</div>


<script>
    const showChangedForm = document.getElementById('showChangedForm');
    const form = document.getElementById('showChangedFormInputValue');

    const showChangedFormModal = (owner) => {
        if(showChangedForm) {
            if(showChangedForm.classList == 'hidden') { 
                showChangedForm.classList.remove("hidden")
                if (form && owner) {
                    form.id.value = owner.id;
                }
            }
            else {
                showChangedForm.classList.add("hidden")
            }
        }
    }
</script>