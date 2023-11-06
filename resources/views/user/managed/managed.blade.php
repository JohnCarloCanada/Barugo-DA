<x-app>
    <x-slot:title>
        Employee | Farmers
    </x-slot:title>

    <x-sidebar type="managed farmers"/>   

    <section class="w-full min-h-screen p-5 overflow-hidden">
        <x-admin.titleCard title="Farmers Details" slogan="Farmers Current Information" />
        <div class="bg-green-700 w-full px-3 flex flex-col sm:flex-row items-center justify-between gap-y-4 sm:gap-y-0 gap-x-3 relative py-2">
            <div class="py-2 bg-green-700 text-white md:w-[25%] w-full ">
                <form action="{{route('userPersonalInformation.index')}}" method="GET" class="w-full">
                    @csrf
                    <input name="search" class="w-full px-3 py-1 font-normal bg-slate-100 rounded outline-0 text-ms text-slate-800" placeholder="Search RSBSA No" type="text" value="{{$search}}">
                </form>
            </div>
            <div class="flex gap-2">
                <a href="{{route('userPersonalInformation.create')}}" class="hover:bg-slate-200 md:text-sm border text-slate-500 p-2  rounded bg-slate-100 flex items-center gap-3 cursor-pointer whitespace-nowrap">
                    <img src="{{asset('images/icons/plus.png')}}" class="w-[12px] h-[12px]" alt=""> Add Farmer
                </a>
                <a href="{{route('userDownloadAllFarmersRecord')}}" class="hover:bg-slate-200 text-sm border text-slate-500 py-2 p-2  rounded bg-slate-100 flex items-center gap-3 cursor-pointer whitespace-nowrap">
                    <img src="{{asset('images/icons/export.png')}}" class="w-[15px] h-[15px]" alt=""> Export Excel
                </a>
            </div>  
        </div>
        <section class="w-[100%,900px] mx-auto overflow-x-auto bg-white rounded-lg px-3 shadow-2xl">
            <table class="w-full mt-5 text-center">
                <thead>
                    <tr class="text-[12px]">
                        <th class="text-sm"></th>
                        <th class="text-sm">RSBSA No.</th>
                        <th class="text-sm">Surname</th>
                        <th class="text-sm">Address</th>
                        <th class="text-sm">Mobile No.</th>
                        <th class="text-sm whitespace-nowrap">Main Livelihood</th>
                        <th class="text-sm">Operation</th>
                    </tr>
                </thead>
        
                <tbody>
                    @foreach ($PersonalInformations as $PersonalInformation)
                        <tr class="pt-10 odd:bg-slate-200 text-[12px]">
                            <td><div class="w-[24px] h-[24px] bg-red-800 {{ $PersonalInformation->update_status  ? '' : 'hidden' }} "></div></td>
                            <td>{{$PersonalInformation->RSBSA_No}}</td>
                            <td>{{$PersonalInformation->Surname}}</td>
                            <td>{{$PersonalInformation->Address}}</td>
                            <td>{{$PersonalInformation->Mobile_No}}</td>
                            <td>{{$PersonalInformation->Main_livelihood}}</td>
                            <td class="flex items-center justify-center gap-x-3">
                                <a href="{{route('user.managedFarmersDetails', ['personalInformation' => $PersonalInformation, 'currentRoute' => 'area'])}}">
                                    <img class="max-w-[34px] p-1 hover:bg-green-300/50 rounded-full" src="{{asset('images/icons/view.png')}}" alt="">
                                </a>
                                <a href="{{route('userPersonalInformation.edit', ['personalInformation' => $PersonalInformation])}}">
                                    <img class="max-w-[34px] p-1 hover:bg-green-300/50 rounded-full" src="{{asset('images/icons/update.png')}}" alt="">
                                </a>
                            </td>		
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-3 sm:mt-4 shadow-2xl w-full">{{ $PersonalInformations->links('pagination::tailwind') }}</div>
        </section>
    </section>
</x-app>