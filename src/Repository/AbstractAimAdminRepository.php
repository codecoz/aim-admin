<?php declare(strict_types=1);

/*
 * This file is part of the Aim Admin package.
 *
 * (c) CodeCoz <contact@codecoz.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CodeCoz\AimAdmin\Repository;

use CodeCoz\AimAdmin\Contracts\Repository\AimAdminRepositoryInterface;
use CodeCoz\AimAdmin\Contracts\Service\CrudBoard\CrudFormHandlerInterface;
use CodeCoz\AimAdmin\Contracts\Service\CrudBoard\CrudGridLoaderInterface;
use Illuminate\Pagination\CursorPaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

/**
 * This interface defines blueprints of AimAdmin Repository.
 *
 *
 * @author CodeCoz <contact@codecoz.com>
 */
abstract class AbstractAimAdminRepository implements AimAdminRepositoryInterface, CrudFormHandlerInterface, CrudGridLoaderInterface
{
    public function all(): iterable
    {
        return $this->getModelFqcn()::all();
    }

    public function findOrFail(int|string $id): object
    {
        return $this->getModelFqcn()::findOrFail($id);
    }

    public function find($id)
    {
        return $this->getModelFqcn()::find($id);
    }

    public function findOneBy(string $field, $value)
    {
        return $this->getModelFqcn()::where($field, $value)->first();
    }

    protected function findBy($field, $value): iterable
    {
        return $this->getModelFqcn()::where($field, $value)->get();
    }

    public function saveFormData(array $data = [])
    {
        $class = $this->getModelFqcn();
        $model = new $class;
        foreach ($data as $key => $value) {
            $model->$key = $value;
        }
        $model->save();
        return $model;
    }

    public function crudShow(int|string $id): ?\ArrayAccess
    {
        return $this->find($id);
    }

    public function getRecordForEdit(int|string $id): object
    {
        $record = $this->findOrFail($id);
        return $record;
    }

    public function getGridData(array $filters = []): ?iterable
    {
        return null;
    }

    public function getGridQuery(): ?Builder
    {
        return null;
    }

    public function getGridPagination(): ?Paginator
    {
        return null;
    }

    public function getGridCursorPaginator(array $filters): ?CursorPaginator
    {
        return null;
    }

    public function getGridPaginator(array $filters): ?LengthAwarePaginator
    {
        return null;
    }

    public function applyFilterQuery(Builder $query, array $filters): Builder
    {
        foreach ($filters as $field => $value) {
            $query->where($field, $value);
        }
        return $query;
    }

    public function applyFilterData(Collection $data, array $filters): Collection
    {
        foreach ($filters as $field => $value) {
            $filtered = $data->where($field, $value);
            $data = $filtered;
        }
        return $data;
    }

}
