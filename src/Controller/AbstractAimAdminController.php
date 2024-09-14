<?php declare(strict_types=1);

namespace CodeCoz\AimAdmin\Controller;

use CodeCoz\AimAdmin\Contracts\Controller\AimAdminControllerInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use CodeCoz\AimAdmin\Support\Facades\CrudBoardFacade;
use CodeCoz\AimAdmin\Contracts\Service\CrudBoard\CrudGridInterface;
use CodeCoz\AimAdmin\Form\CrudForm;

abstract class AbstractAimAdminController extends Controller implements AimAdminControllerInterface
{

    private ?array $actionList = null;

    public function configureFormField(): iterable
    {
        return [];
    }

    public function configureGridColumn(): iterable
    {
        return [];
    }


    public function configureGridRowActions(): iterable
    {
        return [];
    }


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
        $model = ($row instanceof Model) ? $row : $repo->getRecordForEdit($row);
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

    public function configureActions(): iterable
    {
        return $this->getDefaultCrudActions();
    }

}

