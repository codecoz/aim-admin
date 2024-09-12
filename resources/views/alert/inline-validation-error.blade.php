@props(['errors'])
@if(config('aim-admin.inline_validation_error', true))
    @if (!empty($errors))
        @foreach ($errors as $error)
            <span class="text-xs" style="color: red; !important;">{!!  $error !!}</span>
        @endforeach
    @endisset
@endif
