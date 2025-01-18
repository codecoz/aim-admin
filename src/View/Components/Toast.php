<?php

declare(strict_types=1);

/*
 * This file is part of the Aim Admin package.
 *
 * (c) CodeCoz <contact@codecoz.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CodeCoz\AimAdmin\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

/**
 * this is a component class responsible for Crud Grid view
 *
 * @author CodeCoz <contact@codecoz.com>
 */
class Toast extends Component
{
    /**
     * Create the component instance.
     */
    public function __construct(
        public string $type,
        public string $message,
        public int    $timer = 2000,
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('aim-admin::crudboard.toast');
    }

}
