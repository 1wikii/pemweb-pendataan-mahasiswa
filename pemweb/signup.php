<?php
$title = 'Signup';
require_once('views/layoutCSS.php');
require_once('objects/user.php');


if (isset($_POST['signup'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $new_user = new USER($email, $password, $username);
    $validation = $new_user->SIGNUP();

    if (!$validation) {
        echo "<script>alert('Akun sudah ada, silahkan coba kembali !');</script>";
    }

    if ($validation) {
        echo "<script>alert('Berhasil membuat akun !');
        setTimeout(function() {
            window.location.href = 'login.php';
        }, 2000); 
        </script>";
    }

}

?>

<body>

    <div class="container-fluid d-flex justify-content-center align-items-center container-login100"
        style="height: 100vh; background-image: url('assets/bg.jpg');">

        <form class="bg-white p-5 rounded" style="width: 40%;" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
            <p class="text-center login100-form-title">
                Sign Up
            </p>

            <div class="mb-3">
                <label for="username" class="form-label">Username </label>
                <input name="username" type="text" class="form-control" id="username">
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email </label>
                <input name="email" type="text" class="form-control" id="email">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input name="password" type="password" class="form-control" id="password">
            </div>

            <button type="submit" name="signup" class="btn btn-primary rounded font-custom" style="width: 100%;">Sing
                Up</button>
            <p class="m-1 text-center">Already have account ? <a href="login.php">Login</a></p>
        </form>



    </div>


    <?php
    require_once('views/layoutJS.php');
    ?>


    <script>
        $(document).ready(function () {

            // validasi username
            $("#username").on("input blur", function () {
                // Hapus pesan sebelumnya
                $(".error-message").remove();

                // Validasi username
                const username = $(this).val().trim();  // hilangkan semua spasi
                if (username === "") {
                    isValid = false;
                    $(this).after('<span class="error-message text-danger">Username harus diisi</span>');
                }
            });

            // validasi email
            $("#email").on("input blur", function () {
                // Hapus pesan sebelumnya
                $(".error-message").remove();

                // Validasi email
                const email = $(this).val().trim();  // hilangkan semua spasi
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;   // regex untuk cek format email
                if (email === "") {
                    isValid = false;
                    $(this).after('<span class="error-message text-danger">Email harus diisi</span>');
                } else if (!emailRegex.test(email)) {
                    isValid = false;
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
                    isValid = false;
                    $(this).after('<span class="error-message text-danger">Password harus diisi</span>');
                }
            });
        });
    </script>
</body>