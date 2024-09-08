<?php

declare(strict_types=1);

namespace CodeCoz\AimAdmin\Tests\Components;

use CodeCoz\AimAdmin\Field\DateTimeField;
use CodeCoz\AimAdmin\Tests\ComponentTestCase;
use PHPUnit\Framework\Attributes\Test;

class DateTimeFieldTest extends ComponentTestCase
{
    #[Test]
    public function it_initializes_with_correct_attributes()
    {
        $component = DateTimeField::init('date', 'Date');

        $this->assertEquals('date', $component->getDto()->getName());
        $this->assertEquals('Date', $component->getDto()->getLabel());
        $this->assertEquals('datetime-local', $component->getDto()->getInputType());
        $this->assertEquals('input', $component->getDto()->getHtmlElement());
    }

    #[Test]
    public function it_sets_the_format_correctly()
    {
        $component = DateTimeField::init('date', 'Date')->setFormat('Y-m-d H:i:s');
        $this->assertEquals('Y-m-d H:i:s', $component->getDto()->getCustomOption('format'));
    }

    #[Test]
    public function it_sets_the_component_template_correctly()
    {
        $component = DateTimeField::init('date', 'Date');
        $this->assertEquals('aim-admin::crudboard.fields.datetime', $component->getDto()->getComponent());
    }
}
