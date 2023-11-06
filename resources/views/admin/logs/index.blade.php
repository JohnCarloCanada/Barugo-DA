<x-app>
    <x-slot:title>
        Admin | Activity Logs
    </x-slot:title>

    <x-admin.sidebar type="logs"/>

    <section class="w-full min-h-screen overflow-hidden">
        <header class="w-full bg-green-700 px-5 sm:px-6 py-3 sm:py-4">
            <h2 class="font-bold text-white text-4xl sm:text-5xl">Logs</h2>
            <p class="font-semibold text-white mt-1 sm:mt-2 text-xs">Information about the system</p>
        </header>
        <main class="w-full p-3">
            <section class="bg-white flex flex-col gap-y-2 sm:gap-y-3 justify-start h-[calc(100vh-140px)] shadow-2xl overflow-y-scroll">
                @foreach ($logs as $log)
                    <div class="flex flex-col justify-start odd:bg-gray-300 p-2">
                        <p class="text-xs text-gray-500 font-semibold">{{$log->created_at->format('M j, Y g:i A')}}</p>
                        <p class="font-bold text-sm text-black whitespace-nowrap">{{$log->causer->employee_id}} <span class="bg-green-200 text-green-800 font-semibold px-[6px] h-fit text-[8px] md:text-[10px] rounded-md mr-1">{{$log->causer->appaccess->user_role}}</span></p> 
                        <h3 class="text-sm text-black">{{$log->description}}</h3>
                    </div>
                @endforeach
            </section>
        </main>
    </section>
</x-app>