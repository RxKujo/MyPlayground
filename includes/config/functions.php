<?php

function print_error($session) {
    if (isset( $session["error"] ) ) {
        $error = $session["error"];

        echo '<div class="alert alert-danger text-center">';
        echo htmlspecialchars($error);
        echo '</div>';
    }
}

function deleteCookie($key) {
    if (isset($_COOKIE[$key])) {
        unset($_COOKIE[$key]);
        setcookie($key, '', time() - 3600,'/');
    }
}

function isAuthenticated() {
    if (isset($_SESSION['authenticated']) && $_SESSION['authenticated']) {
        return true;
    } else if (isset($_COOKIE['user']) && $_COOKIE['user']) {
        return true;
    }
    return false;
}