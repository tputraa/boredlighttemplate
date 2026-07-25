<?php

namespace App\Http\Controllers;

use App\Models\MstMenu;
use App\Services\MenuService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MenuController extends BaseController
{
    protected ?int $menucode = 4;

    public function index(): View
    {
        $this->authorizeMenu();

        $menus = MstMenu::query()
            ->where('is_active', 1)
            ->orderBy('menuparent')
            ->orderBy('idx')
            ->get();

        return view('menus.index', compact('menus'));
    }

    public function create(): View
    {
        $this->authorizeMenu();

        if ((int) $this->userAccess['fadd'] !== 1) {
            abort(403);
        }

        $parents = MstMenu::query()
            ->where('menuparent', 0)
            ->where('is_active', 1)
            ->orderBy('idx')
            ->get();

        return view('menus.create', compact('parents'));
    }

    public function store(Request $request): RedirectResponse
    {
        $this->authorizeMenu();

        if ((int) $this->userAccess['fadd'] !== 1) {
            abort(403);
        }

        $validated = $request->validate([
            'menuname' => 'required|string|max:255',
            'menuparent' => 'required|integer|min:0',
            'is_active' => 'required|integer|in:0,1',
            'idx' => 'required|integer|min:0',
            'menutype' => 'required|string|max:50|in:link,parent',
            'menulink' => 'nullable|string|max:255',
            'icon' => 'nullable|string',
        ]);

        MstMenu::create($validated);

        MenuService::clearAllMenuCache();

        return redirect()->route('menus.index')->with('success', 'Menu created successfully.');
    }

    public function edit(MstMenu $menu): View
    {
        $this->authorizeMenu();

        if ((int) $this->userAccess['fedit'] !== 1) {
            abort(403);
        }

        $parents = MstMenu::query()
            ->where('menuparent', 0)
            ->where('is_active', 1)
            ->where('menucode', '!=', $menu->menucode)
            ->orderBy('idx')
            ->get();

        return view('menus.edit', compact('menu', 'parents'));
    }

    public function update(Request $request, MstMenu $menu): RedirectResponse
    {
        $this->authorizeMenu();

        if ((int) $this->userAccess['fedit'] !== 1) {
            abort(403);
        }

        $validated = $request->validate([
            'menuname' => 'required|string|max:255',
            'menuparent' => 'required|integer|min:0',
            'is_active' => 'required|integer|in:0,1',
            'idx' => 'required|integer|min:0',
            'menutype' => 'required|string|max:50|in:link,parent',
            'menulink' => 'nullable|string|max:255',
            'icon' => 'nullable|string',
        ]);

        $menu->update($validated);

        MenuService::clearAllMenuCache();

        return redirect()->route('menus.index')->with('success', 'Menu updated successfully.');
    }

    public function destroy(MstMenu $menu): RedirectResponse
    {
        $this->authorizeMenu();

        if ((int) $this->userAccess['fdelete'] !== 1) {
            abort(403);
        }

        $menu->update(['is_active' => 0]);

        MenuService::clearAllMenuCache();

        return redirect()->route('menus.index')->with('success', 'Menu deactivated successfully.');
    }
}
