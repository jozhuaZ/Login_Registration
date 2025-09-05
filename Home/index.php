<?php include ('../func/session.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="styles.css">

    <title>Home Page</title>
</head>
<body>
    <?php if (isset($_SESSION['flash_msg'])): ?>
        <div class="notif-message poppins-default">
            <p>
            <?php 
                echo htmlspecialchars($_SESSION['flash_msg']); 
                unset($_SESSION['flash_msg']); // remove session variable after showing msg
            ?>
            </p>
        </div>
    <?php endif; ?>

    <h1>Hello <?php echo htmlspecialchars($_SESSION['username']); ?></h1>
</body>
</html>