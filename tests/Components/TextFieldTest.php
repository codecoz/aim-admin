<?php

declare(strict_types=1);

namespace CodeCoz\AimAdmin\Tests\Components;

use CodeCoz\AimAdmin\Field\TextField;
use CodeCoz\AimAdmin\Tests\ComponentTestCase;
use CodeCoz\AimAdmin\Tests\Traits\InteractsWithViews;
use PHPUnit\Framework\Attributes\Test;

class TextFieldTest extends ComponentTestCase
{
    use InteractsWithViews;


    #[Test] public function it_initializes_with_correct_attributes()
    {
        $component = TextField::init('name', 'Input Name');

        $this->assertEquals('name', $component->getDto()->getName());
        $this->assertEquals('Input Name', $component->getDto()->getLabel());
        $this->assertEquals('text', $component->getDto()->getInputType());
        $this->assertEquals('input', $component->getDto()->getHtmlElement());
        $this->assertEquals('name', $component->getDto()->getHtmlAttributes()->get('id'));
    }

    #[Test] public function the_text_filed_component_can_be_rendered()
    {
        $component = TextField::init('name', 'input-name');
        $this->assertInstanceOf(TextField::class, $component);
    }


    #[Test] public function it_sets_the_html_element_as_input()
    {
        $component = TextField::init('name', 'input-name');
        $this->assertEquals('input', $component->getDto()->getHtmlElement());
    }


    #[Test] public function it_sets_the_placeholder_attribute()
    {
        $component = TextField::init('name', 'input-name')->setPlaceholder('Placeholder');
        $this->assertEquals('Placeholder', $component->getDto()->getHtmlAttributes()->get('placeholder'));
    }


    #[Test] public function it_sets_the_id_attribute()
    {
        $component = TextField::init('name', 'input-name');
        $this->assertEquals('name', $component->getDto()->getHtmlAttributes()->get('id'));
    }


    #[Test] public function it_assigns_the_label_correctly()
    {
        $component = TextField::init('name', 'Label');
        $this->assertEquals('Label', $component->getDto()->getLabel());
    }


    #[Test] public function it_defaults_to_not_required()
    {
        $component = TextField::init('name', 'input-name');
        $this->assertFalse($component->getDto()->isRequired());
    }


    #[Test] public function it_handles_custom_options()
    {
        $component = TextField::init('name', 'input-name')
            ->setCustomOption('data-custom', 'value');
        $this->assertEquals('value', $component->getDto()->getCustomOption('data-custom'));
    }


    #[Test] public function it_defaults_css_class_to_empty_string()
    {
        $component = TextField::init('name', 'input-name');
        $this->assertEquals('', $component->getDto()->getCssClass());
    }


    #[Test] public function it_stores_html_attributes_correctly()
    {
        $component = TextField::init('name', 'input-name')
            ->setHtmlAttributes(['data-test' => 'test-value']);
        $this->assertEquals('test-value', $component->getDto()->getHtmlAttributes()->get('data-test'));
    }


    #[Test] public function it_sets_the_layout_class_correctly()
    {
        $component = TextField::init('name', 'input-name');
        $this->assertEquals('col-lg-6', $component->getDto()->getLayoutClass());
    }


    #[Test] public function it_sets_the_component_template_correctly()
    {
        $component = TextField::init('name', 'input-name');
        $this->assertEquals('aim-admin::crudboard.fields.input', $component->getDto()->getComponent());
    }


}
