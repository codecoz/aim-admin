<?php declare(strict_types=1);

namespace CodeCoz\AimAdmin\MenuBuilder;

class SidebarItemHelper extends MenuItemHelper
{


    /**
     * Check if a menu item is accepted for the sidebar section.
     *
     * @param mixed $item
     * @return bool
     */
    public static function isAcceptedItem($item)
    {
        return self::isSubmenu($item) ||
            self::isLink($item);
    }

    /**
     * Check if a menu item is valid for the sidebar.
     *
     * @param mixed $item
     * @return bool
     */
    public static function isValidItem($item)
    {
        return self::isAcceptedItem($item);
    }
}
