<x-app>
    <x-slot:title>
        Admin | Farmer
    </x-slot:title>

    <x-admin.sidebar type="personnel"/>


    <section class="w-full min-h-screen p-5 overflow-y-auto">
        <x-admin.titleCard title="Personnel Details" slogan="Personnel refers to the employees or workforce of an organization, encompassing all individuals who contribute to its operations, from entry-level staff to top executives." />
        <div class="flex flex-col w-full">
            <table class="flex flex-col overflow-x-auto min-w-[800px] md:max-w-full shadow-md border border-2 rounded">
                <tr class="grid grid-cols-1 py-2 bg-green-700 text-white w-full">
                    <th class="w-full px-3 grid grid-cols-2 relative  py-2">
                        <div class="flex items-center gap-3 cursor-pointer">
                            <img src="{{asset('images/icons/plus.png')}}" class="hover:bg-green-200 w-[25px] h-[25px] border bg-slate-100 rounded-full p-1" alt=""> Add Personnel
                        </div>
                        <form action="{{route('admin.personnel')}}" method="GET" class="w-full">
                            <input name="search" class="px-3 py-1 font-normal bg-slate-100 rounded outline-0 text-ms text-slate-800 w-full" placeholder="Search..." type="text">
                        </form>
                    </th>
                    <th class="grid grid-cols-6">
                        <div>Name</div>
                        <div>Gender</div>
                        <div>Email</div>
                        <div>Role</div>
                        <div>Status</div>
                        <div>Operation</div>
                    </th>
                </tr>
                @foreach ($users as $user)
                    
                <tr class="grid py-1 odd:bg-slate-200 grid-cols-6 w-full">
                    <td class="break-all">{{$user->name}}</td>
                    <td class="break-all">lorem</td>
                    <td class="break-all">{{$user->email}}</td>
                    <td class="break-all">{{$user->role_as  ? 'admin' : 'personnel'}}</td>
                    <td class="{{$user->is_actived ? 'break all text-green-500 font-semibold' : 'break all text-red-500 font-semibold'}}">{{$user->is_actived ? 'activate' : 'deactivate'}}</td>
                    <td class="grid grid-cols-3 gap-2">
                        <img class="max-w-[34px] p-1 hover:bg-green-300/50 rounded-full" src="{{asset($user->is_actived ? 'images/icons/unlock.png' : 'images/icons/padlock.png')}}" alt="">
                        <div><img class="max-w-[34px] p-1 hover:bg-green-300/50 rounded-full" src="{{asset('images/icons/update.png')}}" alt=""></div>
                        <div><img class="max-w-[34px] p-1 hover:bg-green-300/50 rounded-full" src="{{asset('images/icons/delete.png')}}" alt=""></div>
                    </td>
                </tr>
                @endforeach
                @if($userCount!=0)
                <tr class="bg-green-500 gap-2 py-1 w-full flex items-center justify-center text-white font-bold">
                    @for ($count = 0; $count < $userCount; $count += 10)
                        <td class="hover:bg-slate-200 hover:text-black rounded px-2 py-1">
                            <a href="/admin/personnel?skip={{$count}}&&search={{$search}}">
                                <p>{{ $count + 10}}</p>
                            </a>
                        </td>
                    @endfor
                </tr>
                @else
                    <tr class="flex items-center justify-center">
                        <td class="flex items-center justify-center flex-col p-3 mt-5">
                            <img src="{{asset('images/man.png')}}" class="h-[5rem] h-[5rem]" alt="">
                            <p class="font-bold mt-3 text-xl -translate-x-2">No Data</p>
                        </td>
                    </tr>
                @endIf
            </table>
        </div>
    </section>
</x-app>

<script>
    const users = document.getElementById()
</script>