<?php

declare(strict_types=1);

namespace CodeCoz\AimAdmin\Controller;

use CodeCoz\AimAdmin\Contracts\Controller\AimAdminControllerInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use CodeCoz\AimAdmin\Support\Facades\CrudBoardFacade;
use CodeCoz\AimAdmin\Contracts\Service\CrudBoard\CrudGridInterface;
use CodeCoz\AimAdmin\Form\CrudForm;
use CodeCoz\AimAdmin\Repository\AbstractAimAdminRepository;

abstract class AbstractAimAdminController extends Controller implements AimAdminControllerInterface
{
    private ?array $actionList = null;

    /**
    * Abstract method must be implemented in the child controller
    * this will return associated respository for the controller.
    *
    * @return AbstractAimAdminRepository
    */
    abstract protected function getRepository();

    /**
    * protected method for configuring  crudboard actions.
    * need be implemented in the child controller class for different actions.
    *
    * @return iterable
    */
    protected function configureActions(): iterable
    {
        return $this->getDefaultCrudActions();
    }

    /**
    * Abstracted method for configuring  crudboard actions.
    * Must be implemented in the child controller class for the actions.
    *
    * @return void
    */
    abstract protected function configureFilter(): void;

    /**
    * Abstract method for configuring  crudboard form.
    * Must to be implemented in the child controller class for configuring the form.
    *
    * @return void
    */
    abstract protected function configureForm(): void;


    public function initGrid(array $columns, mixed ...$params): CrudGridInterface
    {
        $this->actionList = $this->actionList ?? $this->configureActions();
        $grid = CrudBoardFacade::createGrid($this->getRepository(), $params)
            ->addColumns($columns)
            ->addActions($this->actionList);
        $this->configureFilter();
        return $grid;
    }

    protected function getForm(array $fields)
    {
        $this->actionList = $this->actionList ?? $this->configureActions();
        return CrudBoardFacade::createForm($fields)
            ->setFormStat(CrudForm::STAT_NEW)
            ->setActions($this->actionList);
    }

    protected function getFilter(array $fields)
    {
        $this->actionList = $this->actionList ?? $this->configureActions();
        return CrudBoardFacade::getGrid()
            ->getFilter()
            ->addFields($fields)
            ->setFormStat(CrudForm::STAT_NEW)
            ->setActions($this->actionList)
            ->assignQueryData();
    }

    protected function initCreate()
    {
        $this->configureForm();
        return CrudBoardFacade::getForm();
    }


    protected function initStore(Request $request)
    {
        $this->configureForm();
        return CrudBoardFacade::getForm()
            ->setFormHandler($this->getRepository())
            ->processData($request);
    }

    protected function getDefaultCrudActions(): iterable
    {
        return [

        ];
    }

    protected function initEdit(mixed $row): CrudForm
    {
        $repo = $this->getRepository();
        $model = is_object($row) ? $row : $repo->getRecordForEdit($row);
        $this->configureForm();
        return CrudBoardFacade::getForm()
            ->setFormStat(CrudForm::STAT_EDIT)
            ->setData($model);
    }

    protected function initShow(mixed $row, array $fields)
    {
        $this->actionList = $this->actionList ?? $this->configureActions();
        return CrudBoardFacade::setRepository($this->getRepository())
            ->createShow($row, $fields)
            ->addActions($this->actionList);
    }
}
