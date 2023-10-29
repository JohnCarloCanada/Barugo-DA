@props(['type', 'notApprovedCount', 'needUpdateFarmersCount'])

<ul class="mt-3 sm:mt-0 flex flex-col items-center sm:flex-row gap-y-3 sm:gap-y-2 gap-x-0 sm:gap-x-6">
    <li class="flex items-center justify-between gap-x-3">
        <a class="font-bold text-base hover:text-green-600 {{$type == 'index' ? 'text-green-600' : 'text-white'}}" href="{{route('adminPersonalInformation.index')}}">Approved Farmers</a>
    </li>
    <li class="flex items-center justify-between gap-x-3">
        <a class="font-bold text-base hover:text-green-600 {{$type == 'approval' ? 'text-green-600' : 'text-white'}}" href="{{route('adminPersonalInformation.needApproval')}}">Needs Approval</a>
        <p class="text-white">{{$notApprovedCount}}</p>
    </li>
    <li class="flex items-center justify-between gap-x-3">
        <a class="font-bold text-base hover:text-green-600 {{$type == 'update' ? 'text-green-600' : 'text-white'}}" href="{{route('adminPersonalInformation.needUpdate')}}">Updates</a>
        <p class="text-white">{{$needUpdateFarmersCount}}</p>
    </li>
</ul>