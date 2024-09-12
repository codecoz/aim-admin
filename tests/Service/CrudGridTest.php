<?php

namespace CodeCoz\AimAdmin\Tests\Service;

use CodeCoz\AimAdmin\Collection\FieldCollection;
use CodeCoz\AimAdmin\Contracts\Service\CrudBoard\CrudGridInterface;
use CodeCoz\AimAdmin\Contracts\Service\CrudBoard\CrudGridLoaderInterface;
use CodeCoz\AimAdmin\Services\CrudBoard\CrudGrid;
use Orchestra\Testbench\TestCase;
use PHPUnit\Framework\MockObject\Exception;


class CrudGridTest extends TestCase
{
    private CrudGridInterface $crudGrid;

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        $crudGridLoader = $this->createMock(CrudGridLoaderInterface::class);
        $this->crudGrid =  CrudGrid::init($crudGridLoader,[]);
    }

    public function testTitle()
    {
        $this->crudGrid->setTitle('foo');
        $this->assertEquals('foo',$this->crudGrid->getTitle(),'Should return foo');
    }

    public function testAddColumn()
    {
        $this->crudGrid->addColumns(['foo','bar']);
        $this->assertInstanceOf(FieldCollection::class,$this->crudGrid->getColumns());
    }

    public function testDataLoader()
    {
        $this->assertInstanceOf(CrudGridLoaderInterface::class,$this->crudGrid->getGridDataLoader());
    }


}
