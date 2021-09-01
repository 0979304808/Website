<?php

namespace App\Repositories\Jobs;

use App\Core\Repositories\BaseRepository;
use App\Models\Jobs\Job;
use App\Repositories\Jobs\Contract\JobRepositoryInterface;

class JobRepository extends BaseRepository implements JobRepositoryInterface
{
    protected $model;

    public function __construct(Job $job)
    {
        parent::__construct($job);
        $this->model = $job;
    }

    public function withAll()
    {
        return $this->model->with('user');
    }

    public function whereAll($type, $active, $country, $province)
    {
        $job = $this->model->with('user');
        if ($type !== 'all') {
            $job = $job->where('type', $type);
        }
        if ($active !== 'all') {
            $job = $job->where('active', $active);
        }
        if ($country !== 'all') {
            $job = $job->where('country', $country);
        }
        if ($type !== 'all') {
            $job = $job->where('type', $type);
        }
        if ($province !== 'all') {
            $job = $job->where('province', $province);
        }
        return $job;
    }

    public function Search($search)
    {
        return $this->model->where(function ($query) use ($search) {
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('username', 'like', $search);
            });
        })->orWhere('title', 'like', "%$search%")->orWhere('id', 'like', $search)->with('user');
    }

    public function updateJob(array $attribute, $id)
    {
        $job = $this->findOneOrFail($id);
        if ($job) {
             $job->update($attribute);
            return $job;
        }
    }

}