<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - AntiSlot</title>
    @include('include.auth.style')

</head>

<body>
    <div id="auth">

        <div class="container">
            <div class="row">
                <div class="col-md-5 col-sm-12 mx-auto">
                    <div class="card pt-4">
                        <div class="card-body">
                            <div class="text-center mb-5">
                                <img src="{{ asset('template/assets/login/assets/images/AntiSlot.png') }}"
                                    height="150" class='mb-4'>
                                <h3>Login</h3>
                                <p>Please login to continue to AntiSlot.</p>
                            </div>
                            <form method="POST" action="{{ route('login.store') }}">
                                @csrf
                                @if (session()->has('loginError'))
                                    <div class="alert alert-light-danger color-danger"><i
                                            data-feather="alert-circle"></i>
                                        {{ session('loginError') }}
                                    </div>
                                @endif
                                <div class="form-group position-relative has-icon-left">
                                    <label for="email">Email</label>
                                    <div class="position-relative">
                                        <input type="text"
                                            class="form-control @error('email') is invalid
                                            
                                        @enderror"
                                            id="email" name="email">
                                        <div class="form-control-icon">
                                            <i data-feather="user"></i>
                                        </div>
                                    </div>
                                    @error('email')
                                        <small class="btn btn-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group position-relative has-icon-left">
                                    <div class="clearfix">
                                        <label for="password">Password</label>
                                    </div>
                                    <div class="position-relative">
                                        <input type="password"
                                            class="form-control @error('password') is invalid
                                            
                                        @enderror"
                                            id="password" name="password">
                                        <div class="form-control-icon">
                                            <i data-feather="lock"></i>
                                        </div>
                                    </div>
                                    @error('password')
                                        <small class="btn btn-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="clearfix">
                                    <button class="btn btn-primary float-end">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    @include('include.auth.script')
</body>

</html>
