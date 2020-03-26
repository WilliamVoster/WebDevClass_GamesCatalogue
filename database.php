<!-- registration number: 1906423 -->
<?php
// Provided by Joseph Walton-Rivers for ce154

/**
 * This script is used for connecting to databases
 */

// there are oo and procdural interfaces, we're using the OO interface.
// oh yeah... PHP supports classes.

// could use seperate variables here to.
$db = array();

// CHANGE THESE TO MATCH YOUR SETUP!
$db['host'] = "localhost";
$db['user'] = "root";
$db['pass'] = "";
$db['name'] = "assignment2020";

// $db['host'] = "cseemyweb.essex.ac.uk";
// $db['user'] = "tv19295";
// $db['pass'] = "6LXLZTzFqdKle";
// $db['name'] = "ce154_tv19295";

/**
 * Function to connect to the database
 */
function connect(){
    global $db;
    $link = new mysqli($db['host'], $db['user'], $db['pass'], $db['name']);
    if  ($link->connect_errno) {
        die("Failed to connect to MySQL: " . $link->connect_error);
    }

    return $link;
}
function get_messages($link) {
    $records = array();

    $results = $link->query("SELECT * FROM message");

    // didn't work? return no results
    if ( !$results ) {
        return records;
    }

    while ( $row = $results->fetch_assoc() ) {
        $records[] = $row;
    }
    
    return $records;
}
function save_message($link, $data) {
    // prepared statemenets = no sql injection \o/

    // first we create the statement
    $stmt = $link->prepare("insert into message(name, email, reason, message) values (?,?,?,?)");
    if ( !$stmt ) {
        die("could not prepare statement: " . $link->errno . ", error: " . $link->error);
    }

    // then we bind the parameters
    // s = string, i = integer
    $result = $stmt->bind_param("ssis", $data['name'], $data['email'], $data['reason'], $data['message']);
    if ( !$result ) {
        die("could not bind params: " . $stmt->error);
    }

    // finally, execute
    if ( !$stmt->execute() ) {
        die("couldn't execute statement");
    }

    // you can also alter data and call execute again to send another message...
}
function generateSalt(){
    $length = mt_rand(5, 10);
    $salt = "";

    foreach(range(0, $length-1) as $i){
        $salt .= chr(mt_rand(33, 126));
    }
    return $salt;
}
function register($link, $data){
    // echo var_dump($data['username']);

    //To check if there already exists a user with that username:
    $previousUser = checkForUser($link, $data);
    if (count($previousUser) > 0){ return false; }


    $password = htmlspecialchars($data["password"], ENT_QUOTES, 'UTF-8');
    $username = htmlspecialchars($data["username"], ENT_QUOTES, 'UTF-8');

    $salt = generateSalt();
    $hash = sha1($password . $salt);
    $isAdmin = 0;

    // Provided by Joseph Walton-Rivers for ce154
    $stmt = $link->prepare("INSERT INTO users(uname, pass, salt, is_admin) values (?,?,?,?)");
    if ( !$stmt ) {die("could not prepare statement: " . $link->errno . ", error: " . $link->error);}
    
    $result = $stmt->bind_param("sssi", $username, $hash, $salt, $isAdmin);
    if ( !$result ) {die("could not bind params: " . $stmt->error);}

    if ( !$stmt->execute() ) {die("couldn't execute statement");}

    //If no user exist with that username return true:
    return true;
}
function checkForUser($link, $data){

    $username = htmlspecialchars($data["username"], ENT_QUOTES, 'UTF-8');
    $records = array();

    $query = "SELECT id, uname, pass, salt, is_admin FROM users where uname = ?";

    $stmt = $link->prepare($query);
    if ( !$stmt ) {die("could not prepare statement: " . $link->errno . ", error: " . $link->error);}
 
    $stmt->bind_param("s", $username);
    if ( !$stmt->execute() ) {die("couldn't execute statement");}

    $results = $stmt->get_result();

    while ( $row = $results->fetch_assoc() ) {
        $records[] = $row;
    }

    return $records;
}
function login($link, $data){

    $previousUser = checkForUser($link, $data);
    if (count($previousUser) == 0){ return false; }
    // echo var_dump($previousUser);

    $username = $previousUser[0]["uname"];
    $hash = $previousUser[0]["pass"];
    $salt = $previousUser[0]["salt"];
    $password = htmlspecialchars($data["password"], ENT_QUOTES, 'UTF-8');
    $isAdmin = $previousUser[0]["is_admin"] == 1 ? true : false;

    if ($hash == sha1($password . $salt)){
        //echo "right password!";
        $_SESSION["username"] = $username;
        $_SESSION["userID"] = $previousUser[0]["id"];
        if($isAdmin){$_SESSION["isAdmin"] = $isAdmin;}
        return true;
    }else{
        //echo "wrong password";
        return false;
    }
}
function filterGenreRating($link, $genre, $rating){
    $genre = htmlspecialchars($genre, ENT_QUOTES, 'UTF-8');
    $rating = htmlspecialchars($rating, ENT_QUOTES, 'UTF-8');

    $genreBool = false;
    $ratingBool = false;
    if(isset($genre)){ if($genre != ""){ $genreBool = true; } }
    if(isset($rating)){ if($rating == "on"){ $ratingBool = true; }  }

    if(!$genreBool and !$ratingBool){return [];}

    $query = "SELECT id, title, image, genre, rating, description from games where ";

    if($genreBool){ $query .= "genre = ?"; }

    if($genreBool and $ratingBool){ $query .= " and "; }

    if($ratingBool){ $query .= "rating > 80"; }
    

    $returnArr = [];
    $param = "$genre";

    $stmt = $link->prepare($query);
    if(!$stmt){ die("could not prepare statement: " . $link->errno . ", error: " . $link->error);}

    if($genreBool){ $stmt->bind_param("s", $param); }

    if ( !$stmt->execute() ) {die("couldn't execute statement");}

    $results = $stmt->get_result();
        
    while ( $row = $results->fetch_assoc() ) {
        $returnArr[] = $row;
    }

    return $returnArr;

}
function filterSearch($link, $keyword){
    $keyword = htmlspecialchars($keyword, ENT_QUOTES, 'UTF-8');

    $returnArr = [];
    if($keyword == ""){
        echo "No search keyword<br>";
        return $returnArr;
    }

    $query = "SELECT id, title, image, genre, rating, description from games where title like ?;";
    $param = "%$keyword%";

    $stmt = $link->prepare($query);
    if(!$stmt){ die("could not prepare statement: " . $link->errno . ", error: " . $link->error);}

    $stmt->bind_param("s", $param);
    if ( !$stmt->execute() ) {die("couldn't execute statement");}

    $results = $stmt->get_result();
        
    while ( $row = $results->fetch_assoc() ) {
        $returnArr[] = $row;
    }

    return $returnArr;
}
function addBookmark($link, $userID, $gameID){
    $userID = htmlspecialchars($userID, ENT_QUOTES, 'UTF-8');
    $gameID = htmlspecialchars($gameID, ENT_QUOTES, 'UTF-8');

    $query = "INSERT into bookmarks (user_id, game_id) VALUES (?, ?);";

    $stmt = $link->prepare($query);

    if ( !$stmt ) { die("could not prepare statement: " . $link->errno . ", error: " . $link->error); } 

    $result = $stmt->bind_param("ii", $userID, $gameID);

    if ( !$result ) { die("could not bind params: " . $stmt->error); }
 
    if ( !$stmt->execute() ) { die("couldn't execute statement"); }

}
function removeBookmark($link, $userID, $gameID){
    $userID = htmlspecialchars($userID, ENT_QUOTES, 'UTF-8');
    $gameID = htmlspecialchars($gameID, ENT_QUOTES, 'UTF-8');

    $query = "DELETE FROM bookmarks where user_id = ? and game_id = ?";

    $stmt = $link->prepare($query);

    if ( !$stmt ) { die("could not prepare statement: " . $link->errno . ", error: " . $link->error); } 

    $result = $stmt->bind_param("ii", $userID, $gameID);

    if ( !$result ) { die("could not bind params: " . $stmt->error); }
 
    if ( !$stmt->execute() ) { die("couldn't execute statement"); }

}
function getBookmarks($conn){
    if(!isset($_SESSION["userID"])){return;}

    $sql    = "SELECT id, title FROM games;";
    $result = mysqli_query($conn, $sql);

    $bookmarkSql    = "SELECT user_id, game_id FROM bookmarks;";
    $bookmarkResult = mysqli_query($conn, $bookmarkSql);

    $_SESSION["bookmark"] = [];
    foreach ($result as $id) {
        $_SESSION["bookmark"][$id["id"]] = false;
    }
    foreach ($bookmarkResult as $pair) {
        if($pair["user_id"] == $_SESSION["userID"]){
            $_SESSION["bookmark"][$pair["game_id"]] = true;
        }
    }
}
function getReviews($conn){

    $query = "SELECT reviews.id, user_id, game_id, rating, title, review, users.uname from reviews, users where reviews.user_id = users.id;";

    $result = mysqli_query($conn, $query);

    $returnArr = [];

    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)){

            $returnArr[] = $row;
        }
    }
    return $returnArr;
}
function createReview($conn, $title, $body, $rating, $gameID){
    if(!isset($_SESSION["userID"])){ return false;}
    $userID = htmlspecialchars($_SESSION["userID"], ENT_QUOTES, 'UTF-8');
    $gameID = htmlspecialchars($gameID, ENT_QUOTES, 'UTF-8');
    $rating = htmlspecialchars($rating, ENT_QUOTES, 'UTF-8');
    $title = htmlspecialchars($title, ENT_QUOTES, 'UTF-8');
    $body = htmlspecialchars($body, ENT_QUOTES, 'UTF-8');

    $query = "INSERT INTO reviews (user_id, game_id, rating, title, review) VALUES (?, ?, ?, ?, ?);";

    $stmt = $conn->prepare($query);

    if ( !$stmt ) { die("could not prepare statement: " . $link->errno . ", error: " . $link->error); } 

    $result = $stmt->bind_param("iiiss", $_SESSION["userID"], $gameID, $rating, $title, $body);

    if ( !$result ) { die("could not bind params: " . $stmt->error); }
 
    if ( !$stmt->execute() ) { die("couldn't execute statement"); }

}
function deleteReview($conn, $reviewID){
    if(!isset($_SESSION["userID"])){ return false;}
    $reviewID = htmlspecialchars($reviewID, ENT_QUOTES, 'UTF-8');

    $query = "DELETE FROM reviews WHERE id = ?";

    $stmt = $conn->prepare($query);

    if ( !$stmt ) { die("could not prepare statement: " . $link->errno . ", error: " . $link->error); } 

    $result = $stmt->bind_param("i", $reviewID, );

    if ( !$result ) { die("could not bind params: " . $stmt->error); }
 
    if ( !$stmt->execute() ) { die("couldn't execute statement"); }
}
function hasReview($conn, $userID, $gameID){
    if(!isset($userID) || !isset($gameID)){ return false;}
    $userID = htmlspecialchars($userID, ENT_QUOTES, 'UTF-8');
    $gameID = htmlspecialchars($gameID, ENT_QUOTES, 'UTF-8');

    $query = "SELECT user_id, game_id FROM reviews";
    $result = mysqli_query($conn, $query);

    $returnArr = [];
    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)){
            array_push($returnArr, [$row["user_id"], $row["game_id"]]);
        }
    }

    foreach ($returnArr as $pair) {
        if($pair[0] == $userID && $pair[1] == $gameID){
            return true;
        }
    }
    // return in_array($userID, $returnArr);
    // echo var_dump($returnArr);
    return false;
        
}
function addGame($conn, $title, $image, $genre, $rating, $description){
    if(!isset($_SESSION["userID"]) || !isset($_SESSION["isAdmin"])){ return false;}
    $title = htmlspecialchars($title, ENT_QUOTES, 'UTF-8');
    $image = htmlspecialchars($image, ENT_QUOTES, 'UTF-8');
    $genre = htmlspecialchars($genre, ENT_QUOTES, 'UTF-8');
    $rating = htmlspecialchars($rating, ENT_QUOTES, 'UTF-8');
    $description = htmlspecialchars($description, ENT_QUOTES, 'UTF-8');

    $query = "INSERT INTO games (title, image, genre, rating, description) VALUES (?, ?, ?, ?, ?);";
    
    $stmt = $conn->prepare($query);

    if ( !$stmt ) { die("could not prepare statement: " . $link->errno . ", error: " . $link->error); } 

    $result = $stmt->bind_param("sssis", $title, $image, $genre, $rating, $description);

    if ( !$result ) { die("could not bind params: " . $stmt->error); }
 
    if ( !$stmt->execute() ) { die("couldn't execute statement"); }

}
function removeGame($conn, $gameID){
    if(!isset($_SESSION["userID"]) || !isset($_SESSION["isAdmin"])){ return false;}

    $query = "DELETE FROM games where id = ?";
    
    $stmt = $conn->prepare($query);

    if ( !$stmt ) { die("could not prepare statement: " . $link->errno . ", error: " . $link->error); } 

    $result = $stmt->bind_param("i", $gameID);

    if ( !$result ) { die("could not bind params: " . $stmt->error); }
 
    if ( !$stmt->execute() ) { die("couldn't execute statement"); }


    //clear reviews
    $query = "DELETE FROM reviews where game_id = ?";
    
    $stmt = $conn->prepare($query);

    if ( !$stmt ) { die("could not prepare statement: " . $link->errno . ", error: " . $link->error); } 

    $result = $stmt->bind_param("i", $gameID);

    if ( !$result ) { die("could not bind params: " . $stmt->error); }
 
    if ( !$stmt->execute() ) { die("couldn't execute statement"); }


    //clear bookmarks
    $query = "DELETE FROM bookmarks where game_id = ?";
    
    $stmt = $conn->prepare($query);

    if ( !$stmt ) { die("could not prepare statement: " . $link->errno . ", error: " . $link->error); } 

    $result = $stmt->bind_param("i", $gameID);

    if ( !$result ) { die("could not bind params: " . $stmt->error); }
 
    if ( !$stmt->execute() ) { die("couldn't execute statement"); }


}