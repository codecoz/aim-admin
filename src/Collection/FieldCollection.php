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

use CodeCoz\AimAdmin\Dto\CrudBoard\FieldDto;
use CodeCoz\AimAdmin\Field\Field;

/**
 * This class is for field creation in crudboard  .
 *
 * @author CodeCoz <contact@codecoz.com>
 */
final class FieldCollection extends AbstractCollection
{
    private function __construct(iterable $fields)
    {
        $this->items = $this->processFields($fields);
    }

    public static function init(iterable $fields): self
    {
        return new self($fields);
    }

    public function offsetGet(mixed $offset): FieldDto
    {
        return $this->items[$offset];
    }

    private function processFields(iterable $fields): array
    {
        $dtos = [];
        foreach ($fields as $field) {
            if (\is_string($field)) {
                $field = Field::init($field, $field);
            }

            $dto = $field->getDto();
            $dtos[$dto->getName()] = $dto;
        }

        return $dtos;
    }

    public function prepend(FieldDto $field): void
    {
        $this->items = \array_unshift($this->items, $field);
    }

    public function first(): ?FieldDto
    {
        if (0 === \count($this->items)) {
            return null;
        }

        return $this->items[array_key_first($this->items)];
    }

    public function get(string $name): ?FieldDto
    {
        return $this->items[$name] ?? null;
    }

    public function set(FieldDto $field): void
    {
        $this->items[$field->getName()] = $field;
    }

    public function unset(FieldDto $field): void
    {
        unset($this->items[$field->getName()]);
    }

    public function add($field)
    {
        if (\is_string($field)) {
            $field = Field::init($field, $field);
        }
        $dto = $field->getDto();
        $this->set($dto);
    }


}
