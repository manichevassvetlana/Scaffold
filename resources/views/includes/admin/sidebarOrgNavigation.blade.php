<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">

            <li class="nav-item">
                <a href="{{ route('adminDashboard') }}" class="nav-link active">
                    <i class="icon icon-speedometer"></i> Dashboard
                </a>
            </li>

            <li class="nav-title">Admin Functions</li>

            <li class="nav-item nav-dropdown">
                <a href="#" class="nav-link nav-dropdown-toggle">
                    <i class="fas fa-tag"></i> Organization <i class="fa fa-caret-right"></i>
                </a>

                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a href="{{ route('organization-user.index') }}" class="nav-link">
                            <i class="fas fa-folder"></i> Manage Users
                        </a>
                    </li>
                </ul>
            </li>

        </ul>
    </nav>
</div>