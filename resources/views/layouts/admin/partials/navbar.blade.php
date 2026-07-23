<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
    <div class="container-fluid">
        <button class="btn btn-link text-dark d-lg-none" id="sidebar-toggle">
            <i class="fas fa-bars"></i>
        </button>

        <div class="d-flex align-items-center ms-auto">
            <a href="{{ route('frontend.home') }}" class="btn btn-outline-primary btn-sm me-3" target="_blank">
                <i class="fas fa-external-link-alt me-1"></i> View Site
            </a>

            <div class="dropdown">
                <button class="btn btn-link text-dark dropdown-toggle text-decoration-none" type="button" data-bs-toggle="dropdown">
                    <i class="fas fa-user-circle me-2"></i>
                    {{ auth()->user()->name }}
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i> Profile</a></li>
                    <li><a class="dropdown-item" href="{{ route('admin.settings.index') }}"><i class="fas fa-cog me-2"></i> Settings</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item">
                                <i class="fas fa-sign-out-alt me-2"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
