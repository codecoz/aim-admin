<?php

declare(strict_types=1);

namespace CodeCoz\AimAdmin\Tests\Components;

use CodeCoz\AimAdmin\Field\TextareaField;
use CodeCoz\AimAdmin\Tests\ComponentTestCase;
use PHPUnit\Framework\Attributes\Test;

class TextareaFieldTest extends ComponentTestCase
{
    #[Test]
    public function it_initializes_with_correct_attributes()
    {
        $component = TextareaField::init('description', 'Description');

        $this->assertEquals('description', $component->getDto()->getName());
        $this->assertEquals('Description', $component->getDto()->getLabel());
        $this->assertEquals('textarea', $component->getDto()->getHtmlElement());
    }

    #[Test]
    public function it_sets_rows_and_cols_correctly()
    {
        $component = TextareaField::init('description', 'Description')
            ->setRows(5)
            ->setCols(50);

        $this->assertEquals(5, $component->getDto()->getHtmlAttributes()->get('rows'));
        $this->assertEquals(50, $component->getDto()->getHtmlAttributes()->get('cols'));
    }

    #[Test]
    public function it_sets_the_component_template_correctly()
    {
        $component = TextareaField::init('description', 'Description');
        $this->assertEquals('aim-admin::crudboard.fields.textarea', $component->getDto()->getComponent());
    }
}
