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
            <section class="mb-3">
                @if ($errors->any())
                    <ul class="grid grid-cols-2 sm:grid-cols-4 gap-1 mb-3">
                        @foreach ($errors->all() as $error )
                            <li class="text-sm sm:text-base text-red-800 font-bold">{{$error}}</li>
                        @endforeach
                    </ul>
                    @endif

                    @isset($errorMessage)
                        <div id="message" class="text-sm sm:text-base text-red-800 font-bold">
                            {{$errorMessage}}
                        </div>
                    @endisset
                <form class="flex flex-col gap-y-3 sm:flex-row sm:gap-y-0 sm:gap-x-2" action="{{route('activityLogs.filter')}}" method="get">
                    @csrf
                    @method('get')

                    <div>
                        <label class="bg-[#679f69] px-3 py-1 font-bold text-white rounded-sm" for="Start_Date">Start Date: </label>
                        <input class="bg-[#e8e8e8] px-3 py-1 text-gray-400" type="date" id="Start_Date" name="Start_Date" >
                    </div>
                    <div>
                        <label class="bg-[#679f69] px-3 py-1 font-bold text-white rounded-sm" for="End_Date">End Date: </label>
                        <input class="bg-[#e8e8e8] px-3 py-1 text-gray-400" type="date" id="End_Date" name="End_Date" >
                    </div>
                    <div>
                        <input class="bg-[#679f69] hover:bg-[#8f948f] py-1 px-2 text-white font-bold cursor-pointer" type="submit" value="Filter Logs">
                    </div>
                </form>
            </section>
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


<script>
    setTimeout(function() {
        document.getElementById('message').remove();
    }, 5000); // Remove after 5 seconds (5000 milliseconds)

</script>