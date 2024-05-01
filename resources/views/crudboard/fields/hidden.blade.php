<input type="hidden"  id="{{ $field->getName() }}" 
 class="{{ $field->getCssClass() }}"  name="{{ $field->getName() }}"
 value="{{ old($field->getName(),$field->getValue()) }}" />