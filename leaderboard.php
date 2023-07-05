<!DOCTYPE html>
<html>

<head>
    <title>Leaderboard</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="global/style.css"/>
    <link rel="icon" type="image/x-icon" href="global/favicon.ico">
</head>

<body>

    <?php
        // include the configs for the database connection
        require_once("config/db.php");
        // include the navigation bar -> change nav once, applied everywhere
        session_start();
        if($_SESSION['user_login_status']==1)
        {
            include 'global/navbar_user.html';
        }
        else include 'global/navbar.html';
    ?>
    <div class="content">
        <table>
            <tr>
                <th>Rank</th>
                <th>Username</th>
                <th>Score</th>
            </tr>
            <?php
            // Create connection
            $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            // query to get users ranked by score
            $sql_leaderboard =
                "SELECT 
                    RANK() OVER (ORDER BY total_score DESC ) AS 'rank',
                    username,
                    total_score
                FROM user";
            $result = $conn->query($sql_leaderboard);
            if ($result->num_rows > 0) {
                // output data of each row
                while ($row = $result->fetch_assoc()) {
                    echo "<tr><td>" . $row["rank"] . "</td><td>" . $row["username"] . "</td><td>"
                        . $row["total_score"] . "</td></tr>";
                }
                echo "</table>";
            } else {
                echo "0 results";
            }
            $conn->close();
            ?>
        </table>
    </div>
</body>

</html>