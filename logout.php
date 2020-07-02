<?php ob_start(); ?>
<?php
session_start();
                $_SESSION['user_id'] = null;
                $_SESSION['name'] = null;
                $_SESSION['email'] = null;
                header("location:index.php");
?>