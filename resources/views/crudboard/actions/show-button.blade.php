<a href="{{route($action->getRouteName(),$action->getRouteParameters())}}" class="btn {{$action->getCssClass() }}" {{ $htmlActionAttributes }}>
    @if($action->getIcon())
    <i class="fas {{$action->getIcon()}}"> </i>
    @endif
    {{$action->getLabel() }}
</a>