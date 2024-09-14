<?php declare(strict_types=1);

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
 * @author CodeCoz <contact@codecoz.com>
 */
interface AimAdminControllerInterface
{
    function getRepository();
    function initGrid(array $columns);
}
