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

use CodeCoz\AimAdmin\Dto\CrudBoard\FieldDto;

use function Symfony\Component\String\u;

/**
 * This is a trait for field  .
 *
 * @author Muhammad Abdullah Ibne Masud <abdullah.masud@banglalink.net>
 */
trait FieldTrait
{
    private FieldDto $dto;

    private function __construct()
    {
        $this->dto = new FieldDto();
    }

    public function setName(string $name): self
    {
        $this->dto->setName($name);

        return $this;
    }

    public function setInputType(string $inputType): self
    {
        $this->dto->setInputType($inputType);

        return $this;
    }

    public function setLabel(string|false|null $label): self
    {
        $this->dto->setLabel($label ?? self::humanizeString($this->dto->getName()));

        return $this;
    }

    public function setFormattedValue($value): self
    {
        $this->dto->setFormattedValue($value);

        return $this;
    }

    public function formatValue(?callable $callable): self
    {
        $this->dto->setFormatValueCallable($callable);

        return $this;
    }

    public function setVirtual(bool $isVirtual): self
    {
        $this->dto->setVirtual($isVirtual);

        return $this;
    }

    public function setDisabled(bool $disabled = true): self
    {
        $this->dto->setDisable($disabled);
        return $this;
    }

    public function setComponent(string $component): self
    {
        $this->dto->setComponent($component);
        return $this;
    }

    public function setHelp(string $help): self
    {
        $this->dto->setHelp($help);
        return $this;
    }

    public function addCssClass(string $cssClass): self
    {
        $this->dto->setCssClass($this->dto->getCssClass() . ' ' . $cssClass);
        return $this;
    }

    public function setCssClass(string $cssClass): self
    {
        $this->dto->setCssClass($cssClass);
        return $this;
    }

    public function getDto(): FieldDto
    {
        return $this->dto;
    }

    public function setCustomOption(string $optionName, $optionValue): self
    {
        $this->dto->setCustomOption($optionName, $optionValue);

        return $this;
    }

    public function setCustomOptions(array $options): self
    {
        $this->dto->setCustomOptions($options);

        return $this;
    }

    private static function humanizeString(string $string): string
    {
        $uString = u($string);
        $upperString = $uString->upper()->toString();

        // this prevents humanizing all-uppercase labels (e.g. 'UUID' -> 'U u i d')
        // and other special labels which look better in uppercase
        if ($uString->toString() === $upperString) {
            return $upperString;
        }

        return $uString
            ->replaceMatches('/([A-Z])/', '_$1')
            ->replaceMatches('/[_\s]+/', ' ')
            ->trim()
            ->lower()
            ->title(true)
            ->toString();
    }

    public function setStyle(string $style): self
    {
        $this->dto->setHtmlAttribute('style', $style);
        return $this;
    }

    public function addStyle(string $style): self
    {
        $this->dto->addHtmlAttributes(['style' => $style]);
        return $this;
    }

}
