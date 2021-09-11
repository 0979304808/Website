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
            $childComment = $childComment->language($lang);
        }
        if ($status != null ){
            $childComment = $childComment->status($status);
        }
        return $childComment;
    }

    public function createOrUpdateChildComment(array $attribute)
    {
        $id = explode('-', request('_id'));
        $id = end($id);
        if (request('_id')){
            $comment = $this->model->find($id);
            return $comment->update($attribute);
        }
        return $this->model->create($attribute);
    }
}
