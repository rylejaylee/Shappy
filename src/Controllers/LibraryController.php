<?php

namespace Shappy\Controllers;

use Shappy\Http\Controller;
use Shappy\Http\Request;
use Shappy\Models\Library;
use Shappy\Models\Novel;

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
        $novel = new Novel;
        $popular = $novel->fetch_all(5, 0, Novel::VIEWS, 'desc');
        $top_rated = $novel->fetch_all(5, 0, Novel::RATING, 'desc');
        return $this->view('library/index', compact('novels', 'popular', 'top_rated'));
    }

    public function add(Request $request)
    {
        $novel_id =  $request->input('novel_id');
        $this->flash('success', "A novel has been added from your novel");
        echo $this->library->create(auth()->id, $novel_id);
    }

    public function remove(Request $request)
    {
        $library_id =  $request->input('library_id');

        $this->flash('success', "A novel has been removed from your novel");
        echo $this->library->delete($library_id);
    }
}
