<!DOCTYPE html>
<html>
    <head>
        <title>Create an account</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="global/style.css"/>
        <link rel="icon" type="image/x-icon" href="global/favicon.ico">
    </head>
    <body>
        <?php
        // include the navigatfion bar -> change nav once, applied everywhere
        include 'global/navbar.html';
        ?>
        <div class="content">
        <?php
            // include the configs / constants for the database connection
            require_once("config/db.php");

            // load the registration class
            require_once("classes/Registration.php");

            // create the registration object that will handle the entire registration process.
            $registration = new Registration();

            // show the register view (with the registration form, and messages/errors)
            include("views/register_form.php");
            ?>
        </div>
    </body>
</html>
