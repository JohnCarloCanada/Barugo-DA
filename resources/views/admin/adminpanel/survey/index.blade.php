<x-app>
    <x-slot:title>
        Admin | Admin Control Panel
    </x-slot:title>

    <x-admin.sidebar type="Admin Panel"/>

    <section class="w-full min-h-screen overflow-hidden">
        <x-admin.controlPanel>Survey Control Panel</x-admin.controlPanel>
        <nav class="flex justify-start items-center p-3 sm:p-4 shadow-xl">
            <ul class="flex flex-col sm:flex-row items-center justify-center gap-2 sm:gap-4">
                <li><a class=" underline font-semibold text-[#72c4ff]" href="{{route('adminControlPanelSurvey.survey', ['currentRoute' => 'All'])}}">Survey Questions</a></li>
                <li><a class=" underline font-semibold" href="{{route('adminControlPanelSeason.season')}}">Season</a></li>
                <li><a class=" underline font-semibold" href="{{route('adminControlPanelSeed.index')}}">Seed Inventory</a></li>
            </ul>
        </nav>

        <section class="w-full overflow-x-auto p-4 overflow-y-hidden">
            <table class="w-[700px] sm:w-full flex flex-col shadow-2xl">
                <tr class="grid grid-cols-1 py-2 bg-green-700 text-white w-full">
                    <th class="w-full px-3 flex items-center justify-between relative py-2">
                        <div data-show-form class="flex items-center gap-3 cursor-pointer">
                            <img src="{{asset('images/icons/plus.png')}}" class="hover:bg-green-200 w-[25px] h-[25px] border bg-slate-100 rounded-full p-1" alt=""> Add New Option
                        </div>
                        <ul class="flex items-center gap-x-5 sm:gap-x-6">
                            <li>
                                <a href="{{route('adminControlPanelSurvey.survey', ['currentRoute' => 'All'])}}" class="{{$currentRoute == 'All' ? 'text-[#72c4ff]' : ''}}">All</a>
                            </li>
                            <li>
                                <a href="{{route('adminControlPanelSurvey.survey', ['currentRoute' => 'Religion'])}}" class="{{$currentRoute == 'Religion' ? 'text-[#72c4ff]' : ''}}" href="">Religion</a>
                            </li>
                            <li>
                                <a href="{{route('adminControlPanelSurvey.survey', ['currentRoute' => 'Livelihood'])}}" class="{{$currentRoute == 'Livelihood' ? 'text-[#72c4ff]' : ''}}" href="">Livelihood</a>
                            </li>
                        </ul>
                    </th>
                    <th class="grid grid-cols-2 text-[12px] mt-5">
                        <div>Option Name</div>
                        <div>Operation</div>
                    </th>
                </tr>
                <tr class="grid py-1 grid-cols-2 w-full">
                    @foreach ($options as $option)
                        <td class="text-center">{{$option->Name}}</td>
                        <td class="flex items-center justify-center">
                            {{-- <div><img class="max-w-[34px] p-1 hover:bg-green-300/50 rounded-full" src="{{asset('images/icons/update.png')}}" alt=""></div> --}}
                            <form action="{{route('adminControlPanelSurvey.destroy', ['option' => $option])}}" method="post">
                                @csrf
                                @method('delete')

                                <button type="submit">
                                    <img class="max-w-[34px] p-1 hover:bg-green-300/50 rounded-full" src="{{asset('images/icons/delete.png')}}" alt="delete button">
                                </button>
                            </form>
                        </td>
                    @endforeach
                </tr>
            </table>
            <div class="w-full mt-3">{{$options->links('pagination::tailwind')}}</div>
        </section>
    </section>

</x-app>

<div id="religionSurveyForm" class="hidden" >
    
    <div class="h-screen w-screen bg-gray-500/50 fixed top-0 left-0 z-2 flex items-center justify-center">
        <form method="POST" action="{{route('adminControlPanelSurvey.store')}}" class="p-3 w-full gap-2 text-gray-700 grid md:w-2/4 rounded shadow-md bg-white">
            @csrf
            <div class="text-[20px] font-semibold w-full flex items-center justify-between px-3 my-2">
                <p>Add New Option</p>
                <img data-show-close src="{{asset('images/close.png')}}" class="w-[16px] h-[16px] cursor-pointer" alt="close">
            </div>
            <div class="w-full px-3 flex flex-col gap-1">
                <label for="Option_Name" class="text-[12px] font-semibold">Gender</label>
                <select name="Option_Name" id="Option_Name" class="w-full border text-gray-700 outline-0 px-2 py-1 shadow-md bg-gray-100">
                    <option value="Religion">Religion</option>
                    <option value="Livelihood">Livelihood</option>
                </select>
            </div>
            <div class="w-full px-3 flex flex-col gap-1">
                <label for="Name" class="text-[12px] font-semibold">Name</label>
                <input type="text" name="Name" id="Name" placeholder="Enter Name..." class="w-full border outline-0 px-2 py-1 shadow-md bg-gray-100">
            </div>
            <div class="px-3">
                <button type="submit" class="py-2 w-full mt-3 text-white hover:bg-green-500 rounded font-bold bg-green-700">
                    ADD RELIGION
                </button>
            </div>
        </form>
    </div>
    
</div>




<script>
    const religionSurveyForm = document.getElementById('religionSurveyForm');
    const btnShowClose = document.querySelector('[data-show-close]');
    const btnShowForm = document.querySelector('[data-show-form]');

    btnShowForm.addEventListener('click', () => {
        religionSurveyForm.classList.toggle('hidden');
    });

    btnShowClose.addEventListener('click', () => {
        religionSurveyForm.classList.add('hidden');
    });
    
</script>