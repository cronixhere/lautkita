<?php

function checkAccess($requiredRole) {
    if (!isset($_SESSION['user']) || $_SESSION['role'] !== $requiredRole) {
        header('Location: login.php');
        exit;
    }
}
