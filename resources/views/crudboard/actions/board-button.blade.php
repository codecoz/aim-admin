<a class="btn btn-primary  {{$crudAction->getCssClass() }}" href="{{ route($crudAction->getRouteName(), $crudAction->getRouteParameters()) }}"
{{ $htmlAttributes }}>
    @if ($crudAction->getIcon())
    <i class="fas {{ $crudAction->getIcon() }}"></i>
    @endif
    {{ $crudAction->getLabel() }}
</a>