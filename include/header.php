<!-- registration number: 1906423 -->
<header>
    <nav>
        <ul>
            <li><a href="./index.php">Home</a></li>
            <li><a href="./bookmarks.php">Bookmarks</a></li>
            <li><a href="./review">Write review</a></li>
        </ul>
    </nav>

    
    <span>
        <ul>
        <?php

        if(!isset($_SESSION["username"])){
            echo "<li><a href=\"./login.php\">Log in</a></li>";
            echo "<li><a href=\"./register.php\">Register</a></li>";
        }else{
            echo "<li>Welcome " . $_SESSION["username"] . "!</li>";
            echo "<li><a href=\"./logout.php\">Logout</a></li>";
        }
        
        ?>
        </ul>
    </span>

</header>