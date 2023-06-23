<?php

namespace Shappy\Controllers;

use Shappy\Http\Controller;
use Shappy\Http\Request;
use Shappy\Models\Category;
use Shappy\Models\Chapter;
use Shappy\Models\Novel;
use Shappy\Models\Rating;
use Shappy\Models\Review;
use Shappy\Utils\Guard;
use Shappy\Utils\Pagination;
use Shappy\Utils\Validator;

class NovelsController extends Controller
{

    public function __construct(
        private $validator = new Validator,
        private $novel = new Novel
    ) {
    }


    public function fetch(Request $request)
    {
        $slug = $request->input('novel');

        $novel = $this->novel->get_by_slug_with_user($slug);

        if(!$novel) return error_404();
        
        $chapter = new Chapter;
        $chapters = $chapter->get_all_by_novel_id($novel->id);


        $review = new Review;
        $reviews = $review->get_all_by_novel_id($novel->id);

        $rating = new Rating;
        $ratings_average = $rating->get_average($novel->id);
        $ratings_data = $rating->get_ratings($novel->id);
        $ratings_count = $rating->get_rating_count($novel->id);

        if (!$novel) error_404();

        // add new property on novel object
        $novel->ratings_average = floatval($ratings_average);

        $_ratings = [
            'rating_5' => 0,
            'rating_4' => 0,
            'rating_3' => 0,
            'rating_2' => 0,
            'rating_1' => 0,
        ];

        $ratings = [
            'rating_5' => 0,
            'rating_4' => 0,
            'rating_3' => 0,
            'rating_2' => 0,
            'rating_1' => 0,
        ];

        foreach ($ratings_data as $rating) {
            switch ($rating->rating) {
                case 5:
                    $_ratings['rating_5'] = ($rating->rating_count / $ratings_count) * 100;
                    $ratings['rating_5'] = $rating->rating_count;
                    break;
                case 4:
                    $_ratings['rating_4'] = ($rating->rating_count / $ratings_count) * 100;
                    $ratings['rating_4'] = $rating->rating_count;
                    break;
                case 3:
                    $_ratings['rating_3'] = ($rating->rating_count / $ratings_count) * 100;
                    $ratings['rating_3'] = $rating->rating_count;
                    break;
                case 2:
                    $_ratings['rating_2'] = ($rating->rating_count / $ratings_count) * 100;
                    $ratings['rating_2'] = $rating->rating_count;
                    break;
                case 1:
                    $_ratings['rating_1'] = ($rating->rating_count / $ratings_count) * 100;
                    $ratings['rating_1'] = $rating->rating_count;
                    break;
                default:
                    # code...
                    break;
            }
        }
        // dd($_ratings);

        return $this->view("novel/fetch", [
            'novel' => $novel,
            'chapters' => $chapters,
            'reviews' => $reviews,
            '_ratings' => $_ratings,
            'ratings' => $ratings,
        ]);
    }

    public function create()
    {
        Guard::authorized();
        $category = new Category;
        $categories = $category->get_all();
        return $this->view('novel/create', ['categories' => $categories]);
    }

    public function store(Request $request)
    {
        Guard::authorized();

        $title = $request->input('title');
        $desc = $request->input('desc');
        $category = $request->input('category');

        $image_file = $request->file('image');
        $image_name = null;

        $this->validator->title($title);
        $this->validator->empty($desc, 'Description');
        $this->validator->empty($category, 'Category');
        $this->validator->max($desc, 'Description', 5000);

        if ($image_file["tmp_name"]) {
            $this->validator->image($image_file);
            $this->validator->allowed_image($image_file);
        }

        if ($this->validator->has_error()) {
            $this->flash('error', $this->validator->get_error());

            return $this->redirect('/novel/create');
        }

        // Generate the image_name
        if ($image_file["tmp_name"]) {
            $image_extension = strtolower(pathinfo($image_file['name'], PATHINFO_EXTENSION));
            // Create a unique image name
            $image_name = "novels/" . bin2hex(random_bytes(16)) . "." . $image_extension;
        }

        if ($this->novel->create($title, auth()->id, $desc, $category, $image_name)) {
            if ($image_file["tmp_name"]) {
                move_uploaded_file($image_file["tmp_name"], "assets/images/$image_name");
            }

            $this->flash('success', 'Congrats! You have created a new novel');
            return $this->redirect('/');
        }
    }

    public function edit(Request $request)
    {
        Guard::authorized();

        $id = $request->input('id');
        $novel = $this->novel->get_by_id($id);
        if (!$novel) error_404();

        Guard::owner($novel->user_id);
        $category = new Category;
        $categories = $category->get_all();
        return $this->view("novel/edit", ['novel' => $novel, 'categories' => $categories]);
    }

    public function update(Request $request)
    {
        Guard::authorized();
        $id = $request->input('novel_id');
        $novel = $this->novel->get_by_id($id);
        if (!$novel) error_404();
        Guard::owner($novel->user_id);


        $novel_id = $request->input('novel_id');
        $title = $request->input('title');
        $desc = $request->input('desc');
        $category = $request->input('category');

        $this->validator->title($title);
        $this->validator->empty($desc, 'Description');
        $this->validator->max($desc, 'Description', 5000);
        $this->validator->empty($category, 'Category');

        if ($this->validator->has_error()) {
            $this->flash('error', $this->validator->get_error());
            return $this->redirect('/novel/edit?id=' . $novel_id);
        }

        if ($this->novel->update($title, $desc, $category, $novel_id)) {
            $this->flash('success', 'Congrats! You have updated a novel');
            return $this->redirect("/novel/fetch?novel=" . $this->novel->title_to_slug($title));
        } else {
            $this->flash('error', 'Something went wrong! Failed to update novel.');
        }
    }

    public function delete(Request $request)
    {
        Guard::authorized();
        $id = $request->input('id');
        $novel = $this->novel->get_by_id($id);

        if (!$novel) error_404();
        Guard::owner($novel->user_id);
        if ($this->novel->delete($id)) {
            // delete cover image if novel is deleted
            if ($novel->img != null && file_exists("." . img($novel->img)))
                unlink("." . img($novel->img));

            $this->flash('success', 'Congrats! You have deleted a novel');
            echo 1;
        }
    }

    public function upload_cover(Request $request)
    {
        Guard::authorized();
        $id = $request->input('novel_id');
        $novel = $this->novel->get_by_id($id);

        if (!$novel) error_404();
        Guard::owner($novel->user_id);

        $image_file = $request->file('image');

        $this->validator->empty($image_file['name'], 'Cover image');
        $this->validator->image($image_file);
        $this->validator->allowed_image($image_file);

        if ($this->validator->has_error()) {
            $this->flash('error', $this->validator->get_error());
            echo 0;
            exit;
        }

        $old_image = $novel->img;
        $image_extension = strtolower(pathinfo($image_file['name'], PATHINFO_EXTENSION));
        $image_name = "novels/" . bin2hex(random_bytes(16)) . "." . $image_extension;

        if ($this->novel->update_img($image_name, $novel->id)) {
            // delete cover image if novel is deleted
            if (move_uploaded_file($image_file["tmp_name"], "assets/images/$image_name")) {
                if ($old_image != null && file_exists("." . img($old_image)))
                    unlink("." . img($old_image));

                $this->flash('success', 'Congrats! You uploaded a new cover image');
                echo 1;
                exit;
            }
            $this->flash('error', 'Something went wrong! Please try again.');
            echo 0;
        }
    }
}
