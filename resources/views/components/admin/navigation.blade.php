@props(['type'])

<ul class="mt-3 sm:mt-0 flex flex-col items-center sm:flex-row gap-y-3 sm:gap-y-2 gap-x-0 sm:gap-x-6">
    <li>
        <a class="font-bold text-base hover:text-green-600 {{$type == 'index' ? 'text-green-600' : 'text-white'}}" href="{{route('adminPersonalInformation.index')}}">Approved Farmers</a>
    </li>
    <li>
        <a class="font-bold text-base hover:text-green-600 {{$type == 'approval' ? 'text-green-600' : 'text-white'}}" href="{{route('adminPersonalInformation.needApproval')}}">Needs Approval</a>
    </li>
    <li>
        <a class="font-bold text-base hover:text-green-600" href="">Updates</a>
    </li>
</ul>