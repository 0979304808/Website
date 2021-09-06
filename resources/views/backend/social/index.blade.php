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
@section('after-script')
    {{ HTML::script('backend/js/social/release.js') }}
@endsection
@section('main')
    <div class="content">
        <!--Phân trang-->
        <div class="col-xs-12">
            <div class="col-xs-12">
                <div class="form-group col-xs-3" >
                    <select class="form-control statusOption" >
                        @foreach ($status_option as $key => $value)
                            <option value="{{$key}}" @if(request('status') == $key) selected @endif>{{$value}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-xs-3" >
                    <select class="form-control languageOption"  >
                        @foreach ($languages as  $key => $value)
                            <option value="{{$value->id}}" @if(request('lang') == $value->id) selected @endif>{{$value->name}}</option>
                        @endforeach
                    </select>
                </div>
                <a href="{{route('backend.social.release').'?pin=1'}}">
                    <button class="btn btn-default pull-right {{(request('pin')) ? 'active' : ''}}">Bài viết đã ghim</button>
                </a>
                <a href="{{route('backend.social.release').'?choice=1'}}">
                    <button class="btn btn-default pull-right  {{(request('choice')) ? 'active' : ''}}">Bài viết Yêu thích</button>
                </a>
            </div>
        </div>

        <div class="col-xs-12">
            @foreach ($posts as $key => $post)
                <div class="col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h5 class="title"><strong>{!! $post->title !!}</strong></h5>
                            <div class="post-head">
                                <div class="col-xs-1 post-img">
                                    <img src="{{ empty($post->user->profile->image) ? url('images/user.png') : $post->user->profile->image }}" alt="">
                                </div>
                                <div class="col-xs-6">
                                    <strong>{{ $post->user->username }}</strong>
                                    <p>
                                        {{ $post->created_at->diffForHumans() }}
                                        <span class="label">{{$post->category->name}}</span><br>
                                        <p><a href="{{'https://mazii.net/qa?detail='. $post->id}}" target="_blank">Đến trang nguồn</a></p>
                                    </p>
                                </div>
                                <div class="col-xs-5">
                                    <button class="btn btn-xs btn-sale btn-{{($post->sale) ? 'success' : 'default'}}" data-id="{{ $post->id }}" data-status="{{$post->sale}}">Bài sale</button>
                                    <div class="btn-group pull-right">
                                        @if ($post->status == -1 || $post->status == -2)
                                        <button class="btn btn-xs btn-action btn-primary" data-kind="1" data-type="new" data-id="{{ $post->id }}"><i class="fa fa-undo"></i>Reset</button>
                                        @else
                                        <button class="btn btn-xs btn-action btn-primary" data-kind="1" data-type="check" data-id="{{ $post->id }}">{{ ($post->status) ? 'Bỏ duyệt' : 'Duyệt' }}</button>
                                        <button class="btn btn-xs btn-action btn-info" data-kind="1" data-type="pin" data-id="{{ $post->id }}">{{ ($post->top) ? 'Bỏ ghim' : 'Ghim' }}</button>
                                        <button class="btn btn-xs btn-action btn-success" data-kind="1" data-type="choice" data-id="{{ $post->id }}">{{ ($post->editor_choice) ? 'Bỏ Yêu Thích' : 'Yêu Thích'}}</button>
                                        <button class="btn btn-xs btn-action btn-warning" data-kind="1" data-type="spam" data-id="{{ $post->id }}"  data-text="{{ substr(strip_tags($post->content), 0, 30) }}">Spam</button>
                                        <button class="btn btn-xs btn-action btn-danger" data-kind="1" data-type="delete" data-id="{{ $post->id }}"  data-text="{{ substr(strip_tags($post->content), 0, 30) }}">Xoá</button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="post-content" style="overflow-wrap: break-word;">
                                {!! $post->content !!}
                            </div>
                        </div>
                        <button class="btn btn-default btn-comment" data-id="{{ $post->id }}"><i class="fa fa-comments"></i> Comments <span>({{ count($post->comments) }})</span></button>
                        <div class="comments-{{$post->id}} hidden">
                            @foreach ($post->comments as $index => $comment)
                                <div class="box-comment col-xs-12">
                                    <div class="post-head">
                                        <div class="col-xs-1 post-img">
                                            <img src="{{ empty($comment->user->profile->image) ? url('images/user.png') : $comment->user->profile->image }}" alt="">
                                        </div>
                                        <div class="col-xs-11">
                                            <div class="parent col-xs-12
                                            @switch($comment->status)
                                                @case(1)
                                                    {{'bg-success'}}
                                                    @break
                                                @case(-1)
                                                    {{'bg-danger'}}
                                                    @break
                                                @case(-2)
                                                    {{'bg-warning'}}
                                                    @break
                                            @endswitch
                                            " >
                                                <div class="btn-group pull-right">
                                                    @if ($comment->status == -1 || $comment->status == -2)
                                                    <button class="btn btn-xs btn-action btn-primary" data-kind="2" data-type="new" data-id="{{ $comment->id }}"><i class="fa fa-undo"></i>Reset</button>
                                                    @else
                                                    <button class="btn btn-xs btn-action btn-primary" data-kind="2" data-type="check" data-id="{{ $comment->id }}">{{($comment->status == 1) ? 'Bỏ duyệt' : 'Duyệt'}}</button>
                                                    <button class="btn btn-xs btn-action btn-warning" data-kind="2" data-type="spam" data-id="{{ $comment->id }}" data-text="{{ substr(strip_tags($comment->content), 0, 30) }}">Spam</button>
                                                    <button class="btn btn-xs btn-action btn-danger" data-kind="2" data-type="delete" data-id="{{ $comment->id }}" data-text="{{ substr(strip_tags($comment->content), 0, 30) }}">Xóa</button>
                                                    @endif
                                                </div>
                                                <strong>{{ $comment->user->username }}</strong>
                                                @switch($comment->status)
                                                    @case(1)
                                                        <label class="label label-primary">Bình luận này đã được duyệt</label>
                                                        @break
                                                    @case(-1)
                                                        <label class="label label-danger">Bình luận này đã bị xoá</label>
                                                        @break
                                                    @case(-2)
                                                        <label class="label label-warning">Bình luận này đã bị gắn spam</label>
                                                        @break
                                                @endswitch
                                                <p>{{ $comment->created_at->diffForHumans() }}</p>
                                                <div class="post-content" style="overflow-wrap: break-word;">
                                                    {!! $comment->content !!}
                                                </div>
                                                <button class="btn btn-default btn-child pull-right" data-id="{{$comment->id}}"><i class="fa fa-comment">{{ count($comment->childComments) }}</i></button>
                                            </div>
                                            <div class="box-child-comments-{{$comment->id}} hidden">
                                                <div class="childs col-xs-12">
                                                    @foreach ($comment->childComments as $child)
                                                        <div class="box-comment box-child-comment-{{ $comment->id }} col-xs-12">
                                                            <div class="col-xs-1 post-img">
                                                                <img src="{{ empty($child->user->profile->image) ? url('images/user.png') : $child->user->profile->image }}" alt="">
                                                            </div>
                                                            <div class="col-xs-11
                                                            @switch($child->status)
                                                                @case(1)
                                                                    {{'bg-success'}}
                                                                    @break
                                                                @case(-1)
                                                                    {{'bg-danger'}}
                                                                    @break
                                                                @case(-2)
                                                                    {{'bg-warning'}}
                                                                    @break
                                                                @endswitch
                                                            ">
                                                                <div class="col-xs-8 ">
                                                                    <strong>{{ $child->user->username }}</strong>
                                                                    @switch($child->status)
                                                                        @case(1)
                                                                            <label class="label label-primary">Bình luận này đã được duyệt</label>
                                                                            @break
                                                                        @case(-1)
                                                                            <label class="label label-danger">Bình luận này đã bị xoá</label>
                                                                            @break
                                                                        @case(-2)
                                                                            <label class="label label-warning">Bình luận này đã bị gắn spam</label>
                                                                            @break
                                                                    @endswitch
                                                                    <p>{{ $child->created_at->diffForHumans() }}</p>
                                                                    <div class="post-content" style="overflow-wrap: break-word;">
                                                                        {!! $child->content !!}
                                                                    </div>
                                                                </div>
                                                                <div class="col-xs-3">
                                                                    <div class="btn-group pull-right">
                                                                        @if ($child->status == -1 || $child->status == -2)
                                                                            <button class="btn btn-xs btn-action btn-primary" data-kind="3" data-type="new" data-id="{{ $child->id }}"><i class="fa fa-undo"></i>Reset</button>
                                                                        @else
                                                                            <button class="btn btn-xs btn-action btn-primary" data-kind="3" data-type="check" data-id="{{ $child->id }}">{{($child->status == 1) ? 'Bỏ duyệt' : 'Duyệt'}}</button>
                                                                            <button class="btn btn-xs btn-action btn-warning" data-kind="3" data-type="spam" data-id="{{ $child->id }}" data-text="{{ substr(strip_tags($child->content), 0, 30) }}">Spam</button>
                                                                            <button class="btn btn-xs btn-action btn-danger" data-kind="3" data-type="delete" data-id="{{ $child->id }}" data-text="{{ substr(strip_tags($child->content), 0, 30) }}">Xóa</button>
                                                                        @endif
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
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <!--Phân trang-->
        <div class="col-xs-12">
            <div class="col-xs-12">
                <div class="col-xs-12 text-center">
                    {!! $posts->appends(['status' => request('status') , 'lang' => request('lang'), 'choice' => request('choice'), 'pin' => request('pin')])->links() !!}
                </div>
            </div>
        </div>
    </div>
@endsection