<!-- registration number: 1906423 -->
<?php
    include("./database.php");
    $conn = connect();

    session_start();



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./css/style.css">
    <title>Login</title>
</head>
<body>

    <?php include("./include/header.php") ?>

    <h1 class="userPage">Login</h1>
    
    <form action="#" method="POST" class="userForm" id="userFormLogin">
        <label for="usernameInputLogin">Username</label>
        <input id="usernameInputLogin" type="text" name="username" >
        <label for="passwordInputLogin">Password</label>
        <input id="passwordInputLogin" type="password" name="password" >
        <input type="submit" name="submit" value="Login">
        <span id="errorMessageLogin"><strong>User does not exist.</strong></span>
    </form> 


<?php
    if (isset($_POST["username"]) && isset($_POST["password"])){

        if (login($conn, $_POST)){
            echo "logged in";

            echo "<script type=\"text/javascript\"> document.getElementById(\"errorMessage\").classList.remove(\"active\"); </script>";
            header("Location: ./index.php");

        }else{
            // echo "user does not exist";
            echo "<script type=\"text/javascript\"> 
                document.getElementById(\"errorMessageLogin\").classList.add(\"active\");
                document.getElementById(\"userFormLogin\").classList.add(\"error\");
                document.getElementById(\"usernameInputLogin\").focus();
                setTimeout(function() { 
                    document.getElementById(\"userFormLogin\").classList.remove(\"error\");
                }, 50);
            </script>";
        }
        
        
    }

?>


    <script type="text/javascript">document.getElementById("usernameInputLogin").focus();</script>
</body>
</html>