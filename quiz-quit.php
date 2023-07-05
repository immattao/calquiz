<?php
    // Get db info
    require_once("config/db.php");

    // Start session (just to get userID)
    session_start();

    // Create connection
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Grab quiz results from post
    $score = $_POST['score'];
    $length = $_POST['length'];

    if(!isUserLoggedIn()){
        return;
    }
    
    $currentUserID = $_SESSION['userID'];
    $date = date("Y-m-d H-i-s");

    // Insert new quiz result query
    $sql = "INSERT INTO quiz (userID, date_completed, quiz_score, quiz_length)
            VALUES('" . $currentUserID . "','" . $date . "', '" . $score . "', '" . $length . "');";
    $query_add_score = $conn->query($sql);
    if (!$query_add_score) {
        die("Insert failed!");
    }

    // Update total score query
    $sql = "UPDATE user
            SET total_score = (SELECT sum(quiz_score)
                               FROM quiz
                               WHERE userID = " . $_SESSION['userID'] .")
            WHERE userID = " . $_SESSION['userID'] . ";";
    $query_add_score = $conn->query($sql);
    if (!$query_add_score) {
        die("Insert failed!");
    }

    // CLose connection
    $conn->close();

    function isUserLoggedIn()
    {
        if (isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] == 1) {
            return true;
        }
        // default return
        return false;
    }
?>