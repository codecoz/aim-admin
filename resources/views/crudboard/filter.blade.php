<div class="card search-bar collapsed-card">
    <div class="card-header" data-card-widget="collapse" style="cursor: pointer;">
        <h3 class="card-title"><i class="fas fa-search"> </i>
            @if($filter->getTitle())
                {{ $filter->getTitle() }}
            @else
                Search
            @endif
        </h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-plus"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <form method="get" name='filter'>
            <div class="row">
                @php $collapseFlag = false; @endphp
                @foreach($filter->getFields() as $field)
                    @php
                        $htmlAttributes = $field->getAttributesAsHtml();
                        if($field->getValue()){$collapseFlag = true;}
                    @endphp
                    <div class="form-group {{ $field->getLayoutClass() }}">
                        <x-dynamic-component :component="$field->getComponent()" :$field :$htmlAttributes/>
                    </div>
                @endforeach
            </div>
            <div class="flex">
            @foreach($filter->getActions()->getFilterActions() as $action)
                        @if($action->shouldBeDisplayedFor(null))
                            @php $htmlActionAttributes = $action->getAttributesAsHtml() ; @endphp
                            <x-dynamic-component :component="$action->getComponent()" :$action :$htmlActionAttributes/>
                        @endif
            @endforeach
            </div>
        </form>
    </div>
</div>

@push('scripts')
    <script type="module">
        $(document).ready(function() {
            @if($collapseFlag) $('.search-bar').removeClass('collapsed-card'); @endif
        });
    </script>
@endpush
