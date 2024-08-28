<?php

declare(strict_types=1);

namespace CodeCoz\AimAdmin\Tests\Components;

use CodeCoz\AimAdmin\Field\ChoiceField;
use CodeCoz\AimAdmin\Tests\ComponentTestCase;
use PHPUnit\Framework\Attributes\Test;

class DropDownFieldTest extends ComponentTestCase
{

    private array $options;

    public function __construct(string $name)
    {
        parent::__construct($name);
        $this->options = [
            1 => 'One',
            2 => 'Two',
        ];
    }

    #[Test] public function the_choice_field_component_can_be_rendered()
    {
        $component = ChoiceField::init('type', 'Type', choiceType: 'select', choiceList: $this->options);
        $this->assertInstanceOf(ChoiceField::class, $component);
    }

    #[Test] public function it_sets_the_required_html_attribute_correctly()
    {
        $component = ChoiceField::init('type', 'Type', choiceType: 'select', choiceList: $this->options)
            ->setHtmlAttributes(['required' => true]);
        $this->assertTrue($component->getDto()->getHtmlAttributes()->get('required'));
    }

    #[Test] public function it_sets_the_choice_list_correctly()
    {
        $component = ChoiceField::init('type', 'Type', choiceType: 'select', choiceList: $this->options);
        $this->assertEquals($this->options, $component->getDto()->getCustomOption('choiceList'));
    }

    #[Test] public function it_sets_the_input_type_correctly()
    {
        $component = ChoiceField::init('type', 'Type', choiceType: 'select', choiceList: $this->options);
        $this->assertEquals('select', $component->getDto()->getInputType());
    }

    #[Test] public function it_sets_the_default_value_correctly()
    {
        $component = ChoiceField::init('type', 'Type', choiceType: 'select', choiceList: $this->options)
            ->setDefaultValue('1');
        $this->assertEquals('1', $component->getDto()->getValue());
    }

    #[Test] public function it_handles_custom_options_correctly()
    {
        $component = ChoiceField::init('type', 'Type', choiceType: 'select', choiceList: $this->options)
            ->setCustomOption('empty', 'Select an option');
        $this->assertEquals('Select an option', $component->getDto()->getCustomOption('empty'));
    }

    #[Test] public function it_sets_the_name_and_label_correctly()
    {
        $component = ChoiceField::init('type', 'Type', choiceType: 'select', choiceList: $this->options);
        $this->assertEquals('type', $component->getDto()->getName());
        $this->assertEquals('Type', $component->getDto()->getLabel());
    }

    #[Test] public function it_defaults_css_class_to_empty_string()
    {
        $component = ChoiceField::init('type', 'Type', choiceType: 'select', choiceList: $this->options);
        $this->assertEquals('', $component->getDto()->getCssClass());
    }

    #[Test] public function it_sets_the_layout_class_correctly()
    {
        $component = ChoiceField::init('type', 'Type', choiceType: 'select', choiceList: $this->options);
        $this->assertEquals('col-lg-6', $component->getDto()->getLayoutClass());
    }

    #[Test] public function it_sets_the_component_template_correctly()
    {
        $component = ChoiceField::init('type', 'Type', choiceType: 'select', choiceList: $this->options);
        $this->assertEquals('aim-admin::crudboard.fields.choice', $component->getDto()->getComponent());
    }


}
