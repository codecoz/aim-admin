<?php

namespace CodeCoz\AimAdmin\Tests\Service;

use CodeCoz\AimAdmin\Collection\FormFieldCollection;
use CodeCoz\AimAdmin\Services\CrudBoard\GridFilter;
use Orchestra\Testbench\TestCase;


class GridFilterTest extends TestCase
{
    private GridFilter $filter;

    protected function setUp(): void
    {
        parent::setUp();
        $this->filter = new GridFilter();
    }

    public function testFilterField()
    {
        $this->filter->addFields(['foo','bar']);
        $this->assertInstanceOf(FormFieldCollection::class,$this->filter->getFields());
    }

    public function testSetCssClass()
    {
        $this->filter->setCssClass('foo')
          ->setCssClass('bar');
        $this->assertEquals('foo bar',trim($this->filter->getCssClass()));
    }

    public function testGetData()
    {
       $this->assertEquals([],$this->filter->getData());

    }

    public function testAssignQueryData()
    {
        $this->filter->addFields(['foo','bar']);
        $obj = $this->filter->assignQueryData();
        $this->assertInstanceOf(GridFilter::class,$obj);
    }
}
