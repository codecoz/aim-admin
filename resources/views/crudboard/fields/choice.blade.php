    <label class="form-label" for="{{ $field->getName() }}">{{ $field->getLabel() }}  @if($field->isRequired()) <span class="required">*</span> @endif</label>
    @switch($field->getInputType())
        @case("radio")
        @case("checkbox")
             @foreach ($field->getCustomOption('choiceList') as $key=>$value)
             <label class="form-check form-check-inline">
                <input  {{ $field->getAttributesAsHtml() }} class="form-check-input {{ $field->getCssClass() }}" type="{{ $field->getInputType() }}" name="{{ $field->getName() }}" value="{{ $key }}"
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
                 @if($field->isDisabled()) disabled @endif
                 @if($field->isReadonly()) readonly @endif
                >
                <span class="form-check-label">{{ $value }}</span>
			</label>
            @endforeach
        @break
        @default
            <select {{ $field->getAttributesAsHtml() }} class="form-control {{ $field->getCssClass() }}" name="{{ $field->getName() }}" id="{{ $field->getName() }}"
            @if($field->isDisabled()) disabled @endif @if($field->isReadonly()) readonly @endif
            @if($field->isRequired()) required @endif
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
