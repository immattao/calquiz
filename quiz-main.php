<!DOCTYPE html>
<html>
    <head>
        <title>Start a quiz</title>
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
            else 
            {   
                include 'global/navbar.html';
                echo "Please log in to save your progress";
            }

        ?>
        <div class="content">
            <div id="score"></div>
            <div id="quiz"></div>
            <button id="next" type="button"><a href='#'>Next</a></button>
            <button id="quit" type="button" onclick=""><a href='#'>Quit</a></button>
            <button id="start" type="button"><a href='#'>Start</a></button>
        </div>
        <!--import jQuery-->
        <script type='text/javascript' src='https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js'></script>
        <script type='module' src="jsquiz.js"></script>
    </body>
</html>

