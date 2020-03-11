<!-- registration number: 1906423 -->
<?php
    //include("./database.php");
    // $conn = connect();
    session_start();
    // echo var_dump($_SESSION);

    session_unset();
    session_destroy();

    // echo var_dump($_SESSION);
    header("Location: ./index.php");
 

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./css/style.css">
    <title>Logout</title>
</head>
<body>

    <h2>Logging out...</h2>

    <a href="./index.php">BACK</a>

</body>
</html>