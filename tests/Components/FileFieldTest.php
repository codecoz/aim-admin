<?php

declare(strict_types=1);


use CodeCoz\AimAdmin\Field\FileField;
use CodeCoz\AimAdmin\Tests\ComponentTestCase;
use CodeCoz\AimAdmin\Tests\Traits\InteractsWithViews;
use PHPUnit\Framework\Attributes\Test;

class FileFieldTest extends ComponentTestCase
{
    use InteractsWithViews;

    private FileField $component;

    public function __construct(string $name)
    {
        parent::__construct($name);
        $this->component = FileField::init('name', 'file-name');
    }

    #[Test] public function it_initializes_with_correct_attributes()
    {
        $this->assertEquals('name', $this->component->getDto()->getName());
        $this->assertEquals('File-name', $this->component->getDto()->getLabel());
        $this->assertEquals('file', $this->component->getDto()->getInputType());
        $this->assertEquals('input', $this->component->getDto()->getHtmlElement());
        $this->assertEquals(null, $this->component->getDto()->getHtmlAttributes()->get('id'));
    }

    #[Test] public function the_text_filed_component_can_be_rendered()
    {
        $this->assertInstanceOf(FileField::class, $this->component);
    }

    #[Test] public function it_sets_the_html_element_as_input()
    {
        $this->assertEquals('input', $this->component->getDto()->getHtmlElement());
    }

    #[Test] public function it_sets_the_placeholder_attribute()
    {
        $this->assertEquals('file-name', $this->component->getDto()->getHtmlAttributes()->get('placeholder'));
    }

    #[Test] public function it_sets_the_id_attribute()
    {
        $this->assertEquals(null, $this->component->getDto()->getHtmlAttributes()->get('id'));
    }

    #[Test] public function it_assigns_the_label_correctly()
    {
        $this->assertEquals('File-name', $this->component->getDto()->getLabel());
    }

    #[Test] public function it_defaults_to_not_required()
    {
        $this->assertFalse($this->component->getDto()->isRequired());
    }


    #[Test] public function it_handles_custom_options()
    {
        $component = $this->component->setCustomOption('data-custom', 'value');
        $this->assertEquals('value', $component->getDto()->getCustomOption('data-custom'));
    }


    #[Test] public function it_defaults_css_class_to_empty_string()
    {
        $this->assertEquals('', $this->component->getDto()->getCssClass());
    }


    #[Test] public function it_stores_html_attributes_correctly()
    {
        $component = $this->component->setHtmlAttributes(['data-test' => 'test-value']);
        $this->assertEquals('test-value', $component->getDto()->getHtmlAttributes()->get('data-test'));
    }


    #[Test] public function it_sets_the_layout_class_correctly()
    {
        $this->assertEquals('col-lg-6', $this->component->getDto()->getLayoutClass());
    }


    #[Test] public function it_sets_the_component_template_correctly()
    {
        $this->assertEquals('aim-admin::crudboard.fields.file', $this->component->getDto()->getComponent());
    }

}
