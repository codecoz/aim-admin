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

use CodeCoz\AimAdmin\Dto\CrudBoard\FormFieldDto;
use CodeCoz\AimAdmin\Field\Field;

/**
 * This class is for field creation in crudboard  .
 *
 * @author CodeCoz <contact@codecoz.com>
 */
final class FormFieldCollection extends AbstractCollection
{
    private function __construct(iterable $fields)
    {
        $this->items = $this->processFields($fields);
    }

    public static function init(iterable $fields): self
    {
        return new self($fields);
    }

    public function offsetGet(mixed $offset): FormFieldDto
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

    public function prepend(FormFieldDto $field): void
    {
        $this->items = \array_unshift($this->items, $field);
    }

    public function first(): ?FormFieldDto
    {
        if (0 === \count($this->items)) {
            return null;
        }

        return $this->items[array_key_first($this->items)];
    }

    public function get(string $name): ?FormFieldDto
    {
        return $this->items[$name] ?? null;
    }

    public function set(FormFieldDto $field): void
    {
        $this->items[$field->getName()] = $field;
    }

    public function unset(FormFieldDto $field): void
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

    public function hasFileInput(): bool
    {
        $result = false;
        foreach ($this->items as $FieldDto) {
            if ($result = $FieldDto->isFileInput()) {
                break;
            }
        }
        return $result;
    }

}
