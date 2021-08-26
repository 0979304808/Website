<?php

namespace App\Repositories\Projects;

use App\Core\Repositories\BaseRepository;
use App\Models\Projects\Project;
use App\Repositories\Projects\Contract\ProjectRepositoryInterface;

class ProjectRepository extends BaseRepository implements ProjectRepositoryInterface {

    protected $model;

    public function __construct(Project $project)
    {
        parent::__construct($project);
        $this->model = $project;
    }

    public function findSlug(string $slug)
    {
        return $this->model->whereSlug($slug)->firstOrFail();
    }
 
}