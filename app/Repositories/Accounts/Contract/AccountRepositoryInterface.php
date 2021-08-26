<?php

namespace App\Repositories\Accounts\Contract;

use App\Core\Repositories\Contract\BaseRepositoryInterface;

interface AccountRepositoryInterface extends BaseRepositoryInterface {
    
    /**
     * @param array $data
     * @return mixed
     */
    public function createAccountVirtual(array $data);

    /**
     * @return mixed
     */
    public function getAccounts();
    public function changePassword($user, $password);
}