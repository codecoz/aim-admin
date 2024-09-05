<?php

namespace CodeCoz\AimAdmin\Tests\Service;

use CodeCoz\AimAdmin\Collection\FormFieldCollection;
use CodeCoz\AimAdmin\Form\CrudForm;
use CodeCoz\AimAdmin\Services\CrudBoard\GridFilter;
use Orchestra\Testbench\TestCase;


class CrudFormTest extends TestCase
{
    private CrudForm $form;

    protected function setUp(): void
    {
        $this->form = new GridFilter();
    }

    public function testFormField()
    {
        $this->form->addFields(['foo','bar']);
        $this->assertInstanceOf(FormFieldCollection::class,$this->form->getFields());
    }

    public function testSetCssClass()
    {
        $this->form->setCssClass('foo')
          ->setCssClass('bar');
        $this->assertEquals('foo bar',trim($this->form->getCssClass()));
    }

    public function testAddIdField()
    {
       $this->form->addFields(['foo','bar']);
       $this->form->addIdField();
       $this->assertEquals(3,$this->form->getFields()->count());
    }
}
