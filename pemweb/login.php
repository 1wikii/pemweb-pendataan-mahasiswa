<?php
$title = 'Login';
require_once('views/layoutCSS.php');
require_once('objects/user.php');

// server melakukan login
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $account = new User($email, $password);
    $validation = $account->LOGIN();

    // Validation 
    if (!$validation['email']) {
        echo "<script>alert('Email tidak ditemukan, login kembali !');</script>";

    }
    if (!$validation['password']) {
        echo "<script>alert('Password salah, login kembali !');</script>";
    }

    if ($validation['email'] && $validation['password']) {

        // buat session ketika login berhasil
        session_start();
        $_SESSION['isLogin'] = true;

        // buat cookie untuk username
        // Cookie berlaku 3 hari
        setcookie("username", $account->getUsername(), time() + (86400 * 3), "/");

        echo "<script>alert('Berhasil login !');
            window.location.href = 'home.php';
        </script>";
    }

}

?>

<body>

    <div class="container-fluid d-flex justify-content-center align-items-center container-login100"
        style="height: 100vh; background-image: url('assets/bg.jpg');">

        <form class="container-xxl bg-white p-5 rounded" style="width: 40%;" action="<?php $_SERVER['PHP_SELF'] ?>"
            method="POST">
            <p class="text-center login100-form-title">
                Login
            </p>

            <div class="mb-3">
                <label for="email" class="form-label">Email </label>
                <input name="email" type="text" class="form-control" id="email">
                <?php if (isset($isEmailFail) && $isEmailFail): ?>
                    <span class="error-message text-danger">Email tidak ditemukan !</span>
                <?php endif; ?>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input name="password" type="password" class="form-control" id="password">
            </div>

            <button type="submit" name="login" class="btn btn-primary rounded font-custom" style="width: 100%;"
                id="submit">Login</button>

            <p class="m-1 text-center">Already have account ? <a href="signup.php">Sign Up</a></p>
        </form>

    </div>


    <?php
    require_once('views/layoutJS.php');
    ?>

    <script>
        $(document).ready(function () {

            // validasi email ketika user mengetik
            $("#email").on("input blur", function () {

                // Hapus pesan sebelumnya
                $(".error-message").remove();

                // Validasi email
                const email = $(this).val().trim();  // hilangkan semua spasi
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;   // regex untuk cek format email
                if (email === "") {
                    $(this).after('<span class="error-message text-danger">Email harus diisi</span>');
                } else if (!emailRegex.test(email)) {
                    $(this).after('<span class="error-message text-danger">Email tidak valid</span>');
                }
            });


            // Validasi Password
            $("#password").on("input blur", function () {
                // Hapus pesan sebelumnya
                $(".error-message").remove();

                // Validasi password
                const password = $(this).val().trim();
                if (password === "") {
                    $(this).after('<span class="error-message text-danger">Password harus diisi</span>');
                }
            });

        });
    </script>


</body>