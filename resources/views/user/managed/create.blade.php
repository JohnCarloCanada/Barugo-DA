<x-app>
    <x-slot:title>
        Add New Farmers
    </x-slot:title>

    <x-sidebar type="managed farmers"/>   

    <section class="w-full min-h-screen p-10">
        <section class="w-[100%,900px] my-0 mx-auto bg-white flex flex-col items-center justify-center">
            <h2 class="text-black font-bold text-3xl sm:text-4xl">Add New Farmer</h2>

            <section class="w-full mt-10">
                <form class="w-full" action="{{route('managed.store')}}" method="post">
                    @csrf
                    <h3 class="bg-[#679f69] px-3 py-1 font-bold text-white">Part I: Personal Information</h3>

                    <div class="w-full flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 my-2">
                        <label class="sr-only" for="Surname">Surname: </label>
                        <input required class="bg-[#e8e8e8] w-full px-3 py-1" type="text" name="Surname" id="Surname" placeholder="Surname">
                        <label class="sr-only" for="First_Name">First Name: </label>
                        <input required class="bg-[#e8e8e8] w-full px-3 py-1" type="text" name="First_Name" id="First_Name" placeholder="First Name">
                        <label class="sr-only" for="Middle_Name">Middle Name: </label>
                        <input class="bg-[#e8e8e8] w-full px-3 py-1" type="text" name="Middle_Name" id="Middle_Name" placeholder="Middle Name">
                        <label class="sr-only" for="Extension">Extension: </label>
                        <input class="bg-[#e8e8e8] w-[min(100%,300px)] px-3 py-1" type="text" name="Extension" id="Extension" placeholder="Extension">
                    </div>

                    <div class="w-full flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 my-2">
                        <label class="sr-only" for="Surname">RSBSA No: </label>
                        <input required class="bg-[#e8e8e8] w-full px-3 py-1" type="text" name="RSBSA_No" id="RSBSA_No" placeholder="RSBSA No">
                        <label class="sr-only" for="Mobile_No">Mobile No: </label>
                        <input required class="bg-[#e8e8e8] w-full px-3 py-1" type="text" name="Mobile_No" id="Mobile_No" placeholder="Mobile No">
                        <div class="w-full flex flex-col sm:flex-row items-start sm:items-center justify-start gap-2 bg-[#e8e8e8] px-3 py-1">
                            <p class="font-semibold text-base text-gray-400 mr-3">Sex</p>
                            <div class="flex items-center justify-center gap-1 mr-3">
                                <input required class="w-full" type="radio" name="Sex" id="Male" value="Male">
                                <label class="text-gray-400" for="Male">Male</label>
                            </div>
                            <div class="flex items-center justify-center gap-1 mr-3">
                                <input required type="radio" name="Sex" id="Female" value="Female">
                                <label class="text-gray-400" for="Female">Female</label>
                            </div>
                        </div>
                        <label class="sr-only" for="Date_of_birth">Date of Birth: </label>
                        <input required class="bg-[#e8e8e8] w-full px-3 py-1 text-gray-400" type="date" name="Date_of_birth" id="Date_of_birth">
                        <label class="sr-only" for="Religion">Religion:</label>
                        <select required class="bg-[#e8e8e8] w-full px-3 py-1 text-gray-400" name="Religion" id="Religion">
                            <option class="bg-[#e8e8e8]" value="Roman Cathloic">Roman Cathloic</option>
                            <option class="bg-[#e8e8e8]" value="Christian">Christian</option>
                            <option class="bg-[#e8e8e8]" value="Born Again">Born Again</option>
                            <option class="bg-[#e8e8e8]" value="Saksi Ni Monta">Saksi Ni Monta</option>
                        </select>
                    </div>

                    <div class="w-full flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 my-2">
                        <label class="sr-only" for="Address">Address: </label>
                        <input class="bg-[#e8e8e8] w-full px-3 py-1" type="text" name="Address" id="Address" placeholder="Address">
                    </div>

                    <div class="w-full flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 my-2">
                        <div class="w-full flex flex-col sm:flex-row items-start sm:items-center justify-start gap-2 bg-[#e8e8e8] px-3 py-1">
                            <p class="font-semibold text-base text-gray-400 mr-3">Civil Status</p>
                            <div class="flex items-center justify-center gap-1 mr-3">
                                <input required class="w-full" type="radio" name="Civil_Status" id="Single" value="Single">
                                <label class="text-gray-400" for="Single">Single</label>
                            </div>
                            <div class="flex items-center justify-center gap-1 mr-3">
                                <input required type="radio" name="Civil_Status" id="Married" value="Married">
                                <label class="text-gray-400" for="Married">Married</label>
                            </div>
                            <div class="flex items-center justify-center gap-1 mr-3">
                                <input required type="radio" name="Civil_Status" id="Widowed" value="Widowed">
                                <label class="text-gray-400" for="Widowed">Widowed</label>
                            </div>
                            <div class="flex items-center justify-center gap-1 mr-3">
                                <input required type="radio" name="Civil_Status" id="Seperated" value="Seperated">
                                <label class="text-gray-400" for="Seperated">Seperated</label>
                            </div>
                        </div>
                        <label class="sr-only" for="Name_of_Spouse">Name Of Spouse: </label>
                        <input class="bg-[#e8e8e8] w-[50%] px-3 py-1" type="text" name="Name_of_Spouse" id="Name_of_Spouse" placeholder="Name of Spouse if married">
                    </div>

                    <div class="w-full flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 my-2">
                        <div class="w-full flex flex-col sm:flex-row items-start sm:items-center justify-start sm:justify-between gap-2 bg-[#e8e8e8] px-3 py-1">
                            <p class="font-semibold text-base text-gray-400 mr-3">Highest Education Qualification</p>
                            <div class="flex items-center justify-center gap-1 mr-3">
                                <input required class="w-full" type="radio" name="Highest_educational_qualification" id="Pre School" value="Pre School">
                                <label class="text-gray-400" for="Pre_School">Pre School</label>
                            </div>
                            <div class="flex items-center justify-center gap-1 mr-3">
                                <input required type="radio" name="Highest_educational_qualification" id="Elementary" value="Elementary">
                                <label class="text-gray-400" for="Elementary">Elementary</label>
                            </div>
                            <div class="flex items-center justify-center gap-1 mr-3">
                                <input required type="radio" name="Highest_educational_qualification" id="High School" value="High School">
                                <label class="text-gray-400" for="High_School">High School</label>
                            </div>
                            <div class="flex items-center justify-center gap-1 mr-3">
                                <input required type="radio" name="Highest_educational_qualification" id="College" value="College">
                                <label class="text-gray-400" for="College">College</label>
                            </div>
                            <div class="flex items-center justify-center gap-1 mr-3">
                                <input required type="radio" name="Highest_educational_qualification" id="None" value="None">
                                <label class="text-gray-400" for="None">None</label>
                            </div>
                        </div>
                    </div>
                    <h3 class="bg-[#679f69] px-3 py-1 font-bold text-white">Part II: Farm Profile</h3>
                    <div class="w-full flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 my-2">
                        <div class="w-full flex flex-col sm:flex-row items-start sm:items-center justify-start sm:justify-between gap-2 bg-[#e8e8e8] px-3 py-1">
                            <p class="font-semibold text-base text-gray-400 mr-3">Main Livelihood</p>
                            <div class="flex items-center justify-center gap-1 mr-3">
                                <input required type="radio" name="Main_Livelihood" id="Farmer" value="Farmer">
                                <label class="text-gray-400" for="Farmer">Farmer</label>
                            </div>
                            <div class="flex items-center justify-center gap-1 mr-3">
                                <input required type="radio" name="Main_Livelihood" id="Farmworker/Laborer" value="Farmworker/Laborer">
                                <label class="text-gray-400" for="Farmworker/Laborer">Farmworker/Laborer</label>
                            </div>
                            <div class="flex items-center justify-center gap-1 mr-3">
                                <input required type="radio" name="Main_Livelihood" id="Fisherfolk" value="Fisherfolk">
                                <label class="text-gray-400" for="Fisherfolk">Fisherfolk</label>
                            </div>
                            <div class="flex items-center justify-center gap-1 mr-3">
                                <input required type="radio" name="Main_Livelihood" id="Agri_Youth" value="Agri Youth">
                                <label class="text-gray-400" for="Agri_Youth">Agri Youth</label>
                            </div>
                        </div>
                    </div>
                    <div class="w-full flex flex-col sm:flex-row items-start sm:items-center justify-end gap-3 my-2">
                        <input class="bg-[#679f69] py-1 px-2 text-white font-bold cursor-pointer" type="submit" value="Add Farmer">
                    </div>
                </form>
            </section>
        </section>
    </section>
</x-app>