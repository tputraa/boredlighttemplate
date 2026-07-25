<?php

namespace App\Http\Controllers;

use App\Models\MenuAccess;
use App\Models\MstMenu;
use App\Models\UserGroup;
use App\Services\MenuService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class MenuAccessController extends BaseController
{
    protected ?int $menucode = 5;

    public function index(Request $request): View
    {
        $this->authorizeMenu();

        $roles = UserGroup::query()->where('isactive', 1)->get();
        $menus = MstMenu::query()->where('is_active', 1)->orderBy('idx')->get();
        $selectedRole = (int) $request->get('role', $roles->first()?->roleid ?? 1);

        $access = MenuAccess::query()
            ->where('user_group_id', $selectedRole)
            ->get()
            ->keyBy(fn ($row) => "{$row->user_group_id}:{$row->menucode}");

        return view('menuaccess.index', compact('roles', 'menus', 'access', 'selectedRole'));
    }

    public function store(Request $request): RedirectResponse
    {
        $this->authorizeMenu();

        if ((int) $this->userAccess['fedit'] !== 1 && (int) $this->userAccess['fadd'] !== 1) {
            abort(403);
        }

        $validated = $request->validate([
            'user_group_id' => 'required|exists:user_group,roleid',
            'permissions' => 'sometimes|array',
        ]);

        $roleId = (int) $validated['user_group_id'];
        $submitted = $validated['permissions'] ?? [];

        DB::transaction(function () use ($roleId, $submitted) {
            $menus = MstMenu::query()->where('is_active', 1)->pluck('menucode');

            foreach ($menus as $menucode) {
                $flags = $submitted[$menucode] ?? [];

                MenuAccess::query()->updateOrInsert(
                    [
                        'user_group_id' => $roleId,
                        'menucode' => (int) $menucode,
                    ],
                    [
                        'fview' => isset($flags['fview']) ? 1 : 0,
                        'fadd' => isset($flags['fadd']) ? 1 : 0,
                        'fedit' => isset($flags['fedit']) ? 1 : 0,
                        'fdelete' => isset($flags['fdelete']) ? 1 : 0,
                        'updated_at' => now(),
                        'created_at' => now(),
                    ]
                );
            }
        });

        MenuService::clearMenuCacheByRole($roleId);

        return redirect()->route('menuaccess.index', ['role' => $roleId])->with('success', 'Menu access updated successfully.');
    }
}
