<x-app>
    <x-slot:title>
        Add New Machinery
    </x-slot:title>

    <x-admin.sidebar type="managed farmers"/>   

    <section class="w-full min-h-screen p-10">
        <section class="w-[100%,900px] my-0 mx-auto bg-white flex flex-col items-center justify-center ">
            <h2 class="text-black font-bold text-3xl sm:text-4xl">Add New Machinery</h2>
            @if ($errors->any())
            <ul class="grid grid-cols-2 sm:grid-cols-4 gap-1 mb-3">
                @foreach ($errors->all() as $error )
                    <li class="text-sm sm:text-base text-red-800 font-bold">{{$error}}</li>
                @endforeach
            </ul>
            @endif
            <section class="w-full mt-3">
                <h3 class="bg-[#679f69] px-3 py-1 font-bold text-white">Machinery</h3>

                <form  action="{{route('adminMachineryInformation.store', ['personalInformation' => $personalInformation])}}" class="w-full flex flex-col justify-center items-center mt-5 sm:mt-6" method="post">
                    @csrf 

                    <div class="w-[min(100%,300px)] flex items-center sm:items-start justify-center flex-col gap-y-5 sm:gap-y-3">
                        <div class="flex flex-col sm:flex-row gap-4">
                            <label class="text-base sm:text-xl font-bold text-[#979797]" for="MachineName" >Machinery</label>
                            <select class="bg-[#679f69] px-5 py-1 rounded-3xl text-white font-bold cursor-pointer" name="MachineName" id="MachineName">
                                <option value="Hand Tractor">Hand Tractor</option>
                                <option value="Palay Threaser">Palay Threaser</option>
                                <option value="Rice Mill">Rice Mill</option>
                                <option value="Wheel Tractor">Wheel Tractor</option>
                                <option value="Combine Harvester">Combine Harvester</option>
                            </select>
                        </div>
    
                        <div class="flex items-center flex-col sm:flex-row gap-x-2">
                            <p class="whitespace-nowrap text-base font-bold text-[#979797]">Mode of Acqusition</p>
                            <div class="whitespace-nowrap">
                                <input type="radio" name="Mode_Acqusition" id="Purchased" value="Purchased">
                                <label class="text-gray-400" for="Purchased">Purchased</label>
                            </div>
                            <div class="whitespace-nowrap">
                                <input type="radio" name="Mode_Acqusition" id="Grant" value="Grant">
                                <label class="text-gray-400" for="Grant">Grant</label>
                            </div>
                        </div>

                        <div class="flex items-center flex-col sm:flex-row gap-x-4">
                            <label class="text-gray-400 font-bold text-base" for="Price">Price</label>
                            <input class="bg-[#679f69] rounded-xl px-3 py-1 text-white font-bold" step="0.01" type="number" name="Price" id="Price">
                        </div>

                        <div class="flex items-center flex-col sm:flex-row gap-x-2">
                            <p class="whitespace-nowrap text-base font-bold text-[#979797]">Mode of Acqusition</p>
                            <div class="whitespace-nowrap">
                                <input type="radio" name="Use_of_Machinery" id="Rental" value="Rental">
                                <label class="text-gray-400" for="Rental">Rental</label>
                            </div>
                            <div class="whitespace-nowrap">
                                <input type="radio" name="Use_of_Machinery" id="Private" value="Private">
                                <label class="text-gray-400" for="Private">Private</label>
                            </div>
                        </div>

                        <div class="w-full flex flex-col sm:flex-row items-center justify-start gap-3 my-2">
                            <input class="bg-[#679f69] py-1 px-2 text-white font-bold cursor-pointer" type="submit" value="Add Machinery">
                        </div>
                    </div>
                </form>
            </section>
        </section>
    </section>
</x-app>