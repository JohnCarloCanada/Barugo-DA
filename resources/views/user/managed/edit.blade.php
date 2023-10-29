<x-app>
    <x-slot:title>
        Edit Farmers
    </x-slot:title>

    <x-sidebar type="managed farmers"/>   

    <section class="w-full min-h-screen p-10">
        <section class="w-[100%,900px] my-0 mx-auto bg-white flex flex-col items-center justify-center ">
            <h2 class="text-black font-bold text-3xl sm:text-4xl">Edit Farmers</h2>

            <section class="w-full mt-10  overflow-y-auto">
                <form class="w-full overflow-y-auto" action="{{route('userPersonalInformation.update', ['personalInformation' => $PersonalInformations])}}" method="post">
                    @csrf
                    @method('put')

                    @if ($errors->any())
                    <ul>
                        @foreach ($errors->all() as $error )
                            <li>{{$error}}</li>
                        @endforeach
                    </ul>
                    @endif
                    
                    <h3 class="bg-[#679f69] px-3 py-1 font-bold text-white">Part I: Personal Information</h3>

                    <div class="w-full flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 my-2">
                        <label class="sr-only" for="Surname">Surname: </label>
                        <input class="bg-[#e8e8e8] w-full px-3 py-1" type="text" name="Updated_Surname" id="Surname" placeholder="Surname" value="@if(old('Updated_Surname')) {{old('Updated_Surname')}} @elseif($PersonalInformations->Surname) {{$PersonalInformations->Surname}} @endif">
                        <label class="sr-only" for="First_Name">First Name: </label>
                        <input class="bg-[#e8e8e8] w-full px-3 py-1" type="text" name="Updated_First_Name" id="First_Name" placeholder="First Name" value="@if(old('Updated_First_Name')) {{old('Updated_First_Name')}} @elseif($PersonalInformations->First_Name) {{$PersonalInformations->First_Name}} @endif">
                        <label class="sr-only" for="Middle_Name">Middle Name: </label>
                        <input class="bg-[#e8e8e8] w-full px-3 py-1" type="text" name="Updated_Middle_Name" id="Middle_Name" placeholder="Middle Name" value="@if(old('Updated_Middle_Name')) {{old('Updated_Middle_Name')}} @elseif($PersonalInformations->Middle_Name) {{$PersonalInformations->Middle_Name}} @endif">
                        <label class="sr-only" for="Extension">Extension: </label>
                        <input class="bg-[#e8e8e8] w-[min(100%,300px)] px-3 py-1" type="text" name="Updated_Extension" id="Extension" placeholder="Extension" value="@if(old('Updated_Extension')) {{old('Updated_Extension')}} @elseif($PersonalInformations->Extension) {{$PersonalInformations->Extension}} @endif">
                    </div>

                    <div class="w-full flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 my-2">
                        <label class="sr-only" for="Surname">RSBSA No: </label>
                        <input disabled class="bg-[#e8e8e8] w-full px-3 py-1 disabled:bg-pink-200/75" type="text" name="RSBSA_No" id="RSBSA_No" placeholder="RSBSA No" value="@if(old('RSBSA_No')) {{old('RSBSA_No')}} @elseif($PersonalInformations->RSBSA_No) {{$PersonalInformations->RSBSA_No}} @endif">
                        <label class="sr-only" for="Mobile_No">Mobile No: </label>
                        <input class="bg-[#e8e8e8] w-full px-3 py-1" type="text" name="Updated_Mobile_No" id="Mobile_No" placeholder="Mobile No" value="@if(old('Updated_Mobile_No')) {{old('Updated_Mobile_No')}} @elseif($PersonalInformations->Mobile_No) {{$PersonalInformations->Mobile_No}} @endif">
                        <div class="w-full flex flex-col sm:flex-row items-start sm:items-center justify-start gap-2 bg-[#e8e8e8] px-3 py-1">
                            <p class="font-semibold text-base text-gray-400 mr-3">Sex</p>
                            <div class="flex items-center justify-center gap-1 mr-3">
                                <input class="w-full" type="radio" name="Updated_Sex" id="Male" value="Male" @if(old('Updated_Sex')) checked @elseif($PersonalInformations->Sex == "Male") checked @endif>
                                <label class="text-gray-400" for="Male">Male</label>
                            </div>
                            <div class="flex items-center justify-center gap-1 mr-3">
                                <input type="radio" name="Updated_Sex" id="Female" value="Female" @if(old('Updated_Sex')) checked @elseif($PersonalInformations->Sex == "Female") checked @endif>
                                <label class="text-gray-400" for="Female">Female</label>
                            </div>
                        </div>
                        <label class="sr-only" for="Date_of_birth">Date of Birth: </label>
                        <input class="bg-[#e8e8e8] w-full px-3 py-1 text-gray-400" type="date" name="Updated_Date_of_birth" id="Date_of_birth" value="{{$PersonalInformations->Date_of_birth}}">
                        <label class="sr-only" for="Religion">Religion:</label>
                        <select class="bg-[#e8e8e8] w-full px-3 py-1 text-gray-400" name="Updated_Religion" id="Religion">
                            @foreach ($Religions as $religion)
                                <option @if ($religion->Name == $PersonalInformations->Religion) selected @endif class="bg-[#e8e8e8]" value="{{$religion->Name}}">{{$religion->Name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="w-full flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 my-2">
                        <label class="sr-only" for="Address">Address: </label>
                        <input class="bg-[#e8e8e8] w-full px-3 py-1" type="text" name="Updated_Address" id="Address" placeholder="Address" value="@if(old('Updated_Address')) {{old('Updated_Address')}} @elseif($PersonalInformations->Address) {{$PersonalInformations->Address}} @endif">
                    </div>

                    <div class="w-full flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 my-2">
                        <div class="w-full flex flex-col sm:flex-row items-start sm:items-center justify-start gap-2 bg-[#e8e8e8] px-3 py-1">
                            <p class="font-semibold text-base text-gray-400 mr-3">Civil Status</p>
                            <div class="flex items-center justify-center gap-1 mr-3">
                                <input class="w-full" type="radio" name="Updated_Civil_Status" id="Single" value="Single" @if(old('Updated_Civil_Status')) checked @elseif($PersonalInformations->Civil_Status == "Single") checked @endif>
                                <label class="text-gray-400" for="Single">Single</label>
                            </div>
                            <div class="flex items-center justify-center gap-1 mr-3">
                                <input type="radio" name="Updated_Civil_Status" id="Married" value="Married" @if(old('Updated_Civil_Status')) checked @elseif($PersonalInformations->Civil_Status == "Married") checked @endif>
                                <label class="text-gray-400" for="Married">Married</label>
                            </div>
                            <div class="flex items-center justify-center gap-1 mr-3">
                                <input type="radio" name="Updated_Civil_Status" id="Widowed" value="Widowed" @if(old('Updated_Civil_Status')) checked @elseif($PersonalInformations->Civil_Status == "Widowed") checked @endif>
                                <label class="text-gray-400" for="Widowed">Widowed</label>
                            </div>
                            <div class="flex items-center justify-center gap-1 mr-3">
                                <input type="radio" name="Updated_Civil_Status" id="Seperated" value="Seperated" @if(old('Updated_Civil_Status')) checked @elseif($PersonalInformations->Civil_Status == "Seperated") checked @endif>
                                <label class="text-gray-400" for="Seperated">Seperated</label>
                            </div>
                        </div>
                        <label class="sr-only" for="Name_of_Spouse">Name Of Spouse: </label>
                        <input disabled class="bg-[#e8e8e8] w-[50%] px-3 py-1" type="text" name="Updated_Name_of_Spouse" id="Name_of_Spouse" placeholder="Name of Spouse if married" value="@if(old('Updated_Name_of_Spouse')) {{old('Updated_Name_of_Spouse')}} @elseif($PersonalInformations->Name_of_Spouse) {{$PersonalInformations->Name_of_Spouse}} @endif">
                    </div>

                    <div class="w-full flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 my-2">
                        <div class="w-full flex flex-col sm:flex-row items-start sm:items-center justify-start sm:justify-between gap-2 bg-[#e8e8e8] px-3 py-1">
                            <p class="font-semibold text-base text-gray-400 mr-3">Highest Education Qualification</p>
                            <div class="flex items-center justify-center gap-1 mr-3">
                                <input class="w-full" type="radio" name="Updated_Highest_education_qualification" id="Pre School" value="Pre School" @if(old('Updated_Highest_education_qualification')) checked @elseif($PersonalInformations->Highest_education_qualification == "Pre School") checked @endif>
                                <label class="text-gray-400" for="Pre_School">Pre School</label>
                            </div>
                            <div class="flex items-center justify-center gap-1 mr-3">
                                <input type="radio" name="Updated_Highest_education_qualification" id="Elementary" value="Elementary" @if(old('Updated_Highest_education_qualification')) checked @elseif($PersonalInformations->Highest_education_qualification == "Elementary") checked @endif>
                                <label class="text-gray-400" for="Elementary">Elementary</label>
                            </div>
                            <div class="flex items-center justify-center gap-1 mr-3">
                                <input type="radio" name="Updated_Highest_education_qualification" id="High School" value="High School" @if(old('Updated_Highest_education_qualification')) checked @elseif($PersonalInformations->Highest_education_qualification == "High School") checked @endif>
                                <label class="text-gray-400" for="High_School">High School</label>
                            </div>
                            <div class="flex items-center justify-center gap-1 mr-3">
                                <input type="radio" name="Updated_Highest_education_qualification" id="College" value="College" @if(old('Updated_Highest_education_qualification')) checked @elseif($PersonalInformations->Highest_education_qualification == "College") checked @endif>
                                <label class="text-gray-400" for="College">College</label>
                            </div>
                            <div class="flex items-center justify-center gap-1 mr-3">
                                <input type="radio" name="Updated_Highest_education_qualification" id="None" value="None" @if(old('Updated_Highest_education_qualification')) checked @elseif($PersonalInformations->Highest_education_qualification == "None") checked @endif>
                                <label class="text-gray-400" for="None">None</label>
                            </div>
                        </div>
                    </div>
                    <h3 class="bg-[#679f69] px-3 py-1 font-bold text-white">Part II: Farm Profile</h3>
                    <div class="w-full flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 my-2">
                        <select class="bg-[#e8e8e8] px-3 py-1 text-gray-400" name="Updated_Main_livelihood" id="Main_livelihood">
                            @foreach ($Livelihood as $livelihood)
                                <option @if ($livelihood->Name == $PersonalInformations->Main_livelihood) selected @endif class="bg-[#e8e8e8]" value="{{$livelihood->Name}}">{{$livelihood->Name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="w-full flex flex-col sm:flex-row items-start sm:items-center justify-end gap-3 my-2">
                        <input class="bg-[#679f69] py-1 px-2 text-white font-bold cursor-pointer" type="submit" value="Edit Farmer">
                    </div>
                </form>
            </section>
        </section>
    </section>
</x-app>

<script>
    const civilStatusBtn = document.querySelectorAll('input[name="Updated_Civil_Status"]');
    const spouseInput = document.querySelector('input[name="Updated_Name_of_Spouse"]');

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