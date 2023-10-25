<x-app>
    <x-slot:title>
        barugo | Managed Farmers
    </x-slot:title>

    <x-sidebar type="canine records"/>   

    <section class="w-full min-h-screen p-5 overflow-y-auto">
        <section class="flex flex-col my-2 items-start justify-center gap-y-6">
            <h2 class="text-2xl sm:text-4xl mx-2 font-bold text-black">Canine Vaccination Records</h2>
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-y-3 sm:gap-y-0 justify-center gap-x-3">
                <a aria-label="Go to add farmers" class="py-2 px-3 bg-[#679f69] rounded flex items-center justify-between gap-x-4" href="{{route('dogVaccinationInformation.create')}}">
                    <p class="text-white font-bold text-xs">ADD NEW RECORD</p>
                    <img aria-hidden="true" class="w-3 h-3 object-contain" src="{{asset('images/icons/plus.png')}}" alt="">
                </a>
                <ul class="py-2 px-3 bg-[#679f69] rounded cursor-pointer flex items-center justify-between gap-x-4">
                    <p class="text-white font-bold text-xs">SORT</p>
                    <img aria-hidden="true" class="w-3 h-3 cursor-pointer object-contain" src="{{asset('images/icons/down-arrow.png')}}" alt="">
                </ul>
            </div>
        </section>
        <section class="w-[100%,900px] h-[500px] mx-auto overflow-x-auto bg-white rounded-lg">
            <table class="w-full mt-5 text-center">
                <thead>
                    <tr>
                        <th class="whitespace-nowrap">Date of Registration</th>
                        <th class="">Name</th>
                        <th class="">Age</th>
                        <th class="whitespace-nowrap">Owner Name</th>
                        <th class="">Sex</th>
                        <th class="">Neutering</th>
                        <th class="">Color</th>
                        <th class="">Species</th>
                        <th class="whitespace-nowrap">Last Vacinnation Month</th>
                        <th class="">Operation</th>
                    </tr>
                </thead>
        
                <tbody>
                    @foreach ($DogInformations as $dogInformation)
                        <tr class="pt-10 odd:bg-slate-200">
                            <td>{{$dogInformation->Date_of_Registration}}</td>
                            <td>{{$dogInformation->Dog_Name}}</td>
                            <td>{{$dogInformation->Age}}</td>
                            <td>{{$dogInformation->Owner_Name}}</td>
                            <td>{{$dogInformation->Sex}}</td>
                            <td>{{$dogInformation->Neutering}}</td>
                            <td>{{$dogInformation->Color}}</td>
                            <td>{{$dogInformation->Species}}</td>
                            <td>{{$dogInformation->Last_Vac_Month}}</td>
                            <td class="flex items-center justify-center">
                                <a href="">
                                    <img class="max-w-[34px] p-1 hover:bg-green-300/50 rounded-full" src="{{asset('images/icons/view.png')}}" alt="">
                                </a>
                                <div>
                                    <img class="max-w-[34px] p-1 hover:bg-green-300/50 rounded-full cursor-pointer" src="{{asset('images/icons/update.png')}}" alt="">
                                </div>
                            </td>		
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </section>
    </section>
</x-app>