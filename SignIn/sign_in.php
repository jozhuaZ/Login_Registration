<?php
session_start();

// establish a connection
include ('../Database/connection.php');
$conn = connect();

// set variables from Sign In form
$email = $_POST['email'] ?? null;
$password = $_POST['password'] ?? null;

if (!$email || !$password) {
    // redirect to index.php
    header('Location: index.php?error=insufficient_inputs');
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

    $query = "SELECT * FROM user WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$email]);
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