@props(['messages'])

@if ($messages->any())
    {{-- Check if there are any messages --}}
    <div {{ $attributes->merge(['class' => 'alert alert-danger alert-dismissible']) }}>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h5><i class="icon fas fa-ban"></i> Alert!</h5>
        @foreach ($messages->all() as $message)
            {{-- Loop through all messages --}}
            <div>{{ $message }}</div>
        @endforeach
    </div>
@endif
