<div class="btn-group">
        <form method="post" action="{{route($rowAction->getRouteName(), $routeParams) }}"
              onsubmit="return gridDeleteConfirm(this)">
            <button class="{{ $rowAction->getCssClass() }}" type="submit"
                    {!! $htmlAttributes !!}  data-bs-toggle="tooltip" data-bs-placement="top" title="Delete">
                    @if($rowAction->getIcon())  
                        <i class="fas {{$rowAction->getIcon() }}"></i> 
                    @else
                        {{ $rowAction->getName() }}
                    @endif
            </button>
            @csrf
        </form>

</div>
