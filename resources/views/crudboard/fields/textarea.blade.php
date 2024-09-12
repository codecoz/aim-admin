<label class="form-label" for="{{ $field->getName() }}"> {{ $field->getLabel() }}  @if($field->isRequired())
        <span class="required text-red">*</span>
    @endif</label>
<textarea class="form-control {{ $field->getCssClass() }}" name="{{ $field->getName() }}"
          rows="{{ $field->getCustomOption('rows')}}" placeholder="{{ $field->getPlaceholder() }}"
          {!! $htmlAttributes !!} @if($field->isDisabled()) disabled @endif @if($field->isReadonly()) readonly
          @endif  @if($field->isRequired()) required @endif >{{ old($field->getName(),$field->getValue()) }}</textarea>
@if($field->getHelp())
    <span class="text-xs">{!! $field->getHelp() !!}</span>
@endif

<x-aim-admin::alert.inline-validation-error :errors="$errors->get($field->getName())" class="mt-1"/>
