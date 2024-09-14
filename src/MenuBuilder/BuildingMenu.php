<?php declare(strict_types=1);

namespace CodeCoz\AimAdmin\MenuBuilder;

class BuildingMenu
{
    /**
     * The menu builder.
     *
     * @var Builder
     */
    public Builder $menu;

    /**
     * Create a new event instance.
     *
     * @param Builder $menu
     */
    public function __construct(Builder $menu)
    {
        $this->menu = $menu;
    }
}
