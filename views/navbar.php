<nav class="navbar navbar-expand sticky-top" style="background-color: rgba(255, 255, 255, 0.72); color: black;">
    <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <!-- Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdown"
                        role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <!-- Foto User -->
                        <img src="./assets/user.png" alt="User Photo" class="rounded-circle me-2"
                            style="width: 30px; height: 30px;">
                        <!-- Nama User -->
                        <span id="username"><?php echo $_COOKIE['username'] ?></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li>
                            <a class="dropdown-item" href="logout.php">Logout</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>