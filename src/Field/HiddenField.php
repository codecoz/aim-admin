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
 * This class is for creating text field .
 *
 * @author CodeCoz <contact@codecoz.com>
 */
final class HiddenField implements FieldInterface
{
    use FormFieldTrait;

    public static function init(string $name, ?string $label = null, ...$params): self
    {
        $value = isset($params[0]) ? $params[0] : (isset($params['value']) ? $params['value'] : null);
        return (new self())
            ->setName($name)
            ->setComponent('aim-admin::crudboard.fields.hidden')
            ->setDefaultValue($value);
    }


}
