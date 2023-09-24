<x-app>
    <x-slot:title>
        Managed Farmers
    </x-slot:title>

    <x-sidebar type="managed farmers"/>   

    <section class="w-full min-h-screen p-5 overflow-y-auto">
        <section class="flex flex-col my-2 items-start justify-center gap-y-6">
            <h2 class="text-2xl sm:text-4xl font-bold text-black">Managed Farmers</h2>
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-y-3 sm:gap-y-0 justify-center gap-x-3">
                <a aria-label="Go to add farmers" class="py-2 px-3 bg-[#679f69] rounded flex items-center justify-between gap-x-4" href="{{route('personalInformation.create')}}">
                    <p class="text-white font-bold text-xs">ADD FARMER</p>
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
                        <th class="">RSBSA No.</th>
                        <th class="">Surname</th>
                        <th class="">Address</th>
                        <th class="">Mobile No.</th>
                        <th class="">Main Livelihood</th>
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
                            <td class="flex items-center justify-center">
                                <a class="bg-[#679f69] px-3 py-1 rounded-lg text-white font-bold cursor-pointer" href="{{ route('personalInformation.edit', ['personalInformation' => $PersonalInformation]) }}">Edit</a>
                                <form class="w-full" action="{{ route('personalInformation.destroy', ['personalInformation' => $PersonalInformation]) }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <div>
                                        <input class="bg-[#679f69] px-3 py-1 rounded-lg text-white font-bold cursor-pointer" type="submit" value="Delete">
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