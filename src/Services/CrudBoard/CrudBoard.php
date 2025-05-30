<?php

declare(strict_types=1);

/*
 * This file is part of the AimAdmin package.
 *
 * (c) CodeCoz <contact@codecoz.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CodeCoz\AimAdmin\Services\CrudBoard;

/**
 * This interface defines blueprints of AimAdmin CRUD grid loader.
 * It will ensure to provide record for CrudBoard grid.
 *
 * @author Muhammad Abdullah Ibne Masud <abdullah.masud@banglalink.net>
 */

use CodeCoz\AimAdmin\Contracts\Repository\AimAdminRepositoryInterface;

final class CrudBoard extends AbstractCrudBoard
{
    private $params = [];

    public function setParam(mixed $param): static
    {
        $this->params[] = $param;
        return $this;
    }

    public function getParams(): array
    {
        return $this->params;
    }

    public function setRepository(AimAdminRepositoryInterface $repo): self
    {
        $this->repo = $repo;
        return $this;
    }

    protected function getRecordForShow(int|string $id): ?\ArrayAccess
    {
        return $this->getRepository()->crudShow($id);
    }
}
