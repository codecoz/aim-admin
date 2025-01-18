<?php

declare(strict_types=1);

namespace CodeCoz\AimAdmin\MenuBuilder\Filters;

use CodeCoz\AimAdmin\MenuBuilder\ActiveChecker;

class ActiveFilter implements FilterInterface
{
    /**
     * The active checker instance.
     *
     * @var ActiveChecker
     */
    protected ActiveChecker $activeChecker;

    /**
     * Constructor.
     *
     * @param ActiveChecker $activeChecker
     */
    public function __construct(ActiveChecker $activeChecker)
    {
        $this->activeChecker = $activeChecker;
    }

    /**
     * Transforms a menu item. Adds the active attribute when suitable.
     *
     * @param array $item A menu item
     * @return array The transformed menu item
     */
    public function transform($item): array
    {
        $item['active'] = $this->activeChecker->isActive($item);

        return $item;
    }
}
