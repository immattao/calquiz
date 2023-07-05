<!DOCTYPE html>
<html>
    <head>
        <title>Your Calquiz Home</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="global/style.css"/>
        <link rel="icon" type="image/x-icon" href="global/favicon.ico">
    </head>
    <body>
         <!--Include navbar-->
        <?php
                include 'global/navbar_user.html';
        ?>    

        <!--Streak counting-->
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
            $sql = "WITH temp AS (
                SELECT 
                    DENSE_RANK() OVER (PARTITION BY quiz.userID ORDER BY date_completed) AS date_rank, 
                    date_completed, 
                    DATE_ADD(date_completed, INTERVAL -DENSE_RANK() OVER (PARTITION BY quiz.userID ORDER BY date_completed) day) AS date_series, 
                    userID
                FROM quiz
            )
            #create temporary table to where dates are grouped into series of consecutive dates
            
            SELECT
                COUNT(DISTINCT date_completed) AS streak_count, #count the number of dates in each series 
                date_series, #streak identifier (all dates in 1 streak has the same date_series due to math)
                MAX(date_completed) AS end_date #the end date of the date series/ streak
            FROM temp
            WHERE userID = ". $_SESSION['userID'] . "
            GROUP BY date_series
            ORDER BY date_series DESC 
            LIMIT 1; #take the latest streak
            ";

                $query_calculate_streak = $conn->query($sql);
                // get result row (as an object)
                $result_row = $query_calculate_streak->fetch_object();
                $curdate = date("Y-m-d");//current date
                if($result_row->end_date == $curdate){
                    // write user data into PHP SESSION (a file on the server)
                    $_SESSION['streak'] = $result_row->streak_count;
                }
                else $_SESSION['streak'] = "0";
                if (!$query_calculate_streak) {
                    die("Get streak failed!");
                }
            // CLose connection
            $conn->close();
        ?>   
        
        <div class="content">
                Hey, <?php echo $_SESSION['username']; ?>
                <br></br>
                You are on a  <?php echo $_SESSION['streak']; ?>-day streak! Keep it up ^-^
        </div>
    </body>
</html>





