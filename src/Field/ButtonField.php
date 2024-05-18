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

use function Symfony\Component\String\u;
use CodeCoz\AimAdmin\Dto\CrudBoard\ActionDto;

/**
 * This class is for field creation in crudboard  .
 *
 * @author CodeCoz <contact@codecoz.com>
 */
final class ButtonField
{
    public const DELETE = 'delete';
    public const DETAIL = 'detail';
    public const EDIT = 'edit';
    public const INDEX = 'index';
    public const NEW = 'new';


    private ActionDto $dto;

    private function __construct(ActionDto $actionDto)
    {
        $this->dto = $actionDto;
    }

    public function __toString()
    {
        return $this->dto->getName();
    }

    /**
     * @param string $name
     * @param mixed $label Use FALSE to hide the label; use NULL to autogenerate it
     * @param mixed ...$prarms
     * @return ButtonField
     */
    public static function init(string $name, ?string $label = null, mixed ...$prarms): self
    {
        $dto = new ActionDto();
        $dto->setType($params['type'] ?? ActionDto::TYPE_ROW);
        $dto->setName($name);
        $dto->setValue($name);
        $dto->setLabel($label);
        $dto->setComponent('aim-admin::crudboard.actions.grid-button');
        switch ($name) {
            case self::EDIT :
                $dto->setIcon('fa-pen-to-square');
                $dto->setCssClass('btn btn-block btn-sm btn-primary');
                break;
            case self::DELETE :
                $dto->setIcon('fa-times');
                $dto->setOption('role', ActionDto::GRID_DELETE_ACTION);
                $dto->setCssClass('btn btn-block btn-sm btn-danger');
                $dto->setComponent('aim-admin::crudboard.actions.grid-delete-button');
                break;
            case self::DETAIL :
                $dto->setIcon('fa-file-lines');
                $dto->setCssClass('btn btn-block btn-sm btn-info');
                break;
            default:
                $dto->setCssClass('btn btn-block btn-primary btn-sm');
                break;
        }
        isset($params['icon']) && $dto->setIcon($params['icon']);
        isset($params['cssClass']) && $dto->setCssClass($params['cssClass']);
        $dto->setHtmlElement('a');
        $dto->setHtmlAttribute('title', $label ?? self::humanizeString($name));
        return new self($dto);
    }

    public function createAsCrudBoardAction(): self
    {
        $this->dto->setType(ActionDto::TYPE_CRUD_BOARD);
        $this->dto->setCssClass('btn btn-primary');
        $this->iconForNew();
        $this->dto->setComponent('aim-admin::crudboard.actions.board-action');
        return $this;
    }

    public function iconForNew(): self
    {
        $this->dto->setIcon('fa-plus');
        return $this;
    }

    public function createAsBatchAction(): self
    {
        $this->dto->setType(ActionDto::TYPE_BATCH);
        return $this;
    }

    public function createAsFormAction(): self
    {
        $this->dto->setType(ActionDto::TYPE_FORM);
        $this->dto->setCssClass('btn btn-secondary');
        $label = $this->dto->getLabel() ?? $this->dto->getHtmlAttributes()->get('title');
        $this->dto->setLabel($label);
        $this->dto->setComponent("aim-admin::crudboard.actions.form-action");
        return $this;
    }

    public function createAsFilterAction(): self
    {
        $this->dto->setType(ActionDto::TYPE_FILTER);
        $this->dto->setCssClass('btn btn-secondary');
        $this->setComponent("aim-admin::crudboard.actions.filter-action");
        return $this;
    }

    public function createAsFilterSubmitAction(): self
    {
        $this->dto->setType(ActionDto::TYPE_FILTER);
        $this->dto->setCssClass('btn btn-success float-right');
        $this->dto->setHtmlElement('button');
        $this->setHtmlAttributes(['type' => 'submit'])
            ->setComponent("aim-admin::crudboard.actions.filter-action");
        return $this;
    }

