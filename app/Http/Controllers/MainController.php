<?php

namespace App\Http\Controllers;

use App\Http\Resources\WeeklyMenuResource;
use App\Services\MenuService;
use App\Services\WeekSelectorService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class MainController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Home');
    }

    public function aboutPage(): Response
    {
        return Inertia::render('AboutUs');
    }
}
