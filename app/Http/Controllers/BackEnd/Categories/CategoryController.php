<?php

namespace App\Http\Controllers\BackEnd\Categories;

use App\Core\Traits\ApiResponser;
use App\Repositories\Categories\Contract\CategoryRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use JavaScript;
class CategoryController extends Controller
{
    use ApiResponser;
    private $category;

    public function __construct(CategoryRepositoryInterface $category)
    {
        $this->category = $category;
    }

    public function list()
    {
        $categories = $this->category->all();
        JavaScript::put([
            'categories' => $categories,
            'link_delete_category' => route('backend.category.delete'),
        ]);
        $view = view('backend.categories.index');
        $view->with('categories', $categories);
        return $view;
    }

    public function createOrupdate(Request $request)
    {
        $attribute = $request->only('title');
        $this->category->create($attribute);
        return redirect()->back()->with('msg','Thêm danh mục thành công');

    }

    public function delete()
    {
        $category = $this->category->findOneOrFail(request('id'));
        if ($category){
            $category->delete();
            $category->posts()->detach();
            return $this->success('Delete');
        }

    }
}
