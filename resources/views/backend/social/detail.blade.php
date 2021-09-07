@extends('backend.layouts.master')
@section('before-css')
    {{ HTML::style('vendors/google-code-prettify/bin/prettify.min.css') }}
    <style>
        .post-content img{width: 100%;}
        .btn-comment{border: none;}
        .post-img{padding-left: 0px;}
        .post-img img{width: 40px; height: 40px; border-radius: 50%}
        .box-comment, .box-comment .box-child-comment{margin-top: 15px;}
        .box-child-comment .post-img{margin-right: 1em;}
        hr{margin-top: 5px; border: 1px solid #E6E9ED}
    </style>
@endsection
@section('before-script')
    {{ HTML::script('vendors/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js') }}
    {{ HTML::script('vendors/jquery.hotkeys/jquery.hotkeys.js') }}
    {{ HTML::script('vendors/google-code-prettify/src/prettify.js') }}
@endsection
@section('after-script')
    {{ HTML::script('backend/js/social/post.js') }}
@endsection
@section('main')
    @include('backend.includes.previous', ['back_link' => URL::previous()])
    <div class="filter">
        <div class="form-group col-xs-3">
            <label class="control-label col-xs-4" for="language">Language</label>
            <div class="form-group col-xs-8">
                <select name="language" id="" class="form-control fillter_width_url">
                    {{--@foreach ($languages as $short => $lang)--}}
                        {{--<option value="{{ route('backend.social.post', ['lang' => $short]) }}" {{ ($language == $short) ? 'selected' : '' }} >{{ $lang }}</option>--}}
                    {{--@endforeach--}}
                </select>
            </div>
        </div>
        <div class="form-group col-xs-3">
            <label class="control-label col-xs-4" for="account">Account</label>
            <div class="form-group col-xs-8">
                <select name="account" id="" class="form-control">
                    @foreach ($accounts as $key => $account)
                        <option value="{{ $account['userId'] }}">{{ $account['username'] }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="col-xs-9">
            <div class="col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h5 class="title"><strong>{!! $post->title !!}</strong></h5>
                        <div class="post-head">
                            <div class="col-xs-1 post-img">
                                <img src="{{ empty($post->user->profile['image']) ? url('images/user.png') : $post->user->profile['image'] }}" alt="">
                            </div>
                            <div class="col-xs-10">
                                <strong>{{ $post->user['username'] }}</strong>
                                <p>
                                    {{ $post->created_at->diffForHumans() }} 
                                    <span class="label">{{$post->category['name']}}</span>
                                    <a href="{{ empty($post->link) ? '#' : $post->link }}" target="_blank"><span class="label">Đến trang nguồn</span></a>
                                </p>
                            </div>
                            <div class="col-xs-1">
                                <ul class="nav navbar-right panel_toolbox">
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                        <ul class="dropdown-menu" role="menu">
                                            <li><a href="javascript:void();" class="btn btn-edit-post" data-id="{{ $post->id }}" data-toggle="modal" data-target=".bs-modal-edit-post-{{$post->id}}">Edit</a></li>
                                            <li><a href="javascript:void();" class="btn btn-delete-post" data-id="{{ $post->id }}">Delete</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="post-content" style="overflow-wrap: break-word;">
                            {!! $post->content !!}
                        </div>
                    </div>
                    <button class="btn btn-default btn-comment" data-id="{{ $post->id }}"><i class="fa fa-comments"></i> Comments <span>({{ count($post->comments->where('status',1)) }})</span></button>
                    <div class="comments-{{$post->id}} hidden">
                        <hr>
                        <div class="x_content">
                            <div class="text-editor">
                                <div class="col-xs-1 post-img">
                                    <img src="{{ url('images/user.png') }}" alt="">
                                </div>
                                <div class="col-xs-11">
                                    @include('backend.includes.editor', ['id' => $post->id, 'type' => 'comment', 'height' => 60])
                                </div>
                            </div>
                        </div>
                        @foreach ($post->comments->where('status',1) as $index => $comment)
                            <div class="box-comment col-xs-12">
                                <div class="post-head">
                                    <div class="col-xs-1 post-img">
                                        <img src="{{ empty($comment->user->profile['image']) ? url('images/user.png') : $comment->user->profile['image'] }}" alt="">
                                    </div>
                                    <div class="col-xs-11">
                                        <div class="parent col-xs-12">
                                            <ul class="nav navbar-right panel_toolbox">
                                                <li class="dropdown">
                                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                                    <ul class="dropdown-menu" role="menu">
                                                        <li><a href="" class="btn btn-edit-comment" data-id="{{ $comment->id }}" data-type="comment" data-toggle="modal" data-target=".bs-modal-edit-comment-{{$comment->id}}">Edit</a></li>
                                                        <li><a href="" class="btn btn-delete-comment" data-id="{{ $comment->id }}" data-type="comment">Delete</a></li>
                                                    </ul>
                                                </li>
                                            </ul>
                                            <strong>{{ $comment->user['username'] }}</strong>
                                            <p>{{ $comment->created_at->diffForHumans() }}</p>
                                            <div class="post-content" style="overflow-wrap: break-word;">
                                                {!! $comment->content !!}
                                            </div>
                                            <button class="btn btn-default btn-comment btn-child pull-right" data-id="{{$comment->id}}"><i class="fa fa-comment"> ({{ count($comment->childComments->where('status',1)) }})</i></button>
                                        </div>
                                        <div class="box-child-comments-{{$comment->id}} hidden">
                                            <div class="col-xs-12 editor-child-{{$comment->id}}">
                                                <div class="text-editor">
                                                    <div class="col-xs-1 post-img">
                                                        <img src="{{ url('images/user.png') }}" alt="">
                                                    </div>
                                                    <div class="col-xs-11">
                                                        @include('backend.includes.editor', ['id' => "child-$comment->id", 'type' => 'child', 'height' => 60])
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="childs col-xs-12">
                                                @foreach ($comment->childComments->where('status',1) as $child)
                                                    <div class="box-comment box-child-comment col-xs-12">
                                                        <div class="col-xs-1 post-img">
                                                            <img src="{{ empty($child->user->profile['image']) ? url('images/user.png') : $child->user->profile['image'] }}" alt="">
                                                        </div>
                                                        <div class="col-xs-9">
                                                            <strong>{{ $child->user['username'] }}</strong>
                                                            <p>{{ $child->created_at->diffForHumans() }}</p>
                                                            <div class="post-content" style="overflow-wrap: break-word;">
                                                                {!! $child->content !!}
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-1">
                                                            <ul class="nav navbar-right panel_toolbox">
                                                                <li class="dropdown">
                                                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                                                    <ul class="dropdown-menu" role="menu">
                                                                        <li><a href="" class="btn btn-edit-comment" data-id="{{ $child->id }}" data-type="child" data-toggle="modal" data-target=".bs-modal-edit-child-{{$child->id}}">Edit</a></li>
                                                                        <li><a href="" class="btn btn-delete-comment" data-id="{{ $child->id }}" data-type="child">Delete</a></li>
                                                                    </ul>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <!-- Modal edit comment-->
                                                    <div class="modal fade bs-modal-edit-child-{{$child->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                                                                    </button>
                                                                    <h4 class="modal-title" id="">Sửa bài viết</h4>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form name="form-create-account" enctype="multipart/form-data" class="form-horizontal form-label-left">
                                                                        <div class="form-group">
                                                                            <div class="col-xs-12">
                                                                                <div class="btn-toolbar editor" data-role="editor-toolbar-edit-child-{{$child->id}}" data-target="#editor-edit-child{{$child->id}}">
                                                                                    <div class="btn-group">
                                                                                        <a class="btn" data-edit="bold" title="Bold (Ctrl/Cmd+B)"><i class="fa fa-bold"></i></a>
                                                                                        <a class="btn" data-edit="italic" title="Italic (Ctrl/Cmd+I)"><i class="fa fa-italic"></i></a>
                                                                                        <a class="btn" data-edit="underline" title="Underline (Ctrl/Cmd+U)"><i class="fa fa-underline"></i></a>
                                                                                    </div>
                                                                                    <div class="btn-group">
                                                                                        <a class="btn" data-edit="insertunorderedlist" title="Bullet list"><i class="fa fa-list-ul"></i></a>
                                                                                        <a class="btn" data-edit="insertorderedlist" title="Number list"><i class="fa fa-list-ol"></i></a>
                                                                                        <a class="btn" data-edit="outdent" title="Reduce indent (Shift+Tab)"><i class="fa fa-dedent"></i></a>
                                                                                        <a class="btn" data-edit="indent" title="Indent (Tab)"><i class="fa fa-indent"></i></a>
                                                                                    </div>
                                                                                    <div class="btn-group">
                                                                                        <a class="btn" data-edit="justifyleft" title="Align Left (Ctrl/Cmd+L)"><i class="fa fa-align-left"></i></a>
                                                                                        <a class="btn" data-edit="justifycenter" title="Center (Ctrl/Cmd+E)"><i class="fa fa-align-center"></i></a>
                                                                                        <a class="btn" data-edit="justifyfull" title="Justify (Ctrl/Cmd+J)"><i class="fa fa-align-justify"></i></a>
                                                                                    </div>
                                                                                </div>

                                                                                <div id="editor-edit-child-{{$child->id}}" data-id="{{ $child->id }}" class="editor-wrapper" style="min-height: 60px;">
                                                                                    {!! $child->content !!}
                                                                                </div>

                                                                                <div class="form-group pull-right" style="margin-top: 8px;">
                                                                                    <button class="btn btn-sm btn-primary btn-edit-submit-comment form-control" data-type="child" data-id="{{ $child->id }}">Submit</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal edit comment-->
                            <div class="modal fade bs-modal-edit-comment-{{$comment->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                                            </button>
                                            <h4 class="modal-title" id="">Sửa bài viết</h4>
                                        </div>
                                        <div class="modal-body">
                                            <form name="form-create-account" enctype="multipart/form-data" class="form-horizontal form-label-left">
                                                <div class="form-group">
                                                    <div class="col-xs-12">
                                                        <div class="btn-toolbar editor" data-role="editor-toolbar-edit-comment-{{$comment->id}}" data-target="#editor-edit-comment{{$comment->id}}">
                                                            <div class="btn-group">
                                                                <a class="btn" data-edit="bold" title="Bold (Ctrl/Cmd+B)"><i class="fa fa-bold"></i></a>
                                                                <a class="btn" data-edit="italic" title="Italic (Ctrl/Cmd+I)"><i class="fa fa-italic"></i></a>
                                                                <a class="btn" data-edit="underline" title="Underline (Ctrl/Cmd+U)"><i class="fa fa-underline"></i></a>
                                                            </div>
                                                            <div class="btn-group">
                                                                <a class="btn" data-edit="insertunorderedlist" title="Bullet list"><i class="fa fa-list-ul"></i></a>
                                                                <a class="btn" data-edit="insertorderedlist" title="Number list"><i class="fa fa-list-ol"></i></a>
                                                                <a class="btn" data-edit="outdent" title="Reduce indent (Shift+Tab)"><i class="fa fa-dedent"></i></a>
                                                                <a class="btn" data-edit="indent" title="Indent (Tab)"><i class="fa fa-indent"></i></a>
                                                            </div>
                                                            <div class="btn-group">
                                                                <a class="btn" data-edit="justifyleft" title="Align Left (Ctrl/Cmd+L)"><i class="fa fa-align-left"></i></a>
                                                                <a class="btn" data-edit="justifycenter" title="Center (Ctrl/Cmd+E)"><i class="fa fa-align-center"></i></a>
                                                                <a class="btn" data-edit="justifyfull" title="Justify (Ctrl/Cmd+J)"><i class="fa fa-align-justify"></i></a>
                                                            </div>
                                                        </div>

                                                        <div id="editor-edit-comment-{{$comment->id}}" data-id="{{ $comment->id }}" class="editor-wrapper" style="min-height: 60px;">
                                                            {!! $comment->content !!}
                                                        </div>

                                                        <div class="form-group pull-right" style="margin-top: 8px;">
                                                            <button class="btn btn-sm btn-primary btn-edit-submit-comment form-control" data-type="comment" data-id="{{ $comment->id }}">Submit</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal edit post-->
        <div class="modal fade bs-modal-edit-post-{{$post->id}}" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                        </button>
                        <h4 class="modal-title" id="">Sửa bài viết</h4>
                    </div>
                    <div class="modal-body">
                        <form name="form-create-account" enctype="multipart/form-data" class="form-horizontal form-label-left">
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <select name="category" id="category-edit-post-{{$post->id}}" class="form-control">
                                        @foreach ($categories as $id => $category)
                                            <option value="{{ $category->id }}" {{($post->category_id == $category->id) ? 'selected' : ''}}>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <input type="text" name="title" required="required" id="title-edit-post-{{$post->id}}" value="{!!$post->title!!}" class="form-control col-xs-12">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <div class="btn-toolbar editor" data-role="editor-toolbar-edit-post-{{$post->id}}" data-target="#editor-edit-post{{$post->id}}">
                                        <div class="btn-group">
                                            <a class="btn" data-edit="bold" title="Bold (Ctrl/Cmd+B)"><i class="fa fa-bold"></i></a>
                                            <a class="btn" data-edit="italic" title="Italic (Ctrl/Cmd+I)"><i class="fa fa-italic"></i></a>
                                            <a class="btn" data-edit="underline" title="Underline (Ctrl/Cmd+U)"><i class="fa fa-underline"></i></a>
                                        </div>
                                        <div class="btn-group">
                                            <a class="btn" data-edit="insertunorderedlist" title="Bullet list"><i class="fa fa-list-ul"></i></a>
                                            <a class="btn" data-edit="insertorderedlist" title="Number list"><i class="fa fa-list-ol"></i></a>
                                            <a class="btn" data-edit="outdent" title="Reduce indent (Shift+Tab)"><i class="fa fa-dedent"></i></a>
                                            <a class="btn" data-edit="indent" title="Indent (Tab)"><i class="fa fa-indent"></i></a>
                                        </div>
                                        <div class="btn-group">
                                            <a class="btn" data-edit="justifyleft" title="Align Left (Ctrl/Cmd+L)"><i class="fa fa-align-left"></i></a>
                                            <a class="btn" data-edit="justifycenter" title="Center (Ctrl/Cmd+E)"><i class="fa fa-align-center"></i></a>
                                            <a class="btn" data-edit="justifyfull" title="Justify (Ctrl/Cmd+J)"><i class="fa fa-align-justify"></i></a>
                                        </div>  
                                    </div>
                                    
                                    <div id="editor-edit-post-{{$post->id}}" data-id="{{ $post->id }}" class="editor-wrapper" style="min-height: 60px;">
                                        {!! $post->content !!}
                                    </div>
                                    
                                    <div class="form-group pull-right" style="margin-top: 8px;">
                                        <button class="btn btn-sm btn-primary btn-edit-submit form-control" data-type="post" data-id="{{ $post->id }}">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        {{-- right tab --}}
        <div class="col-xs-3">
            <div class="x_panel">
                @foreach ($listPost as $item)
                <div class="x_title">
                    <a href="{{ route('backend.social.post.detail', ['post' => $item->id, 'lang' => request('lang'), 'category' => request('category') ]) }}">{{ $item->title }}</a>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="clearfix"></div>

@endsection