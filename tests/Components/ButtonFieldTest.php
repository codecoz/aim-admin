<?php

declare(strict_types=1);

namespace CodeCoz\AimAdmin\Tests\Components;

use CodeCoz\AimAdmin\Field\ButtonField;
use CodeCoz\AimAdmin\Tests\ComponentTestCase;
use PHPUnit\Framework\Attributes\Test;

class ButtonFieldTest extends ComponentTestCase
{
    #[Test] public function the_button_component_can_be_rendered()
    {
        $component = ButtonField::init('name', 'Create');
        $this->assertInstanceOf(ButtonField::class, $component);
    }

    #[Test] public function the_button_field_component_can_be_rendered()
    {
        $component = ButtonField::init('name', 'Create');
        $this->assertInstanceOf(ButtonField::class, $component);
    }

    #[Test] public function it_sets_the_html_element_as_anchor()
    {
        $component = ButtonField::init('name', 'Create');
        $this->assertEquals('a', $component->getDto()->getHtmlElement());
    }

    #[Test] public function it_sets_the_button_label_correctly()
    {
        $component = ButtonField::init('name', 'Create');
        $this->assertEquals('Create', $component->getDto()->getLabel());
    }


    #[Test] public function it_sets_the_title_attribute_correctly()
    {
        $component = ButtonField::init('name', 'Create');
        $this->assertEquals('Create', $component->getDto()->getHtmlAttributes()->get('title'));
    }


    #[Test] public function it_sets_the_button_value_correctly()
    {
        $component = ButtonField::init('name', 'Create');
        $this->assertEquals('name', $component->getDto()->getValue());
    }

    #[Test] public function it_sets_the_css_class_correctly()
    {
        $component = ButtonField::init('name', 'Create');
        $this->assertEquals('btn btn-block btn-primary btn-sm', $component->getDto()->getCssClass());
    }


    #[Test] public function it_sets_the_button_type_correctly()
    {
        $component = ButtonField::init('name', 'Create');
        $this->assertEquals('row', $component->getDto()->getType());
    }

    #[Test] public function it_adds_custom_html_attributes()
    {
        $component = ButtonField::init('name', 'Create')
            ->setHtmlAttributes(['data-custom' => 'custom-value']);
        $this->assertEquals('custom-value', $component->getDto()->getHtmlAttributes()->get('data-custom'));
    }


    #[Test] public function it_can_render_with_custom_url()
    {
        $component = ButtonField::init('name', 'Create')
            ->createAsFormAction()
            ->linkToUrl('/custom-url');
        $this->assertEquals('/custom-url', $component->getDto()->getUrl());
    }


    #[Test] public function it_can_render_with_custom_route()
    {
        $component = ButtonField::init('name', 'Create')
            ->createAsFormAction()
            ->linkToRoute('custom.route', ['param' => 'value']);
        $this->assertEquals('custom.route', $component->getDto()->getRouteName());
        $this->assertEquals(['param' => 'value'], $component->getDto()->getRouteParameters());
    }

    #[Test] public function it_sets_the_component_template_correctly()
    {
        $component = ButtonField::init('name', 'Create');
        $this->assertEquals('aim-admin::crudboard.actions.grid-button', $component->getDto()->getComponent());
    }

}
