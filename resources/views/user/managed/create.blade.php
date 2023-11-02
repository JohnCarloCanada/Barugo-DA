<x-app>
    <x-slot:title>
        Employee | New Farmer
    </x-slot:title>

    <x-sidebar type="managed farmers"/>   

    <section class="w-full min-h-screen p-10">
        <section class="w-[100%,900px] my-0 mx-auto bg-white flex flex-col items-center justify-center ">
            <h2 class="text-black font-bold text-3xl sm:text-4xl">Add New Farmer</h2>

            <section class="w-full mt-10 overflow-y-auto">
                <form class="w-full overflow-y-auto" action="{{route('userPersonalInformation.store')}}" method="post">
                    @csrf

                    @if ($errors->any())
                    <ul class="grid grid-cols-2 sm:grid-cols-4 gap-1 mb-3">
                        @foreach ($errors->all() as $error )
                            <li class="text-sm sm:text-base text-red-800 font-bold">{{$error}}</li>
                        @endforeach
                    </ul>
                    @endif
                    <h3 class="bg-[#679f69] px-3 py-1 font-bold text-white">Part I: Personal Information</h3>

                    <div class="w-full flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 my-2">
                        <label class="sr-only" for="Surname">Surname: </label>
                        <input class="bg-[#e8e8e8] w-full px-3 py-1" type="text" name="Surname" id="Surname" placeholder="Surname" value="{{old('Surname')}}">
                        <label class="sr-only" for="First_Name">First Name: </label>
                        <input class="bg-[#e8e8e8] w-full px-3 py-1" type="text" name="First_Name" id="First_Name" placeholder="First Name" value="{{old('First_Name')}}">
                        <label class="sr-only" for="Middle_Name">Middle Name: </label>
                        <input class="bg-[#e8e8e8] w-full px-3 py-1" type="text" name="Middle_Name" id="Middle_Name" placeholder="Middle Name" value="{{old('Middle_Name')}}">
                        <label class="sr-only" for="Extension">Extension: </label>
                        <input class="bg-[#e8e8e8] w-[min(100%,300px)] px-3 py-1" type="text" name="Extension" id="Extension" placeholder="Extension" value="{{old('Extension')}}">
                    </div>

                    <div class="w-full flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 my-2">
                        <label class="sr-only" for="Surname">RSBSA No: </label>
                        <input class="bg-[#e8e8e8] w-full px-3 py-1" type="text" name="RSBSA_No" id="RSBSA_No" placeholder="RSBSA No" value="{{old('RSBSA_No')}}">
                        <label class="sr-only" for="Mobile_No">Mobile No: </label>
                        <input class="bg-[#e8e8e8] w-full px-3 py-1" type="text" name="Mobile_No" id="Mobile_No" placeholder="Mobile No" value="{{old('Mobile_No')}}">
                        <div class="w-full flex flex-col sm:flex-row items-start sm:items-center justify-start gap-2 bg-[#e8e8e8] px-3 py-1">
                            <p class="font-semibold text-base text-gray-400 mr-3">Sex</p>
                            <div class="flex items-center justify-center gap-1 mr-3">
                                <input class="w-full" type="radio" name="Sex" id="Male" value="Male" @if(old('Sex')) checked @endif>
                                <label class="text-gray-400" for="Male">Male</label>
                            </div>
                            <div class="flex items-center justify-center gap-1 mr-3">
                                <input type="radio" name="Sex" id="Female" value="Female" @if(old('Sex')) checked @endif>
                                <label class="text-gray-400" for="Female">Female</label>
                            </div>
                        </div>
                        <label class="sr-only" for="Date_of_birth">Date of Birth: </label>
                        <input class="bg-[#e8e8e8] w-full px-3 py-1 text-gray-400" type="date" name="Date_of_birth" id="Date_of_birth">
                        <label class="sr-only" for="Religion">Religion:</label>
                        <select class="bg-[#e8e8e8] w-full px-3 py-1 text-gray-400" name="Religion" id="Religion">
                            @foreach ($Religions as $religion)
                                <option class="bg-[#e8e8e8]" value="{{$religion->Name}}">{{$religion->Name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="w-full flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 my-2">
                        <label class="sr-only" for="Address">Address: </label>
                        <input class="bg-[#e8e8e8] w-full px-3 py-1" type="text" name="Address" id="Address" placeholder="Address" value="{{old('Address')}}">
                    </div>

                    <div class="w-full flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 my-2">
                        <div class="w-full flex flex-col sm:flex-row items-start sm:items-center justify-start gap-2 bg-[#e8e8e8] px-3 py-1">
                            <p class="font-semibold text-base text-gray-400 mr-3">Civil Status</p>
                            <div class="flex items-center justify-center gap-1 mr-3">
                                <input class="w-full" type="radio" name="Civil_Status" id="Single" value="Single">
                                <label class="text-gray-400" for="Single">Single</label>
                            </div>
                            <div class="flex items-center justify-center gap-1 mr-3">
                                <input type="radio" name="Civil_Status" id="Married" value="Married">
                                <label class="text-gray-400" for="Married">Married</label>
                            </div>
                            <div class="flex items-center justify-center gap-1 mr-3">
                                <input type="radio" name="Civil_Status" id="Widowed" value="Widowed">
                                <label class="text-gray-400" for="Widowed">Widowed</label>
                            </div>
                            <div class="flex items-center justify-center gap-1 mr-3">
                                <input type="radio" name="Civil_Status" id="Seperated" value="Seperated">
                                <label class="text-gray-400" for="Seperated">Seperated</label>
                            </div>
                        </div>
                        <label class="sr-only" for="Name_of_Spouse">Name Of Spouse: </label>
                        <input disabled class="bg-[#e8e8e8] w-[50%] px-3 py-1" type="text" name="Name_of_Spouse" id="Name_of_Spouse" placeholder="Name of Spouse if married">
                    </div>

                    <div class="w-full flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 my-2">
                        <div class="w-full flex flex-col sm:flex-row items-start sm:items-center justify-start sm:justify-between gap-2 bg-[#e8e8e8] px-3 py-1">
                            <p class="font-semibold text-base text-gray-400 mr-3">Highest Education Qualification</p>
                            <div class="flex items-center justify-center gap-1 mr-3">
                                <input class="w-full" type="radio" name="Highest_education_qualification" id="Pre School" value="Pre School">
                                <label class="text-gray-400 whitespace-nowrap" for="Pre_School">Pre School</label>
                            </div>
                            <div class="flex items-center justify-center gap-1 mr-3">
                                <input type="radio" name="Highest_education_qualification" id="Elementary" value="Elementary">
                                <label class="text-gray-400" for="Elementary">Elementary</label>
                            </div>
                            <div class="flex items-center justify-center gap-1 mr-3">
                                <input type="radio" name="Highest_education_qualification" id="High School" value="High School">
                                <label class="text-gray-400" for="High_School">High School</label>
                            </div>
                            <div class="flex items-center justify-center gap-1 mr-3">
                                <input type="radio" name="Highest_education_qualification" id="College" value="College">
                                <label class="text-gray-400" for="College">College</label>
                            </div>
                            <div class="flex items-center justify-center gap-1 mr-3">
                                <input type="radio" name="Highest_education_qualification" id="None" value="None">
                                <label class="text-gray-400" for="None">None</label>
                            </div>
                        </div>
                    </div>
                    <h3 class="bg-[#679f69] px-3 py-1 font-bold text-white">Part II: Farm Profile</h3>
                    <div class="w-full flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 my-2">
                        <select class="bg-[#e8e8e8] px-3 py-1 text-gray-400" name="Main_livelihood" id="Main_livelihood">
                            @foreach ($Livelihood as $livelihood)
                                <option class="bg-[#e8e8e8]" value="{{$livelihood->Name}}">{{$livelihood->Name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="w-full flex flex-col sm:flex-row items-start sm:items-center justify-end gap-3 my-2">
                        <input class="bg-[#679f69] py-1 px-2 text-white font-bold cursor-pointer" type="submit" value="Add Farmer">
                    </div>
                </form>
            </section>
        </section>
    </section>
</x-app>

<script>
    const civilStatusBtn = document.querySelectorAll('input[name="Civil_Status"]');
    const spouseInput = document.querySelector('input[name="Name_of_Spouse"]');

    civilStatusBtn.forEach(btn => {
        btn.addEventListener('change', () => {
            if(btn.value === 'Single') {
                spouseInput.disabled = true;
            } else {
                spouseInput.disabled = false;
            }
        })
    })
</script>