<?php

include_once "src/user.controller.php";
?>

<header>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php"><img src="assets/img/logo.png" alt="Weatherizer" height="20" loading=  "lazy"></a>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-link" aria-current="page" href="index.php">Home</a>
                    <form class="d-flex" role="search" action="search.php">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" id="search" name="search">
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </form>
                </div>
            </div>
            <!-- Avatar -->
            <div class="d-flex">
                <div class="dropdown">
                    <a data-mdb-dropdown-init class="dropdown-toggle d-flex align-items-center hidden-arrow" href="#" id="navbarDropdownMenuAvatar" role="button" aria-expanded="false">
                        Profile
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuAvatar">
                        <?php if (isUserLoggedIn()) {?>
                        <li>
                            <a class="dropdown-item" href="favourites.php">Favourites</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="logout.php">Logout</a>
                        </li>
                        <?php } else { ?>
                        <li>
                            <a class="dropdown-item" href="login_register.php">Sign Up / Login</a>
                        </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</header>
