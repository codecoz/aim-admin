<?php

declare(strict_types=1);

namespace CodeCoz\AimAdmin\Tests\Components;

use CodeCoz\AimAdmin\Field\DateTimeField;
use CodeCoz\AimAdmin\Tests\ComponentTestCase;
use PHPUnit\Framework\Attributes\Test;

class DateTimeFieldTest extends ComponentTestCase
{
    private DateTimeField $component;

    public function __construct(string $name)
    {
        parent::__construct($name);
        $this->component = DateTimeField::init('date', 'Date');
    }

    #[Test]
    public function it_initializes_with_correct_attributes()
    {

        $this->assertEquals('date', $this->component->getDto()->getName());
        $this->assertEquals('Date', $this->component->getDto()->getLabel());
    }

    #[Test]
    public function it_sets_the_component_template_correctly()
    {
        $this->assertEquals('aim-admin::crudboard.fields.datetime', $this->component->getDto()->getComponent());
    }
}
