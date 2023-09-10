<x-guest>
    <x-slot:title>
        Login Barugo
    </x-slot:title>


    <section class="w-full min-h-screen bg-gradient-to-r from-[#81b277] to-[#dfedb7] flex items-center justify-center py-10">

        <section class="w-[min(100%,900px)] custom-bg bg-overlay before:z-10 rounded-3xl mx-5 lg:mx-0 flex flex-col items-center justify-center sm:flex-row">
            <section class="w-full flex flex-col items-center justify-center px-5 py-5 sm:py-5 z-[20]">
                <img src="{{ asset('images/DA-logo.png') }}" class="w-24 h-24 mb-5" alt="">
                <form class="w-full sm:w-[80%]" action="{{route('login.store')}}" method="POST">
                    @csrf

                    <h2 class="font-bold text-3xl sm:text-4xl mb-5 text-white">Login</h2>

                    <div class="mb-5">
                        <x-input-error :messages="$errors->get('email')" class="mt-2 mb-4" />
                        <label class="sr-only" for="email">Email</label>
                        <input class="p-2 rounded-md w-full"  type="email" name="email" id="email" placeholder="Enter Email Address" value="{{ old('email')}}">
                    </div>

                    <div class="mb-1">
                        <x-input-error :messages="$errors->get('password')" class="mt-2 mb-4" />
                        <label class="sr-only" for="password">Password</label>
                        <input class="p-2 rounded-md w-full" type="password" name="password" id="password" placeholder="Enter Password" value="{{ old('password')}}">
                    </div>

                    <div class="block mt-1 mb-2">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
                            <span class="ml-2 text-sm text-black font-semibold">{{ __('Remember me') }}</span>
                        </label>
                    </div>

                    <div class="w-full flex items-center justify-center sm:justify-start">
                        <input class="px-8 py-1 bg-[#fbad1b] text-white font-bold cursor-pointer" type="submit" value="Login">
                    </div>
                </form>
            </section>
            <section class="w-full h-full mt-10 sm:mt-0 sm:self-end z-[20]">
                <h2 class="font-bold text-white text-3xl sm:text-4xl text-center sm:text-end p-5">Farmers Management Platform</h2>
            </section>
        </section>

    </section>
</x-guest>