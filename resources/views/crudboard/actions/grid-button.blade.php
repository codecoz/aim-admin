<div class="btn-group">
    @if($rowAction->isGridDeleteAction())
        <form method="post" action="{{route($rowAction->getRouteName(), $routeParams) }}"
              onsubmit="return gridDeleteConfirm(this)">
            <button class="btn  {{ $rowAction->getCssClass() }} btn-sm" type="submit"
                    {{ $htmlAttributes }}  data-bs-toggle="tooltip" data-bs-placement="top" title="Delete">
                <i class="fas {{$rowAction->getIcon() }}"></i>
            </button>
            @csrf
        </form>
    @else
        <a class="btn  {{ $rowAction->getCssClass() }} btn-sm"
           href="{{route($rowAction->getRouteName(), $routeParams) }}" {{ $htmlAttributes }}
           data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $rowAction->getLabel() }}">
            <i class="fas {{$rowAction->getIcon() }}"></i>
        </a>
    @endif
</div>
