<?php 
/**
 * @file header.inc.php
 * @brief The header of the application.
 * @details This file contains the header of the application. It includes the navigation bar and the sidebar of the application. It also includes the user information and the page title.
 * @author Bancos Gabriel
 * @date 2024-11-30
 */


ob_start();
if(Config::getPage() == "fetch_messages" || Config::getPage() == "login") 
    return;

if(isset($_SESSION['user'])) {
    $q = Config::getCon()->prepare('SELECT * FROM `users` WHERE `id` = ?');
    $q->execute(array($_SESSION['user']));
    $data = $q->fetch(PDO::FETCH_OBJ);
}
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
	<meta charset="utf-8" />
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css" integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q=" crossorigin="anonymous"><!--end::Fonts--><!--begin::Third Party Plugin(OverlayScrollbars)-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.3.0/styles/overlayscrollbars.min.css" integrity="sha256-dSokZseQNT08wYEWiz5iLI8QPlKxG+TswNRD8k35cpg=" crossorigin="anonymous"><!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Third Party Plugin(Bootstrap Icons)-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.min.css" integrity="sha256-Qsx5lrStHZyR9REqhUF8iQt73X06c8LGIUPzpOhwRrI=" crossorigin="anonymous"><!--end::Third Party Plugin(Bootstrap Icons)--><!--begin::Required Plugin(AdminLTE)-->
	<link href="<?php echo BASE_URL ?>assets/css/adminlte.css" rel="stylesheet" />
    <title><?php if(Config::getPage() != "profile") echo SITE_NAME ?></title>
</head>
<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <div class="app-wrapper">
        <nav class="app-header navbar navbar-expand bg-body">
            <div class="container-fluid">
                <ul class="navbar-nav">
                    <li class="nav-item"> <a class="nav-link" data-lte-toggle="sidebar" href="" role="button"> <i class="bi bi-list"></i> </a> </li>
                </ul> 
                <ul class="navbar-nav ms-auto">
                <?php if(isset($_SESSION['user'])) { ?>
                    <li class="nav-item dropdown"> <a class="nav-link" data-bs-toggle="dropdown" href="#"> <i class="bi bi-bell-fill"></i> <span class="navbar-badge badge text-bg-warning">15</span> </a>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end"> <span class="dropdown-item dropdown-header">15 Notifications</span>
                            <div class="dropdown-divider"></div> <a href="#" class="dropdown-item"> <i class="bi bi-envelope me-2"></i> 4 new messages
                                <span class="float-end text-secondary fs-7">3 mins</span> </a>
                            <div class="dropdown-divider"></div> <a href="#" class="dropdown-item"> <i class="bi bi-people-fill me-2"></i> 8 friend requests
                                <span class="float-end text-secondary fs-7">12 hours</span> </a>
                            <div class="dropdown-divider"></div> <a href="#" class="dropdown-item"> <i class="bi bi-file-earmark-fill me-2"></i> 3 new reports
                                <span class="float-end text-secondary fs-7">2 days</span> </a>
                            <div class="dropdown-divider"></div> <a href="#" class="dropdown-item dropdown-footer">
                                See All Notifications
                            </a>
                        </div>
                    </li>
                    <li class="nav-item dropdown user-menu">
                        <a href="" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"> 
                        <img src="<?php echo BASE_URL ?>assets/img/user2-160x160.jpg" class="user-image rounded-circle shadow" alt="User Image"> 
                        <span class="d-none d-md-inline"><?php echo $data->username ?></span> </a>
                        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                            <li class="user-header text-bg-primary"> <img src="<?php echo BASE_URL ?>/assets/img/user2-160x160.jpg" class="rounded-circle shadow" alt="User Image">
                                <p>
                                    <?php echo join(" ", [$data->first_name, $data->last_name]); ?>
                                    <small><?php echo Config::getData("groups", "name", $data->group); ?></small>
                                </p>
                            </li>
                            <li class="user-footer"> 
                                <a href="<?php echo BASE_URL ?>profile/<?php echo $data->username ?>" class="btn btn-default btn-flat">Profile</a> 
                                <a href="<?php echo BASE_URL ?>logout" class="btn btn-default btn-flat float-end">Sign out</a> 
                            </li>
                        </ul>
                    </li> 
                    <?php } else { ?>
                    <li class="nav-item"> <a href="<?php echo BASE_URL ?>login" class="nav-link">Login</a> </li>
                    <?php } ?>
                </ul>
            </div>
        </nav> 
        <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
            <div class="sidebar-brand"> 
                <a href="<?php echo BASE_URL ?>" class="brand-link"> 
                    <img src="<?php echo BASE_URL ?>/assets/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image opacity-75 shadow"> 
                    <span class="brand-text fw-light"><?php echo SITE_NAME ?></span>
                </a> 
            </div>
            <div class="sidebar-wrapper">
                <nav class="mt-2"> 
                    <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                        
                        <li class="nav-item"> 
                            <a href="<?php echo BASE_URL ?>" class="nav-link"> <i class="nav-icon bi bi-chat-fill"></i>
                                <p>Direct Chat</p>
                            </a> 
                        </li>         

                        <li class="nav-item"> 
                            <a href="<?php echo BASE_URL ?>employees" class="nav-link"> <i class="nav-icon bi bi-people-fill"></i>
                                <p>Employees</p>
                            </a> 
                        </li>       
                        
                        <li class="nav-item"> 
                            <a href="<?php echo BASE_URL ?>menu" class="nav-link"> <i class="nav-icon bi bi-menu-app"></i>
                                <p>Menu</p>
                            </a> 
                        </li>       

                    </ul> 
                </nav>
            </div>
        </aside>
        <main class="app-main">
            <div class="app-content-header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="mb-0"><?php if(Config::getPage() != '404') echo Config::getCurrentPage(); ?></h3> <!-- Page Title !-->
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a href="<?php echo BASE_URL ?>">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page"><?php echo Config::getCurrentPage(); ?></li> <!-- Home / Page !-->
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
    