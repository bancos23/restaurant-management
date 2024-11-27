<?php
unset($_SESSION['user']);
$_SESSION['msg'] = '<div class="alert alert-warning"><i class="fa fa-check sign"></i>You have been logged out!</div>'; 
Config::gotoPage(''); 
session_destroy();
return;
?>