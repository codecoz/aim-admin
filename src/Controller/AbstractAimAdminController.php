<?php declare(strict_types=1);

namespace CodeCoz\AimAdmin\Controller;

use CodeCoz\AimAdmin\Contracts\Controller\AimAdminControllerInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use CodeCoz\AimAdmin\Support\Facades\CrudBoardFacade;
use CodeCoz\AimAdmin\Contracts\Service\CrudBoard\CrudGridInterface;
use CodeCoz\AimAdmin\Field\ButtonField;
use CodeCoz\AimAdmin\Form\CrudForm;

abstract class AbstractAimAdminController extends Controller implements AimAdminControllerInterface
{

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
        $grid = CrudBoardFacade::createGrid($this->getRepository(), $params)
            ->addColumns($columns)
            ->addActions($this->configureActions());
        $this->configureFilter();
        return $grid;
    }

    protected function getForm(array $fields)
    {
        return CrudBoardFacade::createForm($fields)
            ->setFormStat(CrudForm::STAT_NEW)
            ->setActions($this->configureActions());
    }

    protected function getFilter(array $fields)
    {
        return CrudBoardFacade::getGrid()
            ->getFilter()
            ->addFields($fields)
            ->setFormStat(CrudForm::STAT_NEW)
            ->setActions($this->configureActions())
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
            ButtonField::init(ButtonField::EDIT)->linkToRoute('customer_edit')->addCssClass('fa-file-lines'),
            ButtonField::init(ButtonField::DELETE)->linkToRoute('customer_delete'),
            ButtonField::init(ButtonField::DETAIL)->linkToRoute('customer_detail'),
            ButtonField::init('new', 'new')->linkToRoute('customer_create')->createAsCrudBoardAction(),
            // ButtonField::init('other')->linkToRoute('other_link')->addCssClass('btn-secondary')->setIcon('fa-pencil')

        ];
    }

    protected function initEdit(int|string $id): CrudForm
    {
        $repo = $this->getRepository();
        $row = $repo->getRecordForEdit($id);
        $this->configureForm();
        return CrudBoardFacade::getForm()
            ->setFormStat(CrudForm::STAT_EDIT)
            ->setData($row);
    }

    protected function initShow(int|string $id, array $fields)
    {
        return CrudBoardFacade::setRepository($this->getRepository())
            ->createShow($id, $fields)
            ->addActions($this->configureActions());
    }

    public function configureActions(): iterable
    {
        return $this->getDefaultCrudActions();
    }


}
