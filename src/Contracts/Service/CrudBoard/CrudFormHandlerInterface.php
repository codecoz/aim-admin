<?php declare(strict_types=1);

/*
 * This file is part of the Aim Admin package.
 *
 * (c) CodeCoz <contact@codecoz.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CodeCoz\AimAdmin\Contracts\Service\CrudBoard;

/**
 * This interface defines blueprints of AimAdmin CRUD form data handler.
 * It defines how to  validate and store data to DB
 * It will ensure to provide record for CrudBoard grid.
 *
 * @author CodeCoz <contact@codecoz.com>
 */
interface CrudFormHandlerInterface
{
    function saveFormData(array $data = []);
}
