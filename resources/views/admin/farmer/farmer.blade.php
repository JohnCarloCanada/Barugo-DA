<x-app>
    <x-slot:title>
        Admin | Farmer
    </x-slot:title>

    <x-admin.sidebar type="managed farmers"/>

    <section class="w-full bg-slate-100 min-h-screen p-5 overflow-hidden">
        <x-admin.titleCard title="Farmers Details" slogan="Farmers Current Information" />
        <div class="flex flex-col w-[min(100%,1300px)] overflow-x-auto min-h-[600px] shadow-2xl rounded-2xl">
            <table class="w-[max(100%,1100px)] flex flex-col shadow-md border-2 rounded">
                <tr class="grid grid-cols-1 py-2 bg-green-700 text-white w-full">
                    <th class="w-full px-3 flex flex-col sm:flex-row items-start justify-between gap-y-4 sm:gap-y-0 gap-x-3 relative py-2">
                        <div class="py-2 bg-green-700 text-white md:w-[25%] w-full">
                            <form action="{{route('adminPersonalInformation.index')}}" method="GET" class="w-full">
                                @csrf
                                <input name="search" class="w-full px-3 py-1 font-normal bg-slate-100 rounded outline-0 text-ms text-slate-800" placeholder="Search RSBSA No" type="text" value="{{$search}}">
                            </form>
                        </div>
                        <div class="flex gap-2">
                            <a href="{{route('adminPersonalInformation.create')}}" class="hover:bg-slate-200 md:text-sm border text-slate-500 p-2  rounded bg-slate-100 flex items-center gap-3 cursor-pointer whitespace-nowrap">
                                <img src="{{asset('images/icons/plus.png')}}" class="w-[12px] h-[12px]" alt=""> Add Farmer
                            </a>
                            <a href="{{route('adminDownloadAllFarmersRecord')}}" class="hover:bg-slate-200 text-sm border text-slate-500 py-2 p-2  rounded bg-slate-100 flex items-center gap-3 cursor-pointer whitespace-nowrap">
                                <img src="{{asset('images/icons/export.png')}}" class="w-[15px] h-[15px]" alt=""> Export Excel
                            </a>
                            <x-admin.navigation type="index" notApprovedCount={{$notApprovedCount}}/>
                        </div>  
                    </th>
                    <th class="grid grid-cols-7 text-[12px] mt-5">
                        <div>RSBSA No</div>
                        <div>Surname</div>
                        <div>Address</div>
                        <div>Mobile No.</div>
                        <div>Main Livelihood</div>
                        <div>status</div>
                        <div>Operation</div>
                    </th>
                </tr>
                    @foreach ($PersonalInformations as $PersonalInformation)
                    <tr class="grid py-1 odd:bg-slate-200 grid-cols-7 w-full text-[12px]">
                        <td class="text-center">{{$PersonalInformation->RSBSA_No}}</td>
                        <td class="text-center">{{$PersonalInformation->Surname}}</td>
                        <td class="text-center">{{$PersonalInformation->Address}}</td>
                        <td class="text-center">{{$PersonalInformation->Mobile_No}}</td>
                        <td class="text-center">{{$PersonalInformation->Main_livelihood}}</td>
                        <td class="{{ $PersonalInformation->is_approved ? "text-green-500 font-bold text-center rounded h-fit" : "text-red-500 font-bold text-center  rounded h-fit"}}">{{ $PersonalInformation->is_approved ? "Active" : "In-Active"}}</td>
                        <td class="flex items-center justify-between">
                            <a href="{{route('admin.farmerDetails', ['personalInformation' => $PersonalInformation, 'currentRoute' => 'area'])}}">
                                <img class="max-w-[34px] p-1 hover:bg-green-300/50 rounded-full" src="{{asset('images/icons/view.png')}}" alt="">
                            </a>
                            <a href="{{route('adminPersonalInformation.edit', ['personalInformation' => $PersonalInformation])}}">
                                <img class="max-w-[34px] p-1 hover:bg-green-300/50 rounded-full" src="{{asset('images/icons/update.png')}}" alt="">
                            </a>
                            <form class="" action="{{ route('adminPersonalInformation.delete', ['personalInformation' => $PersonalInformation]) }}" method="post">
                                @csrf
                                @method('delete')
                                <div class="w-full">
                                    <input class="bg-red-500 hidden w-full px-3 py-1 rounded-lg text-white font-bold cursor-pointer" type="submit" value="Delete">
                                    <button type="submit">
                                        <img class="max-w-[34px] p-1 hover:bg-green-300/50 rounded-full" src="{{asset('images/icons/delete-2.png')}}" alt="">
                                    </button>
                                </div>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </table>
            {{ $PersonalInformations->links('pagination::tailwind') }}
        </div>
    </section>
</x-app>