<x-app>
    <x-slot:title>
        Admin | Farmer
    </x-slot:title>

    <x-admin.sidebar type="managed farmers"/>


    <section class="w-full min-h-screen p-5 overflow-y-auto">
        <x-admin.titleCard title="Farmers Details" slogan="Approval and Inforamtion About the farmers." />
        <div class="flex flex-col w-full h-full">
            <table class="flex flex-col overflow-x-auto min-w-[800px] md:max-w-full shadow-md border-2 rounded">
                <tr class="grid grid-cols-1 py-2 bg-green-700 text-white w-full">
                    <th class="w-full px-3 grid grid-cols-2 relative  py-2">
                        <div class="flex items-center gap-3 cursor-pointer">
                            <img src="{{asset('images/icons/plus.png')}}" class="hover:bg-green-200 w-[25px] h-[25px] border bg-slate-100 rounded-full p-1" alt=""> Add Farmer
                        </div>
                        <input class="px-3 py-1 bg-slate-100 rounded outline-0 text-ms text-slate-800 w-full" placeholder="Search..." type="text">
                    </th>
                    <th class="grid grid-cols-7 text-[12px] mt-5">
                        <div>RSBSA No</div>
                        <div>Surname</div>
                        <div>Address</div>
                        <div>Mobile No.</div>
                        <div>Main Livelihood</div>
                        <div>status</div>
                        <div class="">Operation</div>
                    </th>
                </tr>


                    @foreach ($PersonalInformations as $PersonalInformation)
                    <tr class="grid py-1 odd:bg-slate-200 grid-cols-7 w-full">

                        <td class="text-center">{{$PersonalInformation->RSBSA_No}}</td>
                        <td class="text-center">{{$PersonalInformation->Surname}}</td>
                        <td class="text-center">{{$PersonalInformation->Address}}</td>
                        <td class="text-center">{{$PersonalInformation->Mobile_No}}</td>
                        <td class="text-center">{{$PersonalInformation->Main_livelihood}}</td>
                        <td class="{{ $PersonalInformation->is_approved ? "text-green-500 font-bold text-center rounded h-fit" : "text-red-500 font-bold text-center  rounded h-fit"}}">{{ $PersonalInformation->is_approved ? "Active" : "In-Active"}}</td>
                        <td class="grid grid-cols-3 gap-2">
                            <div>
                                @if(!$PersonalInformation->is_approved)
                                <form class="" action="{{ route('admin.approved', ['personalInformation' => $PersonalInformation]) }}" method="post">
                                    @csrf
                                    @method('put')
                                    <div class="w-full">
                                        <button class="@if($PersonalInformation->is_approved) hidden @endif" type="submit">
                                            <img class="max-w-[34px] p-1 hover:bg-green-300/50 rounded-full" src="{{asset('images/icons/tick.png')}}" alt="">
                                        </button>
                                    </div>
                                </form>
                                @endif
                            </div>
                            <a href="{{route('admin.farmerDetails', ['personalInformation' => $PersonalInformation, 'currentRoute' => 'personal'])}}">
                                <img class="max-w-[34px] p-1 hover:bg-green-300/50 rounded-full" src="{{asset('images/icons/view.png')}}" alt="">
                            </a>
                            <form class="" action="{{ route('admin.delete', ['personalInformation' => $PersonalInformation]) }}" method="post">
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
        </div>
    </section>
</x-app>