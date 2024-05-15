<?php declare(strict_types=1);

/*
 * This file is part of the Aim Admin package.
 *
 * (c) CodeCoz <contact@codecoz.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CodeCoz\AimAdmin\Field;

use CodeCoz\AimAdmin\Contracts\Field\FieldInterface;


/**
 * This class is for field creation in crudboard  .
 *
 * @author CodeCoz <contact@codecoz.com>
 */
final class DateTimeField implements FieldInterface
{
    use FormFieldTrait;

    public static function init(string $name, ?string $label = null, ...$params): self
    {
        return (new self())
            ->setName($name)
            ->setLabel($label ?? self::humanizeString($name))
            ->setComponent('aim-admin::crudboard.fields.datetime')
            ->formatValue(fn($value): string => (new \DateTime($value))->format('Y-m-d'));
    }


}
