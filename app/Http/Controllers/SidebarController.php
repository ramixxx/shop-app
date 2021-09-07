<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Link;

class SidebarController extends Controller
{
    /**
     * Register
     */
    public function allSidebarLinks()
    {
        return Link::with('sidebar_child_item')->get();
    }
}