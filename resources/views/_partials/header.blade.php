<div class="page-header md-shadow-z-1-i navbar navbar-fixed-top">
    <div class="page-header-inner container">
        <div class="page-logo">
            <a href="/">
                <img src="/img/logo.png" alt="logo" class="logo-default" style="margin-top: 8px; width: 135px;" />
            </a>
            <div class="menu-toggler sidebar-toggler">
            </div>
        </div>

        <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
        </a>

        <div class="page-actions">
            @if (auth()->user() && (auth()->user()->is_admin) or auth()->user()->is_super)
                <div class="btn-group">
                    <button type="button" class="btn btn-circle red-pink dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-plus"></i>&nbsp;<span class="hidden-sm hidden-xs">New&nbsp;</span>&nbsp;<i class="fa fa-angle-down"></i>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li>
                            <a data-toggle="modal" data-target="#websiteFormModal" href="javascript:;"><i class="fa fa-globe"></i> New website </a>
                        </li>
                        <li>
                            <a data-toggle="modal" data-target="#userFormModal" href="javascript:;"><i class="icon-user"></i> New user </a>
                        </li>
                    </ul>
                </div>
            @endif
            &nbsp;
            @if (auth()->user()->is_user)
                <div class="navbar-stats">
                    <span>Current month income: <strong>12.00 {{ auth()->user()->currency }}</strong></span>
                </div>
                <div class="navbar-stats">
                    <span>Last month income: <strong>0.00 {{ auth()->user()->currency }}</strong></span>
                </div>
            @endif
        </div>

        <div class="page-top">
            <div class="top-menu">
                <ul class="nav navbar-nav pull-right">
                    @if (auth()->user())

                    @if (!auth()->user()->is_user)
                        <flagged-conversation></flagged-conversation>
                    @endif

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
                                <a href="/users/{{ auth()->user()->id }}/account">
                                    <i class="icon-user"></i> Change password
                                </a>
                            </li>
                            <li class="divider"></li>
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
