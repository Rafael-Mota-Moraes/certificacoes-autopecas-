@props(['action', 'method' => 'POST'])

<form action="{{ $action }}" method="{{ $method === 'GET' ? 'GET' : 'POST' }}" {{ $attributes }}>

    @if ($method !== 'GET')
        @csrf
    @endif

    @if (isset($spoofMethod))
        @method($spoofMethod)
    @endif

    {{ $slot }}

</form>
