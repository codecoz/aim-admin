<label class="form-label" for="{{ $field->getName() }}">{{ $field->getLabel() }}  @if($field->isRequired())
        <span class="required text-red">*</span>
    @endif</label>
@switch($field->getInputType())
    @case("radio")
    @case("checkbox")
        <div class="form-group clearfix">
            @foreach ($field->getCustomOption('choiceList') as $key=>$value)
                @php  $htmlAttributes = $field->getAttributesAsHtml(); @endphp
                <div class="icheck-danger d-inline">
                    <input {!!  $htmlAttributes !!} class="form-check-input {{ $field->getCssClass() }}"
                           type="{{ $field->getInputType() }}" name="{{ $field->getName() }}" value="{{ $key }}"
                           id="{{$key}}"
                           @if($values = old($field->getName(),$field->getValue()))
                               @php
                                   $values = is_array($values) ? $values : [$values];
                               @endphp
                               @if(in_array($key,$values))
                                   checked
                           @endif
                           @elseif($field->getCustomOption(CodeCoz\AimAdmin\Field\ChoiceField::SELECTED.".".$key) !==null )
                               checked
                        @endif
                        @disabled($field->isDisabled())
                        @readonly($field->isReadonly())
                    >
                    <label for="{{$key}}">
                        {{ $value }}
                    </label>
                </div>
            @endforeach
        </div>
        @break
    @default
        <select {!! $htmlAttributes !!} class="form-control {{ $field->getCssClass() }}" name="{{ $field->getName() }}"
                id="{{ $field->getName() }}"
            @disabled($field->isDisabled())
            @readonly($field->isReadonly())
            @required($field->isRequired())
        >
            @if ($field->getCustomOption(CodeCoz\AimAdmin\Field\ChoiceField::EMPTY))
                <option value="">{{ $field->getCustomOption(CodeCoz\AimAdmin\Field\ChoiceField::EMPTY) }}</option>
            @endif
            @foreach ($field->getCustomOption('choiceList') as $key=>$value)

                <option value="{{ $key }}"
                        @if($values = old($field->getName(),$field->getValue()))
                            @php
                                $values = is_array($values) ? $values : [$values];
                            @endphp
                            @if(in_array($key,$values))
                                selected
                        @endif
                        @elseif($field->getCustomOption(CodeCoz\AimAdmin\Field\ChoiceField::SELECTED.".".$key) !==null )
                            selected
                    @endif
                >{{ $value}}</option>
            @endforeach

        </select>
@endswitch
@if($field->getHelp())
    <span class="text-xs">{!! $field->getHelp() !!}</span>
@endif

<x-aim-admin::alert.inline-validation-error :errors="$errors->get($field->getName())" class="mt-1"/>

