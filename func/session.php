<?php

/*  
 * FOR USER'S SESSION CHECK ONLY
 */
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../SignIn/index.php?error=not_logged_in');
    exit;
}