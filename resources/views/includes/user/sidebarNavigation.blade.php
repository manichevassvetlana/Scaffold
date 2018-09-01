<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">

            <li class="nav-item">
                <a href="{{ route('userDashboard') }}" class="nav-link active">
                    <i class="icon icon-speedometer"></i> Dashboard
                </a>
            </li>

            <li class="nav-title">User Functions</li>

            <li class="nav-item nav-dropdown">
                @impersonating
                <a href="#" class="nav-link nav-dropdown-toggle">
                    <i class="fas fa-magic"></i> Impersonation <i class="fa fa-caret-right"></i>
                </a>

                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a href="{{ route('impersonate-leave') }}" class="nav-link">
                            <i class="fas fa-user"></i> Leave
                        </a>
                    </li>
                </ul>
                @endImpersonating
            </li>

        </ul>
    </nav>
</div>