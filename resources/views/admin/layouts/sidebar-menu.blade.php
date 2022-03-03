<nav>
    <div class="sidebar-top">
        <span class="shrink-btn">
        <i class='fa fa-chevron-left'></i>
        </span>
        <img height="70" src="{{ asset('storage/images/logo.svg') }}" class="logo" alt="">
        <h3 class="hide">{{ config('app.name') }}</h3>
    </div>
    <div class="sidebar-links">
        <ul>
            <li class="tooltip-element {{ request()->is('admin/dashboard') ? 'active' : '' }}" data-tooltip="0">
                <a href="{{ route('admin.dashboard') }}" data-active="0">
                    <i class="fa fa-tachometer-alt"></i>
                    <span class="link hide">Dashboard</span>
                </a>
            </li>
            <li class="tooltip-element {{ request()->is('admin/users*') ? 'active' : '' }}" data-tooltip="1">
                <a href="{{ route('admin.users.index') }}" data-active="1">
                    <i class="fa fa-user"></i>
                    <span class="link hide">Cooks</span>
                </a>
            </li>
            <li class="tooltip-element {{ request()->is('admin/recipes*') ? 'active' : '' }}" data-tooltip="2">
                <a href="{{ route('admin.recipes.index') }}" data-active="2">
                    <i class="fa fa-pizza-slice"></i>
                    <span class="link hide">Recipes</span>
                </a>
            </li>
            <li class="tooltip-element {{ request()->is('admin/reviews*') ? 'active' : '' }}" data-tooltip="3">
                <a href="{{ route('admin.reviews.index') }}" data-active="3">
                    <i class="far fa-star"></i>
                    <span class="link hide">Reviews</span>
                </a>
            </li>
            <li class="tooltip-element {{ request()->is('admin/comments*') ? 'active' : '' }}" data-tooltip="4">
                <a href="{{ route('admin.comments.index') }}" data-active="4">
                    <i class="fa fa-comment"></i>
                    <span class="link hide">Comments</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="sidebar-footer">
        <div class="admin-user tooltip-element" data-tooltip="1">
            <div class="admin-profile hide">
                <img src="{{ asset('/storage/avatars') }}/{{ auth()->user()->image }}" alt="">
                <div class="admin-info">
                    <h3>{{ auth()->user()->name }}</h3>
                    <h5>Admin</h5>
                </div>
            </div>
            <a href="{{ route('admin.logout') }}" class="log-out text-decoration-none">
                <i class='fa fa-sign-out-alt'></i>
            </a>
        </div>
    </div>
</nav>
