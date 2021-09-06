@extends('backend.layouts.master')
@section('after-script')
    {{ HTML::script('backend/js/packages/premium.js') }}
@endsection
@section('main')
    <div class="col-md-8 col-xs-12" style="position: -webkit-sticky; position: sticky; top: 0;">
        <div class="x_panel">
            <div class="x_title">
                <h2 class="col-md-3 col-xs-3">Danh sách: </h2>
                <div class="col-md-3 col-sm-3 col-xs-3">
                    <select name="package" class="form-control fillter_width_url">
                        <option value="{{ route('backend.premium') }}" {{ ($package == null) ? 'selected' : ''}}>Tất cả</option>
                        <option value="{{ route('backend.premium', ['pac' => '1month']) }}" {{ ($package == '1month') ? 'selected' : ''}}>1 Tháng</option>
                        <option value="{{ route('backend.premium', ['pac' => '6month']) }}" {{ ($package == '6month') ? 'selected' : ''}}>6 Tháng</option>
                        <option value="{{ route('backend.premium', ['pac' => '1year']) }}" {{ ($package == '1year') ? 'selected' : ''}}>1 Năm</option>
                    </select>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-3">
                    <select name="package" class="form-control fillter_width_url">
                        <option value="{{ route('backend.premium', ['pac' => $package]) }}" {{ ($pub === 'all') ? 'selected' : ''}}>Tất cả</option>
                        <option value="{{ route('backend.premium', ['pac' => $package, 'pub' => true]) }}" {{ ($pub === '1') ? 'selected' : ''}}>Phát hành</option>
                        <option value="{{ route('backend.premium', ['pac' => $package, 'pub' => false]) }}" {{ (!$pub) ? 'selected' : ''}}>Chưa phát hành</option>
                    </select>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <th>STT</th>
                        <th class="text-center">Gói Nâng Cấp</th>
                        <th></th>
                        </thead>
                        <tbody>
                        @foreach ($packages as $key => $package)
                            <tr>
                                <td class="text-center align-middle">{{ $key + 1 }}</td>
                                <td>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody>
                                            <tr>
                                                <td class="text-right">ID : </td>
                                                <td>{{ $package->package }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-right">Tên gói : </td>
                                                <td><a href="#" class="editable" data-country="false" data-id="{{ $package->id }}" data-field="name">{{ $package->name }}</a></td>
                                            </tr>
                                            <tr>
                                                <td class="text-right">Mô tả : </td>
                                                <td><a href="#" class="editable" data-country="false" data-id="{{ $package->id }}" data-field="description">{{ $package->description }}</a></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                            <th class="text-center">Quốc gia</th>
                                            <th class="text-center">Ngày sale</th>
                                            <th class="text-center">Ngày kết thúc</th>
                                            <th class="text-center">Giá gốc</th>
                                            <th class="text-center">% sale</th>
                                            </thead>
                                            <tbody>
                                            @foreach ($package->countries as $country)
                                                <tr>
                                                    <td class="text-center">{{ $country->country }}</td>
                                                    <td class="text-center"><a href="#" data-type="date" class="editable-time" data-id="{{ $country->id }}" data-country="true" data-field="time_on_sale">{{ $country->time_on_sale }}</a></td>
                                                    <td class="text-center"><a href="#" data-type="date" class="editable-time" data-id="{{ $country->id }}" data-country="true" data-field="time_on_finish">{{ $country->time_on_finish }}</a></td>
                                                    <td class="text-center"><a href="#" class="editable" data-id="{{ $country->id }}" data-country="true" data-field="price">{{ $country->price }}</a></td>
                                                    <td class="text-center"><a href="#" class="editable" data-id="{{ $country->id }}" data-country="true" data-field="sale">{{ $country->sale }}</a> %</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </td>
                                <td class="text-center align-middle">
                                    <button class="btn btn-block btn-{{ ($package->publish) ? 'success' : 'default' }} btn-xs btn-publish" data-id="{{ $package->id }}" data-publish="{{ $package->publish }}">{{ ($package->publish) ? 'Phát hành' : 'Chưa phát hành' }}</button>
                                    <button class="btn btn-block btn-danger btn-xs btn-delete" data-id="{{ $package->id }}"><i class="fa fa-trash"></i> Xoá</button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-xs-12" style="position: -webkit-sticky; position: sticky; top: 0;">
        <div class="x_panel">
            <div class="x_title">
                <h2 class="col-md-12 col-xs-12">Thêm gói nâng cấp: </h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form action="{{ route('backend.premium.store') }}" method="POST" data-parsley-validate>
                    {{ csrf_field() }}
                    <label>ID * :</label>
                    <select name="package" class="form-control">
                        <option value="1month">1 Tháng</option>
                        <option value="6month">6 Tháng</option>
                        <option value="1year">1 Năm</option>
                    </select>
                    <br>

                    <label>Tên gói * :</label>
                    <input type="text" class="form-control" name="name" required />
                    <br>

                    <label>Mô tả * :</label>
                    <textarea name="description" class="form-control" id="" cols="30" rows="4"></textarea>
                    <br>

                    <label for="">Quốc gia :</label>
                    <input type="text" class="form-control" name="vn" value="vn" placeholder="Việt Nam" readonly />

                    <br>
                    <label>Ngày sale * :</label>
                    <input type="date" class="form-control" name="time_on_sale_vn" value="{{ date('Y-m-d', strtotime("+1 day")) }}"/>

                    <br>
                    <label>Ngày kết thúc * :</label>
                    <input type="date" class="form-control" name="time_on_finish_vn" value="{{ date('Y-m-d', strtotime("+2 day")) }}"/>

                    <br>
                    <div class="form-group has-feedback">
                        <label>Giá gốc * :</label>
                        <input type="text" name="price_vn" class="form-control" placeholder="45000">
                        <span class="fa form-control-feedback right" aria-hidden="true">vnđ</span>
                    </div>

                    <br>
                    <label>% sale * :</label>
                    <select name="sale_vn" class="form-control">
                        <option value="">Chọn sale %</option>
                        @for ($i = 70; $i > 0; $i-=5)
                            <option value="{{ $i }}">{{ $i }} %</option>
                        @endfor
                    </select>

                    <br>
                    <label for="">Quốc gia :</label>
                    <input type="text" class="form-control" name="jp" value="jp" placeholder="Nhật Bản" readonly />

                    <br>
                    <label>Ngày sale * :</label>
                    <input type="date" class="form-control" name="time_on_sale_jp" value="{{ date('Y-m-d', strtotime("+1 day")) }}" />

                    <br>
                    <label>Ngày kết thúc * :</label>
                    <input type="date" class="form-control" name="time_on_finish_jp" value="{{ date('Y-m-d', strtotime("+2 day")) }}"/>

                    <br>
                    <div class="form-group has-feedback">
                        <label>Giá gốc * :</label>
                        <input type="text" name="price_jp" class="form-control" placeholder="20">
                        <span class="fa fa-jpy form-control-feedback right" aria-hidden="true"></span>
                    </div>

                    <br>
                    <label>% sale * :</label>
                    <select name="sale_jp" class="form-control">
                        <option value="">Chọn sale %</option>
                        @for ($i = 70; $i > 0; $i-=5)
                            <option value="{{ $i }}">{{ $i }} %</option>
                        @endfor
                    </select>

                    <br>
                    <div class="form-group">
                        <button class="btn btn-success">Thêm mới</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
