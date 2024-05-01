<?php

namespace CodeCoz\AimAdmin;

class Admin
{
    // Build wonderful Aim Admin Package

    public static function packagePath($path): string
    {
        return __DIR__ . "/../$path";
    }

    static function sortMenusByDisplayOrder(array $menuArray): array
    {
        uasort($menuArray, function ($a, $b) {
            if ($a['displayOrder'] == 1 && $b['displayOrder'] != 1) {
                return -1;
            } elseif ($b['displayOrder'] == 1 && $a['displayOrder'] != 1) {
                return 1;
            } elseif ($a['displayOrder'] == 0) {
                return 1;
            } elseif ($b['displayOrder'] == 0) {
                return -1;
            }
            return $a['displayOrder'] <=> $b['displayOrder'];
        });
        return $menuArray;
    }

    static function processMenuItem($menuItem): array
    {
        $menuData = [
            'text' => $menuItem['title'],
            'url' => $menuItem['url'],
            'applicationID' => $menuItem['applicationID'],
            'class' => $menuItem['class'] ?? '',
            'active' => [$menuItem['url']],
        ];

        if (isset($menuItem['iconName']) && $menuItem['iconName'] !== "") {
            $menuData['icon'] = 'fa fa-' . $menuItem['iconName'];
        }

        if (!empty($menuItem['children'])) {
            // Use 'processMenuItem' directly for recursion
            $menuData['submenu'] = array_map(function ($item) {
                return self::processMenuItem($item);
            }, $menuItem['children']);
        }

        return $menuData;
    }

}
