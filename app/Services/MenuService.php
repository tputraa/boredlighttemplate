<?php

namespace App\Services;

use App\Models\MstMenu;
use App\Models\Permission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class MenuService
{
    /**
     * Get the cached menus available to the currently authenticated user.
     *
     * @return array<int, array{menucode: int, menuname: string, menulink: string|null, icon: string|null, children: array<int, mixed>}>
     */
    public static function getUserMenus(): array
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        if ($user === null || $user->user_group_id === null) {
            return [];
        }

        $roleId = (int) $user->user_group_id;

        return Cache::remember(self::cacheKey($roleId), now()->addHours(12), function () use ($roleId) {
            $permittedMenuCodes = Permission::query()
                ->where('user_group_id', $roleId)
                ->where('fview', 1)
                ->pluck('menucode')
                ->all();

            if (empty($permittedMenuCodes)) {
                return [];
            }

            $parents = MstMenu::query()
                ->where('menuparent', 0)
                ->where('is_active', 1)
                ->whereIn('menucode', $permittedMenuCodes)
                ->orderBy('idx')
                ->get();

            $menus = [];

            foreach ($parents as $parent) {
                $children = MstMenu::query()
                    ->where('menuparent', $parent->menucode)
                    ->where('is_active', 1)
                    ->whereIn('menucode', $permittedMenuCodes)
                    ->orderBy('idx')
                    ->get()
                    ->toArray();

                if ($parent->menutype === 'parent' && empty($children)) {
                    continue;
                }

                $menus[] = [
                    'menucode' => (int) $parent->menucode,
                    'menuname' => $parent->menuname,
                    'menulink' => $parent->menulink,
                    'icon' => $parent->icon,
                    'menutype' => $parent->menutype,
                    'children' => $children,
                ];
            }

            return $menus;
        });
    }

    /**
     * Clear the menu cache for a specific role.
     */
    public static function clearMenuCacheByRole(int $roleId): void
    {
        Cache::forget(self::cacheKey($roleId));
    }

    /**
     * Clear the menu cache for every known role.
     */
    public static function clearAllMenuCache(): void
    {
        foreach ([1, 2, 3] as $roleId) {
            Cache::forget(self::cacheKey($roleId));
        }
    }

    private static function cacheKey(int $roleId): string
    {
        return "user_menus:{$roleId}";
    }
}
