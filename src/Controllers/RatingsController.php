<?php

namespace Shappy\Controllers;

use Shappy\Http\Controller;
use Shappy\Http\Request;
use Shappy\Models\Novel;
use Shappy\Models\Rating;
use Shappy\Utils\Guard;

class RatingsController extends Controller
{

    public function __construct(
        private $rating = new Rating,
        private $novel = new Novel
    ) {
    }

    public function store(Request $request)
    {
        Guard::authorized();

        $stars = $request->input('stars');
        $novel_id = $request->input('novel_id');
        $user_id = auth()->id;


        if ($this->rating->create($stars, $user_id, $novel_id)) {
            $this->flash('success', 'Congrats! You have added a rating to this novel');
            echo 1;
            exit;
        }

        $this->flash('error', 'Sorry! You have failed to rate the novel');
        echo 0;
    }

    public function update(Request $request)
    {
        Guard::authorized();

        $stars = $request->input('stars');
        $rating_id = $request->input('rating_id');
        
        if ($this->rating->update($stars, $rating_id)) {
            $this->flash('success', 'Congrats! You have updated a rating to this novel');
            echo 1;
            exit;
        }

        $this->flash('error', 'Sorry! You have failed to rate the novel');
        echo 0;
    }

    public function user_rating(Request $request)
    {
        $novel_id = $request->input('novel_id');
        $user_id = auth()->id;

        $user_rating = $this->rating->get_user_rating($user_id, $novel_id);
        if ($user_rating)
            echo json_encode($user_rating);
        else
            echo 0;
    }
}
