<?php

namespace App\Repositories\Partners\Contract;

use App\Core\Repositories\Contract\BaseRepositoryInterface;

interface PartnerRepositoryInterface extends BaseRepositoryInterface {
    public function createPartner($params);

    public function deletePartner($id);
    
    public function updatePartner($params,$id);
}