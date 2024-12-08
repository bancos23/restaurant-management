<?php
/**
 * @file login.p.php
 * @brief Login Page
 * @details
 * This file contains the login page for the restaurant management system.
 * 
 * @file /Users/eduhaidu/restaurant-management/inc/pages/login.p.php
 * 
 * @html
 * The HTML structure includes:
 * - Meta tags for character set, viewport, title, author, description, and keywords.
 * - Links to external stylesheets for fonts, OverlayScrollbars, and Bootstrap Icons.
 * - A login form with fields for username and password, and a "Remember Me" checkbox.
 * - Links for "Forgot password" and "Register a new membership".
 * - Scripts for OverlayScrollbars, Popper.js, Bootstrap, and AdminLTE.
 * 
 * @php
 * The PHP code includes:
 * - Displaying session messages.
 * - Handling form submission for login.
 * - Querying the database to verify user credentials.
 * - Redirecting the user upon successful login or displaying an error message.
 * 
 * @dependencies
 * - External stylesheets and scripts from jsDelivr CDN.
 * - AdminLTE CSS and JS files.
 * 
 * @usage
 * This file is used to render the login page where users can enter their credentials to access the restaurant management system.
 */
?>
<html lang="en">
	
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title><?php echo defined('SITE_NAME') ? SITE_NAME : 'Restaurant Management' ?> - Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="title" content="AdminLTE 4 | Sidebar Mini">
    <meta name="author" content="ColorlibHQ">
    <meta name="description" content="AdminLTE is a Free Bootstrap 5 Admin Dashboard, 30 example pages using Vanilla JS.">
    <meta name="keywords" content="bootstrap 5, bootstrap, bootstrap 5 admin dashboard, bootstrap 5 dashboard, bootstrap 5 charts, bootstrap 5 calendar, bootstrap 5 datepicker, bootstrap 5 tables, bootstrap 5 datatable, vanilla js datatable, colorlibhq, colorlibhq dashboard, colorlibhq admin dashboard"><!--end::Primary Meta Tags--><!--begin::Fonts-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css" integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q=" crossorigin="anonymous"><!--end::Fonts--><!--begin::Third Party Plugin(OverlayScrollbars)-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.3.0/styles/overlayscrollbars.min.css" integrity="sha256-dSokZseQNT08wYEWiz5iLI8QPlKxG+TswNRD8k35cpg=" crossorigin="anonymous"><!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Third Party Plugin(Bootstrap Icons)-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.min.css" integrity="sha256-Qsx5lrStHZyR9REqhUF8iQt73X06c8LGIUPzpOhwRrI=" crossorigin="anonymous"><!--end::Third Party Plugin(Bootstrap Icons)--><!--begin::Required Plugin(AdminLTE)-->
    <link rel="stylesheet" href="<?php echo defined('BASE URL') ? BASE_URL : 'localhost' ?>assets/css/adminlte.css">
</head> 

<body class="login-page bg-body-secondary">
    <div class="login-box">
        <div class="card card-outline card-primary">
            <div class="card-header"> <a href="<?php echo defined('BASE_URL') ? BASE_URL : 'localhost' ?>" class="link-dark text-center link-offset-2 link-opacity-100 link-opacity-50-hover">
                    <h1 class="mb-0"> <?php echo defined('SITE_NAME') ? SITE_NAME : 'Restaurant Management' ?></h1>
                </a> </div>
            <div class="card-body login-card-body">
                <p class="login-box-msg">Sign in to start your session</p>
                <form method="POST">
					<?php
					if(isset($_SESSION['msg'])) { echo $_SESSION['msg']; $_SESSION['msg'] = ''; }
					if(isset($_POST['aLogin'])) {
						$q = Config::getCon()->prepare('SELECT * FROM `users` WHERE `username` = ? AND `password` = ?');
						$q->execute(array($_POST['uName'],$_POST['uPass']));
						if($q->rowCount()) {
							$row = $q->fetch(PDO::FETCH_OBJ);
							$_SESSION['user'] = $row->id;		
							Config::gotoPage('');
						}
						else 
							$_SESSION['msg'] = '<center><p><font color="red">Wrong password or email!</font></p></center>'; Config::gotoPage('login'); return;
					} ?>
                    <div class="input-group mb-1">
                        <div class="form-floating"> <input id="username" type="text" class="form-control" placeholder="" name="uName"> <label for="email">Username</label> </div>
                        <div class="input-group-text"> <span class="bi bi-person-circle"></span> </div>
                    </div>
                    <div class="input-group mb-1">
                        <div class="form-floating"> <input id="passwd" type="password" class="form-control" placeholder="" name="uPass"> <label for="passwd">Password</label> </div>
                        <div class="input-group-text"> <span class="bi bi-lock-fill"></span> </div>
                    </div> <!--begin::Row-->
                    <div class="row">
                        <div class="col-8 d-inline-flex align-items-center">
                            <div class="form-check"> <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault"> <label class="form-check-label" for="flexCheckDefault">
                                    Remember Me
                                </label> </div>
                        </div> <!-- /.col -->
                        <div class="col-4">
                            <div class="d-grid gap-2"> <button type="submit" name="aLogin" class="btn btn-primary">Sign In</button> </div>
                        </div> <!-- /.col -->
                    </div> <!--end::Row-->
                </form>
                <p class="mb-1"> <a href="forgot-password.html">I forgot my password</a> </p>
                <p class="mb-0"> <a href="register.html" class="text-center">
                        Register a new membership
				</a> </p>
            </div> <!-- /.login-card-body -->
        </div>
    </div> <!-- /.login-box --> <!--begin::Third Party Plugin(OverlayScrollbars)-->
    <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.3.0/browser/overlayscrollbars.browser.es6.min.js" integrity="sha256-H2VM7BKda+v2Z4+DRy69uknwxjyDRhszjXFhsL4gD3w=" crossorigin="anonymous"></script> <!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Required Plugin(popperjs for Bootstrap 5)-->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha256-whL0tQWoY1Ku1iskqPFvmZ+CHsvmRWx/PIoEvIeWh4I=" crossorigin="anonymous"></script> <!--end::Required Plugin(popperjs for Bootstrap 5)--><!--begin::Required Plugin(Bootstrap 5)-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha256-YMa+wAM6QkVyz999odX7lPRxkoYAan8suedu4k2Zur8=" crossorigin="anonymous"></script> <!--end::Required Plugin(Bootstrap 5)--><!--begin::Required Plugin(AdminLTE)-->
    <script src="<?php echo BASE_URL ?>assets/js/adminlte.js"></script> <!--end::Required Plugin(AdminLTE)--><!--begin::OverlayScrollbars Configure-->
    <script>
        const SELECTOR_SIDEBAR_WRAPPER = ".sidebar-wrapper";
        const Default = {
            scrollbarTheme: "os-theme-light",
            scrollbarAutoHide: "leave",
            scrollbarClickScroll: true,
        };
        document.addEventListener("DOMContentLoaded", function() {
            const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
            if (
                sidebarWrapper &&
                typeof OverlayScrollbarsGlobal?.OverlayScrollbars !== "undefined"
            ) {
                OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
                    scrollbars: {
                        theme: Default.scrollbarTheme,
                        autoHide: Default.scrollbarAutoHide,
                        clickScroll: Default.scrollbarClickScroll,
                    },
                });
            }
        });
    </script> <!--end::OverlayScrollbars Configure--> <!--end::Script-->
</body><!--end::Body-->

</html>