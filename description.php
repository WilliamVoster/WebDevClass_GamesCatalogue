<!-- registration number: 1906423 -->
<?php
    include("./database.php");
    $conn = connect();

    session_start();

    getBookmarks($conn);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./css/style.css">
    <title><?php echo $_GET["game"];?></title>
    <style>
        body{
            background-color: #2e2e31;
        }
    </style>
</head>
<body id="body">

<?php include("./include/header.php") ?>

    <main id="description">

    <?php
        if( isset($_GET["game"]) && isset($_SESSION["games"])){
            foreach($_SESSION["games"] as $id => $gameInfo){
                if($_GET["game"] == $id){

                    echo "<script type=\"text/javascript\">document.title = \"" . $gameInfo["title"] . "\";</script>";
                    
                    echo "<h1>" . $gameInfo["title"] . "</h1>";
                    echo 
                        "<img id=\"banner\" src=\"./media/" . $gameInfo["image"] . 
                        "\" alt=\"banner image of current game page; " . $gameInfo["title"] . "\">";


                    
                    $greenVal = $gameInfo["rating"] + 50;
                    $redVal = 200 - $greenVal;
                
                    echo "<div id=\"rating\"><span>Score</span>";

                    if($gameInfo["rating"] != 0){    
                    echo 
                        "<div style=\"background: rgb(" . 
                        $redVal . ", " . $greenVal . ", 0);\"><span>" . 
                        $gameInfo["rating"] . "%</span></div>";
                    }else{
                    echo
                        "<span class=\"subSpan\">No rating for this game</span>";
                    }


                    $genres = ["fps" => "First person", "rpg" => "Role playing", "sim" => "Simulator", "str" => "Strategy"];

                    echo "<span>Genre</span>";
                    if($gameInfo["genre"] != "???"){
                        foreach($genres as $key => $value){
                            if($key == $gameInfo["genre"]){
                                echo "<span class=\"subSpan\">" . $genres[$gameInfo["genre"]] . " game</span>";
                                echo "<a href=\"index.php?genre=" . $gameInfo["genre"] . "\"><img src=\"./media/genre/" . $gameInfo["genre"] . ".png\"></a>";
                            }
                        }
                    }else{
                        echo "<span class=\"subSpan\">No genre for this game</span>";
                    }
                    echo "</div>";


                    echo 
                        "<div id=\"gameDescription\">" .  
                        "<h3>Description</h3><br>" .
                        $gameInfo["description"] . 
                        "-- Steam</div>";

                    //handle add and remove from bookmark
                    if(isset($_POST["bookmark"])){
                        if($_POST["bookmark"] == "add"){
                            $_SESSION["bookmark"][$id] = true;
                            addBookmark($conn, $_SESSION["userID"], $id);

                        }elseif($_POST["bookmark"] == "remove"){
                            $_SESSION["bookmark"][$id] = false;
                            removeBookmark($conn, $_SESSION["userID"], $id);
                        }
                        //echo var_dump($_SESSION["bookmark"]);
                    }


                    echo "<div id=\"addToBookmark\">" .
                        "<form acrion=\"./description\" method=\"POST\">"; //GET removes the already present gameID = x;

                        if(isset($_SESSION["username"])){
                            if(isset($_SESSION["bookmark"]) and $_SESSION["bookmark"][$id]){
                                // game is in bookmark
                                echo "<input type=\"hidden\" name=\"bookmark\" value=\"remove\">" . 
                                    "<input type=\"submit\" value=\"Remove bookmark\">";
                                
                            }else{
                                echo "<input type=\"hidden\" name=\"bookmark\" value=\"add\">" . 
                                    "<input type=\"submit\" value=\"Add bookmark\">";
                            }
                        }else{
                            echo "Log in for bookmark <br> functionality";
                        }
                    echo "</form></div>";


                    if(isset($_POST["newReview"])){
                        //echo var_dump($_POST);
                        // echo htmlspecialchars($_POST["reviewBody"]);
                        createReview(
                            $conn, 
                            $_POST["reviewTitle"], 
                            htmlspecialchars($_POST["reviewBody"]), 
                            $_POST["reviewRating"], 
                            $id);
                        // echo "test";
                    }
                    $reviews = [];
                    foreach (getReviews($conn) as $row) {
                        if($row["game_id"] == $_GET["game"]){
                            $reviews[] = $row;
                        }
                    }
                    echo "<div id=\"reviews\">";
                    if(count($reviews) > 0){ echo "<h3>Reviews</h3>"; 
                    }else{ echo "<h3>No reviwes for this game</h3>"; }

                    echo "<a href=\"#\" id=\"showNewReview\"";
                    if(!isset($_SESSION["username"])){echo "class=\"hidden\"";}
                    echo ">Write review</a>";

                    echo 
                        "<div id=\"newReview\" class=\"hidden\">" . 
                        "<h3>New review for " . $gameInfo["title"] . "</h3>" .
                        "<form action=\"#\" method=\"POST\" id=\"newReviewForm\">" .
                        "<label for=\"reviewTitle\">Title</label>" .
                        "<input type=\"text\" id=\"reviewTitle\" name=\"reviewTitle\">" .
                        "<label for=\"reviewRating\">Rating in %</label>" .
                        "<input type=\"number\" id=\"reviewRating\" name=\"reviewRating\" min=\"0\" max=\"100\">" .
                        "<textarea rows=\"4\" cols=\"50\" name=\"reviewBody\"
                        style=\"resize: none;\" placeholder=\"Write review here \"></textarea>" .
                        "<input type=\"submit\" name=\"newReview\" value=\"Create review\">" .
                        "</form></div>";
                    
                    echo 
                        "<script type=\"text/javascript\">
                            showNewReview = document.getElementById(\"showNewReview\");
                            newReview = document.getElementById(\"newReview\");
                            flipBool = false;
                            showNewReview.onclick = () => {
                                newReview.classList.toggle(\"hidden\");
                                if(flipBool){ showNewReview.innerHTML = \"Write review\"; 
                                }else{ showNewReview.innerHTML = \"Close\"; }
                                flipBool = !flipBool;
                            }
                        </script>";

                    if(count($reviews) > 0){
                    foreach ($reviews as $review) {
                        echo 
                            "<div>" .
                            "<h3>" . $review["title"] . "</h3>" .
                            "<p>" . $review["review"] . "</p>";
                            if(isset($_SESSION["userID"])){
                                if($review["user_id"] == $_SESSION["userID"]){
                                echo 
                                    "<form action=\"./description.php\" method=\"POST\">
                                    <input type=\"submit\" name=\"editReview\" value=\"Edit review\">
                                    </form>";
                                }
                            }
                            
                        echo "</div>";
                    }
                    }else{
                        
                    }

                    

                    echo "</div>";


                }
            }
        }
    
    ?>
    </main>


<?php include("./include/footer.html") ?>

<script src="./main.js"></script>

</body>
</html>