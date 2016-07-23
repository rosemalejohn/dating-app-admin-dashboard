<div class="page-sidebar-wrapper">
    <div class="page-sidebar navbar-collapse collapse">
        <!-- BEGIN SIDEBAR MENU -->
        <ul class="page-sidebar-menu page-sidebar-menu-hover-submenu page-sidebar-menu-closed" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
            <li class="start ">
                <a href="/">
                    <i class="icon-home"></i>
                    <span class="title">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="/conversations">
                    <i class="icon-envelope-open"></i>
                    <span class="title">Chat system</span>
                    <span class="arrow "></span>
                </a>
            </li>
            @if (auth()->user() && auth()->user()->is_admin)
            <li>
                <a href="/websites">
                    <i class="fa fa-globe"></i>
                    <span class="title">Manage Websites</span>
                    <span class="arrow "></span>
                </a>
            </li>
            <li>
                <a href="/users">
                    <i class="fa fa-users"></i>
                    <span class="title">Users</span>
                    <span class="arrow "></span>
                </a>
            </li>
            <li class="start ">
                <a href="/settings/system">
                    <i class="icon-settings"></i>
                    <span class="title">System Settings</span>
                </a>
            </li>
            @endif
        </ul>
        <!-- END SIDEBAR MENU -->
    </div>
</div>
