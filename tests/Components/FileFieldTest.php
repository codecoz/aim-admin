<?php

declare(strict_types=1);


use CodeCoz\AimAdmin\Field\FileField;
use CodeCoz\AimAdmin\Tests\ComponentTestCase;
use CodeCoz\AimAdmin\Tests\Traits\InteractsWithViews;
use PHPUnit\Framework\Attributes\Test;

class FileFieldTest extends ComponentTestCase
{
    use InteractsWithViews;


    #[Test] public function it_initializes_with_correct_attributes()
    {
        $component = FileField::init('name', 'File Name');

        $this->assertEquals('name', $component->getDto()->getName());
        $this->assertEquals('File Name', $component->getDto()->getLabel());
        $this->assertEquals('file', $component->getDto()->getInputType());
        $this->assertEquals('input', $component->getDto()->getHtmlElement());
        $this->assertEquals(null, $component->getDto()->getHtmlAttributes()->get('id'));
    }

    #[Test] public function the_text_filed_component_can_be_rendered()
    {
        $component = FileField::init('name', 'file-name');
        $this->assertInstanceOf(FileField::class, $component);
    }


    #[Test] public function it_sets_the_html_element_as_input()
    {
        $component = FileField::init('name', 'file-name');
        $this->assertEquals('input', $component->getDto()->getHtmlElement());
    }


    #[Test] public function it_sets_the_placeholder_attribute()
    {
        $component = FileField::init('name', 'file-name')->setPlaceholder('Placeholder');
        $this->assertEquals('Placeholder', $component->getDto()->getHtmlAttributes()->get('placeholder'));
    }


    #[Test] public function it_sets_the_id_attribute()
    {
        $component = FileField::init('name', 'file-name');
        $this->assertEquals(null, $component->getDto()->getHtmlAttributes()->get('id'));
    }


    #[Test] public function it_assigns_the_label_correctly()
    {
        $component = FileField::init('name', 'Label');
        $this->assertEquals('Label', $component->getDto()->getLabel());
    }


    #[Test] public function it_defaults_to_not_required()
    {
        $component = FileField::init('name', 'file-name');
        $this->assertFalse($component->getDto()->isRequired());
    }


    #[Test] public function it_handles_custom_options()
    {
        $component = FileField::init('name', 'file-name')
            ->setCustomOption('data-custom', 'value');
        $this->assertEquals('value', $component->getDto()->getCustomOption('data-custom'));
    }


    #[Test] public function it_defaults_css_class_to_empty_string()
    {
        $component = FileField::init('name', 'file-name');
        $this->assertEquals('', $component->getDto()->getCssClass());
    }


    #[Test] public function it_stores_html_attributes_correctly()
    {
        $component = FileField::init('name', 'file-name')
            ->setHtmlAttributes(['data-test' => 'test-value']);
        $this->assertEquals('test-value', $component->getDto()->getHtmlAttributes()->get('data-test'));
    }


    #[Test] public function it_sets_the_layout_class_correctly()
    {
        $component = FileField::init('name', 'file-name');
        $this->assertEquals('col-lg-6', $component->getDto()->getLayoutClass());
    }


    #[Test] public function it_sets_the_component_template_correctly()
    {
        $component = FileField::init('name', 'file-name');
        $this->assertEquals('aim-admin::crudboard.fields.file', $component->getDto()->getComponent());
    }


}
