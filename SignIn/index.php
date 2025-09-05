<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="styles.css"> <!-- relative styling -->
    
    <title>Sign In</title>
</head>
<body>
    <?php if (isset($_SESSION['flash_error'])): ?>
        <div class="error-message poppins-default">
            <p>
            <?php 
                echo htmlspecialchars($_SESSION['flash_error']); 
                unset($_SESSION['flash_error']); // remove session variable after showing msg
            ?>
            </p>
        </div>
    <?php endif; ?>

    <h1>Sign In</h1>
    <form action="sign_in.php" method="post" class="poppins-default">
        <label>Email/Username</label>
        <input id="login" type="text" name="login" required>
        
        <label>Password</label>
        <input id="password" type="password" name="password" required>

        <a href="#">Forgot Password?</a>

        <p class="link-text">Don't have an account yet? <a href="../SignUp/index.php">Sign Up</a> instead.</p>

        <input class="button-sign-in" type="submit" value="Sign In">
    </form>
</body>
</html>