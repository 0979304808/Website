@extends('backend.layouts.master')
@section('after-script')
    {{ HTML::script('backend/js/code/transaction.js') }}
@endsection
@section('main')
    <div class="col-md-12 col-xs-12" style="position: -webkit-sticky; position: sticky; top: 0;">
        <div class="x_panel">
            @if (session('msg'))
                <div class="alert alert-success">
                    {{ session('msg') }}
                </div>
            @endif
            <form method="POST" action="{{ route('backend.code.import') }}" enctype="multipart/form-data">
                @csrf
                @method('POST')
                <div class="form-group">
                    <input class="form-control" type="file" name="file">
                </div>
                <div class="form-group">
                    <input class="btn btn-primary" type="submit" value="Import">
                </div>
            </form>
        </div>
    </div>
@endsection
