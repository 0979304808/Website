<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    @role('administrator|manager')
    <div class="menu_section">
        <h3>Cộng đồng</h3>
        <ul class="nav side-menu">
            <li class="{{ Request::is('social') ? 'active' : '' }}"><a><i class="fa fa-folder-open-o" aria-hidden="true"></i> Cộng đồng Mazii <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li class="{{ Request::is('posts') ? 'active' : '' }}">
                        <a href="{{ route('backend.social.release') }}">Bài viết cộng đồng</a>
                    </li>
                    <li class="{{ Request::is('comment') ? 'active' : '' }}">
                        <a href="{{ route('backend.social.release.comment') }}">Quản lý bình luận</a>
                    </li>
                    <li class="{{ Request::is('posts') ? 'active' : '' }}">
                        <a href="{{ route('backend.social.post') }}">Bài viết biên tập</a>
                    </li>
                    <li class="{{ Request::is('accounts') ? 'active' : '' }}">
                        <a href="{{ route('backend.social.account') }}">Tài khoản</a>
                    </li>
                    <li class="{{ Request::is('report') ? 'active' : '' }}">
                        <a href="{{ route('backend.social.release.report') }}">Báo cáo vi phạm</a>
                    </li>
                    <li class="{{ Request::is('jlpt') ? 'active' : '' }}">
                        <a href="{{ route('backend.social.jlpt.index') }}">Thông tin về JLPT</a>
                    </li>
                </ul>
            </li>
            <li class="{{ Request::is('admin/partner/*') ? 'active' : '' }}"><a><i class="fa fa-folder-open-o" aria-hidden="true"></i> Đối tác<span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li class="{{ Request::is('*partner/') ? 'active' : '' }}">
                        <a href="{{ route('backend.partner.index') }}">Danh sách đối tác</a>
                    </li>
                    <li class="{{ Request::is('*partner/create') ? 'active' : '' }}">
                        <a href="{{ route('backend.partner.create') }}">Thêm đối tác</a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
    @endrole
    @permission('update-content|read-content')
    <div class="menu_section">
        <h3>Nội dung</h3>
        <ul class="nav side-menu">
            <li class="{{ Request::is('editor') ? 'active' : '' }}"><a><i class="fa fa-folder-open-o" aria-hidden="true"></i> Từ vựng <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    @permission('update-content')
                    <li class="{{ Request::is('words') ? 'active' : '' }}">
                        <a href="{{ route('backend.editor.word') }}">Biên tập</a>
                    </li>
                    @endpermission
                    @permission('read-content')
                    <li class="{{ Request::is('approved') ? 'active' : '' }}">
                        <a href="{{ route('backend.editor.approve') }}">Kiểm duyệt</a>
                    </li>
                    @endpermission
                    <li class="{{ Request::is('statistic') ? 'active' : '' }}">
                        <a href="{{ route('backend.editor.statistic') }}">Thống kê</a>
                    </li>
                </ul>
            </li>
            <li class="{{ Request::is('editor') ? 'active' : '' }}"><a><i class="fa fa-folder-open-o" aria-hidden="true"></i> Từ chuyên ngành<span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    @permission('read-content')
                    <li class="{{ Request::is('major') ? 'active' : '' }}">
                        <a href="{{ route('backend.editor.word.major') }}">Duyệt từ</a>
                    </li>
                    @endpermission
                    <li class="{{ Request::is('statistic') ? 'active' : '' }}">
                        <a href="{{ route('backend.editor.word.major.statistic') }}">Thống kê</a>
                    </li>
                </ul>
            </li>
            <li class="{{ Request::is('editor') ? 'active' : '' }}"><a><i class="fa fa-folder-open-o" aria-hidden="true"></i> Góp ý người dùng<span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li class="{{ Request::is('words') ? 'active' : '' }}">
                        <a href="{{ route('backend.editor.word.wrong') }}">Danh sách từ vựng</a>
                    </li>
                    <li class="{{ Request::is('words') ? 'active' : '' }}">
                        <a href="{{ route('backend.editor.word.wrong.statistic') }}">Thống kê</a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
    @endpermission
    {{-- <div class="menu_section">
        <h3>Quảng cáo</h3>
        <ul class="nav side-menu">
            <li class="{{ Request::is('ads') ? 'active' : '' }}"><a><i class="fa fa-file-text"></i> Ads <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li class="{{ Request::is('ads/*/app') ? 'active' : '' }}">
                        <a href="{{ route('backend.ads') }}">Danh sách</a>
                    </li>
                </ul>
            </li>
        </ul>
    </div> --}}
    {{-- @role('administrator|manager')
    <div class="menu_section">
        <h3>Mã bản quyền</h3>
        <ul class="nav side-menu">
            <li class="{{ Request::is('projects') ? 'active' : '' }}"><a><i class="fa fa-cubes"></i> Dự án <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li class="{{ Request::is('list') ? 'active' : '' }}">
                        <a href="{{ route('backend.project.list') }}">Danh sách dự án</a>
                    </li>
                    <li class="{{ Request::is('prices') ? 'active' : '' }}">
                        <a href="{{ route('backend.project.price') }}">Bảng giá mã code</a>
                    </li>
                    <li class="{{ Request::is('orders') ? 'active' : '' }}">
                        <a href="{{ route('backend.project.order') }}">Danh sách đơn hàng</a>
                    </li>
                    <li class="{{ Request::is('logs') ? 'active' : '' }}">
                        <a href="{{ route('backend.project.log') }}">Danh sách kích hoạt mã</a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
    @endrole --}}
    @role('administrator')
    <div class="menu_section">
        <h3>Quản lý premium</h3>
        <ul class="nav side-menu">
            <li class="{{ Request::is('premium') ? 'active' : '' }}"><a href="{{ route('backend.premium') }}"><i class="fa fa-star-half-o" aria-hidden="true"></i> Gói nâng cấp</a></li>
            <li class="{{ Request::is('admin/code/*') ? 'active' : '' }}"><a><i class="fa fa-folder-open-o" aria-hidden="true"></i> Quản lý mã bản quyền<span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li class="{{ Request::is('*code/transaction') ? 'active' : '' }}">
                        <a href="{{ route('backend.code.transaction') }}">Phiên giao dịch</a>
                    </li>
                    <li class="{{ Request::is('*code/codesended') ? 'active' : '' }}">
                        <a href="{{ route('backend.code.codesended') }}">Mã đã gửi</a>
                    </li>
                    <li class="{{ Request::is('*user/usersubscribe') ? 'active' : '' }}">
                        <a href="{{ route('backend.user.usersubcribe.index') }}">User Subscribes</a>
                    </li>
                </ul>
            </li>
            <li class="{{ Request::is('admin/user/*') ? 'active' : '' }}"><a><i class="fa fa-folder-open-o" aria-hidden="true"></i> Quản lý người dùng<span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li class="{{ Request::is('*user/user-mazii') ? 'active' : '' }}">
                        <a href="{{ route('backend.user.user-mazii.index') }}">User</a>
                    </li>
                    <li class="{{ Request::is('*user/expired') ? 'active' : '' }}">
                        <a href="{{ route('backend.user.expried') }}">User hết hạn premium</a>
                    </li>
                </ul>
            </li>
            <li class="{{ Request::is('admin/jobs/*') ? 'active' : '' }}"><a><i class="fa fa-folder-open-o" aria-hidden="true"></i> Quản lý Jobs<span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li class="{{ Request::is('*job/') ? 'active' : '' }}">
                        <a href="{{ route('backend.job.index') }}">Danh sách công việc</a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
    @endrole

    <div class="menu_section">
        <h3>Tài khoản</h3>
        <ul class="nav side-menu">
            @role('administrator')
            <li class="{{ Request::is('auth') ? 'active' : '' }}"><a><i class="fa fa-folder-open-o" aria-hidden="true"></i> Tài khoản <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li class="{{ Request::is('account') ? 'active' : '' }}">
                        <a href="{{ route('backend.account') }}">Danh sách</a>
                    </li>
                    <li class="{{ Request::is('role') ? 'active' : '' }}">
                        <a href="{{ route('backend.role') }}">Phân quyền - vai trò</a>
                    </li>
                </ul>
            </li>
            @endrole
            <li class="{{ Request::is('profile') ? 'active' : '' }}"><a href="{{ route('backend.profile', ['admin' => $guard->id]) }}"><i class="fa fa-user" aria-hidden="true"></i> Thông tin cá nhân</a></li>
        </ul>
    </div>
        
</div>