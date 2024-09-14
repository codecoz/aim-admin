<a class="{{ $action->getCssClass() }}"
   @if($action->getRouteName())
       href="{{ route($action->getRouteName(),  $routeParams) }}"
   @elseif($action->getUrl())
       href="{{$action->getUrl()}}"
   @else
       href="#"
    @endif
    {!! $htmlAttributes !!}>
    @if ($action->getIcon())
        <i class="fas {{ $action->getIcon() }}"></i>
    @endif
    {{ $action->getLabel() }}
</a>


