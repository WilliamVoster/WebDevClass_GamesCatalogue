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
                                echo "<img src=\"./media/genre/" . $gameInfo["genre"] . ".png\">";
                            }
                        }
                    }else{
                        echo "<span class=\"subSpan\">No genre for this game</span>";
                    }


                }
            }
        }
    
    ?>
    </main>


<?php include("./include/footer.html") ?>

<script src="./main.js"></script>

</body>
</html>