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
final class InputField implements FieldInterface
{
    use FormFieldTrait;

    public static function init(string $name, ?string $label = null, ...$params): self
    {
        $type = isset($params[0]) ? $params[0] : (isset($params['type']) ? $params['type'] : 'text');
        $value = isset($params[1]) ? $params[1] : (isset($params['value']) ? $params['value'] : null);
        return (new self())
            ->setName($name)
            ->setComponent('aimadmin::crudboard.fields.input')
            ->setHtmlElementName('input')
            ->setPlaceholder($label ?? self::humanizeString($name))
            ->setInputType($type)
            ->setLabel($label ?? self::humanizeString($name))
            ->setDefaultValue($value);
    }


}
