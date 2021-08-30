<?php

namespace App\Http\Controllers\BackEnd\Users;

use App\Models\Users\UserSubscribe;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Users\Contract\UserSubscribeRepositoryInterface;
use JavaScript;


class UserController extends Controller
{
    private $usersubscribe;
    
    public function __construct(UserSubscribeRepositoryInterface $usersubscribe){
        $this->usersubscribe = $usersubscribe;
    }

    public function usersubscribe(Request $request) {
        $start_time  = $request->get('start_time', 'desc');
        $search      = $request->get('search', null);

        if(!is_null($search)){
             $list_usersubscribes = $this->usersubscribe->WhereHasUser($search);
        }else{
             $list_usersubscribes =  $this->usersubscribe->WithUser();
        }
        $list_usersubscribes =  $list_usersubscribes->orderBy('start_time',$start_time)->paginate(30)->appends(['start_time' => $start_time,'search' => $search]);

        JavaScript::put([
            'url_usersubscribe' => $request->url()
        ]);
 
         return view('backend.users.usersubscribe',compact('list_usersubscribes','start_time','search'));
    }
}
