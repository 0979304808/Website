<?php

namespace App\Http\Controllers\BackEnd\Socials;

use App\Core\Traits\ApiResponser;
use App\Repositories\ChildComments\Contract\ChildCommentRepositoryInterface;
use App\Repositories\Comments\Contract\CommentRepositoryInterface;
use App\Repositories\Languages\Contract\LanguageRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use JavaScript;

class CommentController extends Controller
{
    use ApiResponser;
    private $language;
    private $comment;
    private $childComment;

    public function __construct(LanguageRepositoryInterface $language, CommentRepositoryInterface $comment, ChildCommentRepositoryInterface $childComment)
    {
        $this->language = $language;
        $this->comment = $comment;
        $this->childComment = $childComment;
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
}
