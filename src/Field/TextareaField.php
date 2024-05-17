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
final class TextareaField implements FieldInterface
{
    public final const ROW = 'rows';
    public final const COL = 'cols';
    private static array $defaultParams = [self::ROW => 2, self::COL => null];

    use FormFieldTrait;

    public static function init(string $name, ?string $label = null, ...$params): self
    {
        $label = $label ?? self::humanizeString($name);
        $finalParams = $params + self::$defaultParams;
        return (new self())
            ->setName($name)
            ->setComponent('aim-admin::crudboard.fields.textarea')
            ->setLabel($label)
            ->setCustomOption(self::ROW, $finalParams[self::ROW])
            ->setPlaceholder($label)
            ->setAttribute('id', $name);
    }

    public function setNumOfRows(int $rows): self
    {
        if ($rows < 1) {
            throw new \InvalidArgumentException(sprintf('The argument of the "%s()" method must be 1 or higher (%d given).', __METHOD__, $rows));
        }
        $this->setCustomOption(self::ROW, $rows);
        return $this;
    }


}
