<!DOCTYPE html>
<html>
    <head>
        <title>Calquiz - Homepage</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="global/style.css"/>
        <link rel="icon" type="image/x-icon" href="global/favicon.ico">
    </head>
    <body>
        <?php
                include 'global/navbar.html';
        ?>
        <div class="content">
            <?php
                // show potential errors / feedback (from login object)
                if (isset($login)) {
                    if ($login->errors) {
                        foreach ($login->errors as $error) {
                            echo $error;
                        }
                    }
                    if ($login->messages) {
                        foreach ($login->messages as $message) {
                            echo $message;
                        }
                    }
                }
            ?>
            <h2>Welcome back to calquiz!</h2>
            <form action="index.php" method="post"> 
                <label>Username : </label>  
                <input type="text" placeholder="Enter username" name="username" required>
                <br></br>
                <label>Password : </label> 
                <input type="password" placeholder="Enter Password" name="password"  autocomplete="off" required>
                <br></br>
                <button type="submit" name="login">Login</button> 
            </form> 
        </div>
        
    </body>
</html>
    