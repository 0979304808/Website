<?php

namespace App\Http\Controllers\BackEnd\Socials;

use App\Core\Traits\ApiResponser;
use App\Http\Requests\Jlpts\CreateJlptRequest;
use App\Models\Posts\Post;
use App\Repositories\Jlpt\Contract\JlptRepositoryInterface;
use App\Repositories\Languages\Contract\LanguageRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use JavaScript;

class JlptController extends Controller
{
    use ApiResponser;
    private $jlpt;
    private $language;

    public function __construct(JlptRepositoryInterface $jlpt, LanguageRepositoryInterface $language)
    {
        $this->jlpt = $jlpt;
        $this->language = $language;
    }

    // List thông tin về jlpt
    public function index(Request $request)
    {
        $search = $request->get('search', null);
        if ($search != null) {
            $jlpts = $this->jlpt->search($search);
        }
        if (!isset($jlpts)) {
            $jlpts = $this->jlpt->WithAll()->paginate();
        } else {
            $jlpts = $jlpts->paginate();
        }
        JavaScript::put([
            'url_list_jlpt' => route('backend.social.jlpt.index'),
            'url_store_jlpt' => route('backend.social.jlpt.store'),
            'url_delete_jlpt' => route('backend.social.jlpt.delete'),
        ]);
        $views = view('backend.social.jlpt.index');
        $views->with('jlpts', $jlpts);
        return $views;
    }

    // View create or update
    public function create()
    {
        $languages = $this->language->all();
        $views = view('backend.social.jlpt.create');
        if (request('id') != null) {
            $jlpt = $this->jlpt->find(request('id'));
            $views->with('jlpt', $jlpt);
        }
        $views->with('languages', $languages);
        return $views;
    }

    // Xử lý Create or Update
    public function createOrUpdate(CreateJlptRequest $request)
    {
        $attribute = $request->only(['title', 'shortDes', 'descHtml', 'image', 'language_id']);
        $attribute['admin_id'] = Auth::id();
        $jlpt = $this->jlpt->createOrUpdate($attribute);
        if ($jlpt === true ) {
            return redirect()->back()->with('success','Cập nhật bài viết thành công');
        }
            return redirect(route('backend.social.jlpt.create') . '?id=' . $jlpt->id)->with('success', 'Thêm bài viết thành công');
    }

    // Delete
    public function delete()
    {
        $id = request('id');
        if ($id){
            return $this->jlpt->deleteJplt($id);
        }
        return $this->error('Bad request',400);
    }
}
