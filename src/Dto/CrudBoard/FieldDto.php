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

namespace CodeCoz\AimAdmin\Dto\CrudBoard;

use CodeCoz\AimAdmin\Support\OptionValueStore;

/**
 * This class is for field creation in crudboard  .
 *
 * @author CodeCoz <contact@codecoz.com>
 */
final class FieldDto
{
    private ?string $name = null;
    private mixed $value = null;
    private mixed $formattedValue = null;
    private $formatValueCallable;
    private string $label;
    private string $cssClass = '';
    private ?string $textAlign = null;
    private ?string $help;
    private ?bool $sortable = null;
    private ?bool $virtual = null;
    private ?string $component = null;
    private ?bool $hidden = null;
    private ?bool $disable = null;
    private ?string $inputType = null;
    private OptionValueStore $customOptions;
    private string $validationRule = '';
    private string $placeholder;
    private OptionValueStore $htmlAttributes;

    public function __construct()
    {
        $this->customOptions = OptionValueStore::init();
        $this->htmlAttributes = OptionValueStore::init();

    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getValue(): mixed
    {
        return $this->value;
    }

    public function setValue(mixed $value): void
    {
        $this->value = $value;
    }


    public function getLabel()
    {
        return $this->label;
    }

    public function setLabel($label): void
    {
        $this->label = \ucwords(\str_replace('_', ' ', $label));
    }

    public function getFormatValueCallable(): ?callable
    {
        return $this->formatValueCallable;
    }

    public function setFormatValueCallable(?callable $callable): void
    {
        $this->formatValueCallable = $callable;
    }

    public function getTextAlign(): ?string
    {
        return $this->textAlign;
    }

    public function setTextAlign(string $textAlign): void
    {
        $this->textAlign = $textAlign;
    }

    public function getCssClass(): string
    {
        return $this->cssClass;
    }

    public function setCssClass(string $cssClass): void
    {
        $this->cssClass = trim($cssClass);
    }

    public function getComponent(): ?string
    {
        return $this->component;
    }

    public function setComponent(?string $component): void
    {
        $this->component = $component;
    }

    public function getHelp(): string|null
    {
        return $this->help;
    }

    public function setHelp(string $help): void
    {
        $this->help = $help;
    }

    public function isSortable(): ?bool
    {
        return $this->sortable;
    }

    public function setSortable(bool $isSortable): void
    {
        $this->sortable = $isSortable;
    }

    public function isHidden(): ?bool
    {
        return $this->hidden;
    }

    public function setHidden(bool $hidden): void
    {
        $this->hidden = $hidden;
    }

    public function isDisabled(): ?bool
    {
        return $this->disable;
    }

    public function setDisable(bool $disable): void
    {
        $this->disable = $disable;
    }

    public function isVirtual(): ?bool
    {
        return $this->virtual;
    }

    public function setVirtual(bool $isVirtual): void
    {
        $this->virtual = $isVirtual;
    }

    public function getFormattedValue(): mixed
    {
        return $this->formattedValue;
    }

    public function setFormattedValue(mixed $formattedValue): void
    {
        $this->formattedValue = $formattedValue;
    }

    public function setInputType(string $inputType): void
    {
        $this->inputType = $inputType;
    }

    public function getInputType(): ?string
    {
        return $this->inputType;
    }

    public function setCustomOptions(array $customOptions): void
    {
        $this->customOptions = OptionValueStore::init($customOptions);
    }

    public function setCustomOption(string $optionName, mixed $optionValue): void
    {
        $this->customOptions->set($optionName, $optionValue);
    }

    public function getCustomOption(string $optionName): string|int|null
    {
        return $this->customOptions->get($optionName);
    }

    public function getCustomOptions(): mixed
    {
        return $this->customOptions->all();
    }

    public function setValidationRule(string $rule): void
    {
        $this->validationRule = $rule;
    }

    public function getValidationRule(): string
    {
        return $this->validationRule;
    }

    public function getHtmlAttributes(): OptionValueStore
    {
        return $this->htmlAttributes;
    }

    public function addHtmlAttributes(array $htmlAttributes): void
    {
        $this->htmlAttributes->add($this->htmlAttributes, $htmlAttributes);
    }

    public function setHtmlAttributes(array $htmlAttributes): void
    {
        $this->htmlAttributes->set($htmlAttributes);
    }

    public function setHtmlAttribute(string $attributeName, mixed $attributeValue): void
    {
        $this->htmlAttributes->set($attributeName, $attributeValue);
    }

    public function getAttributesAsHtml(): string
    {
        $html = '';
        $attributes = $this->htmlAttributes->get();
        foreach ($attributes as $attr => $val) {
            $html .= $this->prepareHtmlAttributes($attr, $val);
        }
        return $html;
    }

    private function prepareHtmlAttributes(string $attr, mixed $val): string
    {
        $html = '';
        switch (strtolower($attr)) {
            case 'class':
                $this->cssClass .= " $val ";
                break;
            case 'disabled':
                $this->disable = (bool)$val;
                break;
            case 'placeholder':
                $this->placeholder = $val;
                break;
            default:
                $html = " $attr =  $val ";
        }
        return $html;
    }

}
