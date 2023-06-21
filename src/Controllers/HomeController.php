<?php

namespace Shappy\Controllers;

use Shappy\Http\Controller;
use Shappy\Models\Novel;

class HomeController extends Controller
{
    public function index()
    {
        $novel = new Novel;

        $novels = $novel->fetch_all(4);
    
        return $this->view('home', ['novels' => $novels]);
    }
}
