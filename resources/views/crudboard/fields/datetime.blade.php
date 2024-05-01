<label class="form-label" for="{{ $field->getName() }}">{{ $field->getLabel() }}  @if($field->isRequired()) <span class="required">*</span> @endif</label>
<input {{ $field->getAttributesAsHtml() }} class="form-control  {{ $field->getCssClass() }}" id="{{ $field->getName() }}"  name="{{ $field->getName() }}" 
type="date" placeholder="{{ $field->getPlaceholder('placeholder')}}"  value="{{ old($field->getName(),$field->getFormattedValue()) }}" 
@if($field->isDisabled()) disabled @endif @if($field->isREadonly()) readonly @endif
/> 