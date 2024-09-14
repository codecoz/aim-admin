<label class="form-label" for="{{ $field->getName() }}">{{ $field->getLabel() }}  @if($field->isRequired())
        <span class="required text-red">*</span>
    @endif</label>
<input {{ $field->getAttributesAsHtml() }} class="form-control  {{ $field->getCssClass() }}"
       id="{{ $field->getName() }}" name="{{ $field->getName() }}"
       type="date" placeholder="{{ $field->getPlaceholder('placeholder')}}"
       value="{{ old($field->getName(),$field->getFormattedValue()) }}"
       @if($field->isDisabled()) disabled @endif @if($field->isREadonly()) readonly @endif
/>
@if($field->getHelp())
    <span class="text-xs">{!! $field->getHelp() !!}</span>
@endif

<x-aim-admin::alert.inline-validation-error :errors="$errors->get($field->getName())" class="mt-1"/>

