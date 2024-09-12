<label class="form-label" for="{{ $field->getName() }}"> {{ $field->getLabel() }}  @if($field->isRequired())
        <span class="required text-red">*</span>
    @endif</label>
<div class="{{$field->getCssClass()}}" {!! $htmlAttributes !!}>
    @foreach ( $field->getCustomOption('fields') as $key=>$childField)
        @php
            $htmlAttributes = $childField->getAttributesAsHtml() ;
        @endphp
        <div class="form-group {{$childField->getLayoutClass() }}">
            <x-dynamic-component :component="$childField->getComponent()" :field="$childField" :$htmlAttributes/>
        </div>
    @endforeach
</div>
@if($field->getHelp())
    <span class="text-xs">{!! $field->getHelp() !!}</span>
@endif

<x-aim-admin::alert.inline-validation-error :errors="$errors->get($field->getName())" class="mt-1"/>

