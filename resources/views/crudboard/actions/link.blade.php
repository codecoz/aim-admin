<a class="{{ $action->getCssClass() }}"
   @if($action->getRouteName())
       href="{{ route($action->getRouteName(),  $routeParams) }}"
   @else
       href="#"
    @endif
    {!! $htmlAttributes !!}>
    @if ($action->getIcon())
        <i class="fas {{ $action->getIcon() }}"></i>
    @endif
    {{ $action->getLabel() }}
</a>


