<?php

declare(strict_types=1);


use CodeCoz\AimAdmin\Field\HiddenField;
use CodeCoz\AimAdmin\Tests\ComponentTestCase;
use CodeCoz\AimAdmin\Tests\Traits\InteractsWithViews;
use PHPUnit\Framework\Attributes\Test;

class HiddenFieldTest extends ComponentTestCase
{
    use InteractsWithViews;


    #[Test] public function it_initializes_with_correct_attributes()
    {
        $component = HiddenField::init('name', 'Hidden Name');

        $this->assertEquals('name', $component->getDto()->getName());
        $this->assertEquals(null, $component->getDto()->getLabel());
    }

    #[Test] public function the_text_filed_component_can_be_rendered()
    {
        $component = HiddenField::init('name', 'input-name');
        $this->assertInstanceOf(HiddenField::class, $component);
    }


    #[Test] public function it_sets_the_placeholder_attribute()
    {
        $component = HiddenField::init('name', 'input-name')->setPlaceholder('Placeholder');
        $this->assertEquals('Placeholder', $component->getDto()->getHtmlAttributes()->get('placeholder'));
    }


    #[Test] public function it_assigns_the_label_correctly()
    {
        $component = HiddenField::init('name', 'Label');
        $this->assertEquals(null, $component->getDto()->getLabel());
    }


    #[Test] public function it_defaults_to_not_required()
    {
        $component = HiddenField::init('name', 'input-name');
        $this->assertFalse($component->getDto()->isRequired());
    }


    #[Test] public function it_handles_custom_options()
    {
        $component = HiddenField::init('name', 'input-name')
            ->setCustomOption('data-custom', 'value');
        $this->assertEquals('value', $component->getDto()->getCustomOption('data-custom'));
    }


    #[Test] public function it_defaults_css_class_to_empty_string()
    {
        $component = HiddenField::init('name', 'input-name');
        $this->assertEquals('', $component->getDto()->getCssClass());
    }


    #[Test] public function it_stores_html_attributes_correctly()
    {
        $component = HiddenField::init('name', 'input-name')
            ->setHtmlAttributes(['data-test' => 'test-value']);
        $this->assertEquals('test-value', $component->getDto()->getHtmlAttributes()->get('data-test'));
    }


    #[Test] public function it_sets_the_layout_class_correctly()
    {
        $component = HiddenField::init('name', 'input-name');
        $this->assertEquals('col-lg-6', $component->getDto()->getLayoutClass());
    }


    #[Test] public function it_sets_the_component_template_correctly()
    {
        $component = HiddenField::init('name', 'input-name');
        $this->assertEquals('aim-admin::crudboard.fields.hidden', $component->getDto()->getComponent());
    }


}
