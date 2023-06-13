<?php

namespace Shappy\Controllers;

use Shappy\Http\Controller;
use Shappy\Http\Request;
use Shappy\Models\Novel;
use Shappy\Utils\Guard;
use Shappy\Utils\Validator;

class NovelsController extends Controller
{
    private $validator;
    private $novel;

    public function __construct()
    {
        $this->validator = new Validator;
        $this->novel = new Novel;
    }

    public function fetch(Request $request)
    {
        $slug = $request->input('novel');

        $novel = $this->novel->get_by_slug($slug);

        return $this->view("novel/fetch", ['novel' => $novel]);
    }

    public function create()
    {
        Guard::authorized();
        return $this->view('novel/create');
    }

    public function store(Request $request)
    {
        Guard::authorized();

        $title = $request->input('title');
        $desc = $request->input('desc');

        $image_file = $request->file('image');
        $image_name = null;

        $this->validator->title($title);
        $this->validator->empty($desc, 'Description');
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

        if ($this->novel->create($title, auth()->id, $desc, $image_name)) {
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
        Guard::owner($novel->user_id);  

        return $this->view("novel/edit", ['novel' => $novel]);
    }

    public function update(Request $request)
    {   
        Guard::authorized();
        $id = $request->input('id');
        $novel = $this->novel->get_by_id($id);
        Guard::owner($novel->user_id);


        $novel_id = $request->input('novel_id');
        $title = $request->input('title');
        $desc = $request->input('desc');

        $this->validator->title($title);
        $this->validator->empty($desc, 'Description');
        $this->validator->max($desc, 'Description', 5000);

        if ($this->validator->has_error()) {
            $this->flash('error', $this->validator->get_error());
            return $this->redirect('/novel/edit?id='.$novel_id);
        }

        if ($this->novel->update($title, $desc, $novel_id)) {
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
        Guard::owner($novel->user_id);
        if ($this->novel->delete($id)) {
            $this->flash('success', 'You have deleted a input');
            echo 1;
        }
    }
}
