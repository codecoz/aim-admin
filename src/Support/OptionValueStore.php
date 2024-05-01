<?php declare(strict_types=1);

/*
 * This file is part of the Aim Admin package.
 *
 * (c) CodeCoz <contact@codecoz.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CodeCoz\AimAdmin\Support;

use Countable;

final class OptionValueStore implements Countable
{
    private array $container = [];

    protected $delimiter = '.';

    private function __construct(array $options, $delimiter)
    {
        $this->container = $options;
        $this->delimiter = $delimiter;
    }

    public static function init(array $options = [], $delimiter = '.'): self
    {
        return new self($options, $delimiter);
    }

    public function all(): array
    {
        return $this->container;
    }

    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }

    protected function exists($array, $key)
    {
        return \array_key_exists($key, $array);
    }

    public function count(): int
    {
        return \count($this->all());
    }

    public function isEmpty(): bool
    {
        return 0 === $this->count();
    }

    public function has($keys)
    {
        $keys = (array)$keys;

        if (!$this->container || $keys === []) {
            return false;
        }

        foreach ($keys as $key) {
            $items = $this->container;

            if ($this->exists($items, $key)) {
                continue;
            }

            foreach (explode($this->delimiter, $key) as $segment) {
                if (!is_array($items) || !$this->exists($items, $segment)) {
                    return false;
                }

                $items = $items[$segment];
            }
        }

        return true;
    }

    public function get($key = null, $default = null)
    {
        if (\is_null($key)) {
            return $this->container;
        }

        if ($this->exists($this->container, $key)) {
            return $this->container[$key];
        }

        if (\strpos($key, $this->delimiter) === false) {
            return $default;
        }

        $items = $this->container;

        foreach (\explode($this->delimiter, $key) as $segment) {
            if (!\is_array($items) || !$this->exists($items, $segment)) {
                return $default;
            }

            $items = &$items[$segment];
        }

        return $items;
    }

    public function set($keys, $value = null): void
    {
        if (\is_array($keys)) {
            foreach ($keys as $key => $value) {
                $this->set($key, $value);
            }

            return;
        }

        $items = &$this->container;

        foreach (\explode($this->delimiter, $keys) as $key) {
            if (!isset($items[$key]) || !\is_array($items[$key])) {
                $items[$key] = [];
            }

            $items = &$items[$key];
        }

        $items = $value;
    }

    public function setIfNotSet(string $key, mixed $value): void
    {
        if (!$this->has($key)) {
            $this->set($key, $value);
        }
    }

    public function add($keys, $value = null)
    {
        if (is_array($keys)) {
            foreach ($keys as $key => $value) {
                $this->add($key, $value);
            }
        } elseif ($this->get($keys) === null) {
            $this->set($keys, $value);
        }

        return $this;
    }

    public function keyValueExists($key, $value): bool
    {
        $keyValues = $this->get($key);
        if ($keyValues) {
            return is_array($keyValues) ? \in_array($value, $keyValues) : ($keyValues == $value);
        }
        return false;
    }

    public function renderAsHtmlAttributes(): string
    {
        $html = "";
        foreach ($this->all() as $key => $value) {
            $html .= "$key='$value'";
        }
        return $html;
    }


}
