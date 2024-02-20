<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'templates/head.php'; ?>
</head>

<body>
    <?php include 'templates/header.php'; ?>
    <div class="container-sm p-5 form-container">
    <!-- Pills navs -->
    <ul class="nav nav-pills nav-justified mb-3" id="ex1" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="tab-login" data-mdb-pill-init href="#pills-login" role="tab" aria-controls="pills-login" aria-selected="true">Login</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="tab-register" data-mdb-pill-init href="#pills-register" role="tab" aria-controls="pills-register" aria-selected="false">Register</a>
        </li>
    </ul>
    <!-- Pills navs -->

    <!-- Pills content -->
    <?php
    if (isset($_GET['message'])) {
        $message = $_GET['message'];
        echo "<span class=\"badge badge-warning\">$message</span>";
    } elseif (isUserLoggedIn()) {
        echo "<span class=\"badge badge-warning\">Already logged in. You don't belong here</span>";
    } else {    
        ?>
    
    <div class="tab-content">
        <div class="tab-pane fade show active" id="pills-login" role="tabpanel" aria-labelledby="tab-login">
            <form action="src/login_register.controller.php" method="post">
                <!-- Email input -->
                <div data-mdb-input-init class="form-outline mb-4">
                    <input type="email" id="email" name="email" class="form-control" />
                    <label class="form-label" for="email">Email</label>
                </div>

                <!-- Password input -->
                <div data-mdb-input-init class="form-outline mb-4">
                    <input type="password" id="password" name="password" class="form-control" />
                    <label class="form-label" for="password">Password</label>
                </div>

                <!-- 2 column grid layout -->
                <div class="row mb-4">
                    <div class="col-md-6 d-flex justify-content-center">
                        <!-- Checkbox -->
                        <div class="form-check mb-3 mb-md-0">
                            <input class="form-check-input" type="checkbox" value="" id="loginCheck" checked />
                            <label class="form-check-label" for="loginCheck"> Remember me </label>
                        </div>
                    </div>

                    <!-- Forgot password for later
                    <div class="col-md-6 d-flex justify-content-center">
                        <a href="#!">Forgot password?</a>
                    </div>
                    -->
                </div>

                <!-- Submit button -->
                <button type="submit" name="button_login" class="btn btn-primary btn-block mb-4">Sign in</button>
            </form>
        </div>
        <div class="tab-pane fade" id="pills-register" role="tabpanel" aria-labelledby="tab-register">
            <form action="src/login_register.controller.php" method="post">
                <!-- Name input -->
                <div data-mdb-input-init class="form-outline mb-4">
                    <input type="text" id="name" name="name" class="form-control" />
                    <label class="form-label" for="name">Name</label>
                </div>

                <!-- Email input -->
                <div data-mdb-input-init class="form-outline mb-4">
                    <input type="email" id="email" name="email" class="form-control" />
                    <label class="form-label" for="email">Email</label>
                </div>

                <!-- Password input -->
                <div data-mdb-input-init class="form-outline mb-4">
                    <input type="password" id="password" name="password" class="form-control" />
                    <label class="form-label" for="password">Password</label>
                </div>

                <!-- Repeat Password input -->
                <div data-mdb-input-init class="form-outline mb-4">
                    <input type="password" id="repeatPassword" name="repeatPassword" class="form-control" />
                    <label class="form-label" for="repeatPassword">Repeat password</label>
                </div>
                


                <!-- Submit button -->
                <button data-mdb-ripple-init type="submit" name="button_signup" class="btn btn-primary btn-block mb-3">Sign up</button>
            </form>
        </div>
    </div>
    <!-- Pills content -->
    </div>

    <?php } ?>

    <?php include 'templates/script.php'; ?>
</body>

</html>
