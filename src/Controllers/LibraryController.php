<?php

namespace Shappy\Controllers;

use Shappy\Http\Controller;
use Shappy\Http\Request;
use Shappy\Models\Library;

class LibraryController extends Controller
{
    private $library;
    public function __construct()
    {
        $this->library = new Library;
    }

    public function index()
    {
        $novels = $this->library->get_by_user(auth()->id ?? 0);
    
        return $this->view('library/index', compact('novels'));
    }

    public function add(Request $request)
    {
        $novel_id =  $request->input('novel_id');

        echo $this->library->create(auth()->id, $novel_id);
    }

    public function remove(Request $request)
    {
        $library_id =  $request->input('library_id');

        echo $this->library->delete($library_id);
    }
}
