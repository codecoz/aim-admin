<?php declare(strict_types=1);

/*
 * This file is part of the Aim Admin package.
 *
 * (c) CodeCoz <contact@codecoz.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CodeCoz\AimAdmin\View\Components;

use CodeCoz\AimAdmin\Services\CrudBoard\GridFilter as Filter;

/**
 * this is a component class responsible for Crud Grid view
 *
 * @author CodeCoz <contact@codecoz.com>
 */
class GridFilter extends AbstractAimAdminComponent
{

    public Filter $filter;

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|\Closure|string
     */
    public function render()
    {
        $this->prepareFields();
        return view('aim-admin::crudboard.filter');
    }

    private function prepareFields(): void
    {
        $filter = $this->getCrudBoard()
            ->getGrid()->getFilter();
        $fields = $filter->getFields();
        foreach ($fields as $name => $field) {
            $field->setName(Filter::CONTAINER_NAME . "[$name]");
        }
        $this->filter = $filter;
    }
}
