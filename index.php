<!-- registration number: 1906423 -->
<?php
    session_start();

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

            <form action="./index.php" method="GET" id="filterForm">
                <span>
                    <select name="genre">
                    <option value="">Select genre</option>
                        <option value="fps">First person shooter</option>
                        <option value="rpg">Role playing game</option>
                        <option value="sim">Simulator game</option>
                        <option value="str">Strategy game</option>
                    </select>
                </span>
                <span>
                    <input type="checkbox" id="over80Rating" name="over80Rating"><label for="over80Rating">Above 80% rating</label>
                </span>
                <!-- <span>
                    <input type="radio" id="inputRadio"><label for="inputRadio">radio</label>
                </span> -->
                
                <span>
                    <!-- <input type="hidden" name="filter" value="yes"> -->
                    <input type="submit" value="Filter">
                </span>
            </form>

        </div>
            
        <div id="gallery">
        <?php

        if(isset($_POST["newGameSubmit"])){
            addGame(
                $conn,
                $_POST["newGameTitle"],
                $_POST["newGameImage"],
                $_POST["newGameGenre"],
                $_POST["newGameRating"],
                $_POST["newGameDescription"]
            );
        }
        
        if(isset($_SESSION["isAdmin"])){
            echo
            "<div id=\"addGame\">" .
                "<span><label for=\"showAddGame\">Admin function: </label>
                <button id=\"showAddGame\">Add game</button></span>" .
                "<img src=\"./media/add.png\">" .
                "<div id=\"addGameForm\" class=\"hidden\"><form action=\"#\" method=\"post\" class=\"hidden\">
                    <label for=\"newGameTitle\">Title</label>
                    <input type=\"text\" name=\"newGameTitle\" id=\"newGameTitle\">
                    <label for=\"newGameImage\">Image URL</label>
                    <input type=\"text\" name=\"newGameImage\" id=\"newGameImage\">
                    <label for=\"newGameGenre\">Genre</label>
                    <select name=\"newGameGenre\" id=\"newGameGenre\">
                        <option value=\"???\">Select Genre</option>
                        <option value=\"fps\">First Person Shooter</option>
                        <option value=\"rpg\">Role Playing Game</option>
                        <option value=\"sim\">Simulator Game</option>
                        <option value=\"str\">Strategy Game</option>
                    </select>
                    <label for=\"newGameRating\">Rating in %</label>
                    <input type=\"number\" name=\"newGameRating\" id=\"newGameRating\" min=\"0\" max=\"100\">
                    <textarea name=\"newGameDescription\" id=\"newGameDescription\" cols=\"30\" rows=\"10\" 
                    style=\"resize: none;\" placeholder=\"Description\"></textarea>
                    <span><input type=\"submit\" name=\"newGameSubmit\" value=\"Add game\"></span>
                </form></div>
            </div>";
        }
        echo "
        <script type=\"text/javascript\">
        let showAddGame = document.getElementById(\"showAddGame\");
        let addGameForm = document.getElementById(\"addGameForm\");
        flipBool = false;
        showAddGame.onclick = () => {
            addGameForm.classList.toggle(\"hidden\");
            if(flipBool){showAddGame.innerHTML = \"Add game\"; flipBool = !flipBool;
            }else{showAddGame.innerHTML = \"Close\"; flipBool = !flipBool;}
        }
        </script>";
        
        ?>
        <ul>
        <?php
        $sql    = "SELECT id, title, image, genre, rating, description FROM games;";
        $result = mysqli_query($conn, $sql);
    
        $bookmarkSql    = "SELECT user_id, game_id FROM bookmarks;";
        $bookmarkResult = mysqli_query($conn, $bookmarkSql);
        $_SESSION["games"] = [];

        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
                $_SESSION["games"][$row["id"]] = [
                    "id" => $row["id"],
                    "title" => $row["title"], 
                    "image" => $row["image"], 
                    "genre" => $row["genre"], 
                    "rating" => $row["rating"],
                    "description" => $row["description"]
                ];
                
            }
        }
        if(mysqli_num_rows($bookmarkResult) > 0 and isset($_SESSION["username"])){
            $_SESSION["bookmark"] = [];
            while($row = mysqli_fetch_assoc($bookmarkResult)){
                // echo var_dump($row);
                if($row["user_id"] == $_SESSION["userID"]){
                    $_SESSION["bookmark"][] = $row["game_id"];
                }
                // else{
                //     $_SESSION["bookmark"][$row["user_id"]] = false;
                // }
            }
            // echo var_dump($_SESSION["bookmark"]);
        }
        if(isset($_GET["search"])){
            $result = filterSearch($conn, $_GET["search"]); 
            
        }elseif((isset($_GET["genre"]) and $_GET["genre"] != "") or isset($_GET["over80Rating"])){
            // if($_GET["genre"] != "" or $_GET["over80Rating"] == "on"){
                $rating = "off";
                if(isset($_GET["over80Rating"])){  $rating = $_GET["over80Rating"]; }

                $result = filterGenreRating($conn, $_GET["genre"], $rating);
            // }
        }
        if(
            isset($_GET["search"]) or 
            (isset($_GET["genre"]) and $_GET["genre"] != "") or 
            (isset($_GET["over80Rating"]) and $_GET["over80Rating"] == "on")){
            // echo var_dump($result);

            if(count($result) > 0){
                $_SESSION["games"] = [];
                foreach($result as $game){
                    // echo var_dump($game);
                    $_SESSION["games"][$game["id"]] = [
                        "id"    => $game["id"],
                        "title" => $game["title"], 
                        "image" => $game["image"], 
                        "genre" => $game["genre"], 
                        "rating" => $game["rating"],
                        "description" => $game["description"]
                    ];
                }
            }else{
                $_SESSION["games"] = [];
                echo "No results";
            }
        }
        foreach($_SESSION["games"] as $game){
            echo 
            "<li id =\"" . $game["id"] . "\">" .
                "<a href=\"./description.php?game=" . $game["id"] . "\">" . $game["title"] . "</a>" .
                "<img src=\"" . $game["image"] . "\">" .
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



   

