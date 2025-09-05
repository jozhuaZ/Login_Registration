<?php
session_start();

// establish a connection
include ('../Database/connection.php');
$conn = connect();

// set variables from Sign In form
$login = $_POST['login'] ?? null;
$password = $_POST['password'] ?? null;

if (!$login || !$password) {
    // redirect to index.php
    $_SESSION['flash_error'] = 'Please fill in all credential fields to proceed.';
    header('Location: index.php');
    exit;
}

try {
    // check if connection is established
    if (is_null($conn)) {
        // redirect to index.php
        $_SESSION['flash_error'] = 'Server Error. Please try again later.';
        header('Location: index.php');
        exit;
    }

    $query = "SELECT * FROM user WHERE email = :login OR username = :login LIMIT 1";
    $stmt  = $conn->prepare($query);
    $stmt->execute([':login' => $login]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // no existing user with the input email
    if (!$user) {
        //redirect to index.php
        $_SESSION['flash_error'] = 'User not found. Please try again.';
        header('Location: index.php');
        exit;
    }

    // verify if password is matched to stored hashed (hashed password on database)
    if (!password_verify($password, $user['password'])) {
        // redirect to index.php
        $_SESSION['flash_error'] = 'Incorrect Password.';
        header('Location: index.php');
        exit;
    }

    // set user info on session
    session_regenerate_id(true);
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['contact_number'] = $user['contact_number'];
    $_SESSION['address'] = $user['address'];
    $_SESSION['firstname'] = $user['firstname'];
    $_SESSION['middlename'] = $user['middlename'];
    $_SESSION['lastname'] = $user['lastname'];

    // redirect to home
    header('Location: ../Home/index.php');
    
} catch (PDOException $e) {
    // redirect to index.php
    $_SESSION['flash_error'] = 'Server Error. Please try again later.';
    header('Location: index.php'); // ERROR 500  
    exit;
}


// echo "Your email is $email"; 