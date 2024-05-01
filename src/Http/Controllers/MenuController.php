<?php declare(strict_types=1);

namespace CodeCoz\AimAdmin\Http\Controllers;

use CodeCoz\AimAdmin\Contracts\Service\MenuServiceInterface;
use CodeCoz\AimAdmin\Controller\AbstractAimAdminController;
use CodeCoz\AimAdmin\Field\ButtonField;
use CodeCoz\AimAdmin\Field\ChoiceField;
use CodeCoz\AimAdmin\Field\Field;
use CodeCoz\AimAdmin\Field\InputField;
use CodeCoz\AimAdmin\Field\TextField;
use CodeCoz\AimAdmin\Helpers\Helper;
use CodeCoz\AimAdmin\Http\Requests\MenuCreateRequest;
use CodeCoz\AimAdmin\Http\Requests\MenuUpdateRequest;
use CodeCoz\AimAdmin\Traits\HelperTrait;

class MenuController extends AbstractAimAdminController
{
    use HelperTrait;
    const TARGET = [
        '_self' => 'Self',
        '_blank' => 'Blank',
    ];

    public function __construct(private readonly MenuServiceInterface $menuService)
    {

    }

    public function getRepository()
    {
        return $this->menuService;
    }

    public function configureActions(): iterable
    {
        return [
            ButtonField::init('new', 'new')->linkToRoute('menu_create')->createAsCrudBoardAction(),
            ButtonField::init(ButtonField::EDIT)->linkToRoute('menu_edit', function ($row) {
                return ['id' => $row['id']];
            }),
            ButtonField::init(ButtonField::DELETE)->linkToRoute('menu_delete', function ($row) {
                return ['id' => $row['id']];
            }),
            ButtonField::init('submit')->createAsFormSubmitAction(),
            ButtonField::init('cancel')->linkToRoute('menu_list')->createAsFormAction(),
        ];
    }

    public function configureForm()
    {
        $menus = $this->menuService->keyPairParentID();

        $iconCollection = collect(Helper::fontAwesomeIcons())
            ->filter()
            ->flatMap(function ($value) {
                return [$value => $value];
            });

        $icons = $iconCollection->toArray();

        $menus = [-1 => 'None'] + $menus;

        $fields = [
            ChoiceField::init('applicationID', 'Select Application', choiceType: 'select', choiceList: $this->menuService->getApplication())
                ->setDefault(config('aim-admin.auth.app_id')),
            InputField::init('title')->setHtmlAttributes(['required' => true]),
            InputField::init('name', 'Slug')->setHtmlAttributes(['required' => true]),
            ChoiceField::init('parentID', 'Parent Select', choiceType: 'select', choiceList: $menus)->setHtmlAttributes(['required' => true]),
            InputField::init('display_order')->setHtmlAttributes(['required' => true])->setDefaultValue('0'),
            ChoiceField::init('iconName', 'Select Icon', choiceType: 'select', choiceList: $icons)
                ->setCssClass('form-control icons_select2'),
            ChoiceField::init('target', 'Select Target', choiceType: 'target', choiceList: $this::TARGET)->setHtmlAttributes(['required' => true]),
        ];

        $this->getForm($fields)
            ->setName('menu_form')
            ->setMethod('post')
            ->setActionUrl(route('menu_store'));
    }

    public function configureFilter(): void
    {
        $fields = [
            TextField::init('title'),
            TextField::init('name')->setLabel('Slug'),
        ];
        $this->getFilter($fields);
    }

    public function menu()
    {
        $this->initGrid([
            'title',
            Field::init('name', 'Slug'),
            'applicationID',
            'parentID',
            Field::init('displayOrder', 'Display Order'),
            Field::init('isActive', 'Active Status')->formatValue(function ($value) {
                return $value == 1 ? "Active" : "Inactive";
            }),
            Field::init('isDeleted', 'Is Deleted')->formatValue(function ($value) {
                return $value == 1 ? "Yes" : "No";
            }),
        ], pagination: 10);
        return view('aimadmin::settings.menu.list');
    }

    public function create()
    {
        $this->initCreate();
        return view('aimadmin::settings.menu.create');
    }

    public function store(MenuCreateRequest $request)
    {
        $this->menuService->saveMenu($request);
        return to_route('menu_list')->with('success', 'Menu has been Created Successfully !');
    }

    public function update(MenuUpdateRequest $request)
    {
        $this->menuService->updateMenu($request);
        return to_route('menu_list')->with('success', 'Menu has been  Updated Successfully !');
    }

    public function edit(int $id)
    {
        $requestedMenu = $this->menuService->singleMenu($id);
        $icons = Helper::fontAwesomeIcons();
        return view('aimadmin::settings.menu.edit')
            ->with('menu', $requestedMenu->data)
            ->with('userApplicationIDs', $this->menuService->getApplication())
            ->with('icons', $icons)
            ->with('targets', $this::TARGET)
            ->with('all_menu', $this->getRepository()->getAllMenu());
    }

    public function delete($id)
    {
        $this->menuService->deleteMenu($id);
        return to_route('menu_list')->with('success', 'Menu has been Deleted Successfully !!!');
    }
}
