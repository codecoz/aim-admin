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

use CodeCoz\AimAdmin\Services\CrudBoard\GridFilter;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * This interface defines blueprints of AimAdmin CRUD grid.
 * It will ensure to provide record for CrudBoard grid.
 *
 * @author CodeCoz <contact@codecoz.com>
 */
interface CrudGridInterface
{
    function getGridDataLoader(): CrudGridLoaderInterface;

    function getGridData(): LengthAwarePaginator;

    function addColumns(array $columns);

    function getColumns();

    function addActions(array $actions = []);

    public function getFilter(): GridFilter;

    public function setTitle(string $title): self;

    public function getTitle(): ?string;

    public static function init(CrudGridLoaderInterface $gridDataLoader, array $params): CrudGridInterface;

}
