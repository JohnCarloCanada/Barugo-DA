@php
    $name = '';
    $initial = '';
    if($area->Tenant_Name == 'None') {
        if($area->personalinformation->Middle_Name) {
            $initial = Str::upper(Str::substr($area->personalinformation->Middle_Name, 0, 1)) . '.';
            $name = $area->personalinformation->First_Name . " " . $initial . " " . $area->personalinformation->Last_Name;
        } else {
            $name = $area->personalinformation->First_Name . " " . $area->personalinformation->Surname;
        }
    } else {
        $name = $area->Tenant_Name;
    }
@endphp


<x-app>
    <x-slot:title>
        Admin | Seed Distribution
    </x-slot:title>

    <x-admin.sidebar type="seed distributions"/>

    <section class="w-full min-h-screen bg-green-700 p-5 overflow-y-auto">
        <section class="flex flex-col my-2 items-center justify-center gap-y-6">
            <h2 class="text-2xl sm:text-4xl mx-2 font-bold text-white">Seed Claimer</h2>
        </section>
        @if ($issuanceExist)
            <section class="w-full flex flex-col justify-center items-center gap-3 mx-auto bg-white rounded-lg">
                <a href="{{route('adminSeedDistribution.index')}}" class="text-xl font-semibold w-full flex items-center justify-between px-3 my-2">
                    <p>Seed Claimer</p>
                    <img src="{{asset('images/close.png')}}" class="w-[16px] h-[16px] cursor-pointer" alt="close">
                </a>
    
                <h2 class="check-claimer-card-style">RSBSA No.: <span>{{$area->personalinformation->RSBSA_No}}</span></h2>
                <h2 class="check-claimer-card-style">Lot No.: <span>{{$area->Lot_No}}</span></h2>
                <h2 class="check-claimer-card-style">Name: <span>{{$name}}</span></h2>
                <h2 class="check-claimer-card-style">Seed Name: <span>{{$area->seedissuancehistory->Seed_Variety}}</span></h2>
                <h2 class="check-claimer-card-style">Seed Quantity: <span>{{$area->seedissuancehistory->Quantity}}</span></h2>
                <h2 class="check-claimer-card-style">Issuance Date: <span>{{$area->seedissuancehistory->created_at}}</span></h2>
            </section>

        @else 
            <section class="w-full flex flex-col justify-center items-center gap-3 mx-auto bg-white rounded-lg">
                <a href="{{route('userSeedDistribution.index')}}" class="text-xl font-semibold w-full flex items-center justify-between px-3 my-2">
                    <p>Seed Claimer</p>
                    <img onclick="closeClaimer()" src="{{asset('images/close.png')}}" class="w-[16px] h-[16px] cursor-pointer" alt="close">
                </a>

                <h2 class="check-claimer-card-style">It Doesnt Exist!</h2>
            </section>
        @endif
    </section>
</x-app>
