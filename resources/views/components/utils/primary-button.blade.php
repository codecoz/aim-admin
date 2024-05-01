<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn-block btn-success']) }}>
    {{ $slot }}
</button>
