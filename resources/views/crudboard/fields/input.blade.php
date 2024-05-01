    
    <label class="form-label" for="{{ $field->getName() }}">{{ $field->getLabel() }}  @if($field->isRequired()) <span class="required">*</span> @endif </label>
    <input  class="form-control  {{ $field->getCssClass() }}"  name="{{ $field->getName() }}" 
    type="{{ $field->getInputType() }}" placeholder="{{ $field->getPlaceholder() }}"  value="{{ old($field->getName(),$field->getValue()) }}"
    {{ $htmlAttributes }} @if($field->isDisabled()) disabled @endif @if($field->isReadonly()) readonly @endif  @if($field->isRequired()) required @endif 
    />