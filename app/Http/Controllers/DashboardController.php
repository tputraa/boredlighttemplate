<?php

namespace App\Http\Controllers;

class DashboardController extends BaseController
{
    protected ?int $menucode = 1;

    public function index()
    {
        $this->authorizeMenu();

        return view('dashboard');
    }
}
