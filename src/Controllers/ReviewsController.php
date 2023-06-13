<?php

namespace Shappy\Controllers;

use Shappy\Http\Controller;
use Shappy\Http\Request;
use Shappy\Models\Novel;
use Shappy\Models\Review;
use Shappy\Utils\Guard;
use Shappy\Utils\Validator;

class ReviewsController extends Controller
{

    public function __construct(
        private $validator = new Validator,
        private $review = new Review,
        private $novel = new Novel
    ) {
    }

    public function store(Request $request)
    {
        Guard::authorized();

        $comment = $request->input('comment');
        $novel_id = $request->input('novel_id');
        
        $novel = $this->novel->get_by_id($novel_id);
        if(!$novel) return error_404('Novel not found');

        $this->validator->empty($comment, 'Comment');

        if ($this->validator->has_error()) {
            $this->flash('error', $this->validator->get_error());
            return $this->redirect("/novel/fetch?novel={$novel->slug}");
        }

        if ($this->review->create($comment, auth()->id, $novel_id)) {
            $this->flash('success', "You have added a comment on reviews");
            return $this->redirect("/novel/fetch?novel={$novel->slug}");
        }
    }
}
