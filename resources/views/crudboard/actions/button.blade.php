@if($action->isSubmitAction())
    <button class="btn btn-primary  {{ $action->getCssClass() }}" type="submit"
            value="{{$action->getValue()}}" {{ $htmlActionAttributes }} >{{ $action->getLabel() }}</button>
@else
    <a href="{{ route($action->getRouteName(),$action->getRouteParameters()) }}"
       class="btn {{$action->getCssClass() }}" {{$htmlActionAttributes}}> {{$action->getLabel() }}</a>
@endif
