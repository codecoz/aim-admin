<label class="form-label" for="{{ $field->getName() }}">{{ $field->getLabel() }}  @if($field->isRequired())
        <span class="required text-red">*</span>
    @endif </label>
<div class="form-group clearfix">
    <div class="icheck-danger d-inline">
        <input class="form-control  {{ $field->getCssClass() }}" name="{{ $field->getName() }}"
               type="{{ $field->getInputType() }}" placeholder="{{ $field->getPlaceholder() }}"
               value="{{ old($field->getName(),$field->getValue()) }}"
               {!! $htmlAttributes !!} @if($field->isDisabled()) disabled @endif @if($field->isReadonly()) readonly
               @endif  @if($field->isRequired()) required @endif
        />
        <label for="{{ $field->getName() }}">
        </label>
        </br>
    </div>
</div>

@if($field->getHelp())
    <span class="text-xs">{!! $field->getHelp() !!}</span>
@endif

<x-aim-admin::alert.inline-validation-error :errors="$errors->get($field->getName())" class="mt-1"/>


