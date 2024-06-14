<li>
    @auth
        <form method="POST" action="{{ route('logout') }}">
            <a class="dropdown-item">
                @csrf
                <button style="background-color: transparent; border:none">
                    <i class="icon-mid bi bi-box-arrow-left me-2"></i>
                    Logout
                </button>
            </a>
        </form>
    @endauth
</li>
