<?php

declare(strict_types=1);

/*
 * This file is part of the AimAdmin package.
 *
 * (c) CodeCoz <contact@codecoz.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CodeCoz\AimAdmin\Field;

use CodeCoz\AimAdmin\Collection\FieldCollection;

/**
 * This class is for creating text field .
 *
 * @author Muhammad Abdullah Ibne Masud <abdullah.masud@banglalink.net>
 */
final class FieldGroup
{
    use FormFieldTrait;

    public static function init(iterable $fields, ?string $name = null, ?string $label = null): self
    {
        $fields = FieldCollection::init($fields);

        return (new self())
            ->setCssClass('border rounded m-auto row')
            ->setComponent('aim-admin::crudboard.fields.group')
            ->setName($name ?? 'group')
            ->setLabel($label ?? $name ?? 'Group')
            ->setCustomOption('fields', $fields);
    }

}
