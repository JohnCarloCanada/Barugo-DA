@props(['messages'])

@if ($messages)
    <ul {{ $attributes->merge(['class' => 'text-[13px] font-bold text-black space-y-1']) }} >
        @foreach ((array) $messages as $message)
            <li>{{ $message }}</li>
        @endforeach
    </ul>
@endif