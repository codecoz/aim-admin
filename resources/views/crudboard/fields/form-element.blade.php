
@php
   $attributes = "";
@endphp

@switch($field->getHtmlElement())
    @case("input")
        <input class="form-control  {{$field->getCssClass()}}" id="{{ $field->getName() }} "  name="{{ $field->getName() }} " 
        type="{{ $field->getHtmlAttributes()->get('type','text')}}" placeholder="{{$field->getHtmlAttributes()->get('placeholder')}}"  />
        @break;

