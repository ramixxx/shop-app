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
        $links = Link::find(1)->item;
        // var_dump($links);
        foreach($links as $link) {
            print_r($link->name);
        }
    }
}