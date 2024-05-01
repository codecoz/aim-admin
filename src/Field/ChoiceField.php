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
final class ChoiceField implements FieldInterface
{
    final const LIST = 'choiceList';
    final const TYPE = 'choiceType';
    final const EMPTY = 'empty';
    final const SELECTED = 'selected';

    use FormFieldTrait;

    public static function init(string $name, ?string $label = null, ...$params): self
    {
        $type = $params[0] ?? ($params[self::TYPE] ?? 'select');
        $choiceList = $params[1] ?? ($params[self::LIST] ?? null);
        $empty = $params[2] ?? ($params[self::EMPTY] ?? null);
        $selected = $params[3] ?? ($params[self::SELECTED] ?? null);
        !$choiceList && throw new \InvalidArgumentException(self::LIST . ':[] is a mandatory  parameter');
        return (new self($type, $choiceList))
            ->setName($name)
            ->setComponent('aimadmin::crudboard.fields.choice')
            ->setLabel($label ?? self::humanizeString($name))
            ->setCustomOption(self::LIST, $choiceList)
            ->setCustomOption(self::EMPTY, $empty)
            ->setDefault($selected)
            ->setInputType($type);

    }

    public function setDefault(mixed $defaultValue): self
    {

        if (is_array($defaultValue)) {
            $this->setAttribute('multiple', false);
            $values = \array_flip($defaultValue);
        } else {
            $values[$defaultValue] = 1;
        }
        $this->setCustomOption(self::SELECTED, $values);
        return $this;
    }


}