    public function createAsFormSubmitAction(): self
    {
        $this->dto->setType(ActionDto::TYPE_FORM);
        $this->dto->setHtmlElement('button');
        $this->dto->setCssClass('btn float-right btn-primary');
        $label = $this->dto->getLabel() ?? $this->dto->getHtmlAttributes()->get('title');
        $this->dto->setLabel($label);
        $this->setHtmlAttributes(['type' => 'submit'])
            ->setComponent("aim-admin::crudboard.actions.form-action");
        return $this;
    }

    public function createAsShowAction(): self
    {
        $this->dto->setType(ActionDto::TYPE_SHOW);
        $this->dto->setCssClass('btn btn-secondary');
        $this->dto->setComponent('aim-admin::crudboard.actions.show-button');
        return $this;
    }

    /**
     * @param mixed $label Use FALSE to hide the label; use NULL to autogenerate it
     */
    public function setLabel(string|false|null $label): self
    {
        $this->dto->setLabel($label ?? self::humanizeString($this->dto->getName()));
        return $this;
    }

    public function setIcon(?string $icon): self
    {
        $this->dto->setIcon($icon);

        return $this;
    }

    public function removeCssClass(string $cssClass): self
    {
        $classStr = $this->dto->getCssClass();
        if ($classStr) {
            $classes = explode(' ', $classStr);
            $newClasses = array_filter($classes, function ($value) use ($cssClass) {
                return (trim($value) != $cssClass);
            });
            $this->dto->setCssClass(implode(' ', $newClasses));
        }
        return $this;
    }

    /**
     * If you set your own CSS classes, the default CSS classes are not applied.
     * You may want to also add the 'btn' (and 'btn-primary', etc.) classes to make
     * your action look like a button.
     */
    public function setCssClass(string $cssClass): self
    {
        $this->dto->setCssClass($cssClass);
        return $this;
    }

    /**
     * If you add a custom CSS class, the default CSS classes are not applied.
     * You may want to also add the 'btn' (and 'btn-primary', etc.) classes to make
     * your action look like a button.
     */
    public function addCssClass(string $cssClass): self
    {
        $this->dto->setCssClass(trim($this->dto->getCssClass() . ' ' . $cssClass));

        return $this;
    }

    public function displayAsLink(): self
    {
        $this->dto->setHtmlElement('a');
        return $this;
    }

    public function displayAsButton(): self
    {
        $this->dto->setHtmlElement('button');

        return $this;
    }

    public function setHtmlAttributes(array $attributes): self
    {
        $this->dto->setHtmlAttributes($attributes);

        return $this;
    }

    public function setComponent(string $component): self
    {
        $this->dto->setComponent($component);

        return $this;
    }

    /**
     * @param string $routeName
     * @param array|\Closure $routeParameters The callable has the signature: function ($row): array
     *
     * Route parameters can be defined as a callable with the signature: function ($entityInstance): array
     * Example: ->linkToRoute('invoice_send', fn (Invoice $entity) => ['uuid' => $entity->getId()]);
     * @return ButtonField
     */
    public function linkToRoute(string $routeName, array|\Closure $routeParameters = []): self
    {
        $this->dto->setRouteName($routeName);
        $this->dto->setRouteParameters($routeParameters);
        return $this;
    }

    public function linkToUrl(string|callable $url): self
    {

        $this->dto->setUrl($url);
        return $this;
    }

    public function displayIf(callable $callable): self
    {
        $this->dto->setDisplayCallable($callable);
        return $this;
    }

    public function getDto(): ActionDto
    {
        // if (null === $this->dto->getLabel() || null === $this->dto->getIcon()) {
        //     throw new \InvalidArgumentException(sprintf('The label or icon of an action cannot be null at the same time. Either set the label, the icon or both for the "%s" action.', $this->dto->getName()));
        // }
        return $this->dto;
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

    public function setTitle(string $title): self
    {
        $this->dto->setHtmlAttribute('title', $title);
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

    public function asModal(): self
    {
        $this->dto->setHtmlAttributes(['data-target' => '#cc-modal', 'data-toggle' => 'modal']);
        $this->dto->setCssClass(trim($this->dto->getCssClass() . ' cc-modal'));
        return $this;
    }
}
