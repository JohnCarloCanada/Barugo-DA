<x-app>
    <x-slot:title>
        Add New Livestock
    </x-slot:title>

    <x-sidebar type="managed farmers"/>   

    <section class="w-full min-h-screen p-10">
        <section class="w-[100%,900px] my-0 mx-auto bg-white flex flex-col items-center justify-center ">
            <h2 class="text-black font-bold text-3xl sm:text-4xl">Add New Livestock</h2>
            @if ($errors->any())
            <ul class="grid grid-cols-2 sm:grid-cols-4 gap-1 mb-3">
                @foreach ($errors->all() as $error )
                    <li class="text-sm sm:text-base text-red-800 font-bold">{{$error}}</li>
                @endforeach
            </ul>
            @endif
            <section class="w-full mt-3">
                <h3 class="bg-[#679f69] px-3 py-1 font-bold text-white">Livestock</h3>

                <form class="w-full flex flex-col justify-center items-center mt-5 sm:mt-6" action="{{route('adminLiveStockInformation.store', ['personalInformation' => $personalInformation])}}" method="post">
                    @csrf 

                    <div class="w-[min(100%,300px)] flex items-center sm:items-center justify-center flex-col gap-y-3">
                        <div class="flex flex-col sm:flex-row gap-4">
                            <label class="text-base sm:text-xl font-bold text-[#979797]" for="LSAnimals">Livestocks</label>
                            <select class="bg-green-600 px-5 py-1 rounded-3xl text-white font-bold cursor-pointer" name="LSAnimals" id="LSAnimals">
                                <option value="Carabao">Carabao</option>
                                <option value="Cattle">Cattle</option>
                                <option value="Goat">Goat</option>
                                <option value="Sheep">Sheep</option>
                                <option value="Swine">Swine</option>
                            </select>
                        </div>
    
                        <div class="flex flex-col sm:flex-row gap-4">
                            <label class="text-base sm:text-xl font-bold text-[#979797]" for="Sex_LS">Sex</label>
                            <select class="bg-green-600 px-5 py-1 rounded-3xl text-white font-bold cursor-pointer" name="Sex_LS" id="Sex_LS">
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>

                        <div class="flex items-center flex-col sm:flex-row gap-x-4">
                            <label class="text-base sm:text-xl font-bold text-[#979797]" for="Livestock_Name">Name</label>
                            <input class="bg-green-600 rounded-xl px-3 py-1 text-white font-bold" type="text" name="Livestock_Name" id="Livestock_Name">
                        </div>

                        <div class="w-full flex flex-col sm:flex-row items-center justify-end gap-3 my-2">
                            <input class="bg-[#679f69] py-1 px-2 text-white font-bold cursor-pointer" type="submit" value="Add Livestock">
                        </div>
                    </div>
                </form>
            </section>
        </section>
    </section>
</x-app>