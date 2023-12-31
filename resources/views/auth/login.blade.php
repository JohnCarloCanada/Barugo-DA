<x-guest>
    <x-slot:title>
        Barugo | Login
    </x-slot:title>


    <section class="w-full min-h-screen bg-gradient-to-r from-[#81b277] to-[#dfedb7] flex items-center justify-center py-10 relative">
        @if (session('status'))
        <div class="absolute z-20 top-3 sm:top-10 bg-red-500 px-3 py-2 rounded-sm">
            <p class="text-white font-bold text-xl sm:text-2xl">{{ session('status') }}</p>
        </div>
        @endif
        <section class="w-[min(100%,900px)] custom-bg bg-overlay before:z-10 rounded-3xl mx-5 lg:mx-0 flex flex-col items-center justify-center sm:flex-row">
            <section class="w-full flex flex-col items-center justify-center px-5 py-5 sm:py-5 z-[20]">
                <img src="{{ asset('images/icons/DA-logo.png') }}" class="w-24 h-24 mb-5" alt="">
                <form class="w-full sm:w-[80%]" action="{{route('login.store')}}" method="POST">
                    @csrf

                    <h2 class="font-bold text-3xl sm:text-4xl mb-5 text-white">Login</h2>

                    <div class="my-1">
                        <x-input-error :messages="$errors->get('employee_id')" class="my-1 text-xs w-fit px-2 py-1 rounded bg-red-500 text-white" />
                        <label class="sr-only" for="employee_id">Employee ID</label>
                        <input class="p-2 rounded-md w-full outline-0 font-semibold text-slate-700"  type="text" name="employee_id" id="employee_id" placeholder="Enter Employee ID" value="{{ old('employee_id')}}">
                    </div>

                    <div class="my-2">
                        <x-input-error :messages="$errors->get('password')" class="my-1 text-xs w-fit px-2 py-1 rounded bg-red-500 text-white" />
                        <label class="sr-only" for="password">Password</label>
                        <input class="p-2 rounded-md w-full outline-0 font-semibold" type="password" name="password" id="password" placeholder="Enter Password" value="{{ old('password')}}">
                    </div>

                    <div class="block mt-1 mb-2">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
                            <span class="ml-2 text-sm font-semibold text-slate-700">{{ __('Remember me') }}</span>
                        </label>
                    </div>

                    <div class="w-full flex items-center justify-center sm:justify-start">
                        <input aria-label="Login" class="px-8 py-1 bg-[#fbad1b] rounded text-white font-bold cursor-pointer" type="submit" value="Login">
                    </div>
                </form>
            </section>
            <section class="w-full h-full mt-10 sm:mt-0 sm:self-end z-[20]">
                <h2 class="font-bold text-white text-3xl sm:text-4xl text-center sm:text-end p-5">Farmers Management Platform</h2>
            </section>
        </section>

    </section>
</x-guest>