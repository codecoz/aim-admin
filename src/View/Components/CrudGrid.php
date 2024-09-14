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

use CodeCoz\AimAdmin\Contracts\Service\CrudBoard\CrudGridInterface;

/**
 * this is a component class responsible for Crud Grid view
 *
 * @author CodeCoz <contact@codecoz.com>
 */
class CrudGrid extends AbstractAimAdminComponent
{

    public CrudGridInterface $grid;

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|\Closure|string
     */
    public function render()
    {
        $this->grid = $this->getCrudBoard()->getGrid();
        return view('aim-admin::crudboard.grid');
    }
}
