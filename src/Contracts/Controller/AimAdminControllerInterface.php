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

namespace CodeCoz\AimAdmin\Contracts\Controller;

/**
 * This interface defines blueprints of AimAdmin admin controller.
 * as well as filter and sorting options.
 *
 * @author Muhammad Abdullah Ibne Masud <md.a.ibne.masud@gmail.com>
 */
interface AimAdminControllerInterface
{
    //public function getRepository();
    public function initGrid(array $columns);

}
