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
    <title><?php echo $_GET["game"];?></title>
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
                        }elseif($_POST["bookmark"] == "remove"){
                            $_SESSION["bookmark"][$id] = false;
                        }
                    }


                    echo "<div id=\"addToBookmark\">" .
                        "<form acrion=\"./description\" method=\"POST\">"; //GET removes the already present gameID = x;

                        if(isset($_SESSION["username"])){
                            if(isset($_SESSION["bookmark"]) and in_array($id, $_SESSION["bookmark"])){
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

                }
            }
        }
    
    ?>
    </main>


<?php include("./include/footer.html") ?>

<script src="./main.js"></script>

</body>
</html>