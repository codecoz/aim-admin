<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-search"> </i>
            @if($filter->getTitle())
                {{ $filter->getTitle() }}
            @else
                Search
            @endif
        </h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <form method="get" name='filter'>
            <div class="row">
                @foreach($filter->getFields() as $field)
                    @php $htmlAttributes = $field->getAttributesAsHtml() ; @endphp
                    <div class="form-group {{ $field->getLayoutClass() }}">
                        <x-dynamic-component :component="$field->getComponent()" :$field :$htmlAttributes/>
                    </div>
                @endforeach
            </div>
            <div class="flex">
                <button type="submit" class="btn btn-success float-right">
                    <i class="fas fa-search"> </i> Search
                </button>
            </div>
            <a href="" class="btn btn-secondary"> Reset</a>
        </form>
    </div>
</div>
