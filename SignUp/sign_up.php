<?php
session_start();

// establish a connection
include ('../Database/connection.php');
$conn = connect();

// set variables from Sign Up form
$requiredField = ['firstname', 'middlename', 'lastname', 'email', 'username', 'contact_number', 'address', 'password', 'confirm_password'];

foreach ($requiredField as $field) {
    if (!isset($_POST[$field]) || trim($_POST[$field]) === '') {
        $_SESSION['flash_error'] = 'Please input all fields.';
        header('Location: index.php');
        exit;
    }
}

$firstname = $_POST['firstname'];
$middlename = $_POST['middlename'];
$lastname = $_POST['lastname'];
$email = $_POST['email'];
$username = $_POST['username'];
$contact_number = $_POST['contact_number'];
$address = $_POST['address'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

try {
    // check if connection is established
    if (is_null($conn)) {
        // redirect to index.php
        $_SESSION['flash_error'] = 'Server Error. Please try again later.';
        header('Location: index.php');
        exit;
    }
    
    // redirect to index if password and confirm password doesn't match
    if ($password !== $confirm_password) {
        $_SESSION['flash_error'] = 'Password did not match.';
        header('Location: index.php');
        exit;
    }

    // check if email or username already exists
    $check = $conn->prepare("SELECT id FROM user WHERE email = ? OR username = ?");
    $check->execute([$email, $username]);
    if ($check->fetch()) {
        $_SESSION['flash_error'] = 'Email or Username already exists.';
        header('Location: index.php');
        exit;
    }

    // hash the password for security
    $hashPassword = password_hash($password, PASSWORD_DEFAULT);

    // execute query
    $stmt = $conn->prepare("INSERT INTO user
                            (firstname, middlename, lastname, email, username, contact_number, address, password)
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    if ($stmt->execute([$firstname, $middlename, $lastname, $email, $username, $contact_number, $address, $hashPassword])) {
        $_SESSION['flash_msg'] = 'Successfully registered';

        $userId = $conn->lastInsertId();
        // set user info on session
        $_SESSION['user_id'] = $userId;
        $_SESSION['username'] = $username;
        $_SESSION['email'] = $email;
        $_SESSION['contact_number'] = $contact_number;
        $_SESSION['address'] = $address;
        $_SESSION['firstname'] = $firstname;
        $_SESSION['middlename'] = $middlename;
        $_SESSION['lastname'] = $lastname;
    
        // redirect to home
        header('Location: ../Home/index.php');
    } else {
        $_SESSION['flash_error'] = 'Unable to register at the mean time, please try again later.';
        header('Location: index.php');
        exit;
    }
} catch (PDOException $e) {
    // redirect to index.php
    $_SESSION['flash_error'] = 'Server Error. Please try again later.';
    header('Location: index.php'); // ERROR 500  
    exit;
}