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
                    <i class="fas fa-magic"></i> Maintenance <i class="fa fa-caret-right"></i>
                </a>

                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a href="{{ route('users.index') }}" class="nav-link">
                            <i class="fas fa-user"></i> Users
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('organizations.index') }}" class="nav-link">
                            <i class="fas fa-sitemap"></i> Organizations
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('roles.index') }}" class="nav-link">
                            <i class="fas fa-lock"></i> Roles
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('plans.index') }}" class="nav-link">
                            <i class="fas fa-list-ol"></i> Plans
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('abilities.index') }}" class="nav-link">
                            <i class="fas fa-bicycle"></i> Abilities
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('subscriptions.index') }}" class="nav-link">
                            <i class="fas fa-user-plus"></i> Subscriptions
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item nav-dropdown">
                <a href="#" class="nav-link nav-dropdown-toggle">
                    <i class="fas fa-tag"></i> Catalog <i class="fa fa-caret-right"></i>
                </a>

                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a href="{{ route('categories.index') }}" class="nav-link">
                            <i class="fas fa-folder"></i> Categories
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('lookup-values.index') }}" class="nav-link">
                            <i class="fas fa-list-ul"></i> Lookup Values
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item nav-dropdown">
                <a href="#" class="nav-link nav-dropdown-toggle">
                    <i class="fas fa-angle-double-right"></i> Localization <i class="fa fa-caret-right"></i>
                </a>

                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a href="{{ route('countries.index') }}" class="nav-link">
                            <i class="fas fa-angle-right"></i> Manage Countries
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('states.index') }}" class="nav-link">
                            <i class="fas fa-angle-right"></i> Manage States
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('cities.index') }}" class="nav-link">
                            <i class="fas fa-angle-right"></i> Manage Cities
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('postal-codes.index') }}" class="nav-link">
                            <i class="fas fa-angle-right"></i> Manage Postal Codes
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('addresses.index') }}" class="nav-link">
                            <i class="fas fa-angle-right"></i> Manage Addresses
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('counties.index') }}" class="nav-link">
                            <i class="fas fa-angle-right"></i> Manage Counties
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('locations.index') }}" class="nav-link">
                            <i class="fas fa-angle-right"></i> Manage Locations
                        </a>
                    </li>
                </ul>

            </li>

            <li class="nav-item nav-dropdown">
                <a href="#" class="nav-link nav-dropdown-toggle">
                    <i class="fas fa-cogs"></i> System <i class="fa fa-caret-right"></i>
                </a>

                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a href="{{ route('announcements.index') }}" class="nav-link">
                            <i class="fas fa-bullhorn"></i> Manage Announcements
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('notifications.index') }}" class="nav-link">
                            <i class="fas fa-exclamation-circle"></i> Manage Notifications
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('entity-relationships.index') }}" class="nav-link">
                            <i class="fas fa-angle-right"></i> Entity Relationships
                        </a>
                    </li>
                </ul>

            </li>

            <li class="nav-item nav-dropdown">
                <a href="#" class="nav-link nav-dropdown-toggle">
                    <i class="fas fa-laptop"></i> Developers <i class="fa fa-caret-right"></i>
                </a>

                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a href="{{ route('developers.index') }}" class="nav-link">
                            <i class="fas fa-user-md"></i> Manage Developers
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('apis.index') }}" class="nav-link">
                            <i class="fas fa-flask"></i> Manage APIs
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('documents.index') }}" class="nav-link">
                            <i class="fas fa-book"></i> Manage Documents
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('repositories.index') }}" class="nav-link">
                            <i class="fas fa-code-branch"></i> Manage Repositories
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('sdks.index') }}" class="nav-link">
                            <i class="fas fa-code"></i> Manage SDK's
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item nav-dropdown">
                <a href="#" class="nav-link nav-dropdown-toggle">
                    <i class="fas fa-laptop"></i> Content <i class="fa fa-caret-right"></i>
                </a>

                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a href="{{ route('pages.index') }}" class="nav-link">
                            <i class="fas fa-user-md"></i> Pages
                        </a>
                    </li>
                </ul>
            </li>

        </ul>
    </nav>
</div>