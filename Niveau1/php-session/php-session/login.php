<?php require 'connect-db.php'; ?>
<?php if (isset($_SESSION['user_id'])) header('Location: index.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon super site php | Contact</title>
</head>
<body>
    <?php include 'navbar.php'; ?>

    <form action="index.php" method="POST">
        <input type="text" name="email" value=<?= isset($_GET['email']) ? $_GET['email'] : '' ?>>
        <input type="text" name="password">

        <input type="submit" name="login" value="Send">
    </form>
</body>
</html>