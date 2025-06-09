<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
unset($_SESSION['user']);
header("Location: /project-p22/?page=login");
exit;
?>