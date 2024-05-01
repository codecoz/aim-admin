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

use CodeCoz\AimAdmin\Collection\FieldCollection;

/**
 * This class is for creating chai select field .
 *
 * @author CodeCoz <contact@codecoz.com>
 */
final class ChainSelectField
{
    use FormFieldTrait;

    public static function init(iterable $fields, string $route, ?string $name = null): self
    {
        foreach ($fields as $key => $child) {
            $prefix = $name ? $name . '-' : "";
            $prefix .= 'chain-';
            if (isset($fields[($key + 1)])) {
                $child->setCustomOption('dependant', $prefix . ($key + 1));
            }
            $child->setAttribute('data-chain-select', $prefix . $key);
        }
        $children = FieldCollection::init($fields);
        return (new self())
            ->setName($name ?? 'chain')
            ->setComponent('aimadmin::crudboard.fields.chainselect')
            ->setCustomOption('dependant-route', $route)
            ->setCustomOption('children', $children);

    }

}
