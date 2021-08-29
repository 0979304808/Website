<?php

namespace App\Http\Controllers\BackEnd\Posts;

use App\Core\Traits\ApiResponser;
use App\Core\Traits\Authorization;
use App\Http\Requests\Posts\CreatePostRequest;
use App\Repositories\Categories\Contract\CategoryRepositoryInterface;
use App\Repositories\Posts\Contract\PostRepositoryInterface;
use App\Repositories\Tags\Contract\TagRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use JavaScript;

class PostController extends Controller
{
    use ApiResponser;
    use Authorization;
    private $post;
    private $category;
    private $tag;

    public function __construct(PostRepositoryInterface $post, CategoryRepositoryInterface $category, TagRepositoryInterface $tag)
    {
        $this->post = $post;
        $this->category = $category;
        $this->tag = $tag;
    }

    // View form create post
    public function form()
    {
        if (request('id')){
            $post = $this->post->find(request('id'));
            return view('backend.posts.form',['post' => $post]);
        }
        return view('backend.posts.form');
    }

    // View List Post
    public function list(Request $request)
    {

        $category = $request->get('category','all');
        $tag = $request->get('tag','all');
        $search = $request->get('search',null);
        if($category != 'all' && $category != null ){
            $posts = $this->post->WhereHasCategory($category);
        }
        if($tag != 'all' && $tag != null){
            $posts = $this->post->WhereHasTag($tag);
        }
        if($category != null && $tag != null && $tag != 'all' && $category != 'all'){
            $posts = $this->post->WherehasCategoryTag($category, $tag);
        }
        if($search != null ){
            $posts = $this->post->Search($search);  
        }
        if(!isset($posts)){
            $posts = $this->post->WithAll();
        }
        $categories = $this->category->all();
        $tags = $this->tag->all();
        $view = view('backend.posts.index');
        JavaScript::put([
            'posts' => $posts,
            'link_update_post_category' => route('backend.post.category'),
            'link_update_post_tag' => route('backend.post.tag'),
            'link_delete_post' => route('backend.post.delete'),
            'link_post' => route('backend.post'),
        ]);
        $view->with('posts', $posts);
        $view->with('categories', $categories);
        $view->with('tags', $tags);
        return $view;
    }

    // Create Post
    public function create(CreatePostRequest $request)
    {
        $attribute = $request->only(['title', 'description', 'img']);
        $attribute['admin_id'] = Auth::id();
        $this->post->createOrUpdate($attribute);
        if (request('id')){
            return redirect()->back()->with('msg','Sửa bài viết thành công');
        }
        return redirect()->back()->with('msg','Thêm bài viết mới thành công');

    }

    // Update Post to Category
    public function UpdatePostCategory()
    {
        $post = $this->post->findOneOrFail(request('id'));
        $categories = request(['categories']);
        if (!empty($categories)) {
            $post->categories()->sync($categories['categories']);
        } else {
            $post->categories()->detach();
        }
        return $this->success('Update');
    }

    // Update Post to Tag
    public function UpdatePostTag()
    {
        $post = $this->post->findOneOrFail(request('id'));
        $tags = request(['tags']);
        if (!empty($tags)) {
            $post->tags()->sync($tags['tags']);
        } else {
            $post->tags()->detach();
        }
        return $this->success('Update');
    }

    // Delete Post
    public function delete()
    {
        $post = $this->post->findOneOrFail(request('id'));
        if ($post->delete()) {
            $post->categories()->detach();
            $post->tags()->detach();
        }
        return $this->success('Delete');
    }
}
