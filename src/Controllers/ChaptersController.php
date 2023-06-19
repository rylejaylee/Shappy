<?php

namespace Shappy\Controllers;

use Shappy\Http\Controller;
use Shappy\Http\Request;
use Shappy\Models\Chapter;
use Shappy\Models\Novel;
use Shappy\Utils\Guard;
use Shappy\Utils\Validator;

class ChaptersController extends Controller
{

    public function __construct(
        private $novel = new Novel,
        private $chapter = new Chapter,
        private $validator = new Validator
    ) {
    }

    public function create(Request $request)
    {
        Guard::authorized();

        $novel_id = $request->input('novel_id');
        $novel = $this->novel->get_by_id($novel_id);

        if (!$novel) error_404();

        Guard::owner($novel->user_id);

        return $this->view('chapters/create', ['novel_id' => $novel->id]);
    }
    public function fetch(Request $request)
    {
        $chapter_id = $request->input('id');

        $chapter = $this->chapter->get_by_id($chapter_id);

        return $this->view('chapters/fetch', ['chapter' => $chapter]);
    }

    public function store(Request $request)
    {
        Guard::authorized();

        $novel_id = $request->input('novel_id');
        $novel = $this->novel->get_by_id($novel_id);

        if (!$novel) error_404();

        Guard::owner($novel->user_id);

        $title = $request->input('title');
        $content = $request->input('content');

        $this->validator->title($title);
        $this->validator->empty($content, 'Content');

        if ($this->validator->has_error()) {
            $this->flash('error', $this->validator->get_error());
            return $this->redirect('/chapters/create?novel_id=' . $novel->id);
        }

        if ($this->chapter->create($title, $content, auth()->id, $novel->id)) {
            $this->flash('success', 'Congrats! You have added new chapter to your novel.');
            return $this->redirect("/novel/fetch?novel={$novel->slug}");
        }
    }

    public function edit(Request $request)
    {
        Guard::authorized();

        $chapter_id = $request->input('id');
        $chapter = $this->chapter->get_by_id($chapter_id);

        if (!$chapter) error_404();

        Guard::owner($chapter->user_id);
        
        return $this->view('/chapters/edit', ['chapter' => $chapter]);
    }

    public function update(Request $request)
    {
        Guard::authorized();

        $chapter_id = $request->input('chapter_id');
        $chapter = $this->chapter->get_by_id($chapter_id);

        if (!$chapter) error_404();

        Guard::owner($chapter->user_id);

        $title = $request->input('title');
        $content = $request->input('content');

        $this->validator->title($title);
        $this->validator->empty($content, 'Content');
        
        if ($this->validator->has_error()) {
            $this->flash('error', $this->validator->get_error());
            return $this->redirect('/chapters/edit?id=' . $chapter->id);
        }

        if ($this->chapter->update($title, $content, $chapter->id)) {
            $this->flash('success', 'Congrats! You have a chapter.');
            return $this->redirect("/chapters/fetch?id={$chapter->id}");
        }
    }

    public function delete(Request $request)
    {
        Guard::authorized();

        $chapter_id = $request->input('chapter_id');
        $chapter = $this->chapter->get_by_id($chapter_id);

        if (!$chapter) error_404();

        Guard::owner($chapter->user_id);

        if ($this->chapter->delete($chapter->id)) {
            $this->flash('success', 'Congrats! You have deleted a chapter.');
            echo 1;
        }
    }
}
