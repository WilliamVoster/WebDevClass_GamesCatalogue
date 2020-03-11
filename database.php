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


    $salt = generateSalt();
    $hash = sha1($data['password'] . $salt);
    $isAdmin = 0;

    // Provided by Joseph Walton-Rivers for ce154
    $stmt = $link->prepare("INSERT INTO users(uname, pass, salt, is_admin) values (?,?,?,?)");
    if ( !$stmt ) {die("could not prepare statement: " . $link->errno . ", error: " . $link->error);}
    
    $result = $stmt->bind_param("sssi", $data['username'], $hash, $salt, $isAdmin);
    if ( !$result ) {die("could not bind params: " . $stmt->error);}

    if ( !$stmt->execute() ) {die("couldn't execute statement");}

    //If no user exist with that username return true:
    return true;
}

function checkForUser($link, $data){

    $username = $data["username"];
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

    $username = $previousUser[0]["uname"];
    $hash = $previousUser[0]["pass"];
    $salt = $previousUser[0]["salt"];
    $password = $data["password"];

    if ($hash == sha1($password . $salt)){
        //echo "right password!";
        $_SESSION["username"] = $username;
        return true;
    }else{
        //echo "wrong password";
        return false;
        // echo "<br>|<br>";
        // echo var_dump($password);
        // echo "<br>|<br>";
        // echo var_dump($salt);
        // echo "<br>|<br>";
        // echo var_dump($hash);
        // echo "<br>|<br>";
        // echo var_dump(sha1($password . $salt));
    }
}

function filterGenerateSQL($search, $filterArr){

    if(is_array($filterArr) && isset($search)){
        return "wrong input";
    }
}
// echo filterGenerateSQL("test", array("test", "test"));

function filterSearch($link, $keyword){

    $query = "SELECT id, title, image, genre, rating from games where title like ?;";
    $param = "%$keyword%";

    $stmt = $link->prepare($query);
    if(!$stmt){ die("could not prepare statement: " . $link->errno . ", error: " . $link->error);}

    $stmt->bind_param("s", $param);
    if ( !$stmt->execute() ) {die("couldn't execute statement");}

    $results = $stmt->get_result();
    // $temp = $results->fetch_assoc();

    // return $returnArr = [];

    // if(mysqli_num_rows($temp) > 0){
        
    $returnArr = [];
    while ( $row = $results->fetch_assoc() ) {
        $returnArr[] = $row;
    }
    // while ( $row = $results->fetch_array(MYSQLI_NUM) ) {
    //     // foreach ($row as $r) {
    //     //     echo $r . "<br>";
    //     // }
    //     // echo var_dump($row);
    //     $returnArr[] = $row;
    // }
    // }

    return $returnArr;
    //return [];
}