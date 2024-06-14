<?php
session_start(); // Mulai session
// Periksa apakah pengguna sudah login, jika ya alihkan ke halaman yang sesuai
if (isset($_SESSION['username'])) {
    header('Location: ../app/');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign in - Voler Admin Dashboard</title>
    <link rel="stylesheet" href="assets/css/bootstrap.css">

    <link rel="shortcut icon" href="assets/images/favicon.svg" type="image/x-icon">
    <link rel="stylesheet" href="assets/css/app.css">

    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="../app/assets/static/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
</head>

<body>
    <div id="auth">

        <div class="container">
            <div class="row">
                <div class="col-md-5 col-sm-12 mx-auto">
                    <div class="card pt-4">
                        <div class="card-body">
                            <div class="text-center mb-5">
                                <img src="assets/images/AntiSlot.png" height="150" class='mb-4'>
                                <h3>Sign In</h3>
                                <p>Please sign in to continue to AntiSlot.</p>
                            </div>
                            <form action="../config/auth.php" method="POST">
                                <div class="form-group position-relative has-icon-left">
                                    <label for="username">Username</label>
                                    <div class="position-relative">
                                        <input type="text" class="form-control" id="username" name="username">
                                        <div class="form-control-icon">
                                            <i data-feather="user"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group position-relative has-icon-left">
                                    <div class="clearfix">
                                        <label for="password">Password</label>
                                        <!-- <a href="auth-forgot-password.html" class='float-end'>
                                            <small>Forgot password?</small>
                                        </a> -->
                                    </div>
                                    <div class="position-relative">
                                        <input type="password" class="form-control" id="password" name="password">
                                        <div class="form-control-icon">
                                            <i data-feather="lock"></i>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class='form-check clearfix my-4'>
                                </div> -->
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
    <script src="assets/js/feather-icons/feather.min.js"></script>
    <script src="assets/js/app.js"></script>

    <script src="assets/js/main.js"></script>

    <!-- SweetAlert2 -->
    <script src="../app/assets/static/plugins/sweetalert2/sweetalert2.min.js"></script>

</body>

<!-- jika terjadi gagal login -->
<?php
if (isset($_GET['error'])) {
    $login = $_GET['error'];
    if ($login == 1) {
        echo "
        <script>
        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
          });    
        
            Toast.fire({
            icon: 'error',
            title: 'Login gagal!.'
          })
          </script>
          ";
    } else if ($login == 2) { //untuk username dan password nya kosong
        echo "
        <script>
        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
          });    
        
            Toast.fire({
            icon: 'warning',
            title: 'Username dan Password tidak boleh kosong.'
          })
          </script>
          ";
    }
}



?>

</html>