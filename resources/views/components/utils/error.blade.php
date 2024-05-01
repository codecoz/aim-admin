@props(['messages'])

@if ($messages)
    <div class="alert alert-danger alert-dismissible d-flex align-items-center" role="alert">
        <i class="fa fa-home me-2"></i>
        <div>
            @foreach ((array) $messages as $message)
                {{ $message }} <button class="btn-close" type="button" data-bs-dismiss="alert"
                    aria-label="Close"></button>
            @endforeach
        </div>
    </div>
@endif
