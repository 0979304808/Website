<?php

namespace App\Repositories\ChildComments;

use App\Core\Repositories\BaseRepository;
use App\Models\Socials\ChildComment;
use App\Repositories\ChildComments\Contract\ChildCommentRepositoryInterface;

class ChildCommentRepository extends BaseRepository implements ChildCommentRepositoryInterface {

    protected $model;

    public function __construct(ChildComment $childComment)
    {
        parent::__construct($childComment);
        $this->model = $childComment;
    }
 
}