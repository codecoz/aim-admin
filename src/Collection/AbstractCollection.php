<?php declare(strict_types=1);

/*
 * This file is part of the Aim Admin package.
 *
 * (c) CodeCoz <contact@codecoz.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CodeCoz\AimAdmin\Collection;


/**
 * This class is a collection abstract class abstract.
 *
 * @author CodeCoz <contact@codecoz.com>
 */
abstract class AbstractCollection implements \ArrayAccess, \Countable, \IteratorAggregate
{
    protected array $items;

    abstract function offsetGet(mixed $offset): mixed;

    public function isEmpty(): bool
    {
        return 0 === \count($this->items);
    }

    public function offsetExists(mixed $offset): bool
    {
        return \array_key_exists($offset, $this->items);
    }


    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->items[$offset] = $value;
    }

    public function offsetUnset(mixed $offset): void
    {
        unset($this->items[$offset]);
    }

    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->items);
    }

    public function count(): int
    {
        return \count($this->items);
    }

    public function all(): array
    {
        return $this->items;
    }

}
