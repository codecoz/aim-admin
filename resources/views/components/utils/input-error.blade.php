@props(['messages'])
@if ($messages)
    @foreach ((array) $messages as $message)
        <span class="error invalid-feedback">{{ $message }}</span><br>
    @endforeach
@endif
