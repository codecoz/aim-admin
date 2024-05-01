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

use CodeCoz\AimAdmin\Contracts\Repository\AimAdminRepositoryInterface;
use CodeCoz\AimAdmin\Form\AbstractForm;

/**
 * This interface defines blueprints of CRUD Board. CRUD Board is will handle CRUD operations
 * as well as filter and sorting options.
 *
 * @author CodeCoz <contact@codecoz.com>
 */
interface CrudBoardInterface
{
    public function createGrid(CrudGridLoaderInterface $dataLoader, array $params = []): CrudGridInterface;

    public function getRepository(): AimAdminRepositoryInterface;

    public function setRepository(AimAdminRepositoryInterface $repo): self;

    public function getGrid(): CrudGridInterface;

    public function addGridActions(array $actions = []);

    public function getForm(): AbstractForm;

    public function createForm(array $fields);

    public function getCrudShow(): CrudShowInterface;

}
