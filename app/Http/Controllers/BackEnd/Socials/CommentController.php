<?php

namespace App\Http\Controllers\BackEnd\Socials;

use App\Core\Traits\ApiResponser;
use App\Http\Requests\Comments\CommentRequest;
use App\Models\Socials\Comment;
use App\Repositories\ChildComments\Contract\ChildCommentRepositoryInterface;
use App\Repositories\Comments\Contract\CommentRepositoryInterface;
use App\Repositories\Languages\Contract\LanguageRepositoryInterface;
use App\Repositories\UserMazii\Contract\UserMaziiRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use JavaScript;

class CommentController extends Controller
{
    use ApiResponser;
    private $language;
    private $comment;
    private $childComment;
    private $user;

    public function __construct(LanguageRepositoryInterface $language, CommentRepositoryInterface $comment, ChildCommentRepositoryInterface $childComment, UserMaziiRepositoryInterface $user)
    {
        $this->language = $language;
        $this->comment = $comment;
        $this->childComment = $childComment;
        $this->user = $user;
    }

    // List Comment
    public function index(Request $request)
    {
        //type_cmt = 1 cmt thường ;  2: cmt con
        $type_cmt = (in_array($request->get('typecmt'), [1, 2]) ? request('typecmt') : 1);
        $lang = $request->get('lang', '1');
        $status = $request->get('status', '0');
        $status_option = [
            '0' => 'Chưa duyệt',
            '1' => 'Đã duyệt',
            '-2' => 'Spam',
            '-1' => 'Đã xóa',
        ];
        if ($type_cmt == 1) {
            $comments = $this->comment;
        } else {
            $comments = $this->childComment;
        }
        if ($lang != null || $status != null) {
            $comments = $comments->whereLangStatus($lang, $status);
        } else {
            $comments = $comments->withAll();
        }

        $languages = $this->language->all();
        $comments = $comments->paginate();
        JavaScript::put([
            'link_getcomment' => route('backend.social.comment'),
            'link_update_status_post' => route('backend.social.release.update')
        ]);

        $view = view('backend.social.comment');
        $view->with('status_option', $status_option);
        $view->with('languages', $languages);
        $view->with('comments', $comments);
        return $view;
    }

    public function create(CommentRequest $request)
    {
        $data = $request->all();
        if (isset($data['user_id'])) {
            $user = $this->user->find($data['user_id']);
            $data['language_id'] = $user->language_id;
        }
        switch ($data['type']) {
            case 'comment':
                $new = $this->comment->createOrUpdateComment([
                    'status' => 1,
                    'user_id' => $data['user_id'],
                    'post_id' => $data['id'],
                    'content' => $data['content'],
                    'language_id' => $data['language_id']
                ]);
                if ($new) {
                    return $this->success($new, 201);
                }
                break;
            case 'child':
                $id = explode('-', $data['id']);
                $new = $this->childComment->createOrUpdateChildComment([
                    'status' => 1,
                    'user_id' => $data['user_id'],
                    'comment_id' => end($id),
                    'content' => $data['content'],
                    'language_id' => $data['language_id']
                ]);
                if ($new) {
                    return $this->success($new, 201);
                }
                break;
        }
    }

    public function update(CommentRequest $request)
    {
        $data = $request->all();
        switch ($data['type']) {
            case 'comment':
                $new = $this->comment->createOrUpdateComment([
                    'status' => 1,
                    'content' => $data['content'],
                ]);
                if ($new) {
                    return $this->success($new, 200);
                }
                break;
            case 'child':
                $new = $this->childComment->createOrUpdateChildComment([
                    'status' => 1,
                    'content' => $data['content'],
                ]);
                if ($new) {
                    return $this->success($new, 200);
                }
                break;
        }
    }

    public function delete()
    {
        switch (request('type')) {
            case 'comment':
                $new = $this->comment->find(request('id'));
                if ($new) {
                    $new->delete();
                    $new->save();
                    return $this->success('Xóa thành công', 200);
                }
                break;
            case 'child':
                $new = $this->childComment->find(request('id'));
                if ($new) {
                    $new->delete();
                    $new->save();
                    return $this->success('Xóa thành công', 200);
                }
                break;
        }
    }
}
