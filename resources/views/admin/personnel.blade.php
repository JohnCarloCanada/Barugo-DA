<x-app>
    <x-slot:title>
        Admin | Farmer
    </x-slot:title>

    <x-admin.sidebar type="personnel"/>


    <section class="w-full min-h-screen p-5 overflow-y-auto">
        <x-admin.titleCard title="Personnel Details" slogan="Personnel refers to the employees or workforce of an organization, encompassing all individuals who contribute to its operations, from entry-level staff to top executives." />
        <div class="flex flex-col w-full">
            <table class="flex flex-col overflow-x-auto min-w-[800px] md:max-w-full shadow-md border-2 rounded">
                <tr class="grid grid-cols-1 py-2 bg-green-700 text-white w-full">
                    <th class="w-full px-3 grid grid-cols-2 relative  py-2">
                        <div  onclick="showPersonnelForm()" class="flex cursor-pointer w-fit items-center gap-3">
                            <img src="{{asset('images/icons/plus.png')}}" class="hover:bg-green-200 w-[25px] h-[25px] border bg-slate-100 rounded-full p-1" alt=""> Add Personnel
                        </div>
                        <form action="{{route('personnel.index')}}" method="GET" class="w-full">
                            <input name="search" class="px-3 py-1 font-normal bg-slate-100 rounded outline-0 text-ms text-slate-800 w-full" placeholder="Search..." type="text" value="{{$search}}">
                        </form>
                    </th>
                    <th class="grid grid-cols-6">
                        <div>Employee ID</div>
                        <div>Last Name</div>
                        <div>Gender</div>
                        <div>Role</div>
                        <div>Status</div>
                        <div>Operation</div>
                    </th>
                </tr>
                @foreach ($users as $user)
                    
                <tr class="grid py-1 odd:bg-slate-200 grid-cols-6 w-full text-center">
                    <td class="break-all">{{$user->employee_id}}</td>
                    <td class="break-all">{{$user->last_name}}</td>
                    <td class="break-all">{{ucwords($user->userdetails->gender)}}</td>
                    <td class="break-all">{{$user->userdetails->user_role == 'Admin'  ? 'Admin' : 'Personnel'}}</td>
                    <td class="{{$user->is_actived ? 'break all text-green-500 font-semibold' : 'break all text-red-500 font-semibold'}}">{{$user->userdetails->is_actived ? 'Activate' : 'Deactivate'}}</td>
                    <td class="grid grid-cols-3 gap-2">
                        <form method="POST" action="{{ route('personnel.update', ['personnel' => $user]) }}">
                            @csrf
                            @method('PUT')
                            <button type="submit">
                                <img class="max-w-[34px] p-1 hover:bg-green-300/50 rounded-full" src="{{asset($user->userdetails->is_actived ? 'images/icons/unlock.png' : 'images/icons/padlock.png')}}" alt="">
                            </button>
                        </form>
                        
                        <img onclick="showPersonnelEditForm({{$user}})" class="max-w-[34px] cursor-pointer p-1 hover:bg-green-300/50 rounded-full" src="{{asset('images/icons/update.png')}}" alt="">

                        <form method="POST" action="{{ route('personnel.destroy', ['personnel' => $user]) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit">
                                <img class="max-w-[34px] p-1 hover:bg-green-300/50 rounded-full" src="{{asset('images/icons/delete.png')}}" alt="">
                            </button>
                        </form>
                            
                    </td>
                </tr>
                @endforeach
                @if($userCount != 0)
                <tr class="bg-green-500 gap-2 overflow-x-auto py-1 w-full flex px-3 items-center text-white font-bold">
                    @if($userCount > 10)
                        @for ($count = 0, $counter = 1; $count <= $userCount; $count += 10, $counter++)
                            <td class="hover:bg-slate-200 hover:text-black  rounded px-2 py-1">
                                <a href="/admin/personnel?skip={{ $count }}&&search={{ $search }}">
                                    <p>{{ $counter }}</p>
                                </a>
                            </td>
                        @endfor
                        @else
                            <td class="hover:bg-slate-200 hover:text-black  rounded px-2 py-1">
                                <a href="/admin/personnel?skip=0&&search={{ $search }}">
                                    <p>1</p>
                                </a>
                            </td>
                    @endIf
                </tr>
                @else
                    <tr class="flex items-center justify-center">
                        <td class="flex items-center justify-center flex-col p-3 mt-5">
                            <img src="{{asset('images/man.png')}}" class="h-[5rem]" alt="">
                            <p class="font-bold mt-3 text-xl -translate-x-2">No Data</p>
                        </td>
                    </tr>
                @endIf
            </table>
        </div>
    </section>
</x-app>


