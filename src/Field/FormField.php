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

use CodeCoz\AimAdmin\Contracts\Field\FieldInterface;

/**
 * This class is for field creation in crudboard  .
 *
 * @author Muhammad Abdullah Ibne Masud <abdullah.masud@banglalink.net>
 */

final class FormField implements FieldInterface
{
    use FieldTrait;

    public static function init(string $name, ?string $label = null, ...$params): self
    {
        return (new self())
        ->setName($name)
        ->setLabel($label);
    }

}
