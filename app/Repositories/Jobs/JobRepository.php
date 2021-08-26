<?php

namespace App\Repositories\Jobs;

use App\Core\Repositories\BaseRepository;
use App\Models\Jobs\Job;
use App\Repositories\Jobs\Contract\JobRepositoryInterface;

class JobRepository extends BaseRepository implements JobRepositoryInterface {

    protected $model;

    public function __construct(Job $job)
    {
        parent::__construct($job);
        $this->model = $job;
    }

    public function active_Job($id)
    {
        return $this->model->where('id',$id)->update(['active' => 1]);
    }

 
}