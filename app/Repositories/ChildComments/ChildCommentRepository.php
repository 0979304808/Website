<?php

namespace App\Repositories\ChildComments;

use App\Core\Repositories\BaseRepository;
use App\Models\Socials\ChildComment;
use App\Repositories\ChildComments\Contract\ChildCommentRepositoryInterface;

class ChildCommentRepository extends BaseRepository implements ChildCommentRepositoryInterface
{

    protected $model;

    public function __construct(ChildComment $childComment)
    {
        parent::__construct($childComment);
        $this->model = $childComment;
    }

    public function withAll()
    {
        return $this->model->with(['user', 'comment']);
    }

    public function whereLangStatus($lang, $status)
    {
        $childComment = $this->model->with(['user', 'comment']);
        if ($lang != null ){
            $childComment = $childComment->where('language_id',$lang);
        }
        if ($status != null ){
            $childComment = $childComment->where('status',$status);
        }
        return $childComment;
    }
}