<x-app>
    <x-slot:title>
        Employee | Vaccinations
    </x-slot:title>

    <x-sidebar type="canine records"/>   

    <section class="w-full min-h-screen bg-green-700 p-5 overflow-y-auto">
        <section class="flex flex-col my-2 items-start justify-center gap-y-6">
            <h2 class="text-2xl sm:text-4xl mx-2 font-bold text-white">Canine Vaccination Records</h2>
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-y-3 sm:gap-y-0 justify-center gap-x-3">
                <a aria-label="Go to add farmers" class="py-2 px-6 bg-[#679f69] rounded flex items-center justify-between gap-x-4" href="{{route('dogVaccinationInformation.create')}}">
                    <p class="text-white font-bold text-xs whitespace-nowrap">ADD NEW RECORD</p>
                    <img aria-hidden="true" class="w-3 h-3 object-contain" src="{{asset('images/icons/plus.png')}}" alt="">
                </a>
                <div class="py-2 bg-green-700 text-white w-full">
                    <form action="{{route('dogVaccinationInformation.index')}}" method="GET" class="w-full">
                        @csrf
                        <input name="search" class="w-full px-3 py-1 font-normal bg-slate-100 rounded outline-0 text-ms text-slate-800" placeholder="Search Dog Name or Owner Name" type="text" value="{{$search}}">
                    </form>
                </div>
            </div>
        </section>
        <section class="w-[min(100%,1300px)] h-[500px] overflow-x-auto mx-auto bg-white rounded-lg">
            <table class="w-[max(100%,1100px)] mt-5 text-center">
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
                        <tr class="pt-10 odd:bg-slate-300">
                            <td>{{$dogInformation->Date_of_Registration}}</td>
                            <td>{{$dogInformation->Dog_Name}}</td>
                            <td>{{$dogInformation->Age}}</td>
                            <td>{{$dogInformation->Owner_Name}}</td>
                            <td>{{$dogInformation->Sex}}</td>
                            <td>{{$dogInformation->Neutering}}</td>
                            <td>{{$dogInformation->Color}}</td>
                            <td>{{$dogInformation->Species}}</td>
                            <td>{{$dogInformation->Last_Vac_Month}}</td>
                            <td class="flex items-center justify-between">
                                <a href="{{route('dogVaccinationInformation.vaccination', ['dogInformation' => $dogInformation])}}">
                                    <img class="max-w-[34px] p-1 hover:bg-green-300/50 rounded-full" src="{{asset('images/icons/inject.png')}}" alt="">
                                </a>
                                <a href="{{route('dogVaccinationInformation.edit', ['dogInformation' => $dogInformation])}}">
                                    <img class="max-w-[34px] p-1 hover:bg-green-300/50 rounded-full cursor-pointer" src="{{asset('images/icons/update.png')}}" alt="">
                                </a>
                                <form action="{{route('dogVaccinationInformation.destroy', ['dogInformation' => $dogInformation])}}" method="post">
                                    @csrf
                                    @method('delete')

                                    <button type="submit">
                                        <img class="max-w-[34px] p-1 hover:bg-green-300/50 rounded-full" src="{{asset('images/icons/delete.png')}}" alt="">
                                    </button>
                                </form>
                            </td>		
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </section>
        <div class="w-full mt-3 bg-white rounded-xl px-2 font-bold">{{$DogInformations->links('pagination::tailwind')}}</div>
    </section>
</x-app>

