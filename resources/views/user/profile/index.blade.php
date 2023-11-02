<x-app>
    <x-slot:title>
        Employee | Profile
    </x-slot:title>

    <x-sidebar type="Profile"/>

    <section class="w-full min-h-screen flex items-center justify-center bg-green-700">
        <section class="w-[min(900px,100%)] bg-white rounded-md mx-3 sm:mx-2 p-2 sm:p-3">
            <div class="flex flex-col justify-center items-start sm:items-center">
                <h2 class="text-2xl sm:text-3xl font-bold text-slate-600">Profile Information</h2>
                <p class="text-xs sm:text-base font-normal text-slate-600">Update your account's profile information.</p>
            </div>
            <form class="w-full mt-10" method="post" action="{{route('userProfile.update')}}">
                @csrf
                @method('patch')

                <div class="mt-4 sm:mt-5 flex flex-col items-start gap-1 sm:gap-2">
                    <label for="first_name" class=" font-semibold text-slate-600 text-sm">First Name</label>
                    <input required class="bg-gray-300 w-[min(350px,100%)] py-1 px-3 rounded-md valid:bg-slate-300" placeholder="Enter first name" type="text" name="first_name" id="first_name">
                </div>

                <div class="mt-4 sm:mt-5 flex flex-col items-start gap-1 sm:gap-2">
                    <label for="middle_name" class=" font-semibold text-slate-600 text-sm">Middle Name</label>
                    <input class="bg-gray-300 w-[min(350px,100%)] py-1 px-3 rounded-md valid:bg-slate-300" placeholder="Enter midddle name" type="text" name="middle_name" id="middle_name">
                </div>

                <div class="mt-4 sm:mt-5 flex flex-col items-start gap-1 sm:gap-2">
                    <label for="last_name" class=" font-semibold text-slate-600 text-sm">Last Name</label>
                    <input required class="bg-gray-300 w-[min(350px,100%)] py-1 px-3 rounded-md valid:bg-slate-300" placeholder="Enter last name" type="text" name="last_name" id="last_name">
                </div>

                <div class="mt-2 sm:mt-5">
                    <input class="bg-black hover:bg-slate-600 duration-300 text-white font-bold px-5 py-2 rounded-md cursor-pointer" type="submit" value="Save">
                </div>
            </form>
        </section>
    </section>

</x-app>

