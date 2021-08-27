@extends('backend.layouts.master')
@section('after-script')
    {{ HTML::script('backend/js/posts/categoryAndtag.js') }}
    {{ HTML::script('backend/js/posts/updateAnddelete.js') }}
@endsection
@section('main')
<div class="col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2>Bài Viết<small>Danh sách</small></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                </li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="table-responsive">
                <table  id="datatable" class="table table-striped jambo_table table-bordered">
                    <thead>
                        <th>STT</th>
                        <th>Tiêu đề</th>
                        <th>Mô tả</th>
                        <th>Ảnh Bìa</th>
                        <th>Tác giả</th>
                        <th>Danh mục</th>
                        <th>Thẻ</th>
                        <th></th>
                    </thead>
                    <tbody>
                        @foreach ($posts as $key => $post)
                        <tr>
                            <td>{{ $key+1}}</td>
                            <td>{{ $post->title }}</td>
                            <td>{{ $post->description }}</td>
                            <td class="text-center"><img src="{{ $post->img ?? asset('images/default.png') }}" alt="" width="50" height="50"></td>
                            <td>{{ $post->author->username }}</td>
                            <td>
                                @foreach ($post->categories as $category)
                                    <span class="label label-primary">{{$category->title}}</span>
                                @endforeach
                            </td>
                            <td>
                                @foreach ($post->tags as $tag)
                                    <span class="label label-primary">{{$tag->title}}</span>
                                @endforeach
                            </td>
                            <td class="text-right">
                                @if (!$post->hasRole('administrator'))
                                <button type="button" class="btn btn-sm btn-dark btn-role-for-admin" data-key="{{ $key }}" data-id="{{ $post->id }}"><i class="fa fa-delicious"></i> Danh mục</button>
                                <button type="button" class="btn btn-sm btn-info btn-permission-for-admin" data-key="{{ $key }}" data-id="{{ $post->id }}"><i class="fa fa-cog"></i> Thẻ</button>
                                <a type="button" class="btn btn-sm btn-primary" href="{{ route('backend.post.form',['id' => $post->id]) }}"><i class="fa fa-pencil"></i></a>
                                <button type="button" class="btn btn-sm btn-danger btn-delete-post"  data-key="{{ $key }}" data-id="{{ $post->id }}"><i class="fa fa-trash-o"></i></button>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <!--Phân trang-->
                @include('backend.includes.pagination', ['data' => $posts])
            </div>
        </div>
    </div>
</div>

{{-- Modal list roles --}}
<div class="modal fade modal-role-admin" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">

        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title" id="">Danh mục</h4>
        </div>
        <div class="modal-body">
            <ul class="to_do">
                @foreach ($categories as $category)
                  <li>
                    <p><input type="checkbox" class="roles" name="{{ $category->title }}" value="{{ $category->id }}"> {{ $category->title }} </p>
                  </li>
                @endforeach
            </ul>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-success btn-save-change-role-admin">Cập nhật</button>
        </div>

      </div>
    </div>
</div>

{{-- Modal list permissions --}}
<div class="modal fade modal-permission-admin" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">

        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title" id="">Thẻ</h4>
        </div>
        <div class="modal-body">
            <ul class="to_do">
                @foreach ($tags as $tag)
                  <li>
                    <p><input type="checkbox" class="permissions" name="{{ $tag->title }}" value="{{ $tag->id }}"> {{ $tag->title }} </p>
                  </li>
                @endforeach
            </ul>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-success btn-save-change-permission">Cập nhật</button>
        </div>

      </div>
    </div>
</div>

@endsection