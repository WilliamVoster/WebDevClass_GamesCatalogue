<?php

$server   = "localhost"; // essexweb something...something
$username = "root";
$password = "";
$database = "assignment2020";
$log = "";

$conn = new mysqli($server, $username, $password, $database);

if(!$conn){
    $log = $log . mysqli_connect_error();
    die();
}else{
    $log = $log . "connected";
}

$sql    = "SELECT id, title, image, genre, rating from games;";
$result = mysqli_query($conn, $sql);


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
</head>
<body id="body">

    <?php 
    //include!<>
    
    ?>

    <header>
        <nav>
            <ul>
                <li><a href="./index.php">Home</a></li>
                <li><a href="./bookmark.php">Bookmarks</a></li>
                <li><a href="./review">Write review</a></li>
                <li><a href="./about.php">About</a></li>
            </ul>
        </nav>

        
        <span>
            <ul>
            <?php

            if(!isset($_SESSION)){
                echo "<li><a href=\"./login.php\">Log in</a></li>";
                echo "<li><a href=\"./register.php\">Register</a></li>";
            }else{
                echo  "Welcome " . $_SESSION["username"] . "!";
            }
            
            ?>
            </ul>
        </span>
   
    
    </header>

    <main>
        <form id="filter" action="#" method="GET">
            <!-- <span class="icon"><i class="fa fa-search">icon</i></span> -->
            <img src="./media/search-icon.svg" alt="search icon">
            <input type="text" placeholder="Search" name="search">
            <input type="checkbox" id="inputCheck"><label for="inputCheck">check</label>
            <input type="radio" id="inputRadio"><label for="inputRadio">radio</label>
            <input type="submit" name="applyFilter" id="applyFilter" value="Search">
        </form>

        <div id="gallery">
            <ul>
                <?php
                if(mysqli_num_rows($result) > 0){
                    while($row = mysqli_fetch_assoc($result)){
    
                        echo 
                        "<li id =\"" . $row["id"] . "\">" .
                            "<a href=\"./games/" . "#" . "\">" . $row["title"] . "</a>" .
                            "<img src=\"" . $row["image"] . "\">" .
                        "</li>";
                    }
                }else{
                    $log = $log . "<br>0 results";
                }?>

                <!-- <li><a href="./#">a</a></li>
                <li><a href="./#">b</a></li>
                <li><a href="./#">c</a></li>
                <li><a href="./#">d</a></li>
                <li><a href="./#">e</a></li>
                <li><a href="./#">f</a></li>
                <li><a href="./#">g</a></li>
                <li><a href="./#">h</a></li>
                <li><a href="./#">i</a></li> -->
            </ul>

        </div>
    </main>
    
    
    
    <footer>
        <?php echo "--> " . $log;?>
        <ul>
            <li>Web development assignmet 2020</li>
            <li>University Of Essex CE154</li>
            <li>Thor William Voster</li>
            <li>github.com/WilliamVoster</li>
        </ul>
    </footer>

    <script src="./main.js"></script>
    
</body>
</html>

<?php mysqli_close($conn);?>



   

