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

namespace CodeCoz\AimAdmin\Services\CrudBoard;

use CodeCoz\AimAdmin\Collection\ActionCollection;
use CodeCoz\AimAdmin\Collection\FieldCollection;
use CodeCoz\AimAdmin\Contracts\Service\CrudBoard\CrudGridInterface;
use CodeCoz\AimAdmin\Contracts\Service\CrudBoard\CrudGridLoaderInterface;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * This class implement  AimAdmin CRUD grid Interface .
 * It is responsible to generate grid/table view.
 *
 * @author CodeCoz <contact@codecoz.com>
 */
final class CrudGrid implements CrudGridInterface
{
    private ?string $title = null;
    private FieldCollection $fields;
    private ActionCollection $actions;
    private GridFilter $filter;
    private GridPaginator $paginator;
    private array $loaderParams = [];
    private ?LengthAwarePaginator $gridData = null;
    private array $config = [
        'actionHeader' => 'Action',
        'rowCssCallable' => null,
        'rowCssClassCallable' => null,
        'headerRowCssClass' => null,
        'tableCssClass' => 'table-bordered table-hover text-nowrap table-sm',
    ];

    private function __construct(private CrudGridLoaderInterface $gridDataLoader, array $params)
    {
        $this->filter = new GridFilter();
        $this->paginator = new GridPaginator($params['pagination'] ?? 10);
        $this->config = ($params['config'] ?? []) + $this->config;
    }

    public static function init(CrudGridLoaderInterface $gridDataLoader, array $params): CrudGridInterface
    {
        return new self($gridDataLoader, $params);
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getFilter(): GridFilter
    {
        return $this->filter;
    }

    function getGridDataLoader(): CrudGridLoaderInterface
    {
        return $this->gridDataLoader;
    }

    public function addColumns(array $columns): self
    {
        $this->fields = FieldCollection::init($columns);
        return $this;
    }

    public function addActions(array $actions = [])
    {
        $dtos = [];
        foreach ($actions as $name => $action) {
            $dtos[$name] = $action->getDto();
        }
        $this->actions = ActionCollection::init($dtos);
        return $this;
    }

    public function getColumns()
    {
        return $this->fields;
    }

    public function getGridData(): LengthAwarePaginator
    {
        if (!$this->gridData) {
            $filters = $this->filter->getData();
            $queryBuilder = $this->gridDataLoader->getGridQuery();
            if (null !== $queryBuilder) {
                $queryBuilder = $this->gridDataLoader->applyFilterQuery($queryBuilder, $filters);
                $paginator = $this->paginator->paginateQuery($queryBuilder);
            } elseif ($gridData = $this->gridDataLoader->getGridData($filters)) {
                $dataCollection = $gridData instanceof Collection ? $gridData : collect($gridData);
                $dataCollection = $this->gridDataLoader->applyFilterData($dataCollection, $filters);
                $paginator = $this->paginator->paginate($dataCollection);
                $paginator->withPath(Request::url());
            } else {
                ($paginator = $this->gridDataLoader->getGridCursorPaginator($filters))
                || ($paginator = $this->gridDataLoader->getGridPaginator($filters));
            }
            $this->gridData = $paginator ? $paginator->withQueryString() : $this->paginator->paginate(collect([]));
        }
        return $this->gridData;
    }

    public function getActions(): ActionCollection
    {
        return $this->actions->getCrudBoardActions();
    }

    public function getRowActions(): ActionCollection
    {
        return $this->actions->getRowActions();
    }

    public function getActionLevel(): string
    {
        return $this->config['actionHeader'];
    }

    public function getRowCssClass(mixed $row): ?string
    {
        $cssClass = null;
        $this->config['rowCssClassCallable'] &&
        is_callable($this->config['rowCssClassCallable']) &&
        $cssClass = call_user_func($this->config['rowCssClassCallable'], $row);
        return $cssClass;
    }

    public function getRowCss(mixed $row): ?string
    {
        $css = null;
        $this->config['rowCssCallable'] &&
        is_callable($this->config['rowCssCallable']) &&
        $css = call_user_func($this->config['rowCssCallable'], $row);
        return $css;
    }

    public function getHeaderRowCssClass(): ?string
    {
        return $this->config['headerRowCssClass'];
    }

    public function getTableCssClass(): ?string
    {
        return $this->config['tableCssClass'];
    }
}
