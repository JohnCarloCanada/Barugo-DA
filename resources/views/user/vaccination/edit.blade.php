<x-app>
    <x-slot:title>
        Employee | Edit Dog Record
    </x-slot:title>

    <x-sidebar type="canine records"/>   

    <section class="w-full min-h-screen p-10">
        <section class="w-[100%,900px] my-0 mx-auto bg-white flex flex-col items-center justify-center ">
            <h2 class="text-black font-bold text-3xl sm:text-4xl">Add New Dog Record</h2>
            @if ($errors->any())
            <ul class="grid grid-cols-2 sm:grid-cols-4 gap-1 mb-3">
                @foreach ($errors->all() as $error )
                    <li class="text-sm sm:text-base text-red-800 font-bold">{{$error}}</li>
                @endforeach
            </ul>
            @endif
            <section class="w-full mt-10 overflow-y-auto">
                <form class="w-full overflow-y-auto" action="{{route('dogVaccinationInformation.update', ['dogInformation' => $DogInformation])}}" method="post">
                    @csrf
                    @method('put')
                    <h3 class="bg-[#679f69] px-3 py-1 font-bold text-white">Part I: Dog Profile</h3>

                    <div class="w-full flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 my-2">
                        <label class="sr-only" for="Dog_Name">Name: </label>
                        <input class="bg-[#e8e8e8] w-full px-3 py-1" type="text" name="Dog_Name" id="Dog_Name" placeholder="Dog Name" value="{{$DogInformation->Dog_Name}}">
                        <label class="sr-only" for="Species">Species: </label>
                        <input class="bg-[#e8e8e8] w-full px-3 py-1" type="text" name="Species" id="Species" placeholder="Species" value="{{$DogInformation->Species}}">
                        <label class="sr-only" for="Age">Age: </label>
                        <input class="bg-[#e8e8e8] w-full px-3 py-1" type="number" name="Age" id="Age" placeholder="Age" value="{{$DogInformation->Age}}">
                        <div class="w-full flex flex-col sm:flex-row items-start sm:items-center justify-start gap-2 bg-[#e8e8e8] px-3 py-1">
                            <p class="font-semibold text-base text-gray-400 mr-3">Sex</p>
                            <div class="flex items-center justify-center gap-1 mr-3">
                                <input class="w-full" type="radio" name="Sex" id="Male" value="Male" @if($DogInformation->Sex == 'Male') checked @endif>
                                <label class="text-gray-400" for="Male">Male</label>
                            </div>
                            <div class="flex items-center justify-center gap-1 mr-3">
                                <input type="radio" name="Sex" id="Female" value="Female" @if($DogInformation->Sex == 'Female') checked @endif>
                                <label class="text-gray-400" for="Female">Female</label>
                            </div>
                        </div>
                        <div class="w-full flex flex-col sm:flex-row items-start sm:items-center justify-start gap-2 bg-[#e8e8e8] px-3 py-1">
                            <p class="font-semibold text-base text-gray-400 mr-3">Neutering</p>
                            <div class="flex items-center justify-center gap-1 mr-3">
                                <input class="w-full" type="radio" name="Neutering" id="Yes" value="Yes" @if($DogInformation->Neutering == 'Yes') checked @endif >
                                <label class="text-gray-400" for="Yes">Yes</label>
                            </div>
                            <div class="flex items-center justify-center gap-1 mr-3">
                                <input type="radio" name="Neutering" id="No" value="No" @if($DogInformation->Neutering == 'No') checked @endif>
                                <label class="text-gray-400" for="No">No</label>
                            </div>
                        </div>
                        <label class="sr-only" for="Color">Color: </label>
                        <input class="bg-[#e8e8e8] w-full px-3 py-1" type="text" name="Color" id="Color" placeholder="Color" value="{{$DogInformation->Color}}">
                    </div>                
                    <h3 class="bg-[#679f69] px-3 py-1 font-bold text-white">Part II: Owner Profile</h3>
                    <div class="w-full flex flex-col sm:flex-row items-center gap-3 my-2">
                        <label class="text-base text-[#979797] whitespace-nowrap" for="RSBSA_No" >RSBSA No</label>
                        <select class="bg-[#e8e8e8]  w-[min(100px,100%)] px-3 py-1 text-gray-400" name="RSBSA_No" id="RSBSA_No">
                            @foreach ($personalInformation as $info)
                                <option @if ($info->id == $DogInformation->personal_information_id) selected @endif class="bg-[#e8e8e8]" value="{{$info->id}}">{{$info->RSBSA_No}}</option>
                            @endforeach
                        </select>
                    </div>

                    <h3 class="bg-[#679f69] px-3 py-1 font-bold text-white">Part III: Remarks</h3>
                    <div class="w-full flex flex-col gap-3 my-2">
                        <label class="text-base text-[#979797]" for="MachineName" >Remarks</label>
                        <textarea class="bg-[#e8e8e8] w-full px-3 py-1" name="Remarks" id="Remarks" cols="30" rows="10">{{$DogInformation->Remarks}}</textarea>
                    </div>

                    <div class="w-full flex flex-col sm:flex-row items-start sm:items-center justify-end gap-3 my-2">
                        <input class="bg-[#679f69] py-1 px-2 text-white font-bold cursor-pointer" type="submit" value="Add Record">
                    </div>
                </form>
            </section>
        </section>
    </section>
</x-app>