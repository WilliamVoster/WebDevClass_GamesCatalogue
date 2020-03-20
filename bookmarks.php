<!-- registration number: 1906423 -->
<?php
    include("./database.php");
    $conn = connect();

    session_start();

    $sql    = "SELECT id, title, image, genre, rating FROM games;";
    $result = mysqli_query($conn, $sql);

    



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bookmarks</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
<?php include("./include/header.php") ?>

    <main id="bookmarks">
    <?php

        if(!isset($_SESSION["username"])){
            echo "<h1>Log in for bookmark functionality</h1>";
        }else{
            getBookmarks($conn);
            if(isset($_POST["delete"])){
                $_SESSION["bookmark"][$_POST["gameID"]] = false;
                removeBookmark($conn, $_SESSION["userID"], $_POST["gameID"]);
            }
            echo "<h1>Bookmarks</h1>";
            if(mysqli_num_rows($result) <= 0){ echo "sql error"; }else{
                while($row = mysqli_fetch_assoc($result)){
                    if($_SESSION["bookmark"][$row["id"]]){
                        // echo $row["title"] . "<br>";$row["id"]
                        echo
                            "<div><h3>" . $row["title"] . "</h3>" . 
                            "<span>" . 
                                "<a href=\"./description.php?game=" . $row["id"] . "\">Game page</a>" . 

                                "<form action=\"./bookmarks.php\" method=\"POST\">" . 
                                "<input type=\"hidden\" name=\"gameID\" value=\"" . $row["id"] . "\">" .
                                "<input type=\"submit\" name=\"delete\" value=\"Remove\">" .
                                "</form>" . 

                            "</span></div>";
                    }
                    
                }
            }

            
            
        }


    ?>
    </main>

    <script src="./main.js"></script>

<?php include("./include/footer.html") ?>
</body>
</html>