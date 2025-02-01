<?php

declare(strict_types=1);

namespace CodeCoz\AimAdmin\Services\CrudBoard;

use CodeCoz\AimAdmin\Contracts\Repository\AimAdminRepositoryInterface;
use CodeCoz\AimAdmin\Contracts\Service\CrudBoard\CrudBoardInterface;
use CodeCoz\AimAdmin\Contracts\Service\CrudBoard\CrudGridInterface;
use CodeCoz\AimAdmin\Contracts\Service\CrudBoard\CrudGridLoaderInterface;
use CodeCoz\AimAdmin\Contracts\Service\CrudBoard\CrudShowInterface;
use CodeCoz\AimAdmin\Form\CrudForm;
use Illuminate\Database\Eloquent\Model;

abstract class AbstractCrudBoard implements CrudBoardInterface
{
    protected AimAdminRepositoryInterface $repo;
    private CrudGridInterface $grid;
    private CrudForm $form;
    private CrudShowInterface $crudShow;

    abstract protected function getRecordForShow(int|string $id): ?\ArrayAccess;

    public function createGrid(CrudGridLoaderInterface $dataLoader, array $params = []): CrudGridInterface
    {
        $this->grid = CrudGrid::init($dataLoader, $params);
        return $this->grid;
    }

    public function getRepository(): AimAdminRepositoryInterface
    {
        return $this->repo;
    }

    public function getGrid(): CrudGridInterface
    {
        return $this->grid;
    }

    public function addGridColumns(array $columns)
    {
        $this->grid->addColumns($columns);
        return $this;
    }

    public function getForm(): CrudForm
    {
        return $this->form;
    }


    public function addGridActions(array $actions = [])
    {
        $this->grid->addActions($actions);
        return $this;
    }

    protected function defaultGridRowActions()
    {

    }

    public function createForm(array $fields): CrudForm
    {
        $this->form = (new CrudForm())
            ->addFields($fields);
        return $this->form;
    }

    /**
     * @throws \Exception
     */
    public function createShow(mixed $row, array $fields): CrudShowInterface
    {
        $record = ($row instanceof Model) ? $row : $this->getRecordForShow($row);
        if ($record === null) {
            throw new \Exception("No record is found for details");
        }
        $this->crudShow = CrudShow::init($fields, $record);
        return $this->crudShow;
    }

    public function getCrudShow(): CrudShowInterface
    {
        return $this->crudShow;
    }

}
