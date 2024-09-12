<?php

declare(strict_types=1);

namespace CodeCoz\AimAdmin\Tests\Components;

use CodeCoz\AimAdmin\Field\ChoiceField;
use CodeCoz\AimAdmin\Tests\ComponentTestCase;
use PHPUnit\Framework\Attributes\Test;

class DropDownFieldTest extends ComponentTestCase
{
    private array $options;
    private ChoiceField $component;

    public function __construct(string $name)
    {
        parent::__construct($name);
        $this->options = [
            1 => 'One',
            2 => 'Two',
        ];
        $this->component = ChoiceField::init('type', 'Type', choiceType: 'select', choiceList: $this->options);
    }

    #[Test] public function the_choice_field_component_can_be_rendered()
    {
        $this->assertInstanceOf(ChoiceField::class, $this->component);
    }

    #[Test] public function it_sets_the_required_html_attribute_correctly()
    {
        $component = $this->component->setHtmlAttributes(['required' => true]);
        $this->assertTrue($component->getDto()->getHtmlAttributes()->get('required'));
    }

    #[Test] public function it_sets_the_choice_list_correctly()
    {
        $this->assertEquals($this->options, $this->component->getDto()->getCustomOption('choiceList'));
    }

    #[Test] public function it_sets_the_input_type_correctly()
    {
        $this->assertEquals('select', $this->component->getDto()->getInputType());
    }

    #[Test] public function it_sets_the_default_value_correctly()
    {
        $component = $this->component->setDefaultValue('1');
        $this->assertEquals('1', $component->getDto()->getValue());
    }

    #[Test] public function it_handles_custom_options_correctly()
    {
        $component = $this->component->setCustomOption('empty', 'Select an option');
        $this->assertEquals('Select an option', $component->getDto()->getCustomOption('empty'));
    }

    #[Test] public function it_sets_the_name_and_label_correctly()
    {
        $this->assertEquals('type', $this->component->getDto()->getName());
        $this->assertEquals('Type', $this->component->getDto()->getLabel());
    }

    #[Test] public function it_defaults_css_class_to_empty_string()
    {
        $this->assertEquals('', $this->component->getDto()->getCssClass());
    }

    #[Test] public function it_sets_the_layout_class_correctly()
    {
        $this->assertEquals('col-lg-6', $this->component->getDto()->getLayoutClass());
    }

    #[Test] public function it_sets_the_component_template_correctly()
    {
        $this->assertEquals('aim-admin::crudboard.fields.choice', $this->component->getDto()->getComponent());
    }


}
