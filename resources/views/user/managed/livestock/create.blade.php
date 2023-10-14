<x-app>
    <x-slot:title>
        Add New Livestock
    </x-slot:title>

    <x-sidebar type="managed farmers"/>   

    <section class="w-full min-h-screen p-10">
        <section class="w-[100%,900px] my-0 mx-auto bg-white flex flex-col items-center justify-center ">
            <h2 class="text-black font-bold text-3xl sm:text-4xl">Add New Livestock</h2>

            <section class="w-full mt-3">
                <h3 class="bg-[#679f69] px-3 py-1 font-bold text-white">Livestock</h3>

                <form class="w-full flex flex-col justify-center items-center mt-5 sm:mt-6" action="" method="post">
                    @csrf 

                    <div class="w-[min(100%,300px)] flex items-center sm:items-end justify-center flex-col gap-y-3">
                        <div class="flex flex-col sm:flex-row gap-4">
                            <label class="text-base sm:text-xl font-bold text-[#979797]" for="livestock">Livestocks</label>
                            <select class="bg-green-600 px-5 py-1 rounded-3xl text-white font-bold cursor-pointer" name="livestock" id="livestock">
                                <option value="Carabao">Carabao</option>
                                <option value="Cattle">Cattle</option>
                                <option value="Goat">Goat</option>
                                <option value="Sheep">Sheep</option>
                                <option value="Swine">Swine</option>
                            </select>
                        </div>
    
                        <div class="flex flex-col sm:flex-row gap-4">
                            <label class="text-base sm:text-xl font-bold text-[#979797]" for="sex">Sex</label>
                            <select class="bg-green-600 px-5 py-1 rounded-3xl text-white font-bold cursor-pointer" name="sex" id="sex">
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>

                        <div class="w-full flex flex-col sm:flex-row items-center justify-end gap-3 my-2">
                            <input class="bg-[#679f69] py-1 px-2 text-white font-bold cursor-pointer" type="submit" value="Add Farmer">
                        </div>
                    </div>


                    
                </form>
            </section>
        </section>
    </section>
</x-app>