<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

abstract class BaseController extends Controller
{
    /**
     * CRUD access flags for the current request.
     *
     * @var array{fview: int, fadd: int, fedit: int, fdelete: int}
     */
    protected array $userAccess = [
        'fview' => 0,
        'fadd' => 0,
        'fedit' => 0,
        'fdelete' => 0,
    ];

    /**
     * Menu code identifier for this controller. Child classes must override.
     */
    protected ?int $menucode = null;

    public function __construct()
    {
        $this->middleware($this->extractGroupAndLoadAccess());
    }

    /**
     * Middleware closure that captures user_group_id and shares access flags.
     */
    private function extractGroupAndLoadAccess(): Closure
    {
        return function ($request, $next) {
            /** @var \App\Models\User|null $user */
            $user = Auth::user();
            $groupId = $user !== null ? (int) $user->user_group_id : null;

            if ($this->menucode !== null) {
                $this->userAccess = Permission::getAccess($groupId, $this->menucode);
            }

            View::share('userAccess', $this->userAccess);

            return $next($request);
        };
    }

    /**
     * Abort with 403 if the user does not have view permission for this menu.
     */
    protected function authorizeMenu(?int $menucode = null): void
    {
        $code = $menucode ?? $this->menucode;

        if ($code === null) {
            abort(403, 'No menu code configured for authorization.');
        }

        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        $groupId = $user !== null ? (int) $user->user_group_id : null;

        $this->userAccess = Permission::getAccess($groupId, $code);
        View::share('userAccess', $this->userAccess);

        if ((int) $this->userAccess['fview'] !== 1) {
            abort(403, 'You are not authorized to view this menu.');
        }
    }
}
