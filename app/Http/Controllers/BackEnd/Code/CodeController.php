<?php

namespace App\Http\Controllers\BackEnd\Code;

use App\Core\Traits\Authorization;
use App\Exports\PremiumExport;
use App\Imports\PremiumImport;
use App\Repositories\Codes\Contract\CodeRepositoryInterface;
use App\Repositories\Premiums\Contract\PremiumMaziiRepositoryInterface;
use App\Repositories\Serial\Contract\SerialRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Purchase\Contract\MaziiPurchaseRepositoryInterface;
use Javascript;
use App\Core\Traits\ApiResponser;

class CodeController extends Controller
{
    use ApiResponser;
    use Authorization;

    private $maziipurchase;
    private $serial;
    private $premiumMazii;
    private $code;

    public function __construct(MaziiPurchaseRepositoryInterface $maziipurchase, CodeRepositoryInterface $code, SerialRepositoryInterface $serial, PremiumMaziiRepositoryInterface $premiumMazii)
    {
        $this->maziipurchase = $maziipurchase;
        $this->serial = $serial;
        $this->premiumMazii = $premiumMazii;
        $this->code = $code;
    }

    // List Phiên giao dịch
    public function Transaction(Request $request)
    {
        $startOfBeforeMonth = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d_h:i:s-A ');
        $search = $request->get('search', null);
        $filter = $request->get('filter', 'all');
        $sort = $request->get('sort', 'new');
        $action = $request->get('action');
        if ($filter != null && $filter != 'all' || $sort != null) {
            $premiumMazii = $this->premiumMazii->WhereSortFilter($sort, $filter);
        }
        if ($search != null) {
            $premiumMazii = $this->premiumMazii->search($search);
        }
        if (isset($premiumMazii)) {
            $premiumMazii = $premiumMazii->with('user')->paginate();
        } else {
            $premiumMazii = $this->premiumMazii->withAll();
        }

        // Export excel
        if ($action == 'excel') {
            return (new PremiumExport($sort, $filter, $search))->download('premium-' . $startOfBeforeMonth . '.csv');
        }
        $providers = [
            'all' => 'Tất cả',
            'apple' => 'Apple',
            'google' => 'Google',
            'card' => 'Card'
        ];

        Javascript::put([
            'url_transaction' => route('backend.code.transaction'),
            'url_get_purchase' => route('backend.code.getcodepurchase')
        ]);
        $view = view('backend.code.transaction');
        $view->with('premiumMazii', $premiumMazii);
        $view->with('providers', $providers);
        return $view;
    }

    // List Mã đã gửi
    public function codesended(Request $request)
    {
        $status = (in_array($request->get('status'), ["0", "1", "2"])) ? trim($request->get('status')) : "1";
        $code = convert_vi_to_en(str_replace(' ', '', $request->get('code', null)));
        $sort = $request->get('sort', 'new');
        if (!isset($codes)) {
            $codes = $this->code->withAll();
        }
        $expired = [
            '7' => '7 ngày',
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

        $views = view('backend.code.codesended');
        $views->with('codes', $codes);
        $views->with('state', $state);
        return $views;
    }

    // Chi tiết đơn hàng
    public function codepurchase(Request $request)
    {
        $code = $request->get('code');
        if ($code) {
            $purchase = $this->code->findOneBy(['code' => $code]);
            if ($purchase) {
                return $this->success($purchase, 200);
            }
        }
        return $this->error('Purchase not found', 404);
    }

    // Thu hồi mã code
    public function recalled(Request $request)
    {
        $key = $request->get('key', '');
        if ($key) {
            $reason = $this->guard()->user()->username . " : Thu hồi mã code";
            $state = 0;
            $params = [
                'state' => $state,
                'reason' => $reason,
            ];
            $serial = $this->serial->findOneBy(['serialkey' => $key]);

            $serial->update($params);

            if ($serial) {
                return $this->success('recalled');
            }
        }
        return $this->error('Models Not Found', 404);
    }

    // View  Import
    public function viewImport()
    {
        return view('backend.code.import');
    }

    // Import
    public function import(Request $request)
    {
        $file = $request->file('file');
        (new PremiumImport)->import($file);
        return redirect()->back()->with('msg', 'Thành công');
    }

}
