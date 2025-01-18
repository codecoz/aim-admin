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

namespace CodeCoz\AimAdmin\Collection;

use CodeCoz\AimAdmin\Dto\CrudBoard\ActionDto;

/**
 * This class is for action collection in crudboard  .
 *
 * @author CodeCoz <contact@codecoz.com>
 */
final class ActionCollection extends AbstractCollection
{
    private function __construct(array $actions)
    {
        $this->items = $actions;
    }

    public function __clone()
    {
        foreach ($this->items as $actionName => $actionDto) {
            $this->items[$actionName] = clone $actionDto;
        }
    }

    /**
     * @param ActionDto[] $actions
     */
    public static function init(array $actions): self
    {
        return new self($actions);
    }

    public function get(string $actionName): ?ActionDto
    {
        return $this->items[$actionName] ?? null;
    }

    public function offsetExists(mixed $offset): bool
    {
        return \array_key_exists($offset, $this->items);
    }

    public function offsetGet(mixed $offset): ActionDto
    {
        return $this->items[$offset];
    }

    public function getRowActions(): self
    {
        return self::init(array_filter(
            $this->items,
            static fn (ActionDto $action): bool => $action->isRowAction()
        ));
    }

    public function getCrudBoardActions(): self
    {
        return self::init(array_filter(
            $this->items,
            static fn (ActionDto $action): bool => $action->isCrudBoardAction()
        ));
    }

    public function getBatchActions(): self
    {
        return self::init(array_filter(
            $this->items,
            static fn (ActionDto $action): bool => $action->isBatchAction()
        ));
    }

    public function getFormActions(): self
    {
        return self::init(array_filter(
            $this->items,
            static fn (ActionDto $action): bool => $action->isFormAction()
        ));
    }

    public function getShowActions(): self
    {
        return self::init(array_filter(
            $this->items,
            static fn (ActionDto $action): bool => $action->isShowAction()
        ));
    }

    public function getFilterActions(): static
    {
        return self::init(array_filter(
            $this->items,
            static fn (ActionDto $action): bool => $action->isFilterAction()
        ));
    }

}
