<?php

declare(strict_types=1);

namespace CodeCoz\AimAdmin\MenuBuilder;

/**
 * TODO: On the future, all menu items should have a type property. We can use
 * the type property to easy distinguish the item type and avoid guessing it by
 * they properties.
 */
class MenuItemHelper
{
    /**
     * Check if a menu item is a header.
     *
     * @param mixed $item
     * @return bool
     */
    public static function isHeader($item): bool
    {
        return is_string($item) || isset($item['header']);
    }


    /**
     * Check if a menu item is a link.
     *
     * @param mixed $item
     * @return bool
     */
    public static function isLink($item): bool
    {
        return !isset($item['submenu']);
    }

    /**
     * Check if a menu item is a submenu.
     *
     * @param mixed $item
     * @return bool
     */
    public static function isSubmenu($item): bool
    {
        return isset($item['submenu']) &&
            is_array($item['submenu']);
    }

    /**
     * Check if a menu item is allowed to be shown (not restricted).
     *
     * @param mixed $item
     * @return bool
     */
    public static function isAllowed($item)
    {
        return $item && empty($item['restricted']);
    }

}
