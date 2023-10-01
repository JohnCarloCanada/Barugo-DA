<x-app>
    <x-slot:title>
        Admin | Farmer
    </x-slot:title>

    <x-admin.sidebar type="managed farmers"/>


    <section class="w-full min-h-screen p-5 overflow-y-auto">
        <div class=" my-3">
            <h2 class="font-bold text-2xl">Farmers Details</h2>
            <p class="text-sm">Approval and Inforamtion About the farmers.</p>
        </div>
        <div class="flex flex-col w-full h-full">
            <table class="flex flex-col overflow-x-auto min-w-[800px] md:max-w-full shadow-md border border-2 rounded">
                <tr class="grid grid-cols-1 py-2 bg-green-700 text-white w-full">
                    <th class="w-full px-3 relative flex md:justify-end justify-center items-center py-2">
                        <input class="md:w-1/2 px-3 py-1 bg-slate-100 rounded outline-0 text-ms text-slate-800 w-[90%]" placeholder="Search..." type="text">
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
                        <td class="flex items-center justify-center gap-2">
                            <a href="/admin/farmers/details/personal">
                                <img class="max-w-[34px] p-1 hover:bg-green-300/50 rounded-full" src="{{asset('images/icons/view.png')}}" alt="">
                            </a>
                            @if($PersonalInformation->is_approved)
                            <form class="" action="{{ route('admin.approved', ['personalInformation' => $PersonalInformation]) }}" method="post">
                                @csrf
                                @method('put')
                                <div class="w-full">
                                    <input class="bg-[#679f69] hidden w-full px-3 py-1 rounded-lg text-white font-bold cursor-pointer @if($PersonalInformation->is_approved) hidden @endif" type="submit" value="Approved">
                                    <button type="submit">
                                        <img class="max-w-[34px] p-1 hover:bg-green-300/50 rounded-full" src="{{asset('images/icons/tick.png')}}" alt="">
                                    </button>
                                </div>
                            </form>
                            @endif
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
        <section class="w-[100%,900px] h-[500px] mx-auto overflow-x-auto bg-white rounded-lg">
            <table class="w-full mt-5 text-center">
                <thead>
                    <tr >
                        <th class="">RSBSA No.</th>
                        <th class="">Surname</th>
                        <th class="">Address</th>
                        <th class="">Mobile No.</th>
                        <th class="">Main Livelihood</th>
                        <th class="">Status</th>
                        <th class="">Operation</th>
                    </tr>
                </thead>
        
                <tbody>
                    @foreach ($PersonalInformations as $PersonalInformation)
                        <tr class="pt-10 odd:bg-slate-200">
                            <td>{{$PersonalInformation->RSBSA_No}}</td>
                            <td>{{$PersonalInformation->Surname}}</td>
                            <td>{{$PersonalInformation->Address}}</td>
                            <td>{{$PersonalInformation->Mobile_No}}</td>
                            <td>{{$PersonalInformation->Main_livelihood}}</td>
                            <td class="{{ $PersonalInformation->is_approved ? "text-green-500 font-bold p-1 rounded h-fit w-fit" : "text-red-500 font-bold p-1 rounded h-fit w-fit"}}">{{ $PersonalInformation->is_approved ? "Active" : "In-Active"}}</td>
                            <td class="flex items-center justify-center gap-2">
                                <a href="/admin/farmers/details/personal">
                                    <img class="max-w-[34px] p-1 hover:bg-green-300/50 rounded-full" src="{{asset('images/icons/view.png')}}" alt="">
                                </a>
                                @if($PersonalInformation->is_approved)
                                <form class="" action="{{ route('admin.approved', ['personalInformation' => $PersonalInformation]) }}" method="post">
                                    @csrf
                                    @method('put')
                                    <div class="w-full">
                                        <input class="bg-[#679f69] hidden w-full px-3 py-1 rounded-lg text-white font-bold cursor-pointer @if($PersonalInformation->is_approved) hidden @endif" type="submit" value="Approved">
                                        <button type="submit">
                                            <img class="max-w-[34px] p-1 hover:bg-green-300/50 rounded-full" src="{{asset('images/icons/tick.png')}}" alt="">
                                        </button>
                                    </div>
                                </form>
                                @endif
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
                </tbody>
            </table>
        </section>
    </section>
</x-app>