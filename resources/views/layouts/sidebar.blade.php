<div class="side-nav">
    <div class="side-nav-inner">
        <ul class="side-nav-menu scrollable">
            <li class="nav-item dropdown">
                <a href="{{ route('home') }}">
                    <span class="icon-holder">
                        <i class="anticon anticon-dashboard"></i>
                    </span>
                    <span class="title">Dashboard</span>
                </a>
            </li>
            <li class="nav-item dropdown">
                <a href="{{ route('admin.equipment.index') }}">
                    <span class="icon-holder">
                        <i class="anticon anticon-team"></i>
                    </span>
                    <span class="title">Kelola Equipment</span>
                </a>
            </li>
            <li class="nav-item dropdown">
                <a href="{{ route('admin.user.index') }}">
                    <span class="icon-holder">
                        <i class="anticon anticon-team"></i>
                    </span>
                    <span class="title">Kelola User</span>
                </a>
            </li>
            <li class="nav-item dropdown">
                <a href="{{ route('user.setting.index') }}">
                    <span class="icon-holder">
                        <i class="anticon anticon-setting"></i>
                    </span>
                    <span class="title">Settings</span>
                </a>
            </li>
        </ul>
    </div>
</div>
