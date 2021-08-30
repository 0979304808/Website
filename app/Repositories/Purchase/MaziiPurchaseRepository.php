<?php

namespace App\Repositories\Purchase;

use App\Models\Purchase\MaziiPurchase;
use App\Core\Repositories\BaseRepository;
use App\Repositories\Purchase\Contract\MaziiPurchaseRepositoryInterface;

class MaziiPurchaseRepository extends BaseRepository implements MaziiPurchaseRepositoryInterface
{

    protected $model;

    public function __construct(MaziiPurchase $maziiPurchase)
    {
        parent::__construct($maziiPurchase);
        $this->model = $maziiPurchase;
    }

    public function WithAdmin($code)
    {
        return $this->model->with('adminUser')->where('code', $code)->first();
    }
}