<?php

namespace Shappy\Controllers;

use Shappy\Http\Controller;
use Shappy\Http\Request;
use Shappy\Models\Chapter;
use Shappy\Models\Novel;
use Shappy\Utils\Guard;
use Shappy\Utils\Pagination;
use Shappy\Utils\Validator;

class ChaptersController extends Controller
{
    private $chapter;
    private $novel;
    private $validator;

    public function __construct()
    {
        $this->novel = new Novel;
        $this->chapter = new Chapter;
        $this->validator = new Validator;
    }

    public function all(Request $request)
    {
        $novel_slug = $request->input('novel');
        $novel = $this->novel->get_by_slug_with_user($novel_slug);

        if (!$novel) return error_404();

        $count = $this->chapter->count_by_novel_id($novel->id);
        $limit = 4;
        $pagination = new Pagination($count, $limit);
        $chapters = $this->chapter->get_all_by_novel_id($novel->id, $limit, $pagination->getOffset());
        $links = $pagination->getPaginationLinks();

        return $this->view('chapters/all', ['chapters' => $chapters, 'links' => $links, 'novel' => $novel]);
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

        $chapters = $this->chapter->get_all_ids($chapter->novel_id);
        $is_next_exist = $chapters[count($chapters) - 1]->id != $chapter->id;
        $is_prev_exist = $chapters[0]->id != $chapter->id;

        $chapter->is_next = $is_next_exist;
        $chapter->is_prev = $is_prev_exist;

        return $this->view('chapters/fetch', ['chapter' => $chapter, 'chapters' => $chapters]);
    }

    public function read_first(Request $request)
    {
        $novel = $request->input('novel');
        $chapter = $this->chapter->get_first($novel);

        return $this->redirect("/chapters/fetch?id=$chapter->id");
    }

    public function next(Request $request)
    {
        $chapter_id = $request->input('chapter');
        $novel = $request->input('novel');

        $chapter = $this->chapter->get_next_id($chapter_id, $novel);
      
        return $this->redirect("/chapters/fetch?id=$chapter->id");
    }


    public function previous(Request $request)
    {
        $chapter_id = $request->input('chapter');
        $novel = $request->input('novel');

        $chapter = $this->chapter->get_prev_id($chapter_id, $novel);

        return $this->redirect("/chapters/fetch?id=$chapter->id");
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

        $novel = $this->novel->get_by_id($chapter->novel_id);
        $slug = $novel ? $novel->slug : 0;

        if ($this->chapter->delete($chapter->id)) {
            $this->flash('success', 'Congrats! You have deleted a chapter.');
            echo $slug;
            exit;
        }

        echo 0;
    }
}
