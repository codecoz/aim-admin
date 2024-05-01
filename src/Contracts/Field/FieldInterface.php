<?php declare(strict_types=1);

/*
 * This file is part of the Aim Admin package.
 *
 * (c) CodeCoz <contact@codecoz.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CodeCoz\AimAdmin\Contracts\Field;

/**
 * This interface defines blueprints of field for curd boad components i.e. grid, form and filters
 *
 *
 * @author CodeCoz <contact@codecoz.com>
 */
interface FieldInterface
{
    public static function init(string $name, ?string $label = null, mixed ...$params): self;

}
