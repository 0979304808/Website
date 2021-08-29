@extends('backend.layouts.master')
@section('after-script')
{{--  <script src="{{ url('backend/js/code/codesended.js') }}"></script>  --}}
@endsection
@section('main')
    <div class="col-md-12 col-xs-12" style="position: -webkit-sticky; position: sticky; top: 0;">
        <div class="x_panel">
            <div class="x_title">
                <h2 class="col-md-3 col-xs-3">Danh sách mã đã gửi: </h2>
                <hr><br>
                <div class="col-md-2 col-sm-2 col-xs-2">
                    <p>Lọc:</p>
                    <select name="sort" class="form-control">
                        <option value="new" {{ $sort == 'new' ? 'selected' : '' }}>Mới nhất</option>
                        <option value="old" {{ $sort == 'old' ? 'selected' : '' }}>Cũ nhất</option>
                    </select>
                </div>
                <div class="col-md-2 col-sm-2 col-xs-2">
                    <p>Tìm kiếm:</p>
                    <select name="state" class="form-control">
                        @foreach ($state as $k => $v)
                            <option value="{{ $k }}" {{ $status == $k ? 'selected' : '' }}>{{ $v }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-4">
                    <p>Nhập mã code:</p>
                    <input type="text" class="form-control input-search" placeholder="Nhập mã code..."
                        value="{{ $code }}">
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="table-responsive">
                    {!! $paging['html'] !!}
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <th class="text-center">STT</th>
                            <th class="text-center">Code</th>
                            <th class="text-center">NV gửi mã</th>
                            <th class="text-center">Thời hạn</th>
                            <th class="text-center">Lý do</th>
                            <th class="text-center">User kích hoạt</th>
                            <th class="text-center">User đặt mua</th>
                            <th class="text-center">Biên tập</th>
                        </thead>
                        <tbody>
                            @foreach ($list_codes->data as $key => $code)
                                <tr>
                                    <td>{{ $from_stt_of_view += 1 }}</td>
                                    <td>
                                        <span>{{ $code->serialkey }}</span>
                                        <span
                                            class="pull-right label label-{{ $code->state == 0 ? 'default' : ($code->state == 1 ? 'warning' : 'success') }}">{{ $state[$code->state] }}</span>
                                    </td>
                                    <td>
                                        @if (isset($code->purchase->admin->username))
                                            {{ $code->purchase->admin->username }}
                                        @endif
                                    </td>
                                    <td>
                                        {{ $code->day_active != 10 ? $expired[$code->day_active] : '' }}
                                    </td>
                                    <td> {{ $code->reason }} </td>
                                    <td>
                                        @if (isset($code->active) && !empty($code->active))
                                            <p>{{ 'id: ' . $code->active->userId }}</p>
                                            <p>{{ 'email: ' . $code->active->user->email }}</p>
                                            <p>{{ 'username: ' . $code->active->user->username }}</p>
                                        @endif
                                    </td>
                                    <td>
                                        @if (isset($code->purchase) && !empty($code->purchase))
                                            <p>{{ 'email:' . $code->purchase->email }}</p>
                                            <p>{{ 'phone:' . $code->purchase->phone }}</p>
                                            <p>{{ 'name:' . $code->purchase->name }}</p>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group" style="float: right">
                                            <button type="button"
                                                class="btn btn-sm btn-recalled {{ in_array($code->state, [0, 2]) ? 'disabled' : 'btn-primary' }}"
                                                data-key="{{ $code->serialkey }}">
                                                Thu hồi
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                    {!! $paging['html'] !!}
                </div>
            </div>
        </div>
    </div>
@endsection
