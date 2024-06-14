<header class="mb-3">
    <nav class="navbar navbar-expand navbar-light navbar-top">
        <div class="container-fluid">
            <a href="#" class="burger-btn d-block">
                <i class="bi bi-justify fs-3"></i>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-lg-0">
                    </li>
                </ul>
                <div class="dropdown">
                    <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="user-menu d-flex">
                            <div class="user-name text-end me-3">
                                <h6 class="mb-0 text-gray-600">{{ session('user_name') }}</h6>
                                {{-- <h6 class="mb-0 text-gray-600">Jhon Dhey</h6> --}}
                                <p class="mb-0 text-sm text-gray-600">Administrator</p>
                            </div>
                            <div class="user-img d-flex align-items-center">
                                <div class="avatar avatar-md">
                                    <img src="{{ '../template/assets/compiled/jpg/2.jpg' }}">
                                </div>
                            </div>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton"
                        style="min-width: 11rem; max-height:11.5rem">
                        <li>
                            <h6 class="dropdown-header">Hello, {{ session('user_name') }}</h6>
                        </li>
                        <li><a class="dropdown-item" href="{{ route('profile') }}"><i
                                    class="icon-mid bi bi-person me-2"></i> My
                                Profile</a></li>
                        <li><a class="dropdown-item" href="{{ route('dashboard.settings') }}"><i
                                    class="icon-mid bi bi-gear me-2"></i>
                                Settings</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        @include('auth.logout');
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</header>
