<?php

namespace App\View;

use App\Models\MstMenu;
use Illuminate\Support\Facades\Request;

class MenuViewHelper
{
    /**
     * Determine the parent menu code of the currently active route.
     */
    public static function activeParentMenuCode(): ?int
    {
        $path = trim(Request::path(), '/');

        $child = MstMenu::query()
            ->where('menuparent', '!=', 0)
            ->where('is_active', 1)
            ->whereNotNull('menulink')
            ->get()
            ->first(function ($menu) use ($path) {
                $linkPath = trim(ltrim($menu->menulink, '/'), '/');

                return $path === $linkPath || str_starts_with($path, $linkPath.'/');
            });

        if ($child) {
            return (int) $child->menuparent;
        }

        $parent = MstMenu::query()
            ->where('menuparent', 0)
            ->where('is_active', 1)
            ->where('menutype', 'link')
            ->whereNotNull('menulink')
            ->get()
            ->first(function ($menu) use ($path) {
                $linkPath = trim(ltrim($menu->menulink, '/'), '/');

                return $path === $linkPath;
            });

        return $parent ? (int) $parent->menucode : null;
    }
}
