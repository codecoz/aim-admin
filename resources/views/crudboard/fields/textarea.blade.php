<label class="form-label" for="{{ $field->getName() }}"> {{ $field->getLabel() }}  @if($field->isRequired())
        <span class="required">*</span>
    @endif</label>
<textarea class="form-control {{ $field->getCssClass() }}" name="{{ $field->getName() }}"
          rows="{{ $field->getCustomOption('rows')}}" placeholder="{{ $field->getPlaceholder() }}"
          {{ $htmlAttributes }} @if($field->isDisabled()) disabled @endif @if($field->isReadonly()) readonly
          @endif  @if($field->isRequired()) required @endif >{{ old($field->getName(),$field->getValue()) }}</textarea>
