<div class="page-sidebar-wrapper">
    <div class="page-sidebar navbar-collapse collapse">
        <ul class="page-sidebar-menu page-sidebar-menu-hover-submenu page-sidebar-menu-closed" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
            @if (auth()->user() && (auth()->user()->is_admin) or auth()->user()->is_super)
            <li class="start">
                <a href="/">
                    <i class="icon-chart"></i>
                    <span class="title">Dashboard</span>
                </a>
            </li>
            @endif
            <li>
                <a href="/chat">
                    <i class="icon-bubbles"></i>
                    <span class="title">Chat lobby</span>
                    <span class="arrow "></span>
                </a>
            </li>
            @if (auth()->user() && (auth()->user()->is_admin) or auth()->user()->is_super)
            <li>
                <a href="/websites">
                    <i class="icon-globe"></i>
                    <span class="title">Manage Websites</span>
                    <span class="arrow "></span>
                </a>
            </li>
            <li>
                <a href="/users">
                    <i class="icon-people"></i>
                    <span class="title">Moderators</span>
                    <span class="arrow "></span>
                </a>
            </li>
            <li>
                <a href="/settings/system">
                    <i class="icon-settings"></i>
                    <span class="title">System Settings</span>
                </a>
            </li>
            @endif

            @if (config('site.enable_affiliate') && auth()->user()->is_super)
            <li>
                <a href="/affiliates/teams">
                    <i class="icon-organization"></i>
                    <span class="title">Affiliates</span>
                </a>
            </li>
            <li>
                <a href="/affiliates/marketing">
                    <i class="icon-credit-card"></i>
                    <span class="title">Marketing</span>
                </a>
            </li>
            @endif
        </ul>
        <!-- END SIDEBAR MENU -->
    </div>
</div>
