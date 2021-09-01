<?php

namespace App\Http\Controllers\BackEnd\Jobs;

use App\Core\Traits\ApiResponser;
use App\Events\NewEvent;
use App\Models\Jobs\Job;
use App\Repositories\Jobs\Contract\JobRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use JavaScript;

class JobController extends Controller
{
    use ApiResponser;
    private $job;

    public function __construct(JobRepositoryInterface $job)
    {
        $this->job = $job;
    }

    // View Jobs
    public function index(Request $request)
    {
        $list_country = config('jobs.country');
        $list_province = config('jobs.province');

        $type = (in_array($request->get('type'), ['0', '1'])) ? $request->get('type') : 'all';
        $active = (in_array($request->get('active'), ['0', '1'])) ? $request->get('active') : 'all';
        $country = $request->get('country', 'all');
        $province = $request->get('province', 'all');
        $search = $request->get('search', null);

        if ($type !== 'all' || $active !== 'all' || $country !== 'all' || $province !== 'all') {
            $jobs = $this->job->whereAll($type, $active, $country, $province);
        }
        if ($search !== null) {
            $jobs = $this->job->Search($search);
        }
        if (!isset($jobs)) {
            $jobs = $this->job->withAll();
        }
        JavaScript::put([
            'url_list_jobs' => route('backend.job.index'),
            'url_job_detail' => url('job/detail'),
            'url_active_job' => route('backend.job.active'),
            'url_activeAll_job' => route('backend.job.activeAll'),
            'url_delete_job' => route('backend.job.delete'),
            'list_country' => $list_country,
            'list_province' => $list_province,
        ]);
        $jobs = $jobs->orderBy('id','desc')->paginate();
        $views = view('backend.jobs.index');
        $views->with('jobs', $jobs);
        $views->with('list_country', $list_country);
        $views->with('list_province', $list_province);
        return $views;
    }

    // Chi tiết job
    public function detail(Job $job)
    {
        return $this->success($job, 200);
    }

    // Active job
    public function active($id = null)
    {
        if ($id === null ){
            $id = request('id');
        }
        $attribute = [
            'active' => 1
        ];
        $job = $this->job->updateJob($attribute, $id);
        if ($job) {
            $subject = 'MAZII - THÔNG BÁO ĐĂNG BÀI TUYỂN DỤNG THÀNH CÔNG';
            $content = 'Mazii xin thông báo: bài đăng tuyển dụng " ' . $job->title . ' " đã được quản trị viên phê duyệt thành công';
            $data = array(
                'from' => 'mazii',
                'subject' => $subject,
                'email' => $job->user->email,
                'content' => $content,
                'username' => $job->user->username,
            );
            event(new NewEvent($data));
        }
        return $this->success('Active thành công', 200);
    }

    // Active jobs
    public function activeAll()
    {
        foreach (request('list_id') as $key => $value ){
            $this->active($value);
        }
        return $this->success('Active thành công',200);
    }

    // Delete job
    public function delete()
    {
        $id = request('id');
        $reason = request('reason');
        if ($reason) {
            $job = $this->job->deleteId($id);
            if ($job) {
                $subject = 'MAZII - THÔNG BÁO XOÁ BÀI TUYỂN DỤNG';
                $content = 'Chúng mình nhận thấy bài viết tuyển dụng của bạn vi phạm quy tắc cộng đồng Mazii vì lý do : "' . $reason . '" . Mazii gửi mail để thông báo cho bạn bài viết sẽ bị xoá trong vài phút tới.';
                $data = array(
                    'from' => 'mazii',
                    'subject' => $subject,
                    'email' => $job->user->email,
                    'content' => $content,
                    'username' => $job->user->username,
                );
                event(new NewEvent($data));
            }
        }
        return $reason;
    }
}
