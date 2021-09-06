<?php

namespace App\Http\Controllers\BackEnd\Socials;

use App\Core\Traits\ApiResponser;
use App\Http\Requests\Posts\CreatePostRequest;
use App\Http\Requests\TestRequest;
use App\Jobs\NewJob;
use App\Models\Socials\Post;
use App\Repositories\Categories\Contract\CategoryRepositoryInterface;
use App\Repositories\ChildComments\Contract\ChildCommentRepositoryInterface;
use App\Repositories\Comments\Contract\CommentRepositoryInterface;
use App\Repositories\Languages\Contract\LanguageRepositoryInterface;
use App\Repositories\Posts\Contract\PostRepositoryInterface;
use App\Repositories\UserMazii\Contract\UserMaziiRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use JavaScript;

class PostController extends Controller
{
    use ApiResponser;
    private $language;
    private $account;
    private $category;
    private $post;
    private $comment;
    private $chilComment;

    public function __construct(LanguageRepositoryInterface $language, UserMaziiRepositoryInterface $account, CategoryRepositoryInterface $category, PostRepositoryInterface $post, CommentRepositoryInterface $comment, ChildCommentRepositoryInterface $chilComment)
    {
        $this->language = $language;
        $this->account = $account;
        $this->category = $category;
        $this->post = $post;
        $this->comment = $comment;
        $this->chilComment = $chilComment;
    }

    // View release
    public function release(Request $request)
    {

        $lang = $request->get('lang', '1');
        $status = $request->get('status', '0');
        $pin = $request->has('pin');
        $choice = $request->has('choice');
        $status_option = [
            '0' => 'Chưa duyệt',
            '1' => 'Đã duyệt',
            '-2' => 'Spam',
            '-1' => 'Đã xóa',
        ];
        if ($lang != 17 || $status != null) {
            $post = $this->post->whereLangStatus($lang, $status);
        }
        if ($pin) {
            $post = $this->post->wherePin();
        }
        if ($choice) {
            $post = $this->post->whereChoice();
        }
        if (!isset($post)) {
            $post = $this->post->WithAll();
        }
        $posts = $post->paginate();
        $languages = $this->language->all();
        JavaScript::put([
            'link_socials_release' => route('backend.social.release'),
            'link_change_sale' => route('backend.social.release.sale'),
            'link_update_status_post' => route('backend.social.release.update')
        ]);

        $view = view('backend.social.index');
        $view->with('status_option', $status_option);
        $view->with('languages', $languages);
        $view->with('posts', $posts);
        return $view;
    }

    // Change Post
    public function changePost()
    {
        $id = request('id');
        $type = request('type');
        $kind = request('kind');
        $reason = request('reason');
        $title = request('title');
        if ($kind == 1) {
            $object = $this->post->find($id);
            switch ($type) {
                case 'pin':
                    $object->pin();
                    break;
                case 'spam':
                    $object->spam();
                    break;
                case 'choice':
                    $object->choice();
                    break;
                case 'delete':
                    $object->delete();
                    break;
                case 'check':
                    $object->check();
                    break;
                case 'new':
                    $object->new();
                    break;
            }
        } else if ($kind == 2 || $kind == 3) {
            $object = ($kind == 2) ? $this->comment->find($id) : $this->chilComment->find($id);
            switch ($type) {
                case 'spam':
                    $object->spam();
                    break;
                case 'delete':
                    $object->delete();
                    break;
                case 'check':
                    $object->check();
                    break;
                case 'new':
                    $object->new();
                    break;
            }
        } else return response('error', 400);

        if ($object->save()) {
            // Send email to user
            if ($reason != '' && ($type == 'spam' || $type == 'delete')) {
                $subject = 'MAZII - THÔNG BÁO XOÁ BÀI TUYỂN DỤNG';
                $content = 'Chúng mình nhận thấy bài viết tuyển dụng của bạn vi phạm quy tắc cộng đồng Mazii vì lý do : "' . $reason . '" . Mazii gửi mail để thông báo cho bạn bài viết sẽ bị xoá trong vài phút tới.';
                $data = array(
                    'from' => 'mazii',
                    'subject' => $subject,
                    'email' => $object->user->email,
                    'content' => $content,
                    'username' => $object->user->username,
                );
                NewJob::dispatch($data); // Queue
            }
            if ($type == 'check') {
                $subject = 'MAZII - THÔNG BÁO ĐĂNG BÀI TUYỂN DỤNG THÀNH CÔNG';
                $content = 'Mazii xin thông báo: bài đăng tuyển dụng " ' . $object->title . ' " đã được quản trị viên phê duyệt thành công';
                $data = array(
                    'from' => 'mazii',
                    'subject' => $subject,
                    'email' => $object->user->email,
                    'content' => $content,
                    'username' => $object->user->username,
                );
                NewJob::dispatch($data); // Queue
            }
            return response('success');
        }
        return response('error', 302);
    }

    // Sale release
    public function sale()
    {
        $id = request('id');
        $post = $this->post->findOneOrFail($id);
        $post->sale = !$post->sale;
        if ($post->save()) {
            return $this->success('success');
        } else return $this->error('fail', 500);
    }

    // View bài viết biên tập
    public function index()
    {
        $posts = $this->post->WithAll()->paginate();
        $languages = $this->language->all();
        $accounts = $this->account->all();
        $categories = $this->category->all();

        JavaScript::put([
            'link_socials_post' => route('backend.social.post'),
            'link_post_create' => route('backend.social.post.createOrupdate'),
            'link_post_delete' => route('backend.social.post.delete'),
        ]);


        $view = view('backend.social.post');
        $view->with('posts', $posts);
        $view->with('languages', $languages);
        $view->with('accounts', $accounts);
        $view->with('categories', $categories);
        return $view;
    }

    // Create Or Update
    public function createOrUpdate(CreatePostRequest $request)
    {
        $attribute = $request->only(['category_id', 'title', 'link', 'content', 'user_id']);
        if (isset($attribute['user_id'])) {
            $user = $this->account->findOneOrFail($attribute['user_id']);
            $attribute['language_id'] = $user->language_id;
            $attribute['status'] = 1;
        }
        $post = $this->post->createOrUpdatePost($attribute);
        return $this->success($post, 200);
    }

    // Detail Post
    public function detail(Post $post)
    {
        $languages = $this->language->all();
        $accounts = $this->account->all();
        $categories = $this->category->all();
        $listPost = $this->post->all();
        JavaScript::put([
            'link_socials_post' => route('backend.social.post')
        ]);
        $view = view('backend.social.detail');
        $view->with('post', $post);
        $view->with('languages', $languages);
        $view->with('accounts', $accounts);
        $view->with('categories', $categories);
        $view->with('listPost', $listPost);
        return $view;
    }

    // Delete post ( update status = -1 )
    public function delete()
    {
        $post = $this->post->findOneOrFail(request('id'));
        if ($post) {
            $post->delete();
            $post->save();
            return $this->success('Xóa thành công', 200);
        }
    }
}