<div id="personnelForm" class="hidden" >
    
    <div class="h-screen w-screen bg-gray-500/50 fixed top-0 left-0 z-2 flex items-center justify-center">
        <form method="POST" action="{{ route('personnel.store') }}" class="p-3 w-full gap-2 text-gray-700 grid md:w-2/4 rounded shadow-md bg-white">
            @csrf
            <div class="text-[20px] font-semibold w-full flex items-center justify-between px-3 my-2">
                <p>CREATE PERSONNEL</p>
                <img onclick="showPersonnelForm()" src="{{asset('images/close.png')}}" class="w-[16px] h-[16px] cursor-pointer" alt="close">
            </div>
            <div class="w-full px-3 flex flex-col gap-1">
                <label for="employee_id" class="text-[12px] font-semibold">Employee ID</label>
                <input type="text" name="employee_id" placeholder="Enter Employee ID..." class="w-full border outline-0 px-2 py-1 shadow-md bg-gray-100">
            </div>
            <div class="w-full px-3 flex flex-col gap-1">
                <label for="last_name" class="text-[12px] font-semibold">Last Name</label>
                <input type="text" name="last_name" placeholder="Enter Last Name..." class="w-full border outline-0 px-2 py-1 shadow-md bg-gray-100">
            </div>
            <div  class="w-full px-3 flex flex-col gap-1">
                <label for="first_name" class="text-[12px] font-semibold">First Name</label>
                <input type="text" name="first_name"  placeholder="Enter First Name..." class="w-full border outline-0 px-2 py-1 shadow-md bg-gray-100">
            </div>
            <div  class="w-full px-3 flex flex-col gap-1">
                <label for="middle_name" class="text-[12px] font-semibold">Middle Name</label>
                <input type="text" name="middle_name"  placeholder="Enter Middle Name..." class="w-full border outline-0 px-2 py-1 shadow-md bg-gray-100">
            </div>
            <div class="w-full px-3 flex flex-col gap-1">
                <label for="gender" class="text-[12px] font-semibold">Gender</label>
                <select name="gender" class="w-full border text-gray-700 outline-0 px-2 py-1 shadow-md bg-gray-100">
                    <option value="female">Female</option>
                    <option value="male">Male</option>
                </select>
            </div>
            <div class="w-full px-3 flex flex-col gap-1">
                <label for="password" class="text-[12px] font-semibold">Password</label>
                <input type="password" name="password"  placeholder="Enter Password..." class="w-full border outline-0 px-2 py-1 shadow-md bg-gray-100">
            </div>
            <div class="px-3">
                <button type="submit" class="py-2 w-full mt-3 text-white hover:bg-green-500 rounded font-bold bg-green-700">
                    ADD PERSONNEL
                </button>
            </div>
        </form>
    </div>

</div>

<div id="personnelEditForm" class="hidden" >
    <div class="h-screen w-screen bg-gray-500/50 fixed top-0 left-0 z-2 flex items-center justify-center">
        <form method="POST" id="editFormInputValue" action="{{ route('personnel.edit'); }}" class="p-3 w-full gap-2 text-gray-700 grid md:w-2/4 rounded shadow-md bg-white">
            @csrf
            @method('PUT')
            <div class="text-[20px] font-semibold w-full flex items-center justify-between px-3 my-2">
                <p>UPDATE PERSONNEL</p>
                <img onclick="showPersonnelEditForm('')" src="{{asset('images/close.png')}}" class="w-[16px] h-[16px] cursor-pointer" alt="close">
            </div>
            <input type="text" name="id" id="" class="hidden">
            <div class="w-full px-3 flex flex-col gap-1">
                <label for="employee_id" class="text-[12px] font-semibold">Employee ID</label>
                <input type="text" name="employee_id" placeholder="Enter Employee ID..." class="w-full border outline-0 px-2 py-1 shadow-md bg-gray-100">
            </div>
            <div class="w-full px-3 flex flex-col gap-1">
                <label for="last_name" class="text-[12px] font-semibold">Last Name</label>
                <input type="text" name="last_name" placeholder="Enter Last Name..." class="w-full border outline-0 px-2 py-1 shadow-md bg-gray-100">
            </div>
            <div  class="w-full px-3 flex flex-col gap-1">
                <label for="first_name" class="text-[12px] font-semibold">First Name</label>
                <input type="text" name="first_name"  placeholder="Enter First Name..." class="w-full border outline-0 px-2 py-1 shadow-md bg-gray-100">
            </div>
            <div  class="w-full px-3 flex flex-col gap-1">
                <label for="middle_name" class="text-[12px] font-semibold">Middle Name</label>
                <input type="text" name="middle_name"  placeholder="Enter Middle Name..." class="w-full border outline-0 px-2 py-1 shadow-md bg-gray-100">
            </div>
            <div class="w-full px-3 flex flex-col gap-1">
                <label for="gender" class="text-[12px] font-semibold">Gender</label>
                <select name="gender" class="w-full border text-gray-700 outline-0 px-2 py-1 shadow-md bg-gray-100">
                    <option value="female">Female</option>
                    <option value="male">Male</option>
                </select>
            </div>
            <div class="w-full px-3 flex flex-col gap-1">
                <label for="password" class="text-[12px] font-semibold">Password</label>
                <input type="password" name="password"  placeholder="Enter Password..." class="w-full border outline-0 px-2 py-1 shadow-md bg-gray-100">
            </div>
            <div class="px-3">
                <button type="submit" class="py-2 w-full mt-3 text-white hover:bg-green-500 rounded font-bold bg-green-700">
                    UPDATE PERSONNEL
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    const personnelForm = document.getElementById('personnelForm')
    const personnelEditForm = document.getElementById('personnelEditForm')
    const form = document.getElementById('editFormInputValue');


    const showPersonnelForm=()=>{
        if(personnelForm){
            if(personnelForm.classList == 'hidden') personnelForm.classList.remove("hidden")
            else personnelForm.classList.add("hidden")
        }   
    }

    const showPersonnelEditForm=(user)=>{
        if(personnelEditForm) {
            if(personnelEditForm.classList == 'hidden') { 
                personnelEditForm.classList.remove("hidden")
                if (form && user) {
                    console.log(form.attributes.action);
                    form.id.value = user.id;
                    form.employee_id.value = user.employee_id;
                    form.last_name.value = user.last_name;
                    form.first_name.value = user.first_name;
                    form.middle_name.value = user.middle_name;
                    form.gender.value = user.userdetails.gender;
                    form.password.value = user.userdetails.password;
                }
            }
            else personnelEditForm.classList.add("hidden")
        }
    }


</script>