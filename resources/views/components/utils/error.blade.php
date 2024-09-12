@props(['messages','type' => 'danger'])
@if(session('error'))
    @php
        $messages = session('error');
    @endphp
@elseif ($errors->any() && $errors->get('error'))
    @php
        $messages = $errors->get('error');
    @endphp
@endif
@if($messages)
    @php
        $messages = is_array($messages) ? $messages : [$messages];
    @endphp
    <div class="alert alert-{{ $type }} alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h5><i class="icon fas fa-ban"></i> Alert!</h5>
        @foreach ($messages as $message)
            @if(is_string($message))
                {{ $message }} <br>
            @endif
        @endforeach
    </div>
@endif
