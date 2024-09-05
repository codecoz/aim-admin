<?php

namespace CodeCoz\AimAdmin\Tests\Service;

use ArrayAccess;
use CodeCoz\AimAdmin\Collection\FieldCollection;
use CodeCoz\AimAdmin\Contracts\Repository\AimAdminRepositoryInterface;
use CodeCoz\AimAdmin\Contracts\Service\CrudBoard\CrudBoardInterface;
use CodeCoz\AimAdmin\Contracts\Service\CrudBoard\CrudGridInterface;
use CodeCoz\AimAdmin\Contracts\Service\CrudBoard\CrudShowInterface;
use CodeCoz\AimAdmin\Form\CrudForm;
use CodeCoz\AimAdmin\Services\CrudBoard\CrudBoard;
use Orchestra\Testbench\TestCase;


class CrudBoardTest extends TestCase
{

   private CrudBoardInterface $crudBoard;

   protected function setUp(): void
   {
       $this->crudBoard = new CrudBoard();
   }

   public function testCanCreateCrudForm()
   {
      $fields = ['name'];
      $form = $this->crudBoard->createForm($fields);
      $this->assertInstanceOf(CrudForm::class,$form);
      $this->assertInstanceOf(CrudForm::class,$this->crudBoard->getForm());
   }

   public function testCrudBoardParameter()
   {
    $this->crudBoard->setParam('test1');
    $this->crudBoard->setParam('test2');
    $this->crudBoard->setParam('test3');
    $this->assertSame(['test1','test2','test3'], $this->crudBoard->getParams());
   }

   public function testCrudBoardService()
   {
        $stubRepo = new class() implements AimAdminRepositoryInterface
        {
            public function getModelFqcn(): string
            {
              return "User";
            }
            public function crudShow(int|string $id): ?ArrayAccess
            {
                return $this->findById($id);
            }
            private function findById(int $id) : ArrayAccess{
                $row = ['id'=>$id, 'title'=>'foo'];

               return $stubRow = new class($row) implements ArrayAccess {
                    private array $container = [];
                    public function __construct(array $row)
                    {
                        $this->container = $row;
                    }
                    public function offsetSet($offset, $value): void {
                        if (is_null($offset)) {
                            $this->container[] = $value;
                        } else {
                            $this->container[$offset] = $value;
                        }
                    }

                    public function offsetExists($offset): bool {
                        return isset($this->container[$offset]);
                    }

                    public function offsetUnset($offset): void {
                        unset($this->container[$offset]);
                    }

                    public function offsetGet($offset): mixed {
                        return isset($this->container[$offset]) ? $this->container[$offset] : null;
                    }
                };
            }
        };

        $this->assertInstanceOf(CrudBoard::class,$this->crudBoard->setRepository($stubRepo));
        $this->assertInstanceOf(AimAdminRepositoryInterface::class,$this->crudBoard->getRepository());
        $crudShow = $this->crudBoard->createShow(1,['name']);
        $this->assertInstanceOf(CrudShowInterface::class,$crudShow);

   }


}


