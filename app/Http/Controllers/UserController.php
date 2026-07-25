<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserGroup;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UserController extends BaseController
{
    protected ?int $menucode = 6;

    public function index(): View
    {
        $this->authorizeMenu();

        $users = User::query()->with('userGroup')->orderBy('name')->get();

        return view('users.index', compact('users'));
    }

    public function create(): View
    {
        $this->authorizeMenu();

        if ((int) $this->userAccess['fadd'] !== 1) {
            abort(403);
        }

        $roles = UserGroup::query()->where('isactive', 1)->get();

        return view('users.create', compact('roles'));
    }

    public function store(Request $request): RedirectResponse
    {
        $this->authorizeMenu();

        if ((int) $this->userAccess['fadd'] !== 1) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'user_group_id' => 'nullable|exists:user_group,roleid',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function edit(User $user): View
    {
        $this->authorizeMenu();

        if ((int) $this->userAccess['fedit'] !== 1) {
            abort(403);
        }

        $roles = UserGroup::query()->where('isactive', 1)->get();

        return view('users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $this->authorizeMenu();

        if ((int) $this->userAccess['fedit'] !== 1) {
            abort(403);
        }

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'user_group_id' => 'nullable|exists:user_group,roleid',
        ];

        if ($request->filled('password')) {
            $rules['password'] = 'string|min:8';
        }

        $validated = $request->validate($rules);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user): RedirectResponse
    {
        $this->authorizeMenu();

        if ((int) $this->userAccess['fdelete'] !== 1) {
            abort(403);
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
