<?php

namespace Shappy\Controllers;

use Shappy\Http\Controller;
use Shappy\Models\Novel;

class HomeController extends Controller
{
    public function index()
    {
        $novel = new Novel;

        $novels = $novel->fetch_all(8);
        $popular = $novel->fetch_all(5, 0, Novel::VIEWS, 'desc');
        $top_rated = $novel->fetch_all(5, 0, Novel::RATING, 'desc');
    
        return $this->view('home', compact('novels', 'popular', 'top_rated'));
    }
}
