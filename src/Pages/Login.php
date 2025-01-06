<?php

/**
 * @file login.php
 * @brief Login page for the application.
 * @details
 * This script handles the user login process.
 * It includes form submission handling, user authentication, and error message display.
 * 
 * @section Dependencies
 * - App\Controller\LoginController: Handles user authentication logic.
 * - App\Config\Config: Provides database connection and configuration.
 * - External libraries for styling and functionality.
 *
 * PHP Variables:
 * - $_POST['uName']: Username input from the login form.
 * - $_POST['uPass']: Password input from the login form.
 *
 * @section External Libraries
 * - @fontsource/source-sans-3: Font library.
 * - overlayscrollbars: Custom scrollbar library.
 * - bootstrap-icons: Icon library.
 * - bootstrap: CSS framework.
 * - adminlte: Admin dashboard template.
 *
 * @section JavaScript
 * - OverlayScrollbars for custom scrollbars.
 */

use App\Controller\LoginController;
use App\Config\Config;

// Handle form submission
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    /**
     * @var string $username User-provided username from the login form.
     * @var string $password User-provided password from the login form.
     */
    $dbConnection = Config::getDatabase();
    $loginController = new LoginController($dbConnection);

    $username = $_POST['uName'] ?? '';
    $password = $_POST['uPass'] ?? '';

    /**
     * Authenticate the user.
     * @param string $username The username entered by the user.
     * @param string $password The password entered by the user.
     * @return void Redirects to the appropriate page based on authentication result.
     */
    if($loginController->performLogin($username, $password))
    {
        header('Location: index');
        exit;
    } else {
        header('Location: login');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $_ENV['SITE_NAME']; ?> - Login</title>
    <meta name="description" content="Login to access the application">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.3.0/styles/overlayscrollbars.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="<?php echo $_ENV['BASE_URL']; ?>assets/css/adminlte.css">
</head>

<body class="login-page bg-body-secondary">
    <div class="login-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="<?php echo $_ENV['BASE_URL']; ?>" class="link-dark link-offset-2 link-opacity-100 link-opacity-50-hover">
                    <h1 class="mb-0"><?php echo $_ENV['SITE_NAME']; ?></h1>
                </a>
            </div>
            <div class="card-body login-card-body">
                <p class="login-box-msg">Sign in to start your session</p>
                <form method="POST" action="">
                    <!-- Display Error Message -->
                    <?php if (!empty($_SESSION['msg'])): ?>
                        <div class="alert alert-danger text-center">
                            <?php echo $_SESSION['msg']; unset($_SESSION['msg']); ?>
                        </div>
                    <?php endif; ?>

                    <!-- Username Input -->
                    <div class="input-group mb-3">
                        <input type="text" name="uName" class="form-control" placeholder="Username" required>
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="bi bi-person-circle"></i></span>
                        </div>
                    </div>

                    <!-- Password Input -->
                    <div class="input-group mb-3">
                        <input type="password" name="uPass" class="form-control" placeholder="Password" required>
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="row">
                        <div class="col-8"></div>
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                        </div>
                    </div>
                </form>
                <!-- Links -->
                <p class="mt-2 mb-0 text-center">
                    <a href="forgot-password.p.php" class="text-secondary">Forgot Password?</a>
                </p>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.3.0/browser/overlayscrollbars.browser.es6.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
    <script src="<?php echo BASE_URL ?>assets/js/adminlte.js"></script>
</body>

</html>