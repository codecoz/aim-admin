<?php declare(strict_types=1);

/*
 * This file is part of the Aim Admin package.
 *
 * (c) CodeCoz <contact@codecoz.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CodeCoz\AimAdmin\Dto\CrudBoard;


use CodeCoz\AimAdmin\Contracts\Field\FieldInterface;


/**
 * This class is for action DTO of grid board .
 *
 * @author CodeCoz <contact@codecoz.com>
 */
final class ActionDto extends AbstractHtmlElementDto
{
    private ?string $type = null;
    private $url;
    private ?string $routeName = null;
    private array $routeParameters = [];

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function getUrl(): string|callable
    {
        return $this->url;
    }

    public function setUrl(string|callable $url): void
    {
        $this->url = $url;
    }

    public function isRowAction(): bool
    {
        return self::TYPE_ROW === $this->type;
    }

    public function isCrudBoardAction(): bool
    {
        return self::TYPE_CRUD_BOARD === $this->type;
    }

    public function isBatchAction(): bool
    {
        return self::TYPE_BATCH === $this->type;
    }

    public function isFormAction(): bool
    {
        return self::TYPE_FORM === $this->type;
    }

    public function isShowAction(): bool
    {
        return self::TYPE_SHOW === $this->type;
    }

    public function isGridDeleteAction(): bool
    {
        return self::GRID_DELETE_ACTION == $this->getOption('role');
    }

    public function getRouteName(): ?string
    {
        return $this->routeName;
    }

    public function setRouteName(string $routeName): void
    {
        $this->routeName = $routeName;
    }

    public function getRouteParameters(): array|\Closure
    {
        return $this->routeParameters;
    }

    public function setRouteParameters(array|\Closure $routeParameters): void
    {
        $this->routeParameters = $routeParameters;
    }

    public function isSubmitAction(): bool
    {
        return $this->getHtmlAttributes()->get('type', '') === 'submit';
    }

    public function isFilterAction(): bool
    {
        return self::TYPE_FILTER === $this->type;
    }


}
