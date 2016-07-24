<div class="page-header md-shadow-z-1-i navbar navbar-fixed-top">
    <div class="page-header-inner container">
        <div class="page-logo">
            <a href="/chat"></a>
            <div class="menu-toggler sidebar-toggler">
            </div>
        </div>

        <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
        </a>
        <div class="page-top">
            <div class="top-menu">
                <ul class="nav navbar-nav pull-right">
                    @if (auth()->user())
                    <li class="dropdown dropdown-user">
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                            @if (auth()->user()->profile)
                                <img alt="" class="img-circle" src="{{ auth()->user()->profile->photo }}" />
                            @else
                                <img alt="" class="img-circle" src="/img/default-photo.png" />
                            @endif
                            <span class="username username-hide-on-mobile">{{ auth()->user()->name }}</span>
                            <i class="fa fa-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-default">
                            <li>
                                <a href="/profile">
                                    <i class="icon-user"></i> My Profile </a>
                            </li>
                            <li><a href="/settings"><i class="icon-settings"></i> Settings</a></li>

                            <li class="divider">
                            </li>
                            <li>
                                <a href="/logout">
                                    <i class="icon-key"></i> Log Out </a>
                            </li>
                        </ul>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>
