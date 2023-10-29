<x-app>
    <x-slot:title>
        barugo | Managed Farmers
    </x-slot:title>

    <x-sidebar type="managed farmers"/>   

    <section class="w-full min-h-screen p-5 overflow-y-auto">
        <section class="flex flex-col my-2 items-start justify-center gap-y-6">
            <h2 class="w-full text-2xl sm:text-4xl mx-2 font-bold text-black text-center">Managed Farmers</h2>
            <div class="w-full flex flex-col sm:flex-row items-start sm:items-center gap-y-3 sm:gap-y-0 justify-between gap-x-3">
                <a aria-label="Go to add farmers" class="py-2 px-3 bg-[#679f69] rounded flex items-center justify-between gap-x-4" href="{{route('userPersonalInformation.create')}}">
                    <p class="text-white font-bold text-xs">ADD FARMER</p>
                    <img aria-hidden="true" class="w-3 h-3 object-contain" src="{{asset('images/icons/plus.png')}}" alt="">
                </a>
            </div>
        </section>
        <section class="w-[100%,900px] h-[600px] mx-auto overflow-x-auto bg-white rounded-lg px-3 shadow-2xl">
            <table class="w-full mt-5 text-center">
                <thead>
                    <tr>
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
                        <tr class="pt-10 odd:bg-slate-200">
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