<?php

declare(strict_types=1);


use CodeCoz\AimAdmin\Field\TextareaField;
use CodeCoz\AimAdmin\Tests\ComponentTestCase;
use CodeCoz\AimAdmin\Tests\Traits\InteractsWithViews;
use PHPUnit\Framework\Attributes\Test;

class TextAreaFieldTest extends ComponentTestCase
{
    use InteractsWithViews;

    #[Test] public function it_initializes_with_correct_attributes()
    {
        $component = TextareaField::init('name', 'TextArea Name');

        $this->assertEquals('name', $component->getDto()->getName());
        $this->assertEquals('TextArea Name', $component->getDto()->getLabel());
        $this->assertEquals('name', $component->getDto()->getHtmlAttributes()->get('id'));
    }

    #[Test] public function the_text_filed_component_can_be_rendered()
    {
        $component = TextareaField::init('name', 'textarea-name');
        $this->assertInstanceOf(TextareaField::class, $component);
    }


    #[Test] public function it_sets_the_placeholder_attribute()
    {
        $component = TextareaField::init('name', 'textarea-name')->setPlaceholder('Placeholder');
        $this->assertEquals('Placeholder', $component->getDto()->getHtmlAttributes()->get('placeholder'));
    }

    #[Test] public function it_sets_the_id_attribute()
    {
        $component = TextareaField::init('name', 'textarea-name');
        $this->assertEquals('name', $component->getDto()->getHtmlAttributes()->get('id'));
    }

    #[Test] public function it_assigns_the_label_correctly()
    {
        $component = TextareaField::init('name', 'Label');
        $this->assertEquals('Label', $component->getDto()->getLabel());
    }


    #[Test] public function it_defaults_to_not_required()
    {
        $component = TextareaField::init('name', 'textarea-name');
        $this->assertFalse($component->getDto()->isRequired());
    }


    #[Test] public function it_handles_custom_options()
    {
        $component = TextareaField::init('name', 'textarea-name')
            ->setCustomOption('data-custom', 'value');
        $this->assertEquals('value', $component->getDto()->getCustomOption('data-custom'));
    }


    #[Test] public function it_defaults_css_class_to_empty_string()
    {
        $component = TextareaField::init('name', 'textarea-name');
        $this->assertEquals('', $component->getDto()->getCssClass());
    }


    #[Test] public function it_stores_html_attributes_correctly()
    {
        $component = TextareaField::init('name', 'textarea-name')
            ->setHtmlAttributes(['data-test' => 'test-value']);
        $this->assertEquals('test-value', $component->getDto()->getHtmlAttributes()->get('data-test'));
    }


    #[Test] public function it_sets_the_layout_class_correctly()
    {
        $component = TextareaField::init('name', 'textarea-name');
        $this->assertEquals('col-lg-6', $component->getDto()->getLayoutClass());
    }


    #[Test] public function it_sets_the_component_template_correctly()
    {
        $component = TextareaField::init('name', 'textarea-name');
        $this->assertEquals('aim-admin::crudboard.fields.textarea', $component->getDto()->getComponent());
    }


}
