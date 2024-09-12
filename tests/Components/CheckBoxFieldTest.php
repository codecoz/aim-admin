<?php

declare(strict_types=1);


use CodeCoz\AimAdmin\Field\CheckBoxField;
use CodeCoz\AimAdmin\Tests\ComponentTestCase;
use PHPUnit\Framework\Attributes\Test;

class CheckBoxFieldTest extends ComponentTestCase
{
    private CheckBoxField $component;

    public function __construct(string $name)
    {
        parent::__construct($name);
        $this->component = CheckBoxField::init('name', 'CheckBox');
    }

    #[Test] public function the_checkbox_component_can_be_rendered()
    {
        $this->assertInstanceOf(CheckBoxField::class, $this->component);
    }

    #[Test] public function it_sets_the_html_element_as_anchor()
    {
        $this->assertEquals('input', $this->component->getDto()->getHtmlElement());
    }

    #[Test] public function it_sets_the_checkbox_label_correctly()
    {
        $this->assertEquals('CheckBox', $this->component->getDto()->getLabel());
    }

    #[Test] public function it_sets_the_checkbox_value_correctly()
    {
        $this->assertEquals(null, $this->component->getDto()->getValue());
    }

    #[Test] public function it_sets_the_checkbox_type_correctly()
    {
        $this->assertEquals('checkbox', $this->component->getDto()->getInputType());
    }

    #[Test] public function it_adds_custom_html_attributes()
    {
        $component = CheckBoxField::init('name', 'CheckBox')
            ->setHtmlAttributes(['data-custom' => 'custom-value']);
        $this->assertEquals('custom-value', $component->getDto()->getHtmlAttributes()->get('data-custom'));
    }

    #[Test] public function it_sets_the_component_template_correctly()
    {
        $this->assertEquals('aim-admin::crudboard.fields.checkbox', $this->component->getDto()->getComponent());
    }

}
