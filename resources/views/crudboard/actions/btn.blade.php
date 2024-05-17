<button class="{{ $action->getCssClass() }}" {!! $htmlAttributes !!} >
    @if ($action->getIcon())
        <i class="fas {{ $action->getIcon() }}"></i>
    @endif
    {{ $action->getLabel() }}
</button>
