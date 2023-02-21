<?php 
require 'connect-db.php'; 

$users = $pdo->query('SELECT * FROM user')->fetchAll();
$errors = [];
// register
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    if (!empty($_POST['email']) && !empty($_POST['password'])) { 
        // vérifier si email exist 
        $userAlreadyExist = $pdo->query('SELECT * FROM user WHERE email = "' . $_POST['email'] . '"')->fetch();
        
        if (!$userAlreadyExist) {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $newUserQuery = "INSERT INTO user (email, password) VALUES ('$email', '$password')";
            $pdo->query($newUserQuery);

            header('Location: login.php?email='.$email);
        } else {
            $errors[] = 'Email already taken';
        }
    } else {
        $errors[] = 'Veuillez remplir tous les champs';
    }
}

// login
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    if (!empty($_POST['email']) && !empty($_POST['password'])) { 
        $userExist = $pdo->query('SELECT * FROM user WHERE email = "' . $_POST['email'] . '"')->fetch();
        if (!$userExist) {
            $errors[] = 'User not found';
        } else {
            if ($userExist['password'] === $_POST['password']) {
                $_SESSION['user_id'] = $userExist['id'];
                header('Location: index.php');
            } else {
                $errors[] = "Invalid password";
            }
        }
    } else {
        $errors[] = 'Veuillez remplir tous les champs';
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) { 
    session_destroy();
    header('Refresh:0');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon super site php</title>
</head>
<body>
    <?php include 'navbar.php'; ?>

    <?php 
        foreach($errors as $error) {
            echo $error;
        }
    ?>
    <form method="POST">

        <label for="email">Email</label>
        <input type="text" name="email" id="email" value="plop@plop.com">

        <label for="password">Password</label>
        <input type="text" name="password" placeholder="password">

        <input type="submit" name="register" value="Send">
    </form>
    
    <?php if (isset($_SESSION['user_id'])) { ?>
        <form method="post">
            <button type="sumbit" name="logout">Logout</button>
        </form>
    <?php } ?>
</body>
</html>