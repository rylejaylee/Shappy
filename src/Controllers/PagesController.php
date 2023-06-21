<?php 

namespace Shappy\Controllers;

use Shappy\Http\Controller;
use Shappy\Models\Novel;
use Shappy\Utils\Pagination;

class PagesController extends Controller {
    public function new_novels()
    {
        $novel = new Novel;
        $records_per_page=8;

        $pagination = new Pagination($novel->count()->count, $records_per_page);

        $novels = $novel->fetch_all($records_per_page, $pagination->getOffset());

        $links = $pagination->getPaginationLinks();

        return $this->view('novel/new_novels', ['novels' => $novels, 'links' => $links]);
    }
}