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

namespace CodeCoz\AimAdmin\Contracts\Repository;

/**
 * This interface defines blueprints of AimAdmin Repository.
 *
 *
 * @author CodeCoz <contact@codecoz.com>
 */
interface AimAdminRepositoryInterface
{
    public function getModelFqcn(): string;
    public function crudShow(int|string $id): ?\ArrayAccess;
}
