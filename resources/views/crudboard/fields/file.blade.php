<label class="form-label" for="{{ $field->getName() }}">{{ $field->getLabel() }}  @if($field->isRequired())
        <span class="required text-red">*</span>
    @endif</label>
<input id="{{ $field->getName() }}" name="{{ $field->getName() }}" class="form-control" type="file"
       value="{{ old($field->getName(),$field->getValue()) }}"
    @required($field->isRequired()) {!! $htmlAttributes !!}  @disabled($field->isDisabled())  @readonly($field->isReadonly()) />
@if($field->getHelp())
    <span class="text-xs">{!! $field->getHelp() !!}</span>
@endif

<x-aim-admin::alert.inline-validation-error :errors="$errors->get($field->getName())" class="mt-1"/>
