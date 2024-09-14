<?php declare(strict_types=1);

/*
 * This file is part of the AimAdmin package.
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
 * @author Muhammad Abdullah Ibne Masud <abdullah.masud@banglalink.net>
 */
final class InputField implements FieldInterface
{
    use FormFieldTrait;

    public static function init(string $name, ?string $label = null, ...$params): self
    {
        $type = $params[0] ?? ($params['type'] ?? 'text');
        $value = $params[1] ?? ($params['value'] ?? null);
        return (new self())
        ->setName($name)
        ->setComponent('aim-admin::crudboard.fields.input')
        ->setHtmlElementName('input')
        ->setPlaceholder($label ?? self::humanizeString($name))
        ->setInputType($type)
        ->setLabel($label ?? self::humanizeString($name))
        ->setDefaultValue($value)
        ;
    }




}
