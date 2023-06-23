<?php

namespace Shappy\Utils;


class Pagination
{
    private $totalRecords;
    private $recordsPerPage;
    private $currentPage;

    public function __construct($totalRecords, $recordsPerPage)
    {
        $this->totalRecords = $totalRecords;
        $this->recordsPerPage = $recordsPerPage;
        $this->currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
    }

    public function getTotalPages()
    {
        return ceil($this->totalRecords / $this->recordsPerPage);
    }

    public function getCurrentPage()
    {
        return $this->currentPage;
    }

    public function getOffset()
    {
        return ($this->currentPage - 1) * $this->recordsPerPage;
    }

    public function getPaginationLinks()
    {
        $totalPages = $this->getTotalPages();
        $currentPage = $this->getCurrentPage();

        $links = '';
        $queries = '?';

        unset($_GET['page']);

        if(boolval($_GET)){
            $queries = "?";
            for ($i=0; $i < count($_GET); $i++) { 
                $queries .= array_keys($_GET)[$i] . "=" . array_values($_GET)[$i];
                $queries .= "&";
            }
        }


        if ($totalPages > 1) {
            $links .= '<ul class="pagination">';

            if ($currentPage > 1) {
                $links .= '<li class="page-item "><a class="page-link" href="'.$queries.'page=' . ($currentPage - 1) . '">Previous</a></li>';
            }

            for ($i = 1; $i <= $totalPages; $i++) {
                if ($i == $currentPage) {
                    $links .= '<li class="page-item active"><a class="page-link" href="'.$queries.'page=' . $i . '">' . $i . '</a></li>';
                } else {
                    $links .= '<li class="page-item"><a class="page-link" href="'.$queries.'page=' . $i . '">' . $i . '</a></li>';
                }
            }

            if ($currentPage < $totalPages) {
                $links .= '<li class="page-item"><a class="page-link" href="'.$queries.'page=' . ($currentPage + 1) . '">Next</a></li>';
            }

            $links .= '</ul>';
        }

        return $links;
    }
}
