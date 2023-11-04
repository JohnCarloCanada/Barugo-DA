@props(['type', 'notApprovedCount', 'needUpdateFarmersCount'])

<select class="text-slate-600 p-2 rounded bg-slate-100 text-sm" onchange="location = this.value;">
    <option value="{{ route('adminPersonalInformation.index') }}" {{$type == 'index' ? 'selected' : ''}}>Approved Farmers</option>
    <option value="{{ route('adminPersonalInformation.needApproval') }}" {{$type == 'approval' ? 'selected' : ''}}>Needs Approval ({{ $notApprovedCount }})</option>
    <option value="{{ route('adminPersonalInformation.needUpdate') }}" {{$type == 'update' ? 'selected' : ''}}>Updates ({{ $needUpdateFarmersCount }})</option>
</select>