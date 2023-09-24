<x-app>
    <x-slot:title>
        Admin Dashboard
    </x-slot:title>

    <x-sidebar type="dashboard"/>


    <section class="w-full min-h-screen p-5 overflow-y-auto">
        <section class="w-[100%,900px] h-[500px] mx-auto overflow-x-auto bg-white rounded-lg">
            <table class="w-full mt-5 text-center">
                <thead>
                    <tr>
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
                        <tr class="pt-10">
                            <td>{{$PersonalInformation->RSBSA_No}}</td>
                            <td>{{$PersonalInformation->Surname}}</td>
                            <td>{{$PersonalInformation->Address}}</td>
                            <td>{{$PersonalInformation->Mobile_No}}</td>
                            <td>{{$PersonalInformation->Main_livelihood}}</td>
                            <td>{{ $PersonalInformation->is_approved ? "Active" : "In-Active"}}</td>
                            <td class="flex items-center justify-center gap-3">
                                <form class="w-full" action="{{ route('admin.approved', ['personalInformation' => $PersonalInformation]) }}" method="post">
                                    @csrf
                                    @method('put')
                                    <div class="w-full">
                                        <input class="bg-[#679f69] w-full px-3 py-1 rounded-lg text-white font-bold cursor-pointer @if($PersonalInformation->is_approved) hidden @endif" type="submit" value="Approved">
                                    </div>
                                </form>
                                <form class="w-full" action="{{ route('admin.delete', ['personalInformation' => $PersonalInformation]) }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <div class="w-full">
                                        <input class="bg-red-500 w-full px-3 py-1 rounded-lg text-white font-bold cursor-pointer" type="submit" value="Delete">
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