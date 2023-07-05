
<!DOCTYPE html>
<html>
    <head>
        <title>Calquiz</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="global/style.css"/>
        <link rel="icon" type="image/x-icon" href="global/favicon.ico">
    </head>
    <body>
        <?php
            // include the configs for the database connection
            require_once("config/db.php");

            // load the login class
            require_once("classes/Login.php");

            // create a login object. when this object is created, it will do all login/logout stuff automatically
            $login = new Login();

            //show views depend on login status
            if ($login->isUserLoggedIn() == true) {
                // the user is logged in, show them user home view
                include("views/user_home.php");

            } else {
                // the user is not logged in, show them guest view
                include("views/guest.php");
            } 
            ?>
    </body>
</html>