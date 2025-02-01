<!-- Content-->
<div class="content">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">
                @if($show->getTitle())
                    {{ $show->getTitle() }}
                @else
                    {{ $attributes['title']}}
                @endif
            </h5>
        </div>
        <div class="card-body">
            <table class="table table-sm table-bordered mb-2">
                <tbody>
                @foreach($show->getFields() as $field)
                    <tr>
                        <th>{{$field->getLabel()}}</th>
                        <td>
                            @if($component = $field->getComponent())
                                @php
                                    $value = $field->getValue() ;
                                    $record = $show->getRecord();
                                    if($formaterFunc = $field->getFormatValueCallable()){
                                    $value = $formaterFunc($value,$record);
                                    }
                                @endphp
                                <x-dynamic-component :component="$component" :$value :$record/>
                            @else
                                {{$field->getValue()}}
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            @foreach($show->getActions()->getShowActions() as $action)
                @if($action->shouldBeDisplayedFor($show->getRecord()))
                    @php $htmlActionAttributes = $action->getAttributesAsHtml() ; @endphp
                    <x-dynamic-component :component="$action->getComponent()" :$action :$htmlActionAttributes/>
                @endif
            @endforeach
        </div>
    </div>
</div>
