<?php

namespace App\Repositories\Codes;

use App\Models\Codes\CodePurchase;
use App\Core\Repositories\BaseRepository;
use App\Repositories\Codes\Contract\CodePurchaseRepositoryInterface;

class CodePurchaseRepository extends BaseRepository implements CodePurchaseRepositoryInterface {

    protected $model;

    public function __construct(CodePurchase $codepurchase)
    {
        parent::__construct($codepurchase);
        $this->model = $codepurchase;
    }

    public function WithAdmin($code){
       return $this->model->with('admin')->where('code',$code)->first();
    }
}