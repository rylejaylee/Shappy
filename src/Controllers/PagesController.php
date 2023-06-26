<?php

namespace Shappy\Controllers;

use Shappy\Http\Controller;
use Shappy\Http\Request;
use Shappy\Models\Novel;
use Shappy\Utils\Pagination;

class PagesController extends Controller
{


    public function list(Request $request)
    {

        if (!isset($_GET['order_by']) || !isset($_GET['order']) || !isset($_GET['status'])) {
            return $this->redirect('/novels/list?order_by=date&order=desc&status=all');
        }

        $novel = new Novel;
        $records_per_page = 5;
        $order = $request->input('order');
        $order_by = $request->input('order_by');
        $status = $request->input('status');

        if (!in_array($order_by, ['date', 'name', 'rating', 'views']))
            return error_404();
        else if (!in_array($order, ['asc', 'desc']))
            return error_404();
        else if (!in_array($status, ['all', 'ongoing', 'completed', 'hiatus']))
            return error_404();

        $pagination = new Pagination($novel->count()->count, $records_per_page);
        $filter = Novel::DATE;
        switch ($order_by) {
            case 'date':
                $filter = Novel::DATE;
                break;
            case 'name':
                $filter = Novel::NAME;
                break;
            case 'rating':
                $filter = Novel::RATING;
                break;
            case 'rating':
                $filter = Novel::VIEWS;
                break;
            default:
                # code...
                break;
        }

        $novels = $novel->fetch_all($records_per_page, $pagination->getOffset(), $filter, $order, $status);
     
        $links = $pagination->getPaginationLinks();

        $popular = $novel->fetch_all(5, 0, Novel::VIEWS);
        $top_rated = $novel->fetch_all(5, 0, Novel::RATING);
     
        return $this->view('novel/new_novels', compact('novels', 'links', 'popular', 'top_rated'));
    }

    public function search(Request $request) {
        $text = $request->input('text');
       
        $novel = new Novel;
        $novels = $novel->search($text);
        
        echo json_encode($novels);
        
    }
}
