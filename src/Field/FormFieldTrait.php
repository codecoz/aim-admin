<?php

declare(strict_types=1);

/*
 * This file is part of the Aim Admin package.
 *
 * (c) CodeCoz <contact@codecoz.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CodeCoz\AimAdmin\Field;

use CodeCoz\AimAdmin\Dto\CrudBoard\FormFieldDto;

use function Symfony\Component\String\u;

/**
 * This is a trait for field  .
 *
 * @author CodeCoz <contact@codecoz.com>
 */
trait FormFieldTrait
{
    private FormFieldDto $dto;

    private function __construct()
    {
        $this->dto = new FormFieldDto();
        $this->setLayoutClass('col-lg-6');
    }

    public function setName(string $name): self
    {
        $this->dto->setName($name);
        return $this;
    }

    public function setHtmlElementName(string $htmlElementName): self
    {
        $this->dto->setHtmlElement($htmlElementName);
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

    public function setDisabled(bool $disabled = true): self
    {
        $this->dto->setDisable($disabled);
        return $this;
    }

    public function setReadonly(bool $readonly = true): self
    {
        $this->dto->setReadonly($readonly);
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

    public function getDto(): FormFieldDto
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

    public function setHtmlAttributes(array $htmlAttributes): self
    {
        $this->dto->setHtmlAttributes($htmlAttributes);

        return $this;
    }

    public function setAttribute(string $name, mixed $value): self
    {
        $this->dto->setHtmlAttribute($name, $value);
        return $this;
    }

    public function getHtmlAttributes(string|null $attributeName)
    {
        return $this->dto->getHtmlAttributes($attributeName);
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

    public function setPlaceholder(string $text): self
    {
        $this->dto->setHtmlAttribute('placeholder', $text);

        return $this;
    }

    public function validate(array|string $rules)
    {
        $this->dto->setValidationRule($rules);
        return $this;
    }

    public function setInputType(string $inputType): self
    {
        $this->dto->setInputType($inputType);
        return $this;

    }

    public function getInputType(): ?string
    {
        return $this->dto->getInputType();

    }

    public function setDefaultValue(?string $value = null): self
    {
        $this->dto->setValue($value);
        return $this;
    }

    public function setLayoutClass(string $class): self
    {
        $this->dto->setLayoutClass($class);
        return $this;
    }

    public function makeHiddenType(): self
    {
        $this->dto->setInputType(FormFieldDto::INPUT_TYPE_HIDDEN);
        return $this;
    }

    public function makeFileType(): self
    {
        $this->dto->setInputType(FormFieldDto::INPUT_TYPE_FILE);
        return $this;
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
