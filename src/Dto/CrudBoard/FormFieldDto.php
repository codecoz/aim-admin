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

final class FormFieldDto extends AbstractHtmlElementDto
{
    private OptionValueStore $customOptions;
    private $validationRule;
    private ?string $inputType = null;

    public function __construct()
    {
        parent::__construct();
        $this->customOptions = OptionValueStore::init();
    }

    public function setCustomOptions(array $customOptions): void
    {
        $this->customOptions->set($customOptions);
    }

    public function setCustomOption(string $optionName, mixed $optionValue): void
    {
        $this->customOptions->set($optionName, $optionValue);
    }

    public function getCustomOptions(): array
    {
        return $this->customOptions->all();
    }

    public function getCustomOptionStore(): OptionValueStore
    {
        return $this->customOptions;
    }

    public function getCustomOption(string $optionName): mixed
    {
        return $this->customOptions->get($optionName);
    }

    public function setValidationRule(array|string $rules)
    {
        $this->validationRule = $rules;
    }

    public function getValidationRule(): null|array|string
    {
        return $this->validationRule;
    }

    public function setInputType(string $inputType): void
    {
        $this->inputType = $inputType;
    }

    public function getInputType(): ?string
    {
        return $this->inputType;
    }

    public function isHiddenInput()
    {
        return $this->inputType == self::INPUT_TYPE_HIDDEN;
    }

    public function isFileInput()
    {
        return $this->inputType == self::INPUT_TYPE_FILE;
    }

}
