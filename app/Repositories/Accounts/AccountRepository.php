<?php

namespace App\Repositories\Accounts;

use App\Core\Repositories\BaseRepository;
use App\Models\Socials\Account;
use App\Repositories\Accounts\Contract\AccountRepositoryInterface;

class AccountRepository extends BaseRepository implements AccountRepositoryInterface {

    protected $model;

    public function __construct(Account $account)
    {
        parent::__construct($account);
        $this->model = $account;
    }

    public function createAccountVirtual(array $data)
    {
        return $this->model->create($data);
    }
    
    public function getAccounts()
    {
       return $this->model->get(['userId', 'username', 'tokenId', 'email', 'language_id']);
    }

    private function existsAccount($email){
        return $this->model->whereEmail($email)->exists();
    }

    public function changePassword($user, $password){
        $user->password = $password;
        return $user->save();
    }
 
}
