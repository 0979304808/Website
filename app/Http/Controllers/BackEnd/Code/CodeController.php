<?php

namespace App\Http\Controllers\BackEnd\Code;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Codes\Contract\CodePurchaseRepositoryInterface;
use Javascript;
use App\Core\Traits\ApiResponser;

class CodeController extends Controller
{
    use ApiResponser;
    private $codepurchase ; 
    public function __construct(CodePurchaseRepositoryInterface $codepurchase){
        $this->codepurchase = $codepurchase ; 
    }
    const TRANSACTION_USER_API = 'http://api.mazii.net/api/premium/list';
    const API_CODES = 'http://api.mazii.net/api/codes';

    public function Transaction(Request $request)
    {
        $page       = $request->get('page',1);
        $search     = $request->get('search',null); 
        $filter     = $request->get('filter','all');
        $sort       = $request->get('sort','new');

        $url = self::TRANSACTION_USER_API.'?page='.$page.'&sort='.$sort;
        if(!is_null($filter) && $filter != 'all'){
            $url = $url . '&filter=' . $filter;
        }
        if($search != null){
            $url = $url . '&search=' . $search;
        }

        $results = curl_get($url);

        $providers = [
            'apple'  => 'Apple',
            'google' => 'Google',
            'card'   => 'Card',
            'all'    => 'Tất cả'
        ];
        
        //customize pagination
        $query_string = [
            'page'      => '{page}',
            'filter'    => $filter,
            'sort'      => $sort,
            'search'    => $search
        ];
        $link = make_url_pagi($request->url(), $query_string);
        
        $paging = paging($link, $results->total, $results->current_page, $results->per_page);

        Javascript::put([
            'url_transaction' => route('backend.code.transaction'),
            'url_get_purchase'=> route('backend.code.getcodepurchase')
        ]);
        return view('backend.code.transaction',compact(['paging','results','providers','sort','search','filter']));
    }
    public function codesended(Request $request)
    {
        $page   = $request->get('page',1);
        $status = (in_array($request->get('status'),["0","1","2"])) ? trim($request->get('status')) : "1";
        $code   = convert_vi_to_en(str_replace(' ','',$request->get('code',null)));
        $sort   = $request->get('sort','new');

        $limit = 20;
        $url = self::API_CODES . "?page=$page&limit=$limit&status=$status&code=$code&sort=$sort";
        $list_codes = curl_get($url);

        $from_stt_of_view = $list_codes->from - 1; //STT record của table = $list_codes->from - 1;

        $query_string = [
            'page'      => '{page}',
            'status'    => $status,
            'sort'      => $sort,
        ];

        $link = make_url_pagi($request->url(),$query_string);
        $paging = paging($link, $list_codes->total, $page, $limit);

        $expired = [
            '7'  => '7 ngày',
            '30' => '1 tháng',
            '60' => '2 tháng',
            '90' => '3 tháng',
            '180' => '6 tháng',
            '365' => '1 năm',
            '730' => '2 năm',
            '3650' => 'vĩnh viễn',
        ];
        $state = [
            '0' => 'Chưa kích hoạt',
            '1' => 'Đã gửi',
            '2' => 'Đã kích hoạt',
        ];
        
        JavaScript::put([
            'url_codesended'    => route('backend.code.codesended'),
            // 'url_recalled'  => route('backend.code.recalled')
        ]);
        
        return view('backend.code.codesended',compact(['paging','state','expired','list_codes','page','status','code','sort','from_stt_of_view']));
    }

    public function codepurchase(Request $request){
            $code = $request->code;
            $purchase = $this->codepurchase->WithAdmin($code);
            if($purchase){
                return $this->success($purchase, 200);
            }
            return $this->error('Purchase not found',404);
    }
}
