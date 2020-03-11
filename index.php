<!-- registration number: 1906423 -->
<?php

    session_start();

    $server   = "localhost";
    $username = "root";
    $password = "";
    $database = "assignment2020";
    $log = "";

    // $server   = "cseemyweb.essex.ac.uk"; // essexweb something...something
    // $username = "tv19295";
    // $password = "6LXLZTzFqdKle";
    // $database = "ce154_tv19295";
    // $log = "";

    $conn = new mysqli($server, $username, $password, $database);

    if(!$conn){
        $log = $log . mysqli_connect_error();
        die();
    }else{
        $log = $log . "connected";
    }

    $sql    = "SELECT id, title, image, genre, rating from games;";
    $result = mysqli_query($conn, $sql);

    include("./database.php");
    // $conn = connect();


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./css/style.css">
    <!-- <link rel="stylesheet" href="./"> -->
    <title>Home</title>
    <style>
        body{
            background-color: #2e2e31;
        }
    </style>
</head>

<body id="body">

    <?php include("./include/header.php") ?>
    
    <main>
        <div id="filter">
            <form action="./index.php" method="GET">
                <span id="searchbar">
                    <img src="./media/search-icon.svg" alt="search icon">
                    <input type="text" placeholder="Search" name="search">
                    <input type="submit" value="Search">
                </span>
            </form>

            <form action="./index.php" method="GET">
                <span>
                    <input type="checkbox" id="inputCheck"><label for="inputCheck">check</label>
                </span>
                <span>
                    <input type="radio" id="inputRadio"><label for="inputRadio">radio</label>
                </span>
            </form>

        </div>
            
        <div id="gallery">
            <ul>
                <?php
                if(mysqli_num_rows($result) > 0){
                    while($row = mysqli_fetch_assoc($result)){

                        $_SESSION["games"][$row["id"]] = [
                            "id" => $row["id"],
                            "title" => $row["title"], 
                            "image" => $row["image"], 
                            "genre" => $row["genre"], 
                            "rating" => $row["rating"]
                        ];
                    }
                }
                if(isset($_GET["search"])){
                    $result = filterSearch($conn, $_GET["search"]); 

                    if(count($result) > 0){
                        $_SESSION["games"] = [];
                        foreach($result as $game){
                            $_SESSION["games"][$game["id"]] = [
                                "id"    => $game["id"],
                                "title" => $game["title"], 
                                "image" => $game["image"], 
                                "genre" => $game["genre"], 
                                "rating" => $game["rating"]
                            ];
                        }
                    }
                }
                foreach($_SESSION["games"] as $game){
                    echo 
                    "<li id =\"" . $game["id"] . "\">" .
                        "<a href=\"./description.php?game=" . $game["id"] . "\">" . $game["title"] . "</a>" .
                        "<img src=\"./media/" . $game["image"] . "\">" .
                    "</li>";
                }
                ?>

            </ul>

        </div>
    </main>
    
    
    <?php include("./include/footer.html"); ?>

    <script src="./main.js"></script>
    
</body>
</html>

<?php mysqli_close($conn);?>



   

