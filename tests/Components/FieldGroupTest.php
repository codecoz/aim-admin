<?php

declare(strict_types=1);


use CodeCoz\AimAdmin\Field\FieldGroup;
use CodeCoz\AimAdmin\Field\TextField;
use CodeCoz\AimAdmin\Tests\ComponentTestCase;
use PHPUnit\Framework\Attributes\Test;

class FieldGroupTest extends ComponentTestCase
{
    private FieldGroup $component;

    public function __construct(string $name)
    {
        parent::__construct($name);

        $this->component = FieldGroup::init([
            TextField::init('name', 'Product Name'),
            TextField::init('detail', 'Product Detail'),
            TextField::init('source', 'Product Source'),
        ], 'Group')
            ->setLayoutClass('col-12');
    }

    #[Test] public function the_field_group_component_can_be_rendered()
    {
        $this->assertInstanceOf(FieldGroup::class, $this->component);
    }

    #[Test] public function it_sets_the_field_group_label_correctly()
    {
        $this->assertEquals('Group', $this->component->getDto()->getLabel());
    }

    #[Test] public function it_sets_the_field_group_value_correctly()
    {
        $this->assertEquals(null, $this->component->getDto()->getValue());
    }

    #[Test] public function it_adds_custom_html_attributes()
    {
        $component = $this->component
            ->setHtmlAttributes(['data-custom' => 'custom-value']);
        $this->assertEquals('custom-value', $component->getDto()->getHtmlAttributes()->get('data-custom'));
    }

    #[Test] public function it_sets_the_component_template_correctly()
    {
        $this->assertEquals('aim-admin::crudboard.fields.group', $this->component->getDto()->getComponent());
    }

}
