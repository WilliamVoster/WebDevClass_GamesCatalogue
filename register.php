<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./css/style.css">
    <title>Register</title>
</head>
<body>

<?php include("./include/header.html") ?>
    
    <form action="#" method="POST" class="userForm">
        <label for="usernameInputRegister">Username</label>
        <input id="usernameInputRegister" type="text" name="username" required>
        <label for="passwordInputRegister">Password</label>
        <input id="passwordInputRegister" type="password" name="password" required>
        <label for="repeatInputRegister">Repeat</label>
        <input id="repeatInputRegister" type="password" name="password" required>
        <input type="submit" name="submit" value="Register">
    </form> 
</body>
</html>