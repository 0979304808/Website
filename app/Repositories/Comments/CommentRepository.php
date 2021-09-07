<?php

namespace App\Repositories\Comments;

use App\Core\Repositories\BaseRepository;
use App\Models\Socials\Comment;
use App\Repositories\Comments\Contract\CommentRepositoryInterface;

class CommentRepository extends BaseRepository implements CommentRepositoryInterface
{

    protected $model;

    public function __construct(Comment $comment)
    {
        parent::__construct($comment);
        $this->model = $comment;
    }

    public function withAll()
    {
        return $this->model->with(['childComments', 'user', 'post']);
    }

    public function whereLangStatus($lang, $status)
    {
        $comment = $this->model->with(['childComments', 'user', 'post']);
        if ($lang != null) {
            $comment = $comment->where('language_id', $lang);
        }
        if ($status != null) {
            $comment = $comment->where('status', $status);
        }
        return $comment;
    }

    public function createOrUpdateComment(array $attribute)
    {
        if (request('_id')){
            $comment = $this->model->find(request('_id'));
            return $comment->update($attribute);
        }
        return $this->model->create($attribute);
    }
}