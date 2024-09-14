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

use CodeCoz\AimAdmin\Services\CrudBoard\CrudShow as Show;

/**
 * this is a component class responsible for Crud Grid view
 *
 * @author CodeCoz <contact@codecoz.com>
 */
class CrudShow extends AbstractAimAdminComponent
{

    public Show $show;

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|\Closure|string
     */
    public function render()
    {
        $this->show = $this->getCrudBoard()->getCrudShow();
        return view('aim-admin::crudboard.show');
    }
}
