<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
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