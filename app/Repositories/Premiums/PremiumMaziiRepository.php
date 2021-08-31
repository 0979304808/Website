<?php

namespace App\Repositories\Premiums;

use App\Core\Repositories\BaseRepository;
use App\Models\Premiums\PremiumMazii;
use App\Repositories\Premiums\Contract\PremiumMaziiRepositoryInterface;

class PremiumMaziiRepository extends BaseRepository implements PremiumMaziiRepositoryInterface
{
    protected $model;

    public function __construct(PremiumMazii $premiumMazii)
    {
        parent::__construct($premiumMazii);
        $this->model = $premiumMazii;
    }

    public function withAll()
    {
        return $this->model->with('user')->paginate();
    }

    public function WhereSortFilter($sort, $filter)
    {
        if ($sort == 'old'){
            $sort = 'asc';
        }
        if ($sort == 'new'){
            $sort = 'desc';
        }
        if ($filter == 'all'){
            return $this->model->orderBy('premiumId', $sort);
        }
        return $this->model->where('provider', $filter)->orderBy('premiumId', $sort);
    }

    public function search($search)
    {
        return $this->model->whereHas('user', function ($query) use ($search) {
            $query->where('userId', 'like', '%' . $search . '%');
            $query->orWhere('email', 'like', '%' . $search . '%');
        })->orWhere('transaction', 'like', '%' . $search . '%')->orWhere('premiumId', 'like', '%' . $search . '%');
    }

}