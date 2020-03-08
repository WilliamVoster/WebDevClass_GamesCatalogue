<!-- registration number: 1906423 -->
<?php
    include("./database.php");
    $conn = connect();

?>
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

    <?php include("./include/header.php") ?>

    <h1 class="userPage">Register</h1>


    <form action="#" method="POST" class="userForm" id="userFormRegister">
        <label for="usernameInputRegister">Username</label>
        <input id="usernameInputRegister" type="text" name="username" required>
        <label for="passwordInputRegister">Password</label>
        <input id="passwordInputRegister" type="password" name="password" required>
        <label for="repeatInputRegister">Repeat</label>
        <input id="repeatInputRegister" type="password" name="repeatPass" required>
        <input type="submit" name="submit" value="Register">
        <span id="errorMessageRegister"><strong>Password did not match repeated password, please try again.</strong></span>
    </form> 


<?php
    if (isset($_POST["username"]) && isset($_POST["password"])){
        if ($_POST["password"] !== $_POST["repeatPass"]){
            // echo "passwords dont match";
            
            echo "<script type=\"text/javascript\"> 
                document.getElementById(\"errorMessageRegister\").classList.add(\"active\");
                document.getElementById(\"userFormRegister\").classList.add(\"error\");
                document.getElementById(\"usernameInputRegister\").focus();
                setTimeout(function() { 
                    document.getElementById(\"userFormRegister\").classList.remove(\"error\");
                }, 50);
            </script>";

        }else{
            // echo "passwords match";
            echo "<script type=\"text/javascript\"> document.getElementById(\"errorMessage\").classList.remove(\"active\"); </script>";
            $alreadyExists = register($conn, $_POST);
            if(!$alreadyExists){
                echo "ALREADY EXISTS";
            }
            header("Location: ./login.php");
        }
    }
?>

    <script type="text/javascript">document.getElementById("usernameInputRegister").focus();</script>
</body>
</html>