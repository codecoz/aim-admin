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
 * This base class is for crudboard DTO. This is a base class and contains
 * common methods and attributes of all dto.
 *
 * @author CodeCoz <contact@codecoz.com>
 */
abstract class AbstractHtmlElementDto
{
    // these are the actions applied to a specific row
    public const TYPE_ROW = 'row';
    // these are the actions that are not associated to an crud board
    // (they are available only in the INDEX page)
    public const TYPE_CRUD_BOARD = 'crud_board';
    // these are actions that can be applied to one or more rows at the same time
    public const TYPE_BATCH = 'batch';

    public const TYPE_FORM = 'form';

    public const TYPE_SHOW = 'show';

    // these are actions that can be applied to filter
    public const TYPE_FILTER = 'filter';

    public const INPUT_TYPE_HIDDEN = 'hidden';
    public const INPUT_TYPE_FILE = 'file';

    public const GRID_DELETE_ACTION = 'grid-delete';

    private ?string $name = null;
    private $label;
    private $help;
    private ?string $icon = null;
    private string $cssClass = '';
    private ?string $textAlign = null;
    private OptionValueStore $htmlAttributes;
    private ?string $htmlElement = null;
    private $formatValueCallable;
    private $formattedValue;
    private $displayCallable;
    private string $component;
    private ?bool $disable = null;
    private ?bool $readonly = null;
    private ?string $placeholder = null;
    private mixed $value = null;
    private ?string $layoutClass = null;
    private bool $required = false;
    private OptionValueStore $options;

    public function __construct()
    {
        $this->htmlAttributes = OptionValueStore::init();
        $this->options = OptionValueStore::init();

    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getLabel()
    {
        return $this->label;
    }

    public function getValue(): mixed
    {
        return $this->value;
    }

    public function setValue(mixed $value): void
    {
        $this->value = $value;
    }

    public function setLabel(mixed $label): void
    {
        $this->label = \is_string($label) ? \ucwords(\str_replace('_', ' ', $label)) : $label;
    }

    public function getCssClass(): string
    {
        return $this->cssClass;
    }

    public function setCssClass(string $cssClass): void
    {
        $this->cssClass = $cssClass;
    }

    public function getComponent(): string
    {
        return $this->component;
    }

    public function setComponent(string $component): void
    {
        $this->component = $component;
    }

    public function getFormatValueCallable(): ?callable
    {
        return $this->formatValueCallable;
    }

    public function setFormatValueCallable(?callable $callable): void
    {
        $this->formatValueCallable = $callable;
    }

    public function getFormattedValue(): mixed
    {
        $this->formattedValue = ($this->formatValueCallable && $this->value) ? \call_user_func($this->formatValueCallable, $this->value)
            : $this->value ?? $this->formattedValue;
        return $this->formattedValue;
    }

    public function setFormattedValue(mixed $formattedValue): void
    {
        $this->formattedValue = $formattedValue;
    }

    public function getTextAlign(): ?string
    {
        return $this->textAlign;
    }

    public function setTextAlign(string $textAlign): void
    {
        $this->textAlign = $textAlign;
    }

    public function shouldBeDisplayedFor(mixed $row): bool
    {
        return null === $this->displayCallable || (bool)\call_user_func($this->displayCallable, $row);
    }

    public function setDisplayCallable(callable $displayCallable): void
    {
        $this->displayCallable = $displayCallable;
    }

    public function isDisabled(): ?bool
    {
        return $this->disable;
    }

    public function setDisable(bool $disable): void
    {
        $this->disable = $disable;
    }

    public function isReadonly(): ?bool
    {
        return $this->readonly;
    }

    public function setReadonly(bool $readonly): void
    {
        $this->readonly = $readonly;
    }

    public function isRequired(): ?bool
    {
        return $this->required;
    }

    public function setRequired(bool $required): void
    {
        $this->required = $required;
    }


    public function getHtmlElement(): string
    {
        return $this->htmlElement;
    }

    public function setHtmlElement(string $htmlElement): void
    {
        $this->htmlElement = $htmlElement;
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

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function setIcon(?string $icon): void
    {
        $this->icon = $icon;
    }

    public function getHelp(): string|null
    {
        return $this->help;
    }

    public function setHelp(string $help): void
    {
        $this->help = $help;
    }

    public function getAttributesAsHtml(): string
    {
        $html = '';
        $attributes = $this->htmlAttributes->get();
        foreach ($attributes as $attr => $val) {
            $html .= $this->prepareHtmlAttributes($attr, $val);
        }
        //  echo $html;
        return $html;
    }

    private function prepareHtmlAttributes(string $attr, mixed $val): string
    {
        $html = '';
        switch (strtolower($attr)) {
            case 'class':
                $this->cssClass .= " $val ";
                break;
            case 'readonly':
                $this->readonly = (bool)$val;
                break;
            case 'disabled':
                $this->disable = (bool)$val;
                break;
            case 'required':
                $this->required = (bool)$val;
                break;
            case 'placeholder':
                $this->placeholder = $val;
                break;
            default:
                $html = $attr . '="' . $val . '"';
        }
        return $html;
    }


    public function setPlaceholder(string $placeholder): void
    {
        $this->placeholder = $placeholder;
    }

    public function getPlaceholder(): ?string
    {
        return $this->placeholder;
    }

    public function setLayoutClass(string $class): void
    {
        $this->layoutClass = $class;
    }

    public function getLayoutClass(): ?string
    {
        return $this->layoutClass;
    }

    public function getOption($name): mixed
    {
        return $this->options->get($name);
    }

    public function setOption(mixed $name, mixed $value): void
    {
        $this->options->set($name, $value);
    }

}
