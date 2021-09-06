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
    {{ HTML::script('backend/js/social/comment.js') }}
@endsection
@section('main')
    <div class="content">
        <!--Phân trang-->
        <div class="col-xs-9">
            <div class="col-xs-12">
                <div class="form-group col-xs-3" >
                    <select class="form-control statusOptionCmt" >
                        @foreach ($status_option as $k => $v)
                            <option value="{{$k}}" {{($k == request('status')) ? 'selected' : ''}}>{{$v}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-xs-3" >
                    <select class="form-control languageOptionCmt"  >
                        @foreach ($languages as  $v)
                            <option value="{{$v->id}}" {{($v->id == request('lang')) ? 'selected' : ''}}>{{$v->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-xs-3" >
                    <select class="form-control cmtOption"  >
                        <option value="1" {{(request('typecmt') == 1) ? 'selected' : ''}}>Bình luận</option>
                        <option value="2" {{(request('typecmt') == 2) ? 'selected' : ''}}>Bình luận con</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="col-xs-12">
            @foreach ($comments as $key => $comment)
                <div class="col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                             <h5 class="title"><strong></strong></h5>

                            <div class="post-head">
                                <div class="col-xs-1 post-img">
                                    <img src="{{ empty($comment->user->profile->image) ? url('images/user.png') : $comment->user->profile->image }}" alt="">
                                </div>
                                <div class="col-xs-6">
                                    <strong>{{ $comment->user->username }}</strong>
                                    <p>
                                        {{ $comment->created_at->diffForHumans() }} 
                                        <br>
                                        <p><a href="https://mazii.net/qa?detail={{ (request('type_cmt') ==1) ? $comment->post->id : 0}}" target="_blank">Đến trang nguồn</a></p>
                                    </p>
                                </div>
                                <div class="col-xs-5">
                                    <div class="btn-group pull-right">
                                        @if (request('status') == -1 || request('status') == -2)
                                        <button class="btn btn-xs btn-action btn-primary" data-kind="{{(request('typecmt') == 1 ||request('typecmt') == 0) ? '2' : '3'}}" data-type="new" data-id="{{ $comment->id }}" data-text="{{ substr(strip_tags($comment->content), 0, 30) }}"><i class="fa fa-undo"></i>Reset</button>
                                        @else
                                        <button class="btn btn-xs btn-action btn-primary" data-kind="{{(request('typecmt') == 1 ||request('typecmt') == 0) ? '2' : '3'}}" data-type="check" data-id="{{ $comment->id }}" data-text="{{ substr(strip_tags($comment->content), 0, 30) }}">{{ ($comment->status) ? 'Bỏ duyệt' : 'Duyệt' }}</button>
                                        <button class="btn btn-xs btn-action btn-warning" data-kind="{{(request('typecmt') == 1 ||request('typecmt') == 0) ? '2' : '3'}}" data-type="spam" data-id="{{ $comment->id }}"  data-text="{{ substr(strip_tags($comment->content), 0, 30) }}">Spam</button>
                                        <button class="btn btn-xs btn-action btn-danger" data-kind="{{(request('typecmt') == 1 ||request('typecmt') == 0) ? '2' : '3'}}" data-type="delete" data-id="{{ $comment->id }}"  data-text="{{ substr(strip_tags($comment->content), 0, 30) }}">Xoá</button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="post-content" style="overflow-wrap: break-word;">
                                {!! $comment->content !!}
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="col-xs-12 text-center">
            {!! $comments->appends(['status' => request('status') , 'lang' => request('lang'), 'typecmt' => request('typecmt')])->links() !!}
        </div>
    </div>
@endsection