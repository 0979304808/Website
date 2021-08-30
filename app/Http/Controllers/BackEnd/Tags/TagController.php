<?php

namespace App\Http\Controllers\BackEnd\Tags;

use App\Core\Traits\ApiResponser;
use App\Repositories\Tags\Contract\TagRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use JavaScript;

class TagController extends Controller
{
    use ApiResponser;
    private $tag;

    public function __construct(TagRepositoryInterface $tag)
    {
        $this->tag = $tag;
    }

    // List tags
    public function list()
    {
        $tags = $this->tag->all();
        JavaScript::put([
            'tags' => $tags,
            'link_delete_tag' => route('backend.tag.delete'),
        ]);
        $view = view('backend.tags.index');
        $view->with('tags', $tags);
        return $view;
    }

    // Create tag
    public function createOrupdate(Request $request)
    {
        $attribute = $request->only('title');
        $this->tag->create($attribute);
        return redirect()->back()->with('msg', 'Thêm thẻ thành công');

    }

    // Delete tag
    public function delete()
    {
        $tag = $this->tag->findOneOrFail(request('id'));
        if ($tag) {
            $tag->delete();
            $tag->posts()->detach();
            return $this->success('Delete');
        }

    }
}
